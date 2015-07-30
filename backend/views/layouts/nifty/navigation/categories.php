<?php
/**
 * @var yii\web\View $this
 * @var common\models\Category[] $categories
 */

use yii\helpers\Html;
?>

<?php foreach ($categories as $category): ?>

    <li id="nav-category-<?= $category->id ?>">
        <a href="#">
            <span><?= $category->name ?></span>
            <?php if ($category->is_visible): ?>
                <i class="fa fa-eye add-tooltip"
                   title="<?= Yii::t('tg', 'Visible on frontend') ?>"></i>
            <?php else: ?>
                <i class="fa fa-eye-slash add-tooltip"
                   title="<?= Yii::t('tg', 'Hidden on frontend') ?>"></i>
            <?php endif ?>
            <?= Html::tag('i', '', [
                'class' => 'add-tooltip fa fa-pencil',
                'title' => Yii::t('tg', 'Edit Block Category'),
                'data' => [
                    'title' => 'Edit Block Category',
                    'id' => $category->id,
                    'name' => $category->name,
                    'alias' => $category->alias,
                    'visible' => $category->is_visible,
                    'toggle' => 'modal',
                    'target' => '#block-modal'
                ]
            ]) ?>
            <i class="arrow"></i>
        </a>

        <?= $this->render('templates', ['category' => $category, 'templates' => $category->templates]) ?>

    </li>

<?php endforeach; ?>

<li>
    <?= Html::a('+ Add Block Category', '#', [
        'data' => [
            'title' => 'New Block Category',
            'toggle' => 'modal',
            'target' => '#block-modal'
        ]
    ]) ?>
</li>