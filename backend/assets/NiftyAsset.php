<?php

namespace backend\assets;

use yii\web\AssetBundle;
use yii\web\View;

/**
 * @author Dmitry Grasevich
 * @since 1.0.0
 */
class NiftyAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [];
    public $js = [];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
        'common\assets\PerfectScrollbarAsset',
        'common\assets\UnderscoreAsset',
        'common\assets\HandlebarsAsset',
        'common\assets\HighlightAsset',
        'common\assets\FontAwesomeAsset',
        'common\assets\BootboxAsset',
        'backend\assets\NanoScrollerAsset',
        'backend\assets\MetisMenuAsset',
        'backend\assets\NiftyJsAsset',
        'backend\assets\NiftyCssAsset',
    ];

    public function init() {
        $this->jsOptions['position'] = View::POS_END;
        parent::init();
    }
}
