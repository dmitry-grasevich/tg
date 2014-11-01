<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class PerfectScrollbarAsset extends AssetBundle
{
    public $sourcePath = '@bower/perfect-scrollbar/src';
    public $css = [
        'perfect-scrollbar.css',
    ];
    public $js = [
        'perfect-scrollbar.js',
    ];
    public $depends = [];
}
