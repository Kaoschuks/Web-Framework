<?php

/**
 * IPresentation short summary.
 *
 * IPresentation description.
 *
 * @version 1.0
 * @author Kaos
 */
if(is_file("Presentation Layer/Interface/Routing/Route.php"))
{
    require_once 'Presentation Layer/Interface/Routing/Route.php';
}

interface IPages
{
    public function ui();
}

interface IModules
{
    public function gen_ui($data);
}

function getImage($filename) {
    if (!file_exists($filename)) {
        return FALSE;
    }
    # Gets file extension
    $arr = explode('.', $filename);
    $extension = strtolower($arr[count($arr) - 1]);

    # Gets file modification time
    clearstatcache();
    $time = filemtime($filename);

    $position = strripos($filename, '.'.$extension);

    return sprintf('%s-%s.%s', substr($filename, 0, $position), $time, $extension);
}
