<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "functions".
 *
 * @property integer $id
 * @property string $name
 * @property string $code
 * @property integer $parent_id
 *
 * @property TemplateFunctions[] $templateFunctions
 * @property Template $parent
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
            [['parent_id'], 'integer'],
            [['name'], 'string', 'max' => 255]
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
            'parent_id' => Yii::t('tg', 'Parent'),
            'parentName' => Yii::t('tg', 'Parent'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(Template::className(), ['id' => 'parent_id']);
    }

    /**
     * Getter for parent name
     *
     * @return string  parent name
     */
    public function getParentName()
    {
        return empty($this->parent) ? '' : $this->parent->name;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTemplateFunctions()
    {
        return $this->hasMany(TemplateFunctions::className(), ['functions_id' => 'id']);
    }
}
