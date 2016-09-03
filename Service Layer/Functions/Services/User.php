<?php

if(is_file("Service Layer/Functions/Services/IServices.php"))
{
    require_once 'Service Layer/Functions/Services/IServices.php';
}

class User_Services extends Functionality implements IServices
{
    private $response;
    
    public function Control($type = null, $info = null)
    {
        switch($type)
        {
            case "Create_Users":
            {
                $info['type'] = "save_users";
                $this->response = parent::Get_Control("Users", $info);
                break;
            }
            case "Update_Users":
            {
                $info['type'] = "update_users";
                $this->response = parent::Get_Control("Users", $info);
                break;
            }
            case "Delete_Users":
            {
                $info['type'] = "remove_users";
                $this->response = parent::Get_Control("Users", $info);
                break;
            }
            case "View_All_Users":
            {
                $info['type'] = "get_users";
                $this->response = parent::Get_Control("Users", $info);
                break;
            }
            case "View_Users":
            {
                $info['type'] = "get_single_user";
                $this->response = parent::Get_Control("Users", $info);
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

?>