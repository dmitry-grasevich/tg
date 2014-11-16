<?php
/**
 * @var yii\web\View $this
 * @var common\models\Element $model
 */

$this->title = Yii::t('app', 'Create {modelClass}', [
    'modelClass' => 'Element',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Elements'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="css-create">
    <?= $this->render('_form', [ 'model' => $model ]) ?>
</div>
