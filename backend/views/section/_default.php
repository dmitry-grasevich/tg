<?php
use yii\helpers\Url;
use kartik\form\ActiveForm;
use kartik\widgets\Typeahead;
use kartik\widgets\ColorInput;
use \common\models\SectionControl;

/**
 * @var yii\web\View $this
 * @var common\models\Section $section
 */
$form = ActiveForm::begin([
    'id' => 'default-values-form',
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
        Default Values
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
                            if ($control->name == 'Font') {
                                echo Typeahead::widget([
                                    'name' => "Default[{$sectionControl->id}]",
                                    'value' => $sectionControl->default,
                                    'options' => [
                                        'placeholder' => 'Filter as you type ...',
                                    ],
                                    'scrollable' => true,
                                    'pluginOptions' => ['highlight' => true],
                                    'dataset' => [
                                        [
                                            'prefetch' => Url::to(['google-font-list']),
                                            'limit' => 10
                                        ]
                                    ],
                                ]);
                            } elseif ($control->name == 'Color') {
                                echo ColorInput::widget([
                                    'name' => "Default[{$sectionControl->id}]",
                                    'value' => $sectionControl->default,
                                ]);
                            } elseif ($control->name == 'Text') {
                                echo \kartik\helpers\Html::textInput("Default[{$sectionControl->id}]", $sectionControl->default, [
                                    'class' => 'form-control',
                                    'placeholder' => 'Enter default text',
                                ]);
                            }
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
