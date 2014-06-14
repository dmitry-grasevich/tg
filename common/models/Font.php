<?php

namespace common\models;

use Yii;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

/**
 * This is the model class for table "font".
 *
 * @property integer $id
 * @property string $name
 * @property string $filename
 * @property string $directory
 *
 * @property TemplateFont[] $templateFonts
 */
class Font extends Library
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'font';
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
    public function getTemplateFonts()
    {
        return $this->hasMany(TemplateFont::className(), ['font_id' => 'id']);
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $dir = Yii::getAlias('@webroot' . Yii::$app->params['template']['alias']['fonts']);
            if ($this->directory) {
                $dir .= '/' . $this->directory;
            }
            FileHelper::createDirectory($dir);
            $font = UploadedFile::getInstance($this, 'filename');
            if (!empty($font)) {
                $font->saveAs($dir . '/' . $font->name);
                $this->filename = $font->name;
            }

            return true;
        } else {
            return false;
        }
    }
}
