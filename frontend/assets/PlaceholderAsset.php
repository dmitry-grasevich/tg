<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class PlaceholderAsset extends AssetBundle
{
    public $sourcePath = '@bower/jquery-placeholder';
    public $js = [
        'jquery.placeholder.js',
    ];
}
