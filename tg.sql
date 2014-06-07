-- phpMyAdmin SQL Dump
-- version 4.2.0
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 07, 2014 at 09:00 PM
-- Server version: 5.6.17
-- PHP Version: 5.4.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `tg`
--

-- --------------------------------------------------------

--
-- Table structure for table `css`
--

CREATE TABLE IF NOT EXISTS `css` (
`id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` text,
  `filename` varchar(255) DEFAULT NULL,
  `directory` varchar(255) DEFAULT ''
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `functions`
--

CREATE TABLE IF NOT EXISTS `functions` (
`id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` text
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `functions`
--

INSERT INTO `functions` (`id`, `name`, `code`) VALUES
(1, 'Define Constants', 'define(''THEMEROOT'', get_stylesheet_directory_url());\ndefine(''IMAGES'', THEMEROOT . ''/images'');');

-- --------------------------------------------------------

--
-- Table structure for table `image`
--

CREATE TABLE IF NOT EXISTS `image` (
`id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `filename` varchar(255) DEFAULT NULL,
  `directory` varchar(255) DEFAULT ''
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `image`
--

INSERT INTO `image` (`id`, `name`, `filename`, `directory`) VALUES
(1, 'Logo 1', 'logo.png', ''),
(2, 'Color Stripe', 'color-stripe.jpg', ''),
(3, 'Pattern 1', 'pattern.jpg', '');

-- --------------------------------------------------------

--
-- Table structure for table `js`
--

CREATE TABLE IF NOT EXISTS `js` (
`id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` text,
  `filename` varchar(255) DEFAULT NULL,
  `directory` varchar(255) DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `migration`
--

CREATE TABLE IF NOT EXISTS `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1400967380),
('m130524_201442_init', 1401621161),
('m140525_063549_create_template_category_table', 1401621165),
('m140528_183554_create_functions', 1401621167),
('m140604_152628_related_template_create', 1401906189),
('m140606_084648_image_create', 1402081957);

-- --------------------------------------------------------

--
-- Table structure for table `related_template`
--

CREATE TABLE IF NOT EXISTS `related_template` (
`id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `child_id` int(11) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=30 ;

--
-- Dumping data for table `related_template`
--

INSERT INTO `related_template` (`id`, `parent_id`, `child_id`) VALUES
(27, 2, 4),
(28, 2, 5);

-- --------------------------------------------------------

--
-- Table structure for table `template`
--

CREATE TABLE IF NOT EXISTS `template` (
`id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `directory` varchar(255) DEFAULT '',
  `img` varchar(255) DEFAULT NULL,
  `code` text
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `template`
--

INSERT INTO `template` (`id`, `category_id`, `name`, `filename`, `directory`, `img`, `code`) VALUES
(1, 1, 'Common Index', 'index.php', '', '', '<?php get_header(); ?>\r\n    <div id="main">\r\n        <div id="content">\r\n            <h1>Main Area</h1>\r\n            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>\r\n                <h1><?php the_title(); ?></h1>\r\n                <h4>Posted on <?php the_time("F jS, Y") ?></h4>\r\n                <p><?php the_content(__("(more...)")); ?></p>\r\n                <hr> <?php endwhile; else: ?>\r\n                <p><?php _e("Sorry, no posts matched your criteria."); ?></p>\r\n            <?php endif; ?>\r\n        </div>\r\n    </div>\r\n    <div id="delimiter"></div>\r\n<?php get_footer(); ?>'),
(2, 1, 'Common Header', 'header.php', '', '', '<!DOCTYPE html>\r\n<!--[if IE 8]> <html <?php language_attributes(); ?> class="ie8"> <![endif]-->\r\n<!--[if !IE]><!--> <html <?php language_attributes(); ?>> <!--<![endif]-->\r\n<head>\r\n    <meta charset="<?php bloginfo("charset"); ?>">\r\n    <title><?php wp_title("|", true, "right"); ?><?php bloginfo("name"); ?></title>\r\n    <meta name="description" content="<?php bloginfo("description"); ?>">\r\n    <meta name="author" content="Template Generator Team">\r\n\r\n    <!-- Mobile Specific Meta -->\r\n    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">\r\n\r\n    <!-- Stylesheets -->\r\n    <link rel="stylesheet" href="<?php bloginfo("stylesheet_url"); ?>" />\r\n    <!-- Google Web Font -->\r\n    <link href="http://fonts.googleapis.com/css?family=Bitter:400,700" rel="stylesheet">\r\n    <link href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,600,300italic,600italic" rel="stylesheet">\r\n\r\n    <!-- Pingbacks -->\r\n    <link rel="pingback" href="<?php bloginfo("pingback_url"); ?>" />\r\n\r\n    <!--[if lt IE 9]>\r\n        <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>\r\n    <![endif]-->\r\n\r\n<?php wp_head(); ?>\r\n</head>\r\n<body <?php body_class(); ?>>'),
(3, 1, 'Common Footer', 'footer.php', '', '', '    <?php wp_footer(); ?>\r\n    </body>\r\n</html>'),
(4, 2, 'Header 1', '', '', '', '    <!-- HEADER -->\r\n    <header class="main-header section-content align-center">\r\n        <a href="<?php echo home_url(); ?>" class="logo"><img src="<?php print IMAGES; ?>/logo.png" alt="<?php bloginfo(''name''); ?>" /></a>\r\n        \r\n        <nav class="main-nav">\r\n            <?php \r\n            wp_nav_menu(array(\r\n                ''theme_location'' => ''main-menu'',\r\n                ''container'' => '''',\r\n                ''menu_class'' => ''inline''\r\n            ));\r\n            ?>\r\n        </nav>\r\n    </header>'),
(5, 2, 'Header 2', '', '', '', '<h1>Header #2</h1>'),
(6, 1, 'Common Functions', 'functions.php', '', '', '<?php\r\n\r\n/***********************************************************************************************/\r\n/* 	Define Constants */\r\n/***********************************************************************************************/\r\ndefine(''THEMEROOT'', get_stylesheet_directory_uri());\r\ndefine(''IMAGES'', THEMEROOT . ''/images'');\r\n\r\n\r\n/***********************************************************************************************/\r\n/* Add Menus */\r\n/***********************************************************************************************/\r\nfunction register_my_menus() {\r\n	register_nav_menus(array(\r\n		''main-menu'' => ''Main Menu'',\r\n		''category-menu'' => ''Category Menu''\r\n	));\r\n}\r\n\r\nadd_action(''init'', ''register_my_menus'');\r\n\r\n\r\n'),
(15, 1, 'Common Styles', 'style.css', '', '', '/*\r\nTheme Name: Template Generator\r\nTheme URI: http://www.template-generator.com\r\nAuthor: Template Generator Team\r\nAuthor URI:\r\nDescription: Theme for Wordpress.\r\nVersion: 1.0\r\nLicense: GNU General Public License v2 or later\r\nLicense URI: http://www.gnu.org/licenses/gpl-2.0.html\r\nTags: black, brown, orange, tan, white, yellow, light, one-page\r\n*/\r\n\r\n.clearfix {\r\n  *zoom: 1;\r\n}\r\n.clearfix:before,\r\n.clearfix:after {\r\n  display: table;\r\n  content: "";\r\n  line-height: 0;\r\n}\r\n.clearfix:after {\r\n  clear: both;\r\n}\r\n.hide-text {\r\n  font: 0/0 a;\r\n  color: transparent;\r\n  text-shadow: none;\r\n  background-color: transparent;\r\n  border: 0;\r\n}\r\n.input-block-level {\r\n  display: block;\r\n  width: 100%;\r\n  min-height: 30px;\r\n  -webkit-box-sizing: border-box;\r\n  -moz-box-sizing: border-box;\r\n  box-sizing: border-box;\r\n}\r\n.row {\r\n  margin-left: -20px;\r\n  *zoom: 1;\r\n}\r\n.row:before,\r\n.row:after {\r\n  display: table;\r\n  content: "";\r\n  line-height: 0;\r\n}\r\n.row:after {\r\n  clear: both;\r\n}\r\n[class*="span"] {\r\n  float: left;\r\n  min-height: 1px;\r\n  margin-left: 20px;\r\n}\r\n.container,\r\n.navbar-static-top .container,\r\n.navbar-fixed-top .container,\r\n.navbar-fixed-bottom .container {\r\n  width: 940px;\r\n}\r\n.span12 {\r\n  width: 940px;\r\n}\r\n.span11 {\r\n  width: 860px;\r\n}\r\n.span10 {\r\n  width: 780px;\r\n}\r\n.span9 {\r\n  width: 700px;\r\n}\r\n.span8 {\r\n  width: 620px;\r\n}\r\n.span7 {\r\n  width: 540px;\r\n}\r\n.span6 {\r\n  width: 460px;\r\n}\r\n.span5 {\r\n  width: 380px;\r\n}\r\n.span4 {\r\n  width: 300px;\r\n}\r\n.span3 {\r\n  width: 220px;\r\n}\r\n.span2 {\r\n  width: 140px;\r\n}\r\n.span1 {\r\n  width: 60px;\r\n}\r\n.offset12 {\r\n  margin-left: 980px;\r\n}\r\n.offset11 {\r\n  margin-left: 900px;\r\n}\r\n.offset10 {\r\n  margin-left: 820px;\r\n}\r\n.offset9 {\r\n  margin-left: 740px;\r\n}\r\n.offset8 {\r\n  margin-left: 660px;\r\n}\r\n.offset7 {\r\n  margin-left: 580px;\r\n}\r\n.offset6 {\r\n  margin-left: 500px;\r\n}\r\n.offset5 {\r\n  margin-left: 420px;\r\n}\r\n.offset4 {\r\n  margin-left: 340px;\r\n}\r\n.offset3 {\r\n  margin-left: 260px;\r\n}\r\n.offset2 {\r\n  margin-left: 180px;\r\n}\r\n.offset1 {\r\n  margin-left: 100px;\r\n}\r\n.row-fluid {\r\n  width: 100%;\r\n  *zoom: 1;\r\n}\r\n.row-fluid:before,\r\n.row-fluid:after {\r\n  display: table;\r\n  content: "";\r\n  line-height: 0;\r\n}\r\n.row-fluid:after {\r\n  clear: both;\r\n}\r\n.row-fluid [class*="span"] {\r\n  display: block;\r\n  width: 100%;\r\n  min-height: 30px;\r\n  -webkit-box-sizing: border-box;\r\n  -moz-box-sizing: border-box;\r\n  box-sizing: border-box;\r\n  float: left;\r\n  margin-left: 2.127659574468085%;\r\n  *margin-left: 2.074468085106383%;\r\n}\r\n.row-fluid [class*="span"]:first-child {\r\n  margin-left: 0;\r\n}\r\n.row-fluid .controls-row [class*="span"] + [class*="span"] {\r\n  margin-left: 2.127659574468085%;\r\n}\r\n.row-fluid .span12 {\r\n  width: 100%;\r\n  *width: 99.94680851063829%;\r\n}\r\n.row-fluid .span11 {\r\n  width: 91.48936170212765%;\r\n  *width: 91.43617021276594%;\r\n}\r\n.row-fluid .span10 {\r\n  width: 82.97872340425532%;\r\n  *width: 82.92553191489361%;\r\n}\r\n.row-fluid .span9 {\r\n  width: 74.46808510638297%;\r\n  *width: 74.41489361702126%;\r\n}\r\n.row-fluid .span8 {\r\n  width: 65.95744680851064%;\r\n  *width: 65.90425531914893%;\r\n}\r\n.row-fluid .span7 {\r\n  width: 57.44680851063829%;\r\n  *width: 57.39361702127659%;\r\n}\r\n.row-fluid .span6 {\r\n  width: 48.93617021276595%;\r\n  *width: 48.88297872340425%;\r\n}\r\n.row-fluid .span5 {\r\n  width: 40.42553191489362%;\r\n  *width: 40.37234042553192%;\r\n}\r\n.row-fluid .span4 {\r\n  width: 31.914893617021278%;\r\n  *width: 31.861702127659576%;\r\n}\r\n.row-fluid .span3 {\r\n  width: 23.404255319148934%;\r\n  *width: 23.351063829787233%;\r\n}\r\n.row-fluid .span2 {\r\n  width: 14.893617021276595%;\r\n  *width: 14.840425531914894%;\r\n}\r\n.row-fluid .span1 {\r\n  width: 6.382978723404255%;\r\n  *width: 6.329787234042553%;\r\n}\r\n.row-fluid .offset12 {\r\n  margin-left: 104.25531914893617%;\r\n  *margin-left: 104.14893617021275%;\r\n}\r\n.row-fluid .offset12:first-child {\r\n  margin-left: 102.12765957446808%;\r\n  *margin-left: 102.02127659574467%;\r\n}\r\n.row-fluid .offset11 {\r\n  margin-left: 95.74468085106382%;\r\n  *margin-left: 95.6382978723404%;\r\n}\r\n.row-fluid .offset11:first-child {\r\n  margin-left: 93.61702127659574%;\r\n  *margin-left: 93.51063829787232%;\r\n}\r\n.row-fluid .offset10 {\r\n  margin-left: 87.23404255319149%;\r\n  *margin-left: 87.12765957446807%;\r\n}\r\n.row-fluid .offset10:first-child {\r\n  margin-left: 85.1063829787234%;\r\n  *margin-left: 84.99999999999999%;\r\n}\r\n.row-fluid .offset9 {\r\n  margin-left: 78.72340425531914%;\r\n  *margin-left: 78.61702127659572%;\r\n}\r\n.row-fluid .offset9:first-child {\r\n  margin-left: 76.59574468085106%;\r\n  *margin-left: 76.48936170212764%;\r\n}\r\n.row-fluid .offset8 {\r\n  margin-left: 70.2127659574468%;\r\n  *margin-left: 70.10638297872339%;\r\n}\r\n.row-fluid .offset8:first-child {\r\n  margin-left: 68.08510638297872%;\r\n  *margin-left: 67.9787234042553%;\r\n}\r\n.row-fluid .offset7 {\r\n  margin-left: 61.70212765957446%;\r\n  *margin-left: 61.59574468085106%;\r\n}\r\n.row-fluid .offset7:first-child {\r\n  margin-left: 59.574468085106375%;\r\n  *margin-left: 59.46808510638297%;\r\n}\r\n.row-fluid .offset6 {\r\n  margin-left: 53.191489361702125%;\r\n  *margin-left: 53.085106382978715%;\r\n}\r\n.row-fluid .offset6:first-child {\r\n  margin-left: 51.063829787234035%;\r\n  *margin-left: 50.95744680851063%;\r\n}\r\n.row-fluid .offset5 {\r\n  margin-left: 44.68085106382979%;\r\n  *margin-left: 44.57446808510638%;\r\n}\r\n.row-fluid .offset5:first-child {\r\n  margin-left: 42.5531914893617%;\r\n  *margin-left: 42.4468085106383%;\r\n}\r\n.row-fluid .offset4 {\r\n  margin-left: 36.170212765957444%;\r\n  *margin-left: 36.06382978723405%;\r\n}\r\n.row-fluid .offset4:first-child {\r\n  margin-left: 34.04255319148936%;\r\n  *margin-left: 33.93617021276596%;\r\n}\r\n.row-fluid .offset3 {\r\n  margin-left: 27.659574468085104%;\r\n  *margin-left: 27.5531914893617%;\r\n}\r\n.row-fluid .offset3:first-child {\r\n  margin-left: 25.53191489361702%;\r\n  *margin-left: 25.425531914893618%;\r\n}\r\n.row-fluid .offset2 {\r\n  margin-left: 19.148936170212764%;\r\n  *margin-left: 19.04255319148936%;\r\n}\r\n.row-fluid .offset2:first-child {\r\n  margin-left: 17.02127659574468%;\r\n  *margin-left: 16.914893617021278%;\r\n}\r\n.row-fluid .offset1 {\r\n  margin-left: 10.638297872340425%;\r\n  *margin-left: 10.53191489361702%;\r\n}\r\n.row-fluid .offset1:first-child {\r\n  margin-left: 8.51063829787234%;\r\n  *margin-left: 8.404255319148938%;\r\n}\r\n[class*="span"].hide,\r\n.row-fluid [class*="span"].hide {\r\n  display: none;\r\n}\r\n[class*="span"].pull-right,\r\n.row-fluid [class*="span"].pull-right {\r\n  float: right;\r\n}\r\n.container {\r\n  margin-right: auto;\r\n  margin-left: auto;\r\n  *zoom: 1;\r\n}\r\n.container:before,\r\n.container:after {\r\n  display: table;\r\n  content: "";\r\n  line-height: 0;\r\n}\r\n.container:after {\r\n  clear: both;\r\n}\r\n.container-fluid {\r\n  padding-right: 20px;\r\n  padding-left: 20px;\r\n  *zoom: 1;\r\n}\r\n.container-fluid:before,\r\n.container-fluid:after {\r\n  display: table;\r\n  content: "";\r\n  line-height: 0;\r\n}\r\n.container-fluid:after {\r\n  clear: both;\r\n}\r\n@media (max-width: 767px) {\r\n  body {\r\n    padding-left: 20px;\r\n    padding-right: 20px;\r\n  }\r\n  .navbar-fixed-top,\r\n  .navbar-fixed-bottom,\r\n  .navbar-static-top {\r\n    margin-left: -20px;\r\n    margin-right: -20px;\r\n  }\r\n  .container-fluid {\r\n    padding: 0;\r\n  }\r\n  .dl-horizontal dt {\r\n    float: none;\r\n    clear: none;\r\n    width: auto;\r\n    text-align: left;\r\n  }\r\n  .dl-horizontal dd {\r\n    margin-left: 0;\r\n  }\r\n  .container {\r\n    width: auto;\r\n  }\r\n  .row-fluid {\r\n    width: 100%;\r\n  }\r\n  .row,\r\n  .thumbnails {\r\n    margin-left: 0;\r\n  }\r\n  .thumbnails > li {\r\n    float: none;\r\n    margin-left: 0;\r\n  }\r\n  [class*="span"],\r\n  .uneditable-input[class*="span"],\r\n  .row-fluid [class*="span"] {\r\n    float: none;\r\n    display: block;\r\n    width: 100%;\r\n    margin-left: 0;\r\n    -webkit-box-sizing: border-box;\r\n    -moz-box-sizing: border-box;\r\n    box-sizing: border-box;\r\n  }\r\n  .span12,\r\n  .row-fluid .span12 {\r\n    width: 100%;\r\n    -webkit-box-sizing: border-box;\r\n    -moz-box-sizing: border-box;\r\n    box-sizing: border-box;\r\n  }\r\n  .row-fluid [class*="offset"]:first-child {\r\n    margin-left: 0;\r\n  }\r\n  .input-large,\r\n  .input-xlarge,\r\n  .input-xxlarge,\r\n  input[class*="span"],\r\n  select[class*="span"],\r\n  textarea[class*="span"],\r\n  .uneditable-input {\r\n    display: block;\r\n    width: 100%;\r\n    min-height: 30px;\r\n    -webkit-box-sizing: border-box;\r\n    -moz-box-sizing: border-box;\r\n    box-sizing: border-box;\r\n  }\r\n  .input-prepend input,\r\n  .input-append input,\r\n  .input-prepend input[class*="span"],\r\n  .input-append input[class*="span"] {\r\n    display: inline-block;\r\n    width: auto;\r\n  }\r\n  .controls-row [class*="span"] + [class*="span"] {\r\n    margin-left: 0;\r\n  }\r\n  .modal {\r\n    position: fixed;\r\n    top: 20px;\r\n    left: 20px;\r\n    right: 20px;\r\n    width: auto;\r\n    margin: 0;\r\n  }\r\n  .modal.fade {\r\n    top: -100px;\r\n  }\r\n  .modal.fade.in {\r\n    top: 20px;\r\n  }\r\n}\r\n@media (max-width: 480px) {\r\n  .nav-collapse {\r\n    -webkit-transform: translate3d(0, 0, 0);\r\n  }\r\n  .page-header h1 small {\r\n    display: block;\r\n    line-height: 20px;\r\n  }\r\n  input[type="checkbox"],\r\n  input[type="radio"] {\r\n    border: 1px solid #ccc;\r\n  }\r\n  .form-horizontal .control-label {\r\n    float: none;\r\n    width: auto;\r\n    padding-top: 0;\r\n    text-align: left;\r\n  }\r\n  .form-horizontal .controls {\r\n    margin-left: 0;\r\n  }\r\n  .form-horizontal .control-list {\r\n    padding-top: 0;\r\n  }\r\n  .form-horizontal .form-actions {\r\n    padding-left: 10px;\r\n    padding-right: 10px;\r\n  }\r\n  .media .pull-left,\r\n  .media .pull-right {\r\n    float: none;\r\n    display: block;\r\n    margin-bottom: 10px;\r\n  }\r\n  .media-object {\r\n    margin-right: 0;\r\n    margin-left: 0;\r\n  }\r\n  .modal {\r\n    top: 10px;\r\n    left: 10px;\r\n    right: 10px;\r\n  }\r\n  .modal-header .close {\r\n    padding: 10px;\r\n    margin: -10px;\r\n  }\r\n  .carousel-caption {\r\n    position: static;\r\n  }\r\n}\r\n@media (min-width: 768px) and (max-width: 979px) {\r\n  .row {\r\n    margin-left: -20px;\r\n    *zoom: 1;\r\n  }\r\n  .row:before,\r\n  .row:after {\r\n    display: table;\r\n    content: "";\r\n    line-height: 0;\r\n  }\r\n  .row:after {\r\n    clear: both;\r\n  }\r\n  [class*="span"] {\r\n    float: left;\r\n    min-height: 1px;\r\n    margin-left: 20px;\r\n  }\r\n  .container,\r\n  .navbar-static-top .container,\r\n  .navbar-fixed-top .container,\r\n  .navbar-fixed-bottom .container {\r\n    width: 724px;\r\n  }\r\n  .span12 {\r\n    width: 724px;\r\n  }\r\n  .span11 {\r\n    width: 662px;\r\n  }\r\n  .span10 {\r\n    width: 600px;\r\n  }\r\n  .span9 {\r\n    width: 538px;\r\n  }\r\n  .span8 {\r\n    width: 476px;\r\n  }\r\n  .span7 {\r\n    width: 414px;\r\n  }\r\n  .span6 {\r\n    width: 352px;\r\n  }\r\n  .span5 {\r\n    width: 290px;\r\n  }\r\n  .span4 {\r\n    width: 228px;\r\n  }\r\n  .span3 {\r\n    width: 166px;\r\n  }\r\n  .span2 {\r\n    width: 104px;\r\n  }\r\n  .span1 {\r\n    width: 42px;\r\n  }\r\n  .offset12 {\r\n    margin-left: 764px;\r\n  }\r\n  .offset11 {\r\n    margin-left: 702px;\r\n  }\r\n  .offset10 {\r\n    margin-left: 640px;\r\n  }\r\n  .offset9 {\r\n    margin-left: 578px;\r\n  }\r\n  .offset8 {\r\n    margin-left: 516px;\r\n  }\r\n  .offset7 {\r\n    margin-left: 454px;\r\n  }\r\n  .offset6 {\r\n    margin-left: 392px;\r\n  }\r\n  .offset5 {\r\n    margin-left: 330px;\r\n  }\r\n  .offset4 {\r\n    margin-left: 268px;\r\n  }\r\n  .offset3 {\r\n    margin-left: 206px;\r\n  }\r\n  .offset2 {\r\n    margin-left: 144px;\r\n  }\r\n  .offset1 {\r\n    margin-left: 82px;\r\n  }\r\n  .row-fluid {\r\n    width: 100%;\r\n    *zoom: 1;\r\n  }\r\n  .row-fluid:before,\r\n  .row-fluid:after {\r\n    display: table;\r\n    content: "";\r\n    line-height: 0;\r\n  }\r\n  .row-fluid:after {\r\n    clear: both;\r\n  }\r\n  .row-fluid [class*="span"] {\r\n    display: block;\r\n    width: 100%;\r\n    min-height: 30px;\r\n    -webkit-box-sizing: border-box;\r\n    -moz-box-sizing: border-box;\r\n    box-sizing: border-box;\r\n    float: left;\r\n    margin-left: 2.7624309392265194%;\r\n    *margin-left: 2.709239449864817%;\r\n  }\r\n  .row-fluid [class*="span"]:first-child {\r\n    margin-left: 0;\r\n  }\r\n  .row-fluid .controls-row [class*="span"] + [class*="span"] {\r\n    margin-left: 2.7624309392265194%;\r\n  }\r\n  .row-fluid .span12 {\r\n    width: 100%;\r\n    *width: 99.94680851063829%;\r\n  }\r\n  .row-fluid .span11 {\r\n    width: 91.43646408839778%;\r\n    *width: 91.38327259903608%;\r\n  }\r\n  .row-fluid .span10 {\r\n    width: 82.87292817679558%;\r\n    *width: 82.81973668743387%;\r\n  }\r\n  .row-fluid .span9 {\r\n    width: 74.30939226519337%;\r\n    *width: 74.25620077583166%;\r\n  }\r\n  .row-fluid .span8 {\r\n    width: 65.74585635359117%;\r\n    *width: 65.69266486422946%;\r\n  }\r\n  .row-fluid .span7 {\r\n    width: 57.18232044198895%;\r\n    *width: 57.12912895262725%;\r\n  }\r\n  .row-fluid .span6 {\r\n    width: 48.61878453038674%;\r\n    *width: 48.56559304102504%;\r\n  }\r\n  .row-fluid .span5 {\r\n    width: 40.05524861878453%;\r\n    *width: 40.00205712942283%;\r\n  }\r\n  .row-fluid .span4 {\r\n    width: 31.491712707182323%;\r\n    *width: 31.43852121782062%;\r\n  }\r\n  .row-fluid .span3 {\r\n    width: 22.92817679558011%;\r\n    *width: 22.87498530621841%;\r\n  }\r\n  .row-fluid .span2 {\r\n    width: 14.3646408839779%;\r\n    *width: 14.311449394616199%;\r\n  }\r\n  .row-fluid .span1 {\r\n    width: 5.801104972375691%;\r\n    *width: 5.747913483013988%;\r\n  }\r\n  .row-fluid .offset12 {\r\n    margin-left: 105.52486187845304%;\r\n    *margin-left: 105.41847889972962%;\r\n  }\r\n  .row-fluid .offset12:first-child {\r\n    margin-left: 102.76243093922652%;\r\n    *margin-left: 102.6560479605031%;\r\n  }\r\n  .row-fluid .offset11 {\r\n    margin-left: 96.96132596685082%;\r\n    *margin-left: 96.8549429881274%;\r\n  }\r\n  .row-fluid .offset11:first-child {\r\n    margin-left: 94.1988950276243%;\r\n    *margin-left: 94.09251204890089%;\r\n  }\r\n  .row-fluid .offset10 {\r\n    margin-left: 88.39779005524862%;\r\n    *margin-left: 88.2914070765252%;\r\n  }\r\n  .row-fluid .offset10:first-child {\r\n    margin-left: 85.6353591160221%;\r\n    *margin-left: 85.52897613729868%;\r\n  }\r\n  .row-fluid .offset9 {\r\n    margin-left: 79.8342541436464%;\r\n    *margin-left: 79.72787116492299%;\r\n  }\r\n  .row-fluid .offset9:first-child {\r\n    margin-left: 77.07182320441989%;\r\n    *margin-left: 76.96544022569647%;\r\n  }\r\n  .row-fluid .offset8 {\r\n    margin-left: 71.2707182320442%;\r\n    *margin-left: 71.16433525332079%;\r\n  }\r\n  .row-fluid .offset8:first-child {\r\n    margin-left: 68.50828729281768%;\r\n    *margin-left: 68.40190431409427%;\r\n  }\r\n  .row-fluid .offset7 {\r\n    margin-left: 62.70718232044199%;\r\n    *margin-left: 62.600799341718584%;\r\n  }\r\n  .row-fluid .offset7:first-child {\r\n    margin-left: 59.94475138121547%;\r\n    *margin-left: 59.838368402492065%;\r\n  }\r\n  .row-fluid .offset6 {\r\n    margin-left: 54.14364640883978%;\r\n    *margin-left: 54.037263430116376%;\r\n  }\r\n  .row-fluid .offset6:first-child {\r\n    margin-left: 51.38121546961326%;\r\n    *margin-left: 51.27483249088986%;\r\n  }\r\n  .row-fluid .offset5 {\r\n    margin-left: 45.58011049723757%;\r\n    *margin-left: 45.47372751851417%;\r\n  }\r\n  .row-fluid .offset5:first-child {\r\n    margin-left: 42.81767955801105%;\r\n    *margin-left: 42.71129657928765%;\r\n  }\r\n  .row-fluid .offset4 {\r\n    margin-left: 37.01657458563536%;\r\n    *margin-left: 36.91019160691196%;\r\n  }\r\n  .row-fluid .offset4:first-child {\r\n    margin-left: 34.25414364640884%;\r\n    *margin-left: 34.14776066768544%;\r\n  }\r\n  .row-fluid .offset3 {\r\n    margin-left: 28.45303867403315%;\r\n    *margin-left: 28.346655695309746%;\r\n  }\r\n  .row-fluid .offset3:first-child {\r\n    margin-left: 25.69060773480663%;\r\n    *margin-left: 25.584224756083227%;\r\n  }\r\n  .row-fluid .offset2 {\r\n    margin-left: 19.88950276243094%;\r\n    *margin-left: 19.783119783707537%;\r\n  }\r\n  .row-fluid .offset2:first-child {\r\n    margin-left: 17.12707182320442%;\r\n    *margin-left: 17.02068884448102%;\r\n  }\r\n  .row-fluid .offset1 {\r\n    margin-left: 11.32596685082873%;\r\n    *margin-left: 11.219583872105325%;\r\n  }\r\n  .row-fluid .offset1:first-child {\r\n    margin-left: 8.56353591160221%;\r\n    *margin-left: 8.457152932878806%;\r\n  }\r\n  input,\r\n  textarea,\r\n  .uneditable-input {\r\n    margin-left: 0;\r\n  }\r\n  .controls-row [class*="span"] + [class*="span"] {\r\n    margin-left: 20px;\r\n  }\r\n  input.span12,\r\n  textarea.span12,\r\n  .uneditable-input.span12 {\r\n    width: 710px;\r\n  }\r\n  input.span11,\r\n  textarea.span11,\r\n  .uneditable-input.span11 {\r\n    width: 648px;\r\n  }\r\n  input.span10,\r\n  textarea.span10,\r\n  .uneditable-input.span10 {\r\n    width: 586px;\r\n  }\r\n  input.span9,\r\n  textarea.span9,\r\n  .uneditable-input.span9 {\r\n    width: 524px;\r\n  }\r\n  input.span8,\r\n  textarea.span8,\r\n  .uneditable-input.span8 {\r\n    width: 462px;\r\n  }\r\n  input.span7,\r\n  textarea.span7,\r\n  .uneditable-input.span7 {\r\n    width: 400px;\r\n  }\r\n  input.span6,\r\n  textarea.span6,\r\n  .uneditable-input.span6 {\r\n    width: 338px;\r\n  }\r\n  input.span5,\r\n  textarea.span5,\r\n  .uneditable-input.span5 {\r\n    width: 276px;\r\n  }\r\n  input.span4,\r\n  textarea.span4,\r\n  .uneditable-input.span4 {\r\n    width: 214px;\r\n  }\r\n  input.span3,\r\n  textarea.span3,\r\n  .uneditable-input.span3 {\r\n    width: 152px;\r\n  }\r\n  input.span2,\r\n  textarea.span2,\r\n  .uneditable-input.span2 {\r\n    width: 90px;\r\n  }\r\n  input.span1,\r\n  textarea.span1,\r\n  .uneditable-input.span1 {\r\n    width: 28px;\r\n  }\r\n}\r\n@media (min-width: 1200px) {\r\n  .row {\r\n    margin-left: -30px;\r\n    *zoom: 1;\r\n  }\r\n  .row:before,\r\n  .row:after {\r\n    display: table;\r\n    content: "";\r\n    line-height: 0;\r\n  }\r\n  .row:after {\r\n    clear: both;\r\n  }\r\n  [class*="span"] {\r\n    float: left;\r\n    min-height: 1px;\r\n    margin-left: 30px;\r\n  }\r\n  .container,\r\n  .navbar-static-top .container,\r\n  .navbar-fixed-top .container,\r\n  .navbar-fixed-bottom .container {\r\n    width: 1170px;\r\n  }\r\n  .span12 {\r\n    width: 1170px;\r\n  }\r\n  .span11 {\r\n    width: 1070px;\r\n  }\r\n  .span10 {\r\n    width: 970px;\r\n  }\r\n  .span9 {\r\n    width: 870px;\r\n  }\r\n  .span8 {\r\n    width: 770px;\r\n  }\r\n  .span7 {\r\n    width: 670px;\r\n  }\r\n  .span6 {\r\n    width: 570px;\r\n  }\r\n  .span5 {\r\n    width: 470px;\r\n  }\r\n  .span4 {\r\n    width: 370px;\r\n  }\r\n  .span3 {\r\n    width: 270px;\r\n  }\r\n  .span2 {\r\n    width: 170px;\r\n  }\r\n  .span1 {\r\n    width: 70px;\r\n  }\r\n  .offset12 {\r\n    margin-left: 1230px;\r\n  }\r\n  .offset11 {\r\n    margin-left: 1130px;\r\n  }\r\n  .offset10 {\r\n    margin-left: 1030px;\r\n  }\r\n  .offset9 {\r\n    margin-left: 930px;\r\n  }\r\n  .offset8 {\r\n    margin-left: 830px;\r\n  }\r\n  .offset7 {\r\n    margin-left: 730px;\r\n  }\r\n  .offset6 {\r\n    margin-left: 630px;\r\n  }\r\n  .offset5 {\r\n    margin-left: 530px;\r\n  }\r\n  .offset4 {\r\n    margin-left: 430px;\r\n  }\r\n  .offset3 {\r\n    margin-left: 330px;\r\n  }\r\n  .offset2 {\r\n    margin-left: 230px;\r\n  }\r\n  .offset1 {\r\n    margin-left: 130px;\r\n  }\r\n  .row-fluid {\r\n    width: 100%;\r\n    *zoom: 1;\r\n  }\r\n  .row-fluid:before,\r\n  .row-fluid:after {\r\n    display: table;\r\n    content: "";\r\n    line-height: 0;\r\n  }\r\n  .row-fluid:after {\r\n    clear: both;\r\n  }\r\n  .row-fluid [class*="span"] {\r\n    display: block;\r\n    width: 100%;\r\n    min-height: 30px;\r\n    -webkit-box-sizing: border-box;\r\n    -moz-box-sizing: border-box;\r\n    box-sizing: border-box;\r\n    float: left;\r\n    margin-left: 2.564102564102564%;\r\n    *margin-left: 2.5109110747408616%;\r\n  }\r\n  .row-fluid [class*="span"]:first-child {\r\n    margin-left: 0;\r\n  }\r\n  .row-fluid .controls-row [class*="span"] + [class*="span"] {\r\n    margin-left: 2.564102564102564%;\r\n  }\r\n  .row-fluid .span12 {\r\n    width: 100%;\r\n    *width: 99.94680851063829%;\r\n  }\r\n  .row-fluid .span11 {\r\n    width: 91.45299145299145%;\r\n    *width: 91.39979996362975%;\r\n  }\r\n  .row-fluid .span10 {\r\n    width: 82.90598290598291%;\r\n    *width: 82.8527914166212%;\r\n  }\r\n  .row-fluid .span9 {\r\n    width: 74.35897435897436%;\r\n    *width: 74.30578286961266%;\r\n  }\r\n  .row-fluid .span8 {\r\n    width: 65.81196581196582%;\r\n    *width: 65.75877432260411%;\r\n  }\r\n  .row-fluid .span7 {\r\n    width: 57.26495726495726%;\r\n    *width: 57.21176577559556%;\r\n  }\r\n  .row-fluid .span6 {\r\n    width: 48.717948717948715%;\r\n    *width: 48.664757228587014%;\r\n  }\r\n  .row-fluid .span5 {\r\n    width: 40.17094017094017%;\r\n    *width: 40.11774868157847%;\r\n  }\r\n  .row-fluid .span4 {\r\n    width: 31.623931623931625%;\r\n    *width: 31.570740134569924%;\r\n  }\r\n  .row-fluid .span3 {\r\n    width: 23.076923076923077%;\r\n    *width: 23.023731587561375%;\r\n  }\r\n  .row-fluid .span2 {\r\n    width: 14.52991452991453%;\r\n    *width: 14.476723040552828%;\r\n  }\r\n  .row-fluid .span1 {\r\n    width: 5.982905982905983%;\r\n    *width: 5.929714493544281%;\r\n  }\r\n  .row-fluid .offset12 {\r\n    margin-left: 105.12820512820512%;\r\n    *margin-left: 105.02182214948171%;\r\n  }\r\n  .row-fluid .offset12:first-child {\r\n    margin-left: 102.56410256410257%;\r\n    *margin-left: 102.45771958537915%;\r\n  }\r\n  .row-fluid .offset11 {\r\n    margin-left: 96.58119658119658%;\r\n    *margin-left: 96.47481360247316%;\r\n  }\r\n  .row-fluid .offset11:first-child {\r\n    margin-left: 94.01709401709402%;\r\n    *margin-left: 93.91071103837061%;\r\n  }\r\n  .row-fluid .offset10 {\r\n    margin-left: 88.03418803418803%;\r\n    *margin-left: 87.92780505546462%;\r\n  }\r\n  .row-fluid .offset10:first-child {\r\n    margin-left: 85.47008547008548%;\r\n    *margin-left: 85.36370249136206%;\r\n  }\r\n  .row-fluid .offset9 {\r\n    margin-left: 79.48717948717949%;\r\n    *margin-left: 79.38079650845607%;\r\n  }\r\n  .row-fluid .offset9:first-child {\r\n    margin-left: 76.92307692307693%;\r\n    *margin-left: 76.81669394435352%;\r\n  }\r\n  .row-fluid .offset8 {\r\n    margin-left: 70.94017094017094%;\r\n    *margin-left: 70.83378796144753%;\r\n  }\r\n  .row-fluid .offset8:first-child {\r\n    margin-left: 68.37606837606839%;\r\n    *margin-left: 68.26968539734497%;\r\n  }\r\n  .row-fluid .offset7 {\r\n    margin-left: 62.393162393162385%;\r\n    *margin-left: 62.28677941443899%;\r\n  }\r\n  .row-fluid .offset7:first-child {\r\n    margin-left: 59.82905982905982%;\r\n    *margin-left: 59.72267685033642%;\r\n  }\r\n  .row-fluid .offset6 {\r\n    margin-left: 53.84615384615384%;\r\n    *margin-left: 53.739770867430444%;\r\n  }\r\n  .row-fluid .offset6:first-child {\r\n    margin-left: 51.28205128205128%;\r\n    *margin-left: 51.175668303327875%;\r\n  }\r\n  .row-fluid .offset5 {\r\n    margin-left: 45.299145299145295%;\r\n    *margin-left: 45.1927623204219%;\r\n  }\r\n  .row-fluid .offset5:first-child {\r\n    margin-left: 42.73504273504273%;\r\n    *margin-left: 42.62865975631933%;\r\n  }\r\n  .row-fluid .offset4 {\r\n    margin-left: 36.75213675213675%;\r\n    *margin-left: 36.645753773413354%;\r\n  }\r\n  .row-fluid .offset4:first-child {\r\n    margin-left: 34.18803418803419%;\r\n    *margin-left: 34.081651209310785%;\r\n  }\r\n  .row-fluid .offset3 {\r\n    margin-left: 28.205128205128204%;\r\n    *margin-left: 28.0987452264048%;\r\n  }\r\n  .row-fluid .offset3:first-child {\r\n    margin-left: 25.641025641025642%;\r\n    *margin-left: 25.53464266230224%;\r\n  }\r\n  .row-fluid .offset2 {\r\n    margin-left: 19.65811965811966%;\r\n    *margin-left: 19.551736679396257%;\r\n  }\r\n  .row-fluid .offset2:first-child {\r\n    margin-left: 17.094017094017094%;\r\n    *margin-left: 16.98763411529369%;\r\n  }\r\n  .row-fluid .offset1 {\r\n    margin-left: 11.11111111111111%;\r\n    *margin-left: 11.004728132387708%;\r\n  }\r\n  .row-fluid .offset1:first-child {\r\n    margin-left: 8.547008547008547%;\r\n    *margin-left: 8.440625568285142%;\r\n  }\r\n  input,\r\n  textarea,\r\n  .uneditable-input {\r\n    margin-left: 0;\r\n  }\r\n  .controls-row [class*="span"] + [class*="span"] {\r\n    margin-left: 30px;\r\n  }\r\n  input.span12,\r\n  textarea.span12,\r\n  .uneditable-input.span12 {\r\n    width: 1156px;\r\n  }\r\n  input.span11,\r\n  textarea.span11,\r\n  .uneditable-input.span11 {\r\n    width: 1056px;\r\n  }\r\n  input.span10,\r\n  textarea.span10,\r\n  .uneditable-input.span10 {\r\n    width: 956px;\r\n  }\r\n  input.span9,\r\n  textarea.span9,\r\n  .uneditable-input.span9 {\r\n    width: 856px;\r\n  }\r\n  input.span8,\r\n  textarea.span8,\r\n  .uneditable-input.span8 {\r\n    width: 756px;\r\n  }\r\n  input.span7,\r\n  textarea.span7,\r\n  .uneditable-input.span7 {\r\n    width: 656px;\r\n  }\r\n  input.span6,\r\n  textarea.span6,\r\n  .uneditable-input.span6 {\r\n    width: 556px;\r\n  }\r\n  input.span5,\r\n  textarea.span5,\r\n  .uneditable-input.span5 {\r\n    width: 456px;\r\n  }\r\n  input.span4,\r\n  textarea.span4,\r\n  .uneditable-input.span4 {\r\n    width: 356px;\r\n  }\r\n  input.span3,\r\n  textarea.span3,\r\n  .uneditable-input.span3 {\r\n    width: 256px;\r\n  }\r\n  input.span2,\r\n  textarea.span2,\r\n  .uneditable-input.span2 {\r\n    width: 156px;\r\n  }\r\n  input.span1,\r\n  textarea.span1,\r\n  .uneditable-input.span1 {\r\n    width: 56px;\r\n  }\r\n  .thumbnails {\r\n    margin-left: -30px;\r\n  }\r\n  .thumbnails > li {\r\n    margin-left: 30px;\r\n  }\r\n  .row-fluid .thumbnails {\r\n    margin-left: 0;\r\n  }\r\n}\r\n/***********************************************************************************************/\r\n/* RESET */\r\n/***********************************************************************************************/\r\n/* http://meyerweb.com/eric/tools/css/reset/ \r\n   v2.0 | 20110126\r\n   License: none (public domain)\r\n*/\r\nhtml,\r\nbody,\r\ndiv,\r\nspan,\r\napplet,\r\nobject,\r\niframe,\r\nh1,\r\nh2,\r\nh3,\r\nh4,\r\nh5,\r\nh6,\r\np,\r\nblockquote,\r\npre,\r\na,\r\nabbr,\r\nacronym,\r\naddress,\r\nbig,\r\ncite,\r\ncode,\r\ndel,\r\ndfn,\r\nem,\r\nimg,\r\nins,\r\nkbd,\r\nq,\r\ns,\r\nsamp,\r\nsmall,\r\nstrike,\r\nstrong,\r\nsub,\r\nsup,\r\ntt,\r\nvar,\r\nb,\r\nu,\r\ni,\r\ncenter,\r\ndl,\r\ndt,\r\ndd,\r\nol,\r\nul,\r\nli,\r\nfieldset,\r\nform,\r\nlabel,\r\nlegend,\r\ntable,\r\ncaption,\r\ntbody,\r\ntfoot,\r\nthead,\r\ntr,\r\nth,\r\ntd,\r\narticle,\r\naside,\r\ncanvas,\r\ndetails,\r\nembed,\r\nfigure,\r\nfigcaption,\r\nfooter,\r\nheader,\r\nhgroup,\r\nmenu,\r\nnav,\r\noutput,\r\nruby,\r\nsection,\r\nsummary,\r\ntime,\r\nmark,\r\naudio,\r\nvideo {\r\n  margin: 0;\r\n  padding: 0;\r\n  border: 0;\r\n  font-size: 100%;\r\n  font: inherit;\r\n  vertical-align: baseline;\r\n}\r\n/* HTML5 display-role reset for older browsers */\r\narticle,\r\naside,\r\ndetails,\r\nfigcaption,\r\nfigure,\r\nfooter,\r\nheader,\r\nhgroup,\r\nmenu,\r\nnav,\r\nsection {\r\n  display: block;\r\n}\r\nbody {\r\n  line-height: 100%;\r\n}\r\nblockquote,\r\nq {\r\n  quotes: none;\r\n}\r\nblockquote:before,\r\nblockquote:after,\r\nq:before,\r\nq:after {\r\n  content: '''';\r\n  content: none;\r\n}\r\ntable {\r\n  border-collapse: collapse;\r\n  border-spacing: 0;\r\n}\r\n* {\r\n  -webkit-box-sizing: border-box;\r\n  -moz-box-sizing: border-box;\r\n  box-sizing: border-box;\r\n}\r\nul,\r\nol,\r\nli {\r\n  list-style-type: none;\r\n}\r\ninput,\r\ntextarea,\r\nselect {\r\n  outline: none;\r\n}\r\n/***********************************************************************************************/\r\n/* UTILITY CLASSES */\r\n/***********************************************************************************************/\r\n.align-center {\r\n  text-align: center;\r\n}\r\n.align-left {\r\n  text-align: left;\r\n}\r\n.align-right {\r\n  text-align: right;\r\n}\r\n.inline li {\r\n  display: inline-block;\r\n  margin-right: 16px;\r\n}\r\n.inline li:last-child {\r\n  margin-right: 0;\r\n}\r\n.narrow-p {\r\n  margin: 0 auto 1.5em;\r\n  width: 30%;\r\n}\r\n/***********************************************************************************************/\r\n/* GENERAL TYPOGRAPHY STYLES */\r\n/***********************************************************************************************/\r\nbody {\r\n  color: #2b2b2b;\r\n  font: 300 16px/24px "Source Sans Pro", Helvetica, Arial, sans-serif;\r\n  -webkit-font-smoothing: antialiased;\r\n}\r\nh1,\r\nh2,\r\nh3 {\r\n  font-family: "Bitter", Georgia, serif;\r\n  margin-bottom: 1.5em;\r\n}\r\nh1 {\r\n  font-size: 26px;\r\n  line-height: 1.4em;\r\n}\r\nh2 {\r\n  font-size: 18px;\r\n  line-height: 1.2em;\r\n}\r\nh3 {\r\n  font-size: 14px;\r\n  line-height: 1.2em;\r\n  text-transform: uppercase;\r\n}\r\np,\r\nfigcaption {\r\n  margin-bottom: 1.5em;\r\n}\r\np a,\r\nfigcaption a {\r\n  color: #e34e47;\r\n  text-decoration: none;\r\n  -webkit-transition: color 0.2s ease-out;\r\n  -moz-transition: color 0.2s ease-out;\r\n  -o-transition: color 0.2s ease-out;\r\n  transition: color 0.2s ease-out;\r\n}\r\np a:hover,\r\nfigcaption a:hover {\r\n  color: #2b2b2b;\r\n  border-bottom: 1px dotted;\r\n}\r\nem {\r\n  font-size: 14px;\r\n  font-style: italic;\r\n  color: #7a7a7a;\r\n}\r\n/***********************************************************************************************/\r\n/* @FONT-FACE */\r\n/***********************************************************************************************/\r\n@font-face {\r\n  font-family: ''icomoon-ultimate'';\r\n  src: url(''fonts/icomoon-ultimate.eot'');\r\n  src: url(''fonts/icomoon-ultimate.eot?#iefix'') format(''embedded-opentype''), url(''fonts/icomoon-ultimate.woff'') format(''woff''), url(''fonts/icomoon-ultimate.ttf'') format(''truetype''), url(''fonts/icomoon-ultimate.svg#icomoon-ultimate'') format(''svg'');\r\n  font-weight: normal;\r\n  font-style: normal;\r\n}\r\n/* Use the following CSS code if you want to use data attributes for inserting your icons */\r\n[data-icon]:before {\r\n  font-family: ''icomoon-ultimate'';\r\n  content: attr(data-icon);\r\n  speak: none;\r\n  font-weight: normal;\r\n  font-variant: normal;\r\n  text-transform: none;\r\n  line-height: 1;\r\n  -webkit-font-smoothing: antialiased;\r\n}\r\n/* Use the following CSS code if you want to have a class per icon */\r\n/*\r\nInstead of a list of all class selectors,\r\nyou can use the generic selector below, but it''s slower:\r\n[class*="icon-"] {\r\n*/\r\n.icon-arrow-right,\r\n.icon-arrow-left,\r\n.icon-arrow-right-2,\r\n.icon-arrow-down,\r\n.icon-twitter,\r\n.icon-facebook,\r\n.icon-dribbble {\r\n  font-family: ''icomoon-ultimate'';\r\n  speak: none;\r\n  font-style: normal;\r\n  font-weight: normal;\r\n  font-variant: normal;\r\n  text-transform: none;\r\n  line-height: 1;\r\n  -webkit-font-smoothing: antialiased;\r\n}\r\n.icon-arrow-right:before {\r\n  content: "\\21";\r\n}\r\n.icon-arrow-left:before {\r\n  content: "\\22";\r\n}\r\n.icon-arrow-right-2:before {\r\n  content: "\\23";\r\n}\r\n.icon-arrow-down:before {\r\n  content: "\\24";\r\n}\r\n.icon-twitter:before {\r\n  content: "\\25";\r\n}\r\n.icon-facebook:before {\r\n  content: "\\26";\r\n}\r\n.icon-dribbble:before {\r\n  content: "\\27";\r\n}\r\n/***********************************************************************************************/\r\n/* UI ELEMENT STYLES */\r\n/***********************************************************************************************/\r\nhr {\r\n  background-color: #dbdbdb;\r\n  background-image: -moz-linear-gradient(left, #ffffff 0%, #dbdbdb 50%, #ffffff 100%);\r\n  background-image: -o-linear-gradient(left, #ffffff 0%, #dbdbdb 50%, #ffffff 100%);\r\n  background-image: -webkit-linear-gradient(left, #ffffff 0%, #dbdbdb 50%, #ffffff 100%);\r\n  background-image: linear-gradient(left, #ffffff 0%, #dbdbdb 50%, #ffffff 100%);\r\n  border: none;\r\n  height: 1px;\r\n  margin: 1.5em auto;\r\n  width: 50%;\r\n}\r\nhr.no-margin {\r\n  margin: 0 auto;\r\n}\r\nhr.alt {\r\n  background: white;\r\n  border-bottom: 1px #dcdbdb solid;\r\n  border-top: 1px #dcdbdb solid;\r\n  height: 5px;\r\n  width: 120px;\r\n}\r\n.box {\r\n  background-color: white;\r\n  border: 1px solid #dcdbdb;\r\n  padding: 3px;\r\n  -webkit-box-shadow: 0 0px 5px 0 rgba(0, 0, 0, 0.16);\r\n  -moz-box-shadow: 0 0px 5px 0 rgba(0, 0, 0, 0.16);\r\n  box-shadow: 0 0px 5px 0 rgba(0, 0, 0, 0.16);\r\n}\r\n.box figure img {\r\n  display: block;\r\n  height: auto;\r\n  width: 100%;\r\n}\r\n.btn {\r\n  background-color: #f7f7f7;\r\n  color: #2b2b2b;\r\n  display: inline-block;\r\n  font-size: 14px;\r\n  height: 32px;\r\n  padding: 3px 16px;\r\n  text-decoration: none;\r\n  -moz-border-radius: 5px;\r\n  -webkit-border-radius: 5px;\r\n  border-radius: 5px;\r\n  -moz-background-clip: padding;\r\n  -webkit-background-clip: padding-box;\r\n  background-clip: padding-box;\r\n  -webkit-transition: background-color 0.3s ease-out;\r\n  -moz-transition: background-color 0.3s ease-out;\r\n  -o-transition: background-color 0.3s ease-out;\r\n  transition: background-color 0.3s ease-out;\r\n}\r\n.btn:hover {\r\n  background-color: #1a2128;\r\n  color: white;\r\n}\r\n.btn:active {\r\n  background-color: #242e37;\r\n  color: white;\r\n}\r\n.btn.active {\r\n  background-color: white;\r\n  font-weight: 600;\r\n}\r\n.btn.active:hover {\r\n  color: inherit;\r\n}\r\n.btn-primary {\r\n  background-color: #e34e47;\r\n  color: white;\r\n  font-size: 16px;\r\n  font-weight: bold;\r\n  height: 48px;\r\n  -webkit-box-shadow: inset 0 -3px 0 0 rgba(0, 0, 0, 0.2);\r\n  -moz-box-shadow: inset 0 -3px 0 0 rgba(0, 0, 0, 0.2);\r\n  box-shadow: inset 0 -3px 0 0 rgba(0, 0, 0, 0.2);\r\n  padding: 12px 24px;\r\n  text-transform: uppercase;\r\n}\r\n.btn-primary:hover {\r\n  background-color: #e55b54;\r\n}\r\n.btn-primary:active {\r\n  box-shadow: none;\r\n  height: 45px;\r\n  margin-top: 3px;\r\n}\r\nblockquote p {\r\n  font-style: italic;\r\n}\r\nblockquote p:before,\r\nblockquote p:after {\r\n  content: ''"'';\r\n}\r\nblockquote cite {\r\n  font-size: 14px;\r\n  text-transform: uppercase;\r\n}\r\n.quote-form {\r\n  margin: 0 auto;\r\n  width: 520px;\r\n}\r\n.quote-form p {\r\n  background-color: #f7f7f7;\r\n  overflow: hidden;\r\n  margin-bottom: 12px;\r\n  padding: 3px 3px 3px 16px;\r\n  text-align: left;\r\n}\r\n.quote-form p:hover {\r\n  background-color: #f2f2f2;\r\n}\r\n.quote-form p.error {\r\n  background-color: #fff5f5;\r\n}\r\n.quote-form p.error label,\r\n.quote-form p.error input {\r\n  color: #ff0000;\r\n}\r\n.quote-form label {\r\n  display: inline-block;\r\n  margin-top: 16px;\r\n}\r\n.quote-form input[type="text"],\r\n.quote-form input[type="email"],\r\n.quote-form input[type="number"],\r\n.quote-form textarea {\r\n  border: none;\r\n  font: 300 16px/24px "Source Sans Pro", Helvetica, Arial, sans-serif;\r\n  float: right;\r\n  height: 54px;\r\n  margin-left: 16px;\r\n  padding: 0 16px;\r\n  width: 350px;\r\n}\r\n.quote-form input[type="submit"] {\r\n  border: none;\r\n  cursor: pointer;\r\n  font: bold 16px/24px "Source Sans Pro", Helvetica, Arial, sans-serif;\r\n  -webkit-font-smoothing: antialiased;\r\n}\r\n.quote-form textarea {\r\n  height: 198px;\r\n  padding: 16px;\r\n}\r\n.quote-form .select-container {\r\n  height: 60px;\r\n}\r\n.quote-form .select-container select {\r\n  font-size: 16px;\r\n  float: right;\r\n  margin: 16px 0 16px 16px;\r\n  width: 350px;\r\n}\r\n.quote-form .cta {\r\n  margin-top: 3em;\r\n}\r\n/***********************************************************************************************/\r\n/* GENERAL */\r\n/***********************************************************************************************/\r\n.section-content {\r\n  padding: 3em 0;\r\n}\r\n.no-bottom-padding {\r\n  padding-bottom: 0;\r\n}\r\nul.row {\r\n  margin-bottom: 1.5em;\r\n}\r\n/***********************************************************************************************/\r\n/* HEADER */\r\n/***********************************************************************************************/\r\n.main-header {\r\n  background: transparent url(''images/color-stripe.jpg'') 0 0 repeat-x;\r\n}\r\n.main-nav ul {\r\n  margin-top: 3em;\r\n}\r\n.main-nav ul li {\r\n  margin-right: 32px;\r\n  text-transform: uppercase;\r\n}\r\n.main-nav ul li a {\r\n  color: #7a7a7a;\r\n  text-decoration: none;\r\n  -webkit-transition: color 0.2s ease-out;\r\n  -moz-transition: color 0.2s ease-out;\r\n  -o-transition: color 0.2s ease-out;\r\n  transition: color 0.2s ease-out;\r\n}\r\n.main-nav ul li a:hover {\r\n  color: #e34e47;\r\n}\r\n.main-nav ul li.current-menu-item a,\r\n.main-nav ul li.current_page_item a {\r\n  color: #2b2b2b;\r\n}\r\n/***********************************************************************************************/\r\n/* MIDDLE CONTENT */\r\n/***********************************************************************************************/\r\n.middle-container {\r\n  background: transparent url(''images/pattern.jpg'') 0 0 repeat;\r\n  -webkit-box-shadow: inset 0 0px 5px 0 rgba(0, 0, 0, 0.2);\r\n  -moz-box-shadow: inset 0 0px 5px 0 rgba(0, 0, 0, 0.2);\r\n  box-shadow: inset 0 0px 5px 0 rgba(0, 0, 0, 0.2);\r\n}\r\n.intro-content {\r\n  background-color: #1a2128;\r\n  color: white;\r\n  height: 209px;\r\n  padding: 0 3em;\r\n}\r\n.intro-content h1 {\r\n  padding-top: 70px;\r\n}\r\n.intro-content .special-intro {\r\n  font-weight: bold;\r\n  padding-top: 86px;\r\n}\r\n.intro-content .intro-color-1 {\r\n  color: #2eb4e8;\r\n}\r\n.intro-content .intro-color-2 {\r\n  color: #a6c63a;\r\n}\r\n.cta {\r\n  margin-top: 1.5em;\r\n}\r\n.portfolio-entries li {\r\n  margin-bottom: 1.5em;\r\n}\r\n.portfolio-entry {\r\n  position: relative;\r\n  -webkit-transition: opacity 0.5s ease-out;\r\n  -moz-transition: opacity 0.5s ease-out;\r\n  -o-transition: opacity 0.5s ease-out;\r\n  transition: opacity 0.5s ease-out;\r\n}\r\n.portfolio-entry .hover-state {\r\n  height: 209px;\r\n  left: 3px;\r\n  padding: 5.5em 75px;\r\n  position: absolute;\r\n  top: 3px;\r\n  width: 100%;\r\n  display: none;\r\n}\r\n.portfolio-entry .hover-state p {\r\n  margin-bottom: 0;\r\n  position: relative;\r\n}\r\n.portfolio-entry .hover-state p:before {\r\n  content: ''\\23'';\r\n  color: #e34e47;\r\n  font-family: "icomoon-ultimate";\r\n  font-size: 11px;\r\n  position: absolute;\r\n  right: -25px;\r\n  top: 1px;\r\n}\r\n.portfolio-entry figure img {\r\n  -webkit-transition: opacity 0.2s ease-out;\r\n  -moz-transition: opacity 0.2s ease-out;\r\n  -o-transition: opacity 0.2s ease-out;\r\n  transition: opacity 0.2s ease-out;\r\n}\r\n.portfolio-entry:hover figure img {\r\n  opacity: 0;\r\n  filter: alpha(opacity=0);\r\n}\r\n.portfolio-entry:hover .hover-state {\r\n  display: block;\r\n}\r\n.portfolio-entry.hidden {\r\n  opacity: .2;\r\n  filter: alpha(opacity=20);\r\n}\r\n.portfolio-header {\r\n  margin: 1.5em 0;\r\n}\r\n.portfolio-header li a {\r\n  background-color: #f7f7f7;\r\n  color: #2b2b2b;\r\n  display: inline-block;\r\n  font-size: 14px;\r\n  height: 32px;\r\n  padding: 3px 16px;\r\n  text-decoration: none;\r\n  -moz-border-radius: 5px;\r\n  -webkit-border-radius: 5px;\r\n  border-radius: 5px;\r\n  -moz-background-clip: padding;\r\n  -webkit-background-clip: padding-box;\r\n  background-clip: padding-box;\r\n  -webkit-transition: background-color 0.3s ease-out;\r\n  -moz-transition: background-color 0.3s ease-out;\r\n  -o-transition: background-color 0.3s ease-out;\r\n  transition: background-color 0.3s ease-out;\r\n}\r\n.portfolio-header li a:hover {\r\n  background-color: #1a2128;\r\n  color: white;\r\n}\r\n.portfolio-header li a:active {\r\n  background-color: #242e37;\r\n  color: white;\r\n}\r\n.portfolio-header li a.active {\r\n  background-color: white;\r\n  font-weight: 600;\r\n}\r\n.portfolio-header li a.active:hover {\r\n  color: inherit;\r\n}\r\n.portfolio-nav {\r\n  padding: 1.5em;\r\n}\r\n.portfolio-nav ul li a {\r\n  background-color: #f7f7f7;\r\n  color: #2b2b2b;\r\n  display: inline-block;\r\n  font-size: 14px;\r\n  height: 32px;\r\n  padding: 3px 16px;\r\n  text-decoration: none;\r\n  -moz-border-radius: 5px;\r\n  -webkit-border-radius: 5px;\r\n  border-radius: 5px;\r\n  -moz-background-clip: padding;\r\n  -webkit-background-clip: padding-box;\r\n  background-clip: padding-box;\r\n  -webkit-transition: background-color 0.3s ease-out;\r\n  -moz-transition: background-color 0.3s ease-out;\r\n  -o-transition: background-color 0.3s ease-out;\r\n  transition: background-color 0.3s ease-out;\r\n}\r\n.portfolio-nav ul li a:hover {\r\n  background-color: #1a2128;\r\n  color: white;\r\n}\r\n.portfolio-nav ul li a:active {\r\n  background-color: #242e37;\r\n  color: white;\r\n}\r\n.portfolio-nav ul li a.active {\r\n  background-color: white;\r\n  font-weight: 600;\r\n}\r\n.portfolio-nav ul li a.active:hover {\r\n  color: inherit;\r\n}\r\n.portfolio-image-list li {\r\n  margin-bottom: 1.5em;\r\n}\r\n.portfolio-image-list li figcaption {\r\n  font-size: 14px;\r\n  margin: 1.5em;\r\n  text-align: center;\r\n}\r\n.portfolio-image-list li:last-child {\r\n  margin-bottom: 0;\r\n}\r\n.sidebar {\r\n  padding: 3em 1.5em;\r\n}\r\n.portfolio-single-nav li a {\r\n  background-color: #f7f7f7;\r\n  color: #2b2b2b;\r\n  display: inline-block;\r\n  font-size: 14px;\r\n  height: 32px;\r\n  padding: 3px 16px;\r\n  text-decoration: none;\r\n  -moz-border-radius: 5px;\r\n  -webkit-border-radius: 5px;\r\n  border-radius: 5px;\r\n  -moz-background-clip: padding;\r\n  -webkit-background-clip: padding-box;\r\n  background-clip: padding-box;\r\n  -webkit-transition: background-color 0.3s ease-out;\r\n  -moz-transition: background-color 0.3s ease-out;\r\n  -o-transition: background-color 0.3s ease-out;\r\n  transition: background-color 0.3s ease-out;\r\n}\r\n.portfolio-single-nav li a:hover {\r\n  background-color: #1a2128;\r\n  color: white;\r\n}\r\n.portfolio-single-nav li a:active {\r\n  background-color: #242e37;\r\n  color: white;\r\n}\r\n.portfolio-single-nav li a.active {\r\n  background-color: white;\r\n  font-weight: 600;\r\n}\r\n.portfolio-single-nav li a.active:hover {\r\n  color: inherit;\r\n}\r\n.about-page p {\r\n  margin: 0 auto 1.5em;\r\n  width: 30%;\r\n}\r\n.about-page hr.alt {\r\n  margin: 3em auto;\r\n}\r\n.about-page .cta {\r\n  margin-top: 3em;\r\n}\r\n.available {\r\n  color: #a6c63a;\r\n}\r\n/***********************************************************************************************/\r\n/* QUOTE AREA */\r\n/***********************************************************************************************/\r\n.quote-container {\r\n  background-color: #1a2128;\r\n}\r\n.quote-container h3 {\r\n  color: white;\r\n}\r\n.quote-container p {\r\n  color: #687078;\r\n  margin: 0 auto 1.5em;\r\n  width: 30%;\r\n}\r\n.quote-container p:last-child {\r\n  margin-bottom: 0;\r\n}\r\n.quote-container p a:hover {\r\n  color: white;\r\n}\r\n/***********************************************************************************************/\r\n/* FOOTER */\r\n/***********************************************************************************************/\r\n.main-footer p {\r\n  margin: 0 auto 1.5em;\r\n  width: 30%;\r\n}\r\n.main-footer p:last-child {\r\n  margin-bottom: 0;\r\n}\r\n.social-icons li a {\r\n  color: #dcdbdb;\r\n  font-size: 32px;\r\n  display: inline-block;\r\n  margin-bottom: 16px;\r\n  text-decoration: none;\r\n  -webkit-transition: color 0.2s ease-out;\r\n  -moz-transition: color 0.2s ease-out;\r\n  -o-transition: color 0.2s ease-out;\r\n  transition: color 0.2s ease-out;\r\n}\r\n.social-icons li a:hover {\r\n  color: #1a2128;\r\n}\r\n.social-icons li a:active {\r\n  color: #202931;\r\n}\r\n');

-- --------------------------------------------------------

--
-- Table structure for table `template_category`
--

CREATE TABLE IF NOT EXISTS `template_category` (
`id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `is_basic` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `template_category`
--

INSERT INTO `template_category` (`id`, `name`, `is_basic`) VALUES
(1, 'Common Files', 1),
(2, 'Headers', 0),
(3, 'Functions', 0);

-- --------------------------------------------------------

--
-- Table structure for table `template_css`
--

CREATE TABLE IF NOT EXISTS `template_css` (
`id` int(11) NOT NULL,
  `template_id` int(11) NOT NULL,
  `css_id` int(11) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Table structure for table `template_functions`
--

CREATE TABLE IF NOT EXISTS `template_functions` (
`id` int(11) NOT NULL,
  `template_id` int(11) NOT NULL,
  `functions_id` int(11) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Table structure for table `template_image`
--

CREATE TABLE IF NOT EXISTS `template_image` (
`id` int(11) NOT NULL,
  `template_id` int(11) NOT NULL,
  `image_id` int(11) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `template_image`
--

INSERT INTO `template_image` (`id`, `template_id`, `image_id`) VALUES
(1, 4, 1),
(2, 15, 2),
(3, 15, 3);

-- --------------------------------------------------------

--
-- Table structure for table `template_js`
--

CREATE TABLE IF NOT EXISTS `template_js` (
`id` int(11) NOT NULL,
  `template_id` int(11) NOT NULL,
  `js_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
`id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `auth_key` varchar(32) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `password_reset_token` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `role` smallint(6) NOT NULL DEFAULT '10',
  `status` smallint(6) NOT NULL DEFAULT '10',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `auth_key`, `password_hash`, `password_reset_token`, `email`, `role`, `status`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'Yz6GqSbNpE5veOeuIA0YZA7heobLAdM7', '$2y$13$1YGkkW6FLGpEzVxPhW984uhh0NnX/OyoCBDRiztLnGFGOtnr6xXw2', NULL, 'admin@gnail.com', 10, 10, 1401621203, 1401621203);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `css`
--
ALTER TABLE `css`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `functions`
--
ALTER TABLE `functions`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `image`
--
ALTER TABLE `image`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `js`
--
ALTER TABLE `js`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migration`
--
ALTER TABLE `migration`
 ADD PRIMARY KEY (`version`);

--
-- Indexes for table `related_template`
--
ALTER TABLE `related_template`
 ADD PRIMARY KEY (`id`), ADD KEY `fk_related_template_parent` (`parent_id`), ADD KEY `fk_related_template_child` (`child_id`);

--
-- Indexes for table `template`
--
ALTER TABLE `template`
 ADD PRIMARY KEY (`id`), ADD KEY `fk_template_template_category` (`category_id`);

--
-- Indexes for table `template_category`
--
ALTER TABLE `template_category`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `template_css`
--
ALTER TABLE `template_css`
 ADD PRIMARY KEY (`id`), ADD KEY `fk_template_css_template` (`template_id`), ADD KEY `fk_template_css_css` (`css_id`);

--
-- Indexes for table `template_functions`
--
ALTER TABLE `template_functions`
 ADD PRIMARY KEY (`id`), ADD KEY `fk_template_functions_template` (`template_id`), ADD KEY `fk_template_functions_functions` (`functions_id`);

--
-- Indexes for table `template_image`
--
ALTER TABLE `template_image`
 ADD PRIMARY KEY (`id`), ADD KEY `fk_template_image_template` (`template_id`), ADD KEY `fk_template_image_image` (`image_id`);

--
-- Indexes for table `template_js`
--
ALTER TABLE `template_js`
 ADD PRIMARY KEY (`id`), ADD KEY `fk_template_js_template` (`template_id`), ADD KEY `fk_template_js_js` (`js_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `css`
--
ALTER TABLE `css`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `functions`
--
ALTER TABLE `functions`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `image`
--
ALTER TABLE `image`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `js`
--
ALTER TABLE `js`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `related_template`
--
ALTER TABLE `related_template`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=30;
--
-- AUTO_INCREMENT for table `template`
--
ALTER TABLE `template`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `template_category`
--
ALTER TABLE `template_category`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `template_css`
--
ALTER TABLE `template_css`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `template_functions`
--
ALTER TABLE `template_functions`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `template_image`
--
ALTER TABLE `template_image`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `template_js`
--
ALTER TABLE `template_js`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `related_template`
--
ALTER TABLE `related_template`
ADD CONSTRAINT `fk_related_template_child` FOREIGN KEY (`child_id`) REFERENCES `template` (`id`) ON DELETE CASCADE,
ADD CONSTRAINT `fk_related_template_parent` FOREIGN KEY (`parent_id`) REFERENCES `template` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `template`
--
ALTER TABLE `template`
ADD CONSTRAINT `fk_template_template_category` FOREIGN KEY (`category_id`) REFERENCES `template_category` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `template_css`
--
ALTER TABLE `template_css`
ADD CONSTRAINT `fk_template_css_css` FOREIGN KEY (`css_id`) REFERENCES `css` (`id`) ON DELETE CASCADE,
ADD CONSTRAINT `fk_template_css_template` FOREIGN KEY (`template_id`) REFERENCES `template` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `template_functions`
--
ALTER TABLE `template_functions`
ADD CONSTRAINT `fk_template_functions_functions` FOREIGN KEY (`functions_id`) REFERENCES `functions` (`id`) ON DELETE CASCADE,
ADD CONSTRAINT `fk_template_functions_template` FOREIGN KEY (`template_id`) REFERENCES `template` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `template_image`
--
ALTER TABLE `template_image`
ADD CONSTRAINT `fk_template_image_image` FOREIGN KEY (`image_id`) REFERENCES `image` (`id`) ON DELETE CASCADE,
ADD CONSTRAINT `fk_template_image_template` FOREIGN KEY (`template_id`) REFERENCES `template` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `template_js`
--
ALTER TABLE `template_js`
ADD CONSTRAINT `fk_template_js_js` FOREIGN KEY (`js_id`) REFERENCES `js` (`id`) ON DELETE CASCADE,
ADD CONSTRAINT `fk_template_js_template` FOREIGN KEY (`template_id`) REFERENCES `template` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
