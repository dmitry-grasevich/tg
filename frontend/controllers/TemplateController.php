<?php

namespace frontend\controllers;

use common\models\TemplateGenerator;
use yii\web\Controller;

class TemplateController extends Controller
{
    public function actionIndex($q)
    {
        TemplateGenerator::create($q);
//        return $this->render('index');
        return;
    }

}
