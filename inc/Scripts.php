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
            'src' => $this->bootstrapPath . '/css/bootstrap.min.css',
            'deps' => array(),
            'ver' => THEME_VERSION
        ];
        $styles['style-theme'] = [
            'src' => $this->cssPath . '/style.css',
            'deps' => array(),
            'ver' => THEME_VERSION
        ];
        $styles['flexslider'] = [
            'src' => $this->cssPath . '/flexslider.css',
            'deps' => array(),
            'ver' => THEME_VERSION
        ];
        $styles['ionicons'] = [
            'src' => $this->iconsDir . '/css/ionicons.min.css',
            'deps' => array(),
            'ver' => THEME_VERSION
        ];
        $styles['simple-line'] = [
            'src' => $this->iconsDir . '/css/simple-line-icons.css',
            'deps' => array(),
            'ver' => THEME_VERSION
        ];
        $styles['rs-plugin'] = [
            'src' => $this->rsPlugin . '/css/settings.css',
            'deps' => array(),
            'ver' => THEME_VERSION
        ];
        $styles['pretty-photo'] = [
            'src' => $this->cssPath . '/prettyPhoto.css',
            'deps' => array(),
            'ver' => THEME_VERSION
        ];


        return $styles;
    }

    public function addFrontEndScripts()
    {
        //General Scripts
        $scripts['ie_html5shiv'] = array(
            'src' => 'https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js',
            'ver' => '3.7.3',
            'in_footer' => false,
            'data' => array(
                'key' => 'conditional',
                'value' => 'lt IE 9',
            )
        );
        $scripts['respond'] = array(
            'src' => 'https://oss.maxcdn.com/respond/1.4.2/respond.min.js',
            'ver' => '1.4.2',
            'in_footer' => false,
            'data' => array(
                'key' => 'conditional',
                'value' => 'lt IE 9',
            )
        );
        //jquery

        wp_deregister_script('jquery');

        $scripts['jquery'] = array(
            'src' => $this->jsPath . '/jquery.min.js',
            'ver' => '1.11.2',
            'in_footer' => true,

        );
        $scripts['moderniz'] = array(
            'src' => $this->jsPath . '/moderniz.min.js',
            'ver' => '',
            'in_footer' => true,
            'deps' => array(
                'jquery',
            )
        );
        $scripts['easing'] = array(
            'src' => $this->jsPath . '/jquery.easing.1.3.js',
            'ver' => '',
            'in_footer' => true,
            'deps' => array(
                'jquery',
            )
        );

        //bootstrap

        $scripts['bootstrap-js'] = array(
            'src' => $this->bootstrapPath . '/js/bootstrap.min.js',
            'ver' => '',
            'in_footer' => true,
            'deps' => array(
                'jquery',
                'ie_html5shiv',
                'respond'

            )
        );
        $scripts['flexslider-js'] = array(
            'src' => $this->jsPath . '/jquery.flexslider-min.js',
            'ver' => '',
            'in_footer' => true,
            'deps' => array(
                'jquery',
            )
        );

        $scripts['parallax-js'] = array(
            'src' => $this->jsPath . '/parallax.min.js',
            'ver' => '',
            'in_footer' => true,
            'deps' => array(
                'jquery',
            )
        );

        $scripts['prettyPhoto-js'] = array(
            'src' => $this->jsPath . '/jquery.prettyPhoto.js',
            'ver' => '',
            'in_footer' => true,
            'deps' => array(
                'jquery',
            )
        );

        $scripts['jqBootstrapValidation-js'] = array(
            'src' => $this->jsPath . '/jqBootstrapValidation.js',
            'ver' => '',
            'in_footer' => true,
            'deps' => array(
                'jquery',
            )
        );

        //revolution slider scripts
        $scripts['themepunch-tool-js'] = array(
            'src' => $this->rsPlugin . '/js/jquery.themepunch.tools.min.js',
            'ver' => '',
            'in_footer' => true,
            'deps' => array(
                'jquery',
            )
        );

        $scripts['themepunch-revolution-js'] = array(
            'src' => $this->rsPlugin . '/js/jquery.themepunch.revolution.min.js',
            'ver' => '',
            'in_footer' => true,
            'deps' => array(
                'jquery',
            )
        );

        $scripts['template'] = array(
            'src' => $this->jsPath . '/template.js',
            'ver' => '',
            'in_footer' => true,
            'deps' => array(
                'jquery',
            )
        );
        $scripts['form-js'] = array(
            'src' => $this->jsPath . '/form-send.js',
            'ver' => '',
            'in_footer' => true,
            'deps' => array(
                'jquery',
            )
        );


        return $scripts;
    }
}
