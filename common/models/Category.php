<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "category".
 *
 * @property integer $id
 * @property string $name
 * @property string $alias
 * @property integer $is_basic
 * @property integer $is_visible  show or not this category items on frontend
 *
 * @property Template[] $templates
 */
class Category extends Library
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'alias'], 'required'],
            [['alias'], 'unique'],
            [['is_basic', 'is_visible'], 'integer'],
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
            'alias' => Yii::t('app', 'Alias'),
            'is_basic' => Yii::t('app', 'Basic Category'),
            'is_visible' => Yii::t('app', 'Visible on Frontend'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTemplates()
    {
        return $this->hasMany(Template::className(), ['category_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVisibleTemplates()
    {
        return $this->hasMany(Template::className(), ['category_id' => 'id'])->where(['template.is_visible' => 1]);
    }
}
