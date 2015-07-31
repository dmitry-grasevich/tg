<?php
/**
 * @var yii\web\View $this
 * @var common\models\Category $category
 * @var common\models\Template[] $templates
 */

use yii\helpers\Url;
?>

<!-- Templates of current category -->
<ul>
    <?php foreach ($templates as $template): ?>
        <li class="">
            <a href="<?= Url::to(['/template/edit', 'cat' => $template->category_id, 'id' => $template->id]) ?>">
                <?= $template->name ?>
                <img
                    src="/images/elements/<?= $category->alias ?>/thumbs/<?= $template->img ?>"
                    width="135px" data-id="<?= $template->id ?>"/>
            </a>
        </li>
    <?php endforeach; ?>
    <li class="">
        <a href="<?= Url::to(['/template/edit', 'cat' => $category->id]) ?>">
            + Add to <?= $category->name ?>
        </a>
    </li>
</ul>
