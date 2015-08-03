<?php
/**
 * @var yii\web\View $this
 * @var common\models\SectionControl $model
 */

use yii\bootstrap\ActiveForm;

$form = ActiveForm::begin([
    'id' => 'sectioncontrol-form',
    'class' => 'form-horizontal',
]);


echo $form->field($model, 'alias')->textInput([
    'placeholder' => Yii::t('tg', 'Lowercase without spaces'),
]);

echo $form->field($model, 'label')->textInput([
    'placeholder' => Yii::t('tg', 'Control label'),
]);

echo $form->field($model, 'help')->textInput([
    'placeholder' => Yii::t('tg', 'Control help text'),
]);

echo $form->field($model, 'description')->textarea([
    'class' => 'form-control',
    'rows' => 5,
    'placeholder' => Yii::t('tg', 'Control description'),
]);

echo $form->field($model, 'default')->textarea([
    'class' => 'form-control',
    'rows' => 5,
    'placeholder' => Yii::t('tg', 'Control default value'),
]);

echo $form->field($model, 'style')->textarea([
    'class' => 'form-control',
    'rows' => 5,
    'placeholder' => Yii::t('tg', 'Control style [output, js_vars]'),
]);


echo $form->field($model, 'pseudojs')->textarea([
    'class' => 'form-control',
    'rows' => 5,
    'placeholder' => Yii::t('tg', 'Control pseudo JS'),
]);

ActiveForm::end();