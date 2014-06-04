<?php

namespace common\models;

use Yii;

class TemplateGenerator
{
    public static function create($q)
    {
        $file = tempnam("tmp", uniqid('zip'));
        $zip = new \ZipArchiveEx();
        $zip->open($file, \ZipArchive::OVERWRITE);

        xdebug_var_dump($q);
        $commonTemplates = Template::find()->innerJoinWith('category')->where(['template_category.is_basic' => 1])->all();
        foreach ($commonTemplates as $template) {
            xdebug_var_dump($template->name);
            /*
            $path = $template->directory != '' ? $template->directory . '/' . $template->filename : $template->filename;
            $zip->addFromString($path, $template->code);

            $csses = $template->csses;
            if (is_array($csses) && count($csses)) {
                foreach ($csses as $css) {
                    $path = $css->directory != '' ? $css->directory . '/' . $css->filename : $css->filename;
                    $zip->addFromString($path, $css->code);
                }
            }

            $jses = $template->jses;
            if (is_array($jses) && count($jses)) {
                foreach ($jses as $js) {
                    $path = $js->directory != '' ? $js->directory . '/' . $js->filename : $js->filename;
                    $zip->addFromString($path, $js->code);
                }
            }
            */
        }
return;
        // Close and send to users
        $zip->close();
        header('Content-Type: application/zip');
        header('Content-Length: ' . filesize($file));
        header('Content-Disposition: attachment; filename="template.zip"');
        readfile($file);
        unlink($file);
    }
}