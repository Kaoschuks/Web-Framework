<?php
/**
 * DBSecurity short summary.
 * This class secures data been inserted or used in database configuration
 * DBSecurity description.
 *
 * @version 1.0
 * @author Kaos
 */

if(!is_file("crypto.php" && "Idbsec.php"))
{
    require_once "crypto.php";
    require_once "Idbsec.php";
}

class DBSecurity implements Idbsec
{
    private $salt1 = "@@#CTYhYVTGGHghgH%%^^&7BBBNb**%^&6%";
    private $salt2 = "@$&())+KJKJHF^hj23m4mdudh88*&*8&^***";
    private $key1 = "@@#CT^&7BBBNb**%^&6%YhYVT^&7BBBNb**%^&6%GGHghgH%%^";
    private $key2 = "@$&())+KJKJ^&7BBBNb**%^&6%HF^hj23m4mdudh88*&*8&^***";
    private $response;

    public function Protect($string, $num)
    {
        $Crypto = new Crypto_Mutate();
        return $Crypto->encrypt($this->mysql_protect($string), $this->salt($this->salt1, $this->salt2), $this->keys($this->key1, $this->key2), $num, $this->iv($this->key1.$this->salt1));
        unset($Crypto);
    }

    public function Unprotect($string, $num)
    {
        $Crypto = new Crypto_Mutate;
        return $Crypto->decrypt(trim(strip_tags(addslashes($string))), $this->salt($this->salt1, $this->salt2), $this->keys($this->key1, $this->key2), $num, $this->iv($this->key1.$this->salt1));
        unset($Crypto);
    }
    
    private function salt($string, $data)
    {
        $string = crypt($data, $string);
        return $string;
    }

    private function keys($data, $string)
    {
        $string = crypt($string, $data);
        return $string;
    }

    private function iv($string)
    {
        return mcrypt_create_iv(mcrypt_get_block_size(MCRYPT_TripleDES, MCRYPT_MODE_CBC), MCRYPT_DEV_RANDOM);
    }

    public function ivGenerator() 
    {
        //combine the userpart and the domain name p
        $chars = "a,b,c,d,e,f,g,h,i,j,k,l,m,n,o,p,q,r,s,t,u,v,w,x,y,z,#,@,$,%,&,!";
        $chars = explode(",", $chars);
        $ints = array();
        for ($i = 0; $i < 4; $i++) {
            array_push($ints, rand(0, 64));
        }
        $password = array();

        //composing the password
        foreach ($ints as $int) {
            $char = $chars[$int * rand(0, 3)];
            if (($int * rand(0, 3)) % 2 == 0) {
                $char = strtoupper($char);
                array_push($password, $int);
            }
            array_push($password, $char);
        }

        //convert the password array to string
        $stringpass = '';
        foreach ($password as $char) {
            $stringpass.=$char;
        }
        return $stringpass;
    }

    private function num()
    {
        return 6;//rand(0, 6);
    }

    //data validation
    private function valid($validator, $string)
    {
        if(!preg_match( "/^[0-9]{4}$/", $string)){
            return "Error";
        
        }else{
            return $string;
        };
    }

    //data stripping
    private function strip($string)
    {
        return trim(stripslashes($string));
    
    }

    // portects mysql from mysql injection
    // and trim unwanted tags elements and html entities
    private function mysql_protect($string) 
    {
        return @ mysql_escape_string(trim(strip_tags(addslashes($string))));
    }

}