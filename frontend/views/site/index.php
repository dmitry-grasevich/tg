<?php
/**
 * @var yii\web\View                $this
 * @var common\models\Category[]    $categories
 * @var common\models\Template[]    $selected
 */
$this->title = 'WordPress Template Generator';
?>
<div class="container" id="main_container">
    <div class="mp-pusher" id="mp-pusher">

        <nav id="mp-menu" class="mp-menu">
            <div class="mp-level">
                <h2>Select a Category</h2>
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
                                        <?php foreach ($category->visibleTemplates as $template): ?>
                                            <li class="menu-item">
                                                <a href="#">
                                                    <img src="images/elements/<?= $category->alias ?>/thumbs/<?= $template->img ?>" width="294px" data-id="<?= $template->id ?>" />
                                                </a>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </nav>

        <div id="droppable" class="trash"></div>

        <a id="trigger" class="icon-burger" href="#"><i></i></a>

        <div class="project-container">
            <div class="browser">
                <div class="browser-header">
                    <i class="dot"></i>
                    <i class="dot dot2"></i>
                    <i class="dot dot3"></i>
                    <input type="text" placeholder="Enter name for your theme" id="theme_name" />
                </div>
                <div class="canvas">
                    <ul id="sortable">
                        <?php if (!empty($selected)): ?>
                            <?php /** @var common\models\Template $t */ ?>
                            <?php foreach ($selected as $t): ?>
                                <li>
                                    <img src="images/elements/<?= $t->category->alias ?>/<?= $t->img ?>" width="1200" data-fullimg="images/elements/<?= $t->category->alias ?>/<?= $t->img ?>" data-id="<?= $s->id ?>">
                                </li>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>

            <div class="button-container text-center">
                <button id="generateBtn" class="btn btn-action">Get Theme</button>
            </div>
        </div>

    </div>
</div>
