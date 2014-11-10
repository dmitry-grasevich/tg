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

/**
 * @var yii\web\View $this
 * @var common\models\Template $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<?= DetailView::widget([
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
            'attribute' => 'is_visible',
            'format' => 'raw',
            'type' => '\kartik\widgets\SwitchInput',
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
        [
            'attribute' => 'category_id',
            'format' => 'raw',
            'type' => '\kartik\widgets\Select2',
            'value' => $model->category ? $model->category->name : '',
            'widgetOptions' => [
                'data' => Category::listAll(),
                'options' => ['placeholder' => 'Select Category ...'],
                'pluginOptions' => ['allowClear' => false],
            ],
        ],
        'name',
        'filename',
        'directory',
        [
            'attribute' => 'img',
            'format' => 'raw',
            'type' => '\kartik\file\FileInput',
            'value' => $model->img ? Html::img(Yii::getAlias('@web/images') . '/' . $model->img, ['class'=>'file-preview-image']) : false,
            'widgetOptions' => [
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
            'value' => '<pre class="scroll"><code>' . Html::encode($model->code) . '</code></pre>',
            'type' => DetailView::INPUT_TEXTAREA,
            'options' => [
                'rows' => 15,
                'class' => 'text-monospace'
            ]
        ],
        [
            'attribute' => 'parents',
            'format' => 'raw',
            'type' => DetailView::INPUT_SELECT2,
            'value' => $model->parentsName,
            'widgetOptions' => [
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
            'type' => DetailView::INPUT_SELECT2,
            'value' => $model->childrenName,
            'widgetOptions' => [
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
            'type' => DetailView::INPUT_SELECT2,
            'value' => $model->CssName,
            'widgetOptions' => [
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
            'type' => DetailView::INPUT_SELECT2,
            'value' => $model->JsName,
            'widgetOptions' => [
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
            'type' => DetailView::INPUT_SELECT2,
            'value' => $model->ImageName,
            'widgetOptions' => [
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
            'type' => DetailView::INPUT_SELECT2,
            'value' => $model->FontName,
            'widgetOptions' => [
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
            'type' => DetailView::INPUT_SELECT2,
            'value' => $model->FunctionsName,
            'widgetOptions' => [
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
            'type' => DetailView::INPUT_SELECT2,
            'value' => $model->PluginName,
            'widgetOptions' => [
                'data' => Plugin::listAll(),
                'options' => [
                    'placeholder' => 'Select Plugins ...',
                    'multiple' => true,
                ],
                'pluginOptions' => ['allowClear' => true],
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
]) ?>
