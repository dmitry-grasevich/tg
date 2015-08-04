<?php
namespace backend\controllers;

use Yii;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use common\models\CommonFile;
use common\models\Screenshot;

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
                    'screenshot' => ['post'],
                ],
            ],
        ]);
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        $files = CommonFile::find()->where(['!=', 'filename', Screenshot::SCREENSHOT_FILENAME])->orderBy('name desc')->all();
        $screenshot = Screenshot::find()->where(['=', 'filename', Screenshot::SCREENSHOT_FILENAME])->one();
        return $this->render('index', ['files' => $files, 'screenshot' => $screenshot]);
    }

    /**
     * @return string
     * @throws BadRequestHttpException
     */
    public function actionSave()
    {
        $data = Yii::$app->request->post('CommonFile');
        if (!$data['id'] || !array_key_exists('code', $data)) {
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

    /**
     * @return string
     * @throws BadRequestHttpException
     */
    public function actionScreenshot()
    {
        $data = Yii::$app->request->post('Screenshot');
        if (!$data['id']) {
            throw new BadRequestHttpException('Bad request: ' . Json::encode($data));
        }

        /** @var \common\models\Screenshot $file */
        $file = Screenshot::findOne($data['id']);
        if (empty($file)) {
            throw new BadRequestHttpException('Screenshot not found');
        }
        $file->code = $data['code'];

        if (!$file->save()) {
            throw new BadRequestHttpException($file->getErrors());
        }

        return '<div class="screenshot-preview-frame">' . Html::img(Screenshot::getImagePath() . '/' . $file->code) . '</div>';
    }
}
