<?php
/**
 * Class ImageTg
 * @package common\helpers
 */

namespace common\helpers;

use yii\imagine\Image;
use Imagine\Image\Point;

class ImageTg
{
    /**
     * Creates thumbnail keeping aspect ratio
     *
     * @param string $source
     * @param string $destination
     * @param integer $width
     * @param integer $height
     * @param array $options
     * @param bool $widen
     *
     * @return \Imagine\Image\ManipulatorInterface
     */
    public static function thumbnail($source, $destination, $width, $height, array $options = array(), $widen = true)
    {
        $imagine = Image::getImagine();
        $image = $imagine->open($source);
        if ($widen) {
            $image->resize($image->getSize()->widen($width));
        } else {
            $image->resize($image->getSize()->heighten($height));
        }
        return $image->save($destination, $options);
    }
}