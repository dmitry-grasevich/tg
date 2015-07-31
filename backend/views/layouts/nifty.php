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

        <div class="boxed">

            <!--CONTENT CONTAINER-->
            <!--===================================================-->
            <div id="content-container">
                <?= $content ?>
            </div>
            <!--===================================================-->
            <!--END CONTENT CONTAINER-->

            <?= $this->render('nifty/navigation') ?>

            <?= $this->render('nifty/controls') ?>

        </div>
    </div>

<?php //= $this->render('nifty/footer') ?>


    <!-- SCROLL TOP BUTTON -->
    <!--===================================================-->
    <button id="scroll-top" class="btn"><i class="fa fa-chevron-up"></i></button>
    <!--===================================================-->

    <div id="floating-top-right" class="floating-container"></div>

    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
