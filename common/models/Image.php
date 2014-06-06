<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "image".
 *
 * @property integer $id
 * @property string $name
 * @property string $filename
 * @property string $directory
 *
 * @property TemplateImage[] $templateImages
 */
class Image extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'image';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name', 'filename', 'directory'], 'string', 'max' => 255]
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
            'filename' => Yii::t('app', 'Filename'),
            'directory' => Yii::t('app', 'Directory'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTemplateImages()
    {
        return $this->hasMany(TemplateImage::className(), ['image_id' => 'id']);
    }
}
