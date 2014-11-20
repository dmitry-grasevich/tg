<?php

namespace common\models;

use common\helpers\ZipArchiveTg;
use Yii;
use yii\helpers\VarDumper;

class TemplateGenerator
{
    /**
     * @param $q - query
     */
    public static function create($q)
    {
        $data = [
            'templates' => [],  // included templates
            'css' => [],        // css code to add to style.css or css files
            'js' => [],         // js
            'images' => [],     // images files
            'fonts' => [],      // fonts files
            'functions' => [],  // code to add to functions.php
            'plugins' => [],    // plugins directories with files
        ];

        $commonTemplates = Template::find()->innerJoinWith('category')
            ->where(['category.is_basic' => 1])->all();

        /** 1. Select common templates */
        /** @var Template[] $commonTemplates */
        foreach ($commonTemplates as $template) {
            /** 2. Processing each common template */
            self::prepareData($template, $data);
        }

        $selectedIds = explode(',', $q['blocks']);
        /** 3. Processing all selected entity for WP template */
        foreach ($selectedIds as $id) {
            $selectedTemplate = Template::findOne(intval($id));
            self::prepareData($selectedTemplate, $data);
        }

        /** 4. Create ZIP from the prepared data */
        self::createZip($data, $q['name']);
    }

    /**
     * @param Template $template
     * @param array $data
     */
    public static function prepareData($template, &$data)
    {
        if (empty($template)) return;

        if (count($template->parents)) {
            /** If template has parent then it is a part of this template */
            /** 1. Collect all templates as parent -> children */
            foreach ($template->parents as $parent) {
                if (!isset($data['templates'][$parent->id][$template->id])) {
                    $data['templates'][$parent->id][$template->id] = $template;
                }
            }
        } else {
            /** Otherwise this is single file */
            if (!isset($data['templates']['file'][$template->id])) {
                $data['templates']['file'][$template->id] = $template; // single file
            }
        }
        if (count($template->css)) {
            foreach ($template->css as $css) {
                if (!empty($css->parent)) {
                    /** If css has parent then it is a part of this css file */
                    /** 2. Collect all css as parent -> children */
                    if (!isset($data['css'][$css->parent->id][$css->id])) {
                        $data['css'][$css->parent->id][$css->id] = $css;
                    }
                } else {
                    /** Otherwise this is single file */
                    if (!isset($data['css']['file'][$css->id])) {
                        $data['css']['file'][$css->id] = $css;
                    }
                }
            }
        }
        if (count($template->js)) {
            foreach ($template->js as $js) {
                /** 3. Each js it's a single file */
                if (!isset($data['js'][$js->id])) {
                    $data['js'][$js->id] = $js;
                }
            }
        }
        if (count($template->images)) {
            foreach ($template->images as $image) {
                /** 4. Each image it's a single file */
                if (!isset($data['images'][$image->id])) {
                    $data['images'][$image->id] = $image;
                }
            }
        }
        if (count($template->fonts)) {
            foreach ($template->fonts as $font) {
                /** 5. Each font it's a single file */
                if (!isset($data['fonts'][$font->id])) {
                    $data['fonts'][$font->id] = $font;
                }
            }
        }
        if (count($template->plugins)) {
            foreach ($template->plugins as $plugin) {
                /** 6. Collect plugins */
                if (!isset($data['plugins'][$plugin->id])) {
                    $data['plugins'][$plugin->id] = $plugin;
                }
            }
        }
        if (count($template->functions)) {
            foreach ($template->functions as $function) {
                if (!empty($function->parent)) {
                    /** If function has parent then it is a part of this function */
                    /** 7. Collect all functions as parent -> children */
                    if (!isset($data['functions'][$function->parent->id][$function->id])) {
                        $data['functions'][$function->parent->id][$function->id] = $function;
                    }
                } else {
                    /** Otherwise this is single file */
                    if (!isset($data['functions']['file'][$function->id])) {
                        $data['functions']['file'][$function->id] = $function;
                    }
                }
            }
        }
        if (count($template->elements)) {
            $block = [
                'title' => $template->name,
                'id' => 'tg_template_' . md5($template->name),
            ];
            foreach ($template->elements as $element) {
                $block['elements'][] = $element;
            }
            $data['customize'][] = $block;
        }
    }

    /**
     * @param array $data
     * @param string $templateName
     */
    public static function createZip($data, $templateName)
    {
        var_dump($data['customize']); exit;
        $file = tempnam("tmp", uniqid('zip'));
        $zip = new ZipArchiveTg();
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
            if ($template->filename == 'style.css') {
                $template->code = str_replace('Theme Name: Template Generator', "Theme Name: $templateName by Template Generator", $template->code);
            }
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

        if (count($data['plugins'])) { // add plugins to zip
            foreach ($data['plugins'] as $id => $plugin) {
                $zip->addDir(Yii::getAlias(self::getPluginsPath() . '/' . $plugin->directory), self::getTemplatePluginsPath());
            }
        }

        /** Add customizer */
        $zip->addDir(Yii::getAlias(self::getIncPath()), self::getTemplateIncPath());

        // TODO: add js

        // Close and send to users
        $zip->close();
        header('Set-Cookie: fileDownload=true; path=/');
        header('Cache-Control: max-age=60, must-revalidate');
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

    public static function getPluginsPath()
    {
        return '@backend/web' . Yii::$app->params['template']['alias']['plugins'];
    }

    public static function getTemplatePluginsPath()
    {
        return 'plugins';
    }

    public static function getIncPath()
    {
        return '@backend/web' . Yii::$app->params['template']['alias']['inc'];
    }

    public static function getTemplateIncPath()
    {
        return '';
    }
}