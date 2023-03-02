<?php

defined('BASEPATH') OR exit('No direct script access allowed');

//include APPPATH . "third_party/Twilio/autoload.php";
//use Twilio\Rest\Client;

class MY_LoginController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->output->set_header('Access-Control-Allow-Origin: *');
        $this->output->set_header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization");
        $this->output->set_header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
        $this->output->set_content_type('application/json');
        //$this->load->library('encrypt');
        $this->setTimeZone(-1);
        $this->load->helper('url');
        $this->load->library('JWT.php', '', 'JWT');
        $this->load->model('App');
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

    public function decodeToken($token) {
        try {
            $data = $this->JWT->decode($token, $this->getKey(),array('HS256'));
        } catch (\Exception $e) { // Also tried JwtException
            $data = array(
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
                'from' => 'customer',
                'where' => "c_id = '$client_admin_id'"
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

    private function sendPushNotification($fields) {
        //$this->autoRender = false;
        //importing the constant files
        //firebase server url to send the curl request
        $url = 'https://fcm.googleapis.com/fcm/send';

        //building headers for the request
        $headers = array(
            'Authorization: key=' . 'AAAAr831Il8:APA91bEaMPLjmhdVfi94GTeyqsjkETBb05Qv8OKIUqjtrAIGmzgyfdt_6QCUgAAAAL6_pRljrbFqIYJ0vaylVIFZ-WDBbpV2xMkHo8mPvs_0l0WNTvXhA26mR8pU-hn03Vq63ixbgIXE',
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

}
