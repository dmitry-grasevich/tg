<?php

if (!function_exists('tg_excerpt_more')) :
/**
 * Filter the excerpt "read more" string.
 *
 * @param string $more "Read more" excerpt string.
 * @return string (Maybe) modified "read more" excerpt string.
 */
function tg_excerpt_more($more) {
    return '...';
}
add_filter('excerpt_more', 'tg_excerpt_more');

endif;


if (!function_exists('tg_custom_excerpt_length')) :
/**
 * Filter the except length to 20 words.
 *
 * @param int $length Excerpt length.
 * @return int (Maybe) modified excerpt length.
 */
function tg_custom_excerpt_length($length) {
    return 25;
}
add_filter('excerpt_length', 'tg_custom_excerpt_length', 999);

endif;