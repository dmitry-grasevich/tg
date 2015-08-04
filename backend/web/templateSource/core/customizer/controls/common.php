<?php
/**
 * @package TG
 * @since TG 1.0.0
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Early exit if the class already exists
if (class_exists('TG_Control')) {
    return;
}

class TG_Control
{
    /**
     * @var string
     */
    protected static $kirkiConfigId = TG_THEME_SLUG . '_theme';

    /**
     * @var array
     */
    protected static $wpControls = array(
        'image' => 'WP_Customize_Image_Control',
        'background-image' => 'WP_Customize_Background_Image_Control',
        'header-image' => 'WP_Customize_Header_Image_Control',
        'color' => 'WP_Customize_Color_Control',
        'media' => 'WP_Customize_Media_Control',
        'upload' => 'WP_Customize_Upload_Control',
        'checkbox' => 'WP_Customize_Control',
        'date' => 'WP_Customize_Control',
        'dropdown-pages' => 'WP_Customize_Control',
        'email' => 'WP_Customize_Control',
        'hidden' => 'WP_Customize_Control',
        'number' => 'WP_Customize_Control',
        'radio' => 'WP_Customize_Control',
        'range' => 'WP_Customize_Control',
        'select' => 'WP_Customize_Control',
        'text' => 'WP_Customize_Control',
        'textarea' => 'WP_Customize_Control',
        'url' => 'WP_Customize_Control',
    );

    /**
     * @var array
     */
    protected static $tgControls = array(
        'tg-date-picker' => 'TG_Date_Picker_Control',
        'tg-dropdown-category' => 'TG_Category_DropDown_Control',
        'tg-dropdown-menu' => 'TG_Menu_DropDown_Control',
        'tg-dropdown-post' => 'TG_Post_DropDown_Control',
        'tg-dropdown-post-type' => 'TG_Post_Type_DropDown_Control',
        'tg-dropdown-tags' => 'TG_Tags_DropDown_Control',
        'tg-dropdown-taxonomy' => 'TG_Taxonomy_DropDown_Control',
        'tg-dropdown-users' => 'TG_Users_DropDown_Control',
        'tg-layout-picker' => 'TG_Layout_Picker_Control',
        'tg-separator' => 'TG_Separator_Control',
        'tg-text-editor' => 'TG_Text_Editor_Control',
        'tg-toggle' => 'TG_Toggle_Control',
        'tg-button' => 'TG_Button_Control',
    );

    /**
     * @var array
     */
    protected static $kirkiControls = array(
        'tg-color' => 'color',
        'tg-color-alpha' => 'color-alpha',
        'tg-font' => 'select',
        'tg-image' => 'image',
        'tg-select' => 'select',
        'tg-slider' => 'slider',
        'tg-radio-buttonset' => 'radio-buttonset',
        'tg-sortable' => 'sortable',
        'tg-text' => 'text',
        'tg-textarea' => 'textarea',
    );

    /**
     *
     */
    public function __construct() {}

    /**
     * @param $customizer
     * @param $controlData
     * @param null $stylesData
     */
    public static function addField(&$customizer, $controlData, $stylesData = null)
    {
        if (!array_key_exists('type', $controlData)) {
            return;
        }

        if (array_key_exists($controlData['type'], self::$kirkiControls)) {
            self::addKirkiField($controlData, $stylesData);
        } elseif (array_key_exists($controlData['type'], self::$tgControls) && class_exists(self::$tgControls[$controlData['type']])) {
            self::addWpField($customizer, $controlData, self::$tgControls[$controlData['type']]);
        } elseif (array_key_exists($controlData['type'], self::$wpControls) && class_exists(self::$wpControls[$controlData['type']])) {
            self::addWpField($customizer, $controlData, self::$wpControls[$controlData['type']]);
        } else {
            self::addWpField($customizer, $controlData);
        }
    }

    /**
     * @param $controlData
     * @param null $stylesData
     */
    protected static function addKirkiField($controlData, $stylesData = null)
    {
        switch ($controlData['type']) {
            case 'tg-font':
                $controlData['choices'] = Kirki_Fonts::get_font_choices();
                break;
            case 'tg-color':
            case 'tg-color-alpha':
            case 'tg-textarea':
                $controlData['transport'] = 'postMessage';
                break;
            default:
                break;
        }

        if ($stylesData) {
            if (array_key_exists('output', $stylesData)) {
                $controlData['output'] = $stylesData['output'];
            }
            if (array_key_exists('js_vars', $stylesData)) {
                $controlData['js_vars'] = $stylesData['js_vars'];
            }
        }

        $controlData['type'] = self::$kirkiControls[$controlData['type']];

        Kirki::add_field(self::$kirkiConfigId, $controlData);
    }

    /**
     * @param $customizer
     * @param $controlData
     * @param null $class
     */
    protected static function addWpField(&$customizer, $controlData, $class = null)
    {
        // Add Setting
        $default = isset($controlData['default']) ? $controlData['default'] : null;
        $settingKey = $controlData['settings'];
        unset($controlData['settings']);
        $sanitizeCallback = self::addSanitizeCallback($controlData);
        $customizer->add_setting(
            $settingKey,
            array(
                'default' => $default,
                'type' => 'theme_mod',
                'capability' => 'edit_theme_options',
                'sanitize_callback' => $sanitizeCallback,
                'transport' => (isset($controlData['transport']) ? $controlData['transport'] : 'refresh')
            )
        );

        if ($class) {
            $customizer->add_control(
                new $class(
                    $customizer,
                    $settingKey,
                    $controlData
                )
            );
        } else {
            $customizer->add_control(
                $settingKey,
                $controlData
            );
        }
    }

    /**
     * Add Sanitization according to the control type (or use the explicit callback that has been set)
     *
     * @param bool|false $controlData
     *
     * @return bool|string
     */
    private static function addSanitizeCallback($controlData = false)
    {
        // If there's an override, use the override rather than the automatic sanitization
        if (isset($controlData['sanitize_callback'])) {
            if (false == $controlData['sanitize_callback']) {
                return false;
            } else {
                return $controlData['sanitize_callback'];
            }
        }

        switch ($controlData['type']) {
            case 'tg-color' :
                $callback = 'tg_sanitize_hex_color';
                break;
            case 'tg-checkbox' :
                $callback = 'tg_sanitize_checkbox';
                break;
            case 'tg-textarea' :
                $callback = 'esc_textarea';
                break;
            case 'tg-code' :
                $callback = false;
                break;
            case 'tg-rte' :
                $callback = false;
                break;
            case 'tg-email':
                $callback = 'sanitize_email';
                break;
            default :
                $callback = 'sanitize_text_field';
        }

        return $callback;
    }
}