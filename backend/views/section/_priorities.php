<?php

use \kartik\form\ActiveForm;
use \common\models\SectionControl;
use \kartik\widgets\TouchSpin;

/**
 * @var yii\web\View $this
 * @var common\models\Section $section
 */
$form = ActiveForm::begin([
    'id' => 'priorities-form',
    'type' => ActiveForm::TYPE_HORIZONTAL,
]);

?>

<div class="panel panel-info">
    <div class="panel-heading">
        <div class="pull-right">
            <span class="kv-buttons-2">
                <button type="submit" class="btn btn-xs btn-info kv-btn-save" title="Save"><span class="glyphicon glyphicon-floppy-disk"></span></button>
            </span>
        </div>
        Priorities
    </div>
    <div class="table-responsive">
        <table class="detail-view table table-hover table-bordered table-striped">
            <tbody>
            <?php foreach ($section->controls as $control): ?>
                <tr>
                    <th style="width: 20%; text-align: right; vertical-align: middle;">
                        <?= $control->name ?>
                    </th>
                    <td>
                        <div class="kv-form-attribute">
                            <?php
                            $sectionControl = SectionControl::findOne(['section_id' => $section->id, 'control_id' => $control->id]);
                            echo TouchSpin::widget([
                                'name' => "Priority[{$sectionControl->id}]",
                                'pluginOptions' => [
                                    'initval' => intval($sectionControl->priority),
                                    'min' => 0,
                                    'max' => 100,
                                    'step' => 10,
                                    'verticalbuttons' => true,
                                ],
                                'options' => [
                                    'class' => 'form-control',
                                    'placeholder' => 'Enter Priority'
                                ]
                            ]);
                            ?>
                        </div>
                    </td>
                </tr>
            <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>

<?php ActiveForm::end() ?>
