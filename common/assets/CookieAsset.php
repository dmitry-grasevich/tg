<?php

namespace common\assets;

use yii\web\AssetBundle;

class CookieAsset extends AssetBundle
{
    public $sourcePath = '@bower/js-cookie/src';
    public $css = [];
    public $js = [
        'js.cookie.js'
    ];
    public $depends = [];
}
