<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;

/**
 * @var yii\web\View $this
 * @var common\models\Template $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="template-form">

    <?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL]);
    echo Form::widget([

        'model' => $model,
        'form' => $form,
        'columns' => 1,
        'attributes' => [

            'category_id' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Category ID...']],

            'name' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Name...', 'maxlength' => 255]],

            'filename' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Filename...', 'maxlength' => 255]],

            'code' => ['type' => Form::INPUT_TEXTAREA, 'options' => ['placeholder' => 'Enter Code...', 'rows' => 6]],

            'directory' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Directory...', 'maxlength' => 255]],

            'img' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Img...', 'maxlength' => 255]],

        ]


    ]);
    echo Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);
    ActiveForm::end(); ?>

</div>
