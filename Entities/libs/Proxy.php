<?php
function ipProxy($url)
{
    $proxies = array(); // Declaring an array to store the proxy list

    // Adding list of proxies to the $proxies array
    //$proxies[] = 'user:password@173.234.11.134:54253';  // Some proxies require user, password, IP and port number
    //$proxies[] = 'user:password@173.234.120.69:54253';
    //$proxies[] = 'user:password@173.234.46.176:54253';
    $proxies[] = '173.234.92.107';  // Some proxies only require IP
    $proxies[] = '173.234.93.94';
    //$proxies[] = '173.234.94.90:54253'; // Some proxies require IP and port number
    //$proxies[] = '69.147.240.61:54253';

    // Choose a random proxy
    if (isset($proxies)) {  // If the $proxies array contains items, then
        $proxy = $proxies[array_rand($proxies)];    // Select a random proxy from the array and assign to $proxy variable
    }
    $ch = curl_init();  // Initialise a cURL handle

    // Setting proxy option for cURL
    if (isset($proxy)) {    // If the $proxy variable is set, then
        curl_setopt($ch, CURLOPT_PROXY, $proxy);    // Set CURLOPT_PROXY with proxy in $proxy variable
    }

    // Set any other cURL options that are required
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_COOKIESESSION, TRUE);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_URL, $url);

    $results = curl_exec($ch);  // Execute a cURL request
    curl_close($ch);    // Closing the cURL handle
    return $results;
}

?>