<?php

namespace common\models;

use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

class Library extends ActiveRecord
{
    public static function listAll($excludeId = null)
    {
        $all = $excludeId ? self::find()->where('id != :id', [':id' => $excludeId])->orderBy('name')->asArray()->all() :
            self::find()->orderBy('name')->asArray()->all();
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