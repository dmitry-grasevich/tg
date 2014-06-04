<?php

namespace common\models;

use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

class Library extends ActiveRecord
{
    public static function listAll($excludeIds = [])
    {
        $all = self::find()->where(['not in', 'id', $excludeIds])->orderBy('name')->asArray()->all();
        if (!empty($all)) {
            return ArrayHelper::map($all, 'id', 'name');
        } else {
            return [0 => ''];
        }
    }
}