<?php
/**
 * Service short summary.
 *
 * Service description.
 *
 * @version 1.0
 * @author Kaos
 */
 
// included files
if(!is_file("CSecurity.php"))
{
    require_once 'CSecurity.php';
}

class CSF
{
    private function csf_generator()
    {
        //combine the userpart and the domain name p
        $chars = "a,b,c,d,e,f,g,h,i,j,k,l,m,n,o,p,q,r,s,t,u,v,w,x,y,z,!,@,#,$,%,&,1,2,3,4,5,6,7,8,9,0";
        $chars = explode(",", $chars);
        $ints = array();
        for ($i = 0; $i < 8; $i++) {
            array_push($ints, rand(0, 12));
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
    
    public function check_csf_session($data, $url)
    {
        $CSecurity = new CSecurity();
        $res = $CSecurity->Unprotect($data, $url);
        if($res == $_SESSION[$url])
        {
            return true;
        }
        else
        {
            header("location: 401");
        }
        unset($CSecurity);
    }
    
    public function check_csf_site_session($url)
    {
        $CSecurity = new CSecurity();
        $res = $CSecurity->Unprotect($_ENV[$url], $url);
        $ses = $CSecurity->Unprotect($_SESSION[$url], $url);
        if($res == $ses)
        {
            return "true";
        }
        else
        {
            header("location: http://{$_SERVER['HTTP_HOST']}/401");
        }
        unset($CSecurity);
    }
    
    public function generate_csf_site_session($url)
    {
        $CSecurity = new CSecurity();
        unset($_ENV[$url]);
        unset($_SESSION[$url]);
        //unset($_SESSION['previous']);
        $var = $this->csf_generator();
        //$_SESSION['previous'] = $url;
        $_ENV[$url] = $CSecurity->Protect($var, $url);
        $_SESSION[$url] = $CSecurity->Protect($var, $url);
        unset($CSecurity);
    }
    
    public function generate_csf_form_session($url)
    {
        $CSecurity = new CSecurity();
        $_SESSION[$url] = $this->csf_generator();
        return $CSecurity->Protect($stringpass, $url);
        unset($CSecurity);
    }
}