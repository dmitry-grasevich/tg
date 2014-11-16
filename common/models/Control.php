<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "control".
 *
 * @property integer $id
 * @property string $name
 * @property string $code
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
            [['name', 'code'], 'required'],
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
            'code' => Yii::t('app', 'Code'),
        ];
    }
}
