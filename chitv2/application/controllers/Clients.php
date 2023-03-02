<?php

defined('BASEPATH') OR exit('No direct script access allowed');

//include APPPATH . "third_party/Twilio/autoload.php";
//use Twilio\Rest\Client;
require_once APPPATH . 'core/MY_LoginController.php';

class Clients extends MY_LoginController {

    public function __construct() {
        parent::__construct();
          header("Access-Control-Allow-Origin: *");
        header("Access-Control-Request-Headers: GET,POST,OPTIONS,DELETE,PUT");
        header("Access-Control-Allow-Headers: authorization, Content-Type");
    }

    public function logintoken() {
        $tokenData = array();
        $tokenData['uniqueId'] = '251';
        $tokenData['role'] = 'ramrajesh';
        //$tokenData['timeStamp'] = Date('Y-m-d h:i:s');
        //$jwtToken = $this->JWT->encode($tokenData, $this->getKey());
        //$enc = $this->encryption->encrypt($jwtToken);
        //echo $enc;
        //$decoded = $this->JWT->decode($this->encryption->decrypt("22dbfd9da641f6359f74447e043ea7f3f8b4d8b161fd41b3be926af52974fbcf0aa8db06a13117f4ecf80ad8d89fa3cd4804f9a13e70b547258035a66b127f42uVdVnAytAgGrFMZw8aoFinwKN0xMQi/v6cqPtU8d3B4B4EwuC7jcfrYpd3IyfrJ2RocXGA52XzU1u3r5J+e9p8oIaEzE1Wh6t2k0SLxvob6o56HZxlErHGI1GQIxSDLwrl1lx0dKhCHD4C0o10FkonaR8/K8WRfkL0GjyQS3LC3M8LpDAImtbHaFyrGArMo+AGLvWxylhwIFJ3yFYdkZsw=="), $this->getKey(),array('HS256'));
        //echo json_encode(array('Token'=>$jwtToken));
        //$decoded = array();
        //$key = bin2hex($this->encryption->create_key(16));
        //$this->output->set_output(json_encode(array('Token'=>'$enc', 'Decoded'=>$decoded), JSON_PRETTY_PRINT));
    }

    public function get_dashboard() {
        $this->load->helper('string');
        $obj = new stdClass();
        $obj->status = "FAILED";
        $obj->message = "";
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);

