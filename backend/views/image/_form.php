<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use common\models\Image;

/**
 * @var yii\web\View $this
 * @var common\models\Image $model
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
            'value' => $model->filename ? Html::img($model->getUrl(), ['class' => 'file-preview-image']) : false,
            'widgetOptions' => [
                'class' => DetailView::INPUT_FILEINPUT,
                'options' => ['accept' => 'image/*'],
                'pluginOptions' => [
                    'showUpload' => false,
                    'initialPreview' => $model->filename ? [Html::img($model->getUrl(), ['class' => 'file-preview-image'])] : false,
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
