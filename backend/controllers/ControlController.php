<?php

namespace backend\controllers;

use Yii;
use common\models\Control;
use common\models\search\Control as ControlSearch;

/**
 * ControlController implements the CRUD actions for Control model.
 */
class ControlController extends BaseController
{
    protected function setModel()
    {
        $this->_model = new Control;
    }

    protected function setSearchModel()
    {
        $this->_searchModel = new ControlSearch;
    }
}
