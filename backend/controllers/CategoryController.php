<?php

namespace backend\controllers;

use Yii;
use common\models\Category;
use common\models\search\Category as CategorySearch;

/**
 * CategoryController implements the CRUD actions for Category model.
 */
class CategoryController extends BaseController
{
    protected function setModel()
    {
        $this->_model = new Category;
    }

    protected function setSearchModel()
    {
        $this->_searchModel = new CategorySearch;
    }
}
