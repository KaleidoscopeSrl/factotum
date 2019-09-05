<?php

namespace FroalaEditor;

use FroalaEditor\Utils\DiskManagement;

class Image {
  public static $defaultUploadOptions = array(
    'fieldname' => 'file',
    'validation' => array(
      'allowedExts' => array('gif', 'jpeg', 'jpg', 'png', 'svg', 'blob'),
      'allowedMimeTypes' => array('image/gif', 'image/jpeg', 'image/pjpeg', 'image/x-png', 'image/png', 'image/svg+xml')
    ),
    'resize' => NULL
  );

  /**
  * Image upload to disk.
  *
  * @param fileRoute string
  * @param options [optional]
  *   (
  *     fieldname => string
  *     validation => array OR function
  *     resize: => array
  *   )
  * @return {link: 'linkPath'} or error string
  */
  public static function upload($fileRoute, $options = NULL) {
    // Check if there are any options passed.
    if (is_null($options)) {
      $options = Image::$defaultUploadOptions;
    } else {
      $options = array_merge(Image::$defaultUploadOptions, $options);
    }

    // Upload image.
    return DiskManagement::upload($fileRoute, $options);
  }

  /**
  * Delete image from disk.
  *
  * @param src string
  * @return boolean
  */
  public static function delete($src) {
    // Delete image.
    return DiskManagement::delete($src);
  }

  /**
  * List images from disk
  *
  * @param folderPath string
  *
  * @return array of image properties
  *     - on success : [{url: 'url', thumb: 'thumb', name: 'name'}, ...]
  *     - on error   : {error: 'error message'}
  */
  public static function getList($folderPath, $thumbPath = null) {

    if (empty($thumbPath)) {
      $thumbPath = $folderPath;
    }

    // Array of image objects to return.
    $response = array();

    $absoluteFolderPath = $_SERVER['DOCUMENT_ROOT'] . $folderPath;

    // Image types.
    $image_types = Image::$defaultUploadOptions['validation']['allowedMimeTypes'];

    // Filenames in the uploads folder.
    $fnames = scandir($absoluteFolderPath);

    // Check if folder exists.
    if ($fnames) {
      // Go through all the filenames in the folder.
      foreach ($fnames as $name) {
        // Filename must not be a folder.
        if (!is_dir($name)) {
          // Check if file is an image.

          if (in_array(mime_content_type($absoluteFolderPath . $name), $image_types)) {
            // Build the image.
            $img = new \StdClass;
            $img->url = $folderPath . $name;
            $img->thumb = $thumbPath . $name;
            $img->name = $name;

            // Add to the array of image.
            array_push($response, $img);
          }
        }
      }
    }

    // Folder does not exist, respond with a JSON to throw error.
    else {
      throw new Exception('Images folder does not exist!');
    }

    return $response;
  }
}

class_alias('FroalaEditor\Image', 'FroalaEditor_Image');
?>
