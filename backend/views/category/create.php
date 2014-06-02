<?php
/**
 * @var yii\web\View $this
 * @var common\models\TemplateCategory $model
 */

$this->title = Yii::t('app', 'Create {modelClass}', [
    'modelClass' => 'Template Category',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Template Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="template-category-create">
    <?= $this->render('_form', [ 'model' => $model ]) ?>
</div>
