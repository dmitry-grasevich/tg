<?php

use yii\helpers\Html;
use kartik\detail\DetailView;

/**
 * @var yii\web\View $this
 * @var common\models\Plugin $model
 */
?>

<?=
DetailView::widget([
    'model' => $model,
    'formOptions' => [
        'options' => ['enctype' => 'multipart/form-data']
    ],
    'condensed' => false,
    'hover' => true,
    'mode' => Yii::$app->request->get('edit') == 't' ? DetailView::MODE_EDIT : DetailView::MODE_VIEW,
    'panel' => [
        'heading' => $this->title,
        'type' => DetailView::TYPE_INFO,
    ],
    'attributes' => [
        'name',
        [
            'type' => DetailView::INPUT_WIDGET,
            'attribute' => 'filename',
            'format' => 'raw',
            'widgetOptions' => [
                'class' => DetailView::INPUT_FILEINPUT,
                'pluginOptions' => [
                    'showUpload' => false,
                    'initialPreview' => false,
                ],
            ],
        ],
        'directory',
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
