<?php
/**
 * @var yii\web\View $this
 * @var common\models\Template $template
 */

$title = Yii::t('tg', 'Block "{template}" ({alias})', [
    'template' => $template->name,
    'alias' => $template->alias,
]);

$this->title = $title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('tg', 'Templates'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
    <div id="page-title">
        <h1 class="page-header text-overflow"><?= $title ?></h1>
    </div>

    <div id="page-content">
        <div class="row">
            <div class="col-sm-6">
                <div class="panel">
                    <div class="panel-heading">
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
                        <h3 class="panel-title"><?= Yii::t('tg', 'Control Params') ?></h3>
                    </div>
                    <div class="panel-body">

                    </div>
                </div>
            </div>

            <div class="col-sm-3">
                <div class="panel">
                    <div class="panel-heading">
                        <h3 class="panel-title"><?= Yii::t('tg', 'Customizer') ?></h3>
                    </div>
                    <div class="panel-body">

                    </div>
                </div>
            </div>
        </div>
    </div>

<?php
$js = <<<JS

hljs.initHighlightingOnLoad();
$('pre.scroll').perfectScrollbar({ suppressScrollX: true });

nifty.container.hasClass("aside-in") ? ($.niftyAside("hide")) : ($.niftyAside("show"));
$.niftyAside("fixedPosition");

JS;
$this->registerJs($js, $this::POS_READY, 'template-view-script');

