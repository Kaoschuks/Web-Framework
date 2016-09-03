<?php

if(!is_file("Service Layer/Functions/Email_Generator.php"))
{
    require_once 'Service Layer/Functions/Services/IServices.php';
}

class Auth_Services extends Functionality implements IServices
{
    private $response;
    
    public function Control($type, $info)
    {
        if(empty($info['provider']))
        {
            $info['provider'] = "custom";                    
        }
        elseif(!empty($info['provider']))
        {
            $hybridauth = new Hybrid_Auth(realpath(dirname(__FILE__)).'\config.php');
            $adapter = $hybridauth->authenticate($info['provider']);
            $user_profile = $adapter->getUserProfile();
        }
        switch($type)
        {
            case "Login":
            {
                $info['type'] = "auth_user";
                $this->response = parent::Get_Control("Auth", $info);
                if(is_array($this->response))
                {
                    $ses = new Session();
                    $ses->create_session($this->response['user']);
                };
                break;
            }
            case "Register":
            {
                $info['type'] = "save_user";
                $this->response = parent::Get_Control("Auth", $info);
                break;
            }
            case "Forgot_Password":
            {
                $info['type'] = "change_password";
                $info['provider'] = "custom";
                $this->response = parent::Get_Control("Auth", $info);
                break;
            }
            default:
            {
                $this->response = "not found";
            }
        }        
        return $this->response;
    }
}