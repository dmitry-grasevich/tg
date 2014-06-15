<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\VarDumper;

class TemplateGenerator
{
    public static function create($q)
    {
        $data = [
            'templates' => [],  // included templates
            'css' => [],        // css code to add to style.css or css files
            'js' => [],         // js
            'images' => [],     // images files
            'fonts' => [],      // fonts files
            'functions' => [],  // code to add to functions.php
        ];

        $commonTemplates = Template::find()->innerJoinWith('category')
            ->where(['template_category.is_basic' => 1])->all();

        foreach ($commonTemplates as $template) {
            self::prepareData($template, $data);
        }

        $selectedIds = explode(',', $q);
        foreach ($selectedIds as $id) {
            $selectedTemplate = Template::findOne(intval($id));
            self::prepareData($selectedTemplate, $data);
        }

        self::createZip($data);
    }

    public static function prepareData($template, &$data)
    {
        if (empty($template)) return;

        if (count($template->parents)) {
            foreach ($template->parents as $parent) {
                if (!isset($data['templates'][$parent->id][$template->id])) {
                    $data['templates'][$parent->id][$template->id] = $template;
                }
            }
        } else {
            if (!isset($data['templates']['file'][$template->id])) {
                $data['templates']['file'][$template->id] = $template; // single file
            }
        }
        if (count($template->css)) {
            foreach ($template->css as $css) {
                if (!empty($css->parent)) {
                    if (!isset($data['css'][$css->parent->id][$css->id])) {
                        $data['css'][$css->parent->id][$css->id] = $css;
                    }
                } else {
                    if (!isset($data['css']['file'][$css->id])) {
                        $data['css']['file'][$css->id] = $css;
                    }
                }
            }
        }
        if (count($template->js)) {
            foreach ($template->js as $js) {
                if (!isset($data['js'][$js->id])) {
                    $data['js'][$js->id] = $js;
                }
            }
        }
        if (count($template->images)) {
            foreach ($template->images as $image) {
                if (!isset($data['images'][$image->id])) {
                    $data['images'][$image->id] = $image;
                }
            }
        }
        if (count($template->fonts)) {
            foreach ($template->fonts as $font) {
                if (!isset($data['fonts'][$font->id])) {
                    $data['fonts'][$font->id] = $font;
                }
            }
        }
        if (count($template->functions)) {
            foreach ($template->functions as $function) {
                if (!empty($function->parent)) {
                    if (!isset($data['functions'][$function->parent->id][$function->id])) {
                        $data['functions'][$function->parent->id][$function->id] = $function;
                    }
                } else {
                    if (!isset($data['functions']['file'][$function->id])) {
                        $data['functions']['file'][$function->id] = $function;
                    }
                }
            }
        }
    }

    public static function createZip($data)
    {
        $file = tempnam("tmp", uniqid('zip'));
        $zip = new \ZipArchiveEx();
        $zip->open($file, \ZipArchive::OVERWRITE);
        $zip->addEmptyDir('images');
        $zip->addEmptyDir('fonts');

        if (count($data['css'])) { // add css
            foreach ($data['css'] as $parentId => $csses) {
                if ($parentId == 'file') {
                    foreach ($csses as $id => $css) {
                        $path = $css->directory != '' ? $css->directory . '/' . $css->filename : $css->filename;
                        $zip->addFromString($path, $css->code);
                    }
                } else {
                    if (!isset($data['templates']['file'][$parentId])) continue;
                    foreach ($csses as $id => $css) {
                        $parent = $data['templates']['file'][$parentId];
                        $parent->code .=  "\n" .  $css->code;
                    }
                }
            }
        }

        if (count($data['functions'])) { // add functions
            foreach ($data['functions'] as $parentId => $functions) {
                if (!isset($data['templates']['file'][$parentId])) continue;
                foreach ($functions as $id => $function) {
                    $parent = $data['templates']['file'][$parentId];
                    if ($parent->filename == 'footer.php') {
                        $parent->code = $function->code . "\n" . $parent->code;
                    } else {
                        $parent->code .=  "\n" .  $function->code;
                    }
                }
            }
        }

        foreach ($data['templates'] as $parentId => $templates) {
            if ($parentId == 'file' || !isset($data['templates']['file'][$parentId])) continue;

            foreach ($templates as $id => $template) {
                $parent = $data['templates']['file'][$parentId];
                $parent->code .=  "\n" .  $template->code;
            }
        }

        foreach ($data['templates']['file'] as $id => $template) {
            $path = $template->directory != '' ? $template->directory . '/' . $template->filename : $template->filename;
            $zip->addFromString($path, $template->code);
        }

        if (count($data['images'])) { // add images to zip
            foreach ($data['images'] as $id => $image) {
                $path = $image->directory != '' ? $image->directory . '/' . $image->filename : $image->filename;
                $zipPath = self::getTemplateImagesPath() . '/' . $path;
                $zip->addFile(Yii::getAlias(self::getImagesPath() . '/' . $path), $zipPath);
            }
        }

        if (count($data['fonts'])) { // add fonts to zip
            foreach ($data['fonts'] as $id => $font) {
                $path = $font->directory != '' ? $font->directory . '/' . $font->filename : $font->filename;
                $zipPath = self::getTemplateFontsPath() . '/' . $path;
                $zip->addFile(Yii::getAlias(self::getFontsPath() . '/' . $path), $zipPath);
            }
        }

        // TODO: add js

        // Close and send to users
        $zip->close();
        header('Content-Type: application/zip');
        header('Content-Length: ' . filesize($file));
        header('Content-Disposition: attachment; filename="template.zip"');
        readfile($file);
        unlink($file);
    }

    public static function getImagesPath()
    {
        return '@backend/web' . Yii::$app->params['template']['alias']['images'];
    }

    public static function getTemplateImagesPath()
    {
        return 'images';
    }

    public static function getFontsPath()
    {
        return '@backend/web' . Yii::$app->params['template']['alias']['fonts'];
    }

    public static function getTemplateFontsPath()
    {
        return 'fonts';
    }
}