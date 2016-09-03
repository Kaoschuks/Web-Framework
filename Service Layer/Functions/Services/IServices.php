<?php

if(!is_file("Service Layer/Functions/Email_Generator.php" || "Service Layer/Cache/Cache.php" || "Service Layer/Security/Csf.php"))
{
    require_once 'Service Layer/Functions/Email_Generator.php';
    require_once 'Service Layer/Cache/Cache.php';
    require_once 'Service Layer/Security/Csf.php';
}

interface IServices
{
    public function Control($type, $info);
}