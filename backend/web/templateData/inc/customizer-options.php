<?php
/**
 * Defines customizer options
 *
 * @package Customizer Library Demo
 */

function customizer_library_demo_options()
{
    // Theme defaults
    $primary_color = '#fff';
    $secondary_color = '#fff';

    // Stores all the controls that will be added
    $options = array();

    // Stores all the sections to be added
    $sections = array();

    // Adds the sections to the $options array
    $options['sections'] = $sections;

    // Logo
    $section = 'logo';

    $sections[] = array(
        'id' => $section,
        'title' => __('Image Example', 'demo'),
        'priority' => '30',
        'description' => __('Example section description.', 'demo')
    );

    $options['logo'] = array(
        'id' => 'logo',
        'label' => __('Logo', 'demo'),
        'section' => $section,
        'type' => 'image',
        'default' => '',
    );

    // Colors
    $section = 'colors';

    $sections[] = array(
        'id' => $section,
        'title' => __('Colors', 'demo'),
        'priority' => '80'
    );

    $options['primary-color'] = array(
        'id' => 'primary-color',
        'label' => __('Primary Color', 'demo'),
        'section' => $section,
        'type' => 'color',
        'default' => $primary_color,
    );

    $options['secondary-color'] = array(
        'id' => 'secondary-color',
        'label' => __('Secondary Color', 'demo'),
        'section' => $section,
        'type' => 'color',
        'default' => $secondary_color,
    );

    $options['border'] = array(
        'id' => 'border',
        'label' => __('Border Color', 'demo'),
        'section' => $section,
        'type' => 'color',
        'default' => $primary_color,
    );

    // Typography
    $section = 'typography';
    $font_choices = customizer_library_get_font_choices();

    $sections[] = array(
        'id' => $section,
        'title' => __('Typography', 'demo'),
        'priority' => '80'
    );

    $options['primary-font'] = array(
        'id' => 'primary-font',
        'label' => __('Primary Font', 'demo'),
        'section' => $section,
        'type' => 'select',
        'choices' => $font_choices,
        'default' => 'Monoton'
    );

    $options['secondary-font'] = array(
        'id' => 'secondary-font',
        'label' => __('Secondary Font', 'demo'),
        'section' => $section,
        'type' => 'select',
        'choices' => $font_choices,
        'default' => 'Merriweather'
    );

    // Adds the sections to the $options array
    $options['sections'] = $sections;

    $customizer_library = Customizer_Library::Instance();
    $customizer_library->add_options($options);

    // To delete custom mods use: customizer_library_remove_theme_mods();

}

add_action('init', 'customizer_library_demo_options');
