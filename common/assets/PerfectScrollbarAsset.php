<?php

namespace common\assets;

use yii\web\AssetBundle;

class PerfectScrollbarAsset extends AssetBundle
{
    public $sourcePath = '@bower/perfect-scrollbar';
    public $css = [
        'css/perfect-scrollbar.css',
    ];
    public $js = [
        'js/perfect-scrollbar.jquery.js',
    ];
    public $depends = [];
}
