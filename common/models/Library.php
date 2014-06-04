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

    public function saveRelated($relation, $data)
    {
        // remove old relations
        foreach ($this->$relation as $related) {
            $this->unlink($relation, $related, true);
        }

        // create new if exists
        if (is_array($data)) {
            $related = self::findAll($data);
            foreach($related as $rel) {
                $this->link($relation, $rel);
            }
        }
    }
}