<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class CommonCssAsset extends AssetBundle
{
    public $sourcePath = '@webroot/css';
    public $css = [
        'normalize.css',
        'icons.css',
        'component.css',
        'site.css',
    ];
    public $js = [];
    public $depends = [];
}
