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
    require_once "Business Layer/Controls/File.php";
}

class Feeds extends File implements IControl
{
    public function Get_Control($control = null, $data = null)
    {
        switch($control)
        {
            case "create_feeds":
            {
                unset($data['data']);
                return $this->Generate_From_Sources();
                break;
            }
            case "view_feeds":
            {
                $name = $data['data']['name'];
                unset($data['data']);
                return $this->View_Feeds($name);
                break;
            }
            case "update_feeds":
            {
                unset($data['data']);
                return $this->Update_Feeds();
                break;
            }
            case "delete_feeds":
            {
                $name = $data['data']['name'];
                unset($data['data']);
                return $this->Delete_Feeds($name);
                break;
            }
            default:
            {
                return "Wrong feed functionality type {$control} sent"; 
            }
        }
    }
    
    private function Generate_From_Sources()
    {
        $var = new Variables();
        $fed = new Feeds_data();
        
        foreach($var->Feeds as $source => $feeds)
        {
            foreach($feeds as $feed => $feed_source)
            {
                foreach($feed_source as $fe => $src)
                {
                    $this->response[$source][$feed][$fe] = $fed->generate_Feed($src, $fe);
                }
            }
            $data = array("name" => "rss/".$source.".json", "text" => json_encode($this->response[$source]));
                
            $this->response[$source]['file'] = File::Get_Control("create_file", $data);
        }
        unset($var);
        return "Feeds Created";
    }
    
    private function Update_Feeds()
    {
        $var = new Variables();
        $fed = new Feeds_data();
        
        foreach($var->Feeds as $source => $feeds)
        {
            foreach($feeds as $feed => $feed_source)
            {
                foreach($feed_source as $fe => $src)
                {
                    $this->response[$source][$feed][$fe] = $fed->generate_Feed($src, $fe);
                }
            }
            $data = array("name" => "rss/".$source.".json", "text" => "");
            $pre = json_decode(File::Get_Control("read_file", $data), true);
            array_merge($this->response[$source], $pre);
            unset($data);
            $data = array("name" => $source.".json", "text" => json_encode($this->response[$source]));
                
            $this->response[$source]['file'] = File::Get_Control("create_file", $data);
            unset($data);
        }
        unset($var);
        
        return "Feeds Updated";
    }
    
    private function View_Feeds($source)
    {
        $data = array("name" => "rss/".$source.".json", "text" => "");
        
        $this->response = File::Get_Control("read_file", $data);
        if(!empty($this->response))
        {
            return json_decode($this->response, true);
        }
        else
        {
            return "Data not found";
        }
        
    }
    
    private function Delete_Feeds($source)
    {
        $data = array("name" => $source.".json", "text" => "");
        
        $this->response = File::Get_Control("delete_file", $data);
        if(!empty($this->response))
        {
            return $this->response;
        }
        else
        {
            return "Data not found";
        }
    }
}