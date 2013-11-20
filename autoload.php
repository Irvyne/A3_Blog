<?php
/**
 * Created by Thibaud BARDIN (Irvyne)
 * This code is under the MIT License (https://github.com/Irvyne/license/blob/master/MIT.md)
 */

spl_autoload_register(function($className){
    $directories = array(
        'Class',
        'Entity',
    );
    foreach ($directories as $directory) {
        $fileName = $className.'.php';
        $path = $directory.'/'.$fileName;
        if (is_file($path)) {
            require $path;
            break;
        }
    }
});