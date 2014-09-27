<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class BootstrapSelectAsset extends AssetBundle
{
    public $sourcePath = '@bower/bootstrap-select';
    public $css = [
        'dist/css/bootstrap-select.css',
    ];
    public $js = [
        'dist/js/bootstrap-select.js',
    ];
    public $depends = [
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}
