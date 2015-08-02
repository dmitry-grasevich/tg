<?php
/**
 * @var yii\web\View $this
 */

use yii\helpers\Html;
use common\models\Control;

$controls = Control::find()->orderBy('name')->all();
?>
<!-- Controls Panel -->
<!--===================================================-->
<aside id="aside-container">
    <div id="aside">
        <div class="nano has-scrollbar">
            <div class="nano-content" tabindex="0" style="right: -15px;">

                <h4 class="pad-hor text-thin">
                    <i class="fa fa-list-alt"></i> <?= Yii::t('tg', 'Controls') ?>
                </h4>

                <div class="list-group section bg-trans">
                    <a href="#" class="list-group-item">
                        <div class="media-body">
                            <div class="text-lg">Section</div>
                            <?= Html::img(Control::getImagePath() . '/section.png', [
                                'style' => 'max-width: 188px;',
                                'data' => [
                                    'type' => Control::TYPE_SECTION,
                                ]
                            ]) ?>
                        </div>
                    </a>
                </div>

                <?php /** @var common\models\Control $control */ ?>
                <?php foreach ($controls as $control): ?>
                    <div class="list-group control bg-trans">
                        <a href="#" class="list-group-item">
                            <div class="media-body">
                                <div class="text-lg"><?= $control->name ?></div>
                                <?php if (!empty($control->img)) {
                                    echo Html::img(Control::getImagePath() . '/' . $control->img, [
                                        'style' => 'max-width: 188px;',
                                        'data' => [
                                            'type' => Control::TYPE_CONTROL,
                                            'id' => $control->id,
                                            'name' => $control->name,
                                        ]
                                    ]);
                                } ?>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>

            </div>
        </div>
    </div>
</aside>
<!--===================================================-->
<!-- END Controls Panel -->