<?php
/**
 * TemplateController implements the CRUD actions for Template model.
 */

namespace backend\controllers;

use common\models\Category;
use Yii;
use common\models\Template;
use common\models\search\Template as TemplateSearch;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\VarDumper;
use yii\web\NotFoundHttpException;
use yii\web\Response;

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
        $cat = Yii::$app->request->get('cat');
        if (empty($cat)) {
            throw new NotFoundHttpException('Page not fount');
        }

        /** @var string $id   template id */
        $id = Yii::$app->request->get('id');

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
}
