<?php
/**
 * @var $this           yii\web\View
 * @var $categories     array
 * @var $selected       array|null
 * @var $s              common\models\Template
 */
$this->title = 'WordPress Template Generator';
?>
<div class="container" id="main_container">
    <div class="mp-pusher" id="mp-pusher">

        <nav id="mp-menu" class="mp-menu">
            <div class="mp-level">
                <h2>Select a Category</h2>
                <ul>
                    <?php foreach ($categories as $catName => $category): ?>
                    <li class="icon icon-arrow-left">
                        <a href="#"><?= $catName ?></a>
                        <div class="mp-level">
                            <h2 class="icon icon-display"><?= $catName ?></h2>
                            <a class="mp-back" href="#">back</a>
                            <div class="items-list">
                                <ul>
                                    <?php foreach ($category['items'] as $item): ?>
                                        <li class="menu-item"><a href="#"><img src="elements/images/thumbs/<?= $item['img'] ?>" width="294px" data-id="<?= $item['id'] ?>" /></a></li>
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
            <div class="browser-header">
                <i class="dot"></i>
                <i class="dot dot2"></i>
                <i class="dot dot3"></i>
                <input type="text" placeholder="Enter name for your theme" id="theme_name" />
            </div>
            <div class="canvas">
                <ul id="sortable">
                    <?php if (!empty($selected)): ?>
                        <?php foreach ($selected as $s): ?>
                        <li>
                            <img src="elements/images/full/<?= $s->img ?>" width="1200px" data-fullimg="elements/images/full/<?= $s->img ?>" data-id="<?= $s->id ?>">
                        </li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
            </div>

            <div class="button-container text-center">
                <button id="generateBtn">Get Template!</button>
            </div>
        </div>

    </div>
</div>
