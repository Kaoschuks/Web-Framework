<?php

if(is_file("Service Layer/Functions/Services/IServices.php"))
{
    require_once 'Service Layer/Functions/Services/IServices.php';
}

class Post_Services implements IServices
{
    private $response;
    
    public function Control($type, $info)
    {
        switch($type)
        {
            case "Create_Post":
            {
                $info['type'] = "save_post";
                $functions = new Functionality();
                $this->response = $functions->Get_Control("Blog", $info);
                unset($functions);           
                break;
            }
            case "Update_Post":
            {
                $info['type'] = "update_post";
                $functions = new Functionality();
                $this->response = $functions->Get_Control("Blog", $info);
                //$this->Caching("Save-Cache", $info['type'], json_decode($this->response, TRUE));
                unset($functions);           
                break;
            }
            case "Delete_Post":
            {
                /*$cache = $this->Caching("Delete-Cache", $info['type'], ' ');
                if(is_array($cache))
                {
                    $this->response = $cache;
                }
                elseif(!is_array($cache))
                {*/
                    $info['type'] = "remove_post";
                    $functions = new Functionality();
                    $this->response = $functions->Get_Control("Blog", $info);
                    /*$this->Caching("Delete-Cache", $info['type'], $this->response);
                    unset($functions);
                }    */            
                break;
            }
            case "View_All_Post":
            {
                /*$cache = $this->Caching("Get-Cache", $info['type'], ' ');
                if(is_array($cache))
                {
                    $this->response = $cache;
                }
                elseif(!is_array($cache))
                {
                    */$info['type'] = "get_post";
                    $functions = new Functionality();
                    
                    $this->response = $functions->Get_Control("Blog", $info);
                    
                    //$this->Caching("Save-Cache", $info['type'], $this->response);
                    unset($functions);
                //}                
                break;
            }
            case "View_Post":
            {
                /*$cache = $this->Caching("Get-Cache", $info['type'], ' ');
                if(is_array($cache))
                {
                    $this->response = $cache;
                }
                elseif(!is_array($cache))
                {
                    */$info['type'] = "get_single_post";
                    $functions = new Functionality();
                    
                    $this->response = $functions->Get_Control("Blog", $info);
                    
                    //$this->Caching("Save-Cache", $info['type'], $this->response);
                    unset($functions);
                //}                
                break;
            }
            case "Update_Comment":
            {
                $info['type'] = "update_comment";
                $functions = new Functionality();
                $this->response = $functions->Get_Control("Blog", $info);
                //$this->Caching("Save-Cache", $info['type'], json_decode($this->response, TRUE));
                unset($functions);           
                break;
            }
            case "Delete_Comment":
            {
                /*$cache = $this->Caching("Delete-Cache", $info['type'], ' ');
                if(is_array($cache))
                {
                    $this->response = $cache;
                }
                elseif(!is_array($cache))
                {*/
                    $info['type'] = "remove_comment";
                    $functions = new Functionality();
                    $this->response = $functions->Get_Control("Blog", $info);
                    /*$this->Caching("Delete-Cache", $info['type'], $this->response);
                    unset($functions);
                }    */            
                break;
            }
            case "View_All_Comment":
            {
                /*$cache = $this->Caching("Get-Cache", $info['type'], ' ');
                if(is_array($cache))
                {
                    $this->response = $cache;
                }
                elseif(!is_array($cache))
                {
                    */$info['type'] = "get_comment";
                    $functions = new Functionality();
                    
                    $this->response = $functions->Get_Control("Blog", $info);
                    
                    //$this->Caching("Save-Cache", $info['type'], $this->response);
                    unset($functions);
                //}                
                break;
            }
            case "Add_Comment":
            {
                $info['type'] = "add_comment";
                $functions = new Functionality();
                $this->response = $functions->Get_Control("Blog", $info);
                unset($functions);           
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