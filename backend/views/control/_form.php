<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use common\models\Control;

/**
 * @var yii\web\View $this
 * @var common\models\Control $model
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
        [
            'attribute' => 'family',
            'format' => 'raw',
            'type' => DetailView::INPUT_WIDGET,
            'value' => $model->family,
            'widgetOptions' => [
                'class' => DetailView::INPUT_SELECT2,
                'data' => Control::listFamilies(),
                'options' => [
                    'placeholder' => 'Select Family...',
                    'multiple' => false,
                ],
                'pluginOptions' => ['allowClear' => true],
            ],
        ],
        'type',
        'class',
        'name',
        [
            'type' => DetailView::INPUT_WIDGET,
            'attribute' => 'img',
            'format' => 'raw',
            'value' => $model->img ? Html::img(Yii::getAlias('@web/images') . '/' . $model->img, ['class'=>'file-preview-image']) : false,
            'widgetOptions' => [
                'class' => '\kartik\widgets\FileInput',
                'options' => ['accept' => 'image/*'],
                'pluginOptions' => [
                    'showUpload' => false,
                    'initialPreview' => $model->img ? [
                        Html::img(Yii::getAlias('@web/images') . '/' . $model->img, ['class'=>'file-preview-image']),
                    ] : false,
                ],
            ],
        ],
        [
            'attribute' => 'params',
            'format' => 'raw',
            'value' => empty($model->params) ? '' : '<pre class="scroll"><code class="php">' . Html::encode($model->params) . '</code></pre>',
            'type' => DetailView::INPUT_TEXTAREA,
            'options' => [
                'rows' => 15,
                'class' => 'text-monospace'
            ]
        ],
        [
            'attribute' => 'css',
            'format' => 'raw',
            'value' => empty($model->css) ? '' : '<pre class="scroll"><code class="php">' . Html::encode($model->css) . '</code></pre>',
            'type' => DetailView::INPUT_TEXTAREA,
            'options' => [
                'rows' => 15,
                'class' => 'text-monospace'
            ]
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
