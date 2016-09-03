<?php

/**
 * Session short summary.
 *
 * Session description.
 *
 * @version 1.0
 * @author Kaos
 */
class Session 
{
    public function session_check() 
    {
        //check if session is already started
        if (empty($_SESSION["{$_SERVER['HTTP_HOST']}_token"])) {
            //$this->create_session($data_ar);
            return false;
            
        } elseif (!empty($_SESSION["{$_SERVER['HTTP_HOST']}_token"])) {
        
            return true;
        }
    }

    public function create_session($data_ar)
    {
        //setting limitter
        session_cache_limiter('private');
        session_cache_expire(30); //cache expiring in 30mins
        if(!is_array($data_ar) && $data_ar == null){
            header("location: 503");
        }else {
            foreach($data_ar as $name=>$info){
                $_SESSION['user'][$name] = $this->secure_session($info);
            }
            $_SESSION["{$_SERVER['HTTP_HOST']}_token"] = $this->token_Generator();
        }
    }
    
    private function validated_session($token, $sessiontoken)
    {
        if($token === $sessiontoken){
            return true;
        }else {
        return false;
        }
    }
    
    //return true if the user has access to login credentials
    public function hasAccess($token) 
    {
        if(isset($_SESSION["{$_SERVER['HTTP_HOST']}_token"])){
            if(empty($_SESSION["{$_SERVER['HTTP_HOST']}_token"])){
                //no access
                return false;
            }
            if($this->validated_session($token, $_SESSION["{$_SERVER['HTTP_HOST']}_token"]) == true){
                //hass access
                return true;
           }else if($this->validated_session($token, $_SESSION["{$_SERVER['HTTP_HOST']}_token"]) == false){
                return false;
           }
        }
        return false;
    }
    
    public static function token_Generator() 
    {
        //combine the userpart and the domain name p
        $chars = "a,b,c,d,e,f,g,h,i,j,k,l,m,n,o,p,q,r,s,t,u,v,w,x,y,z";
        $chars = explode(",", $chars);
        $ints = array();
        for ($i = 0; $i < 4; $i++) {
            array_push($ints, rand(0, 8));
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
    
    public function unsecure_session($string)
    {
        return trim(stripslashes($this->decrypt_session($string))); 
    }
    
    public function secure_session($string)
    {
        return $this->encrypt_session($string);
    }
    
    private function decrypt_session($string)
    {
        return rtrim(base64_decode($string));
    }

    private function encrypt_session($string)
    {
        return rtrim(base64_encode($string));
    }
}

class SessionManager
{
   static function sessionStart($name, $limit = 0, $path = '/', $domain = null, $secure = null, $data = array())
   {
      // Set the cookie name before we start.
      session_name($name . '_Session');

      // Set the domain to default to the current domain.
      $domain = isset($domain) ? $domain : isset($_SERVER['SERVER_NAME']);

      // Set the default secure value to whether the site is being accessed with SSL
      $https = isset($secure) ? $secure : isset($_SERVER['HTTPS']);

      // Set the cookie settings and start the session
      session_set_cookie_params($limit, $path, $domain, $https, true);
      session_start();

        // Make sure the session hasn't expired, and destroy it if it has
        if(self::validateSession())
        {
            // Check to see if the session is new or a hijacking attempt
            if(!self::preventHijacking())
            {
                // Reset session data and regenerate id
                $_SESSION = array();
                $_SESSION['IPaddress'] = $_SERVER['REMOTE_ADDR'];
                $_SESSION['userAgent'] = $_SERVER['HTTP_USER_AGENT'];
                $_SESSION['user'] = $data;
                self::regenerateSession();

            // Give a 5% chance of the session id changing on any request
            }elseif(rand(1, 100) <= 5){
                self::regenerateSession();
            }
        }else{
            $_SESSION = array();
            session_destroy();
            session_start();
        }
   }
    
    static protected function validateSession()
    {
        if( isset($_SESSION['OBSOLETE']) && !isset($_SESSION['EXPIRES']) )
            return false;

        if(isset($_SESSION['EXPIRES']) && $_SESSION['EXPIRES'] < time())
            return false;

        return true;
    }

    static protected function preventHijacking()
    {
        if(!isset($_SESSION['IPaddress']) || !isset($_SESSION['userAgent']))
            return false;

        if ($_SESSION['IPaddress'] != $_SERVER['REMOTE_ADDR'])
            return false;

        if( $_SESSION['userAgent'] != $_SERVER['HTTP_USER_AGENT'])
            return false;

        return true;
    }
    
    static function regenerateSession()
    {
        // If this session is obsolete it means there already is a new id
        if(isset($_SESSION['OBSOLETE']) || $_SESSION['OBSOLETE'] == true)
            return;

        // Set current session to expire in 10 seconds
        $_SESSION['OBSOLETE'] = true;
        $_SESSION['EXPIRES'] = time() + 10;

        // Create new session without destroying the old one
        session_regenerate_id(false);

        // Grab current session ID and close both sessions to allow other scripts to use them
        $newSession = session_id();
        session_write_close();

        // Set session ID to the new one, and start it back up again
        session_id($newSession);
        session_start();

        // Now we unset the obsolete and expiration values for the session we want to keep
        unset($_SESSION['OBSOLETE']);
        unset($_SESSION['EXPIRES']);
    }
}
