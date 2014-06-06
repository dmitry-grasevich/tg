<?php

namespace common\models;

use Yii;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

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
class Image extends Library
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
            [['filename'], 'file', 'types' => 'jpg,jpeg,gif,png'],
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
            'filename' => Yii::t('app', 'File'),
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

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $dir = Yii::getAlias('@webroot/templateImages');
            FileHelper::createDirectory($dir);
            $img = UploadedFile::getInstance($this, 'filename');
            if (!empty($img)) {
                $img->saveAs($dir . '/' . $img->name);
                $this->filename = $img->name;
            }

            return true;
        } else {
            return false;
        }
    }
}
