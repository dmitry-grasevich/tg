<?php

namespace common\models;

use Yii;
use common\helpers\ZipArchiveTg;
use yii\behaviors\SluggableBehavior;
use yii\helpers\VarDumper;

/**
 * Class Generator
 * @package common\models
 */
class Generator
{
    const DIR_CORE = 'core';
    const DIR_FONTS = 'fonts';
    const DIR_PARTIALS = 'partials';
    const DIR_IMAGES = 'images';
    const DIR_CSS = 'css';
    const DIR_JS = 'js';
    const DIR_INC = 'inc';
    const DIR_TGM = 'TGM-Plugin-Activation';

    const SECTION_SORTER_ID = 'tg-sections-order-sorter';

    /**
     * @param $q - query
     */
    public static function run($q)
    {
        $blocks = array_map('trim', explode(',', $q['blocks']));

        self::createZip($blocks, $q['name']);
    }

    /**
     * @param $blocks
     * @param $name
     */
    public static function createZip($blocks, $name)
    {
        $file = tempnam('tmp', uniqid('zip'));
        $zip = new ZipArchiveTg();
        $zip->open($file, \ZipArchive::OVERWRITE);

        $panelCode = $sectionCode = $controlCode = $styleCode = $pseudoJsCode =
        $sorterDefault = $sorterChoices = $cssCode = $jsCode = '';
        $additionalTemplateJs = [];

        $templateSource = self::getTemplateSourcePath();

        /** Add common dirs with files */
        foreach ([self::DIR_CORE, self::DIR_FONTS, self::DIR_INC, self::DIR_PARTIALS, self::DIR_TGM] as $dir) {
            $zip->addDir(Yii::getAlias($templateSource . '/' . $dir), '');
        }

        /** Add directory for attached images */
        $zip->addEmptyDir(self::DIR_IMAGES);

        /** Add directory for styles */
        $zip->addEmptyDir(self::DIR_CSS);

        /** Add directory for scripts */
        $zip->addEmptyDir(self::DIR_JS);

        /** @var Screenshot $screenshot */
        $screenshot = Screenshot::find()->screenshot()->one();
        $zip->addFile(Yii::getAlias(Screenshot::getImageDir() . '/' . $screenshot->filename), $screenshot->filename);

        /** Prepare and add additional files */
        $addFiles = File::find()->additional(true)->all();
        foreach ($addFiles as $addFile) {
            /** @var File $addFile */
            $zip->addEmptyDir($addFile->directory);
            $zip->addFromString($addFile->directory . DIRECTORY_SEPARATOR . $addFile->filename, $addFile->code);
        }

        /** Add blocks HTML into partials and prepare customizer config */
        $templates = Template::findAll($blocks);
        if (count($templates)) {
            /** @var File $config */
            $config = File::find()->config()->one();

            /** @var File $css */
            $css = File::find()->styles()->one();

            /** @var File $js */
            $js = File::find()->scripts()->one();

            $panelPriority = 20;
            $priorityStep = 10;
            foreach ($templates as $template) {
                /** main styles for the current category */
                if (!empty($css) && !empty($template->category->style)) {
                    $cssCode .= self::getComment(strtoupper($template->category->name));
                    $cssCode .= "{$template->category->style}\n";
                }

                $templateCode = $template->code;

                /** @var Template $template */
                $templateData = $template->getCustomizerControls();
                /** Add template's images */
                if (isset($templateData['images']) && count($templateData['images'])) {
                    foreach ($templateData['images'] as  $id => $img) {
                        $image = new Image();
                        $image->attributes = $img;
                        $path = empty($image->directory) ? $image->filename : $image->directory . '/' . $image->filename;
                        $zip->addFile(Image::getPath() . '/' . $path, self::DIR_IMAGES . '/' . $path);
                    }
                }

                /** Add template's js libraries */
                if (isset($templateData['js']) && count($templateData['js'])) {
                    foreach ($templateData['js'] as  $id => $jsLib) {
                        $jsFile = new Js();
                        $jsFile->attributes = $jsLib;
                        $path = self::DIR_JS . DIRECTORY_SEPARATOR . (empty($jsFile->directory) ? '' : $jsFile->directory . DIRECTORY_SEPARATOR) . $jsFile->filename;
                        $zip->addFromString($path, $jsFile->code);
                        $additionalTemplateJs[] = $path;
                    }
                }

                $panelCode .= $template->getCodeForConfig($panelPriority);
                $panelPriority += $priorityStep;

                $sorterDefault .= "'" . $template->alias . "',\n                        ";
                $sorterChoices .= "'" . $template->alias . "' => __('{$template->title}', 'tg'),\n                        ";

                if (!empty($css) && !empty($template->style)) {
                    $cssCode .= self::getComment("Styles for block \"{$template->name}\"");
                    $cssCode .= $template->style;
                    $cssCode .= self::getComment("End of styles for block \"{$template->name}\"");
                }
                if (!empty($js) && !empty($template->script)) {
                    $jsCode .= self::getComment(strtoupper($template->name));
                    $jsCode .= "{$template->script}\n";
                }

                if (!isset($templateData['sections']) || empty($templateData['sections'])) {
                    continue;
                }

                $sectionCode .= "// {$template->title}\n            ";

                $sectionPriority = 10;
                foreach ($templateData['sections'] as $sectionData) {
                    $section = new Section();
                    $section->attributes = $sectionData;
                    $section->setPanelAlias($template->alias);
                    $sectionCode .= $section->getCodeForConfig($sectionPriority);
                    $sectionPriority += $priorityStep;

                    if (!isset($sectionData['sectionControls']) || empty($sectionData['sectionControls'])) {
                        continue;
                    }

                    $controlCode .= "// {$template->title} -> {$section->title}\n            ";
                    $controlCode .= "'{$section->getFullAlias()}' => array(\n                ";

                    foreach ($sectionData['sectionControls'] as $sectionControlData) {
                        $sectionControl = new SectionControl();
                        $sectionControl->attributes = $sectionControlData;
                        $sectionControl->setSectionAlias($section->getFullAlias());
                        $controlCode .= $sectionControl->getCodeForConfig();

                        $templateCode = $sectionControl->applyDefault($templateCode);

                        if (!empty($sectionControl->style)) {
                            $styleCode .= $sectionControl->getStylesForConfig();
                        }

                        if (!empty($sectionControl->pseudojs)) {
                            $pseudoJsCode .= $sectionControl->getPseudoJsForConfig();
                        }
                    }

                    $controlCode .= "\n            ),\n            ";
                }

                $zip->addFromString(self::DIR_PARTIALS . '/section-' . $template->alias . '.php', $templateCode);
            }

            /** Prepare and add common files */
            $commonFiles = File::find()->common()->all();
            foreach ($commonFiles as $commonFile) {
                /** @var File $commonFile */
                if ($commonFile->filename == File::COMMON_CSS_FILENAME) {
                    $commonFile->code = str_replace('{{name}}', $name, $commonFile->code);
                } elseif ($commonFile->filename == File::HOME_PAGE_FILENAME) {
                    // convert comma separated string into array and trim all elements (explode -> array_map(trim, ...))
                    // remove all empty values and convert array into comma separated string (array_filter -> implode)
                    $sorterCode = 'array(' . implode(', ', array_filter(array_map('trim', explode(',', $sorterDefault)))) . ')';
                    $commonFile->code = str_replace("'" . self::SECTION_SORTER_ID . "'", "'" . self::SECTION_SORTER_ID . "', " . $sorterCode, $commonFile->code);
                } elseif ($commonFile->filename == File::FUNCTIONS_FILENAME) {
                    $addJs = ''; $counter = 1;
                    foreach ($additionalTemplateJs as $jsFileName) {
                        $addJs .= "    wp_enqueue_script('tg-js-{$counter}', get_template_directory_uri() . '/{$jsFileName}');\n";
                        $counter++;
                    }
                    $commonFile->code = str_replace('{{additional_js}}', $addJs, $commonFile->code);
                }
                $zip->addFromString($commonFile->filename, $commonFile->code);
            }

            if (!empty($config)) {
                $configCode = $config->code;
                $search = ['{%panels%}', '{%sections%}', '{%controls%}', '{%styles%}', '{%pseudojs%}',
                    '{%sorter_default%}', '{%sorter_choices%}'];
                $replace = [$panelCode, $sectionCode, $controlCode, $styleCode, $pseudoJsCode,
                    $sorterDefault, $sorterChoices];
                $configCode = str_replace($search, $replace, $configCode);
                $zip->addFromString($config->directory . DIRECTORY_SEPARATOR . $config->filename, $configCode);
            }

            if (!empty($css)) {
                $zip->addFromString($css->directory . DIRECTORY_SEPARATOR . $css->filename, $css->code . $cssCode);
            }
            if (!empty($js) && !empty($jsCode)) {
                $code = str_replace('{%code%}', $jsCode, $js->code);
                $zip->addFromString($js->directory . DIRECTORY_SEPARATOR . $js->filename, $code);
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
        return "
/**************************************************************************/
/* $text */
/**************************************************************************/
";
    }

    public static function getTemplateSourcePath()
    {
        return '@backend/web/' . Yii::$app->params['template']['alias']['templateSource'];
    }
}