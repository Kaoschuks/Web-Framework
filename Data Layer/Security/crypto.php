<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DBManager
 *
 * @author Kaos
 */
 
class Crypto_Mutate {

    public function encrypt($string, $salt, $key, $num, $iv)
    {
        $mutateencrypt = array();
        @ $mutateencrypt[0] = $this->ecbencrypt($this->cbcencrypt($string, $salt, $key), $key, $salt);
        @ $mutateencrypt[1] = $this->cbcencrypt($string, $salt, $key);
        @ $mutateencrypt[2] = $this->ecbencrypt($string, $key, $salt);
        @ $mutateencrypt[3] = $this->blowfisencrypt($string, $key, $iv);
        @ $mutateencrypt[4] = $this->tdesencrypt($string, $key);
        @ $mutateencrypt[5] = $this->ecbencrypt($this->cbcencrypt($this->tdesencrypt($string, $key), $salt, $key), $key, $salt);
        @ $mutateencrypt[6] = $this->blowfisencrypt($this->ecbencrypt($this->cbcencrypt($this->tdesencrypt($string, $key), $salt, $key), $key, $salt), $key, $iv);
        $encrypts = $mutateencrypt[$num];
        return $encrypts;
    }

    public function decrypt($string, $salt, $key, $num, $iv)
    {
        $mutatedecrypt = array();
        @ $mutatedecrypt[0] = $this->cbcdecrypt($this->ecbdecrypt($string, $key, $salt), $salt, $key);
        @ $mutatedecrypt[1] = $this->cbcdecrypt($string, $salt, $key);
        @ $mutatedecrypt[2] = $this->ecbdecrypt($string, $key, $salt);
        @ $mutatedecrypt[3] = $this->blowfisdecrypt($string, $key, $iv);
        @ $mutatedecrypt[4] = $this->tdesdecrypt($string, $key);
        @ $mutatedecrypt[5] = $this->tdesdecrypt($this->cbcdecrypt($this->ecbdecrypt($string, $key, $salt), $salt, $key), $key);
         $mutatedecrypt[6] = $this->tdesdecrypt($this->cbcdecrypt($this->ecbdecrypt($this->blowfisdecrypt($string, $key, $iv), $key, $salt), $salt, $key), $key);
    
        $decrypts = $mutatedecrypt[$num];
        return $decrypts;
    }

    private function tdesencrypt($string, $key) 
    {
        return @ base64_encode(mcrypt_cbc(MCRYPT_TripleDES, $key, $string, MCRYPT_ENCRYPT, "kaoschukskaoschukskaoschuks"));
    }

    private function tdesdecrypt($string, $key) 
    {
        $string = trim(base64_decode($string));
        return mcrypt_cbc (MCRYPT_TripleDES, $key, $string, MCRYPT_DECRYPT, "kaoschukskaoschukskaoschuks");
    }

    private function blowfisencrypt($string, $key, $iv) 
    {
        $enc = @ mcrypt_encrypt(MCRYPT_BLOWFISH, $key, $string, MCRYPT_MODE_CBC, "kaoschukskaoschukskaoschuks");
        return base64_encode($enc);
    }

    private function blowfisdecrypt($string, $key, $iv) {
        $enc = mcrypt_decrypt(MCRYPT_BLOWFISH, $key, base64_decode($string), MCRYPT_MODE_CBC, "kaoschukskaoschukskaoschuks");
        return ($enc);
    }

    private function ecbencrypt($string, $salt, $key)
    {
        return rtrim(base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $string, MCRYPT_MODE_ECB)));
    }

    private function ecbdecrypt($string, $salt, $key)
    {
        return rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, base64_decode($string), MCRYPT_MODE_ECB));
    }

    private function cbcencrypt($string, $salt, $key)
    {
        return @ rtrim(base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $string, MCRYPT_MODE_CBC)));
    }

    private function cbcdecrypt($string, $salt, $key)
    {
        return rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, base64_decode($string), MCRYPT_MODE_CBC));
    }

}

?>