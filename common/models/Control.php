<?php

namespace common\models;

use Yii;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

/**
 * This is the model class for table "control".
 *
 * @property integer $id
 * @property string $name
 * @property string $family     control family, can be one of [wp, tg, kirki]
 * @property string $type       control type
 * @property string $class
 * @property string $params
 * @property string $css
 * @property string $img
 *
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
            [['params', 'css'], 'string'],
            [['family', 'type', 'class'], 'required'],
            [['name', 'family', 'type', 'class', 'img'], 'string', 'max' => 255],
            [['type'], 'unique'],
            [['img'], 'file', 'extensions' => 'jpg,jpeg,gif,png'],
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
            'family' => Yii::t('tg', 'Family'),
            'type' => Yii::t('tg', 'Type'),
            'class' => Yii::t('tg', 'Class'),
            'params' => Yii::t('tg', 'Params'),
            'css' => Yii::t('tg', 'CSS'),
            'img' => Yii::t('tg', 'Preview Image'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSectionControls()
    {
        return $this->hasMany(SectionControl::className(), ['control_id' => 'id']);
    }

    public static function getImagePath()
    {
        return Yii::getAlias('@web/images/controls');
    }

    /**
     * @param bool $insert
     * @return bool
     * @throws \yii\base\Exception
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $img = UploadedFile::getInstance($this, 'img');
            if (!empty($img)) {
                $backendDir = self::getImagePath();
                FileHelper::createDirectory($backendDir);

                if (!$img->saveAs($backendDir . '/' . $img->name)) {
                    return false;
                }
                $this->img = $img->name;
            } elseif (!$this->getIsNewRecord()) {
                $this->img = $this->getOldAttribute('img');
            }
            return true;
        } else {
            return false;
        }
    }

    public static function listFamilies()
    {
        return [
            'wp' => 'Wordpress',
            'tg' => 'Template Generator',
            'kirki' => 'Kirki',
        ];
    }
}
