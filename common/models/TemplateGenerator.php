<?php

namespace common\models;

use Yii;
use yii\helpers\VarDumper;

class TemplateGenerator
{
    public static function create($q)
    {
        $file = tempnam("tmp", uniqid('zip'));
        $zip = new \ZipArchiveEx();
        $zip->open($file, \ZipArchive::OVERWRITE);

        $commonTemplates = Template::find()->innerJoinWith('category')->where(['template_category.is_basic' => 1])->all();

        $selectedIds = explode(',', $q);
        $map = [];
        foreach ($selectedIds as $id) {
            $selectedTemplate = Template::findOne(intval($id));

            if (empty($selectedTemplate))
                continue;

            foreach ($selectedTemplate->parents as $parent) {
                $map[$parent->id][] = $selectedTemplate;
            }
        }

        $files = [];

        foreach ($commonTemplates as $template) {
            $files[$template->filename][$template->directory]['id'] = $template->id;
            $files[$template->filename][$template->directory]['code'] = $template->code;

            $csses = $template->css;
            if (is_array($csses) && count($csses)) {
                foreach ($csses as $css) {
                    if (isset($files[$css->filename][$css->directory])) {
                        $files[$css->filename][$css->directory]['code'] .= "\n" . $css->code;
                    } else {
                        $files[$css->filename][$css->directory]['id'] = $css->id;
                        $files[$css->filename][$css->directory]['code'] = $css->code;
                    }
                }
            }

            $jses = $template->js;
            if (is_array($jses) && count($jses)) {
                foreach ($jses as $js) {
                    if (isset($files[$js->filename][$js->directory])) {
                        $files[$js->filename][$js->directory]['code'] .= "\n" . $js->code;
                    } else {
                        $files[$js->filename][$js->directory]['id'] = $js->id;
                        $files[$js->filename][$js->directory]['code'] = $js->code;
                    }
                }
            }

            $functions = $template->functions;
            if (is_array($functions) && count($functions)) {
                foreach ($functions as $function) {
                    if (isset($files[$function->filename][$function->directory])) {
                        $files[$function->filename][$function->directory]['code'] .= "\n" . $function->code;
                    } else {
                        $files[$function->filename][$function->directory]['id'] = $function->id;
                        $files[$function->filename][$function->directory]['code'] = "\n" . $function->code;
                    }
                }
            }
        }

        foreach ($files as $filename => $fileData) {
            foreach ($fileData as $directory => $fileContent) {
                $path = $directory != '' ? $directory . '/' . $filename : $filename;
                $code = $fileContent['code'];

                if (isset($map[$fileContent['id']])) {
                    foreach ($map[$fileContent['id']] as $child) {
                        $code .= "\n" . $child->code;
                    }
                }

                $zip->addFromString($path, $code);
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
}