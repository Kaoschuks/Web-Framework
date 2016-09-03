<?php

/**
 * DBSecurity short summary.
 * This class secures data been inserted or used in database configuration
 * DBSecurity description.
 *
 * @version 1.0
 * @author Kaos
 * Encrypt value to a cryptojs compatiable json encoding string
 *
 * @param mixed $passphrase
 * @param mixed $value
 * @return string
 */

if(!is_file('Service Layer/Cache/Logger.php' || "header.php"))
{
    require_once 'Service Layer/Cache/Logger.php';
    require_once 'header.php';
}

class CSecurity implements Idbsec
{
    public function Protect($string, $phrase)
    {
        return $this->cryptoJsAesEncrypt($phrase, $string);
    }

    public function Unprotect($string, $phrase)
    {
        return $this->cryptoJsAesDecrypt($phrase, $string);
    }
    
    public function cryptoJsAesDecrypt($passphrase, $jsonString)
    {
        $jsondata = json_decode($jsonString, true);
        try {
            $salt = hex2bin($jsondata["s"]);
            $iv  = hex2bin($jsondata["iv"]);
            
        } catch(Exception $e) { return null; }
            $ct = base64_decode($jsondata["ct"]);
            $concatedPassphrase = $passphrase.$salt;
            $md5 = array();
            $md5[0] = md5($concatedPassphrase, true);
            $result = $md5[0];
            for ($i = 1; $i < 3; $i++) {
                $md5[$i] = md5($md5[$i - 1].$concatedPassphrase, true);
                $result .= $md5[$i];
        }
        $key = substr($result, 0, 32);
        $data = openssl_decrypt($ct, 'aes-256-cbc', $key, true, $iv);
        return json_decode($data, true);
    }
    
    private function cryptoJsAesEncrypt($passphrase, $value)
    {
        $salt = openssl_random_pseudo_bytes(8);
        $salted = '';
        $dx = '';
        while (strlen($salted) < 48) {
            $dx = md5($dx.$passphrase.$salt, true);
            $salted .= $dx;
        }
        $key = substr($salted, 0, 32);
        $iv  = substr($salted, 32,16);
        $encrypted_data = openssl_encrypt(json_encode($value), 'aes-256-cbc', $key, true, $iv);
        $data = array("ct" => base64_encode($encrypted_data), "iv" => bin2hex($iv), "s" => bin2hex($salt));
        return json_encode($data);
    }
    
}

function generate_capcath()
{
    session_start();
    $code = rand(1000,9999);
    $_SESSION["code"] = $code;
    $im = imagecreatetruecolor(50, 24);
    $bg = imagecolorallocate($im, 22, 86, 165); //background color blue
    $fg = imagecolorallocate($im, 255, 255, 255);//text color white
    imagefill($im, 0, 0, $bg);
    imagestring($im, 5, 5, 5,  $code, $fg);
    header("Cache-Control: no-cache, must-revalidate");
    header('Content-type: image/png');
    imagepng($im);
    imagedestroy($im);
}