        if ($request) {
            $obj->status = "OK";
            $clientsQuery = "cc_id > 0";
            $regionsQuery = "reg_id > 0";
            $repsQuery = "aff_id > 0";
            $endUsersQuery = "eu_id > 0";
            if (isset($request->login_type)) {
//                if ($request->login_type == 'Aff') {
//                    $rep = $this->App->getFromDb(array(
//                        'from' => 'clientusers',
//                        'where' => "cu_id = '" . $request->login_id . "'"
//                    ));
//                    $query = "cc_id = '" . $rep[0]->cu_company_id . "'";
//                    $obj->query = $query;
//                } else if ($request->login_type == 'Lisensee') {
//
//                    $affs = $this->App->getFromDb(array(
//                        'from' => 'affiliates',
//                        'where' => "aff_licsense_id = '" . $request->login_id . "'"
//                    ));
//                    $c = "(";
//                    $index = 0;
//                    foreach ($affs as $aff) {
//                        if ($index == 0) {
//                            $c = "( '" . $aff->aff_id . "'";
//                        } else {
//                            $c = $c . ", '" . $aff->aff_id . "'";
//                        }
//                        $index = $index + 1;
//                    }
//                    $c = $c . ")";
//                    $query = "cc_aff_company IN $c";
//                    $obj->query = $query;
//                } else if ($request->login_type == 'Rep') {
//                    $rep = $this->App->getFromDb(array(
//                        'from' => 'affiliateusers',
//                        'where' => "affu_id = '" . $request->login_id . "'"
//                    ));
//                    //$query = "cu_company_id = '" . $rep[0]->affu_company . "'";
//                    $affs = $this->App->getFromDb(array(
//                        'from' => 'affiliates',
//                        'where' => "aff_id = '" . $rep[0]->affu_company . "'"
//                    ));
//                    $c = "(";
//                    $index = 0;
//                    foreach ($affs as $aff) {
//                        if ($index == 0) {
//                            $c = "( '" . $aff->aff_id . "'";
//                        } else {
//                            $c = $c . ", '" . $aff->aff_id . "'";
//                        }
//                        $index = $index + 1;
//                    }
//                    $c = $c . ")";
//                    $query = "cc_aff_company IN $c";
//                    $obj->query = $query;
//                    //$obj->query = $query;
//                }  
            }
            $clients = $this->App->getFromDb(array('from' => 'clientcompanies',
                'fields' => "cc_id",
                'where' => $clientsQuery));
            $regions = $this->App->getFromDb(array('from' => 'regions',
                'fields' => "reg_id",
                'where' => $regionsQuery));
            $reps = $this->App->getFromDb(array('from' => 'affiliates',
                'fields' => "aff_id",
                'where' => $repsQuery));
            $endUsers = $this->App->getFromDb(array('from' => 'endusers',
                'fields' => "eu_id",
                'where' => $endUsersQuery));
            $obj->clients = count($clients);
            $obj->regions = count($regions);
            $obj->reps = count($reps);
            $obj->endUsers = count($endUsers);
        }
        $this->output->set_output(json_encode($obj, JSON_PRETTY_PRINT));
    }
    
    
    public function get_audio_save() {
        $this->load->helper('string');
        $obj = new stdClass();
        $obj->status = "FAILED";
        $obj->message = "";
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);

        if ($request) {
            $obj->status = "OK";
            $extn = $request->extn;
            $guard_photo = $request->audio;

            //if (!$this->endsWith($guard_photo, $extn)) {
                $img = "AUD" . "_" . random_string('alnum', 16) . ".".$extn;
                $data_img = explode(',', $guard_photo);
                $decoded = base64_decode($data_img[1]);

                file_put_contents(UPLOAD_PATH . $img, $decoded);
                //$request->audio = $img;
                //$guard_photo = $request->audio;
                $obj->file_name = $img;
            //}


            $obj->message = "File Received";
        }


        $this->output->set_output(json_encode($obj, JSON_PRETTY_PRINT));
    }

    public function get_photo_save() {
        $this->load->helper('string');
        $obj = new stdClass();
        $obj->status = "FAILED";
        $obj->message = "";
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);

        if ($request) {
            $obj->status = "OK";
            $guard_photo = $request->photo;

            if (!$this->endsWith($guard_photo, ".png")) {
                $img = "IMG" . "_" . random_string('alnum', 16) . ".png";
                $data_img = explode(',', $guard_photo);
                $decoded = base64_decode($data_img[1]);

                file_put_contents(UPLOAD_PATH . $img, $decoded);
                $request->photo = $img;
                $guard_photo = $request->photo;
                $obj->file_name = $img;
            }


            $obj->message = "File Received";
        }


        $this->output->set_output(json_encode($obj, JSON_PRETTY_PRINT));
    }
    
    public function get_file_save() {
        $this->load->helper('string');
        $obj = new stdClass();
        $obj->status = "FAILED";
        $obj->message = "";
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);

        if ($request) {
            $obj->status = "OK";
            $extn = $request->extn;
            $guard_photo = $request->photo;

            //if (!$this->endsWith($guard_photo, $extn)) {
            $img = "FILE" . "_" . random_string('alnum', 16) . "." . $extn;
            $data_img = explode(',', $guard_photo);
            $decoded = base64_decode($data_img[1]);

            file_put_contents(UPLOAD_PATH . $img, $decoded);
            //$request->audio = $img;
            //$guard_photo = $request->audio;
            $obj->file_name = $img;
            //}


            $obj->message = "File Received";
        }


        $this->output->set_output(json_encode($obj, JSON_PRETTY_PRINT));
    }

   

    public function change_pass() {
        $obj = new stdClass();
        $obj->status = "FAILED";
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);
        if ($request) {
//            $type = $request->user_type;
            $id = $request->id;
            $user_email = trim($request->user_email);
            $user_password = trim($request->user_password);
            if ($user_email == $user_email) {
//                if ($type == 'aff') {
                    $this->App->updateDb(
                            array('from' => "users", 'where' => "user_id = 's'",
                                'data' => array(
                                    'user_password' => $user_password
                    )));
                    $obj->status = 'OK';
                    $obj->message = "Password Changed Successfully";
//                }
            } else {
                $obj->status = "FAILED";
                $obj->message = "Password does not match";
            }
        }

        $this->output->set_output(json_encode($obj, JSON_PRETTY_PRINT));
    }

    public function checklogin() {
        
        $obj = new stdClass();
        $obj->status = "FAILED";
        $obj->message = "Username or Password is wrong";
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);

        if ($request) {

            $user_email = $request->user_email;
            $user_password = trim($request->user_password);
            //$user_password = password_hash(trim($request->user_password),PASSWORD_BCRYPT);
            $ip = $this->input->ip_address();
            //$obj->ip = $ip;
//            $userObj = $this->App->getFromDb(array(
//                'from' => 'system_users,users',
//                'fields' => "*,user_id AS id",
//                'where' => "su_email = '$user_email' AND user_email = su_email AND user_active = 'Y'",
//            ));
//            $custObj = $this->App->getFromDb(array(
//                'from' => 'system_users, customer_users',
//                'fields' => "*,cuser_id AS id",
//                'where' => "su_email = '$user_email' AND cuser_email = su_email AND cuser_active = 'Y'",
//            ));
            $userObj = $this->App->getFromDb(array(
                'from' => 'users',
                'fields' => "*,user_id AS id",
                'where' => "user_email = '$user_email'",
            ));
//            $storeObj = array();
//            $custObj = array();
//            $storeObj = $this->App->getFromDb(array(
//                'from' => 'system_users, store_users',
//                'fields' => "*,stuser_id AS id",
//                'where' => "su_email = '$user_email' AND stuser_email = su_email AND stuser_active = 'Y'",
//            ));
            //$obj->passEnc = $this->encryption->encrypt('12345678#');
            //$obj->passEx = $this->encryption->decrypt('e8dcccd98396269a0e3fd40207672271a48b72b742fc38cfb3a24a451639894ffc9ff39be1d864b5cf314da900892da27fb11f947958ff2802cdbad8e40fea374FS/zYZ9xXzg7bWHHen/mNIo6nROXQENhTkeakRM0hI=');
            if (count($userObj) > 0) {
                //$obj->pass = $this->encryption->decrypt($userObj[0]->user_password);
                if ($this->encryption->decrypt($userObj[0]->user_password) == $user_password) {
                    $obj->status = "OK";
                    $obj->message = "Successfully logged in";
                    $objToSend = (array) $userObj[0];
                    $objToSend['type'] = "Backend";
                    unset($objToSend['user_password']);
                    $obj->data = $this->prepareToken($objToSend);
                    //$obj->decoded = $this->decodeToken($obj->data);
                    $obj->ip = $ip;
                    $obj->type = "Backend";
                }
            }
            }
        

        $this->output->set_output(json_encode($obj, JSON_PRETTY_PRINT));
    }
    
    public function see(){
        $obj = new stdClass();
        $obj->status = "OK";
        $userObj = $this->App->getFromDb(array(
                'from' => 'users',
                'fields' => "*,user_id AS id",
                'where' => "user_email = 'admin@admin.com'",
            ));
        $obj->msg = $this->encryption->decrypt($userObj[0]->user_password);
        $this->output->set_output(json_encode($obj, JSON_PRETTY_PRINT));
    }


    public function checklogin_app() {
        $obj = new stdClass();
        $obj->status = "FAILED";
        $obj->message = "Username or Password is wrong";
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);

        if ($request) {

            $user_email = $request->user_email;
            $user_password = trim($request->user_password);
            //$user_password = password_hash(trim($request->user_password),PASSWORD_BCRYPT);
            $ip = $this->input->ip_address();
            //$obj->ip = $ip;
            $userObj = $this->App->getFromDb(array(
                'from' => 'end_users',
                'fields' => "*,enduser_id AS id",
                'where' => "enduser_email = '$user_email' AND enduser_active = 'Y'",
            ));
            
            if (count($userObj) > 0) {
                $obj->pw = $this->encryption->decrypt($userObj[0]->enduser_password);
                if ($this->encryption->decrypt($userObj[0]->enduser_password) == $user_password) {
                    $obj->status = "OK";
                    $obj->message = "Successfully logged in";
                    $objToSend = (array) $userObj[0];
                    $objToSend['type'] = "Enduser";
                    unset($objToSend['enduser_password']);
                    $obj->data = $this->prepareToken($objToSend);
                    //$obj->decoded = $this->decodeToken($obj->data);
                    $obj->ip = $ip;
                    $obj->type = "Enduser";
                }
            }
        }

        $this->output->set_output(json_encode($obj, JSON_PRETTY_PRINT));
    }

    public function getlogin() {
        $obj = new stdClass();
        $obj->status = "FAILED";
        $obj->message = "";
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);

        if ($request) {
            $token = $this->input->get_request_header('Authorization');
            $obj->status = "OK";
            $obj->token = $token;
            $obj->data = $this->decodeToken($token);
        }
        $this->output->set_output(json_encode($obj, JSON_PRETTY_PRINT));
    }

    public function recover_password() {
        $obj = new stdClass();
        $obj->status = "FAILED";
        $obj->message = "Username or Password is wrong";
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);

        if ($request) {

            $user_email = strtolower(trim($request->user_email));
            //$user_password = $request->user_password;
            $ip = $this->input->ip_address();
            //$obj->ip = $ip;
            $userObj = $this->App->getFromDb(array(
                'from' => 'users',
                'fields' => "*",
                'where' => "user_email = '$user_email' AND user_active = 'Y'",
            ));
            $licenceeObj = $this->App->getFromDb(array(
                'from' => 'licensee',
                'where' => "Li_email = '$user_email' AND Li_active = 'Y'"
            ));
            $repObj = $this->App->getFromDb(array(//aff tbl
                'from' => 'affiliateusers',
                'where' => "affu_email = '$user_email' AND affu_active = 'Y'"
            ));
            $affObj = $this->App->getFromDb(array(//client comp
                'from' => 'clientusers',
                'where' => "cu_email = '$user_email' AND cu_active = 'Y'"
            ));
            //$obj->mock = $userObj;
            if (count($userObj) > 0) {
                // $user = $userObj[0];
                if ($userObj[0]->user_active == 'N') {
                    $obj->status = "FAILED";
                    $obj->message = "Your email " . $user_email . " is inactive, Contact Deuna Administrator";

                    //$obj->data->ip = $ip;
                    $obj->type = "Backend";
                } else {
                    $obj->status = "OK";
                    $obj->message = "Password recovery instructions have been emailed to " . $user_email . "";
                    $obj->data = $userObj[0];
                    $obj->data->ip = $ip;
                    $obj->type = "Backend";
                }
            } else if (count($licenceeObj) > 0) {
                //$user = $licenceeObj[0];

                if ($licenceeObj[0]->Li_active == 'N') {
                    $obj->status = "FAILED";
                    $obj->message = "Your email " . $user_email . " is inactive, Contact Deuna Administrator";

                    //$obj->data->ip = $ip;
                    $obj->type = "Lisensee";
                } else {
                    $obj->status = "OK";
                    $obj->message = "Password recovery instructions have been emailed to " . $user_email . "";
                    $obj->data = $licenceeObj[0];
                    $obj->data->ip = $ip;
                    $obj->type = "Lisensee";
                }
            } else if (count($repObj) > 0) {
                //$user = $repObj[0];

                if ($repObj[0]->affu_active == 'N') {
                    $obj->status = "FAILED";
                    $obj->message = "Your email " . $user_email . " is inactive, Contact Deuna Administrator";

                    //$obj->data->ip = $ip;
                    $obj->type = "Rep";
                } else {
                    $obj->status = "OK";
                    $obj->message = "Password recovery instructions have been emailed to " . $user_email . "";
                    $obj->data = $repObj[0];
                    $obj->data->ip = $ip;
                    $obj->type = "Rep";
                }
            } else if (count($affObj) > 0) {
                //$user = $affObj[0];
                if ($affObj[0]->cu_active == 'N') {
                    $obj->status = "FAILED";
                    $obj->message = "Your email " . $user_email . " is inactive, Contact Deuna Administrator";

                    //$obj->data->ip = $ip;
                    $obj->type = "Aff";
                } else {
                    $obj->status = "OK";
                    $obj->message = "Password recovery instructions have been emailed to " . $user_email . "";
                    $obj->data = $affObj[0];
                    $obj->data->ip = $ip;
                    $obj->type = "Aff";
                }
            } else {
                $obj->status = "FAILED";
                $obj->message = "Email: " . $user_email . " has not been registered with Deuna";
            }
        }

        $this->output->set_output(json_encode($obj, JSON_PRETTY_PRINT));
    }

    public function send_test_email($text, $sendto, $subject = '') {
        $this->initemail($text, $sendto . '@gmail.com', $subject);
    }

    public function initemail($text, $sendto, $subject = '') {


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
        $r = $ci->email->send();
    }

    

    
}
