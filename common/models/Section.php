<?php

namespace common\models;

use Yii;
use yii\helpers\Html;
use yii\helpers\VarDumper;

/**
 * This is the model class for table "section".
 *
 * @property integer $id
 * @property string $name
 * @property string $code
 *
 * @property SectionControl[] $sectionControls
 * @property Control[] $controls
 */
class Section extends Library
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'section';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'code'], 'required'],
            // relations
            [['controls'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'code' => Yii::t('app', 'Code'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSectionControls()
    {
        return $this->hasMany(SectionControl::className(), ['section_id' => 'id'])->orderBy('priority');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getControls()
    {
        return $this->hasMany(Control::className(), ['id' => 'control_id'])->via('sectionControls');
    }

    /**
     * @param array $controls
     */
    public function setControls($controls)
    {
        $controls = empty($controls) ? [] : Control::findAll($controls);
        $this->populateRelation('controls', $controls);
    }

    /**
     * @return string
     */
    public function getControlsName()
    {
        if (!empty($this->controls)) {
            $names = [];
            foreach ($this->controls as $control)
                $names[] = Html::a($control->name, ['/control/view', 'id' => $control->id]);
            return implode(', ', $names);
        }
        return '';
    }

    /**
     * @param bool $insert
     * @param array $changedAttributes
     */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        $relatedRecords = $this->getRelatedRecords();
        foreach ($relatedRecords as $model => $data) {
            if (!is_array($data)) continue;
            $this->unlinkAll($model, true);
            if (!empty($data)) {
                foreach ($data as $relation) {
                    $this->link($model, $relation);
                }
            }
        }
    }
}
