<!DOCTYPE html>
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
