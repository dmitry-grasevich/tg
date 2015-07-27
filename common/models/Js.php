<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "js".
 *
 * @property integer $id
 * @property string $name
 * @property string $code
 * @property string $filename
 * @property string $directory
 *
 * @property TemplateJs[] $templateJs
 */
class Js extends Library
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'js';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['code'], 'string'],
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
            'code' => Yii::t('tg', 'Code'),
            'filename' => Yii::t('tg', 'Filename'),
            'directory' => Yii::t('tg', 'Directory'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTemplateJs()
    {
        return $this->hasMany(TemplateJs::className(), ['js_id' => 'id']);
    }
}
