<?php
if (!defined('ABSPATH')) die('Direct access forbidden.');

if (!class_exists('TG_Customizer_Registration')) :
    /**
     * Customizer Registration File
     *
     * This file is used to register panels, sections and controls
     *
     * @package TG
     * @since TG 1.0.0
     */
    class TG_Customizer_Registration
    {
        /**
         * @var
         */
        public $customizer;

        /**
         * @var
         */
        public $config;

        /**
         * @var
         */
        public $prefix;

        /**
         * @var
         */
        private static $instance; // stores singleton class

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
            // Register the customizer object
            global $wp_customize;

            $this->customizer = $wp_customize;

            // Set Prefix
            $this->prefix = TG_THEME_SLUG . '-';

            // Grab the customizer config
            $this->config = TG_Customizer_Config::get_instance();

            //Register the panels and sections based on this instance's config

            // Start registration with the panels & sections
            $this->registerPanels($this->config->panels);
            $this->registerSections($this->config->sections);

            // Move default sections into TG Panels
            $this->moveDefaultSections($this->config->default_sections);

            $this->registerDefaultControls($this->config->default_controls, $this->config->styles);

            $this->registerPseudoJs();
        }

        /**
         * Check whether or not panels are supported by the customizer
         *
         * @return   boolean    true if panels are supported
         */
        function customizerSupportsPanels()
        {
            return (class_exists('WP_Customize_Manager') && method_exists('WP_Customize_Manager', 'add_panel')) || function_exists('wp_validate_boolean');
        }

        /**
         * Register Panels
         *
         * @param array $panels    Array of panel config
         */
        function registerPanels($panels = array())
        {
            // If there are no panels, return
            if (empty($panels)) return;

            foreach ($panels as $panel_key => $panel_data) {
                // If panels are supported, add this as a panel
                if ($this->customizerSupportsPanels()) {
                    $this->customizer->add_panel($this->prefix . $panel_key, $panel_data);
                }
            } // foreach panel
        }

        /**
         * Register Sections
         *
         * @param array $sections    Array of sections config
         */
        public function registerSections($sections = array())
        {
            // If there are no sections, return
            if (empty($sections)) return;

            $section_priority = 150;

            foreach ($sections as $section_key => $section_data) {
                if ($this->customizerSupportsPanels() && isset($section_data['panel'])) {
                    // Set which panel to use
                    $section_data['panel'] = $this->prefix . $section_data['panel'];
                }

                if (!isset($section_data['priority'])) {
                    $section_data['priority'] = $section_priority;
                }

                $this->customizer->add_section(
                    $this->prefix . $section_key,
                    $section_data
                );

                $section_priority++;

                // Register Sections for this Panel
                $this->registerControls($section_key, $this->config->controls, $this->config->styles);
            }
        }

        /**
         * Register Controls
         *
         * @param string $panel_section_key     Unique key for which section this control belongs to
         * @param array $controls               Array of controls config
         * @param array $styles                 Array of styles config
         */
        public function registerControls($panel_section_key = '', $controls = array(), $styles = array())
        {
            // If there are no controls, return
            if (empty($controls)) return;

            // Make sure that there is actually section config for this panel
            if (!isset($controls[$panel_section_key])) return;

            $control_priority = 150;

            foreach ($controls[$panel_section_key] as $control_key => $control_data) {

                // Assign control to the relevant section
                $control_data['section'] = $this->prefix . $panel_section_key;

                // Set control priority to obey order of setup
                $control_data['priority'] = $control_priority;

                // Set control settings value
                $control_data['settings'] = $control_key;

                $control_styles = array_key_exists($control_key, $styles) ? $styles[$control_key] : null;

                TG_Control::addField($this->customizer, $control_data, $control_styles);

                $control_priority++;

            } // foreach controls panel_section_key
        }

        /**
         * Move Default Sections
         *
         * @param array $sections
         */
        public function moveDefaultSections($sections = array())
        {
            foreach ($sections as $section_key => $section_data) {
                // Get the current section
                $section = $this->customizer->get_section($section_key);

                // Move this section to a specific panel
                if (isset($section_data['panel'])) {
                    $section->panel = $this->prefix . $section_data['panel'];
                }

                // Prioritize this section
                if (isset($section_data['title'])) {
                    $section->title = $section_data['title'];
                }

                // Prioritize this section
                if (isset($section_data['priority'])) {
                    $section->priority = $section_data['priority'];
                }
            }

            // Remove the theme switcher Panel, Layers isn't ready for that
            $this->customizer->remove_section('themes');
        }

        /**
         * Register default controls - should be called after moving of default sections
         *
         * @param array $default_controls
         * @param array $styles
         */
        public function registerDefaultControls($default_controls = array(), $styles = array())
        {
            // If there are no default controls, return
            if (empty($default_controls)) return;

            foreach ($default_controls as $panel_section_key => $controls) {
                $control_priority = 250;
                foreach ($controls as $control_key => $control_data) {
                    // Assign control to the relevant section
                    $control_data['section'] = $panel_section_key;

                    // Set control priority to obey order of setup
                    $control_data['priority'] = $control_priority;

                    // Set control settings value
                    $control_data['settings'] = $control_key;

                    $control_styles = array_key_exists($control_key, $styles) ? $styles[$control_key] : null;

                    TG_Control::addField($this->customizer, $control_data, $control_styles);

                    $control_priority++;
                }
            }
        }

        /**
         *
         */
        public function registerPseudoJs()
        {
            add_action('wp_footer', array($this, 'generatePseudoJs'), 22);
        }

        /**
         *
         */
        public function generatePseudoJs()
        {
            if (empty($this->config->pseudo_js)) return;

            $script = '';
            foreach ($this->config->pseudo_js as $control_key => $controls) {
                foreach ($controls as $control_data) {
                    $script .= 'wp.customize( \'' . $control_key . '\', function( value ) {';
                        $script .= 'value.bind( function( newval ) {';
                            $script .= '$(\'head\').append(\'<style>' . esc_js($control_data['element']) . '{ ' . esc_js($control_data['property']) . ':\' + newval + \'; }</style>\');';
                        $script .= '});';
                    $script .= '});';
                }
            }

            if ($script != '') {
                echo self::prepareScript($script);
            }
        }

        /**
         * @param $script
         * @return string
         */
        public static function prepareScript($script)
        {
            return '<script>jQuery(document).ready(function($) { "use strict"; '.$script.'});</script>';
        }
    }
endif;

if (!function_exists('tg_register_customizer')) :
    /**
     * Return the one TG_Customizer_Registration object.
     *
     * @since  1.0.0.
     *
     * @return TG_Customizer_Registration    The TG_Customizer_Registration object.
     */
    function tg_register_customizer()
    {
        return TG_Customizer_Registration::get_instance();
    }
endif;

add_action('customize_register', 'tg_register_customizer');
