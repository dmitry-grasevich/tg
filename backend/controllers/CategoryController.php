<?php

namespace backend\controllers;

use Yii;
use common\models\TemplateCategory;
use common\models\search\TemplateCategory as TemplateCategorySearch;

/**
 * CategoryController implements the CRUD actions for TemplateCategory model.
 */
class CategoryController extends BaseController
{
    protected function setModel()
    {
        $this->_model = new TemplateCategory;
    }

    protected function setSearchModel()
    {
        $this->_searchModel = new TemplateCategorySearch;
    }
}
