<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;
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
            [['filename'], 'file', 'extensions' => 'jpg,jpeg,gif,png'],
            [['name', 'filename', 'directory'], 'string', 'max' => 255]
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
            'filename' => Yii::t('tg', 'File'),
            'directory' => Yii::t('tg', 'Directory'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTemplateImages()
    {
        return $this->hasMany(TemplateImage::className(), ['image_id' => 'id']);
    }

    public static function listAll()
    {
        return ArrayHelper::map(Image::find()->all(), 'id', 'name');
    }

    public static function getPath()
    {
        return Yii::getAlias('@backend/web/images/template');
    }

    public function getUrl()
    {
        return Yii::getAlias('@web/images/template') . '/' . $this->filename;
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $dir = Image::getPath();
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
