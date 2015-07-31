<?php
/**
 * @var yii\web\View $this
 */

use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Button;
use yii\bootstrap\Modal;
use common\models\Category;
use backend\models\CategoryForm;

$categories = Category::findAll(['is_basic' => 0]);

$categoryModel = new CategoryForm();
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
                        <a id="toggle-aside" class="shortcut-grid" href="#">
                            <i class="fa fa-magic"></i>
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

                                <!-- Block(Categories) List -->
                                <ul id="block-list">
                                    <?= $this->render('navigation/categories', ['categories' => $categories]) ?>
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

<?php
/**
 * Modal for creating/editing of Block
*/
Modal::begin([
    'id' => 'block-modal',
    'header' => '<h4 class="modal-title">header</h4>',
    'size' => Modal::SIZE_SMALL,
    'footer' =>
        Button::widget([
            'label' => 'Cancel',
            'options' => [
                'class' => 'btn-default',
                'data' => [
                    'dismiss' => 'modal'
                ]
            ]
        ]) .
        Button::widget([
            'label' => 'Remove',
            'options' => [
                'id' => 'delete-block-btn',
                'class' => 'btn-danger',
            ]
        ]) .
        Button::widget([
            'label' => 'SAVE',
            'options' => [
                'id' => 'save-block-btn',
                'class' => 'btn-primary',
            ]
        ])
]);
?>
<div class="row">
    <div class="col-md-12">
        <?php $form = ActiveForm::begin([
            'id' => 'block-form',
            'class' => 'form-horizontal'
        ]); ?>

        <?= $form->field($categoryModel, 'name') ?>

        <?= $form->field($categoryModel, 'alias') ?>

        <?= $form->field($categoryModel, 'is_visible')->checkbox() ?>

        <?= $form->field($categoryModel, 'id')->hiddenInput()->label(false) ?>

        <?php ActiveForm::end(); ?>
    </div>
</div>
<?php
Modal::end();
