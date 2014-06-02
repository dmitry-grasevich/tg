<?php

use kartik\detail\DetailView;

/**
 * @var yii\web\View $this
 * @var common\models\Js $model
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
        [
            'attribute' => 'code',
            'format' => 'ntext',
            'value' => $model->code,
            'type' => DetailView::INPUT_TEXTAREA,
            'options' => ['rows' => 15]
        ],
        'filename',
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
