<?php

namespace common\models;

use Yii;

class TemplateGenerator
{
    public static function create()
    {
        $file = tempnam("tmp", uniqid('zip'));
        $zip = new \ZipArchiveEx();
        $zip->open($file, \ZipArchive::OVERWRITE);

        $templates = Template::find()->all();
        foreach ($templates as $template) {
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