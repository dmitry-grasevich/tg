<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var common\models\search\Template $searchModel
 */

$this->title = Yii::t('tg', 'Templates');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="template-index">
    <?= Html::a('<i class="glyphicon glyphicon-plus"></i> Create Template', ['create'], ['class' => 'btn btn-success']); ?>
    <?= GridView::widget([
        'id' => 'templates-grid',
        'dataProvider' => $dataProvider,
        'resizableColumns' => false,
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
        'responsive' => false,
        'hover' => true,
        'condensed' => true,
        'floatHeader' => false,
        'export' => false,
        'pjax' => true,
    ]) ?>

</div>
