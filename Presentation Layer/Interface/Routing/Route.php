<?php

include "IRoute.php";
include "Service Layer/Service.php";

/**
 * Route short summary.
 *
 * Route description.
 *
 * @version 1.0
 * @author Kaos
 */
class Route implements IRoute
{
    // variables for the route class
    private $_uri = array();

    public function Create_Route()
    {
        $var = new Variables();
        foreach($var->Page_Routes as $Pagename => $Pages)
        {
            self::Add($Pages);
        }
        unset($var);
    }
    
    private function Add($uri)
    {
        $this->_uri[] = trim($uri, '/');
    }
    
    public function Submit()
    {
        $uriGetParam = isset($_GET['uri']) ? $_GET['uri'] : '/';
        $url = explode("/", $uriGetParam);
        $_ENV = $url;
        $num = count($url);
        foreach ($this->_uri as $Key => $value)
        {
            if(preg_match("#^$value$#", ucfirst($uriGetParam)))
            {
                return $value;
            }
            else if(!preg_match("#^$value$#", ucfirst($uriGetParam)))
            {           
                if($num != 1)
                {
                    if($num == 2)
                    {
                        $_GET['post-title'] = $url[1];
                        $_GET['uri'] = $_GET['post-title'];
                        return $url[0]."-Categories";
                    }
                    elseif($num == 3)
                    {
                        $_GET['post-title'] = $url[2];
                        $_GET['uri'] = $_GET['post-title'];
                        return $url[0]."-Posts";
                    }
                }
                else
                {
                    if($uriGetParam === null || $uriGetParam === "/")
                    {
                        $_GET['uri'] = "Home";
                        return "Home";
                    }
                    else
                    {
                        return $uriGetParam;
                    }
                }
                
            }
        }
    }
}