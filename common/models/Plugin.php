<?php

namespace common\models;

use Yii;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

/**
 * This is the model class for table "plugin".
 *
 * @property integer $id
 * @property string $name
 * @property string $directory
 *
 * @property TemplatePlugin[] $templatePlugins
 */
class Plugin extends Library
{
    public $filename;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'plugin';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name', 'directory'], 'string', 'max' => 255]
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
            'directory' => Yii::t('app', 'Directory'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTemplatePlugins()
    {
        return $this->hasMany(TemplatePlugin::className(), ['plugin_id' => 'id']);
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $dir = Yii::getAlias('@webroot' . Yii::$app->params['template']['alias']['plugins']);
            FileHelper::createDirectory($dir);
            $plugin = UploadedFile::getInstance($this, 'filename');
            if (!empty($plugin)) {
                if (!$plugin->name) {
                    return true;
                }
                $pluginPath = $dir . '/' . $plugin->name;
                $pluginDir = $dir . '/' . $this->directory;
                if (is_dir($pluginDir)) {
                    FileHelper::removeDirectory($pluginDir);
                }
                $plugin->saveAs($pluginPath);
                $zip = new \ZipArchive();
                if ($zip->open($pluginPath) === TRUE) {
                    $zip->extractTo($dir);
                    $zip->close();
                    unlink($pluginPath);
                } else {
                    return false;
                }
            }

            return true;
        } else {
            return false;
        }
    }
}
