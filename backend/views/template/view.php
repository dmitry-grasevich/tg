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
                <div class="panel">
                    <div class="panel-heading">
                        <h3 class="panel-title"><?= Yii::t('tg', 'Customizer') ?></h3>
                    </div>
                    <div class="panel-body">
                        <ul class="sections-sortable">

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
