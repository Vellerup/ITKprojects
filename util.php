<?php
/**
 * Created by PhpStorm.
 * User: Vellerup
 * Date: 22/01/16
 * Time: 22.06
 */

include_once("creds.inc");

/*
function get_credentials(){
    $credentials = "xxx@xxxx.dk:xxxxx";
    $headers = array(
        "Content-type: application/xml",
        "Accept: application/xml",
        "Authorization: Basic " . base64_encode($credentials)
    );
    return $headers;

}
*/

//$user_agent = "Martin Vellerup";
function post_harvest($url, $xml_data){
    $headers = get_credentials();
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_VERBOSE, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_USERAGENT, "YOUR DESCRIPTIVE NAME GOES HERE");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_data);

    $data = curl_exec($ch);
    if (curl_errno($ch)) {
        print "Error: " . curl_error($ch);
    } else {
        // Show me the result
        var_dump($data);
        curl_close($ch);
    }


}


function get_harvest($url){
    //echo $url;
    /*
     *
     $credentials = "";
    $headers = array(
        "Content-type: application/xml",
        "Accept: application/xml",
        "Authorization: Basic " . base64_encode($credentials)
    );
*/
    $headers = get_credentials();
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_VERBOSE, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_USERAGENT, "Martin Vellerup");

    $data = curl_exec($ch);
    curl_close($ch);



    return $data;





}

function get_project(){
    //echo "dette er en test3";
  

    $api_url = $jiraurl . '/rest/api/latest/project';


    $ch = curl_init();
    curl_setopt_array($ch, array(
        CURLOPT_URL => $api_url,
        CURLOPT_USERPWD => $username . ':' . $password,
        CURLOPT_RETURNTRANSFER => true
    ));
    $result = curl_exec($ch);
    curl_close($ch);
    //convert JSON data back to PHP array
    //echo $result;
    return json_decode($result);
}



?>
