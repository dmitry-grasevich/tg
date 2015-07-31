<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use common\models\Category;
use common\models\Css;
use common\models\Js;
use common\models\Image;
use common\models\Font;
use common\models\Functions;
use common\models\Template;
use common\models\Plugin;
use \common\models\Element;

/**
 * @var yii\web\View $this
 * @var common\models\Template $model
 */
?>

<?= DetailView::widget([
    'model' => $model,
    'formOptions' => [
        'options' => ['enctype' => 'multipart/form-data']
    ],
    'condensed' => false,
    'hover' => true,
    'mode' => DetailView::MODE_EDIT,
    'panel' => [
        'heading' => $this->title,
        'type' => DetailView::TYPE_INFO,
    ],
    'attributes' => [
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
        [
            'type' => DetailView::INPUT_WIDGET,
            'attribute' => 'category_id',
            'format' => 'raw',
            'value' => $model->category ? $model->category->name : '',
            'widgetOptions' => [
                'class' => DetailView::INPUT_SELECT2,
                'data' => Category::listAll(),
                'options' => ['placeholder' => 'Select Category ...'],
                'pluginOptions' => ['allowClear' => false],
            ],
        ],
        'name',
        'filename',
        'directory',
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
            'attribute' => 'code',
            'format' => 'raw',
            'value' => empty($model->code) ? '' : '<pre class="scroll"><code>' . Html::encode($model->code) . '</code></pre>',
            'type' => DetailView::INPUT_TEXTAREA,
            'options' => [
                'rows' => 15,
                'class' => 'text-monospace'
            ]
        ],
        [
            'attribute' => 'parents',
            'format' => 'raw',
            'type' => DetailView::INPUT_WIDGET,
            'value' => $model->parentsName,
            'widgetOptions' => [
                'class' => DetailView::INPUT_SELECT2,
                'data' => Template::listAll($model->id),
                'options' => [
                    'placeholder' => 'Select Parents ...',
                    'multiple' => true,
                ],
                'pluginOptions' => ['allowClear' => true],
            ],
        ],
        [
            'attribute' => 'children',
            'format' => 'raw',
            'type' => DetailView::INPUT_WIDGET,
            'value' => $model->childrenName,
            'widgetOptions' => [
                'class' => DetailView::INPUT_SELECT2,
                'data' => Template::listAll($model->id),
                'options' => [
                    'placeholder' => 'Select Children ...',
                    'multiple' => true,
                ],
                'pluginOptions' => ['allowClear' => true],
            ],
        ],
        [
            'attribute' => 'css',
            'format' => 'raw',
            'type' => DetailView::INPUT_WIDGET,
            'value' => $model->CssName,
            'widgetOptions' => [
                'class' => DetailView::INPUT_SELECT2,
                'data' => Css::listAll(),
                'options' => [
                    'placeholder' => 'Select Css ...',
                    'multiple' => true,
                ],
                'pluginOptions' => ['allowClear' => true],
            ],
        ],
        [
            'attribute' => 'js',
            'format' => 'raw',
            'type' => DetailView::INPUT_WIDGET,
            'value' => $model->JsName,
            'widgetOptions' => [
                'class' => DetailView::INPUT_SELECT2,
                'data' => Js::listAll(),
                'options' => [
                    'placeholder' => 'Select Js ...',
                    'multiple' => true,
                ],
                'pluginOptions' => ['allowClear' => true],
            ],
        ],
        [
            'attribute' => 'images',
            'format' => 'raw',
            'type' => DetailView::INPUT_WIDGET,
            'value' => $model->ImageName,
            'widgetOptions' => [
                'class' => DetailView::INPUT_SELECT2,
                'data' => Image::listAll(),
                'options' => [
                    'placeholder' => 'Select Images ...',
                    'multiple' => true,
                ],
                'pluginOptions' => ['allowClear' => true],
            ],
        ],
        [
            'attribute' => 'fonts',
            'format' => 'raw',
            'type' => DetailView::INPUT_WIDGET,
            'value' => $model->FontName,
            'widgetOptions' => [
                'class' => DetailView::INPUT_SELECT2,
                'data' => Font::listAll(),
                'options' => [
                    'placeholder' => 'Select Fonts ...',
                    'multiple' => true,
                ],
                'pluginOptions' => ['allowClear' => true],
            ],
        ],
        [
            'attribute' => 'functions',
            'format' => 'raw',
            'type' => DetailView::INPUT_WIDGET,
            'value' => $model->FunctionsName,
            'widgetOptions' => [
                'class' => DetailView::INPUT_SELECT2,
                'data' => Functions::listAll(),
                'options' => [
                    'placeholder' => 'Select Functions ...',
                    'multiple' => true,
                ],
                'pluginOptions' => ['allowClear' => true],
            ],
        ],
        [
            'attribute' => 'plugins',
            'format' => 'raw',
            'type' => DetailView::INPUT_WIDGET,
            'value' => $model->PluginName,
            'widgetOptions' => [
                'class' => DetailView::INPUT_SELECT2,
                'data' => Plugin::listAll(),
                'options' => [
                    'placeholder' => 'Select Plugins ...',
                    'multiple' => true,
                ],
                'pluginOptions' => ['allowClear' => true],
            ],
        ],
        [
            'attribute' => 'elements',
            'format' => 'raw',
            'type' => DetailView::INPUT_WIDGET,
            'value' => $model->elementsName,
            'widgetOptions' => [
                'class' => DetailView::INPUT_SELECT2,
                'data' => Element::listAll(),
                'options' => [
                    'placeholder' => 'Select Elements ...',
                    'multiple' => true,
                ],
                'pluginOptions' => ['allowClear' => true],
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
]) ?>
