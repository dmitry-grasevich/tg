<?php

use yii\helpers\Html;

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
    <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
