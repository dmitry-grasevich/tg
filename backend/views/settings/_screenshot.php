<?php
/**
 * @var yii\web\View $this
 * @var common\models\Screenshot $screenshot
 */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\bootstrap\Button;
use kartik\widgets\FileInput;
?>

<div class="col-sm-12">
    <div class="panel">
        <div class="panel-heading">
            <div class="panel-control">

                <?= Button::widget([
                    'label' => '<i class="fa fa-pencil fa-fw"></i> Edit',
                    'encodeLabel' => false,
                    'options' => [
                        'class' => 'btn-default edit-btn',
                        'data-id' => $screenshot->id,
                    ]
                ]) ?>

                <?= Button::widget([
                    'label' => '<i class="fa fa-mail-reply fa-fw"></i> Cancel',
                    'encodeLabel' => false,
                    'options' => [
                        'class' => 'btn-default cancel-btn hidden',
                        'data-id' => $screenshot->id,
                    ]
                ]) ?>

                <?= Button::widget([
                    'label' => '<i class="fa fa-floppy-o fa-fw"></i> Save',
                    'encodeLabel' => false,
                    'options' => [
                        'class' => 'btn-success save-btn hidden',
                        'data' => [
                            'id' => $screenshot->id,
                            'name' => 'screenshot',
                        ]
                    ]
                ]) ?>

                <?= Button::widget([
                    'label' => '<i class="fa fa-chevron-down"></i>',
                    'encodeLabel' => false,
                    'options' => [
                        'class' => 'btn-default',
                        'data' => [
                            'target' => '#panel-collapse-' . $screenshot->id,
                            'toggle' => 'collapse',
                        ]
                    ]
                ]) ?>

            </div>

            <h3 class="panel-title">screenshot.png</h3>
        </div>

        <div id="panel-collapse-<?= $screenshot->id ?>" class="collapse">

            <div class="panel-body" id="view-<?= $screenshot->id ?>">
                <?= empty($screenshot->code) ? '' :
                    '<div class="screenshot-preview-frame">' .
                    Html::img($screenshot::getImagePath() . '/' . $screenshot->code) .
                    '</div>'
                ?>

            </div>

            <div class="panel-body hidden" id="edit-<?= $screenshot->id ?>" style="padding: 0 20px;">
                <div class="progress progress-striped active hidden">
                    <div style="width: 80%;" class="progress-bar progress-bar-purple"></div>
                </div>


                <?php $form = ActiveForm::begin([
                    'id' => 'form-' . $screenshot->id,
                    'options' => [
                        'enctype' => 'multipart/form-data'
                    ]
                ]); ?>

                <?= $form->field($screenshot, 'id')->hiddenInput()->label(false) ?>

                <?= $form->field($screenshot, 'code')->widget(FileInput::classname(), [
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
                        'initialPreview' => $screenshot->code ? [
                            Html::img($screenshot::getImagePath() . '/' . $screenshot->code, ['class' => 'file-preview-image']),
                        ] : false,
                    ],
                ]); ?>

                <?php ActiveForm::end(); ?>
            </div>

        </div>

    </div>
</div>