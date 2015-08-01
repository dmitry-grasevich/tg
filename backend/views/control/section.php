<?php
/**
 * @var yii\web\View $this
 * @var common\models\Section $model
 */

use yii\bootstrap\ActiveForm;

$form = ActiveForm::begin([
    'id' => 'section-form',
    'class' => 'form-horizontal',
]);


echo $form->field($model, 'alias')->textInput([
    'placeholder' => Yii::t('tg', 'Lowercase without spaces'),
]);

echo $form->field($model, 'title')->textInput([
    'placeholder' => Yii::t('tg', 'Section title'),
]);

echo $form->field($model, 'description')->textarea([
    'class' => 'form-control',
    'rows' => 5,
    'placeholder' => Yii::t('tg', 'Section description'),
]);

ActiveForm::end();