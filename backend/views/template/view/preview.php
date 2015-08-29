<?php
/**
 * @var yii\web\View $this
 * @var common\models\Template $template
 * @var common\models\Image $image
 */

use yii\helpers\Html;
use common\helpers\HtmlTg;

?>
<div class="form-group">
    <h4><?= $template->title ?></h4>

    <?php if (!empty($template->description)): ?>
        <p><?= $template->description ?></p>
    <?php endif ?>

    <?php if (!empty($template->img)): ?>
        <?= Html::img($template->getImagePath() . '/' . $template->img, ['class' => 'file-preview-image', 'style' => 'width:100%']) ?>
    <?php endif ?>

    <?php if (!empty($template->code)): ?>
        <label><?= Yii::t('tg', 'Code') ?>:</label>
        <?= HtmlTg::code($template->code) ?>
    <?php endif ?>

    <?php if (!empty($template->style)): ?>
        <label><?= Yii::t('tg', 'Styles') ?>:</label>
        <?= HtmlTg::code($template->style) ?>
    <?php endif ?>

    <?php if (!empty($template->script)): ?>
        <label><?= Yii::t('tg', 'Javascript') ?>:</label>
        <?= HtmlTg::code($template->script) ?>
    <?php endif ?>

    <?php if (!empty($template->js)): ?>
        <label><?= Yii::t('tg', 'Attached javascript libraries') ?>:</label><br>
        <?= $template->getJsName() ?>
    <?php endif ?>

    <?php if (!empty($template->images)): ?>
        <label><?= Yii::t('tg', 'Attached images') ?>:</label>
        <?= $template->getImagePreview() ?>
    <?php endif ?>
</div>