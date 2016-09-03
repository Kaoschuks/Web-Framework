<?php

/**
 * Functionality short summary.
 *
 * Functionality description.
 *
 * @version 1.0
 * @author Kaos
 */
if(is_file("Business Layer/Controls/IControl.php"))
{
    require_once "Business Layer/Controls/IControl.php";
}


class Blog extends DMining implements IControl
{        
    private $table = "posts";
    private $comment = array("post", "comment", "posted_by", "posted_on");
    
    public function Get_Control($control = null, $data = null)
    {
        switch($control)
        {
            case "get_post":
            {
                unset($data['data']);
                return $this->Get_Post($this->format($data));
                break;
            }
            case "get_single_post":
            {
                return $this->Get_Single_Post($this->format($data));
                break;
            }
            case "save_post":
            {
                return $this->Save_Post($this->format($data));
                break;
            }
            case "update_post":
            {
                return $this->Update_Post($this->format($data));
                break;
            }
            case "remove_post":
            {
                return $this->Delete_Post($this->format($data));
                break;
            }
            case "add_comment":
            {
                return $this->Create_Comment($this->format($data));
                break;
            }
            case "get_comment":
            {
                return $this->Get_Comment($this->format($data));
                break;
            }
            case "remove_comment":
            {
                return $this->Delete_Comment($this->format($data));
                break;
            }
            case "update_comment":
            {
                return $this->Update_Comment($this->format($data));
                break;
            }
            default:
            {
                return "Wrong user functionality type {$control} called";    
            }
        }
    }
    
    private function format($data = array())
    {
        unset($data['type']);
        return $data;
    }
    
    private function map($data = array(), $mapper  = array())
    {
        $maps = array();
        if(is_array($data))
        {
            foreach($data as $key => $dat)
            {
                foreach($mapper as $keys)
                {
                    if($key === $keys)
                    {
                        $maps[$key] = $dat;
                    } 
                }
            }
        }
        return $maps;
    }
    
    private function Save_Post($datas = array())
    {
        $data['table'] = $this->table;
        $data['data'][0] = $datas;
        $data['selector'] = "title";
        $data['category'] = "title";
        $response = DMining::Process_Data($data, "save");
        return $response[1];
    }
    
    private function Get_Post($data = array())
    {
        $data_ar['table'] = $this->table;
        unset($data['table']);
        $data_ar['selector'] = "";
        $data_ar['data'] = $data;
        $data_ar['category'] = "";
        $data_ar['limit'] = "";
        $posts = DMining::Process_Data($data_ar, "get");
        return $posts;
    }
    
    private function Get_Single_Post($data = array())
    {
        $data_ar['table'] = $this->table;
        $data_ar['selector'] = "title";
        $data_ar['category'] = "title";
        $data_ar['data'] = $data;
        $posts = DMining::Process_Data($data_ar, "get");
        if(empty($posts[0]))
        {
            return "Post {$data['title']} not found";
        }
        elseif(!empty($posts[0]))
        {
            return $posts[0];
        }
    }
    
    private function Delete_Post($datas = array())
    {
        $data['table'] = $this->table;
        $data['data'] = $datas;
        $data['selector'] = "title";
        $data['category'] = "title";
        $response = DMining::Process_Data($data, "delete");
        return $response;
    }
    
    private function Update_Post($datas = array())
    { 
        $data['data'] = $datas;
        $data['table'] = $this->table;
        $data['selector'] = "title";
        $data['category'] = "title";
        $response = DMining::Process_Data($data, "update");
        return $response;
    }
    
    private function Create_Comment($datas = array())
    {
        $data['table'] = "blog_comments";
        $data['data'][0] = self::map($datas, $this->comment);
        $data['selector'] = "";
        $data['category'] = "";
        $response = DMining::Process_Data($data, "add");
        return $response[1];
    }
    
    private function Get_Comment($data = array())
    {
        $data_ar['table'] = "blog_comments";
        unset($data['table']);
        $data_ar['selector'] = "post";
        $data_ar['data'] = $data;
        $data_ar['category'] = "post";
        $data_ar['limit'] = "";
        $posts = DMining::Process_Data($data_ar, "get");
        return $posts;
    }
    
    private function Delete_Comment($datas = array())
    {
        $data['table'] = "comments";
        $data['data'] = $datas;
        $data['selector'] = "id";
        $data['category'] = "id";
        $response = DMining::Process_Data($data, "delete");
        return $response;
    }
    
    private function Update_Comment($datas = array())
    {
        $data['table'] = "comments";
        $data['data'] = $datas;
        $data['selector'] = "id";
        $data['category'] = "id";
        //print_r($data);
        $response = DMining::Process_Data($data, "update");
        return $response;
    }
}
