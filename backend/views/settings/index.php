<?php
/**
 * @var yii\web\View $this
 * @var common\models\File[] $files
 * @var common\models\Screenshot $screenshot
 * @var boolean $isCommon
 * @var boolean $isRemovable
 */

use yii\bootstrap\Button;
use yii\helpers\Html;
use backend\assets\SettingsAsset;

SettingsAsset::register($this);

$title = Yii::t('tg', $isCommon ? 'Common Files' : 'Additional Files');

$this->title = $title;

echo Html::hiddenInput('isCommon', $isCommon, ['id' => 'isCommon']);
echo Html::hiddenInput('isRemovable', $isRemovable, ['id' => 'isRemovable']);
?>
    <div id="page-title">
        <h1 class="page-header text-overflow">
            <?= $title ?>
        </h1>

        <div class="block-right">
            <?= Button::widget([
                'label' => '<i class="fa fa-file-o"></i> Add File',
                'encodeLabel' => false,
                'options' => [
                    'id' => 'add-file',
                    'class' => 'btn-primary',
                ]
            ]) ?>
        </div>
    </div>

    <div id="page-content">
        <div class="row">

            <?php foreach ($files as $file): ?>
                <?= $this->render('_panel', ['file' => $file, 'isCommon' => $isCommon, 'isRemovable' => $isRemovable, 'id' => $file->id]) ?>
            <?php endforeach ?>

            <?php if (isset($screenshot)): ?>
                <?= $this->render('_screenshot', ['screenshot' => $screenshot]) ?>
            <?php endif ?>

        </div>
    </div>

<?php
$js = <<<JS

JS;
$this->registerJs($js, $this::POS_READY, 'settings-script');
