<?php

/**
 * @var yii\web\View $this
 * @var common\models\Font $model
 */

$this->title = Yii::t('tg', 'Create {modelClass}', [
    'modelClass' => 'Font',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('tg', 'Fonts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="font-create">
    <?= $this->render('_form', [ 'model' => $model ]) ?>
</div>
