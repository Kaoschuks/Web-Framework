<?php
/**
 * Service short summary.
 *
 * Service description.
 *
 * @version 1.0
 * @author Kaos
 */
 
// included files
if(is_file('Business Layer/Control.php'))
{
    require_once 'Business Layer/Control.php';
}

class Logger extends File
{
    public function log($type = null, $data = null)
    {
        try
        {
            switch($type)
            {
                case "get_log":
                {
                    $this->response = $this->get_data();
                    break;
                }
                case "save_log":
                {
                    $this->response = $this->save_log($data);
                    break;
                }
                default:
                {
                    $this->response = "Wrong logging operation services was called";
                }
            }
        }
        catch(Exception $e)
        {
            return $e->getMessage()." occured in logging operation";
        }
        
        return $this->response;
    }
    
    private function get_log()
    {
        $data = array("name" => getenv('SERVICE_LOG'), "text" => "");
        
        $this->response = File::Get_Control("read_file", $data);
        
        return $this->response;
    }
    
    private function save_log($service = null)
    {
        $log = strtoupper($service['response']['Message'])." with Request type ".$_SERVER['REQUEST_METHOD']." and IP ".$_SERVER['REMOTE_ADDR']." and server status {$service['response']['Status']} on {$service['response']['date']} by {$service['response']['time']}. \n\n";
        $data = array("name" => getenv('SERVICE_LOG'), "text" => $log);
                
        $response = File::Get_Control("update_file", $data);
        return "Service logged";
    }
}

?>