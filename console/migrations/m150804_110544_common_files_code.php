<?php

use yii\db\Schema;
use yii\db\Migration;

class m150804_110544_common_files_code extends Migration
{
    public function up()
    {
        $this->update('{{%common_file}}', [
            'code' => "@charset \"UTF-8\";
/*
Theme Name: {{name}} by Template Generator
Theme URI: http://www.templates-generator.com
Author: Template Generator Team
Author URI:
Description: Theme for Wordpress.
Version: 1.0.0
License: GNU General Public License v2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

@import url('css/bootstrap.min.css');
@import url('css/theme.css');
",
        ], ['filename' => 'style.css']);

        $this->update('{{%common_file}}', [
            'code' => '<?php get_header(); ?>

    <?php
        $order = get_theme_mod(\'tg-sections-order-sorter\');
        $sections = maybe_unserialize($order);
        foreach ($sections as $section) {
            get_template_part(\'partials/section\', $section);
        }
    ?>

    <?php if (have_posts()) : while(have_posts()) : the_post(); ?>
        <?php get_template_part(\'content\', get_post_format()); ?>
     <?php endwhile; else : ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(\'no-posts\'); ?>>
            <h1><?php _e(\'No posts were found.\', \'tg\'); ?></h1>
        </article>
    <?php endif; ?>

<?php get_footer(); ?>',
        ], ['filename' => 'index.php']);

        $this->update('{{%common_file}}', [
            'code' => '<!DOCTYPE html>
<!--[if IE 8]> <html <?php language_attributes(); ?> class="ie8"> <![endif]-->
<!--[if !IE]><!--> <html <?php language_attributes(); ?>> <!--<![endif]-->
<head>
    <meta charset="<?php bloginfo("charset"); ?>">
    <title><?php wp_title("|", true, "right"); ?><?php bloginfo("name"); ?></title>
    <meta name="description" content="<?php bloginfo("description"); ?>">
    <meta name="author" content="Template Generator Team">

    <!-- Mobile Specific Meta -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <!-- Pingbacks -->
    <link rel="pingback" href="<?php bloginfo("pingback_url"); ?>" />

    <!--[if lt IE 9]>
        <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
',
        ], ['filename' => 'header.php']);

        $this->update('{{%common_file}}', [
            'code' => "<?php

if (__FILE__ == \$_SERVER['SCRIPT_FILENAME']) {
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
         * Add support for HTML5
         */
        add_theme_support('html5');

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
",
        ], ['filename' => 'functions.php']);

        $this->update('{{%common_file}}', [
            'code' => '    <?php wp_footer(); ?>
    </body>
</html>
',
        ], ['filename' => 'footer.php']);
    }

    public function down()
    {
        $this->update('{{%common_file}}', ['code' => ''], ['filename' => 'style.css']);
        $this->update('{{%common_file}}', ['code' => ''], ['filename' => 'index.php']);
        $this->update('{{%common_file}}', ['code' => ''], ['filename' => 'header.php']);
        $this->update('{{%common_file}}', ['code' => ''], ['filename' => 'functions.php']);
        $this->update('{{%common_file}}', ['code' => ''], ['filename' => 'footer.php']);
    }
}
