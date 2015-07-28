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
                Blocks
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
