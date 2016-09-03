<?php
if(is_file("Presentation Layer/Interface/IPages.php"))
{
    require_once 'Presentation Layer/Interface/IPages.php';
}
/**
 * Pages_Ui short summary.
 *
 * Pages_Ui description.
 * This is the page interface function
 *
 * @version 1.0
 * @author Kaos
 */
$err = array("404", "403", "500", "401");

class Admin_UI implements IModules
{
    private $error_pages = array("400", "401", "402", "403", "404", "500", "501", "503");
    private $error_message = array(
        "400" => "Bad Request", 
        "401" => "Unauthorised User", 
        "403" => "Access Forbidden", 
        "404" => "Page Not Found", 
        "500" => "Internal Server Error", 
        "501" => "Service Functionality Not Implemented", 
        "503" => "Services unavailable"
    );
    private $ui;
    /*private $Modules = array(
        "Monitoring" => "{SITE}Monitoring",
    );*/
    
    private function generate_Link($url)
    {
        if(count($url) === 2)
        {
            if($url[1] == null){return "Dashboard";}else{return $url[1];}
        }
        elseif(count($url) === 1)
        {
            return $url[0];
        }
    }
    
    private function checkAccess()
    {        
        if(empty($_SESSION['user'])){return false;}else{return true;}
    }
    
    public function gen_ui($data)
    {   
        $data = $this->generate_Link(explode("/", $data));
        print_r($_SESSION);
        switch($data)
        {
            case "Dashboard" :
            case "Settings" :
            case "Analytics" :
            case "Profile" :
            case "Feeds-Manager" :
            case "Blogs-Manager" :
            case "Users-Manager" :
            {
                if($this->checkAccess() === false)
                {
                    $login = ADMIN_Login;
                    header("location: $login");
                }
                elseif($this->checkAccess() === true)
                {
                    $this->ui = self::generate_Pages($data, $data);
                    header("HTTP/1.1 200 $data");
                }
                break;
            }
            case "Login" :
            {
                unset($_SESSION);
                session_destroy();
                $this->ui = self::generate_Pages($data, $data);
                header("HTTP/1.1 200 $data");
                break;
            }
            case "Logout":
            {
                $login = ADMIN_Login;
                header("location: $login");
                break;
            }
            case "Monitoring" :
            {
                /*$modules = $this->Modules[$data];
                header("HTTP/1.1 302 Temporary Redirect");
                header("location: $modules");*/
                break;
            }
            case "400" :
            case "401" :
            case "403" :
            case "404" :
            case "500" :
            case "501" :
            case "503" :
            {
                $this->ui = self::Error($data, $this->error_message[$_GET['uri']]);
                header("HTTP/1.1 $data $error_message");
                //exit();
                break;
            }
            default:
            {
                $err = ERR;
                header("HTTP/1.1 302 Redirecting To Error Pages");
                //header("location: $err");
                echo $data;
            }
        }
        return $this->ui; 
    }
    
    private function Error($data = null, $msg = null)
    {
        $type = "Error";
        ob_start();
        print eval('?>'.file_get_contents('Presentation Layer/Modules/Admin/Header', TRUE));
        $header = ob_get_contents();
        ob_end_clean();

        ob_start();
        print eval('?>'.file_get_contents('Presentation Layer/Modules/Admin/Footer', TRUE));
        $footer = ob_get_contents();
        ob_end_clean();
        
        return $header.$footer;
    }
    
    private function generate_Pages($data = null, $services = null)
    {
        ob_start();
        print eval('?>'.file_get_contents('Presentation Layer/Modules/Admin/Header', TRUE));
        $header = ob_get_contents();
        ob_end_clean();
        
        ob_start();
        print eval('?>'.file_get_contents('Presentation Layer/Modules/Admin/Nav', TRUE));
        $nav = ob_get_contents();
        ob_end_clean();
                
        ob_start();
        print eval('?>'.file_get_contents('Pages/Admin/'.$data, TRUE));
        $interface = ob_get_contents();
        ob_end_clean();

        ob_start();
        print eval('?>'.file_get_contents('Presentation Layer/Modules/Admin/Footer', TRUE));
        $footer = ob_get_contents();
        ob_end_clean();
            
        return $header.$nav.$interface.$footer;
    }
}
