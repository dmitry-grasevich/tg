<?php

namespace common\helpers;

class ZipArchiveTg extends \ZipArchive
{
    public function addDir($dirname, $startdir)
    {
        return $this->recursiveAddDir($dirname, null, $startdir);
    }

    private function recursiveAddDir($dirname, $basedir = null, $startdir = null, $adddir = true)
    {
        $rc = false;

        # If $dirname is a directory
        if (is_dir($dirname)) {

            # Save current working directory
            $working_directory = getcwd();

            # Switch to passed directory
            chdir($dirname);

            # Get basename of passed directory
            $basename = $basedir . basename($dirname);

            if ($startdir) {
                $this->addEmptyDir($startdir);
                $basename = $startdir . '/' . $basename;
            }

            # Add empty directory with the name of the passed directory
            if ($adddir) {
                $rc = $this->addEmptyDir($basename);
                $basename = $basename . '/';
            } else {
                $basename = null;
            }

            # Get all files in the directory
            $files = glob('*');

            # Loop through files
            foreach ($files as $f) {
                # If file is directory
                if (is_dir($f)) {
                    # Call recursiveAdd
                    $this->recursiveAddDir($f, $basename);
                } else {
                    $rc = $this->addFile($f, $basename . $f);
                }
            }

            # Switch back to current working directory
            chdir($working_directory);

            $rc = true;
        }

        return $rc;
    }
}