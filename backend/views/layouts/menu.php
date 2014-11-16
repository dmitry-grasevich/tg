<?php
use yii\bootstrap\Nav;

/* @var $this \yii\web\View */
?>
<div class="panel panel-info">
    <div class="panel-heading">
        <h3 class="panel-title"><i class="glyphicon glyphicon-align-justify"></i> Menu </h3>
    </div>

    <?= Nav::widget([
        'options' => ['class' => 'nav-pills nav-stacked'],
        'items' => [
            [
                'label' => 'Categories',
                'url' => ['/category'],
                'active' => $this->context->id == 'category',
            ],
            [
                'label' => 'Templates',
                'url' => ['/template'],
                'active' => $this->context->id == 'template',
            ],
            [
                'label' => 'Styles',
                'url' => ['/css/index'],
                'active' => $this->context->id == 'css',
            ],
            [
                'label' => 'Scripts',
                'url' => ['/js'],
                'active' => $this->context->id == 'js',
            ],
            [
                'label' => 'Images',
                'url' => ['/image'],
                'active' => $this->context->id == 'image',
            ],
            [
                'label' => 'Fonts',
                'url' => ['/font'],
                'active' => $this->context->id == 'font',
            ],
            [
                'label' => 'Functions',
                'url' => ['/functions'],
                'active' => $this->context->id == 'functions',
            ],
            [
                'label' => 'Plugins',
                'url' => ['/plugin'],
                'active' => $this->context->id == 'plugin',
            ],
            [
                'label' => 'Sections',
                'url' => ['/section'],
                'active' => $this->context->id == 'section',
            ],
            [
                'label' => 'Controls',
                'url' => ['/control'],
                'active' => $this->context->id == 'control',
            ],
        ],
    ]) ?>
</div>