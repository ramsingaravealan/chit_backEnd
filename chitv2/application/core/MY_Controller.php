<?php

defined('BASEPATH') OR exit('No direct script access allowed');

//include APPPATH . "third_party/Twilio/autoload.php";
//use Twilio\Rest\Client;

class MY_Controller extends CI_Controller {

    public $decodedToken;

    public function __construct() {
        parent::__construct();
        $this->output->set_header('Access-Control-Allow-Origin: *');
        $this->output->set_header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization");
        $this->output->set_header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
        $this->output->set_content_type('application/json');
        $this->setTimeZone(-1);
        $this->load->helper('url');
        //$this->load->library('encryption');
        $this->load->library('JWT.php', '', 'JWT');
        $this->load->model('App');
        $token = $this->input->get_request_header('Authorization');
        $this->decodedToken = $this->decodeToken($token);
    }

    public function getKey() {
        return "CD39BAEAFBE2271270CD320E5CF703DC12FD7BD3E8949C939379D28B6A1138BD";
    }

    public function prepareToken($tokenData) {
        $tokenData['timeStamp'] = Date('Y-m-d h:i:s');
        $tokenData['status'] = 'OK';
        $jwtToken = $this->JWT->encode($tokenData, $this->getKey());
        return $jwtToken;
    }

    private function decodeToken($token) {
        try {
            $data = $this->JWT->decode($token, $this->getKey(), array('HS256'));
        } catch (\Exception $e) { // Also tried JwtException
            $data = (object) array(
                        'status' => 'error'
            );
        }

        return $data;
    }

    public function isExisting($email) {
        $result = TRUE;
        $data = $this->App->getFromDb(array(
            'from' => 'system_users',
            'where' => "su_email = '$email'"
        ));
        if (count($data) == 0) {
            $result = FALSE;
        }
        return $result;
    }

    public function getStoresQuery($custId) {
        $storeIds = $this->App->getFromDb(array(
            'from' => 'stores',
            'where' => "store_belongs_cust_id = '" . $custId . "'"
        ));
        $filter = " IN (-1)";
        $prefix = "";
        for ($index = 0; $index < count($storeIds); $index++) {
            if ($index == 0) {
                $prefix = " IN ('" . $storeIds[$index]->store_id . "'";
            } else {
                $prefix .= ",'" . $storeIds[$index]->store_id . "'";
            }
        }
        if (!empty($prefix)) {
            $prefix .= ")";
            $filter = $prefix;
        }

        return $filter;
    }

    public function addSystemUser($email, $type) {
        $this->App->insertDb(array(
            'su_email' => $email,
            'su_type' => $type
                ), 'system_users');
    }

    public function encode_shorcode($text, $affiliatecompany = "", $affiliateemail = "", $affiliatecontact = "", $representativecompanyname = "", $representativename = "", $representativeemail = "", $licenseename, $licenseeenmail = "", $confirmationlink = "", $resetpasswordlink = "", $enduserfullname = "", $enduseremail = "", $adminname = "", $adminemail = "", $enduserimage = "", $affiliateuserimage = "", $adminuserimage = "", $licenseeuserimage = "", $licenseefullname = "", $licenseecompanyname = "", $rankingcode = "") {
        $find = array("[", "]", "affiliatecompany", "affiliateemail", "affiliatecontact",
            "representativecompanyname", "representativename",
            "representativeemail", "licenseename",
            "licenseeenmail", "confirmationlink",
            "resetpasswordlink", "enduserfullname",
            "enduseremail", "adminname",
            "adminemail", "enduserimage",
            "affiliateuserimage", "adminuserimage",
            "licenseeuserimage", "licenseefullname",
            "licenseecompanyname", "rankingcode"
        );

        $replace = array("", "", $affiliatecompany, $affiliateemail, $affiliatecontact,
            $representativecompanyname, $representativename,
            $representativeemail, $licenseename,
            $licenseeenmail, $confirmationlink,
            $resetpasswordlink, $enduserfullname,
            $enduseremail, $adminname,
            $adminemail, $enduserimage,
            $affiliateuserimage, $adminuserimage,
            $licenseeuserimage, $licenseefullname,
            $licenseecompanyname, $rankingcode);

        return str_replace($find, $replace, $text);
    }

