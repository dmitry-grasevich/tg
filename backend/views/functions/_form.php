<?php

use kartik\detail\DetailView;
use common\models\Template;
use \yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var common\models\Functions $model
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
        [
            'type' => DetailView::INPUT_WIDGET,
            'attribute' => 'parent_id',
            'format' => 'raw',
            'value' => $model->parent ? $model->parent->name : '',
            'widgetOptions' => [
                'class' => DetailView::INPUT_SELECT2,
                'data' => Template::listAll(),
                'options' => ['placeholder' => 'Select Common Functions'],
                'pluginOptions' => ['allowClear' => false],
            ],
        ],
        'name',
        [
            'attribute' => 'code',
            'format' => 'raw',
            'value' => '<pre class="scroll"><code class="php">' . Html::encode($model->code) . '</code></pre>',
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
