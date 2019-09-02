<?php

namespace FroalaEditor;

use FroalaEditor\Utils\DiskManagement;

class File {
  public static $defaultUploadOptions = array(
    'fieldname' => 'file',
    'validation' => array(
      'allowedExts' => array('txt', 'pdf', 'doc'),
      'allowedMimeTypes' => array('text/plain', 'application/msword', 'application/x-pdf', 'application/pdf')
    )
  );

  /**
  * File upload to disk.
  *
  * @param fileRoute string
  * @param options [optional]
  *   (
  *     fieldname => string
  *     validation => array OR function
  *   )
  * @return {link: 'linkPath'} or error string
  */
  public static function upload($fileRoute, $options = NULL) {

    if (is_null($options)) {
      $options = File::$defaultUploadOptions;
    } else {
      $options = array_merge(File::$defaultUploadOptions, $options);
    }

    return DiskManagement::upload($fileRoute, $options);
  }

  /**
  * Delete file from disk.
  *
  * @param src string
  * @return boolean
  */
  public static function delete($src) {

    return DiskManagement::delete($src);
  }
}

class_alias('FroalaEditor\File', 'FroalaEditor_File');
?>