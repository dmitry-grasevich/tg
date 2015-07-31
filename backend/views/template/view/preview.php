<?php
/**
 * @var yii\web\View $this
 * @var common\models\Template $template
 */

use yii\helpers\Html;

?>
<div class="form-group">
    <h4><?= $template->title ?></h4>

    <?php if (!empty($template->description)): ?>
        <p><?= $template->description ?></p>
    <?php endif ?>

    <?php if (!empty($template->img)): ?>
        <?= Html::img($template->getImagePath() . '/' . $template->img, ['class'=>'file-preview-image', 'style' => 'width:100%']) ?>
    <?php endif ?>

    <?php if (!empty($template->code)): ?>
        <pre class="scroll"><code><?= Html::encode($template->code) ?></code></pre>
    <?php endif ?>
</div>