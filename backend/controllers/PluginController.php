<?php

namespace backend\controllers;

use Yii;
use common\models\Plugin;
use common\models\search\Plugin as PluginSearch;

/**
 * PluginController implements the CRUD actions for Plugin model.
 */
class PluginController extends BaseController
{
    protected function setModel()
    {
        $this->_model = new Plugin;
    }

    protected function setSearchModel()
    {
        $this->_searchModel = new PluginSearch;
    }
}
