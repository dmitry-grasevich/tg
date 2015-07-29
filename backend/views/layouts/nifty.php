<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\NiftyAsset;
use yii\helpers\Html;

NiftyAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="nifty-ready">
    <?php $this->beginBody() ?>

    <div id="container" class="effect mainnav-lg">
        <?= $this->render('nifty/header') ?>
    </div>

    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
