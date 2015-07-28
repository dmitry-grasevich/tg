<?php
use common\models\Category;

$categories = Category::findAll(['is_basic' => 0]);
?>
<nav id="mp-menu" class="mp-menu">
    <div class="mp-level">
        <h2>Menu</h2>
        <ul>
            <li class="menu-item">
                <a href="#">
                    Dashboard
                </a>
            </li>
            <li class="icon icon-arrow-left">
                <a href="#">Blocks</a>
                <div class="mp-level">
                    <h2>Blocks</h2>
                    <a class="mp-back" href="#">back</a>
                    <ul>
                        <?php /** @var common\models\Category $category */ ?>
                        <?php foreach ($categories as $category): ?>
                            <li class="icon icon-arrow-left">
                                <a href="#"><?= $category->name ?></a>
                                <div class="mp-level">
                                    <h2><?= $category->name ?></h2>
                                    <a class="mp-back" href="#">back</a>
                                    <div class="items-list">
                                        <ul>
                                            <?php /** @var common\models\Template $template */ ?>
                                            <?php foreach ($category->templates as $template): ?>
                                                <li class="menu-item">
                                                    <a href="#">
                                                        <?= $template->name ?>
                                                        <img src="/images/elements/<?= $category->alias ?>/thumbs/<?= $template->img ?>" width="294px" data-id="<?= $template->id ?>" />
                                                    </a>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                </div>
                            </li>
                        <?php endforeach; ?>
                        <li class="icon icon-plus">
                            <a href="#">
                                Add new block
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</nav>

<div id="droppable" class="trash"></div>

<a id="trigger" class="icon-burger" href="#"><i></i></a>

<?php
$js = <<<JS
    new mlPushMenu(document.getElementById('mp-menu'), document.getElementById('trigger'), { type: 'cover' });
JS;

$this->registerJs($js, \yii\web\View::POS_END, 'ml-push-menu-script');
