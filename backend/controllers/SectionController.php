<?php

namespace backend\controllers;

use Yii;
use common\models\Section;
use common\models\search\Section as SectionSearch;

/**
 * SectionController implements the CRUD actions for Section model.
 */
class SectionController extends BaseController
{
    protected function setModel()
    {
        $this->_model = new Section;
    }

    protected function setSearchModel()
    {
        $this->_searchModel = new SectionSearch;
    }
}
