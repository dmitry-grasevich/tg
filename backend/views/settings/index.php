<?php
/**
 * @var yii\web\View $this
 * @var common\models\CommonFile[] $files
 * @var common\models\CommonFile $screenshot
 */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\bootstrap\Button;
use kartik\widgets\FileInput;

$title = Yii::t('tg', 'Common Files');

$this->title = $title;
?>
    <div id="page-title">
        <h1 class="page-header text-overflow">
            <?= $title ?>
        </h1>
    </div>

    <div id="page-content">
        <div class="row">

            <?php foreach ($files as $file): ?>
                <div class="col-sm-12">
                    <div class="panel" id="panel-<?= $file->id ?>">
                        <div class="panel-heading">
                            <div class="panel-control">

                                <?= Button::widget([
                                    'label' => '<i class="fa fa-pencil fa-fw"></i> Edit',
                                    'encodeLabel' => false,
                                    'options' => [
                                        'class' => 'btn-default edit-btn',
                                        'data-id' => $file->id,
                                    ]
                                ]) ?>

                                <?= Button::widget([
                                    'label' => '<i class="fa fa-mail-reply fa-fw"></i> Cancel',
                                    'encodeLabel' => false,
                                    'options' => [
                                        'class' => 'btn-default cancel-btn hidden',
                                        'data-id' => $file->id,
                                    ]
                                ]) ?>

                                <?= Button::widget([
                                    'label' => '<i class="fa fa-floppy-o fa-fw"></i> Save',
                                    'encodeLabel' => false,
                                    'options' => [
                                        'class' => 'btn-success save-btn hidden',
                                        'data-id' => $file->id,
                                    ]
                                ]) ?>

                                <?= Button::widget([
                                    'label' => '<i class="fa fa-chevron-down"></i>',
                                    'encodeLabel' => false,
                                    'options' => [
                                        'class' => 'btn-default',
                                        'data' => [
                                            'target' => '#panel-collapse-' . $file->id,
                                            'toggle' => 'collapse',
                                        ]
                                    ]
                                ]) ?>

                            </div>

                            <h3 class="panel-title"><?= $file->filename ?></h3>
                        </div>

                        <div id="panel-collapse-<?= $file->id ?>" class="collapse">

                            <div class="panel-body" id="view-<?= $file->id ?>">
                                <?= empty($file->code) ? '' : Html::tag('pre', Html::tag('code', Html::encode($file->code)), ['class' => 'scroll', 'style' => 'max-height: 400px; position: relative;']) ?>
                            </div>

                            <div class="panel-body hidden" id="edit-<?= $file->id ?>" style="padding: 0 20px;">
                                <?php $form = ActiveForm::begin(['id' => 'form-' . $file->id]) ?>

                                <?= $form->field($file, 'id')->hiddenInput()->label(false) ?>

                                <?= $form->field($file, 'code')->textarea(['rows' => 15]) ?>

                                <?php ActiveForm::end(); ?>
                            </div>

                        </div>
                    </div>
                </div>
            <?php endforeach ?>

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
        </div>
    </div>

<?php
$js = <<<JS
function switchToEdit (el) {
    el.addClass('hidden');
    el.parent().find('.cancel-btn,.save-btn').removeClass('hidden');

    var id = el.data('id');
    $('#view-' + id).addClass('hidden');
    $('#edit-' + id).removeClass('hidden');
}

function switchToView (el) {
    el.parent().find('.cancel-btn,.save-btn').addClass('hidden');
    el.parent().find('.edit-btn').removeClass('hidden');

    var id = el.data('id');
    $('#edit-' + id).addClass('hidden');
    $('#view-' + id).removeClass('hidden');
}

function initHighlighting () {
    $('pre code').each(function(i, block) {
        hljs.highlightBlock(block);
    });
    $('pre.scroll').perfectScrollbar({ suppressScrollX: true });
}

function progressHandlingFunction (e) {
    if(e.lengthComputable){
        $('.progress-bar').css('width', e.loaded + '%');
    }
}

function initProgressBar () {
    $('.progress').removeClass('hidden');
    $('.progress-bar').css('width', '0%');
}

$('.edit-btn').on('click', function (e) {
    e.preventDefault();
    switchToEdit($(this));
});

$('.cancel-btn').on('click', function (e) {
    e.preventDefault();
    switchToView($(this));
});

$('.save-btn').on('click', function (e) {
    e.preventDefault();

    var self = $(this),
        id = self.data('id');

        if (self.data('name') == 'screenshot') { // ajax file upload
            var formData = new FormData($('#form-' + id)[0]);
            $.ajax({
                url: '/settings/screenshot',  //Server script to process data
                type: 'POST',
                xhr: function() {  // Custom XMLHttpRequest
                    var myXhr = $.ajaxSettings.xhr();
                    if(myXhr.upload){ // Check if upload property exists
                        // For handling the progress of the upload
                        myXhr.upload.addEventListener('progress', progressHandlingFunction, false);
                    }
                    return myXhr;
                },
                beforeSend: function () { initProgressBar(); },
                //Ajax events
                success: function (res) {
                    $('#view-' + id).html(res);
                    switchToView(self);
                    initHighlighting();
                    TgAlert.success('Common File', 'Screenshot was successfully updated');
                },
                error: function (res) { showError(res); },
                always: function() { $('.progress').addClass('hidden'); },
                // Form data
                data: formData,
                //Options to tell jQuery not to process data or worry about content-type.
                cache: false,
                contentType: false,
                processData: false
            });
        } else {    // post simple form
            $.post('/settings/save', $('#form-' + id).serialize(), function (res) {
                $('#view-' + id).html(res);
                switchToView(self);
                initHighlighting();
                TgAlert.success('Common File', 'File code was successfully updated');
            })
            .fail(function (res) {
                showError(res);
            });
        }
});

initHighlighting();
JS;
$this->registerJs($js, $this::POS_READY, 'settings-script');
