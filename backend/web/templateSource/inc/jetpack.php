<?php
/**
 * Jetpack Compatibility File.
 *
 * @link https://jetpack.me/
 *
 * @package tg
 */

/**
 * Add theme support for Infinite Scroll.
 * See: https://jetpack.me/support/infinite-scroll/
 */
function tg_jetpack_setup()
{
    add_theme_support('infinite-scroll', array(
        'container' => 'main',
        'render' => 'tg_infinite_scroll_render',
        'footer' => 'page',
    ));
} // end function tg_jetpack_setup
add_action('after_setup_theme', 'tg_jetpack_setup');

/**
 * Custom render function for Infinite Scroll.
 */
function tg_infinite_scroll_render()
{
    while (have_posts()) {
        the_post();
        get_template_part('partials/content', get_post_format());
    }
} // end function tg_infinite_scroll_render
