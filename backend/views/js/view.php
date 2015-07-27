<?php

/**
 * @var yii\web\View $this
 * @var common\models\Js $model
 */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('tg', 'Js'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="js-view">
    <?= $this->render('_form', [ 'model' => $model ]) ?>
</div>

<?php
$js = <<<JS
hljs.initHighlightingOnLoad();
$('pre.scroll').perfectScrollbar({ suppressScrollX: true });
JS;
$this->registerJs($js, \yii\web\View::POS_READY, 'js-view-script');