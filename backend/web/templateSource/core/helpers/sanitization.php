<?php /**
 * Sanitization helper functions
 *
 * These functions are extra functions which are needed to add sanitization to TG
 *
 * @package TG
 * @since TG 1.0.0
 */

if (!function_exists('tg_sanitize_text')) :
    /**
     * Sanitize a string to allow only tags in the allowedtags array.
     *
     * @since  1.0.0.
     *
     * @param  string $string   The unsanitized string.
     * @return string           The sanitized string.
     */
    function tg_sanitize_text($string)
    {
        global $allowedtags;
        return wp_kses($string, $allowedtags);
    }
endif;

if (!function_exists('tg_sanitize_checkbox')) :
    /**
     * Sanitize a checkbox to only allow 0 or 1
     *
     * @since  1.0.0.
     *
     * @param  boolean $value   The unsanitized value.
     * @return boolean          The sanitized boolean.
     */
    function tg_sanitize_checkbox($value)
    {
        return $value ? '1' : false;
    }
endif;

if (!function_exists('tg_sanitize_number')) :
    function tg_sanitize_number($value = FALSE)
    {
        return is_numeric($value) ? intval($value) : '';
    }
endif;

if (!function_exists('tg_sanitize_js')) :
    /**
     * JS sanitization. The customizer does not like single quotes, while esc_js does not like double quotes
     *
     * @since  1.0.0.
     *
     * @param  string $value    The unsanitized string.
     * @return string           The sanitized string.
     */
    function tg_sanitize_js($value = '')
    {
        $safe_text = _wp_specialchars($value, ENT_QUOTES);
        $safe_text = preg_replace('/&#(x)?0*(?(1)27|39);?/i', '"', stripslashes($safe_text));
        $safe_text = str_replace("\r", '', $safe_text);
        $safe_text = str_replace("\n", '\\n', addslashes($safe_text));

        return trim($safe_text);
    }
endif;

if (!function_exists('tg_sanitize_choices')) :
    /**
     * Sanitize a value from a list of allowed values.
     *
     * @since 1.0.0.
     *
     * @param  mixed $value     The value to sanitize.
     * @param  mixed $setting   The setting for which the sanitizing is occurring.
     * @return mixed            The sanitized value.
     */
    function tg_sanitize_choices($value, $setting)
    {
        if (is_object($setting)) {
            $setting = $setting->id;
        }

        $choices = customizer_library_get_choices($setting);
        $allowed_choices = array_keys($choices);

        if (!in_array($value, $allowed_choices)) {
            $value = customizer_library_get_default($setting);
        }

        return $value;
    }
endif;

if (!function_exists('tg_sanitize_file_url')) :
    /**
     * Sanitize the url of uploaded media.
     *
     * @since 1.0.0.
     *
     * @param  string $url      The url to sanitize
     * @return string $output   The sanitized url.
     */
    function tg_sanitize_file_url($url)
    {
        $output = '';

        $filetype = wp_check_filetype($url);
        if ($filetype["ext"]) {
            $output = esc_url($url);
        }

        return $output;
    }
endif;

if (!function_exists('tg_sanitize_hex_color')) :
    /**
     * Sanitizes a hex color.
     *
     * Returns either '', a 3 or 6 digit hex color (with #), or null.
     * For sanitizing values without a #, see sanitize_hex_color_no_hash().
     *
     * @since 1.0.0
     *
     * @param string $color
     * @return string|null
     */
    function tg_sanitize_hex_color($color)
    {
        if ('' === $color)
            return '';

        // 3 or 6 hex digits, or the empty string.
        if (preg_match('|^#([A-Fa-f0-9]{3}){1,2}$|', $color))
            return $color;

        return null;
    }
endif;

if (!function_exists('tg_sanitize_text_kses')) :
    /**
     * Sanitizes a text.
     *
     * @since 1.0.0
     *
     * @param string $input
     * @return string|null
     */
    function tg_sanitize_text_kses($input) {

        $allowed_html = array(
            'a' => array(
                'href' => array(),
                'title' => array(),
                'rel' => array(),
                'class' => array(),
            ),
            'br' => array(),
            'em' => array(),
            'strong' => array(),
            'i' => array(),
            'span' => array(
                'class' => array(),
                'style' => array(),
            )
        );

        $input = wp_kses($input, $allowed_html);

        return $input;
    }
endif;