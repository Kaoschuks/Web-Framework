<?php

/**
 * IRoute short summary.
 *
 * IRoute description.
 *
 * @version 1.0
 * @author Kaos
 */
if(is_file("Data Layer/Data.php"))
{
    require_once "Data Layer/Data.php";
}

interface IControl
{
    public function Get_Control($control, $data);
}