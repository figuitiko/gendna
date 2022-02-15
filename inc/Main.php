<?php 


namespace Gendna;

use Gendna\Scripts;



class Main{
    private static $instance = null;

    private function __construct()
    {
        $this->defineConstants();
        // $this->includeFiles();
        $this->register();
    }

    public static function getInstance()
    {
        if ( self::$instance == null )
        {
            self::$instance = new Main();
        }

        return self::$instance;
    }

    private function defineConstants()
    {
        $active_theme = wp_get_theme();
        define( 'WP_HOME', 'https://'.$_SERVER['HTTP_HOST'] );
        define( 'WP_SITEURL', 'https://'.$_SERVER['HTTP_HOST'] );
        define( 'THEME_NAME', $active_theme->get( 'Name' ) );
        define( 'THEME_VERSION', $active_theme->get( 'Version' ) );
        define( 'GN_THEME_LOCAL_MODE', true );
        define( 'GN_STYLE_DIR', get_stylesheet_uri() );
        define( 'GN_THEME_DIR', get_template_directory() );
        define( 'GN_THEME_URL', get_template_directory_uri() );
        define( 'GN_THEME_CSS_URL', GN_THEME_URL.'/assets/css' );
        define( 'GN_THEME_JS_URL', GN_THEME_URL.'/assets/js' );
        define( 'GN_THEME_IMG_URL', GN_THEME_URL.'/assets/img' );
        define( 'GN_THEME_FONTS_DIR', GN_THEME_URL.'/assets/css/fonts' );
        define( 'GN_THEME_BOOTSTRAP_DIR', GN_THEME_URL.'/assets/bootstrap');      
        define( 'GN_THEME_ICONS_DIR', GN_THEME_URL.'/assets/icons');      
        define( 'GN_THEME_RS_PLUGIN', GN_THEME_URL.'/assets/rs-plugin');      
    }
    private function register(){
        $scripts = new Scripts();
    }
}