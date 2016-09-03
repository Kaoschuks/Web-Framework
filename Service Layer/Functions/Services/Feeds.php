<?php

if(is_file("Service Layer/Functions/Services/IServices.php"))
{
    require_once 'Service Layer/Functions/Services/IServices.php';
}

class Feeds_Services implements IServices
{
    private $response;
    
    public function Control($type, $info)
    {
        switch($type)
        {
            case "Create_Feed":
            {
                $info['type'] = "create_feeds";
                $functions = new Functionality();
                $this->response = $functions->Get_Control("Rss", $info);
                $this->Caching("Save-Cache", $info['type'], json_decode($this->response, TRUE));
                unset($functions);           
                break;
            }
            case "Update_Feed":
            {
                $info['type'] = "update_feeds";
                $functions = new Functionality();
                $this->response = $functions->Get_Control("Rss", $info);
                $this->Caching("Save-Cache", $info['type'], json_decode($this->response, TRUE));
                unset($functions);           
                break;
            }
            case "Delete_Feed":
            {
                $cache = $this->Caching("Delete-Cache", $info['type'], ' ');
                if(is_array($cache))
                {
                    $this->response = $cache;
                }
                elseif(!is_array($cache))
                {
                    $info['type'] = "delete_feeds";
                    $functions = new Functionality();
                    $this->response = $functions->Get_Control("Rss", $info);
                    $this->Caching("Delete-Cache", $info['type'], $this->response);
                    unset($functions);
                }                
                break;
            }
            case "View_Feed":
            {
                $cache = $this->Caching("Get-Cache", $info['type'], ' ');
                if(is_array($cache))
                {
                    $this->response = $cache;
                }
                elseif(!is_array($cache))
                {
                    $info['type'] = "view_feeds";
                    $functions = new Functionality();
                    
                    $this->response = $functions->Get_Control("Rss", $info);
                    
                    $this->Caching("Save-Cache", $info['type'], $this->response);
                    unset($functions);
                }                
                break;
            }
            default:
            {
                $this->response = "not found";
            }
        }        
        return $this->response;
    }
    
    // services type checker
    private function Caching($type, $Key, $Data)
    {
        $cache = new Cache();
        if($oCache->bEnabled)
        {
            return $cache->cache_service($type, $Key, $Data);
        }
        else
        {
            return "Not enabled";
        }
        unset($Cache);
    }
}
