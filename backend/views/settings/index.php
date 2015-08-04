<?php
/**
 * @var yii\web\View $this
 * @var common\models\CommonFile[] $files
 */

use yii\helpers\Url;
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
            <div class="col-sm-12">
                <div class="panel">
                    <div class="panel-heading">
                        <h3 class="panel-title"><?= Yii::t('tg', 'Screenshot Image') ?></h3>
                    </div>
                    <div class="panel-body" id="settings-wrapper">

                    </div>
                </div>
            </div>
        </div>
    </div>

<?php
$js = <<<JS

hljs.initHighlightingOnLoad();
$('pre.scroll').perfectScrollbar({ suppressScrollX: true });


$('#edit-template-btn').on('click', function() {
    window.location.href = "#";
});
JS;
$this->registerJs($js, $this::POS_READY, 'settings-script');
