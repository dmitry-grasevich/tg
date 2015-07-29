<?php
/**
 * @var yii\web\View $this
 */

use yii\helpers\Url;
use common\models\Category;

$categories = Category::findAll(['is_basic' => 0]);
?>
<!--MAIN NAVIGATION-->
<!--===================================================-->
<nav id="mainnav-container">
    <div id="mainnav">

        <!--Shortcut buttons-->
        <!--================================-->
        <div id="mainnav-shortcut">
            <ul class="list-unstyled">
                <li class="col-xs-4" data-content="Additional Sidebar" data-original-title="" title="">
                    <a id="demo-toggle-aside" class="shortcut-grid" href="#">
                        <i class="fa fa-magic"></i>
                    </a>
                </li>
                <li class="col-xs-4" data-content="Notification" data-original-title="" title="">
                    <a id="demo-alert" class="shortcut-grid" href="#">
                        <i class="fa fa-bullhorn"></i>
                    </a>
                </li>
                <li class="col-xs-4" data-content="Page Alerts" data-original-title="" title="">
                    <a id="demo-page-alert" class="shortcut-grid" href="#">
                        <i class="fa fa-bell"></i>
                    </a>
                </li>
            </ul>
        </div>
        <!--================================-->
        <!--End shortcut buttons-->


        <!--Menu-->
        <!--================================-->
        <div id="mainnav-menu-wrap">
            <div class="nano has-scrollbar">
                <div class="nano-content" tabindex="0" style="right: -15px;">
                    <ul id="mainnav-menu" class="list-group">

                        <!-- Category name -->
                        <li class="list-header">Navigation</li>

                        <!-- Menu Dashboard -->
                        <li class="active-link">
                            <a href="<?= Url::to('/dashboard') ?>">
                                <i class="fa fa-dashboard"></i>
                                <span class="menu-title">
                                    <strong>Dashboard</strong>
                                    <span class="label label-success pull-right">Top</span>
                                </span>
                            </a>
                        </li>

                        <!-- Generator Settings -->
                        <li class="list-header">Generator</li>

                        <!-- Template Settings -->
                        <li>
                            <a href="#">
                                <i class="fa fa-cog"></i>
                                <span class="menu-title">
                                    <strong>Template Settings</strong>
                                </span>
                                <i class="arrow"></i>
                            </a>

                            <!-- Template Settings Submenu -->
                            <ul class="collapse" aria-expanded="false" style="height: 0;">
                                <li>
                                    <a href="#">Setting 1</a>
                                </li>
                                <li>
                                    <a href="#">Setting 2</a>
                                </li>
                            </ul>
                        </li>

                        <!-- Blocks -->
                        <li>
                            <a href="#">
                                <i class="fa fa-th-large"></i>
                                <span class="menu-title">
                                    <strong>Blocks</strong>
                                </span>
                                <i class="arrow"></i>
                            </a>

                            <!-- Blocks(Categories) List -->
                            <ul class="collapse" aria-expanded="false" style="height: 0;">

                                <?php /** @var common\models\Category $category */ ?>
                                <?php foreach ($categories as $category): ?>

                                    <li class="">
                                        <a href="#"><?= $category->name ?><i class="arrow"></i></a>

                                        <!-- Templates of current category -->
                                        <ul class="collapse" aria-expanded="false" style="height: 0;">
                                            <?php /** @var common\models\Template $template */ ?>
                                            <?php foreach ($category->templates as $template): ?>
                                            <li class="">
                                                <a href="#">
                                                    <?= $template->name ?>
                                                    <img src="/images/elements/<?= $category->alias ?>/thumbs/<?= $template->img ?>" width="135px" data-id="<?= $template->id ?>" />
                                                </a>
                                            </li>
                                            <?php endforeach; ?>
                                            <li class="">
                                                <a href="#">+ Add to <?= $category->name ?></a>
                                            </li>
                                        </ul>
                                    </li>

                                <?php endforeach; ?>

                                <li>
                                    <a href="#">+ Add Block Type</a>
                                </li>
                            </ul>
                        </li>

                        <!-- Controls -->
                        <li>
                            <a href="<?= Url::to(['/control']) ?>">
                                <i class="fa fa-list-alt"></i>
                                <span class="menu-title">
                                    <strong>Controls</strong>
                                </span>
                            </a>
                        </li>
                    </ul>

                </div>
            </div>
        </div>
        <!--================================-->
        <!--End menu-->

    </div>
</nav>
<!--===================================================-->
<!--END MAIN NAVIGATION-->