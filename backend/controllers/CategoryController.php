<?php
/**
 * CategoryController implements the CRUD actions for Category model.
 */

namespace backend\controllers;

use Yii;
use common\models\Category;
use common\models\search\Category as CategorySearch;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\Response;

class CategoryController extends BaseController
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
        $this->_model = new Category;
    }

    protected function setSearchModel()
    {
        $this->_searchModel = new CategorySearch;
    }

    /**
     * Create/update category
     *
     * @return array
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionSave()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $category = Yii::$app->request->post('Category');
        $model = isset($category['id']) && $category['id'] ?
            $this->findModel($category['id']) : $this->getModel();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return ['success' => $this->renderPartial('/layouts/nifty/navigation/categories', [
                'categories' => Category::findAll(['is_basic' => 0]),
            ])];
        } else {
            return ['errors' => $model->getErrors()];
        }
    }

    /**
     * Remove category
     *
     * @return array
     * @throws \Exception
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionRemove()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $id = intval(Yii::$app->request->post('id'));
        if (!$id) {
            return ['error' => 'Category not found'];
        }

        if ($this->findModel($id)->delete()) {
            return ['success' => $this->renderPartial('/layouts/nifty/navigation/categories', [
                'categories' => Category::findAll(['is_basic' => 0]),
            ])];
        } else {
            return ['errors' => 'Category not deleted'];
        }
    }
}
