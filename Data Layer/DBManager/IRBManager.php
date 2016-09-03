<?php
require_once 'Entities/Entities.php';
require_once "Data Layer/Security/DBSecurity.php";  
/**
 * IRBManager short summary.
 *
 * IRBManager description.
 *
 * @version 1.0
 * @author Cipher
 */
interface IRBManager
{
    public function Connect($db, $db_user, $db_pass);
    public function Query_Type($type, $data_ar, $con);
}
