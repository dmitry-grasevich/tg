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
    public $css = [];
    public $js = [];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\jui\JuiAsset',
        'frontend\assets\SpectrumAsset',
        'frontend\assets\TouchPunchAsset',
        'frontend\assets\PerfectScrollbarAsset',
        'frontend\assets\HistoryAsset',
        'frontend\assets\ModernizrAsset',
        'frontend\assets\CommonJsAsset',
        'frontend\assets\CommonCssAsset',
    ];

    public function init() {
        $this->jsOptions['position'] = View::POS_END;
        parent::init();
    }
}
