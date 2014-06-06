<?php

use yii\helpers\Html;
use kartik\detail\DetailView;

/**
 * @var yii\web\View $this
 * @var common\models\Image $model
 * @var yii\widgets\ActiveForm $form
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
            'attribute' => 'filename',
            'format' => 'raw',
            'type' => DetailView::INPUT_FILEINPUT,
            'value' => $model->filename ? Html::img(Yii::getAlias('@web/templateImages') . '/' . $model->filename, ['class'=>'file-preview-image']) : false,
            'widgetOptions' => [
                'options' => ['accept' => 'image/*'],
                'pluginOptions' => [
                    'showUpload' => false,
                    'initialPreview' => $model->filename ? [
                            Html::img(Yii::getAlias('@web/templateImages') . '/' . $model->filename, ['class'=>'file-preview-image']),
                        ] : false,
                ],
            ],
        ],
        'directory',
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
