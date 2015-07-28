<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class CommonJsAsset extends AssetBundle
{
    public $sourcePath = '@webroot/js';
    public $css = [];
    public $js = [
        'modernizr.custom.js',
        'classie.js',
        'jquery.fileDownload.js',
        'mlpushmenu.js',
        'wpt.builder.js',
    ];
    public $depends = [];
}
