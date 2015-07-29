<?php

namespace backend\assets;

use yii\web\AssetBundle;

class NanoScrollerAsset extends AssetBundle
{
    public $sourcePath = '@bower/nanoscroller/bin';
    public $css = [
        'css/nanoscroller.css',
    ];
    public $js = [
        'javascripts/jquery.nanoscroller.min.js'
    ];
    public $depends = [];
}
