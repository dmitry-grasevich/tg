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
                    'new' => ['get'],
                    'edit' => ['get'],
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
     * Create new template in category
     *
     * @param string $cat   category id
     *
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionNew($cat = '')
    {
        if (empty($cat)) {
            throw new NotFoundHttpException('Page not fount');
        }

        return $this->render('new', [
            'category' => Category::findOne($cat),
            'template' => new Template(),
        ]);
    }

    /**
     * Edit template
     *
     * @param string $id   template id
     *
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionEdit($id)
    {
        if (empty($id)) {
            throw new NotFoundHttpException('Page not fount');
        }

        return $this->render('edit', [
            'template' => Template::findOne($id),
        ]);
    }
}
