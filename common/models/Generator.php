<?php

namespace common\models;

use common\helpers\ZipArchiveTg;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\VarDumper;

class Generator
{
    const DIR_PARTIALS = 'partials';
    const DIR_IMAGES = 'images';

    /**
     * @param $q - query
     */
    public static function run($q)
    {
        $blocks = array_map('trim', explode(',', $q['blocks']));

        self::createZip($blocks, $q['name']);
    }

    public static function createZip($blocks, $name)
    {
        $file = tempnam('tmp', uniqid('zip'));
        $zip = new ZipArchiveTg();
        $zip->open($file, \ZipArchive::OVERWRITE);

        /** @var Screenshot $screenshot */
        $screenshot = Screenshot::find()->screenshot()->one();
        $zip->addFile(Yii::getAlias(Screenshot::getImageDir() . '/' . $screenshot->filename), $screenshot->filename);

        /** Add directory for the attached images */
        $zip->addEmptyDir(self::DIR_IMAGES);

        /** Add blocks HTML into partials and prepare customizer config */
        $templates = Template::findAll($blocks);
        if (count($templates)) {
            $zip->addEmptyDir(self::DIR_PARTIALS);

            /** @var File $config */
            $config = File::find()->config()->one();

            /** @var File $css */
            $css = File::find()->styles()->one();

            $panelCode = $sectionCode = $controlCode = $styleCode = $pseudoJsCode =
            $sorterDefault = $sorterChoices = $cssCode = '';

            $panelPriority = 20;
            $priorityStep = 10;
            foreach ($templates as $template) {
                $templateCode = $template->code;

                /** @var Template $template */
                $templateData = $template->getCustomizerControls();
                if (isset($templateData['images']) && count($templateData['images'])) {
                    foreach ($templateData['images'] as  $id => $img) {
                        $image = new Image();
                        $image->attributes = $img;
                        $path = empty($image->directory) ? $image->filename : $image->directory . '/' . $image->filename;
                        $zip->addFile(Image::getPath() . '/' . $path, self::DIR_IMAGES . '/' . $path);
                    }
                }

                $panelCode .= $template->getCodeForConfig($panelPriority);
                $panelPriority += $priorityStep;

                $sorterDefault .= "'" . $template->alias . "',\n                        ";
                $sorterChoices .= "'" . $template->alias . "' => __('" . $template->title . "', 'tg'),\n                        ";

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
                        $alias = $template->alias . '-' . $section->alias;
                        $controlCode .= $sectionControl->getCodeForConfig($alias);

                        $templateCode = $sectionControl->applyDefault($alias, $templateCode);

                        if (!empty($sectionControl->style)) {
                            $styleCode .= $sectionControl->getStylesForConfig($alias);
                        }

                        if (!empty($sectionControl->pseudojs)) {
                            $pseudoJsCode .= $sectionControl->getPseudoJsForConfig($alias);
                        }
                    }

                    $controlCode .= "\n            ),\n            ";
                }

                $zip->addFromString(self::DIR_PARTIALS . '/section-' . $template->alias . '.php', $templateCode);
            }

            if (!empty($config)) {
                $configCode = $config->code;
                $search = ['{%panels%}', '{%sections%}', '{%controls%}', '{%styles%}', '{%pseudojs%}',
                    '{%sorter_default%}', '{%sorter_choices%}'];
                $replace = [$panelCode, $sectionCode, $controlCode, $styleCode, $pseudoJsCode, $sorterDefault, $sorterChoices];
                $configCode = str_replace($search, $replace, $configCode);
                $zip->addFromString($config->directory . '/' . $config->filename, $configCode);
            }

            if (!empty($css)) {
                $zip->addFromString($css->directory . '/' . $css->filename, $css->code . $cssCode);
            }
        }

        $templateSource = self::getTemplateSourcePath();

        /** Add common dirs */
        foreach (['core', 'css', 'fonts', 'TGM-Plugin-Activation'] as $dir) {
            $zip->addDir(Yii::getAlias($templateSource . '/' . $dir), '');
        }

        /** Prepare and add common files */
        $commonFiles = File::find()->common()->all();
        foreach ($commonFiles as $commonFile) {
            /** @var File $commonFile */
            if ($commonFile->filename == File::COMMON_CSS_FILENAME) {
                $commonFile->code = str_replace('{{name}}', $name, $commonFile->code);
            } elseif ($commonFile->filename == File::COMMON_INDEX_FILENAME) {
                // convert comma separated string into array and trim all elements (explode -> array_map(trim, ...))
                // remove all empty values and convert array into comma separated string (array_filter -> implode)
                $sorterCode = 'array(' . implode(', ', array_filter(array_map('trim', explode(',', $sorterDefault)))) . ')';
                $commonFile->code = str_replace("'tg-sections-order-sorter'", "'tg-sections-order-sorter', " . $sorterCode, $commonFile->code);
            }
            $zip->addFromString($commonFile->filename, $commonFile->code);
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