    public function encode_shorcode1($text, $affiliatecompany = "", $affiliateemail = "", $affiliatecontact = "", $representativecompanyname = "", $representativename = "", $representativeemail = "", $licenseename, $licenseeenmail = "", $confirmationlink = "", $resetpasswordlink = "", $enduserfullname = "", $enduseremail = "", $adminname = "", $adminemail = "", $enduserimage = "", $affiliateuserimage = "", $adminuserimage = "", $licenseeuserimage = "", $licenseefullname = "", $licenseecompanyname = "", $rankingcode = "", $activationlink = "") {
        $find = array("[", "]", "affiliatecompany", "affiliateemail", "affiliatecontact",
            "representativecompanyname", "representativename",
            "representativeemail", "licenseename",
            "licenseeenmail", "confirmationlink",
            "resetpasswordlink", "enduserfullname",
            "enduseremail", "adminname",
            "adminemail", "enduserimage",
            "affiliateuserimage", "adminuserimage",
            "licenseeuserimage", "licenseefullname",
            "licenseecompanyname", "rankingcode", "activationlink"
        );

        $replace = array("", "", $affiliatecompany, $affiliateemail, $affiliatecontact,
            $representativecompanyname, $representativename,
            $representativeemail, $licenseename,
            $licenseeenmail, $confirmationlink,
            $resetpasswordlink, $enduserfullname,
            $enduseremail, $adminname,
            $adminemail, $enduserimage,
            $affiliateuserimage, $adminuserimage,
            $licenseeuserimage, $licenseefullname,
            $licenseecompanyname, $rankingcode, $activationlink);

        return str_replace($find, $replace, $text);
    }

    public function setTimeZone($client_admin_id = 1) {
        if ($client_admin_id == -1) {
            date_default_timezone_set('America/Puerto_Rico');
        } else {
            $timeObj = $this->App->getFromDb(array(
                'from' => 'admin_settings',
                'where' => "as_id = '$client_admin_id'"
            ));

            if (count($timeObj) > 0) {
                date_default_timezone_set($timeObj[0]->as_time_zone);
            }
        }
    }

    public function endsWith($haystack, $needle) {
        $length = strlen($needle);
        if ($length == 0) {
            return true;
        }

        return (substr($haystack, -$length) === $needle);
    }

    public function logIt($log_by, $log_cid, $log_pid, $log_table, $log_type, $log_notes) {
        $this->setTimeZone($log_cid);
        $log_time = date("Y-m-d H:i:s");
        $this->App->insertDb(array(
            'log_by' => $log_by,
            'log_table' => $log_table,
            'log_pid' => $log_pid,
            'log_type' => $log_type,
            'log_notes' => $log_notes,
            'log_time' => $log_time,
            'log_cid' => $log_cid), 'logs');
    }

