<?php
/**
 * @var yii\web\View $this
 * @var common\models\Template $template
 */

use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Button;

$title = Yii::t('tg', 'Block "{template}" ({alias})', [
    'template' => $template->name,
    'alias' => $template->alias,
]);

$this->title = $title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('tg', 'Templates'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

echo Html::hiddenInput('template-id', $template->id, ['id' => 'tid']);
echo Html::hiddenInput('template-updated_at', $template->updated_at, ['id' => 'template-upd']);

echo $this->render('view/section');
echo $this->render('view/sectioncontrol');
echo $this->render('view/dragcontrol');
?>
    <div id="page-title">
        <h1 class="page-header text-overflow">
            <?= $title ?>
        </h1>
    </div>

    <div id="page-content">
        <div class="row" style="position: relative">
            <div id="droppable" class="trash col-sm-3"></div>
            <div class="col-sm-6">
                <div class="panel">
                    <div class="panel-heading">
                        <div class="panel-control">

                            <?php if ($template->is_visible): ?>
                                <span class="label label-success"><i class="fa fa-eye"></i> <?= Yii::t('tg', 'Visible on frontend') ?></span>
                            <?php else: ?>
                                <span class="label label-dark"><i class="fa fa-eye-slash"></i> <?= Yii::t('tg', 'Hidden on frontend') ?></span>
                            <?php endif ?>

                            <?= Button::widget([
                                'label' => '<i class="fa fa-pencil fa-fw"></i> Edit',
                                'encodeLabel' => false,
                                'options' => [
                                    'id' => 'edit-template-btn',
                                    'class' => 'btn-default'
                                ]
                            ]) ?>
                        </div>

                        <h3 class="panel-title"><?= Yii::t('tg', 'Block Preview') ?></h3>
                    </div>
                    <div class="panel-body">
                        <?= $this->render('view/preview', ['template' => $template]) ?>
                    </div>
                </div>
            </div>

            <div class="col-sm-3">
                <div class="panel">
                    <div class="panel-heading">
                        <h3 class="panel-title"><?= Yii::t('tg', 'Control Settings') ?></h3>
                    </div>
                    <div class="panel-body" id="settings-wrapper">
                        <div class="text-thin text-center text-muted" id="setting-helper"><?= Yii::t('tg', 'Select a section or control in Customizer') ?></div>
                        <div id="settings-container"></div>
                    </div>
                </div>
            </div>

            <div class="col-sm-3">
                <div class="panel" id="customizer-panel">
                    <div class="panel-heading">
                        <div class="panel-control">

                            <!--span class="label label-warning"><i class="fa fa-flash"></i> <?= Yii::t('tg', 'Has unsaved data') ?></span-->

                            <?= Button::widget([
                                'label' => '<i class="fa fa-rotate-right fa-fw"></i> Load',
                                'encodeLabel' => false,
                                'options' => [
                                    'id' => 'load-customizer-btn',
                                    'class' => 'btn-default',
                                    'data' => [
                                        'target' => '#customizer-panel',
                                        'toggle' => 'panel-overlay',
                                    ]
                                ]
                            ]) ?>

                            <?= Button::widget([
                                'label' => '<i class="fa fa-floppy-o fa-fw"></i> Save',
                                'encodeLabel' => false,
                                'options' => [
                                    'id' => 'save-customizer-btn',
                                    'class' => 'btn-warning hidden'
                                ]
                            ]) ?>
                        </div>

                        <h3 class="panel-title"><?= Yii::t('tg', 'Customizer') ?></h3>
                    </div>
                    <div class="panel-body">
                        <ul class="sections-sortable" id="customizer-controls">

                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php
$editProfileUrl = Url::to(['/template/edit', 'cat' => $template->category_id, 'id' => $template->id]);

$js = <<<JS

hljs.initHighlightingOnLoad();
$('pre.scroll').perfectScrollbar({ suppressScrollX: true });

nifty.container.hasClass("aside-in") ? ($.niftyAside("hide")) : ($.niftyAside("show"));
$.niftyAside("fixedPosition");

$('#edit-template-btn').on('click', function() {
    window.location.href = "{$editProfileUrl}";
});
JS;
$this->registerJs($js, $this::POS_READY, 'template-view-script');
