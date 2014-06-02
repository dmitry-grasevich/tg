<?php
namespace backend\actions;

use Yii;
use yii\base\Action;
use yii\base\ErrorException;

class IndexAction extends Action
{
    public function run()
    {
        $model = $this->controller->getSearchModel();
        if (!$model) {
            throw new ErrorException('Search model is empty');
        }

        $dataProvider = $model->search(Yii::$app->request->getQueryParams());

        return $this->controller->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $model,
        ]);
    }
}