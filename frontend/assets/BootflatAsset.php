<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class BootflatAsset extends AssetBundle
{
    public $sourcePath = '@vendor/bootflat';
    public $css = [
        'bootflat/bootflat/css/bootflat.css',
    ];
    public $js = [
        'bootflat/bootflat/js/icheck.min.js',
        'bootflat/bootflat/js/jquery.fs.selecter.min.js',
        'bootflat/bootflat/js/jquery.fs.stepper.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}
