<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class ModernizrAsset extends AssetBundle
{
    public $sourcePath = '@vendor/components/modernizr';
    public $css = [];
    public $js = ['modernizr.js'];
}
