<?php
namespace backend\actions;

use Yii;
use yii\base\Action;
use yii\base\ErrorException;

class CreateAction extends Action
{
    public function run()
    {
        $model = $this->controller->getModel();
        if (!$model) {
            throw new ErrorException('Model is empty');
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->controller->redirect(['view', 'id' => $model->id]);
        } else {
            Yii::$app->request->setQueryParams(['edit' => 't']);
            return $this->controller->render('create', [
                'model' => $model,
            ]);
        }
    }
}