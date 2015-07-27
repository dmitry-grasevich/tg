<?php
/**
 * @var yii\web\View $this
 * @var common\models\Functions $model
 */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('tg', 'Functions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="functions-view">
    <?= $this->render('_form', [ 'model' => $model ]) ?>
</div>

<?php
$js = <<<JS
hljs.initHighlightingOnLoad();
$('pre.scroll').perfectScrollbar({ suppressScrollX: true });
JS;
$this->registerJs($js, \yii\web\View::POS_READY, 'functions-view-script');