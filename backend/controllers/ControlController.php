<?php

namespace backend\controllers;

use Yii;
use common\models\Control;
use common\models\search\Control as ControlSearch;
use common\models\Section;
use common\models\SectionControl;
use yii\db\ActiveRecord;
use yii\web\BadRequestHttpException;

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

    public function actionSettings()
    {
        /** @var string $type   control type */
        $type = Yii::$app->request->get('type');
        if (empty($type) || !Control::isAllowedType($type)) {
            throw new BadRequestHttpException('Unknown control type');
        }

        /** @var integer $id   section/section_control id */
        $id = (int)Yii::$app->request->get('id');

        $class = $type == Control::TYPE_SECTION ? Section::className() : SectionControl::className();
        /** @var ActiveRecord $class */
        $model = $id ? $class::findOne($id) : new $class();

        return $this->renderAjax($type, ['model' => $model]);
    }
}
