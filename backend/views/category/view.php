<?php
/**
 * @var yii\web\View $this
 * @var common\models\Category $model
 */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('tg', 'Template Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="template-category-view">
    <?= $this->render('_form', [ 'model' => $model ]) ?>
</div>
