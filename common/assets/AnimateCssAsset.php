<?php

namespace common\assets;

use yii\web\AssetBundle;

class AnimateCssAsset extends AssetBundle
{
    public $sourcePath = '@bower/animate.css';
    public $css = [
        'animate.min.css',
    ];
    public $js = [];
    public $depends = [];
}
