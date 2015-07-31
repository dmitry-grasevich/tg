<?php
/**
 * @var yii\web\View $this
 * @var common\models\Category $category
 * @var common\models\Template $template
 */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Button;
use kartik\widgets\FileInput;

$title = Yii::t('tg', $template->isNewRecord ? 'New Block in category "{category}"' :
    'Edit Block "{template}" in category "{category}"', [
    'category' => $category->name,
    'template' => $template->name,
]);

$this->title = $title;

$labels = $template->attributeLabels();
?>

<div id="page-title">
    <h1 class="page-header text-overflow"><?= $title ?></h1>
</div>

<div class="col-md-8 col-md-offset-2">
    <?php $form = ActiveForm::begin([
        'id' => 'template-form',
        'class' => 'form-horizontal',
        'options' => [
            'enctype' => 'multipart/form-data'
        ]
    ]); ?>

    <div class="checkbox">
        <label class="form-checkbox form-normal form-success form-text">
            <?= Html::checkbox('Template[is_visible]', $template->is_visible) . ' ' . $labels['is_visible'] ?>
        </label>
    </div>

    <?= $form->field($template, 'name')->textInput([
        'placeholder' => Yii::t('tg', 'Internal system name (usually equal to Title)'),
    ]) ?>

    <?= $form->field($template, 'alias')->textInput([
        'placeholder' => Yii::t('tg', 'lowercase without spaces, wil be used as index in the customizer\'s panels array'),
    ]) ?>

    <?= $form->field($template, 'title')->textInput([
        'placeholder' => Yii::t('tg', 'Title of panel in the customizer'),
    ]) ?>

    <?= $form->field($template, 'description')->textarea([
        'class' => 'form-control',
        'rows' => 5,
        'placeholder' => Yii::t('tg', 'Description of panel in the customizer'),
    ]) ?>

    <?= $form->field($template, 'img')->widget(FileInput::className(), [
        'options' => [
            'accept' => 'image/*',
        ],
        'pluginOptions' => [
            'showUpload' => false,
            'previewSettings' => [
                'image' => [
                    'width' => '100%',
                    'height' => 'auto',
                ]
            ],
            'initialPreview' => $template->img ? [
                Html::img($template->getImagePath() . '/' . $template->img, ['class'=>'file-preview-image']),
            ] : false,
        ],
    ]) ?>

    <?= $form->field($template, 'code')->textarea([
        'class' => 'form-control',
        'rows' => 10,
        'placeholder' => Yii::t('tg', 'Block code'),
    ]) ?>

    <?= $form->field($template, 'id')->hiddenInput()->label(false) ?>
    <?= Html::hiddenInput('Template[category_id]', $category->id) ?>

    <div class="text-right">
        <?= Button::widget([
            'label' => 'SAVE',
            'options' => [
                'id' => 'save-template-btn',
                'class' => 'btn-primary',
            ]
        ]) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
