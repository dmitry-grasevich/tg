<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\datecontrol\DateControl;
use common\models\TemplateCategory;
use yii\helpers\ArrayHelper;
use common\models\Css;
use common\models\Js;
use common\models\Functions;

/**
 * @var yii\web\View $this
 * @var common\models\Template $model
 */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Templates'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="template-view">
    <?=
    DetailView::widget([
        'model' => $model,
        'formOptions' => [
            'options' => ['enctype'=>'multipart/form-data']
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
                'widgetOptions' => [
                    'data' => TemplateCategory::listAll(),
                    'options' => ['placeholder' => 'Select Category ...'],
                    'pluginOptions' => ['allowClear' => true],
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
                'attribute' => 'templateCsses',
                'format' => 'raw',
                'type' => DetailView::INPUT_SELECT2,
                'value' => $model->CssesName,
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
                'attribute' => 'templateJses',
                'format' => 'raw',
                'type' => DetailView::INPUT_SELECT2,
                'value' => $model->JsesName,
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
                'attribute' => 'templateFunctions',
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

</div>
