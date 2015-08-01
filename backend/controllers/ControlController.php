<?php

namespace backend\controllers;

use Yii;
use common\models\Control;
use common\models\search\Control as ControlSearch;
use yii\web\BadRequestHttpException;
use yii\web\Response;

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
        Yii::$app->response->format = Response::FORMAT_JSON;

        /** @var string $type   control type */
        $type = Yii::$app->request->get('type');
        if (!$type || Control::isAllowedType($type)) {
            throw new BadRequestHttpException('Bad control type');
        }

        /** @var integer $id   control id */
        $id = (int)Yii::$app->request->get('id');

        /** @var integer $controlId   id of control assigned to a section */
        $controlId = (int)Yii::$app->request->get('controlId');

        return true;
    }
}
