<?php

namespace backend\controllers;

use Yii;
use common\models\Element;
use common\models\search\Element as ElementSearch;

/**
 * ElementController implements the CRUD actions for Element model.
 */
class ElementController extends BaseController
{
    protected function setModel()
    {
        $this->_model = new Element;
    }

    protected function setSearchModel()
    {
        $this->_searchModel = new ElementSearch;
    }
}
