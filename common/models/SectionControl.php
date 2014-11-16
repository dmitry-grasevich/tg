<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "section_control".
 *
 * @property integer $id
 * @property integer $section_id
 * @property integer $control_id
 * @property integer $priority
 *
 * @property Section $section
 * @property Control $control
 */
class SectionControl extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'section_control';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['section_id', 'control_id'], 'required'],
            [['section_id', 'control_id', 'priority'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'section_id' => Yii::t('app', 'Section ID'),
            'control_id' => Yii::t('app', 'Control ID'),
            'priority' => Yii::t('app', 'Priority'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSection()
    {
        return $this->hasOne(Section::className(), ['id' => 'section_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getControl()
    {
        return $this->hasOne(Control::className(), ['id' => 'control_id']);
    }
}
