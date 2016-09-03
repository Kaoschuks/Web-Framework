<?php 
 /*$uri = explode('/', $_SERVER['REQUEST_URI']);
if(is_array($uri))
{
    header("HTTP/1.1 503 Bad Request");
    header("location: 404");
}
elseif(!is_array($uri))
{
*/
    /*$_SERVER['REQUEST_METHOD'] = "POST";
    $_REQUEST = array(
        "type" => "Register",
        "name" => "Kaos Chuks Kels",
        "uname" => "Kels",
        "passwd" => "Kaoschuks",
        "access" => "user",
        "email" => "kelschuks@yahoo.com",
        "image" => "image.jpg",
        "services" => "Auth",
    );*/

    /*$_SERVER['REQUEST_METHOD'] = "POST";
    $_REQUEST = array(
        "type" => "Create_Feed",
        "name" => "News",
        "services" => "Rss",
    );*/

    try 
    { 
        if(is_readable('Presentation Layer/Presentation.php'))
        {
            require_once 'Presentation Layer/Presentation.php';
            malicous_request();
        }
        
        function generate_ui()
        {    
            $Pages = new Pages_Ui();
            //echo PHPWee\Minify::html($Pages->ui());
            echo $Pages->ui();
    //print_r(get_defined_functions()['user']);print_r(get_defined_constants());print_r(get_declared_classes());
            unset($Pages);
        }

        //error_reporting(E_ALL);
        //error_reporting(1);
        error_reporting(0);
        // secondary compression enabling
        if(substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'zlib'))ob_start("ob_gzhandler"); else ob_start();
        generate_ui();
        header('Connection: Close');

    } 
    catch(Exception $e) 
    {
        $_GET['Error'] = 'Error: ' . $e->getMessage(); // To show output and error
        header("location: 400");
    }