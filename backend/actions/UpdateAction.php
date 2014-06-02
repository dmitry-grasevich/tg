<?php
namespace backend\actions;

use Yii;
use yii\base\Action;
use yii\base\ErrorException;

class UpdateAction extends Action
{
    public function run()
    {
        $id = intval(Yii::$app->request->get('id'));
        if (!$id) {
            throw new ErrorException('Model cannot be found');
        }

        $model = $this->controller->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->controller->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->controller->render('update', [
                'model' => $model,
            ]);
        }
    }
}