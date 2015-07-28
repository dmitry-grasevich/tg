<?php

namespace backend\assets;

use yii\web\AssetBundle;

class CommonJsAsset extends AssetBundle
{
    public $sourcePath = '@webroot/js';
    public $css = [];
    public $js = [
        'highlight.pack.js',
        'classie.js',
        'mlpushmenu.js',
    ];
    public $depends = [];
}
