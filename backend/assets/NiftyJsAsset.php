<?php

namespace backend\assets;

use yii\web\AssetBundle;

class NiftyJsAsset extends AssetBundle
{
    public $sourcePath = '@webroot/js/nifty';
    public $css = [];
    public $js = [
        'highlight.pack.js',
        'helpers.js',
        'nifty.js',
        'alert.js',
        'navigation.js',
        'customizer.js',
    ];
    public $depends = [
        'yii\jui\JuiAsset',
    ];
}
