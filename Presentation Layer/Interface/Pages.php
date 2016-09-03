<?php
/**
 * Pages_Ui short summary.
 *
 * Pages_Ui description.
 * This is the page interface function
 *
 * @version 1.0
 * @author Kaos
 */
if(is_file("Presentation Layer/Modules/Admin/pages.php") || is_file("Presentation Layer/Modules/Site.php") || is_file('Presentation Layer/Modules/Edu/Site.php'))
{
    require_once 'Presentation Layer/Modules/Admin/pages.php';
    require_once 'Presentation Layer/Modules/Edu/Site.php';
    require_once 'Presentation Layer/Modules/Site.php';
}

class Pages_Ui extends Route implements IPages
{
    public $page;
    private $ui;
    
    function __construct()
    {
        session_start();
        unset($this->page);
        unset($this->ui);
        Route::Create_Route();
    }
    
    public function ui()
    {
        $var = new Variables();
        $routes = $var->Page_Routes;
        unset($var);
        $url = explode("/", @ $_GET['uri']);
        
        if(@ $_GET['uri'] === "Webapp")
        {
            $this->ui = self::Pages_Generator($_GET['uri']);
        }
        elseif(in_array("Admin", $url))
        {
            $url = implode('/', $url);
            $admin = new Admin_UI();
            $this->ui = $admin->gen_ui($url);
            unset($admin);
        }
        elseif(in_array("Edu", $url))
        {
            $_GET['uri'] = "Home";
            $url = implode('/', $url);
            $edu = new Edu_UI();
            $this->ui = $edu->gen_ui($url);
            unset($edu);
        }
        elseif(@ $_GET['uri'] === null || $_GET['uri'] === "/")
        {
            $_GET['uri'] = "Home";
            $pages = new Site_UI();
            $this->ui = $pages->gen_ui(Route::submit());
            unset($pages);
        }
        elseif($_GET['uri'] !== null || $_GET['uri'] !== "/")
        {
            $pages = new Site_UI();
            $this->ui = $pages->gen_ui(Route::submit());
            unset($pages);
        }
        header_output();
        return $this->ui;
    }  
    
    private function Pages_Generator($data)
    {
        switch($data)
        {
            case "Webapp":
            {
                define("SERVICE_ACTIVATION", true);
                /*$data['user'] = $_SERVER['PHP_AUTH_USER'];
                $data['pass'] = $_SERVER['PHP_AUTH_PW'];
                if(Service::Auth_User($data) === "access granted")
                {*/
                unset($_GET['uri']);
                if(SERVICE_ACTIVATION === true)
                {
                    $this->page = process($_REQUEST);
                    $type = $_REQUEST['type'];
                    //header("HTTP/1.1 200 $type");
                    header('Connection: Close');
                };
                //}
                break;
            }
            default :
            {
                echo $data;
                $err = ERR;
                //header("location: $err");
            }
        }
        return $this->page;
    }
}
