<?php

namespace backend\assets;

use yii\web\AssetBundle;

class NiftyJsAsset extends AssetBundle
{
    public $sourcePath = '@webroot/js/nifty';
    public $css = [];
    public $js = [
        'highlight.pack.js',
        'nifty.js',
        'helpers.js',
        'alert.js',
        'navigation.js',
    ];
    public $depends = [];
}