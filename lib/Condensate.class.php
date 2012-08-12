<?php

/**
 * Register the Condensate autoloader
 */
spl_autoload_register(array('Condensate', 'autoload'));

/**
 * Condensate Library to be used with Slim
 * @see http://www.slimframework.com
 */
class Condensate {

    /**
     * Condensate autoloader
     *
     * Class files must exist in the same directory as this file and be named
     * the same as its class definition (!case sensitive).
     *
     * @return void
     */
    public static function autoload( $class ) {
        $file = __DIR__ . DIRECTORY_SEPARATOR . str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.class.php';
        if ( file_exists($file) ) {
            require $file;
        }
    }

    public static function upload( $form_file_data, $dir ) {

        if($form_file_data['error'] !== 0)
        {
            throw new Exception(sprintf('File upload failed (error:%d)', $form_file_data['error']));
        }

        $dir = rtrim($dir, '\\/') . DIRECTORY_SEPARATOR;
        Resource::path($dir);

        $tmp_dir = $dir . 'tmp' . DIRECTORY_SEPARATOR;

        if(!file_exists($tmp_dir)) { mkdir($tmp_dir); }
        if(!is_dir($tmp_dir)) { throw new Exception(sprintf('%s is not a valid directory',$tmp_dir)); }

        $file_path = $tmp_dir . basename($form_file_data['name']);
        if(!move_uploaded_file($form_file_data['tmp_name'], $file_path)) {
            throw new Exception(sprintf('File upload failed (moving tmp file)'));
        }

        return Resource::newResource($file_path);
    }

}