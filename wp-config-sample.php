<?php
/**
 * La configuration de base de votre installation WordPress.
 *
 * Ce fichier contient les réglages de configuration suivants : réglages MySQL,
 * préfixe de table, clés secrètes, langue utilisée, et ABSPATH.
 * Vous pouvez en savoir plus à leur sujet en allant sur
 * {@link http://codex.wordpress.org/fr:Modifier_wp-config.php Modifier
 * wp-config.php}. C’est votre hébergeur qui doit vous donner vos
 * codes MySQL.
 *
 * Ce fichier est utilisé par le script de création de wp-config.php pendant
 * le processus d’installation. Vous n’avez pas à utiliser le site web, vous
 * pouvez simplement renommer ce fichier en "wp-config.php" et remplir les
 * valeurs.
 *
 * @package WordPress
 */

// ** Réglages MySQL - Votre hébergeur doit vous fournir ces informations. ** //
/** Nom de la base de données de WordPress. */
define('DB_NAME', 'votre_nom_de_bdd');

/** Utilisateur de la base de données MySQL. */
define('DB_USER', 'votre_utilisateur_de_bdd');

/** Mot de passe de la base de données MySQL. */
define('DB_PASSWORD', 'votre_mdp_de_bdd');

/** Adresse de l’hébergement MySQL. */
define('DB_HOST', 'localhost');

/** Jeu de caractères à utiliser par la base de données lors de la création des tables. */
define('DB_CHARSET', 'utf8');

/** Type de collation de la base de données.
  * N’y touchez que si vous savez ce que vous faites.
  */
define('DB_COLLATE', '');

/**#@+
 * Clés uniques d’authentification et salage.
 *
 * Remplacez les valeurs par défaut par des phrases uniques !
 * Vous pouvez générer des phrases aléatoires en utilisant
 * {@link https://api.wordpress.org/secret-key/1.1/salt/ le service de clefs secrètes de WordPress.org}.
 * Vous pouvez modifier ces phrases à n’importe quel moment, afin d’invalider tous les cookies existants.
 * Cela forcera également tous les utilisateurs à se reconnecter.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'put your unique phrase here');
define('SECURE_AUTH_KEY',  'put your unique phrase here');
define('LOGGED_IN_KEY',    'put your unique phrase here');
define('NONCE_KEY',        'put your unique phrase here');
define('AUTH_SALT',        'put your unique phrase here');
define('SECURE_AUTH_SALT', 'put your unique phrase here');
define('LOGGED_IN_SALT',   'put your unique phrase here');
define('NONCE_SALT',       'put your unique phrase here');
/**#@-*/

/**
 * Préfixe de base de données pour les tables de WordPress.
 *
 * Vous pouvez installer plusieurs WordPress sur une seule base de données
 * si vous leur donnez chacune un préfixe unique.
 * N’utilisez que des chiffres, des lettres non-accentuées, et des caractères soulignés !
 */
$table_prefix = 'wp_';

define( 'WP_CONTENT_URL','http://localhost/.../content');
define( 'WP_CONTENT_DIR', dirname( ABSPATH ) . '/content' );

/**
 * Pour les développeurs : le mode déboguage de WordPress.
 *
 * En passant la valeur suivante à "true", vous activez l’affichage des
 * notifications d’erreurs pendant vos essais.
 * Il est fortemment recommandé que les développeurs d’extensions et
 * de thèmes se servent de WP_DEBUG dans leur environnement de
 * développement.
 *
 * Pour plus d’information sur les autres constantes qui peuvent être utilisées
 * pour le déboguage, rendez-vous sur le Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
 /*
 Sachant que WordPress ne nous permet pas de gérer l'environnement dans lequel est executé notre WordPress, nous mettons la fonctionnalités en palce nous-même en créant une constante qui n'est comprise que pas notre code.
 */
  // define('ENVIRONMENT', 'development');
  //  define('ENVIRONMENT', 'staging');
   define('ENVIRONMENT', 'production');
  /**
   *  Additionnal configuration constants
   * 
   *  @link https://wordpress.org/support/article/editing-wp-config-php
   */
if ( defined( 'ENVIRONMENT' ) ) { // Je vérifie que la constante ENVIRONMENT existe
    if ( ENVIRONMENT === 'development' ) {
        define( 'WP_DEBUG', true );
        define( 'WP_DEBUG_DISPLAY', true ); // Affichage des erreurs PHP/WordPress directement dans le code HTML
        define( 'WP_DEBUG_LOG', false  ); // Enregistrement des erreurs PHP/WordPress dans un fichier de logs
        define('DISALLOW_FILE_MODS', false );
        define( 'FS_METHOD', 'direct' );  // J'indique à WordPress qu'il doit directement télécharger & mettre à jour les fichiers
        define( 'WP_POST_REVISIONS', false ); // A false je désactive les révisions des contenus
        define( 'SCRIPT_DEBUG', true ); // Activation du débug de WordPress pour les CSS & JS
        define( 'EMPTY_TRASH_DAYS', 0 ); // Désactivation de la corbeille
      } elseif ( ENVIRONMENT === 'staging') {
        define( 'WP_DEBUG', true );
        define( 'WP_DEBUG_DISPLAY', false ); // Affichage des erreurs PHP/WordPress directement dans le code HTML
        define( 'WP_DEBUG_LOG', true  ); // Enregistrement des erreurs PHP/WordPress dans un fichier de logs
        define( 'DISALLOW_FILE_MODS', true); // Désactivation de l'installation de plugins & de thèmes
        define( 'WP_POST_REVISIONS', 10 ); // A false je désactive les révisions des contenus
        define( 'SCRIPT_DEBUG', false ); // Activation du débug de WordPress pour les CSS & JS
        define( 'EMPTY_TRASH_DAYS', 60 ); // Désactivation de la corbeille
    } elseif ( ENVIRONMENT === 'production') {
      define( 'WP_DEBUG', false );
      define( 'WP_DEBUG_DISPLAY', false ); // Affichage des erreurs PHP/WordPress directement dans le code HTML
      define( 'WP_DEBUG_LOG', true  ); // Enregistrement des erreurs PHP/WordPress dans un fichier de logs
      define( 'DISALLOW_FILE_MODS', true); // Désactivation de l'installation de plugins & de thèmes
      define( 'WP_POST_REVISIONS', 10 ); // A false je désactive les révisions des contenus
      define( 'SCRIPT_DEBUG', false ); // Activation du débug de WordPress pour les CSS & JS
      define( 'EMPTY_TRASH_DAYS', 60 ); // Désactivation de la corbeille
    } else {
        echo 'La valeur de la constante ENVIRONMENT n\'est pas valide. Les valeurs possibles sont development, staging ou production.' ;
        exit;
    }
} else {
  echo 'La constante ENVIRONMENTn\'est pas définie.';
  exit;
}

// Désactivation de l'éditeur embarqué  de thèmes et pluggins !!
define( 'DISALLOW_FILE_EDIT', true );
define( 'AUTOMATIC_UPDATER_DISABLED', true ); // Désactivation des mise àjour automatiquesde WordPress
define( 'WP_AUTO_UPDATE_CORE', false ); // Désactivation des mise à jour du coeur de WordPress


/* C’est tout, ne touchez pas à ce qui suit ! Bonne publication. */

/** Chemin absolu vers le dossier de WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Réglage des variables de WordPress et de ses fichiers inclus. */
require_once(ABSPATH . 'wp-settings.php');
