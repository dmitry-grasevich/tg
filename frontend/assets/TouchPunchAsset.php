<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class TouchPunchAsset extends AssetBundle
{
    public $sourcePath = '@bower/jquery-ui-touch-punch-improved';
    public $js = [
        'jquery.ui.touch-punch-improved.js',
    ];
}
