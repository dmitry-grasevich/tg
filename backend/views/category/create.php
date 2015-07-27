<?php
/**
 * @var yii\web\View $this
 * @var common\models\Category $model
 */

$this->title = Yii::t('tg', 'Create {modelClass}', [
    'modelClass' => 'Template Category',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('tg', 'Template Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="template-category-create">
    <?= $this->render('_form', [ 'model' => $model ]) ?>
</div>
