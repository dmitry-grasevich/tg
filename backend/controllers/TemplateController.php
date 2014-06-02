<?php

namespace backend\controllers;

use Yii;
use common\models\Template;
use common\models\search\Template as TemplateSearch;

/**
 * TemplateController implements the CRUD actions for Template model.
 */
class TemplateController extends BaseController
{
    protected function setModel()
    {
        $this->_model = new Template;
    }

    protected function setSearchModel()
    {
        $this->_searchModel = new TemplateSearch;
    }
}
