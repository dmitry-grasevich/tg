<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "template_font".
 *
 * @property integer $id
 * @property integer $template_id
 * @property integer $font_id
 *
 * @property Font $font
 * @property Template $template
 */
class TemplateFont extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'template_font';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['template_id', 'font_id'], 'required'],
            [['template_id', 'font_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('tg', 'ID'),
            'template_id' => Yii::t('tg', 'Template ID'),
            'font_id' => Yii::t('tg', 'Font ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFont()
    {
        return $this->hasOne(Font::className(), ['id' => 'font_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTemplate()
    {
        return $this->hasOne(Template::className(), ['id' => 'template_id']);
    }
}
