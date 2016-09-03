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

class Edu_UI implements IModules
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
    private $category = array("Technology");
    
    private function generate_Link($url)
    {
        if(count($url) === 2)
        {
            $_GET['category'] = $url[1];
            return $url[1];
        }
        elseif(count($url) === 1)
        {
            return $url[0];
        }
        elseif(count($url) === 3)
        {
            $_GET['category'] = $url[2];
            return "Category";
        }
        elseif(count($url) === 4)
        {
            $_GET['title'] = $url[3];
            return "Single";
        }
    }
    
    public function gen_ui($data)
    {    
        if($data === "Edu" && !stristr($data, "/") || $data === "Edu/")
        {
            $data = "Home";
        }
        elseif(stristr($data, "/"))
        {
            $data = explode("/", $data);
            $data =  $this->generate_Link($data);
        }
        $services = $_GET['title'];
        $services = $_GET['category'];
        $this->ui = self::generate_Page($data, $services);
        switch($data)
        {
            case "Home" :
            case "About-Us" :
            case "Contact-Us" :
            case "Support" :
            case "Blog" :
            case "News" :
            case "Category":
            case "Single":
            {
                header("HTTP/1.1 200 $data");
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
                break;
            }
            default:
            {
                $err = ERR;
                //header("location: $err");
                echo $data;
            }
        }
        return $this->ui;        
    }
    
    private function Error($type = null, $msg = null)
    {
        ob_start();
        print eval('?>'.file_get_contents('Presentation Layer/Interface/Traits/Error/Header', TRUE));
        $header = ob_get_contents();
        ob_end_clean();

        ob_start();
        print eval('?>'.file_get_contents('Presentation Layer/Interface/Traits/Error/Interface', TRUE));
        $interface = ob_get_contents();
        ob_end_clean();

        ob_start();
        print eval('?>'.file_get_contents('Presentation Layer/Interface/Traits/Error/Footer', TRUE));
        $footer = ob_get_contents();
        ob_end_clean();
        
        return $header.$interface.$footer;
    }
    
    private function generate_Pages($data = null, $services = null)
    {
        ob_start();
        print eval('?>'.file_get_contents('Presentation Layer/Interface/Traits/Header', TRUE));
        $header = ob_get_contents();
        ob_end_clean();

        ob_start();
        print eval('?>'.file_get_contents('Presentation Layer/Interface/Traits/Nav', TRUE));
        $nav = ob_get_contents();
        ob_end_clean();

        ob_start();
        print eval('?>'.file_get_contents('Presentation Layer/Interface/Traits/Footer', TRUE));
        $footer = ob_get_contents();
        ob_end_clean();

        ob_start();
        print eval('?>'.file_get_contents('Presentation Layer/Pages/'.$data, TRUE));
        $interface = ob_get_contents();
        ob_end_clean();
            
        return $header.$nav.$interface.$footer;
    }
    
    private function generate_Page($data = null, $services = null)
    {
        ob_start();
        print eval('?>'.file_get_contents('Presentation Layer/Interface/Traits/Header', TRUE));
        $header = ob_get_contents();
        ob_end_clean();

        ob_start();
        print eval('?>'.file_get_contents('Presentation Layer/Interface/Traits/Nav', TRUE));
        $nav = ob_get_contents();
        ob_end_clean();

        ob_start();
        print eval('?>'.file_get_contents('Presentation Layer/Interface/Traits/Footer', TRUE));
        $footer = ob_get_contents();
        ob_end_clean();

        ob_start();
        print eval('?>'.file_get_contents('Presentation Layer/Pages/'.$data, TRUE));
        $interface = ob_get_contents();
        ob_end_clean();
            
        return $header.$nav.$footer;
    }
}
