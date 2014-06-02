<?php

namespace backend\controllers;

use Yii;
use common\models\Functions;
use common\models\search\Functions as FunctionsSearch;

/**
 * FunctionsController implements the CRUD actions for Functions model.
 */
class FunctionsController extends BaseController
{
    protected function setModel()
    {
        $this->_model = new Functions;
    }

    protected function setSearchModel()
    {
        $this->_searchModel = new FunctionsSearch;
    }
}
