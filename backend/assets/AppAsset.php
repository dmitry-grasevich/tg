<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace backend\assets;

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
        'css/bootstrap.min.css',
        'css/highlight.styles/rainbow.css',
//        'css/highlight.styles/obsidian.css',
//        'css/highlight.styles/googlecode.css',
        'css/site.css',
    ];
    public $js = [
        'scripts/highlight.pack.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'frontend\assets\PerfectScrollbarAsset',
    ];

    public function init() {
        $this->jsOptions['position'] = View::POS_END;
        parent::init();
    }
}
