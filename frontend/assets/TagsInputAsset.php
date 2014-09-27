<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class TagsInputAsset extends AssetBundle
{
    public $sourcePath = '@bower/jquery.tagsinput';
    public $css = [
        'jquery.tagsinput.css',
    ];
    public $js = [
        'jquery.tagsinput.js',
    ];
}
