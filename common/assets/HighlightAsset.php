<?php

namespace common\assets;

use yii\web\AssetBundle;

class HighlightAsset extends AssetBundle
{
    public $sourcePath = '@common/assets/lib/highlight';
    public $css = [
        'styles/rainbow.css',
    ];
    public $js = [
        'highlight.pack.js'
    ];
    public $depends = [];
}
