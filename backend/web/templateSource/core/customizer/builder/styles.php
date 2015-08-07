<?php
if (!function_exists('generate_custom_styles')) :
    /**
     * Generate custom styles
     *
     * @since  1.0.0.
     */
    function generate_custom_styles()
    {
        // Grab the customizer config
        $config = TG_Customizer_Config::get_instance();

        $styles = $sorted = $fonts = $default = array();
        foreach ($config->controls as $section_key => $controls_data) {
            foreach ($controls_data as $control_key => $control_data) {
                $default[$control_key] = isset($control_data['default']) ? $control_data['default'] : '';
            }
        }

        foreach ($config->styles as $control_key => $style_data) {
            if (!array_key_exists('output', $style_data)) {
                continue;
            }

            foreach ($style_data['output'] as $output) {
                if (!array_key_exists('element', $output) || !array_key_exists('property', $output)) {
                    continue;
                }

                $value = get_theme_mod($control_key);
                if (empty($value)) {
                    $value = isset($default[$control_key]) ? $default[$control_key] : '';
                }

                $sorted[$output['element']][$output['property']] = $value;

                if (in_array($output['property'], array('font-family', 'font-weight', 'font-subset'))) {
                    if ('font-family' == $output['property']) {
                        /**
                         * Add the font-family to the array
                         */
                        $fonts[]['font-family'] = $value;
                    } else if ('font-weight' == $output['property']) {
                        /**
                         * Add font-weight to the array
                         */
                        $fonts[]['font-weight'] = $value;
                    } else if ('font-subset' == $output['property']) {
                        /**
                         * add font subsets to the array
                         */
                        $fonts[]['subsets'] = $value;
                    }
                }
            }
        }
        if (empty($sorted)) {
            return;
        }

        $styles['global'] = $sorted;

        $css = Kirki_Output::styles_parse(Kirki_Output::add_prefixes($styles));

        ?>
        <!-- Custom styles -->
        <style type='text/css'>
            <?php echo $css ?>
        </style>
        <!-- // Custom styles -->
        <?php

        foreach ($fonts as $font) {
            // Do we have font-families?
            if (isset($font['font-family']) && $font['font-family']) {
                $font_families = (!isset($font_families)) ? array() : $font_families;
                $font_families[] = $font['font-family'];
                if (Kirki_Toolkit::fonts()->is_google_font($font['font-family'])) {
                    $has_google_font = true;
                }
            }

            // Do we have font-weights?
            if (isset($font['font-weight'])) {
                $font_weights = (!isset($font_weights)) ? array() : $font_weights;
                $font_weights[] = $font['font-weight'];
            }

            // Do we have font-subsets?
            if (isset($font['subsets'])) {
                $font_subsets = (!isset($font_subsets)) ? array() : $font_subsets;
                $font_subsets[] = $font['subsets'];
            }
        }

        // Make sure there are no empty values and define defaults.
        $font_families = (!isset($font_families) || empty($font_families)) ? false : $font_families;
        $font_weights = (!isset($font_weights) || empty($font_weights)) ? '400' : $font_weights;
        $font_subsets = (!isset($font_subsets) || empty($font_subsets)) ? 'all' : $font_subsets;

        if (!isset($has_google_font) || !$has_google_font) {
            return;
        }

        $google_link = str_replace('%3A', ':', Kirki_Toolkit::fonts()->get_google_font_uri($font_families, $font_weights, $font_subsets));
        wp_enqueue_style('tg_google_fonts', $google_link, array(), null);
    }
endif;
