<?php
    require_once 'IRBManager.php';  
/**
 * RBManager short summary.
 *
 * RBManager description.
 *
 * @version 1.0
 * @author Kaos
 */

class RBManager implements IRBManager
{
    private $host = DATABASE_HOST;
    private $con;
    private $query;
    
    function __construct()
    {
        unset($this->con);
        unset($this->query);
    }
    
    public function Connect($db = null, $db_user = null, $db_pass = NULL)
    {
        $this->con = new PDO("mysql:host={$this->host};dbname={$db}", $db_user, $db_pass);
        $this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $this->con;
    }
    
    public function Query_Type($type, $data_ar, $con)
    {
        @ $table = $data_ar['table'];
        @ $cat = $data_ar['category'];
        @ $limit = $data_ar['limit'];
        @ $data = $data_ar['data'];
        unset($data_ar);
        
        switch($type)
        {
            case "select":
            {
                return $this->Select($table, $cat, $data, $con, $limit);
                break;
            }
            case "add":
            {
                return $this->Insert($table, $data, $con);
                break;
            }
            case "insert":
            {
                $res = $this->Select($table, $cat, $data, $con, $limit);
                if(!empty($res))
                {
                    return "Data duplication not allowed";
                }
                else
                {
                    return $this->Insert($table, $data, $con);
                }
                break;
            }
            case "update":
            {
                $datas[$cat] = $data['previous'];
                unset($data['previous']);
                $res = $this->Select($table, $cat, $datas, $con, $limit);
                $cat = 'id';
                if(!empty($res))
                {
                    $data['id'] = json_decode(json_encode($res[0]), true)['id'];
                    return $this->Update($table, $cat, $data, $con);
                }
                else
                {
                    return "Data can't be updated because {$cat} : `{$data[$cat]}` not found";
                }
                break;
            }
            case "delete":
            {
                $res = $this->Select($table, $cat, $data, $con, $limit);
                if(!empty($res))
                {
                    return $this->Delete($table, $cat, $data, $con);
                }
                else
                {
                    return "Data already be deleted";
                }
                break;
            }
            default:
            {
                echo "Invalid database mapper query";  
            }
        }
    }
    
    private function sql_injection_protect($data)
    {
        if(is_array($data))
        {
            foreach($data as $key => $info)
            {
                if(!is_array($info))
                {
                    $data[$key] = mysqli_real_escape_string($info);
                }
                elseif(is_array($info))
                {
                    foreach($info as $keys => $infos)
                    {
                        $data[$key][$keys] = mysqli_real_escape_string($infos);
                    }
                }
            }
        }
        elseif(!is_array($data))
        {
            $data = mysqli_real_escape_string($data);
        }
        return $data;
    }
    
    private function Delete($table, $cat, $data_ar, $con)
    {
        $this->query = $con->prepare("DELETE FROM {$table} WHERE {$cat} = :{$cat}");
        $this->query->execute(array($cat => $data_ar[$cat]));
        return "Deleted";
    }   
    
    private function Select($table, $cat, $data_ar, $con, $limit)
    {
        //$data_ar = $this->sql_injection_protect($data_ar);
        if($cat || $data_ar[$cat] != null && empty($limit))
        {
            $this->query = $con->prepare("SELECT * FROM {$table} WHERE {$cat} = :{$cat} ORDER BY id DESC");
        }
        else if($cat || $data_ar[$cat] != null && !empty($limit))
        {
            $this->query = $con->prepare("SELECT * FROM {$table} WHERE {$cat} = :{$cat} ORDER BY id DESC LIMIT {$limit}");
        }
        else if($cat || $data_ar[$cat] == null && !empty($limit))
        {
            $this->query = $con->prepare("SELECT * FROM  {$table} ORDER BY id DESC LIMIT {$limit}");           
        }
        else
        {
            $this->query = $con->prepare("SELECT * FROM  {$table} ORDER BY id DESC");           
        }
        
        @ $this->query->execute(array($cat => $data_ar[$cat]));
        
        $rows = array();
        while($row = $this->query->fetch(PDO::FETCH_OBJ)) 
        {
            array_push($rows, $row);
        }
        return $rows;
    }
    
    private function Insert($table, $data_ar, $con)
    {
        $arr = array();
        //build the string with the length of the array
        $cou = "";
        $values = ":id, ";
        $arr['id'] = ' ';
            //build the string with the length of the array
        $i=1;//
        foreach($data_ar as $data=>$info)
        {    
            if($i!=count($data_ar))
            { 
                //if not at the last data
                $values .= ":{$data}, ";
               $arr[$data] = $info;
            }
            else if($i == count($data_ar))
            {
                $values .= ":{$data}";
               $arr[$data] = $info;
            }
            $i++;
        }
        //echo $values;
        $this->query = $con->prepare("INSERT INTO {$table} VALUES({$values})");
        $this->query->execute($arr);
        return "Inserted";
    }    
    
    private function Update($table, $cat, $data_ar, $con)
    {
        $query = "";
        $arr = array();
            //build the string with the length of the array
        $i=1;//
        foreach($data_ar as $data=>$info)
        {    
            if($i!=count($data_ar))
            { 
                //if not at the last data
                $query .= "{$data} = :{$data}, ";
               $arr[$data] = $info;
            }
            else if($i == count($data_ar))
            {
                $query .= "{$data} = '{$info}'";
               $arr[$data] = $info;
            }
            $i++;
        }
        
        $this->query = $con->prepare("update {$table} set {$query} where {$cat} = :{$cat}");
        $this->query->execute($arr);
        return "Updated";
    }     
    
}
