<?php

namespace backend\assets;

use yii\web\AssetBundle;

class CommonCssAsset extends AssetBundle
{
    public $sourcePath = '@webroot/css';
    public $css = [
        'ml.menu/normalize.css',
        'ml.menu/icons.css',
        'ml.menu/component.css',
        'highlight.styles/rainbow.css',
        'themes/yeti.css',
        'site.css',
    ];
    public $js = [];
    public $depends = [];
}
