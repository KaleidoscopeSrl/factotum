<?php
/**
 * Created by PhpStorm.
 * User: filippo
 * Date: 05/09/2019
 * Time: 12:34
 */

Route::options('{uri?}', 'Controller@optionsRequest')->where('uri', '.*');