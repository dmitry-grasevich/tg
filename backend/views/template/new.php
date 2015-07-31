<?php
/**
 * @var yii\web\View $this
 * @var common\models\Category $category
 * @var common\models\Template $template
 */
?>

<h1 class="page-header text-overflow text-center">New template in category "<?= $category->name ?>"</h1>

<div class="template-create">
    <?= $this->render('_form', ['model' => $template, 'category' => $category]) ?>
</div>

