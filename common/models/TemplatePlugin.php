<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "template_plugin".
 *
 * @property integer $id
 * @property integer $template_id
 * @property integer $plugin_id
 *
 * @property Plugin $plugin
 * @property Template $template
 */
class TemplatePlugin extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'template_plugin';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['template_id', 'plugin_id'], 'required'],
            [['template_id', 'plugin_id'], 'integer']
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
            'plugin_id' => Yii::t('app', 'Plugin ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlugin()
    {
        return $this->hasOne(Plugin::className(), ['id' => 'plugin_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTemplate()
    {
        return $this->hasOne(Template::className(), ['id' => 'template_id']);
    }
}
