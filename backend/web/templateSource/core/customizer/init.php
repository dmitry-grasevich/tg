<?php
if (!defined('ABSPATH')) {
    die('Direct access forbidden.');
}

if (!class_exists('TG_Customizer')) {

    /**
     * Customizer Init File
     *
     * @package TG
     * @since TG 1.0.0
     */
    class TG_Customizer
    {
        private static $instance; // stores singleton class

        private static $rel_path = null;

        private static $include_isolated_callable;

        /**
         *  Get Instance creates a singleton class that's cached to stop duplicate instances
         */
        public static function get_instance()
        {
            if (!self::$instance) {
                self::$instance = new self();
                self::$instance->init();
            }
            return self::$instance;
        }

        /**
         *  Construct empty on purpose
         */

        private function __construct() {}

        /**
         *  Init behaves like, and replaces, construct
         */

        public function init()
        {
            /**
             * Include a file isolated, to not have access to current context variables
             */
            self::$include_isolated_callable = create_function('$path', 'include $path;');

            global $wp_customize;

            // Include helpers
            self::include_dir('../helpers');

            // Include config file
            self::include_file('builder/config.php');

            if (isset($wp_customize)) {
                Kirki::add_config(TG_THEME_SLUG . '_theme', array(
                    'capability' => 'edit_theme_options',
                ));

                // Include controls
                self::include_dir('controls');

                // Include The Panel and Section Registration Class
                self::include_file('builder/registration.php');

                // Enqueue Styles
                add_action('admin_enqueue_scripts', array($this, 'admin_print_styles'));
                add_action('customize_controls_print_styles', array($this, 'admin_print_styles'));
//                add_action('customize_preview_init', array($this, 'customizer_preview_enqueue_scripts'));
            } else {
                /**
                 * Only frontend
                 */
                // Include styles builder
                self::include_file('builder/styles.php');

                add_action('wp_head', 'generate_custom_styles');
            }
        }

        /**
         *  Enqueue Customizer Preview Scripts
         */
        public function customizer_preview_enqueue_scripts()
        {
            wp_enqueue_script(
                TG_THEME_SLUG . '-customizer-preview',
                TG_CUSTOMIZER_URI . '/js/customizer-preview.js',
                array('customize-preview-widgets'),
                TG_VERSION,
                true
            );
        }

        /**
         *  Enqueue Widget Styles
         */
        public function admin_print_styles()
        {
            wp_enqueue_style(
                TG_THEME_SLUG . '-admin-customizer',
                TG_CUSTOMIZER_URI . '/css/customizer.css',
                array(),
                TG_VERSION
            );
        }

        /**
         * @param string $append
         * @return string
         */
        private static function get_rel_path($append = '')
        {
            if (self::$rel_path === null) {
                self::$rel_path = '/core/' . basename(dirname(__FILE__)) . '/';
            }

            return self::$rel_path . $append;
        }

        /**
         * @param $path
         */
        public static function include_isolated($path)
        {
            call_user_func(self::$include_isolated_callable, $path);
        }

        /**
         * @param $rel_path
         */
        public static function include_file($rel_path)
        {
            $path = TG_TEMPLATE_DIR . self::get_rel_path($rel_path);

            if (file_exists($path)) {
                self::include_isolated($path);
            }
        }

        /**
         * @param $rel_path
         */
        public static function include_dir($rel_path)
        {
            $path = TG_TEMPLATE_DIR . self::get_rel_path($rel_path);

            if ($files = glob($path . '/*.php')) {
                foreach ($files as $file) {
                    self::include_isolated($file);
                }
            }
        }
    }
}

if (!function_exists('tg_customizer_init')) :
    /**
     * Return the one TG_Customizer object.
     *
     * @since  1.0.0.
     *
     * @return TG_Customizer    The TG_Customizer object.
     */
    function tg_customizer_init()
    {
        return TG_Customizer::get_instance();
    }
endif;

add_action('customize_register', 'tg_customizer_init');
add_action('init', 'tg_customizer_init');