<?php

namespace common\models;

use Yii;
use common\models\Library;

/**
 * This is the model class for table "template_category".
 *
 * @property integer $id
 * @property string $name
 * @property integer $is_basic
 * @property integer $is_visible  show or not this category items on frontend
 *
 * @property Template[] $templates
 */
class TemplateCategory extends Library
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'template_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
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
}
