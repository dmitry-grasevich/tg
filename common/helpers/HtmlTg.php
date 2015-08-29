<?php
/**
 * Class HtmlTg
 * @package common\helpers
 */

namespace common\helpers;

use yii\bootstrap\Html;

class HtmlTg
{
    /**
     * Creates wrapper code
     *
     * @param string $code
     *
     * @return string
     */
    public static function code($code)
    {
        return Html::tag('pre', Html::tag('code', Html::encode($code)), ['class' => 'scroll', 'style' => 'max-height: 400px; position: relative;']);
    }
}