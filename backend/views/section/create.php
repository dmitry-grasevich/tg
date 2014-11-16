<?php
/**
 * @var yii\web\View $this
 * @var common\models\Section $model
 */

$this->title = Yii::t('app', 'Create {modelClass}', [
    'modelClass' => 'Section',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Sections'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="css-create">
    <?= $this->render('_form', [ 'model' => $model ]) ?>
</div>
