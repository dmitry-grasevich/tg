<?php

namespace common\models;

use Yii;
use common\models\Library;

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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTemplateCsses()
    {
        return $this->hasMany(TemplateCss::className(), ['css_id' => 'id']);
    }
}
