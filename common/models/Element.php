<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "element".
 *
 * @property integer $id
 * @property integer $section_id
 * @property string $name
 * @property string $description
 * @property integer $priority
 * @property string $css_selector
 * @property string $identificator
 *
 * @property TemplateElement[] $templateElement
 * @property Section $section
 * @property Template[] $templates
 */
class Element extends Library
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'element';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'section_id', 'css_selector'], 'required'],
            [['priority', 'section_id'], 'integer'],
            [['description', 'css_selector', 'identificator'], 'string'],
            [['identificator'], 'unique'],
            // relations
            [['templates'], 'safe'],
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
            'description' => Yii::t('app', 'Description'),
            'section_id' => Yii::t('app', 'Section'),
            'priority' => Yii::t('app', 'Priority'),
            'css_selector' => Yii::t('app', 'CSS Selectors'),
            'identificator' => Yii::t('app', 'Identificator'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSection()
    {
        return $this->hasOne(Section::className(), ['id' => 'section_id']);
    }

    /**
     * Getter for section name
     *
     * @return string  section name
     */
    public function getSectionName()
    {
        return $this->section->name;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTemplates()
    {
        return $this->hasMany(Template::className(), ['id' => 'template_id'])->viaTable('template_element', ['element_id' => 'id']);
    }
}
