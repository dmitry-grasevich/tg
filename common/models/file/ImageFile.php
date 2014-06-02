<?php

namespace common\models\file;

use Yii;
use yii\base\Model;

class ImageFile extends Model
{
    public $img;

    public function rules()
    {
        return [
            [['img'], 'safe'],
            [['img'], 'file', 'types' => 'jpg'],
        ];
    }
}