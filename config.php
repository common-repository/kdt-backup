<?php
    global $wpdb;
    if (WPLANG == '') {
        define('BCP_WPLANG', 'en_GB');
    } else {
        define('BCP_WPLANG', WPLANG);
    }
    if(!defined('DS')) define('DS', DIRECTORY_SEPARATOR);

    define('BCP_PLUG_NAME', basename(dirname(__FILE__)));
    define('BCP_DIR', WP_PLUGIN_DIR. DS. BCP_PLUG_NAME. DS);
    define('BCP_TPL_DIR', BCP_DIR. 'tpl'. DS);
    define('BCP_CLASSES_DIR', BCP_DIR. 'classes'. DS);
    define('BCP_TABLES_DIR', BCP_CLASSES_DIR. 'tables'. DS);
	define('BCP_HELPERS_DIR', BCP_CLASSES_DIR. 'helpers'. DS);
    define('BCP_LANG_DIR', BCP_DIR. 'lang'. DS);
    define('BCP_IMG_DIR', BCP_DIR. 'img'. DS);
    define('BCP_TEMPLATES_DIR', BCP_DIR. 'templates'. DS);
    define('BCP_MODULES_DIR', BCP_DIR. 'modules'. DS);
    define('BCP_FILES_DIR', BCP_DIR. 'files'. DS);
    define('BCP_ADMIN_DIR', ABSPATH. 'wp-admin'. DS);
    
    define('BCP_SITE_URL', get_bloginfo('wpurl'). '/');
    define('BCP_JS_PATH', WP_PLUGIN_URL.'/'.basename(dirname(__FILE__)).'/js/');
    define('BCP_CSS_PATH', WP_PLUGIN_URL.'/'.basename(dirname(__FILE__)).'/css/');
    define('BCP_IMG_PATH', WP_PLUGIN_URL.'/'.basename(dirname(__FILE__)).'/img/');
    define('BCP_MODULES_PATH', WP_PLUGIN_URL.'/'.basename(dirname(__FILE__)).'/modules/');
    define('BCP_TEMPLATES_PATH', WP_PLUGIN_URL.'/'.basename(dirname(__FILE__)).'/templates/');
    define('S_IMG_POSTS_PATH', BCP_IMG_PATH. 'posts/');
    define('BCP_JS_DIR', BCP_DIR. 'js/');

    define('BCP_URL', BCP_SITE_URL);

    define('BCP_LOADER_IMG', BCP_IMG_PATH. 'loading-cube.gif');
	define('BCP_TIME_FORMAT', 'H:i:s');
    define('BCP_DATE_DL', '/');
    define('BCP_DATE_FORMAT', 'm/d/Y');
    define('BCP_DATE_FORMAT_HIS', 'm/d/Y ('. BCP_TIME_FORMAT. ')');
    define('BCP_DATE_FORMAT_JS', 'mm/dd/yy');
    define('BCP_DATE_FORMAT_CONVERT', '%m/%d/%Y');
    define('BCP_WPDB_PREF', $wpdb->prefix);
    define('BCP_DB_PREF', 'bcp_');
    define('BCP_MAIN_FILE', 'bcp.php');

    define('BCP_DEFAULT', 'default');
    define('BCP_CURRENT', 'current');
    
    
    define('BCP_PLUGIN_INSTALLED', true);
    define('BCP_VERSION', '0.1');
    define('BCP_USER', 'user');
    
    
    define('BCP_CLASS_PREFIX', 'bcpc');        
    define('BCP_FREE_VERSION', false);
    
    define('BCP_API_UPDATE_URL', 'http://somereadyapiupdatedomain.com');
    
    define('BCP_SUCCESS', 'Success');
    define('BCP_FAILED', 'Failed');
    define("BCP_LNG_CODE","bcp");
	define('BCP_ERRORS', 'bcpErrors');
	
	define('BCP_THEME_MODULES', 'theme_modules');
	
	
	define('BCP_ADMIN',	'admin');
	define('BCP_LOGGED','logged');
	define('BCP_GUEST',	'guest');
	
	define('BCP_ALL',		'all');
	
	define('BCP_METHODS',		'methods');
	define('BCP_USERLEVELS',	'userlevels');
	/**
	 * Framework instance code, unused for now
	 */
	define('BCP_CODE', 'bcp');
	/**
	 * Plugin name
	 */
	define('BCP_WP_PLUGIN_NAME', 'Backup Plugin');
        