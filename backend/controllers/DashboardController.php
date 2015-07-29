<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;

/**
 * DashboardController
 */
class DashboardController extends Controller
{
    /**
     * Init models
     */
    public function init()
    {
        $this->layout = 'nifty';
    }

    /**
     *
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
