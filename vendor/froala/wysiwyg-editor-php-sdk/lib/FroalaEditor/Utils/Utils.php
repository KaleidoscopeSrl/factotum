<?php

namespace FroalaEditor\Utils;

class Utils {
  /**
   * Check if file is matching the specified allowed extensions and mime types.
   *
   * @param $filename string
   * @param $mimeType string
   * @param $allowedExts Array
   * @param $allowedMimeTypes Array
   *
   * @return boolean
   */
  private static function isFileValid($filename, $mimeType, $allowedExts, $allowedMimeTypes) {
    // Skip if the allowed extensions or mime types are missing.
    if (!$allowedExts || !$allowedMimeTypes) {
      return false;
    }

    // Get extension.
    $extension = end($filename);

    return in_array(strtolower($mimeType), $allowedMimeTypes) && in_array(strtolower($extension), $allowedExts);
  }

  /**
   * Get the mime type of a file.
   *
   * @param $tmpName string
   *
   * @return string
   */
  public static function getMimeType($tmpName) {

    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mimeType = finfo_file($finfo, $tmpName);

    return $mimeType;
  }

  /**
   * Check if a file is valid.
   *
   * @param $validation array or function
   * @param $fieldname string
   *
   * @return boolean
   */
  public static function isValid($validation, $fieldname) {
    // No validation means you dont want to validate, so return affirmative.
    if (!$validation) {
      return true;
    }

    // Get filename.
    $filename = explode(".", $_FILES[$fieldname]["name"]);

    // Validate uploaded files.
    // Do not use $_FILES["file"]["type"] as it can be easily forged.
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mimeType = self::getMimeType($_FILES[$fieldname]["tmp_name"]);

    // Validation is a function provided by the user.
    if ($validation instanceof \Closure) {
        return $validation($_FILES[$fieldname]["tmp_name"], $mimeType);
    }

    if (is_array($validation)) {
      return self::isFileValid($filename, $mimeType, $validation['allowedExts'], $validation['allowedMimeTypes']);
    }

    // Else: no specific validating behaviour found.
    return false;
  }
}

// Define alias.
class_alias('FroalaEditor\Utils\Utils', 'FroalaEditor_Utils');