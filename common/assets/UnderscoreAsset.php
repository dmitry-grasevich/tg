<?php

namespace common\assets;

use yii\web\AssetBundle;

class UnderscoreAsset extends AssetBundle
{
    public $sourcePath = '@bower/underscore';
    public $css = [];
    public $js = [
        'underscore-min.js'
    ];
    public $depends = [];
}
