<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "related_template".
 *
 * @property integer $id
 * @property integer $parent_id
 * @property integer $child_id
 *
 * @property Template $child
 * @property Template $parent
 */
class RelatedTemplate extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'related_template';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_id', 'child_id'], 'required'],
            [['parent_id', 'child_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'parent_id' => Yii::t('app', 'Parent ID'),
            'child_id' => Yii::t('app', 'Child ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChild()
    {
        return $this->hasOne(Template::className(), ['id' => 'child_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(Template::className(), ['id' => 'parent_id']);
    }
}
