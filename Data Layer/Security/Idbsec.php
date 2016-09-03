<?php

/**
 * Idbsec short summary.
 *
 * Idbsec description.
 *
 * @version 1.0
 * @author Kaos
 */

if(!is_file("Cryptography/Crypt.php"))
{
    require_once "Cryptography/Crypt.php";
}

interface Idbsec
{
    public function Protect($string, $num);

    public function Unprotect($string, $num);
}

interface ClientSec
{
    public function Protect($string, $phrase);

    public function Unprotect($string, $phrase);
}
