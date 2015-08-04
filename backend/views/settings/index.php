<?php
/**
 * @var yii\web\View $this
 * @var common\models\CommonFile[] $files
 */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\bootstrap\Button;

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
                            <?= empty($file->code) ? '' : Html::tag('pre', Html::tag('code', Html::encode($file->code)), ['class' => 'scroll', 'style' => 'max-height: 400px; position: relative;'])?>
                        </div>

                        <div class="panel-body hidden" id="edit-<?= $file->id ?>" style="padding: 0 20px;">
                            <?php $form = ActiveForm::begin([
                                'id' => 'form-' . $file->id
                            ]); ?>

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
                        <h3 class="panel-title"><?= Yii::t('tg', 'screenshot.png') ?></h3>
                    </div>
                    <div class="panel-body" id="screenshot-wrapper">

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

    $.post('/settings/save', $('#form-' + id).serialize(), function (res) {
        $('#view-' + id).html(res);
        switchToView(self);
        initHighlighting();
        TgAlert.success('Common File', 'File code was successfully updated');
    });
});

initHighlighting();
JS;
$this->registerJs($js, $this::POS_READY, 'settings-script');
