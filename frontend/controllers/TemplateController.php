<?php

namespace frontend\controllers;

use common\models\TemplateGenerator;
use yii\web\Controller;

class TemplateController extends Controller
{
    public function actionIndex()
    {
        $q = \Yii::$app->request->get();
        if (!isset($q['name']) || empty($q['name'])) {
            return ['error' => 'Theme name is empty'];
        }

        if (!isset($q['blocks']) || empty($q['blocks'])) {
            return ['error' => 'Your template has no block! Please add one or more.'];
        }
        TemplateGenerator::create($q);
    }

}
