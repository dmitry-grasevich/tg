<?php

namespace common\models;

use Yii;

/**
 * Class Control -
 *
 * @package common\models
 */
class Control_
{
    protected $_domain = 'template-generator';

    protected function domain()
    {
        return $this->_domain;
    }

    public static function text()
    {

    }

    public static function font($id, $label, $section, $default)
    {
        return
        "\$options['$id'] = array(
            'id' => '$id',
            'label' => __('$label', '" . self::domain() . "'),
            'section' => '$section',
            'type' => 'select',
            'choices' => customizer_library_get_font_choices(),
            'default' => '$default',
        );";
    }

    public static function color($id, $label, $section, $default)
    {
        return
        "\$options['$id'] = array(
            'id' => '$id',
            'label' => __('$label', '" . self::domain() . "'),
            'section' => '$section',
            'type' => 'color',
            'default' => '$default',
        );";
    }
}