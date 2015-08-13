<?php
get_header();

if (have_posts()):

    if (is_home() && is_front_page()):
        $order = get_theme_mod('tg-sections-order-sorter');
        $sections = maybe_unserialize($order);
        foreach ($sections as $section) {
            get_template_part('partials/section', $section);
        }
    endif;

    /* Start the Loop */
    while (have_posts()): the_post();

        /*
         * Include the Post-Format-specific template for the content.
         * If you want to override this in a child theme, then include a file
         * called content-___.php (where ___ is the Post Format name) and that will be used instead.
         */
        get_template_part('partials/content', get_post_format());

    endwhile;

    the_posts_navigation();

else:

    get_template_part('partials/content', 'none');

endif;

get_sidebar();
get_footer();
