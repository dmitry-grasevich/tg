<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class BootstrapSwitchAsset extends AssetBundle
{
    public $sourcePath = '@bower/bootstrap-switch';
    public $css = [
        'dist/css/bootstrap3/bootstrap-switch.css',
    ];
    public $js = [
        'dist/js/bootstrap-switch.js',
    ];
    public $depends = [
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}
