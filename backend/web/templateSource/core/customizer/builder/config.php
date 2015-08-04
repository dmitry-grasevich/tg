<?php
if (!defined('ABSPATH'))  {
    die('Direct access forbidden.');
}

if (!class_exists('TG_Customizer_Config')) {
    return;
}

/**
 * Customizer Configuration File
 *
 * This file is used to define the different panels, sections and controls for Template
 *
 * @package TG
 * @since TG 1.0.0
 */
class TG_Customizer_Config
{
    /**
     * @var
     */
    public $panels;

    /**
     * @var
     */
    public $default_sections;

    /**
     * @var
     */
    public $sections;

    /**
     * @var
     */
    public $controls;

    /**
     * @var
     */
    public $default_controls;

    /**
     * @var
     */
    public $styles;

    /**
     * @var
     */
    public $pseudo_js;

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
        // Init and store panels
        $this->panels = $this->panels();

        // Init and store default_sections
        $this->default_sections = $this->default_sections();

        // Init and store sections
        $this->sections = $this->sections();

        // Init and store controls
        $this->controls = $this->controls();

        // Init and store default controls
        $this->default_controls = $this->default_controls();

        // Init and store styles
        $this->styles = $this->styles();

        // Init and store pseudo js
        $this->pseudo_js = $this->pseudo_js();
    }

    /**
     * TG Customizer Panels
     *
     * @return   array            Panels to be registered in the customizer
     */
    private function panels()
    {
        $panels = array(
            'site-settings' => array(
                'title' => __('General Settings', 'tg'),
                'description' => __('Control your site\'s logo, navigation and fonts.', 'tg'),
                'priority' => 10
            ),
            'header-panel' => array(
                'title' => __('Header', 'tg'),
                'description' => __('Control your header\'s text, buttons and background.', 'tg'),
                'priority' => 20
            ),
        );

        return apply_filters('tg_customizer_panels', $panels);
    }

    /**
     * TG Customizer Sections
     *
     * @return   array            Sections to be registered in the customizer
     */
    private function default_sections()
    {
        $default_sections = array(
            'title_tagline' => array(
                'title' => __('Logo &amp; Title', 'tg'),
                'panel' => 'site-settings'
            ),
            'colors' => array(
                'title' => __('Colors', 'tg'),
                'panel' => 'site-settings',
                'priority' => 55,
            ),
            'nav' => array( // This is used before any menus are registered. Then replaced by WP Navigation
                'title' => __('Navigation', 'tg'),
                'description' => __('First create a menu then come back here to place it.', 'tg'),
                'priority' => 50,
                'panel' => 'site-settings'
            ),
        );

        return apply_filters('tg_customizer_default_sections', $default_sections);
    }

    /**
     * TG Customizer Sections
     *
     * @return array Sections to be registered in the customizer
     */
    private function sections()
    {
        $sections = array(
            // Site Settings
            'site-colors' => array(
                'title' => __('Colors', 'tg'),
                'panel' => 'site-settings',
            ),
            'fonts' => array(
                'title' => __('Fonts', 'tg'),
                'panel' => 'site-settings'
            ),
            'sections-order' => array(
                'title' => __('Sections Order', 'tg'),
                'panel' => 'site-settings'
            ),
            // Header
            'header-text' => array(
                'title' => __('Text', 'tg'),
                'panel' => 'header-panel',
                'description' => __('Some description here', 'tg'),
            ),
            'header-buttons' => array(
                'title' => __('Buttons', 'tg'),
                'panel' => 'header-panel'
            ),
            'header-background' => array(
                'title' => __('Background', 'tg'),
                'panel' => 'header-panel'
            ),
        );

        return apply_filters('tg_customizer_sections', $sections);
    }

    /**
     * TG Customizer controls
     *
     * @return array Controls to be registered in the customizer
     */
    private function controls()
    {
        $controls = array(
            // Site Settings -> Fonts
            'fonts' => array(
                'tg-body-fonts' => array(
                    'type' => 'tg-font',
                    'label' => __('Body', 'tg'),
                    'default' => 'Lato',
                ),
                'tg-fonts-break-1' => array(
                    'type' => 'tg-separator'
                ),
                'tg-logo-font' => array(
                    'type' => 'tg-font',
                    'label' => __('Logo', 'tg'),
                    'default' => 'Lobster',
                ),
                'tg-fonts-break-2' => array(
                    'type' => 'tg-separator'
                ),
                'tg-heading-fonts' => array(
                    'type' => 'tg-font',
                    'label' => __('Headings', 'tg'),
                    'default' => 'Lato',
                ),
                'tg-fonts-break-3' => array(
                    'type' => 'tg-separator'
                ),
                'tg-buttons-fonts' => array(
                    'type' => 'tg-font',
                    'label' => __('Buttons', 'tg'),
                    'default' => 'Lato',
                ),
            ),


            // @TODO: fill 'default' and 'choices' when template is generated
            // Site Settings -> Sections Order
            'sections-order' => array(
                'tg-sections-order-sorter' => array(
                    'type' => 'tg-sortable',
                    'label' => __('Sections', 'tg'),
                    'help' => __('Click the "eye" to toggle the section from being displayed.', 'tg'),
                    'default' => array(
                        'header',
                        'some',
                        'another',
                    ),
                    'choices' => array(
                        'header' => __('Header', 'tg'),
                        'some' => __('Some Section', 'tg'),
                        'another' => __('Another Section', 'tg'),
                    ),
                ),
            ),

            // Header -> Text
            'header-text' => array(
                'tg-header-text-title' => array(
                    'type' => 'tg-text',
                    'label' => __('Title', 'tg'),
                    'default' => 'Flat landing page<br>for apps <span class="amp">&amp;</span> portfolio',
                    'transport' => 'postMessage',
                    'sanitize_callback' => 'tg_sanitize_text_kses',
                ),
                'tg-header-text-title-color' => array(
                    'type' => 'tg-color-alpha',
                    'label' => __('Title Color', 'tg'),
                    'default' => '#ffffff',
                ),
                'tg-header-text-title-font' => array(
                    'type' => 'tg-font',
                    'label' => __('Title Font', 'tg'),
                    'description' => __('Please choose a font for the title.', 'tg'),
                    'default' => 'Lato',
                ),
                'tg-header-text-title-size' => array(
                    'type' => 'tg-slider',
                    'label' => __('Title Font Size', 'tg'),
                    'description' => __('Please choose a font-size for the title.', 'tg'),
                    'default' => 3.75,
                    'choices' => array(
                        'min' => 2,
                        'max' => 6,
                        'step' => .05
                    ),
                ),

                'tg-header-text-title-separator' => array(
                    'type' => 'tg-separator',
                ),

                'tg-header-text-description' => array(
                    'type' => 'tg-textarea',
                    'label' => __('Description', 'tg'),
                    'default' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas tincidunt mi ac facilisis cursus. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.',
//                    'transport' => 'postMessage',
                ),
                'tg-header-text-description-color' => array(
                    'type' => 'tg-color-alpha',
                    'label' => __('Description Color', 'tg'),
                    'default' => '#ffffff',
                ),
                'tg-header-text-description-font' => array(
                    'type' => 'tg-font',
                    'label' => __('Description Font', 'tg'),
                    'description' => __('Please choose a font for description.', 'tg'),
                    'default' => 'Lato',
                ),
                'tg-header-text-description-size' => array(
                    'type' => 'tg-slider',
                    'label' => __('Description Font Size', 'tg'),
                    'description' => __('Please choose a font-size for description.', 'tg'),
                    'default' => 1.3,
                    'choices' => array(
                        'min' => 0.5,
                        'max' => 3,
                        'step' => .05
                    ),
                ),

                'tg-header-text-description-separator' => array(
                    'type' => 'tg-separator',
                ),
                'tg-header-text-width' => array(
                    'type' => 'tg-slider',
                    'label' => __('Width', 'tg'),
                    'description' => __('Change width of text block', 'tg'),
                    'default' => 8,
                    'choices' => array(
                        'min' => 4,
                        'max' => 12,
                        'step' => 1,
                    ),
                ),
            ),

            // Header -> Buttons
            'header-buttons' => array(
                'tg-header-buttons-button-visibility' => array(
                    'type' => 'tg-toggle',
                    'label' => __('Display button', 'tg'),
                    'default' => '1',
                ),
                'tg-header-buttons-button-title' => array(
                    'type' => 'tg-text',
                    'label' => __('Button Title', 'tg'),
                    'default' => 'Get started',
                    'transport' => 'postMessage',
                ),
                'tg-header-buttons-button-url' => array(
                    'type' => 'tg-text',
                    'label' => __('Button URL', 'tg'),
                    'default' => '#',
                ),
                'tg-header-buttons-button-style' => array(
                    'type' => 'tg-select',
                    'label' => __('Select Button Style', 'tg'),
                    'default' => 'btn-ghost',
                    'choices' => array(
                        'btn-ghost' => 'Ghost (light)',
                        'btn-ghost-inverse' => 'Ghost (dark)',
                        'btn-primary' => 'Primary',
                        'btn-info' => 'Info',
                        'btn-danger' => 'Danger',
                        'btn-warning' => 'Warning',
                        'btn-success' => 'Success',
                        'btn-default' => 'Default',
                        'btn-link' => 'Link',
                    ),
                ),
            ),

            // Header -> Background
            'header-background' => array(
                'tg-header-background-image' => array(
                    'type' => 'tg-image',
                    'label' => __('Background Image', 'tg'),
                    'default' => TG_TEMPLATE_URI . '/images/bg-home-v1.jpg',
                ),
                'tg-header-background-position' => array(
                    'type' => 'tg-radio-buttonset',
                    'label' => __('Background Image Position', 'tg'),
                    'default' => 'scroll',
                    'choices' => array(
                        'scroll' => 'Scroll',
                        'fixed' => 'Fixed',
                    ),
                ),
                'tg-header-background-cover-color' => array(
                    'type' => 'tg-color-alpha',
                    'label' => __('Image Cover Color', 'tg'),
                    'default' => 'rgba(0,0,0,.3)',
                ),
            )
        );

        $controls = apply_filters('tg_customizer_controls', $controls);

        $controls = $this->apply_defaults($controls);

        return $controls;
    }

    /**
     * TG Customizer default controls
     *
     * @return array Default Controls to be registered in the customizer after moving of default sections
     */
    private function default_controls()
    {
        // Site Settings -> Logo & Title
        $default_controls = array(
            'title_tagline' => array(
                'tg-site-logo-text-color' => array(
                    'type' => 'tg-color',
                    'label' => __('Title Text Color', 'tg'),
                    'default' => '#ffffff',
                ),
                'tg-site-logo-image' => array(
                    'type' => 'image',
                    'label' => __('Logo', 'tg'),
                ),
            ),
        );

        // Site Settings -> Navigation
        if (!wp_get_nav_menus()) {
            $default_controls['nav'] = array(
                'tg-general-nav' => array(
                    'type' => 'tg-button',
                    'text' => __('Create Menu', 'tg'),
                    'href' => admin_url('nav-menus.php'),
                ),
            ); // header-layout
        }

        $default_controls = apply_filters('tg_customizer_default_controls', $default_controls);

        $default_controls = $this->apply_defaults($default_controls);

        return $default_controls;
    }

    /**
     * TG Customizer styles
     *
     * @return array
     */
    private function styles()
    {
        $styles = array(
            'tg-site-logo-text-color' => array(
                'output' => array(
                    array(
                        'element' => '.hdr-v1 h1.logo a',
                        'property' => 'color',
                    ),
                ),
                'js_vars' => array(
                    array(
                        'element' => '.hdr-v1 h1.logo a',
                        'function' => 'css',
                        'property' => 'color',
                    ),
                )
            ),
            'tg-body-fonts' => array(
                'output' => array(
                    array(
                        'element' => 'body',
                        'property' => 'font-family',
                    ),
                ),
            ),
            'tg-logo-font' => array(
                'output' => array(
                    array(
                        'element' => '.hdr-v1 h1.logo',
                        'property' => 'font-family',
                    ),
                ),
            ),
            'tg-heading-fonts' => array(
                'output' => array(
                    array(
                        'element' => 'h1,h2,h3,h4,h5,h6, .heading',
                        'property' => 'font-family',
                    ),
                ),
            ),
            'tg-buttons-fonts' => array(
                'output' => array(
                    array(
                        'element' => 'button, .button, input[type=submit]',
                        'property' => 'font-family',
                    ),
                ),
            ),

            'tg-header-text-title' => array(
                'js_vars' => array(
                    array(
                        'element' => '.intro h2.page-intro',
                        'function' => 'html',
                    ),
                )
            ),
            'tg-header-text-title-color' => array(
                'output' => array(
                    array(
                        'element' => '.intro h2.page-intro',
                        'property' => 'color',
                    ),
                ),
                'js_vars' => array(
                    array(
                        'element' => '.intro h2.page-intro',
                        'function' => 'css',
                        'property' => 'color',
                    ),
                )
             ),
            'tg-header-text-title-font' => array(
                'output' => array(
                    array(
                        'element' => '.intro h2.page-intro',
                        'property' => 'font-family',
                    ),
                ),
             ),
            'tg-header-text-title-size' => array(
                'output' => array(
                    array(
                        'element' => '.intro h2.page-intro',
                        'property' => 'font-size',
                        'units' => 'em',
                    ),
                ),
                'js_vars' => array(
                    array(
                        'element' => '.intro h2.page-intro',
                        'function' => 'css',
                        'property' => 'font-size',
                    ),
                )
             ),

            'tg-header-text-description' => array(
                'js_vars' => array(
                    array(
                        'element' => '.intro .page-description',
                        'function' => 'html',
                    ),
                )
            ),
            'tg-header-text-description-color' => array(
                'output' => array(
                    array(
                        'element' => '.intro .page-description',
                        'property' => 'color',
                    ),
                ),
                'js_vars' => array(
                    array(
                        'element' => '.intro .page-description',
                        'function' => 'css',
                        'property' => 'color',
                    ),
                )
             ),
            'tg-header-text-description-font' => array(
                'output' => array(
                    array(
                        'element' => '.intro .page-description',
                        'property' => 'font-family',
                    ),
                ),
             ),
            'tg-header-text-description-size' => array(
                'output' => array(
                    array(
                        'element' => '.intro .page-description',
                        'property' => 'font-size',
                        'units' => 'em',
                    ),
                ),
                'js_vars' => array(
                    array(
                        'element' => '.intro .page-description',
                        'function' => 'css',
                        'property' => 'font-size',
                    ),
                )
             ),

            'tg-header-buttons-button-title' => array(
                'js_vars' => array(
                    array(
                        'element' => '#hdr-btn-1',
                        'function' => 'html',
                    )
                )
            ),

            'tg-header-background-image' => array(
                'output' => array(
                    array(
                        'element' => 'section.home-v1',
                        'property' => 'background-image',
                    ),
                ),
                'js_vars' => array(
                    array(
                        'element' => 'section.home-v1',
                        'function' => 'css',
                        'property' => 'background-image',
                    ),
                )
            ),
            'tg-header-background-position' => array(
                'output' => array(
                    array(
                        'element' => 'section.home-v1',
                        'property' => 'background-attachment',
                    ),
                ),
                'js_vars' => array(
                    array(
                        'element' => 'section.home-v1',
                        'function' => 'css',
                        'property' => 'background-attachment',
                    ),
                )
            ),
            'tg-header-background-cover-color' => array(
                'output' => array(
                    array(
                        'element' => 'section.home-v1:before',
                        'property' => 'background',
                    ),
                ),
                'js_vars' => array(
                    array(
                        'element' => 'section.home-v1:before',
                        'function' => 'css',
                        'property' => 'background',
                    ),
                )
            ),
        );

        return $styles;
    }

    /**
     * TG Customizer pseudo js
     *
     * @return array
     */
    private function pseudo_js()
    {
        $pseudo_js = array(
            'tg-header-background-cover-color' => array(
                array(
                    'element' => 'section.home-v1:before',
                    'property' => 'background',
                ),
            ),
        );

        return $pseudo_js;
    }

    /**
     * @param $controls
     * @return mixed
     */
    private function apply_defaults($controls)
    {
        $defaults = apply_filters('tg_customizer_control_defaults', array());

        if (empty($defaults)) return $controls;

        foreach ($controls as $section_key => $control) {
            foreach ($control as $control_key => $control_data) {
                if (isset($defaults[$control_key])) {
                    $controls[$section_key][$control_key]['default'] = $defaults[$control_key];
                }
            }
        }

        return $controls;
    }
}

