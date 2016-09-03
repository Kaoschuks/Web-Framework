<?php

/**
 * Auth short summary.
 *
 * Session description.
 *
 * @version 1.0
 * @author Kaos
 */
if(is_file("Data Layer/Data.php"))
{
    require_once "Data Layer/Data.php";
}

class Auth_Control extends DMining
{
    public $response;
    const SALT = "MIICXAIBAAKBgQDfmlc2EgrdhvakQApmLCDOgP0nNERInBheMh7J/r5aU8PUAIpGXET/8";
        
    private $auths = array("uname", "passwd", "access");
    private $acct = array("name", "uname", "email", "image");
    
    public function Get_Provider($data, $type, $control)
    {
        if($type === "facebook")
        {
            $this->response = $this->Users_Control($control, $data);
            //$this->response = $this->FB_Data($data);
        }
        else if ($type === "custom") 
        {
            $this->response = $this->Users_Control($control, $data);
        }
        return $this->response;
    }
    
    private function Users_Control($control, $data)
    {
        switch($control)
        {
            case "auth_user":
            {
                return $this->Auth_Users($this->format($data));
                break;
            }
            case "save_user":
            {
                return $this->Save_Users($this->format($data));
                break;
            }
            case "change_password":
            {
                return $this->Update_Users($this->format($data));
                break;
            }
            default:
            {
                return "Wrong control type {$control}";    
            }
        }
    }
    
    private function format($data)
    {
        unset($data['type']);
        unset($data['provider']);
        unset($data['services']);
        return $data['data'];
    }
    
    private function map($data, $mapper)
    {
        $maps = array();
        if(is_array($data))
        {
            foreach($data as $key => $dat)
            {
                foreach($mapper as $keys)
                {
                    if($key === $keys)
                    {
                        if($key === "passwd")
                        {
                            $maps[$key] = _create_hash($dat, SALT);
                        }
                        elseif($key !== "passwd")
                        {
                            $maps[$key] = $dat;
                        }
                    } 
                }
            }
        }
        return $maps;
    }
    
    private function Save_Users($datas)
    {
        //auth
        $data['table'] = "auth";
        $data['selector'] = "uname";
        $data['data'][0] = self::map($datas, $this->auths);
        $data['category'] = "uname";
        $response[$data['table']] = parent::Process_Data($data, "save");
        unset($data['data']);
        
        // basic user
        $data['table'] = "account";
        $data['data'][0] = self::map($datas, $this->acct);
        $response[$data['table']] = parent::Process_Data($data, "save");
        return $response;
    }
    
    private function Auth_Users($data)
    {
        $data_ar['table'] = "auth";
        $data_ar['selector'] = "uname";
        $data_ar['data'] = $data;
        $data_ar['category'] = "uname";
        $users = parent::Process_Data($data_ar, "get");
        if(empty($users[0]))
        {
            return "Incorrect username or password";
        }
        elseif(!empty($users[0]))
        {
            if(self::validateLogin($data['passwd'], $users[0]['passwd'], SALT))
            {
                $data_ar['table'] = "account";
                $response['user'] = parent::Process_Data($data_ar, "get")[0];
                $response['user']['access'] = $users[0]['access'];
                return $response;
            }
            else 
            {
                return "Incorrect username or password";
            }
            
        }
    }
    
    private function Update_Users($datas = array())
    {
        $data['table'] = "auth";
        $data['data'] = $datas;
        $data['selector'] = "uname";
        $data['category'] = "uname";
        $response[$data['table']] = parent::Process_Data($data, "update");
        return $response;
    }
    
    /**
     * @param string $pass The user submitted password
     * @param string $hashed_pass The hashed password pulled from the database
     * @param string $salt The salt used to generate the encrypted password
     */    
    private function validateLogin($pass, $hashed_pass, $salt) 
    {
        return ($hashed_pass === _create_hash($pass, $salt));
    }
    
}