    public function send_email_bulk($text, $sendto, $subject = '') {


        $email = $sendto;


        $newphrase = $text;

        $smtparr = $this->App->getFromDb(array('from' => 'admin_settings', 'where' => "as_id = 1"));
        $smtp_mail_obj = $smtparr[0];
        //$srvar = explode(":", $smtp_mail_obj->server);
        $smtp_host = $smtp_mail_obj->as_smtp_host;
        $smtp_port = $smtp_mail_obj->as_smtp_port;

        $config['protocol'] = "smtp";
        if ($smtp_port == 465) {
            $config['smtp_host'] = "ssl://" . $smtp_host;
        } else if ($smtp_port == 587) {
            $config['smtp_host'] = "ssl://" . $smtp_host;
        } else {
            $config['smtp_host'] = $smtp_host;
        }
        $config['smtp_port'] = "$smtp_port";
        $config['smtp_user'] = $smtp_mail_obj->as_smtp_user_name;
        $config['smtp_pass'] = $smtp_mail_obj->as_smtp_pass;
        $config['charset'] = "utf-8";
        $config['mailtype'] = "html";
        $config['newline'] = "\r\n";
        $config['wordwrap'] = TRUE;
        $ci = get_instance();
        $ci->load->library('email');
        $ci->email->initialize($config);
        $ci->email->set_crlf("\r\n");
        //$ci->email->clear();
        //
        //$ci->email->set_newline("\r\n");
        //$ci->email->set_header('MIME-Version', '1.0; charset=utf-8'); //must add this line
        //$ci->email->set_header('Content-type', 'text/html'); //must add this line
//        if (empty($campaign_company)) {
//            $campaign_company = $smtp_mail_obj->as_smtp_extra;
//        }
        $ci->email->from($smtp_mail_obj->as_smtp_from, $smtp_mail_obj->as_smtp_extra);
        $list = $email;
        $ci->email->to($list);

        $this->email->reply_to($smtp_mail_obj->as_smtp_from, $smtp_mail_obj->as_smtp_extra);
        $ci->email->subject($subject);


        $ci->email->message($newphrase);
        return $r = $ci->email->send();
    }

    public function send_email($text, $sendto, $subject = '') {


        $email = $sendto;


        $newphrase = $text;

        $smtparr = $this->App->getFromDb(array('from' => 'admin_settings', 'where' => "as_id = 1"));
        $smtp_mail_obj = $smtparr[0];
        //$srvar = explode(":", $smtp_mail_obj->server);
        $smtp_host = $smtp_mail_obj->as_smtp_host;
        $smtp_port = $smtp_mail_obj->as_smtp_port;

        $config['protocol'] = "smtp";
        if ($smtp_port == 465) {
            $config['smtp_host'] = "ssl://" . $smtp_host;
        } else if ($smtp_port == 587) {
            $config['smtp_host'] = "ssl://" . $smtp_host;
        } else {
            $config['smtp_host'] = $smtp_host;
        }
        $config['smtp_port'] = "$smtp_port";
        $config['smtp_user'] = $smtp_mail_obj->as_smtp_user_name;
        $config['smtp_pass'] = $smtp_mail_obj->as_smtp_pass;
        $config['charset'] = "utf-8";
        $config['mailtype'] = "html";
        $config['newline'] = "\r\n";
        $config['wordwrap'] = TRUE;
        $ci = get_instance();
        $ci->load->library('email');
        $ci->email->initialize($config);
        $ci->email->set_crlf("\r\n");
        //$ci->email->clear();
        //
        //$ci->email->set_newline("\r\n");
        //$ci->email->set_header('MIME-Version', '1.0; charset=utf-8'); //must add this line
        //$ci->email->set_header('Content-type', 'text/html'); //must add this line
//        if (empty($campaign_company)) {
//            $campaign_company = $smtp_mail_obj->as_smtp_extra;
//        }
        $ci->email->from($smtp_mail_obj->as_smtp_from, $smtp_mail_obj->as_smtp_extra);
        $list = array($email);
        $ci->email->to($list);

        $this->email->reply_to($smtp_mail_obj->as_smtp_from, $smtp_mail_obj->as_smtp_extra);
        $ci->email->subject($subject);


        $ci->email->message($newphrase);
        return $r = $ci->email->send();
    }

    public function sendMessage($tokens, $message) {

        //$this->autoRender = false;
        $fields = array(
            'registration_ids' => $tokens,
            'data' => $message,
            'notification' => $message
        );
        //echo json_encode($fields);
        return $this->sendPushNotification($fields);
    }

