<?php
namespace backend\actions;

use Yii;
use yii\base\Action;
use yii\base\ErrorException;

class DeleteAction extends Action
{
    public function run()
    {
        $id = intval(Yii::$app->request->get('id'));
        if (!$id) {
            throw new ErrorException('Model cannot be found');
        }

        $this->controller->findModel($id)->delete();

        return $this->controller->redirect(['index']);
    }
}