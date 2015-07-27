<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "control".
 *
 * @property integer $id
 * @property string $name
 * @property string $code
 * @property string $styles_code
 * @property string $family     control family, can be one of [wp, tg, kirki]
 * @property string $type       control type
 * @property string $class
 * @property string $params
 * @property string $css
 *
 * @property ControlImage[] $controlImages
 * @property SectionControl[] $sectionControls
 */
class Control extends Library
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'control';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code', 'styles_code', 'mods_code', 'params'], 'string'],
            [['family', 'type', 'class'], 'required'],
            [['name', 'family', 'type', 'class'], 'string', 'max' => 255],
            [['family'], 'unique'],
            [['type'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('tg', 'ID'),
            'name' => Yii::t('tg', 'Name'),
            'code' => Yii::t('tg', 'Code'),
            'styles_code' => Yii::t('tg', 'Code for Styles'),
            'family' => Yii::t('tg', 'Family'),
            'type' => Yii::t('tg', 'Type'),
            'class' => Yii::t('tg', 'Class'),
            'params' => Yii::t('tg', 'Params'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getControlImages()
    {
        return $this->hasMany(ControlImage::className(), ['control_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSectionControls()
    {
        return $this->hasMany(SectionControl::className(), ['control_id' => 'id']);
    }
}
