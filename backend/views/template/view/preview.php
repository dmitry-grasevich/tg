<?php
/**
 * @var yii\web\View $this
 * @var common\models\Template $template
 * @var common\models\Image $image
 */

use yii\helpers\Html;

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
        <?= Html::tag('pre', Html::tag('code', Html::encode($template->code)), ['class' => 'scroll', 'style' => 'max-height: 400px; position: relative;']) ?>
    <?php endif ?>

    <?php if (!empty($template->style)): ?>
        <?= Html::tag('pre', Html::tag('code', Html::encode($template->style)), ['class' => 'scroll', 'style' => 'max-height: 400px; position: relative;']) ?>
    <?php endif ?>

    <?php if (!empty($template->images)): ?>
        <label><?= Yii::t('tg', 'Attached images') ?></label>
        <?php foreach ($template->images as $image): ?>
            <?= Html::img($image->getUrl(), ['class' => 'file-preview-image', 'style' => 'width:100%']) ?><hr>
        <?php endforeach ?>
    <?php endif ?>
</div>