<?php
/**
 * @var yii\web\View $this
 * @var common\models\Functions $model
 */

$this->title = Yii::t('tg', 'Create {modelClass}', [
    'modelClass' => 'Functions',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('tg', 'Functions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="functions-create">
    <?= $this->render('_form', [ 'model' => $model ]) ?>
</div>
