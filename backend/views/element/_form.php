<?php

use yii\helpers\Html;
use kartik\detail\DetailView;

/**
 * @var yii\web\View $this
 * @var common\models\Element $model
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
        'identificator',
        'description',
        [
            'type' => DetailView::INPUT_WIDGET,
            'attribute' => 'section_id',
            'format' => 'raw',
            'value' => $model->section ? $model->section->name : '',
            'widgetOptions' => [
                'class' => DetailView::INPUT_SELECT2,
                'data' => \common\models\Section::listAll(),
                'options' => ['placeholder' => 'Select Section ...'],
                'pluginOptions' => ['allowClear' => false],
            ],
        ],
        'css_selector',
        [
            'type' => DetailView::INPUT_WIDGET,
            'attribute' => 'priority',
            'format' => 'raw',
            'value' => $model->priority,
            'widgetOptions' => [
                'class' => DetailView::INPUT_SPIN,
                'data' => \common\models\Section::listAll(),
                'options' => [
                    'class' => 'form-control',
                    'placeholder' => 'Enter Priority',
                ],
                'pluginOptions' => [
                    'initval' => intval($model->priority),
                    'min' => 0,
                    'max' => 100,
                    'step' => 10,
                    'verticalbuttons' => true,
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
