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

        /** 3. Add blocks HTML into partials and prepare customizer config */
        $templates = Template::findAll($blocks);
        if (count($templates)) {
            $zip->addEmptyDir(self::DIR_PARTIALS);

            /** @var File $config */
            $config = File::find()->config()->one();

            /** @var File $css */
            $css = File::find()->styles()->one();

            $panelCode = $sectionCode = $controlCode = $styleCode = $pseudoJsCode = $cssCode = '';

            $panelPriority = 20;
            $priorityStep = 10;
            foreach ($templates as $template) {
                /** @var Template $template */
                $templateData = $template->getCustomizerControls();

                $panelCode .= $template->getCodeForConfig($panelPriority);
                $panelPriority += $priorityStep;

                $zip->addFromString(self::DIR_PARTIALS . '/section-' . $template->alias . '.php', $template->code);

                if (!empty($css)) {
                    $cssCode .= self::getComment("Styles for block \"" . $template->name . "\"");
                    $cssCode .= $template->style;
                    $cssCode .= self::getComment("End of styles for block \"" . $template->name . "\"");
                }

                if (!isset($templateData['sections']) || empty($templateData['sections'])) {
                    continue;
                }

                $sectionCode .= "// " . $template->title . "\n            ";

                $sectionPriority = 10;
                foreach ($templateData['sections'] as $sectionData) {
                    $section = new Section();
                    $section->attributes = $sectionData;
                    $sectionCode .= $section->getCodeForConfig($template->alias, $sectionPriority);
                    $sectionPriority += $priorityStep;

                    if (!isset($sectionData['sectionControls']) || empty($sectionData['sectionControls'])) {
                        continue;
                    }

                    $controlCode .= "// " . $template->title . " -> " . $section->title . "\n            ";
                    $controlCode .= "'" . $section->alias . "' => array(\n                ";

                    foreach ($sectionData['sectionControls'] as $sectionControlData) {
                        $sectionControl = new SectionControl();
                        $sectionControl->attributes = $sectionControlData;
                        $controlCode .= $sectionControl->getCodeForConfig($section->alias);

                        if (!empty($sectionControl->style)) {
                            $styleCode .= $sectionControl->getStylesForConfig($section->alias);
                        }

                        if (!empty($sectionControl->pseudojs)) {
                            $pseudoJsCode .= $sectionControl->getPseudoJsForConfig($section->alias);
                        }
                    }

                    $controlCode .= "\n            ),\n            ";
                }
            }

            if (!empty($config)) {
                $configCode = $config->code;
                $search = ['{%panels%}', '{%sections%}', '{%controls%}', '{%styles%}', '{%pseudojs%}'];
                $replace = [$panelCode, $sectionCode, $controlCode, $styleCode, $pseudoJsCode];
                $configCode = str_replace($search, $replace, $configCode);
                $zip->addFromString($config->directory . '/' . $config->filename, $configCode);
            }

            if (!empty($css)) {
                $zip->addFromString($css->directory . '/' . $css->filename, $css->code . $cssCode);
            }
        }

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

    protected static function getComment($text)
    {
        return "\n/**
 * ----------------------------------------------------------------------------------------
 * $text
 * ----------------------------------------------------------------------------------------
 */\n";
    }

    public static function getTemplateSourcePath()
    {
        return '@backend/web/' . Yii::$app->params['template']['alias']['templateSource'];
    }
}