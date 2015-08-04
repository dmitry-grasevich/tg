<?php
namespace backend\controllers;

use Yii;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use common\models\File;
use common\models\Screenshot;
use yii\web\Response;

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
                    'additional' => ['get'],
                    'save' => ['post'],
                    'save-additional' => ['post'],
                    'remove-additional' => ['post'],
                    'screenshot' => ['post'],
                    'file-panel' => ['post'],
                ],
            ],
        ]);
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        $files = File::find()->common()->orderBy('name desc')->all();
        $screenshot = Screenshot::find()->screenshot()->one();
        return $this->render('index', ['files' => $files, 'screenshot' => $screenshot]);
    }

    /**
     * @return string
     */
    public function actionAdditional()
    {
        $files = File::find()->additional()->orderBy('filename')->all();
        return $this->render('add', ['files' => $files]);
    }

    /**
     * @return string
     * @throws BadRequestHttpException
     */
    public function actionSave()
    {
        $data = Yii::$app->request->post('File');
        if (!$data['id'] || !array_key_exists('code', $data)) {
            throw new BadRequestHttpException('Bad request');
        }

        /** @var \common\models\File $file */
        $file = File::findOne($data['id']);
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
    public function actionSaveAdditional()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $data = Yii::$app->request->post('File');

        /** @var \common\models\File $file */
        $file = isset($data['id']) && $data['id'] ? File::findOne($data['id']) : new File();

        if ($file->load(Yii::$app->request->post()) && $file->save()) {
            return ['success' => $this->renderAjax('_panel', [
                'file' => $file,
                'isCommon' => false,
                'isRemovable' => true,
                'id' => $file->id,
            ])];
        } else {
            return ['errors' => $file->getErrors()];
        }
    }

    /**
     * @return string
     * @throws BadRequestHttpException
     */
    public function actionRemoveAdditional()
    {
        /** @var string $id   template id */
        $id = intval(Yii::$app->request->post('id'));
        if (!$id) {
            throw new BadRequestHttpException('File cannot be found');
        }

        File::findOne($id)->delete();
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

    /**
     * @return string
     * @throws BadRequestHttpException
     */
    public function actionFilePanel()
    {
        $id = Yii::$app->request->post('id');
        if (!$id) {
            throw new BadRequestHttpException('Bad request');
        }

        return $this->renderAjax('_panel', [
            'file' => new File(),
            'isCommon' => false,
            'id' => $id,
        ]);
    }
}
