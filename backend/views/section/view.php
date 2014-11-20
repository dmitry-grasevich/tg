<?php

/**
 * @var yii\web\View $this
 * @var common\models\Section $model
 */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Sections'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
    <div class="section-view">
        <?= $this->render('_form', ['model' => $model]) ?>
    </div>

<?php if (!empty($model->controls) && count($model->controls)): ?>
    <div class="section-view">
        <?= $this->render('_priorities', ['section' => $model]) ?>
    </div>

    <div class="section-view">
        <?= $this->render('_default', ['section' => $model]) ?>
    </div>
<?php endif; ?>
    <?php
    $js = <<<JS
hljs.initHighlightingOnLoad();
$('pre.scroll').perfectScrollbar({ suppressScrollX: true });
JS;
    $this->registerJs($js, \yii\web\View::POS_READY, 'section-view-script');