<?php
/**
 * @var yii\web\View $this
 * @var common\models\File[] $files
 */

use yii\bootstrap\Button;

$title = Yii::t('tg', 'Additional Files');

$this->title = $title;
?>
    <div id="page-title">
        <h1 class="page-header text-overflow">
            <?= $title ?>
        </h1>

        <div class="block-right">
            <?= Button::widget([
                'label' => '<i class="fa fa-file-o"></i> Add File',
                'encodeLabel' => false,
                'options' => [
                    'id' => 'add-file',
                    'class' => 'btn-primary',
                ]
            ]) ?>
        </div>
    </div>

    <div id="page-content">
        <div class="row">

            <?php foreach ($files as $file): ?>
                <?= $this->render('_panel', ['file' => $file, 'isCommon' => false, 'isRemovable' => true, 'id' => $file->id]) ?>
            <?php endforeach ?>

        </div>
    </div>

<?php
$js = <<<JS
function switchToEdit (el) {
    el.addClass('hidden');
    el.parent().find('.cancel-btn,.save-btn,.remove-btn').removeClass('hidden');

    var id = el.data('id');
    $('#view-' + id).addClass('hidden');
    $('#edit-' + id).removeClass('hidden');
}

function switchToView (el) {
    el.parent().find('.cancel-btn,.save-btn,.remove-btn').addClass('hidden');
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

$(document).on('click', '.edit-btn', function (e) {
    e.preventDefault();
    switchToEdit($(this));
});

$(document).on('click', '.cancel-btn', function (e) {
    e.preventDefault();
    switchToView($(this));
});

$(document).on('click', '.save-btn', function (e) {
    e.preventDefault();

    var self = $(this),
        id = self.data('id');

        $.post('/settings/save-additional', $('#form-' + id).serialize(), function (res) {
            if (res.success) {
                $('#panel-' + id).parent().replaceWith(res.success);
                switchToView(self);
                initHighlighting();
                TgAlert.success('Additional File', 'File was successfully saved');
            } else if (res.errors) {
                updateFormErrors('form-' + id, 'file', res.errors);
            }
        }, 'json')
        .fail(function (res) {
            showError(res);
        });
});

$(document).on('click', '.remove-btn', function (e) {
    e.preventDefault();

    var self = $(this),
        id = self.data('id');

        $.post('/settings/remove-additional', {id: id}, function () {
            $('#panel-' + id).parent().remove();
            TgAlert.success('Additional File', 'File was successfully removed');
        })
        .fail(function (res) {
            showError(res);
        });
});

$(document).on('click', '#add-file', function (e) {
    e.preventDefault();

    var time = new Date().getTime();

    $.post('/settings/file-panel', {id: 'new-' + time}, function (res) {
        $('#page-content > div').append(res);
    })
    .fail(function (res) {
        showError(res);
    });
});

initHighlighting();
JS;
$this->registerJs($js, $this::POS_READY, 'settings-script');
