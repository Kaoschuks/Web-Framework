<?php
/**
 * Service short summary.
 *
 * Service description.
 *
 * @version 1.0
 * @author Kaos
 */

if(is_file("Service Layer/Functions/Site_Functions.php"))
{
    require_once 'Service Layer/Functions/Site_Functions.php';
}

class Service extends Site_Functions
{
    public $response;
    
    protected function Check_Access()
    {
        @ Session::Session();
        return Session::session_check();
    }
    
    protected function Auth_User($data = array())
    {
        if($data['user'] !== 'admin' && $data['pass'] !== 'pass')
        {
            header("WWW-Authenticate: Basic realm =\"Server Access\"");
            
            //HEADER TYPE
            header("HTTP/1.1 401 Unauthorized");
            header_output();
            header('Content-Type: application/json');

            $response['status'] = array(
                "responseStatus" => "401",
                'statusMessage' => "Authentication to server rest server failed",
                'date' => date("d:m:y"),
                'time' => date("G.i:s", time()),
                );
            header("location: 401");
        }
        elseif($data['user'] === 'admin' && $data['pass'] == 'pass')
        {
            return "access granted";
        }
    }
    
    public function Site_Services($request = array())
    {
        //print_r($request);
        //firewall_include();
		$this->response = parent::check_request_method($request);
            
        $data = json_decode($this->response, true);
        if(@ is_array($data['output']['data']))
        {
            unset($data['output']);
        }
        self::logs($data);
        return $this->response;
    }
    
    private function logs($data)
    {
        $log = new Logger();
        $logs = $log->log("save_log", $data);
        unset($data);
        unset($log);
    }
}

function process($data = array())
{
    $services = new Service();
    return $services->Site_Services($data);
}
