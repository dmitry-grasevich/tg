<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "template_section".
 *
 * @property integer $id
 * @property integer $template_id
 * @property integer $section_id
 * @property integer $priority
 *
 * @property Section $section
 * @property Template $template
 */
class TemplateSection extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'template_section';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['template_id', 'section_id'], 'required'],
            [['template_id', 'section_id', 'priority'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'template_id' => Yii::t('app', 'Template ID'),
            'section_id' => Yii::t('app', 'Section ID'),
            'priority' => Yii::t('app', 'Priority'),
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
     * @return \yii\db\ActiveQuery
     */
    public function getTemplate()
    {
        return $this->hasOne(Template::className(), ['id' => 'template_id']);
    }
}
