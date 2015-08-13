<?php

if (__FILE__ == $_SERVER['SCRIPT_FILENAME']) {
    die('Direct access forbidden.');
}

/**
 *      Define Constants
 **/
define('TG_VERSION', '1.0.0');
define('TG_TEMPLATE_URI', get_template_directory_uri());
define('TG_TEMPLATE_DIR', get_template_directory());
define('TG_THEME_TITLE', 'Template Generator');
define('TG_THEME_SLUG', 'tg');
define('TG_IMAGES', TG_TEMPLATE_URI . '/img');
define('TG_SCRIPTS', TG_TEMPLATE_URI . '/js');
define('TG_STYLES', TG_TEMPLATE_URI . '/css');
define('TG_CUSTOMIZER_URI', TG_TEMPLATE_URI . '/core/customizer');
define('TG_CUSTOMIZER_DIR', TG_TEMPLATE_DIR . '/core/customizer');

/**
 *      Load Customizer Support
 **/
require_once TG_TEMPLATE_DIR . '/core/customizer/init.php';

/**
 * TGM Plugin Activation
 */
{
    require_once dirname(__FILE__) . '/TGM-Plugin-Activation/class-tgm-plugin-activation.php';

    /** @internal */
    function tg_theme_register_required_plugins()
    {
        tgmpa(array(
            array(
                'name' => 'Kirki Toolkit',
                'slug' => 'kirki',
                'required' => true,
                'force_activation' => true,
            ),
        ));
    }

    add_action('tgmpa_register', 'tg_theme_register_required_plugins');
}

/**
 *      Init theme
 **/
if (!function_exists('tg_setup')) {

    function tg_setup()
    {
        /**
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
        add_theme_support('html5', array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
        ));

        /**
         * Enable support for Post Formats.
         * See https://developer.wordpress.org/themes/functionality/post-formats/
         */
        add_theme_support('post-formats', array(
            'aside',
            'image',
            'video',
            'quote',
            'link',
        ));

        /**
         * Add support for Title Tags
         */
        add_theme_support('title-tag');

        /**
         * Add support for widgets inside the customizer
         */
        add_theme_support('widget-customizer');

        /**
         * Add support for featured images
         */
        add_theme_support('post-thumbnails');

        /**
         * Add theme support
         */

        // Automatic Feed Links
        add_theme_support('automatic-feed-links');

        /**
         * Register nav menus
         */
        register_nav_menus(array(
            TG_THEME_SLUG . '-primary' => __('Header Menu', 'layerswp'),
            TG_THEME_SLUG . '-footer' => __('Footer Menu', 'layerswp'),
        ));

    } // function tg_setup
} // if !function tg_setup
add_action('after_setup_theme', 'tg_setup', 10);

/**
 * Enqueue styles.
 *
 * @since 1.0.0
 */
function tg_styles() {
    // Load our main stylesheet.
    wp_enqueue_style('tg-style', get_stylesheet_uri());
}
add_action('wp_enqueue_scripts', 'tg_styles');

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';