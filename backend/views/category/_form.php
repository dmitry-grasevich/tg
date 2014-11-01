<?php

use kartik\detail\DetailView;

/**
 * @var yii\web\View $this
 * @var common\models\Category $model
 * @var yii\widgets\ActiveForm $form
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
            'attribute' => 'is_basic',
            'format' => 'raw',
            'type' => DetailView::INPUT_SWITCH,
            'value' => $model->is_basic ? '<i class="glyphicon glyphicon-ok text-success"></i>' :
                '<i class="glyphicon glyphicon-remove text-danger"></i>',
            'widgetOptions' => [
                'pluginOptions' => [
                    'onText' => '<i class="glyphicon glyphicon-ok"></i>',
                    'offText' => '<i class="glyphicon glyphicon-remove"></i>',
                    'onColor' => 'success',
                    'offColor' => 'danger',
                ],
            ],
        ],
        [
            'attribute' => 'is_visible',
            'format' => 'raw',
            'type' => DetailView::INPUT_SWITCH,
            'value' => $model->is_visible ? '<i class="glyphicon glyphicon-ok text-success"></i>' :
                '<i class="glyphicon glyphicon-remove text-danger"></i>',
            'widgetOptions' => [
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
            'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
            'method' => 'post',
        ],
    ],
    'enableEditMode' => true,
])
?>
