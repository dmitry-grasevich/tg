<?php

use kartik\detail\DetailView;

/**
 * @var yii\web\View $this
 * @var common\models\Category $model
 */
?>

<?=
DetailView::widget([
    'model' => $model,
    'condensed' => false,
    'hover' => true,
    'mode' => Yii::$app->request->get('edit') == 't' ? DetailView::MODE_EDIT : DetailView::MODE_VIEW,
    'panel' => [
        'heading' => $this->title,
        'type' => DetailView::TYPE_INFO,
    ],
    'attributes' => [
        'name',
        'alias',
        [
            'type' => DetailView::INPUT_WIDGET,
            'attribute' => 'is_basic',
            'format' => 'raw',
            'value' => $model->is_basic ? '<i class="glyphicon glyphicon-ok text-success"></i>' :
                '<i class="glyphicon glyphicon-remove text-danger"></i>',
            'widgetOptions' => [
                'class' => DetailView::INPUT_SWITCH,
                'pluginOptions' => [
                    'onText' => '<i class="glyphicon glyphicon-ok"></i>',
                    'offText' => '<i class="glyphicon glyphicon-remove"></i>',
                    'onColor' => 'success',
                    'offColor' => 'danger',
                ],
            ],
        ],
        [
            'type' => DetailView::INPUT_WIDGET,
            'attribute' => 'is_visible',
            'format' => 'raw',
            'value' => $model->is_visible ? '<i class="glyphicon glyphicon-ok text-success"></i>' :
                '<i class="glyphicon glyphicon-remove text-danger"></i>',
            'widgetOptions' => [
                'class' => DetailView::INPUT_SWITCH,
                'pluginOptions' => [
                    'onText' => '<i class="glyphicon glyphicon-ok"></i>',
                    'offText' => '<i class="glyphicon glyphicon-remove"></i>',
                    'onColor' => 'success',
                    'offColor' => 'danger',
                ],
            ],
        ],
    ],
    'deleteOptions' => [
        'url' => ['delete', 'id' => $model->id],
        'data' => [
            'confirm' => Yii::t('tg', 'Are you sure you want to delete this item?'),
            'method' => 'post',
        ],
    ],
    'enableEditMode' => true,
])
?>
