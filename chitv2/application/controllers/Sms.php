<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Sms extends MY_Controller {

    public function __construct() {
        parent::__construct();
        //$this->load->helper('sendsms_helper');
    }
//    public function sendsms($mobileno, $message){
//
//    $message = urlencode($message);
//    $sender = 'SEDEMO'; 
//    $apikey = ' 6ojfpx3g160a1vv2279dtl3m42x9qekd';
//    $baseurl = 'https://instantalerts.co/api/web/send?apikey=6ojfpx3g160a1vv2279dtl3m42x9qekd'.$apikey;
//
//    $url = $baseurl.'&sender='.$sender.'&to='.$mobileno.'&message='.$message;    
//    $ch = curl_init();
//    curl_setopt($ch, CURLOPT_POST, false);
//    curl_setopt($ch, CURLOPT_URL, $url);
//    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//    $response = curl_exec($ch);
//    curl_close($ch);
//
//    // Use file get contents when CURL is not installed on server.
//    if(!$response){
//        $response = file_get_contents($url);
//    } 
//}
function sms_code_send()
    {
//    $username   = 'springedgedemo';
//    $password   = '9ot3HDsp#2';
//    $originator = 'demo';
//    $message    = 'Welcom to ......, your activation code is : '.$message;
//    //set POST variables
//    $url = 'https://instantalerts.co/api/web/send?apikey=6ojfpx3g160a1vv2279dtl3m42x9qekd&sender=SEDEMO&to=918807202105&message=Hello%2C+this+is+a+test+message+from+spring+edge';
//
//    $fields = array(
//      'username'   => urlencode($username),
//      'password'   => urlencode($password),
//      'originator' => urlencode($originator),
//      'phone'      => urlencode($number),
//      'msgtext'    => urlencode($message)
//     );
//
//    $fields_string = '';
//
//    //url-ify the data for the POST
//    foreach($fields as $key=>$value)
//    {
//      $fields_string .= $key.'='.$value.'&';
//    }
//
//    rtrim($fields_string,'&');
//
//    //open connection
//    $ch = curl_init();
//
//    //set the url, number of POST vars, POST data
//    curl_setopt($ch,CURLOPT_URL,$url);
//    curl_setopt($ch,CURLOPT_POST,count($fields));
//    curl_setopt($ch,CURLOPT_POSTFIELDS,$fields_string);
//
//    //execute post
//    $result = curl_exec($ch);
//
//    //close connection
//    curl_close($ch);
//    return $result;
    
//    $message = urlencode('Hi, this is a test message');
//    $mobileno='8300904870';
//$sender = 'SEDEMO'; 
//$apikey = 'NTQ0ODcxNTk3NDZlNTc3MzRmMzQ2ZTc0Njk2ZTZkNGU=';
//$baseurl = 'http://web.springedge.com/api/web/send?apikey='.$apikey;
//
//$url = $baseurl.'&sender='.$sender.'&to='.$mobileno.'&message='.$message;    
//$ch = curl_init();
//curl_setopt($ch, CURLOPT_POST, false);
//curl_setopt($ch, CURLOPT_URL, $url);
//curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//$response = curl_exec($ch);
//curl_close($ch);
    $apiKey = urlencode('NTg3MzY4NjQ2ZTMxNjU2NzY3NmUzNjYxNmE1NTM1Mzc=');
// Message details
$numbers = array(918300904870);
$sender = urlencode('600010');
$message = rawurlencode('Hi there, thank you for sending your first test message from Textlocal. Get 20% off today with our code: ');
 
$numbers = implode(',', $numbers);
 
// Prepare data for POST request
$data = array('apikey' => $apiKey, 'numbers' => $numbers, "sender" => $sender, "message" => $message);
// Send the POST request with cURL
$ch = curl_init('https://api.textlocal.in/send/');
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);
// Process your response here
echo $response;
}
}