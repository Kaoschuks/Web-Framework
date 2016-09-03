<?php

/**
 * IDMining short summary.
 *
 * IDMining description.
 *
 * @version 1.0
 * @author Kaos
 */

if(!is_file("Data Layer/Security/DBSecurity.php" || "Data Layer/DBManager/RBManager.php" || "Data Layer/DBManager/FDManager.php" || "Data Layer/File_Manager/File_Uploads.php"))
{
    require_once "Data Layer/DBManager/RBManager.php";
    require_once "Data Layer/File_Manager/File_Uploads.php";
    require_once "Data Layer/File_Manager/File_Manager.php";
    require_once "Data Layer/DBManager/FDManager.php";
    require_once "Data Layer/Security/DBSecurity.php";
}


interface IDMining
{
    public function Process_Data($data, $type);
}
