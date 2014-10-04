<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class HistoryAsset extends AssetBundle
{
    public $sourcePath = '@bower/history.js/scripts/bundled-uncompressed/html4+html5';
    public $css = [
    ];
    public $js = [
        'jquery.history.js',
    ];
    public $depends = [];
}
