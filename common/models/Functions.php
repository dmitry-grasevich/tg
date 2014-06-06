<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "functions".
 *
 * @property integer $id
 * @property string $name
 * @property string $code
 *
 * @property TemplateFunctions[] $templateFunctions
 */
class Functions extends Library
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'functions';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['code'], 'string'],
            [['name'], 'string', 'max' => 255]
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTemplateFunctions()
    {
        return $this->hasMany(TemplateFunctions::className(), ['functions_id' => 'id']);
    }
}
