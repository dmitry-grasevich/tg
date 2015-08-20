<?php

namespace backend\assets;

use yii\web\AssetBundle;

class SettingsAsset extends AssetBundle
{
    public $sourcePath = '@webroot/js/nifty';
    public $js = [
        'settings-files.js',
    ];
    public $depends = [
        'backend\assets\NiftyJsAsset',
    ];
}
