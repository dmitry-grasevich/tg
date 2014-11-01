<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var common\models\search\Image $searchModel
 */

$this->title = Yii::t('app', 'Images');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="image-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php Pjax::begin();
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            'name',
            'filename',
            'directory',
            [
                'header' => 'Image',
                'attribute' => 'filename',
                'format' => 'raw',
                'value' => function($model) {
                    return !empty($model->filename) ?
                        Html::img('@web' . Yii::$app->params['template']['alias']['images'] . '/' . $model->filename, ['style' => 'max-width: 400px;']) : false;
                }
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'buttons' => [
                    'update' =>
                        function ($url, $model) {
                            return Html::a('<span class="glyphicon glyphicon-pencil"></span>', Yii::$app->urlManager->createUrl(['image/view','id' => $model->id,'edit'=>'t']), [
                                'title' => Yii::t('yii', 'Edit'),
                            ]);
                        }
                ],
            ],
        ],
        'responsive'=>true,
        'hover'=>true,
        'condensed'=>true,
        'floatHeader'=>true,

        'panel' => [
            'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-th-list"></i> '.Html::encode($this->title).' </h3>',
            'type'=>'info',
            'before'=>Html::a('<i class="glyphicon glyphicon-plus"></i> Add', ['create'], ['class' => 'btn btn-success']), 'after'=>Html::a('<i class="glyphicon glyphicon-repeat"></i> Reset List', ['index'], ['class' => 'btn btn-info']),
            'showFooter'=>false
        ],
    ]);
    Pjax::end();
    ?>

</div>
