<?php
/**
 * @var yii\web\View $this
 * @var common\models\Category $category
 * @var common\models\Template[] $templates
 */

use yii\helpers\Url;
use yii\bootstrap\Html;
?>

<!-- Templates of current category -->
<ul>
    <?php foreach ($templates as $template): ?>
        <li class="">
            <a href="<?= Url::to(['/template/view', 'id' => $template->id]) ?>">
                <?= $template->name ?>

                <?php if ($template->is_visible): ?>
                    <i class="fa fa-eye add-tooltip"
                       title="<?= Yii::t('tg', 'Visible on frontend') ?>"></i>
                <?php else: ?>
                    <i class="fa fa-eye-slash add-tooltip"
                       title="<?= Yii::t('tg', 'Hidden on frontend') ?>"></i>
                <?php endif ?>

                <?= Html::img($template->getImagePath(true) . '/' . $template->img, [
                    'width' => '135px',
                    'data' => [
                        'id' => $template->id
                    ]
                ]) ?>
            </a>
        </li>
    <?php endforeach; ?>
    <li class="">
        <a href="<?= Url::to(['/template/edit', 'cat' => $category->id]) ?>">
            + Add to <?= $category->name ?>
        </a>
    </li>
</ul>
