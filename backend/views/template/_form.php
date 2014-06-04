<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use common\models\TemplateCategory;
use common\models\Css;
use common\models\Js;
use common\models\Functions;
use common\models\Template;

/**
 * @var yii\web\View $this
 * @var common\models\Template $model
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
        [
            'attribute' => 'category_id',
            'format' => 'raw',
            'type' => DetailView::INPUT_SELECT2,
            'value' => $model->category ? $model->category->name : '',
            'widgetOptions' => [
                'data' => TemplateCategory::listAll(),
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
            'type' => DetailView::INPUT_FILEINPUT,
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
            'format' => 'ntext',
            'value' => $model->code,
            'type' => DetailView::INPUT_TEXTAREA,
            'options' => ['rows' => 15]
        ],
        [
            'attribute' => 'parents',
            'format' => 'raw',
            'type' => DetailView::INPUT_SELECT2,
            'value' => $model->parentsName,
            'widgetOptions' => [
                'data' => Template::listAll([$model->id]),
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
                'data' => Template::listAll([$model->id]),
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
