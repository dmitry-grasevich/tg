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
 * @property string $style
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
            [['name'], 'string', 'max' => 255],
            [['style'], 'string'],
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
            'alias' => Yii::t('tg', 'Alias'),
            'is_basic' => Yii::t('tg', 'Basic Category'),
            'is_visible' => Yii::t('tg', 'Visible on Frontend'),
            'style' => Yii::t('tg', 'Style'),
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
