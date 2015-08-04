<?php

namespace common\models;

use common\helpers\ZipArchiveTg;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\VarDumper;

class Generator
{
    /**
     * @param $q - query
     */
    public static function run($q)
    {
        self::createZip();
    }

    public static function createZip()
    {
        $file = tempnam('tmp', uniqid('zip'));
        $zip = new ZipArchiveTg();
        $zip->open($file, \ZipArchive::OVERWRITE);

        $templateSource = self::getTemplateSourcePath();

        /** 1. Add common dirs */
        foreach (['core', 'css', 'fonts', 'TGM-Plugin-Activation'] as $dir) {
            $zip->addDir(Yii::getAlias($templateSource . '/' . $dir), '');
        }

        /** 2. Prepare customizer config and put it to core/customizer/builder/config.php */
        /** 3. Add blocks HTML into partials */
        /** 4. Prepare and add common files */
            /** 1. Add common styles.css */
            /** 2. Add common screenshot.png */
            /** 3. Add common header.php */
            /** 4. Add common footer.php */
            /** 5. Add common index.php */
            /** 6. Prepare and add common functions.php */

        // Close and send to user
        $zip->close();
        header('Set-Cookie: fileDownload=true; path=/');
        header('Cache-Control: max-age=60, must-revalidate');
        header('Content-Type: application/zip');
        header('Content-Length: ' . filesize($file));
        header('Content-Disposition: attachment; filename="template.zip"');
        readfile($file);
        unlink($file);
    }

    public static function getTemplateSourcePath()
    {
        return '@backend/web/' . Yii::$app->params['template']['alias']['templateSource'];
    }
}