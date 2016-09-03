<?php
 if(!is_file("Data Layer/File_Manager/File_Manager.php"))
 {
     require_once "Data Layer/File_Manager/File_Manager.php";
 }
/**
 * Feeds_data short summary.
 *
 * Feeds_data description.
 *
 * @version 1.0
 * @author Kaos
 */

function strip($string)
{
    return trim(stripslashes($string));    
}

function rss_sort_asc($a, $b)
{
    $a_startDate = strtolower($a->startDate);
    $b_startDate = strtolower($b->startDate);
    if ($a_startDate == $b_startDate) 
    {
        return 0;
    }
    return ($a_startDate< $b_startDate) ? -1 : 1;
}

class Feeds_data
{
    public $responses;
    private $arr = array("http://rss.cnn.com/rss/edition_world.rss", "http://rss.cnn.com/rss/edition_sport.rss", "http://rss.cnn.com/rss/edition_entertainment.rss");
    
    public function generate_Feed($url, $category)
    {
        $i = 0;
        $response = array();
        $image;
        if(in_array($url, $this->arr))
        {
            $xml = simplexml_load_file($url);
            $namespaces = $xml->getNamespaces(true);
            foreach($xml->channel->item as $entry)
            {
                if($category === "CNN")
                {
                    if(empty($image))
                    {
                        $media_group = $entry->children($namespaces['media'])->group;
                        $image =  trim((string)$media_group->children($namespaces['media'])->content->attributes()->url);
                        //$tmp->media_credit = trim((string)$media_group->children($namespaces['media'])->credit);
                    }
                }
                elseif($category === "Trending")
                {
                    preg_match('@src="([^"]+)"@', $entry, $match);
                    //echo json_encode($match);
                    $image = $match[1];
                }
                if(empty($image))
                {
                    $media = $entry->children('media', $url);
                    foreach($media->thumbnail as $thumb) 
                    {
                        $image = $thumb->attributes()->url;
                    }
                }
                $response[strtotime($entry->pubDate)] = array(
                        'link' => stripslashes($entry->link),
                        'title' => strip($entry->title),
                        'date' => strip($entry->pubDate),
                        'description' => strip(strip_tags($entry->description, '<p>')),
                        'image' => stripslashes($image),
                    );
            }
        }
        else 
        {
            $xml = simplexml_load_file($url);
            foreach($xml->channel->item as $entry)
            {
                $media = $entry->children('media', $url);
                foreach($media->thumbnail as $thumb) 
                {
                    $image = $thumb->attributes()->url;
                }
                if(empty($image))
                {
                    preg_match('@src="([^"]+)"@', $entry->description, $match);
                    //echo json_encode($match);
                    $image = $match[1];
                    if(empty($image))
                    {
                        $html = new DOMDocument();        
                        $html->loadHTML($entry->description);
                        //get the first image tag from the description HTML
                        $image = $html->getElementsByTagName('img')->item(0)->getAttribute('src');
                    }
                }
                $response[strtotime($entry->pubDate)] = array(
                        'title' => strip($entry->title),
                        'link' => stripslashes($entry->link),
                        'description' => strip(strip_tags($entry->description, '<p>')),
                        'date' => strip($entry->pubDate),
                        'image' => stripslashes($image),
                    );
                //array_push($response, $items);
            }
        }
        krsort($response);
        return $response;
    }
    
    
    private function createFeeds($url, $category)
    {
        
    }
    
    private function Save_Feed($name, $text)
    {
        $data['data']['name'] = $name;
        $data['data']['text'] = $text;
        $DMining = new DMining();
        if(file_exists(getcwd()."/assets/files/".$name))
        {
            return $DMining->Process_Data($data, "update_file");
        }
        elseif(!file_exists(getcwd()."/assets/files/".$name))
        {
            return $DMining->Process_Data($data, "create_file");
        }
        unset($DMining);
    }
    
    private function Delete_Feed($name, $text)
    {
        $data['data']['name'] = $name;
        $data['data']['text'] = $text;
        $DMining = new DMining();
        return $DMining->Process_Data($data, "delete_file");
        unset($DMining);
    }
    
    private function Read_Feed($name, $text)
    {
        $data['data']['name'] = $name;
        $data['data']['text'] = $text;
        $DMining = new DMining();
        return $DMining->Process_Data($data, "read_file");
        unset($DMining);
    }
}