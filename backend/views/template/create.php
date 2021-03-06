<?php
/**
 * @var yii\web\View $this
 * @var common\models\Template $model
 */

$this->title = Yii::t('app', 'Create {modelClass}', [
    'modelClass' => 'Template',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Templates'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="template-create">
    <?= $this->render('_form', [ 'model' => $model ]) ?>
</div>
