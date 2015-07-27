<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "template_image".
 *
 * @property integer $id
 * @property integer $template_id
 * @property integer $image_id
 *
 * @property Image $image
 * @property Template $template
 */
class TemplateImage extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'template_image';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['template_id', 'image_id'], 'required'],
            [['template_id', 'image_id'], 'integer'],
            [['template_id'], 'exist', 'skipOnError' => true, 'targetClass' => Control::className(), 'targetAttribute' => ['template_id' => 'id']],
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
            'template_id' => Yii::t('tg', 'Template ID'),
            'image_id' => Yii::t('tg', 'Image ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImage()
    {
        return $this->hasOne(Image::className(), ['id' => 'image_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTemplate()
    {
        return $this->hasOne(Template::className(), ['id' => 'template_id']);
    }
}
