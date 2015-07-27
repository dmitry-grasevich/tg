<?php
/**
 * @var yii\web\View $this
 * @var common\models\Element $model
 */

$this->title = Yii::t('tg', 'Create {modelClass}', [
    'modelClass' => 'Element',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('tg', 'Elements'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="css-create">
    <?= $this->render('_form', [ 'model' => $model ]) ?>
</div>
