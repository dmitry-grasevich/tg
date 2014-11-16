<?php

namespace backend\controllers;

use Yii;
use common\models\Section;
use common\models\search\Section as SectionSearch;
use yii\helpers\ArrayHelper;
use backend\actions\SectionViewAction;

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

    // Use Standalone Actions
    public function actions()
    {
        return ArrayHelper::merge(parent::actions(), [
            'view' => ['class' => SectionViewAction::className() ],
        ]);
    }
}
