<?php
/**
 * Idbsec short summary.
 *
 * Idbsec description.
 *
 * @version 1.0
 * @author Kaos
 */
interface ICrypt
{
    public function Encrypt($message, $key);

    public function Decrypt($message, $key);
}
?>