    public function sendMessageAndroid($tokens, $message) {

        //$this->autoRender = false;
        $fields = array(
            'registration_ids' => $tokens,
            'data' => $message,
        );
        //echo json_encode($fields);
        return $this->sendPushNotification($fields);
    }

    private function sendPushNotification($fields) {
        //$this->autoRender = false;
        //importing the constant files
        //firebase server url to send the curl request
        $url = 'https://fcm.googleapis.com/fcm/send';

        //building headers for the request
        $headers = array(
            'Authorization: key=' . 'AAAAdTGSQnM:APA91bEqEQDLzEf86wz4XA8hIlgRGsppgaFpO0gmOKcHxa6p-qXsdSixeJmrs5VY-Ag5PBQdRReRV2FDGSqk-we-0PawF33Qm-MGYYo6cgmT5KE64IYhnAsIAfXjzFcCoRY8ZCCuiC3I',
            'Content-Type: application/json'
        );

        //Initializing curl to open a connection
        $ch = curl_init();

        //Setting the curl url
        curl_setopt($ch, CURLOPT_URL, $url);

        //setting the method as post
        curl_setopt($ch, CURLOPT_POST, TRUE);

        //adding headers 
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

        //disabling ssl support
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        //adding the fields in json format 
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

        curl_setopt($ch, CURLOPT_TIMEOUT, 500);
        curl_setopt($ch, CURLOPT_NOSIGNAL, 1);

        //finally executing the curl request 
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }

        //Now close the connection
        curl_close($ch);

        //and return the result 
        //echo $result;
        return $result;
    }

    public function sendTwilioCurlPost($url, $fields) {
        //$this->autoRender = false;
        //importing the constant files
        //firebase server url to send the curl request
        // $url = 'https://bridgeisp.com:3000/send_notification';
        //building headers for the request
        $headers = array(
            'Content-Type: application/json'
        );

        //Initializing curl to open a connection
        $ch = curl_init();

        //Setting the curl url
        curl_setopt($ch, CURLOPT_URL, $url);

        //setting the method as post
        curl_setopt($ch, CURLOPT_POST, TRUE);

        //adding headers 
        //curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

        curl_setopt($ch, CURLOPT_USERPWD, 'AC70088eaf22fe8f58c0ad2f04ca632d15' . ':' . 'ae96adc7fddbe8a8d00a153e3597f73b');

        //disabling ssl support
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        //adding the fields in json format 
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($fields));


        curl_setopt($ch, CURLOPT_TIMEOUT, 500);
        curl_setopt($ch, CURLOPT_NOSIGNAL, 1);

        //finally executing the curl request 
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }

        //Now close the connection
        curl_close($ch);

        //and return the result 
        //echo $result;
        return json_decode($result);
    }

    public function sendTwilioCurlGet($url) {
        //$this->autoRender = false;
        //importing the constant files
        //firebase server url to send the curl request
        //$url = 'https://mediredpr.com:3000/send_notification_to_channel';
        //building headers for the request
        $headers = array(
            'Content-Type: application/json'
        );

        //Initializing curl to open a connection
        $ch = curl_init();

        //Setting the curl url
        curl_setopt($ch, CURLOPT_URL, $url);

        //setting the method as post
        //curl_setopt($ch, CURLOPT_POST, TRUE);
        //adding headers 
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

        curl_setopt($ch, CURLOPT_USERPWD, 'AC70088eaf22fe8f58c0ad2f04ca632d15' . ':' . 'ae96adc7fddbe8a8d00a153e3597f73b');

        //disabling ssl support
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        //adding the fields in json format 
        //curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

        curl_setopt($ch, CURLOPT_TIMEOUT, 500);
        curl_setopt($ch, CURLOPT_NOSIGNAL, 1);

        //finally executing the curl request 
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }

        //Now close the connection
        curl_close($ch);

        //and return the result 
        //echo $result;
        return json_decode($result);
    }

}
