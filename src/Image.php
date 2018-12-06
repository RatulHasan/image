<?php
/**
 * Laravel Image is an image manipulation package for Laravel.
 * It supports basic image manipulations such as resize, watermark.
 *
 * @author Ratul Hasan <ratuljh@gmail.com>
 * @url https://www.ratulhasan.me
 */

namespace RatulHasan\Image;

/**
 * Class Image
 * @package RatulHasan\Image
 */

class Image
{
    /**
     * @param $src
     * @param $ext
     * @param $destination
     * @param bool $desired_width
     * @param bool $desired_height
     * @return array|bool
     */
    public static function createThumb($image_file, $destination, $desired_width = false, $desired_height = false)
    {

        // If optional arguments are not defined
        $data = getimagesize($image_file);
        if (!$desired_width) {
            $desired_width = $data[0];
        }
        if (!$desired_height) {
            $desired_height = $data[1];
        }
//        Get image extension from file
        $ext = image_type_to_extension($data[2]);

        /*If no dimenstion for thumbnail given, return false */
        if (!$desired_height && !$desired_width) return false;
//        $fparts = pathinfo($src);
//        $ext = strtolower($fparts['extension']);
        /* if its not an image return false */
        if (!in_array($ext, array('gif', 'jpg', 'png', 'jpeg'))) {
            if (!in_array($ext, array('.gif', '.jpg', '.png', '.jpeg'))) {
                return false;
            }
        }

        /* read the source image */
        if ($ext == 'gif' || $ext == '.gif')
            $resource = imagecreatefromgif($image_file);
        else if ($ext == 'png' || $ext == '.png')
            $resource = imagecreatefrompng($image_file);
        else if ($ext == 'jpg' || $ext == 'jpeg' || $ext == '.jpg' || $ext == '.jpeg')
            $resource = imagecreatefromjpeg($image_file);
        else
            return false;

        list($width, $height, $type, $attr) = getimagesize($image_file);

        /* find the "desired height" or "desired width" of this thumbnail, relative to each other, if one of them is not given  */
        if (!$desired_height) $desired_height = floor($height * ($desired_width / $width));
        if (!$desired_width) $desired_width = floor($width * ($desired_height / $height));

        /* create a new, "virtual" image */
        $virtual_image = imagecreatetruecolor($desired_width, $desired_height);

        /* copy source image at a resized size */
        imagecopyresized($virtual_image, $resource, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);

        /* create the physical thumbnail image to its destination */
        /* Use correct function based on the desired image type from $destination thumbnail source */
        $fparts = pathinfo($destination);
        $ext = strtolower($fparts['extension']);
        /* if dest is not an image type, default to jpg */
//        if (!in_array($ext, array('gif', 'jpg', 'png', 'jpeg'))) $ext = 'jpg';
//        $destination = $fparts['dirname'] . '/' . $fparts['filename'] . '.' . $ext;

        if ($ext == 'gif' || $ext == '.gif')
            imagegif($virtual_image, $destination);
        else if ($ext == 'png' || $ext == '.png')
            imagepng($virtual_image, $destination, 1);
        else if ($ext == 'jpg' || $ext == 'jpeg' || $ext == '.jpg' || $ext == '.jpeg')
            imagejpeg($virtual_image, $destination, 100);
        else
            return false;

        return array(
            'width' => $width,
            'height' => $height,
            'new_width' => $desired_width,
            'new_height' => $desired_height,
            'dest' => $destination
        );
    }

    /**
     * @param $target
     * @param $watermark_file
     * @param $position
     */
    public static function watermark($target, $watermark_file, $position = false)
    {
        $watermark = imagecreatefrompng($watermark_file);
        imagealphablending($watermark, false);
        imagesavealpha($watermark, true);
        $img = imagecreatefromstring(file_get_contents($target));
//        $img = imagecreatefromjpeg($target);
        $img_width = imagesx($img);
        $img_height = imagesy($img);
        $watermark_file_width = imagesx($watermark);
        $watermark_file_height = imagesy($watermark);

//        For right-corner watermark
        $dst_x = ($img_width) - ($watermark_file_width);
        $dst_y = ($img_height) - ($watermark_file_height);

//        For bottom-middle watermark
//        $dst_x = ($img_width/2) - ($watermark_file_width/2);
//        $dst_y = ($img_height) - ($watermark_file_height);

//        For right-middle watermark
//        $dst_x = ($img_width) - ($watermark_file_width);
//        $dst_y = ($img_height/2) - ($watermark_file_height/2);


//        For middle watermark
//        $dst_x = ($img_width/2) - ($watermark_file_width);
//        $dst_y = ($img_height/2) - ($watermark_file_height/2);


        imagecopy($img, $watermark, $dst_x, $dst_y, 0, 0, $watermark_file_width, $watermark_file_height);
        imagejpeg($img, $target, 100);
        imagedestroy($img);
        imagedestroy($watermark);
    }
}