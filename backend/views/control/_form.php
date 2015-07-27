<?php

use yii\helpers\Html;
use kartik\detail\DetailView;

/**
 * @var yii\web\View $this
 * @var common\models\Control $model
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
            'format' => 'raw',
            'value' => empty($model->code) ? '' : '<pre class="scroll"><code class="php">' . Html::encode($model->code) . '</code></pre>',
            'type' => DetailView::INPUT_TEXTAREA,
            'options' => [
                'rows' => 15,
                'class' => 'text-monospace'
            ]
        ],
        [
            'attribute' => 'styles_code',
            'format' => 'raw',
            'value' => empty($model->styles_code) ? '' : '<pre class="scroll"><code class="php">' . Html::encode($model->styles_code) . '</code></pre>',
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
