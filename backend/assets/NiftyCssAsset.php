<?php

namespace backend\assets;

use yii\web\AssetBundle;

class NiftyCssAsset extends AssetBundle
{
    public $sourcePath = '@webroot/css/nifty';
    public $css = [
        'nifty.css',
    ];
    public $js = [];
    public $depends = [
        'common\assets\AnimateCssAsset',
    ];
}
