<?php
namespace backend\controllers;

use Yii;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use common\models\Category;
use common\models\Template;
use common\models\search\Template as TemplateSearch;
use yii\web\Response;

/**
 * Class TemplateController implements the CRUD actions for Template model.
 * @package backend\controllers
 */
class TemplateController extends BaseController
{
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

    protected function setModel()
    {
        $this->_model = new Template;
    }

    protected function setSearchModel()
    {
        $this->_searchModel = new TemplateSearch;
    }

    /**
     * Create/Edit template
     *
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionEdit()
    {
        /** @var string $cat   category id */
        $cat = (int)Yii::$app->request->get('cat');
        if (!$cat) {
            throw new NotFoundHttpException('Page not fount');
        }

        /** @var string $id   template id */
        $id = (int)Yii::$app->request->get('id');

        /** @var \common\models\Template $template */
        $template = $id ? $this->findModel($id) : $this->getModel();

        if (Yii::$app->request->isPost) {
            if ($template->load(Yii::$app->request->post()) && $template->save()) {
                $this->redirect(['view', 'id' => $template->id]);
            }
        }

        return $this->render('edit', [
            'category' => Category::findOne($cat),
            'template' => $template,
        ]);
    }

    /**
     * View template
     *
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView()
    {
        /** @var string $id   template id */
        $id = (int)Yii::$app->request->get('id');
        if (!$id) {
            throw new NotFoundHttpException('Page not fount');
        }

        /** @var \common\models\Template $template */
        $template = $this->findModel($id);

        if (Yii::$app->request->isPost) {
//            if ($template->load(Yii::$app->request->post()) && $template->save()) {
//                $this->redirect(['view', 'id' => $template->id]);
//            }
        }

        return $this->render('view', [
            'template' => $template,
        ]);
    }

    /**
     * Load all customizer's controls
     *
     * @throws NotFoundHttpException
     */
    public function actionCustomizer()
    {
        /** @var string $id   template id */
        $id = (int)Yii::$app->request->get('id');
        if (!$id) {
            throw new BadRequestHttpException('Unknown template');
        }

        Yii::$app->response->format = Response::FORMAT_JSON;

        return Template::getCustomizerControls($id);
    }
}
