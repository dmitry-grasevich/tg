<?php
/**
 * @var yii\web\View $this
 * @var common\models\Category $category
 * @var common\models\Template[] $templates
 */

?>

<!-- Templates of current category -->
<ul>
    <?php foreach ($templates as $template): ?>
        <li class="">
            <a href="#">
                <?= $template->name ?>
                <img
                    src="/images/elements/<?= $category->alias ?>/thumbs/<?= $template->img ?>"
                    width="135px" data-id="<?= $template->id ?>"/>
            </a>
        </li>
    <?php endforeach; ?>
    <li class="">
        <a href="#">+ Add to <?= $category->name ?></a>
    </li>
</ul>
