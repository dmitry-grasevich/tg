<?php
/**
 * @var yii\web\View $this
 * @var common\models\Category $category
 * @var common\models\Template $template
 */
?>

<h1 class="page-header text-overflow text-center">Edit template "<?= $template->name ?>" in category "<?= $category->name ?>"</h1>

<?php
$js = <<<JS
nifty.container.hasClass("aside-in") ? ($.niftyAside("hide")) : ($.niftyAside("show"));
$.niftyAside("fixedPosition");
JS;
$this->registerJs($js, $this::POS_READY, 'edit-template-script');
