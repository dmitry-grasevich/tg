<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\VarDumper;

class TemplateGenerator
{
    public static function create($q)
    {
        $file = tempnam("tmp", uniqid('zip'));
        $zip = new \ZipArchiveEx();
        $zip->open($file, \ZipArchive::OVERWRITE);
        $zip->addEmptyDir('images');
        $zip->addEmptyDir('fonts');

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

        VarDumper::dump($data, 4, true); die();

//        foreach ($data as $type => $entites) {
//
//        }

        $files = [];

        foreach ($files as $filename => $fileData) {
            foreach ($fileData as $directory => $fileContent) {
                $path = $directory != '' ? $directory . '/' . $filename : $filename;

                if (isset($fileContent['image'])) { // Add image to archive
                    $zipPath = self::getTemplateImagesPath() . '/' . $path;
                    $zip->addFile(Yii::getAlias(self::getImagesPath() . '/' . $path), $zipPath);
                } elseif (isset($fileContent['font'])) { // Add font to archive
                    $zipPath = self::getTemplateFontsPath() . '/' . $path;
                    $zip->addFile(Yii::getAlias(self::getFontsPath() . '/' . $path), $zipPath);
                } else {
                    $code = $fileContent['code']; // common code
                    if (isset($map[$fileContent['id']])) { // children files
                        foreach ($map[$fileContent['id']] as $child) {
                            if ($filename == 'footer.php') { // Add code to the footer - child code should be before common code
                                $code = $child->code . "\n" . $code;
                            } else {
                                $code .= "\n" . $child->code;
                            }

                            /** Linked images **/
                            $images = $child->images; // children can see images
                            if (is_array($images) && count($images)) {
                                foreach ($images as $image) {
                                    $p = $image->directory != '' ? $image->directory . '/' . $image->filename : $image->filename;
                                    $zipPath = self::getTemplateImagesPath() . '/' . $p;
                                    $zip->addFile(Yii::getAlias(self::getImagesPath() . '/' . $p), $zipPath);
                                }
                            }
                            /** Linked fonts **/
                            $fonts = $child->images; // children can see fonts
                            if (is_array($fonts) && count($fonts)) {
                                foreach ($fonts as $font) {
                                    $p = $font->directory != '' ? $font->directory . '/' . $font->filename : $font->filename;
                                    $zipPath = self::getTemplateFontsPath() . '/' . $p;
                                    $zip->addFile(Yii::getAlias(self::getFontsPath()  . '/' . $p), $zipPath);
                                }
                            }
                            /** Functions **/

                        }
                    }
                    $zip->addFromString($path, $code);
                }
            }
        }

        // Close and send to users
        $zip->close();
        header('Content-Type: application/zip');
        header('Content-Length: ' . filesize($file));
        header('Content-Disposition: attachment; filename="template.zip"');
        readfile($file);
        unlink($file);
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
                if (!isset($data['css'][$css->id])) {
                    $data['css'][$css->id] = $css;
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
                if (!isset($data['functions'][$function->id])) {
                    $data['functions'][$function->id] = $function;
                }
            }
        }
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