<?php
/**
 * @var yii\web\View $this
 * @var common\models\File $file
 * @var boolean $isCommon
 * @var boolean $isRemovable
 * @var string $id
 */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\bootstrap\Button;
?>

<div class="col-sm-12">
    <div class="panel" id="panel-<?= $id ?>">
        <div class="panel-heading">
            <div class="panel-control">

                <?= Button::widget([
                    'label' => '<i class="fa fa-pencil fa-fw"></i> Edit',
                    'encodeLabel' => false,
                    'options' => [
                        'class' => 'btn-default edit-btn',
                        'data-id' => $id,
                    ]
                ]) ?>

                <?= Button::widget([
                    'label' => '<i class="fa fa-mail-reply fa-fw"></i> Cancel',
                    'encodeLabel' => false,
                    'options' => [
                        'class' => 'btn-default cancel-btn hidden',
                        'data-id' => $id,
                    ]
                ]) ?>

                <?= Button::widget([
                    'label' => '<i class="fa fa-floppy-o fa-fw"></i> Save',
                    'encodeLabel' => false,
                    'options' => [
                        'class' => 'btn-success save-btn hidden',
                        'data-id' => $id,
                    ]
                ]) ?>

                <?php if ($isRemovable): ?>
                    <?= Button::widget([
                        'label' => '<i class="fa fa-trash-o fa-fw"></i> Remove',
                        'encodeLabel' => false,
                        'options' => [
                            'class' => 'btn-danger remove-btn hidden',
                            'data-id' => $id,
                        ]
                    ]) ?>
                <?php endif ?>

                <?= Button::widget([
                    'label' => '<i class="fa fa-chevron-down"></i>',
                    'encodeLabel' => false,
                    'options' => [
                        'class' => 'btn-default',
                        'data' => [
                            'target' => '#panel-collapse-' . $id,
                            'toggle' => 'collapse',
                        ]
                    ]
                ]) ?>

            </div>

            <h3 class="panel-title"><?= !$isCommon ? $file->directory . '/' : '' ?><?= $file->filename ?></h3>
        </div>

        <div id="panel-collapse-<?= $id ?>" class="collapse">

            <div class="panel-body" id="view-<?= $id ?>">
                <?= empty($file->code) ? '' : Html::tag('pre', Html::tag('code', Html::encode($file->code)), ['class' => 'scroll', 'style' => 'max-height: 400px; position: relative;']) ?>
            </div>

            <div class="panel-body hidden" id="edit-<?= $id ?>" style="padding: 0 20px;">
                <?php $form = ActiveForm::begin(['id' => 'form-' . $id]) ?>

                <?= $form->field($file, 'id')->hiddenInput()->label(false) ?>

                <?= $form->field($file, 'filename')->textInput() ?>

                <?php if (!$isCommon): ?>
                    <?= $form->field($file, 'directory')->textInput() ?>
                <?php endif ?>

                <?= $form->field($file, 'code')->textarea(['rows' => 15]) ?>

                <?php ActiveForm::end(); ?>
            </div>

        </div>
    </div>
</div>