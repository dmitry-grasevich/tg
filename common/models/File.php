<?php

namespace common\models;

use Yii;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "common_file".
 *
 * @property integer $id
 * @property string $filename
 * @property string $directory
 * @property string $code
 */
class File extends Library
{
    const COMMON_CSS_FILENAME = 'style.css';
    const COMMON_INDEX_FILENAME = 'index.php';
    const HOME_PAGE_FILENAME = 'page-home.php';
    const CONFIG_FILENAME = 'config.php';
    const THEME_STYLES_FILENAME = 'theme.css';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'common_file';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['filename'], 'required'],
            [['code'], 'string'],
            [['filename', 'directory'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('tg', 'ID'),
            'filename' => Yii::t('tg', 'Filename'),
            'directory' => Yii::t('tg', 'Directory'),
            'code' => Yii::t('tg', 'Code'),
        ];
    }

    /**
     * @return FileQuery
     */
    public static function find()
    {
        return new FileQuery(get_called_class());
    }

    /**
     * @return bool|string
     */
    public static function getImagePath()
    {
        return Yii::getAlias('@web/images/template');
    }
}

class FileQuery extends ActiveQuery
{
    /**
     * @return $this
     */
    public function common()
    {
        return $this
            ->where(['!=', 'filename', Screenshot::SCREENSHOT_FILENAME])
            ->andWhere('directory IS NULL');
    }

    /**
     * Get additional files
     *
     * @param bool|true $excludeConfig
     * @return $this
     */
    public function additional($excludeConfig = false)
    {
        $result = $this
            ->where(['!=', 'filename', Screenshot::SCREENSHOT_FILENAME])
            ->andWhere('directory IS NOT NULL');
        if ($excludeConfig) {
            $result = $result->andWhere(['!=', 'filename', Screenshot::CONFIG_FILENAME]);
        }
        return $result;
    }

    /**
     * Get screenshot
     *
     * @return $this
     */
    public function screenshot()
    {
        return $this
            ->where(['=', 'filename', Screenshot::SCREENSHOT_FILENAME])
            ->andWhere('directory IS NULL');
    }

    /**
     * Get config file
     *
     * @return $this
     */
    public function config()
    {
        return $this
            ->where(['=', 'filename', File::CONFIG_FILENAME])
            ->andWhere('directory IS NOT NULL');
    }

    /**
     * Get styles file
     *
     * @return $this
     */
    public function styles()
    {
        return $this
            ->where(['=', 'filename', File::THEME_STYLES_FILENAME])
            ->andWhere('directory IS NOT NULL');
    }
}