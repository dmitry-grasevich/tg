<?php get_header(); ?>

    <?php
        $order = get_theme_mod('tg-sections-order-sorter');
        $sections = maybe_unserialize($order);
        foreach ($sections as $section) {
            get_template_part('partials/section', $section);
        }
    ?>

    <?php if (have_posts()) : while(have_posts()) : the_post(); ?>
        <?php get_template_part('content', get_post_format()); ?>
     <?php endwhile; else : ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class('no-posts'); ?>>
            <h1><?php _e('No posts were found.', 'adaptive-framework'); ?></h1>
        </article>
    <?php endif; ?>

<?php get_footer(); ?>