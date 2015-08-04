<?php

namespace common\models;

use common\helpers\ZipArchiveTg;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\VarDumper;

class Generator
{
    const DIR_PARTIALS = 'partials';

    /**
     * @param $q - query
     */
    public static function run($q)
    {
        $blocks = array_map('trim', explode(',', $q['blocks']));

        self::createZip($blocks);
    }

    public static function createZip($blocks)
    {
        $file = tempnam('tmp', uniqid('zip'));
        $zip = new ZipArchiveTg();
        $zip->open($file, \ZipArchive::OVERWRITE);

        $templateSource = self::getTemplateSourcePath();

        /** 1. Add common dirs */
        foreach (['core', 'css', 'fonts', 'TGM-Plugin-Activation'] as $dir) {
            $zip->addDir(Yii::getAlias($templateSource . '/' . $dir), '');
        }

        /** 2. Prepare and add common files */
        $commonFiles = File::find()->common()->all();
        foreach ($commonFiles as $commonFile) {
            /** @var File $commonFile */
            $zip->addFromString($commonFile->filename, $commonFile->code);
        }

        /** @var Screenshot $screenshot */
        $screenshot = Screenshot::find()->screenshot()->one();
        $zip->addFile(Yii::getAlias(Screenshot::getImageDir() . '/' . $screenshot->filename), $screenshot->filename);

        /** 3. Prepare customizer config and put it to core/customizer/builder/config.php */
        /** 4. Add blocks HTML into partials */
        $templates = Template::findAll($blocks);
        if (count($templates)) {
            $zip->addEmptyDir(self::DIR_PARTIALS);
            foreach ($templates as $template) {
                /** @var Template $template */
                $zip->addFromString(self::DIR_PARTIALS . '/section-' . $template->alias . '.php', $template->code);
            }
        }

        $css = $zip->getFromName(Yii::getAlias($templateSource) . '/css/theme.css');
        $css .= "\nTEST STRING\n";
        $zip->addFromString('css/theme.css', $css);

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