<?php

/**
 * Functionality short summary.
 *
 * Functionality description.
 *
 * @version 1.0
 * @author Kaos
 */
if(is_file("IControl.php"))
{
    require_once "IControl.php";
}

class Users extends DMining implements IControl
{
    private $acct = "account";
    
    public function Get_Control($control = null, $data = array())
    {
        switch($control)
        {
            case "get_users":
            {
                return $this->Get_Users($this->format($data));
                break;
            }
            case "get_single_user":
            {
                return $this->Get_Single_User($this->format($data));
                break;
            }
            case "save_users":
            {
                return $this->Save_Users($this->format($data));
                break;
            }
            case "update_users":
            {
                return $this->Update_Users($this->format($data));
                break;
            }
            case "remove_users":
            {
                return $this->Delete_Users($this->format($data));
                break;
            }
            default:
            {
                return "Wrong user functionality type {$control} sent";    
            }
        }
    }    
    
    private function format($data = array())
    {
        unset($data['type']);
        unset($data['provider']);
        return $data;
    }
    
    private function Save_Users($datas = array())
    {
        // basic user
        $data['table'] = $this->acct;
		/*$res = array();
        /$FU = new File_Uploads();
        foreach($_FILES as $num => $files)
        {
            $files['file'] = $files;
            if(!empty($files['file']['name']))
            {
                $res[$num] = $FU->Upload($num, USER.$num, $files);
                $datas[$num] = USER_Path.$num.$files['file']['name'];
            }else
            {
                $datas[$num] = ADS_Path.$num.$files['file']['name'];
            }
        }*/
        $data['data'] = $datas;
        $data['selector'] = "uname";
        $data['category'] = "uname";
        $response[$data['table']] = parent::Process_Data($data, "save");
        return $response;
    }
    
    private function Delete_Users($datas = array())
    {
        $data['table'] = $this->acct;
        $data['data'] = $datas;
        $data['selector'] = "uname";
        $data['category'] = "uname";
        $response[$data['table']] = parent::Process_Data($data, "delete");
        $data['table'] = "auth";
        $response[$data['table']] = parent::Process_Data($data, "delete");
        return $response;
    }
    
    private function Update_Users($datas = array())
    {
        $data['table'] = $this->acct;
        $data['data'] = $datas;
        $data['selector'] = "id";
        $data['category'] = "id";
        $response[$data['table']] = parent::Process_Data($data, "update");
        return $response;
    }
    
    private function Get_Users($datas = array())
    {
        $data['table'] = $this->acct;
        $data['data'] = $datas;
        $data['selector'] = "";
        $data['category'] = "";
        $response = parent::Process_Data($data, "get");
        return $response;
    }
    
    private function Get_Single_User($datas = array())
    {
        $data['table'] = $this->acct;
        $data['data'] = $datas;
        $data['selector'] = "uname";
        $data['category'] = "uname";
        $response[$data['table']] = parent::Process_Data($data, "get");
        return $response;
    }
}
