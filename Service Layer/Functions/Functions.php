<?php

if(!is_file("Service Layer/Functions/Services/Feeds.php" || "Service Layer/Functions/Services/Authentication.php" || "Service Layer/Functions/Services/Post.php" || "Service Layer/Functions/Services/User.php" || "Service Layer/Functions/Services/Admin.php"))
{
    require_once "Service Layer/Functions/Services/Feeds.php";
    require_once "Service Layer/Functions/Services/Authentication.php";
    require_once "Service Layer/Functions/Services/Post.php";
    require_once "Service Layer/Functions/Services/User.php";
    require_once "Service Layer/Functions/Services/Admin.php";
}

class Functions extends Session
{
    static private $response;
    
    private function protect_input($string) 
    {
        return trim(strip_tags(addslashes($string)));
    }
    
    private function cleanInputs($data)
    {
		$clean_input = array();
		if(is_array($data))
        {
		  foreach($data as $k => $v)
          {
			$clean_input[$k] = self::cleanInputs($v);
          }
		}
        else
        {
		  if(get_magic_quotes_gpc())
          {
			$clean_input = self::protect_input($data);
		  }
	      elseif(!get_magic_quotes_gpc())
          {
              $clean_input = self::protect_input($data);
          }
        }
		return $clean_input;
    }	
    
    protected function Services_Checker($info, $files)
    {       
        $info = self::cleanInputs($info);
        switch($info['services'])
        {
            case "Blog":
            {
                $posts = new Post_Services();
                $this->response = $posts->Control($info['type'], $info['data']);
                unset($posts);
                break;
            }
            case "Auth":
            {
                $auth = new Auth_Services();
                $this->response = $auth->Control($info['type'], $info);
                unset($auth);
                break;
            }
            case "Account":
            {
                $users = new User_Services();
                $this->response = $users->Control($info['type'], $info['data']);
                unset($users);
                break;
            }
            case "Admin":
            {
                $admin = new Admin_Services();
                $this->response = $admin->Control($info['type'], $info);
                unset($admin);
                break;
            }
            case "Rss":
            {
                $feeds = new Feeds_Services();
                $this->response = $feeds->Control($info['type'], $info);
                unset($feeds);
                break;
            }
            default:
            {
                if($this->response === "not found" || $this->response === null)
                {
                    $this->response = "Service Not Found";
                } 
            }
        }
        return $this->response;
    }

}

?>