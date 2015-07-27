<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "control_image".
 *
 * @property integer $id
 * @property integer $control_id
 * @property integer $image_id
 *
 * @property Control $control
 * @property Image $image
 */
class ControlImage extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'control_image';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['control_id', 'image_id'], 'required'],
            [['control_id', 'image_id'], 'integer'],
            [['control_id'], 'exist', 'skipOnError' => true, 'targetClass' => Control::className(), 'targetAttribute' => ['control_id' => 'id']],
            [['image_id'], 'exist', 'skipOnError' => true, 'targetClass' => Image::className(), 'targetAttribute' => ['image_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('tg', 'ID'),
            'control_id' => Yii::t('tg', 'Control ID'),
            'image_id' => Yii::t('tg', 'Image ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getControl()
    {
        return $this->hasOne(Control::className(), ['id' => 'control_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImage()
    {
        return $this->hasOne(Image::className(), ['id' => 'image_id']);
    }
}
