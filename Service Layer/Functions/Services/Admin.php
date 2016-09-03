<?php

if(!is_file("Service Layer/Functions/Email_Generator.php"))
{
    require_once 'Service Layer/Functions/Services/IServices.php';
}

class Admin_Services extends Functionality implements IServices
{
    private $response;
    
    function __construct()
    {
        unset($this->response);
    }
    
    public function Control($type, $info)
    {
        switch($type)
        {
            case "shareCount":
            {
                $this->response[$type] = self::countShares();
                break;
            }
            case "generateSiteMap":
            {
                $this->response[$type] = self::createSiteMap();
                break;
            }
            case "webRanking":
            {
                $this->response[$type] = self::alexaCheck(SITE);
                $this->response[$type]['Google']['Backlink'] = self::googleBacklink(SITE);
                $this->response[$type]['Google']['IndexPages'] = self::googleIndexPages(SITE);
                $this->response[$type]['Google']['Ranking'] = self::get_google_pagerank(SITE);
                break;
            }
            default:
            {
                $this->response = "not found";
            }
        }        
        return $this->response;
    }
    
    private function countShares()
    {
        $obj = new shareCount(SITE);
        return array(
            'twitter' => $obj->get_tweets(),
            'facebook' => $obj->get_fb(),
            'Google+' => $obj->get_plusones()
            );
    }
    
    private function createSiteMap()
    {
        $sitemap = new sitemap();

        //optionally set proxy server name and port or ip and port
        //comment-out or set to an empty string to disable proxy use
        //$sitemap->set_proxy('10.1.1.1:8080');

        //setting rules to ignore URLs which contains these substrings
        $sitemap->set_ignore(array("javascript:", ".css", ".js", ".ico", ".jpg", ".png", ".jpeg", ".swf", ".gif"));

        //parsing one page and gathering links
        $sitemap->get_links(ipProxy(SITE));
        

        //echo "<pre>";
        //print_r($arr);
        //echo "</pre>";

        header ("content-type: text/xml");
        //generating sitemap
        $map = $sitemap->generate_sitemap();

        //submitting site map to Google, Yahoo, Bing, Ask and Moreover services
        $sitemap->ping(SITE);

        //echo $map;

        //return URL list as array
        return $sitemap->get_array();
    }
    
    private function alexaCheck($url = null)
    {
        $xml = simplexml_load_file('http://data.alexa.com/data?cli=10&dat=snbamz&url='.$url);
        $rank=isset($xml->SD[1]->POPULARITY)?$xml->SD[1]->POPULARITY->attributes()->TEXT:0;
        $web=(string)$xml->SD[0]->attributes()->HOST;
        return array("Alexa" => array(
                'Rank' => $rank,
                "Backlink" => $backlink=(int)$xml->SD[0]->LINKSIN->attributes()->NUM,
                ),
            );
    }
    
    private function googleBacklink($domain = null)
    {
        $url="http://ajax.googleapis.com/ajax/services/search/web?v=1.0&q=link:".$domain."&filter=0";
        $ch=curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERAGENT,$_SERVER['HTTP_USER_AGENT']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt ($ch, CURLOPT_HEADER, 0);
        curl_setopt ($ch, CURLOPT_NOBODY, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        $json = curl_exec($ch);
        curl_close($ch);
        $data=json_decode($json,true);
        if($data['responseStatus']==200)
        return array("Backlink" => $data['responseData']['cursor']['resultCount']);
        else
        return false;
    }
    
    private function googleIndexPages($domain = null)
    {
        $url="http://ajax.googleapis.com/ajax/services/search/web?v=1.0&q=site:".$domain."&filter=0";
        $ch=curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERAGENT,$_SERVER['HTTP_USER_AGENT']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt ($ch, CURLOPT_HEADER, 0);
        curl_setopt ($ch, CURLOPT_NOBODY, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        $json = curl_exec($ch);
        curl_close($ch);
        $data=json_decode($json,true);
        if($data['responseStatus']==200)
        return array("IndexPages" => $data['responseData']['cursor']['resultCount']);
        else
        return false;
    }
    
    private function get_google_pagerank($url = null) 
    {
        $query="http://toolbarqueries.google.com/tbr?client=navclient-auto&ch=".self::CheckHash(self::HashURL($url)). "&features=Rank&q=info:".$url."&num=100&filter=0";
        $data=file_get_contents($query);
        $pos = strpos($data, "Rank_");
        if($pos === false){
            return "failed operation";
        } 
        else
        {
            $pagerank = substr($data, $pos + 9);
            return $pagerank;
        }
    }
    
    private function StrToNum($Str, $Check, $Magic)
    {
        $Int32Unit = 4294967296; // 2^32
        $length = strlen($Str);
        for ($i = 0; $i < $length; $i++) 
        {
            $Check *= $Magic;
            if ($Check >= $Int32Unit) 
            {
                $Check = ($Check - $Int32Unit * (int) ($Check / $Int32Unit));
                $Check = ($Check < -2147483648) ? ($Check + $Int32Unit) : $Check;
            }
            $Check += ord($Str{$i});
        }
        return $Check;
    }
    
    private function HashURL($String)
    {
        $Check1 = self::StrToNum($String, 0x1505, 0x21);
        $Check2 = self::StrToNum($String, 0, 0x1003F);
        $Check1 >>= 2;
        $Check1 = (($Check1 >> 4) & 0x3FFFFC0 ) | ($Check1 & 0x3F);
        $Check1 = (($Check1 >> 4) & 0x3FFC00 ) | ($Check1 & 0x3FF);
        $Check1 = (($Check1 >> 4) & 0x3C000 ) | ($Check1 & 0x3FFF);
        $T1 = (((($Check1 & 0x3C0) << 4) | ($Check1 & 0x3C)) <<2 ) | ($Check2 & 0xF0F );
        $T2 = (((($Check1 & 0xFFFFC000) << 4) | ($Check1 & 0x3C00)) << 0xA) | ($Check2 & 0xF0F0000 );
        return ($T1 | $T2);
    }
    
    private function CheckHash($Hashnum)
    {
        $CheckByte = 0;
        $Flag = 0;
        $HashStr = sprintf('%u', $Hashnum) ;
        $length = strlen($HashStr);
        for ($i = $length - 1; $i >= 0; $i --) 
        {
            $Re = $HashStr{$i};
            if (1 === ($Flag % 2)) 
            {
                $Re += $Re;
                $Re = (int)($Re / 10) + ($Re % 10);
            }
            $CheckByte += $Re;
            $Flag ++;
        }
        $CheckByte %= 10;
        if (0 !== $CheckByte) 
        {
            $CheckByte = 10 - $CheckByte;
            if (1 === ($Flag % 2) ) 
            {
                if (1 === ($CheckByte % 2)) 
                {
                    $CheckByte += 9;
                }
                $CheckByte >>= 1;
            }
        }
        return '7'.$CheckByte.$HashStr;
    }
}