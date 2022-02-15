<?php

namespace Gendna;

class Scripts
{

    private $cssPath = '';
    private  $fontPath = '';
    private  $jsPath = '';
    private $bootstrapPath = '';
    private $iconsDir = '';
    private $rsPlugin = '';

    public function __construct()
    {


        $this->cssPath = GN_THEME_CSS_URL;
        $this->fontPath = GN_THEME_FONTS_DIR;
        $this->jsPath = GN_THEME_JS_URL;
        $this->bootstrapPath = GN_THEME_BOOTSTRAP_DIR;
        $this->iconsDir = GN_THEME_ICONS_DIR;
        $this->rsPlugin = GN_THEME_RS_PLUGIN;

        add_action('wp_enqueue_scripts', array($this, 'addFrontEndAssets'));
    }

    /**
     * Register and enqueue styles
     * @param array $styles
     * @return void
     */
    private  function addStyles($styles)
    {
        foreach ($styles as $handle => $args) {
            if ($args === true) {
                wp_enqueue_style($handle);
            } elseif (is_array($args)) {
                wp_register_style(
                    $handle,
                    $args['src'],
                    isset($args['deps']) ? $args['deps'] : array(),
                    isset($args['ver']) ? $args['ver'] : THEME_VERSION,
                    isset($args['media']) ? $args['ver'] : 'all'
                );

                if (!isset($args['enqueue']) || (isset($args['enqueue']) && $args['enqueue'] === true)) {
                    wp_enqueue_style($handle);
                }
            }
        }
    }


    /**
     * Register and enqueue scripts
     * @param array $scripts
     * @return void
     */
    private function addScripts($scripts)
    {
        foreach ($scripts as $handle => $args) {
            if ($args === true) {
                wp_enqueue_script($handle);
            } elseif (is_array($scripts)) {
                wp_register_script(
                    $handle,
                    $args['src'],
                    isset($args['deps']) ? $args['deps'] : array(),
                    isset($args['ver']) ? $args['ver'] : THEME_VERSION,
                    isset($args['in_footer']) ? $args['in_footer'] : true
                );

                if (!isset($args['enqueue']) || (isset($args['enqueue']) && $args['enqueue'] === true)) {
                    wp_enqueue_script($handle);
                }

                if (isset($args['localize']) && is_array($args['localize']) && !empty($args['localize'])) {
                    wp_localize_script(
                        $handle,
                        str_replace('-', '_', $handle) . '_params',
                        $args['localize']
                    );
                }

                if (isset($args['data']) && is_array($args['data']) && !empty($args['data'])) {
                    $data_args = $args['data'];

                    if (isset($data_args['key']) && isset($data_args['value'])) {
                        wp_script_add_data(
                            $handle,
                            $data_args['key'],
                            $data_args['value']
                        );
                    }
                }
            }
        }
    }

    public function addFrontEndAssets()
    {

        $this->addStyles($this->addFrontEndStyles());
        $this->addScripts($this->addFrontEndScripts());
    }
    public function addFrontEndStyles()
    {
        $styles['main-style'] = [
            'src' => GN_STYLE_DIR,
            'ver' => THEME_VERSION
        ];
        $styles['bootstrap'] = [
            'src' => $this->cssPath . '/bootstrap.min.css',
            'deps' => array(),
            'ver' => THEME_VERSION
        ];
        $styles['livvic'] = [
            'src' => 'https://fonts.googleapis.com/css2?family=Livvic:ital,wght@0,300;0,400;0,500;0,600;0,700;0,900;1,300;1,400;1,500;1,600;1,700;1,900&display=swap',
            'deps' => array(),
            'ver' => THEME_VERSION
        ];
        $styles['Barlow'] = [
            'src' => 'https://fonts.googleapis.com/css2?family=Barlow+Condensed:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap',
            'deps' => array(),
            'ver' => THEME_VERSION
        ];
        $styles['animate'] = [
            'src' => $this->cssPath . '/animate.css',
            'deps' => array(),
            'ver' => THEME_VERSION
        ];
        
        $styles['line-awesome'] = [
            'src' => $this->cssPath . '/line-awesome.min.css',
            'deps' => array(),
            'ver' => THEME_VERSION
        ];
        $styles['magnific-popup'] = [
            'src' => $this->cssPath . '/magnific-popup.css',
            'deps' => array(),
            'ver' => THEME_VERSION
        ];
        $styles['owl-carousel'] = [
            'src' => $this->cssPath . '/owl.carousel.css"',
            'deps' => array(),
            'ver' => THEME_VERSION
        ];
        $styles['lightslider'] = [
            'src' => $this->cssPath . '/lightslider.min.css',
            'deps' => array(),
            'ver' => THEME_VERSION
        ];
        $styles['base'] = [
            'src' => $this->cssPath . '/base.css',
            'deps' => array(),
            'ver' => THEME_VERSION
        ];
        $styles['shortcodes'] = [
            'src' => $this->cssPath . '/shortcodes.css',
            'deps' => array(),
            'ver' => THEME_VERSION
        ];
        $styles['shortcodes'] = [
            'src' => $this->cssPath . '/shortcodes.css',
            'deps' => array(),
            'ver' => THEME_VERSION
        ];
        $styles['spacing'] = [
            'src' => $this->cssPath . '/spacing.css',
            'deps' => array(),
            'ver' => THEME_VERSION
        ];
        $styles['style-custom'] = [
            'src' => $this->cssPath . '/style.css',
            'deps' => array(),
            'ver' => THEME_VERSION
        ];

        return $styles;
    }

    public function addFrontEndScripts()
    {
        

        wp_deregister_script('jquery');

        $scripts['theme'] = array(
            'src' => $this->jsPath . '/theme.js',
            'ver' => '3.6.0',
            'in_footer' => true,

        );
        $scripts['theme-plugin'] = array(
            'src' => $this->jsPath . '/theme-plugin.js',
            'ver' => THEME_VERSION,
            'in_footer' => true,
            'deps' => array(
                'theme',
            )

        );
        $scripts['theme-script'] = array(
            'src' => $this->jsPath . '/theme-script.js',
            'ver' => THEME_VERSION,
            'in_footer' => true,
            'deps' => array(
                'theme',
            )

        );


        return $scripts;
    }
}
