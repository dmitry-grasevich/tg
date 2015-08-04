<?php
namespace backend\controllers;

use Yii;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
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
                    'index' => ['get'],
                    'save' => ['post'],
                ],
            ],
        ]);
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        $commonFiles = CommonFile::find()->orderBy('name desc')->all();
        return $this->render('index', ['files' => $commonFiles]);
    }

    /**
     * @return string
     * @throws BadRequestHttpException
     */
    public function actionSave()
    {
        $data = Yii::$app->request->post('CommonFile');
        if (!$data['id']) {
            throw new BadRequestHttpException('Bad request');
        }

        /** @var \common\models\CommonFile $file */
        $file = CommonFile::findOne($data['id']);
        if (empty($file)) {
            throw new BadRequestHttpException('Common File not found');
        }
        $file->code = $data['code'];

        if (!$file->save()) {
            throw new BadRequestHttpException($file->getErrors());
        }

        return Html::tag('pre', Html::tag('code', Html::encode($file->code)), ['class' => 'scroll']);
    }
}
