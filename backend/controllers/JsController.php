<?php

namespace backend\controllers;

use Yii;
use common\models\Js;
use common\models\search\Js as JsSearch;

/**
 * JsController implements the CRUD actions for Js model.
 */
class JsController extends BaseController
{
    protected function setModel()
    {
        $this->_model = new Js;
    }

    protected function setSearchModel()
    {
        $this->_searchModel = new JsSearch;
    }
}
