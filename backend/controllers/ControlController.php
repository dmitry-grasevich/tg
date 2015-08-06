<?php

namespace backend\controllers;

use Yii;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\db\ActiveRecord;
use yii\web\BadRequestHttpException;
use common\models\Control;
use common\models\search\Control as ControlSearch;
use common\models\Section;
use common\models\SectionControl;

/**
 * ControlController implements the CRUD actions for Control model.
 */
class ControlController extends BaseController
{
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'settings' => ['get'],
                    'remove' => ['post'],
                ],
            ],
        ]);
    }

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
        $id = intval(Yii::$app->request->get('id'));

        /** @var ActiveRecord $class */
        $class = $type == Control::TYPE_SECTION ? Section::className() : SectionControl::className();
        $model = $id ? $class::findOne($id) : new $class();

        return $this->renderAjax($type, ['model' => $model]);
    }

    /**
     * Remove control or section
     *
     * @throws BadRequestHttpException
     */
    public function actionRemove()
    {
        /** @var string $type   control type */
        $type = Yii::$app->request->post('type');
        if (empty($type) || !Control::isAllowedType($type)) {
            throw new BadRequestHttpException('Unknown control type: ' . $type);
        }

        /** @var string $id   control id */
        $id = intval(Yii::$app->request->post('id'));

        /** @var ActiveRecord $class */
        $class = $type == Control::TYPE_SECTION ? Section::className() : SectionControl::className();

        /** @var \common\models\SectionControl $control */
        $control = $class::findOne($id);
        if (!$control) {
            throw new BadRequestHttpException('Control not found');
        }

        $control->delete();
    }
}
