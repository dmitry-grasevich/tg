<section class="screen home-v1">
    <header class="hdr-v1">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <h1 class="logo header-font">
                        <a href="<?php echo home_url(); ?>" class="primary">
                            <?php if (get_theme_mod('tg-site-logo-image')): ?>
                                <img src="<?php echo esc_url(get_theme_mod('tg-site-logo-image')) ?>" alt="<?php bloginfo('name'); ?>" />
                            <?php endif; ?>
                            <?php if ('blank' != get_theme_mod('header_textcolor')): ?>
                                <?php bloginfo('name'); ?>
                            <?php endif; ?>
                        </a>
                    </h1>
                </div>
                <div class="col-md-9">
                    <nav class="prim-nav">
                        <?php
                        wp_nav_menu(array(
                            'theme_location' => 'main-menu',
                            'container' => '',
                            'menu_class' => 'inline',
                        ));
                        ?>
                    </nav>
                </div>
            </div>
        </div>
    </header>

    <div class="container">
        <div class="row">

            <div class="vertical">

                <div class="intro col-xs-12 col-sm-10 col-md-<?php echo (get_theme_mod('tg-header-text-width') ?: '8'); ?>" >
                    <h2 class="page-intro border header-font">
                        <?php echo get_theme_mod('tg-header-text-title', 'Flat landing page<br>for apps <span class="amp">&</span> portfolio'); ?>
                    </h2>

                    <p class="page-description secondary">
                        <?php echo get_theme_mod('tg-header-text-description', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas tincidunt mi ac facilisis cursus. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.'); ?>
                    </p>

                    <p>
                        <?php if (get_theme_mod('tg-header-buttons-button-visibility') == '1'): ?>
                            <a href="<?php echo get_theme_mod('tg-header-buttons-button-url'); ?>"
                               id="hdr-btn-1"
                               class="btn btn-lg <?php echo get_theme_mod('tg-header-buttons-button-style'); ?>">
                                <?php echo get_theme_mod('tg-header-buttons-button-title'); ?>
                            </a>
                        <?php endif; ?>
                    </p>
                </div>

            </div>

        </div>
    </div>
</section>