<?php

namespace common\models;

use Yii;
use yii\helpers\FileHelper;
use yii\helpers\VarDumper;
use yii\web\UploadedFile;

/**
 * This is the model class for table "common_file".
 *
 * @property integer $id
 * @property string $name
 * @property string $filename
 * @property string $directory
 * @property string $code
 */
class Screenshot extends File
{
    const SCREENSHOT_FILENAME = 'screenshot.png';

    /**
     * @return bool|string
     */
    public static function getImagePath()
    {
        return Yii::getAlias('@web/images/template');
    }

    /**
     * @return bool|string
     */
    public static function getImageDir()
    {
        return Yii::getAlias('@backend/web/images/template');
    }

    /**
     * @param bool $insert
     * @return bool
     * @throws \yii\base\Exception
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $img = UploadedFile::getInstance($this, 'code');
            if (!empty($img)) {
                $backendDir = self::getImageDir();
                FileHelper::createDirectory($backendDir);

                if (!$img->saveAs($backendDir . '/' . self::SCREENSHOT_FILENAME)) {
                    return false;
                }
                $this->code = self::SCREENSHOT_FILENAME;
            } elseif (!$this->getIsNewRecord()) {
                $this->code = $this->getOldAttribute('code');
            }
            return true;
        } else {
            return false;
        }
    }
}
