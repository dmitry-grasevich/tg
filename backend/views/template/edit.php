<?php
/**
 * @var yii\web\View $this
 * @var common\models\Category $category
 * @var common\models\Template $template
 */
$title = Yii::t('tg', $template->isNewRecord ? 'New Block in category "{category}"' :
    'Edit Block "{template}" in category ":category"', [
    'category' => $category->name,
    'template' => $template->name,
]);

$this->title = $title;
?>

<h1 class="page-header text-overflow text-center"><?= $title ?></h1>

<?= $this->render('_form', ['category' => $category, 'template' => $template]) ?>

<?php
$js = <<<JS
nifty.container.hasClass("aside-in") ? ($.niftyAside("hide")) : ($.niftyAside("show"));
$.niftyAside("fixedPosition");
JS;
//$this->registerJs($js, $this::POS_READY, 'edit-template-script');
