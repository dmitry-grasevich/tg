<?php
namespace backend\controllers;

use Yii;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use common\models\CommonFile;


/**
 * Class SettingsController implements
 * @package backend\controllers
 */
class SettingsController extends Controller
{
    /**
     * Init controller
     */
    public function init()
    {
        $this->layout = 'nifty';
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'remove' => ['post'],
                    'save' => ['post'],
                ],
            ],
        ]);
    }

    public function actionIndex()
    {
        $commonFiles = CommonFile::findAll([]);
        return $this->render('index', ['files' => $commonFiles]);
    }
}
