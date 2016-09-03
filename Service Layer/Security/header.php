<?php

function cors_header()
{
    // Allow from any origin
    if (isset($_SERVER['HTTP_ORIGIN'])) {
        // Decide if the origin in $_SERVER['HTTP_ORIGIN'] is one
        // you want to allow, and if so:
        $origin = $_SERVER['HTTP_ORIGIN'];
        header("Access-Control-Allow-Origin: $origin");
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');    // cache for 1 day
    }

    // Access-Control headers are received during OPTIONS requests
    if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') 
    {
        if(isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
        
        if(isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
            header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
    }
    
}

function security_headers()
{
    //unset($_SERVER['HTTP_COOKIE']);
    if($_SERVER['REQUEST_SCHEME'] === "https")
    {
        header('Public-Key-Pins: pin-sha256="d6qzRu9zOECb90Uez27xWltNsj0e1Md7GkYYkVoZWmM=";pin-sha256="E9CZ9INDbd+2eRQozYqqbQ2yXLVKB9+xcprMF+44U1g=";max-age=604800; includeSubDomains; report-uri="https://example.net/pkp-report"');
        header("Strict-Transport-Security: max-age=31536000");
    }
    ini_set('session.cookie_httponly', 1);
    ini_set('session.use_only_cookies', true);
    ini_set('session.cookie_secure', 1);
    ini_set('session.hash_function', sha512);
    ini_set('session.hash_bits_per_character', 5);
    ini_set('session.entropy_file', '/dev/urandom');
} 

function caching_header()
{
    //get the last-modified-date of this very file
    $lastModified=filemtime(__FILE__);
    //get a unique hash of this file (etag)
    $etagFile = md5_file(__FILE__);
    //get the HTTP_IF_MODIFIED_SINCE header if set
    $ifModifiedSince=(isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) ? $_SERVER['HTTP_IF_MODIFIED_SINCE'] : false);
    //get the HTTP_IF_NONE_MATCH header if set (etag: unique file hash)
    $etagHeader=(isset($_SERVER['HTTP_IF_NONE_MATCH']) ? trim($_SERVER['HTTP_IF_NONE_MATCH']) : false);

    //set last-modified header
    header("Last-Modified: ".gmdate("D, d M Y H:i:s", $lastModified)." GMT");
    //set etag-header
    header("Etag: $etagFile");
    
    $seconds_to_cache = 3600;
    $ts = gmdate("D, d M Y H:i:s", time() + $seconds_to_cache) . " GMT";
    //header("Expires: $ts");
    header('Expires: ' . gmdate('D, d M Y H:i:s', time()+1*4*3600) . ' GMT');
    header("Pragma: cache");
    header("Cache-Control: max-age=$seconds_to_cache");

    //check if page has changed. If not, send 304 and exit
    if (@strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE'])==$lastModified || $etagHeader == $etagFile)
    {
           header("HTTP/1.1 304 Not Modified");
    }
    if (function_exists('header_remove')) 
    {
        header_remove('X-Powered-By'); // PHP 5.3+
    } else {
        @ini_set('expose_php', 'off');
    }
}

function firewall_include()
{
    if(@fsockopen($_SERVER['REMOTE_ADDR'], 80, $errstr, $errno, 1))
die("Proxy access not allowed");
    @ define('PHP_FIREWALL_REQUEST_URI', strip_tags( $_SERVER['REQUEST_URI']));
	@ define('PHP_FIREWALL_ACTIVATION', true );
	
    if(is_readable('Service Layer/Security/firewall.php'))
    {
		require_once 'Service Layer/Security/firewall.php';
    }
}

function malicous_request()
{
    $request_uri = $_SERVER['REQUEST_URI'];
    $query_string = $_SERVER['QUERY_STRING'];
    $user_agent = $_SERVER['HTTP_USER_AGENT'];

    // request uri
    if (	//strlen($request_uri) > 255 || 
        stripos($request_uri, 'eval(') || 
        stripos($request_uri, 'CONCAT') || 
        stripos($request_uri, 'UNION+SELECT') || 
        stripos($request_uri, '(null)') || 
        stripos($request_uri, 'base64_') || 
        stripos($request_uri, '/localhost') || 
        stripos($request_uri, '/pingserver') || 
        stripos($request_uri, '/config.') || 
        stripos($request_uri, '/wwwroot') || 
        stripos($request_uri, '/makefile') || 
        stripos($request_uri, 'crossdomain.') || 
        stripos($request_uri, 'proc/self/environ') || 
        stripos($request_uri, 'etc/passwd') || 
        stripos($request_uri, '/https/') || 
        stripos($request_uri, '/http/') || 
        stripos($request_uri, '/ftp/') || 
        stripos($request_uri, '/cgi/') || 
        stripos($request_uri, '.cgi') || 
        stripos($request_uri, '.exe') || 
        stripos($request_uri, '.sql') || 
        stripos($request_uri, '.ini') || 
        stripos($request_uri, '.dll') || 
        stripos($request_uri, '.asp') || 
        stripos($request_uri, '.jsp') || 
        stripos($request_uri, '/.bash') || 
        stripos($request_uri, '/.git') || 
        stripos($request_uri, '/.svn') || 
        stripos($request_uri, '/.tar') || 
        stripos($request_uri, ' ') || 
        stripos($request_uri, '<') || 
        stripos($request_uri, '>') || 
        stripos($request_uri, '/=') || 
        stripos($request_uri, '...') || 
        stripos($request_uri, '+++') || 
        stripos($request_uri, '://') || 
        stripos($request_uri, '/&&') || 
        // query strings
        stripos($query_string, '?') || 
        stripos($query_string, ':') || 
        stripos($query_string, '[') || 
        stripos($query_string, ']') || 
        stripos($query_string, '../') || 
        stripos($query_string, '127.0.0.1') || 
        stripos($query_string, 'loopback') || 
        stripos($query_string, '%0A') || 
        stripos($query_string, '%0D') || 
        stripos($query_string, '%22') || 
        stripos($query_string, '%27') || 
        stripos($query_string, '%3C') || 
        stripos($query_string, '%3E') || 
        stripos($query_string, '%00') || 
        stripos($query_string, '%2e%2e') || 
        stripos($query_string, 'union') || 
        stripos($query_string, 'input_file') || 
        stripos($query_string, 'execute') || 
        stripos($query_string, 'mosconfig') || 
        stripos($query_string, 'environ') || 
        //stripos($query_string, 'scanner') || 
        stripos($query_string, 'path=.') || 
        stripos($query_string, 'mod=.') || 
        // user agents
        stripos($user_agent, 'binlar') || 
        stripos($user_agent, 'casper') || 
        stripos($user_agent, 'cmswor') || 
        stripos($user_agent, 'diavol') || 
        stripos($user_agent, 'dotbot') || 
        stripos($user_agent, 'finder') || 
        stripos($user_agent, 'flicky') || 
        stripos($user_agent, 'libwww') || 
        stripos($user_agent, 'nutch') || 
        stripos($user_agent, 'planet') || 
        stripos($user_agent, 'purebot') || 
        stripos($user_agent, 'pycurl') || 
        stripos($user_agent, 'skygrid') || 
        stripos($user_agent, 'sucker') || 
        stripos($user_agent, 'turnit') || 
        stripos($user_agent, 'vikspi') || 
        stripos($user_agent, 'zmeu')
    ) 
    {
        header('HTTP/1.1 403 Forbidden');
        header('Status: 403 Forbidden');
        header('Connection: Close');
        exit;
    }
}

function header_output()
{        
    cors_header();
    security_headers();
    firewall_include();
}
?>