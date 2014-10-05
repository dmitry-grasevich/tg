<?php

namespace frontend\controllers;

use common\models\TemplateGenerator;
use yii\web\Controller;

class TemplateController extends Controller
{
    public function actionIndex()
    {
        $q = \Yii::$app->request->post();
//        TemplateGenerator::create($q);
//        return $this->render('index');
        var_dump($q);
        return;
    }

}
