<?php

/**
 * @version 1.0
 * @author Kaos
 */

if(!is_file("IDMining.php"))
{
    require_once "IDMining.php";
}

class DMining extends Crypto implements IDMining
{
    public $response;
    private $limits = array("id", "username", "posted_by", "author", "title", "previous", "post", "passwd", "uname");
    private $de_limits = array("tags");
    const KEY = "6e6f7420636f6d706c657465";
    
    public function Process_Data($data, $type)
    {
        $dat = array();
        $rb = new RBManager();
        $con = $rb->Connect(DATABASE, DATABASE_USERNAME, DATABASE_PASSWORD);
                
        switch($type)
        {
			case "update":
            {
                $res = array();
                $num = count($data['data']);
                //echo $num;
                foreach($data['data'] as $info => $datas)
                {
                    if(!in_array($info, $this->limits))
                    {
                        $dat[$info] = $this->Secure_mined_data($datas, 6);
                        unset($data['data'][$i][$info]);
                    }
                    elseif(in_array($info, $this->limits))
                    {
                        $dat[$info] = $datas;
                        unset($data['data'][$i][$info]);
                    }
                } 
                $data['data'] = $dat;
                return json_decode(json_encode($rb->Query_Type("update", $data, $con)), true);
                break;
            }
            case "add":
            {
                $res = array();
                $num = count($data['data']);
                if($num == null)
                {
                    foreach($data['data'] as $info => $datas)
                    {
                        if(!in_array($info, $this->limits))
                        {
                            $dat[$info] = $this->Secure_mined_data($datas, 6);
                        }
                        elseif(in_array($info, $this->limits))
                        {
                            $dat[$info] = $datas;
                        }
                    }
                    $res[$i] = json_decode(json_encode($rb->Query_Type("add", $data, $con)), true);
                }
                else
                {
                    for($i = 0; $i < $num; $i++)
                    {
                        foreach($data['data'][$i] as $info => $datas)
                        {
                            if(!in_array($info, $this->limits))
                            {
                                $dat[$info] = $this->Secure_mined_data($datas, 6);
                                unset($data['data'][$i][$info]);
                            }
                            elseif(in_array($info, $this->limits))
                            {
                                $dat[$info] = $datas;
                                unset($data['data'][$i][$info]);
                            }
                        }
                    }
                    $data['data'] = $dat;
                    $res[$i] = json_decode(json_encode($rb->Query_Type("add", $data, $con)), true);
                }
                return $res;
                break;
            }
            case "save":
            {
                $res = array();
                $num = count($data['data']);
                if($num == null)
                {
                    foreach($data['data'] as $info => $datas)
                    {
                        if(!in_array($info, $this->limits))
                        {
                            $dat[$info] = $this->Secure_mined_data($datas, 6);
                        }
                        elseif(in_array($info, $this->limits))
                        {
                            $dat[$info] = $datas;
                        }
                    }
                    
                    $data['data'] = $dat;
                    $res[$i] = json_decode(json_encode($rb->Query_Type("insert", $data, $con)), true);
                }
                else
                {
                    for($i = 0; $i < $num; $i++)
                    {
                        foreach($data['data'][$i] as $info => $datas)
                        {
                            if(!in_array($info, $this->limits))
                            {
                                $dat[$info] = $this->Secure_mined_data($datas, 6);
                            }
                            elseif(in_array($info, $this->limits))
                            {
                                $dat[$info] = $datas;
                            }
                        }
                    }
                    $data['data'] = $dat;
                    $res = json_decode(json_encode($rb->Query_Type("insert", $data, $con)), true);
                }
                return $res;
                break;
            }
            case "get":
            {
                $da = array();
                $response = $rb->Query_Type("select", $data, $con);
                foreach($response as $datas => $info)
                {
                    foreach($info as $infos => $dat)
                    {
                        if(in_array($infos, $this->limits))
                        {
                            $da[$infos] = $dat;
                        }
                        elseif(!in_array($infos, $this->limits))
                        {
                            if(in_array($infos, $this->de_limits))
                            {
                                $da[$infos] = $this->Unsecure_mined_data($dat, 6);
                            }
                            elseif(!in_array($infos, $this->de_limits))
                            {
                               $da[$infos] = $this->Unsecure_mined_data($dat, 6);
                            }
                        }
                    }
                   $response[$datas] = $da;
                }
                return $response;
                break;
            }
            case "delete":
            {
                $res = array();                
                $res[] = json_decode(json_encode($rb->Query_Type("delete", $data, $con)), true);
                //print_r($res);
                return $res;
                break;
            }
            case "create_file":
            {
                $fm = new File_Manager();
                return $fm->file_control("Create", $data['name'], json_encode($data['text']));
                unset($fm);
                break;
            }
            case "update_file":
            {
                $fm = new File_Manager();
                return $fm->file_control("Update", $data['name'], $data['text']);
                unset($fm);
                break;
            }
            case "delete_file":
            {
                $file = $data['name'];
                $fm = new File_Manager();
                return $fm->file_control("Delete", $file, $data);
                unset($fm);
                break;
            }
            case "read_file":
            {
                $file = $data['name'];
                $fm = new File_Manager();
                return json_decode($fm->file_control("Read", $file, $data), TRUE);
                unset($fm);
                break;
            }
            default:
            {
                echo "use correct mining type : {$type}";
            }
        }
        
        unset($rb);
        unset($con);
    }
    
    private function Secure_mined_data($data, $num)
    {
        return Crypto::Encrypt($data, hex2bin(KEY));
    }
    
    private function Unsecure_mined_data($data, $num)
    {
        return Crypto::Decrypt($data, hex2bin(KEY));
    }
    
   /* private function Secure_mined_data($data, $num)
    {
        $DBSecurity = new DBSecurity();
        $this->response = $DBSecurity->Protect($data, $num);
        unset($DBSecurity);
        return $this->response;
    }
    
    private function Unsecure_mined_data($data, $num)
    {
        $DBSecurity = new DBSecurity();
        $this->response = $DBSecurity->Unprotect($data, $num);
        unset($DBSecurity);
        return $this->response;
    }*/
}