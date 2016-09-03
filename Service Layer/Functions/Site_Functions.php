<?php

/**
 * Site functions short summary.
 *
 * Site functions description.
 *
 * @version 1.0
 * @author Kaos
 */

if(!is_file("Functions.php"))
{
    require_once 'Functions.php';
}

class Site_Functions extends Functions
{
    static private $response;
    
    private function format_service_data($request = array())
    {
        foreach($request as $data => $post)
        {
            if($data == "type" || $data == "services")
            {
                $info[$data] = $post;
            }
            elseif($data != "type" || $data != "services")
            {
                $info['data'][$data] = $post;
            }
        }
        unset($request);
        return $info;
    }

    protected function check_request_method($request = array())
    {
        $Variable = new Variables();
        
        switch($_SERVER['REQUEST_METHOD'])
            {
                case "POST":
                {
                    if(in_array($request['type'], $Variable->Method[$_SERVER['REQUEST_METHOD']]))
                    {
                        $this->response = self::get_request(self::format_service_data($request));
                    }
                    else
                    {
                        //HEADER TYPE
                        header("HTTP/1.1 501 Not Implemented");
                        header_output();
                        header('Content-Type: application/json');

                        $response['response'] = array(
                            "Status" => "501",
                            'Message' => "Not Implemented",
                            'date' => date("d:m:y"),
                            'time' => date("G.i:s", time()),
                            'output' => "Server did not either recognize the request or it lacks ability to fulfill the request",
                        );
                        $this->response = json_encode($response, JSON_PRETTY_PRINT);
                    }
                    break;
                }
                case "GET":
                {
                    if(in_array(@ $request['type'], $Variable->Method[$_SERVER['REQUEST_METHOD']]))
                    {
                        $this->response = self::get_request(self::format_service_data($request));
                    }
                    else
                    {
                        //HEADER TYPE
                        header("HTTP/1.1 501 Not Implemented");
                        header_output();
                        header('Content-Type: application/json');

                        $response['response'] = array(
                            "Status" => "501",
                            'Message' => "Not Implemented",
                            'date' => date("d:m:y"),
                            'time' => date("G.i:s", time()),
                            'output' => "Server did not either recognize the request or it lacks ability to fulfill the request",
                        );
                        $this->response = json_encode($response, JSON_PRETTY_PRINT);
                    }
                    break;
                }
                default:
                {
                    //HEADER TYPE
                    header("HTTP/1.1 501 Not Implemented");
                    header_output();
                    header('Content-Type: application/json');

                    $response['response'] = array(
                        "Status" => "501",
                        'Message' => "Not Implemented",
                        'date' => date("d:m:y"),
                        'time' => date("G.i:s", time()),
                        'output' => "Server did not either recognize the request or it lacks ability to fulfill the request",
                    );
                    $this->response = json_encode($response, JSON_PRETTY_PRINT);
                }
            }
        
        unset($Variable);
        return $this->response;
    }
    
    //server request funtion
    private function get_request($method = array()) 
    {
        if(!empty($method['type']) && !empty($method['data']))
        {
            // send feedback
            return self::send_reponse(200, $method['type'], parent::Services_Checker($method, $_FILES));
        
        }
        elseif(empty($method['type']) && !empty($method['data']))
        {
            return parent::send_reponse(503, "Service Unavailable", "Service unavailable due to wrong service type used");
        }
        
    }
        
    // SERVER REPONSE FUNCTION
    private function send_reponse($status, $staus_message, $data) 
    {
        //header("Content-Type: application/json");
        if($data !== null && $data !== "Service Not Found")
        {
           //HEADER TYPE
            header("HTTP/1.1 $status $staus_message");
            header_output();
            header('Content-Type: application/json');

            $response['response'] = array(
                "Status" => $status,
                'Message' => $staus_message,
                'date' => date("d:m:y"),
                'time' => date("G.i:s", time()),
                'output' => $data,
            );
        }
        elseif($data !== null && $data === "Service Not Found")
        {
           //HEADER TYPE
            header("HTTP/1.1 501 $data");
            header_output();
            header('Content-Type: application/json');

            $response['response'] = array(
                "Status" => "501",
                'Message' => "Not Implemented",
                'date' => date("d:m:y"),
                'time' => date("G.i:s", time()),
                'output' => "Server did not either recognize the request or it lacks ability to fulfill the request",
            );
        }
        elseif($data === null)
        {
           //HEADER TYPE
            header("HTTP/1.1 500 Internal server error");
            header_output();
            header('Content-Type: application/json');

            $response['response'] = array(
                "Status" => "500",
                'Message' => "Internal server error",
                'date' => date("d:m:y"),
                'time' => date("G.i:s", time()),
                'output' => "Service processing due to lack of data or server error",
                );
        }
        
        return json_encode($response, JSON_PRETTY_PRINT);
        //exit();
    }
        
    
}