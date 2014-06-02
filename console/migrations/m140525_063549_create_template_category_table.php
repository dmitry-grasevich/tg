<?php

use yii\db\Schema;

class m140525_063549_create_template_category_table extends \yii\db\Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%template_category}}', [
            'id' => 'pk',
            'name' => Schema::TYPE_STRING . ' NOT NULL',
            'is_basic' => Schema::TYPE_BOOLEAN . ' DEFAULT "0"',
        ], $tableOptions);

        $this->createTable('{{%template}}', [
            'id' => 'pk',
            'category_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'name' => Schema::TYPE_STRING . ' NOT NULL',
            'filename' => Schema::TYPE_STRING . ' NOT NULL',
            'directory' => Schema::TYPE_STRING . ' DEFAULT ""',
            'img' => Schema::TYPE_STRING,
            'code' => Schema::TYPE_TEXT,
        ], $tableOptions);

        $this->createTable('{{%css}}', [
            'id' => 'pk',
            'name' => Schema::TYPE_STRING . ' NOT NULL',
            'code' => Schema::TYPE_TEXT,
            'filename' => Schema::TYPE_STRING,
            'directory' => Schema::TYPE_STRING . ' DEFAULT ""',
        ], $tableOptions);

        $this->createTable('{{%js}}', [
            'id' => 'pk',
            'name' => Schema::TYPE_STRING . ' NOT NULL',
            'code' => Schema::TYPE_TEXT,
            'filename' => Schema::TYPE_STRING,
            'directory' => Schema::TYPE_STRING . ' DEFAULT ""',
        ], $tableOptions);

        $this->createTable('{{%template_css}}', [
            'id' => 'pk',
            'template_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'css_id' => Schema::TYPE_INTEGER . ' NOT NULL',
        ], $tableOptions);

        $this->createTable('{{%template_js}}', [
            'id' => 'pk',
            'template_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'js_id' => Schema::TYPE_INTEGER . ' NOT NULL',
        ], $tableOptions);

        $this->insert('{{%template_category}}', [
            'id' => '1',
            'name' => 'Skeleton',
            'is_basic' => 1
        ]);

        $this->insert('{{%template}}', [
            'id' => 1,
            'category_id' => 1,
            'name' => 'Common Index',
            'filename' => 'index.php',
            'code' => '<?php get_header(); ?>
    <div id="main">
        <div id="content">
            <h1>Main Area</h1>
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <h1><?php the_title(); ?></h1>
                <h4>Posted on <?php the_time("F jS, Y") ?></h4>
                <p><?php the_content(__("(more...)")); ?></p>
                <hr> <?php endwhile; else: ?>
                <p><?php _e("Sorry, no posts matched your criteria."); ?></p>
            <?php endif; ?>
        </div>
    </div>
    <div id="delimiter"></div>
<?php get_footer(); ?>'
        ]);

        $this->insert('{{%template}}', [
            'id' => 2,
            'category_id' => 1,
            'name' => 'Common Header',
            'filename' => 'header.php',
            'code' => '<!DOCTYPE html>
<!--[if IE 8]> <html <?php language_attributes(); ?> class="ie8"> <![endif]-->
<!--[if !IE]><!--> <html <?php language_attributes(); ?>> <!--<![endif]-->
<head>
    <meta charset="<?php bloginfo("charset"); ?>">
    <title><?php wp_title("|", true, "right"); ?><?php bloginfo("name"); ?></title>
    <meta name="description" content="<?php bloginfo("description"); ?>">
    <meta name="author" content="">

    <!-- Mobile Specific Meta -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <!-- Google Web Font -->
    <link href="http://fonts.googleapis.com/css?family=Bree+Serif" rel="stylesheet">

    <!-- Stylesheets -->
    <link rel="stylesheet" href="<?php bloginfo("stylesheet_url"); ?>" />

    <!-- Pingbacks -->
    <link rel="pingback" href="<?php bloginfo("pingback_url"); ?>" />

    <!--[if lt IE 9]>
        <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Favicon and Apple Icons -->
    <link rel="shortcut icon" href="<?php print IMAGES; ?>/icons/favicon.ico">
    <link rel="apple-touch-icon" href="<?php print IMAGES; ?>/icons/apple-touch-icon.png">
    <link rel="apple-touch-icon" sizes="72x72" href="<?php print IMAGES; ?>/icons/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="114x114" href="<?php print IMAGES; ?>/icons/apple-touch-icon-114x114.png">

<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>'
        ]);

        $this->insert('{{%template}}', [
            'id' => 3,
            'category_id' => 1,
            'name' => 'Common Footer',
            'filename' => 'footer.php',
            'code' => '    <?php wp_footer(); ?>
    </body>
</html>'
        ]);

        $this->insert('{{%css}}', [
            'id' => 1,
            'name' => 'Common Styles',
            'filename' => 'style.css',
            'code' => "/*
Theme Name: Template Generator
Theme URI: http://www.template-generator.com
Author: Template Generator Team
Author URI:
Description: Theme for Wordpress.
Version: 1.0
License: GNU General Public License v2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Tags: black, brown, orange, tan, white, yellow, light, one-page

This theme, like WordPress, is licensed under the GPL.
Use it to make something cool, have fun, and share what you've learned with others.
*/

body { text-align: center; }
#wrapper { display: block; border: 1px #a2a2a2 solid; width:90%; margin:0px auto; }
#header { border: 2px #a2a2a2 solid; }
#content { width: 100%; border: 2px #a2a2a2 solid; }
#delimiter { clear: both; }
#footer { border: 2px #a2a2a2 solid; }
.title { font-size: 11pt; font-family: verdana; font-weight: bold; }
"
        ]);

        $this->insert('{{%template_css}}', [
            'template_id' => 1,
            'css_id' => 1,
        ]);

        $this->addForeignKey('fk_template_template_category', '{{%template}}', 'category_id', '{{%template_category}}', 'id', 'cascade');
        $this->addForeignKey('fk_template_css_template', '{{%template_css}}', 'template_id', '{{%template}}', 'id', 'cascade');
        $this->addForeignKey('fk_template_js_template', '{{%template_js}}', 'template_id', '{{%template}}', 'id', 'cascade');
        $this->addForeignKey('fk_template_css_css', '{{%template_css}}', 'css_id', '{{%css}}', 'id', 'cascade');
        $this->addForeignKey('fk_template_js_js', '{{%template_js}}', 'js_id', '{{%js}}', 'id', 'cascade');
    }

    public function down()
    {
        $this->dropForeignKey('fk_template_template_category', '{{%template}}');
        $this->dropForeignKey('fk_template_css_template', '{{%template_css}}');
        $this->dropForeignKey('fk_template_js_template', '{{%template_js}}');
        $this->dropForeignKey('fk_template_css_css', '{{%template_css}}');
        $this->dropForeignKey('fk_template_js_js', '{{%template_js}}');


        $this->dropTable('{{%template_js}}');
        $this->dropTable('{{%template_css}}');
        $this->dropTable('{{%js}}');
        $this->dropTable('{{%css}}');
        $this->dropTable('{{%template}}');
        $this->dropTable('{{%template_category}}');
    }
}
