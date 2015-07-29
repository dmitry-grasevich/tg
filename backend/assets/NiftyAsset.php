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
        'common\assets\PerfectScrollbarAsset',
        'common\assets\HighlightAsset',
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
