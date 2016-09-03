<?php

/**
 * IRoute short summary.
 *
 * IRoute description.
 *
 * @version 1.0
 * @author Kaos
 */
if(is_file('Entities/Entities.php'))
{
    require_once 'Entities/Entities.php';
}

interface IRoute
{
    public function Create_Route();
    public function submit();
}
