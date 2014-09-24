<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "css".
 *
 * @property integer $id
 * @property string $name
 * @property string $code
 * @property string $filename
 * @property string $directory
 *
 * @property TemplateCss[] $templateCsses
 * @property Template $parent
 */
class Css extends Library
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'css';
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
            [['name', 'filename', 'directory'], 'string', 'max' => 255]
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
            'filename' => Yii::t('app', 'Filename'),
            'directory' => Yii::t('app', 'Directory'),
            'parent_id' => Yii::t('app', 'Parent'),
            'parentName' => Yii::t('app', 'Parent'),
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
    public function getTemplateCsses()
    {
        return $this->hasMany(TemplateCss::className(), ['css_id' => 'id']);
    }
}
