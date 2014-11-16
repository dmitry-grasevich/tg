<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var common\models\search\Template $searchModel
 */

$this->title = Yii::t('app', 'Templates');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="template-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php Pjax::begin();
    echo GridView::widget([
        'id' => 'templates-grid',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute' => 'id',
                'width' => '25px',
            ],
            [
                'header' => ' ',
                'class' => '\kartik\grid\BooleanColumn',
                'attribute' => 'is_visible',
                'width' => '25px',
                'vAlign' => 'top',
            ],
            'name',
            'categoryName',
            [
                'header' => 'Elements',
                'format' => 'raw',
                'value' => function($model) {
                    return $model->elementsName;
                }
            ],
            [
                'header' => 'Preview Image',
                'attribute' => 'img',
                'format' => 'raw',
                'value' => function($model) {
                    return !empty($model->img) ? Html::img('/images/' . $model->img, ['style' => 'max-width: 400px;']) : false;
                }
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'buttons' => [
                    'update' => function ($url, $model) {
                            return Html::a('<span class="glyphicon glyphicon-pencil"></span>', Yii::$app->urlManager->createUrl(['template/view', 'id' => $model->id, 'edit' => 't']), [
                                'title' => Yii::t('yii', 'Edit'),
                            ]);
                        }

                ],
            ],
        ],
        'responsive' => true,
        'hover' => true,
        'condensed' => true,
        'floatHeader' => true,
        'export' => false,

        'panel' => [
            'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-th-list"></i> ' . Html::encode($this->title) . ' </h3>',
            'type' => 'info',
            'before' => Html::a('<i class="glyphicon glyphicon-plus"></i> Create Template', ['create'], ['class' => 'btn btn-success']), 'after' => Html::a('<i class="glyphicon glyphicon-repeat"></i> Reset List', ['index'], ['class' => 'btn btn-info']),
            'showFooter' => false
        ],
    ]);
    Pjax::end(); ?>

</div>
