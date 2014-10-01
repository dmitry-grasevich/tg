<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace frontend\assets;

use yii\web\AssetBundle;
use yii\web\View;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/normalize.css',
        'css/site.css',
        'css/icons.css',
        'css/component.css',

//        'css/flat-ui.css',
//        'css/chosen.css',
//        'css/style.css',
    ];
    public $js = [
        'js/modernizr.custom.js',
        'js/classie.js',
        'js/mlpushmenu.js',
        'js/wpt.builder.js',

//        'js/flatui-checkbox.js',
//        'js/flatui-fileinput.js',
//        'js/flatui-radio.js',
//        'js/jquery.zoomer.js',
//        'js/chosen.jquery.js',
//        'js/application.js',
//        'elements.json',
//        'js/builder.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
//        'yii\bootstrap\BootstrapAsset',
//        'yii\bootstrap\BootstrapPluginAsset',
        'yii\jui\JuiAsset',
//        'frontend\assets\BootflatAsset',
        'frontend\assets\SpectrumAsset',
        'frontend\assets\TouchPunchAsset',
//        'frontend\assets\PlaceholderAsset',
//        'frontend\assets\TagsInputAsset',
//        'frontend\assets\BootstrapSwitchAsset',
//        'frontend\assets\BootstrapSelectAsset',
    ];

    public function init() {
        $this->jsOptions['position'] = View::POS_END;
        parent::init();
    }
}
