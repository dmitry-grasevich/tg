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
    const TYPE_SECTION = 'section';
    const TYPE_CONTROL = 'sectioncontrol';

    protected static $_allowedTypes = [self::TYPE_SECTION, self::TYPE_CONTROL];

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
            [['imgUrl'], 'safe'],
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

    /**
     * @return bool|string
     */
    public static function getImagePath()
    {
        return Yii::getAlias('@web/images/controls');
    }

    /**
     * @return bool|string
     */
    public function getImageDir()
    {
        return Yii::getAlias('@backend/web/images/controls');
    }

    /**
     * @return string
     */
    public function getImgUrl()
    {
        return self::getImagePath() . '/' . $this->img;
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
                $backendDir = self::getImageDir();
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

    /**
     * @return array
     */
    public static function listFamilies()
    {
        return [
            'wp' => 'Wordpress',
            'tg' => 'Template Generator',
            'kirki' => 'Kirki',
        ];
    }

    /**
     * Return true if type is allowed control type
     *
     * @param $type
     *
     * @return bool
     */
    public static function isAllowedType($type)
    {
        return in_array($type, self::$_allowedTypes);
    }
}
