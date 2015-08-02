<?php

namespace common\assets;

use yii\web\AssetBundle;

class HandlebarsAsset extends AssetBundle
{
    public $sourcePath = '@common/assets/lib/handlebars';
    public $js = [
        'handlebars-v3.0.3.js'
    ];
}
