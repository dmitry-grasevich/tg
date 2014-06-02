<?php

namespace backend\controllers;

use Yii;
use common\models\Css;
use common\models\search\Css as CssSearch;

/**
 * CssController implements the CRUD actions for Css model.
 */
class CssController extends BaseController
{
    protected function setModel()
    {
        $this->_model = new Css;
    }

    protected function setSearchModel()
    {
        $this->_searchModel = new CssSearch;
    }
}
