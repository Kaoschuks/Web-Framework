<?php

/**
 * IRoute short summary.
 *
 * IRoute description.
 *
 * @version 1.0
 * @author Kaos
 */
if(!is_file("Business Layer/Auth/Auth_Control.php" || "Business Layer/Controls/Blog.php" || "Business Layer/Controls/Users.php" || "Business Layer/Controls/Feed.php" || "Business Layer/Controls/File.php" || "Business Layer/Controls/Shares.php"))
{
    require_once "Business Layer/Auth/Auth_Control.php";
    require_once "Business Layer/Controls/Blog.php";
    require_once "Business Layer/Controls/Users.php";
    require_once "Business Layer/Controls/Feed.php";
    require_once "Business Layer/Controls/File.php";
    require_once "Business Layer/Controls/Shares.php";
}

interface IFunctionality
{
    public function Get_Control($data);
}
