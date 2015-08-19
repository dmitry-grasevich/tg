<?php
namespace backend\controllers;

use Yii;
use yii\db\ActiveRecord;
use yii\web\Controller;
use yii\filters\VerbFilter;
use backend\actions\CreateAction;
use backend\actions\IndexAction;
use backend\actions\UpdateAction;
use backend\actions\DeleteAction;
use backend\actions\ViewAction;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;

/**
 * Class BaseController
 * @package backend\controllers
 */
abstract class BaseController extends Controller implements BaseControllerInterface
{
    /**
     * @var \yii\db\ActiveRecord
     */
    protected $_model;

    /**
     * @var
     */
    protected $_searchModel;

    /**
     * Init models
     */
    public function init()
    {
        $this->layout = 'nifty';
        $this->setModel();
        $this->setSearchModel();
    }

    /**
     * Use Standalone Actions
     *
     * @return array
     */
    public function actions()
    {
        return [
            'create' => ['class' => CreateAction::className()],
            'index' => ['class' => IndexAction::className()],
            'update' => ['class' => UpdateAction::className()],
            'delete' => ['class' => DeleteAction::className()],
            'view' => ['class' => ViewAction::className()],
        ];
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @return ActiveRecord
     */
    public function getModel()
    {
        return $this->_model;
    }

    public function getSearchModel()
    {
        return $this->_searchModel;
    }

    /**
     * @param $id
     * @return ActiveRecord
     * @throws NotFoundHttpException
     */
    public function findModel($id)
    {
        $m = $this->getModel();
        $class = $m::className();
        if (($model = $class::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    abstract protected function setModel();

    abstract protected function setSearchModel();
}