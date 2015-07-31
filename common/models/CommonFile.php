<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "common_file".
 *
 * @property integer $id
 * @property string $name
 * @property string $filename
 * @property string $directory
 * @property string $code
 */
class CommonFile extends Library
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'common_file';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'filename'], 'required'],
            [['code'], 'string'],
            [['name', 'filename', 'directory'], 'string', 'max' => 255],
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
            'filename' => Yii::t('tg', 'Filename'),
            'directory' => Yii::t('tg', 'Directory'),
            'code' => Yii::t('tg', 'Code'),
        ];
    }
}
