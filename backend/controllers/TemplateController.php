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

        $category = Category::findOne($cat);
        return $this->render('new', ['category' => $category]);
    }
}
