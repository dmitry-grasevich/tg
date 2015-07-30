<?php

namespace common\assets;

use yii\web\AssetBundle;

class BootboxAsset extends AssetBundle
{
    public $sourcePath = '@bower/bootbox.js';
    public $css = [];
    public $js = [
        'bootbox.js'
    ];
    public $depends = [];
}
