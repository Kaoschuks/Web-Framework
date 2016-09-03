<?php

/**
 * Functionality short summary.
 *
 * Functionality description.
 *
 * @version 1.0
 * @author Kaos
 */
if(!is_file("IFunctionality.php"))
{
    require_once "IFunctionality.php";
}

class Functionality implements IFunctionality
{
    private $response;
    
    public function Get_Control($type = null, $data = null)
    {
        switch($type)
        {
            case "Users":
            {
                $users = new Users();
                $this->response = $users->Get_Control($data['type'], $data);
                unset($users);
                break;
            }
            case "Auth":
            {
                $auth = new Auth_Control();
                $this->response = $auth->Get_Provider($data, $data['provider'], $data['type']);
                unset($auth);
                break;
            }
            case "Blog":
            {
                $blog = new Blog();
                $this->response = $blog->Get_Control($data['type'], $data);
                unset($blog);
                break;
            }
            case "Rss":
            {
                $Feeds = new Feeds();
                $this->response = $Feeds->Get_Control($data['type'], $data);
                unset($Feeds);
                break;
            }
            case "File":
            {
                $File = new File();
                $this->response = $File->Get_Control($data['type'], $data);
                unset($File);
                break;
            }
            default:
            {
                $this->response = "Wrong functionality type {$control} sent";    
            }
        }
        return $this->response;
    }
}
