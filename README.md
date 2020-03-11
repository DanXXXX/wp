Installation
Il existe de nombreuses manière d'installer WordPress

De la plus simple, en téléchargement un fichier zip et en suivant les différentes étapes jusqu'à la plus complète en créant un script shell s'appuyant sur wp-cli.

Pré-requis
Quelle que soit la méthode choisie, il existe un certain nombre de pré-requis pour profiter au mieux d'une installation de WordPress.

Environnement
apache (avec le mod rewrite)
PHP > 5.4 (avec la librairie gd)
MySQL
Droits de fichiers
Afin de gérer au mieux une installation de WordPress il est bon de faire un petit recap des problématiques associées aux permissions et droits de fichiers.

Droits et utilisateurs
Détails
chmod : Change le droits
Détails
chown : Change l'utilisateur et le groupe
Détails
Droits et WordPress
Détails
Différentes méthodes
Installation guidée
En passant par le célèbre assistant d'installation de WordPress (installation en 5 minutes)

Quelques écrans s'enchainent, quelques champs à renseigner et hop !

Détails
Installation via composer
composer est le gestionnaire de dépendance de PHP. Le concept est de considérer WordPress lui-meme comme une dépendance du projet.

composer offre une grande flexibilité et possède un atout majeur : la gestion des thèmes et plugins également comme des dépendances du projet 👌

Détails
Nouvelle structure
Beaucoup de raisons visent à modifier la structure de WordPress pour donner au coeur de WordPress sont propre dossier, en voici quelques unes :

Isoler wp-config.php fichier très sensible
Grandement faciliter le partage de projet via git
Détacher le dossier wp-content du reste de WordPress
Faciliter les mises à jour
Utiliser des outils comme composer pour la gestion de dépendances
...
Cette restructuration est complètement supportée par WordPress qui explique même tout le fonctionnement dans cet article dédié : Donner à WordPress son propre répertoire.

Arborescence
Le principe suite à la restructuration est d'obtenir une arborescence comme celle ci

+ mon-projet
|  + .git
|  + wp
|  |  + wp-admin
|  |  + wp-includes
|  |  - wp-blog-header.php
|  |  - wp-settings.php
|  |  - ...
|  + content
|  |  + themes
|  |  + plugins
|  |  + uploads
|  |  - ...
|  - .gitignore
|  - .htaccess
|  - index.php
|  - wp-config.php
Cette structure va permettre d'efficacement utiliser composer pour rapatrier WordPress dans un dossier indépendant.

Étape par étape
Étape 1 : Déplacement / Copie
Créer un sous-dossier wp -> tout placer dedans
Copier index.php à la racine
Déplacer le fichier wp-config.php à la racine
Déplacer le dossier wp-content à la racine et le renommé content
Étape 2 : Modifier index.php
Il est impératif de dire à index.php où trouver le fichier de démarrage wp-blog-header.php

Il suffit de modifier :

require( dirname( __FILE__ ) . '/wp-blog-header.php' );
vers

require( dirname( __FILE__ ) . '/wp/wp-blog-header.php' );
Étape 3 : Modifier le chargement de wp-content
Dans le fichier wp-config.php, il suffit d'ajouter ces 2 constantes en précisant pour WP_CONTENT_URL l'url du projet + /content

define( 'WP_CONTENT_URL', 'http://monurl.local/content' );
define( 'WP_CONTENT_DIR', dirname( ABSPATH ) . '/content' );
Étape 4 : Droits de fichiers
À la racine du dossier mon-projet-wordpress

<mon-utilisateur> : L'utilisateur du système, sur le téléporteur il s'agit de mint

sudo chown -R <user>:www-data content/
sudo find . -type f -exec chmod 664 {} +
sudo find . -type d -exec chmod 775 {} +
Afin de modifier les droits du dossier content/

Étape 5 : Installer WordPress
Installer WordPress normalement mais à partir de l'adresse http://localhost/mon-projet/wp/wp-admin

Étape 6 : Permaliens et URL
Activation des permaliens au format /%postname%/

Dans Réglages > Général > URL de la home : Retirer le /wp

Étape 7 : Ajouter un fichier .htaccess adapté
à la racine du projet ajouter un fichier .htaccess avec ce code

RewriteEngine on
RewriteCond %{REQUEST_URI} !^wp/
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php/$1
En savoir plus
Plusieurs articles abordent WordPress et Composer avec cette nouvelle structure :

Rarst.net
Roots.io
Gilbert Pellegrom - WordPress+Git+Composer
packagist.org à la rescousse
Sur packagist.org, johnpbloch/wordpress est un repo perpétuellement mit à jour avec les dernières sources de wordpress.org.

Il est possible de s'appuyer sur ce repo pour installer WordPress au sein d'un projet.

{
  "require": {
    "php": ">=5.4",
    "johnpbloch/wordpress": "4.*"
  },
  "extra": {
    "wordpress-install-dir": "wp"
  }
}
Cette configuration permet de récupérer WordPress dans un sous dossier wp/

composer, plugins et thèmes
wpackagist, un repo de packages associés à WordPress. Les thèmes et plugins peuvent être définis dans la config de composer afin de les installer rapidement via composer install.

{
  "repositories": [
    {
      "type": "composer",
      "url": "https://wpackagist.org"
    }
  ],
  "require": {
    "php": ">=5.4",
    "johnpbloch/wordpress": "4.*",
    "wpackagist-plugin/advanced-custom-fields": "*",
    "wpackagist-plugin/contact-form-7": "*",
    "wpackagist-theme/hueman":"*",
    "wpackagist-theme/twentyseventeen":"*",
    "wpackagist-theme/bento":"*"
  },
  "extra": {
    "wordpress-install-dir": "wp",
    "installer-paths": {
        "content/plugins/{$name}/": ["type:wordpress-plugin"],
        "content/themes/{$name}/": ["type:wordpress-theme"]
    }
  }
}
Installation via wp-cli
Une installation de WordPress via la ligne de commande en passant par l'utilitaire wp-cli.

Configuration avancée, agir en direct sur le comportement de l'installation, installer des composants annexes ne sont que quelques atouts de cette méthode.

✋Attention Il est impératif d'avoir wp-cli d'installer et configurer avant de se lancer. Cette méthode nécessite également d'être très à l'aise avec la ligne de commande !

Détails
Téléchargement de WordPress
wp core download --locale=fr_FR

Création du fichier de configuration
wp config create --dbname="nom_de_la_base" --dbuser="user_de_la_base" --dbpass="pass_de_la_base" --locale=fr_FR --skip-check --extra-php <<PHP define('WP_DEBUG', true); PHP

Création de la base de données
wp db create

Installation
wp core install --url="http://url/projet" --title="Titre du site" --admin_user="login administrateur" --admin_password="pass administrateur" --admin_email="email administrateur" --skip-email

Modifications de différentes options
Changement de l'url de WordPress

wp option update siteurl $(wp option get siteurl)/$core_dir

Refuser l'indexation

wp option update blog_public 0

Limiter à 5 posts par page (au lieu de 10 par défaut)

wp option update posts_per_page 5
