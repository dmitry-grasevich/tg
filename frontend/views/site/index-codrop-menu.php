<?php
/**
 * @var $this yii\web\View
 * @var $categories array
 */
$this->title = 'WordPress Template Generator';
?>
<div class="container">
    <!-- Push Wrapper -->
    <div class="mp-pusher" id="mp-pusher">

        <!-- mp-menu -->
        <nav id="mp-menu" class="mp-menu">
            <div class="mp-level">
                <h2 class="icon icon-world">All Categories</h2>
                <ul>
                    <?php foreach ($categories as $catName => $category): ?>
                    <li class="icon icon-arrow-left">
                        <a class="icon icon-display" href="#"><?= $catName ?></a>
                        <div class="mp-level">
                            <h2 class="icon icon-display"><?= $catName ?></h2>
                            <a class="mp-back" href="#">back</a>
                            <ul>
                                <?php foreach ($category['items'] as $item): ?>
                                    <li><a href="#"><img src="elements/images/thumbs/<?= $item['thumbnail'] ?>" width="294px" /></a></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </nav>
        <!-- /mp-menu -->

        <div class="scroller"><!-- this is for emulating position fixed of the nav -->
            <div class="scroller-inner">
                <div class="content clearfix">
                    <div class="block clearfix">
                        <p><a href="#" id="trigger" class="menu-trigger"></a></p>
                    </div>
                </div>
            </div><!-- /scroller-inner -->
        </div><!-- /scroller -->

    </div><!-- /pusher -->
</div><!-- /container -->
