<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Addchit extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->output->set_header('Access-Control-Allow-Origin: *');
        $this->output->set_header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization");
        $this->output->set_header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
        $this->output->set_content_type('application/json');
    }

    public function getalladdchit() {
        $this->output->set_header('Access-Control-Allow-Origin: *');
        $this->output->set_header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization");
        $this->output->set_header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
        $this->output->set_content_type('application/json');

//       $this->db->select('chit_group.cg_id,chit_scheme.cs_chit_scheme,chit_value.cv_chit_value, addchits.*');
//        $this->db->select('*');
//	$this->db->from(['addchits','chit_group','chit_scheme','chit_value']);
//        $joins = array("chit_group", "chit_group.cg_id = addchits.ac_cg_id", "left");
//$joins = array("chit_value", "chit_value.cv_chit_value = addchits.ac_cg_id", "left");
//$joins = array("chit_scheme", "chit_scheme.cs_chit_scheme = addchits.ac_cg_id", "left");
//        $this->db->where('chit_group.cg_id=addchits.ac_cg_id');
//         $this->db->where('chit_value.cv_chit_value=addchits.ac_cg_id');
//          $this->db->where('chit_scheme.cs_chit_scheme=addchits.ac_cg_id');
//        $this->db->where('chit_value.cv_id=chit_group.cg_chit_value_id');
// }
        $this->db->select('*');
        $this->db->from(['addchits', 'chit_group', 'chit_scheme', 'chit_value']);
        $joins = array("chit_scheme", "chit_scheme.cs_id = addchits.ac_cg_id", "left");
        $joins = array("chit_value", "chit_value.cv_id = addchits.ac_cg_id", "left");
        $joins = array("chit_group", "chit_group.cg_id = addchits.ac_cg_id", "left");
        $this->db->where('chit_scheme.cs_id=addchits.ac_cg_id');
        $this->db->where('chit_value.cv_id=addchits.ac_cg_id');
        $this->db->where('chit_group.cg_id=addchits.ac_cg_id');
        $query = $this->db->get();
        $str = $this->db->last_query();

        $response = array(
            'status' => 'success',
            'join' => $query->result(),
        );
//         $str= $this->db->last_query();
//        echo"<pre>";
//        print_r($str);
//        exit;
//        echo"<pre>";
//        print_r($response);
//        exit;

        $this->output
                ->set_status_header(200)
                ->set_content_type('application/json')
                ->set_output(json_encode($response));
    }

    public function get_all_addchit() {

        $obj = new stdClass();
        $obj->status = "FAILED";
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);
        $obj->token_status = $this->decodedToken->status;
        if ($request && $this->decodedToken->status == 'OK') {
            $obj->status = "OK";



            $order_by = $request->order_by;
            $num_per_page = $request->num_per_page;
            $order = $request->order;
            $start_from = $request->start_from;
            $search = trim($request->search);

            $query = "ac_id > 0";


            $search_fields = "("
                    . "ac_id LIKE '%$search%'"
//                    . "OR ac_nc_id LIKE '%$search%'"
//                    . " OR ac_name  LIKE '%$search%'"
//                    . " OR ac_phone  LIKE '%$search%'"
                    . " OR ac_chit_scheme  LIKE '%$search%'"
                    . " OR ac_cg_id  LIKE '%$search%'"
                    . " OR ac_chit_value  LIKE '%$search%'"
                    . " OR ac_no_of_members LIKE '%$search%'"
                    . " OR ac_no_of_installment  LIKE '%$search%'"
//                       . " OR ac_max_installment_1  LIKE '%$search%'"
//                    . " OR ac_max_installment_2  LIKE '%$search%'"
//                    . " OR ac_max_installment_3  LIKE '%$search%'"
//                    . " OR ac_max_installment_4  LIKE '%$search%'"
//                    . " OR ac_max_installment_5  LIKE '%$search%'"
//                    . " OR ac_max_installment_6  LIKE '%$search%'"
//                    . " OR ac_max_installment_7  LIKE '%$search%'"
//                    . " OR ac_max_installment_8  LIKE '%$search%'"
//                    . " OR ac_max_installment_9  LIKE '%$search%'"
//                    . " OR ac_max_installment_10  LIKE '%$search%'"
//                    . " OR ac_max_installment_11  LIKE '%$search%'"
//                    . " OR ac_max_installment_12  LIKE '%$search%'"
//                    . " OR ac_max_installment_13  LIKE '%$search%'"
//                    . " OR ac_max_installment_14  LIKE '%$search%'"
//                    . " OR ac_max_installment_15  LIKE '%$search%'"
//                    . " OR ac_max_installment_16  LIKE '%$search%'"
//                    . " OR ac_max_installment_17  LIKE '%$search%'"
//                    . " OR ac_max_installment_18  LIKE '%$search%'"
//                    . " OR ac_max_installment_19  LIKE '%$search%'"
//                    . " OR ac_max_installment_20 LIKE '%$search%'"
//                    . " OR ac_max_installment_21  LIKE '%$search%'"
                    . " OR ac_ceiling  LIKE '%$search%'"
//                     . " OR ac_chit_no_2  LIKE '%$search%'"
//                     . " OR ac_chit_no_3  LIKE '%$search%'"
//                     . " OR ac_chit_no_4  LIKE '%$search%'"
//                     . " OR ac_chit_no_5  LIKE '%$search%'"
//                     . " OR ac_chit_no_6  LIKE '%$search%'"
//                     . " OR ac_chit_no_7  LIKE '%$search%'"
//                     . " OR ac_chit_no_8  LIKE '%$search%'"
//                     . " OR ac_chit_no_9  LIKE '%$search%'"
//                     . " OR ac_chit_no_10  LIKE '%$search%'"
//                     . " OR ac_chit_no_11  LIKE '%$search%'"
//                     . " OR ac_chit_no_12  LIKE '%$search%'"
//                     . " OR ac_chit_no_13  LIKE '%$search%'"
//                     . " OR ac_chit_no_14  LIKE '%$search%'"
//                     . " OR ac_chit_no_15  LIKE '%$search%'"
//                     . " OR ac_chit_no_16  LIKE '%$search%'"
//                     . " OR ac_chit_no_17  LIKE '%$search%'"
//                     . " OR ac_chit_no_18  LIKE '%$search%'"
//                     . " OR ac_chit_no_19  LIKE '%$search%'"
//                     . " OR ac_chit_no_20  LIKE '%$search%'"
//                     . " OR ac_chit_no_21  LIKE '%$search%'"
                    . " OR ac_date_of_joining  LIKE '%$search%'"
                    . " OR ac_first_payment  LIKE '%$search%'"
//                    . " OR ac_log LIKE '%$search%'"
                    . "OR ac_status LIKE '%$search'"
                    . "OR ac_created_at LIKE '%$search'"
                    . "OR ac_updated_at LIKE '%$search'"
                    . ")";

            if (!empty($request->search)) {
                $query = $query . " AND " . $search_fields;
            }
            $joins = array(
            );
            $ct = $this->App->getFromDb(array('from' => 'addchits', 'fields' => "COUNT(ac_id) as total", 'join_left' => $joins, 'where' => $query));
            $rdata = $this->App->getFromDb(array('from' => 'addchits',
                'fields' => "*",
                'join_left' => $joins,
                'where' => $query,
                'orderkey' => $order_by,
                'order' => $order,
                'num' => $num_per_page,
                'startfrom' => $start_from));

            $obj->total = 0;
            if (sizeof($ct) > 0) {
                $obj->total = $ct[0]->total;
            }
            $pg = $obj->total / $num_per_page;
            $pgRound = round($pg);
            if ($pg > $pgRound) {
                $pgRound = $pgRound + 1;
            }
            $obj->pages = $pgRound;
            $obj->data = $rdata;
            $obj->received = sizeof($rdata);
        }

        $this->output->set_output(json_encode($obj, JSON_PRETTY_PRINT));
    }

    public function add_edit_addchit() {
        $this->output->set_header('Access-Control-Allow-Origin: *');
        $this->output->set_header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization");
        $this->output->set_header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
        $this->output->set_content_type('application/json');
        $this->load->helper('string');
        $obj = new stdClass();
        $obj->status = "FAILED";
        $obj->message = "";
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);

//  $ac_ceiling=trim($request->ac_ceiling);
////foreach($ac_ceilings as $ac_ceiling):
////    echo $ac_ceiling."<br>";
////endforeach;
//
//print_r($ac_ceilings);
        $obj->token_status = $this->decodedToken->status;
        if ($request && $this->decodedToken->status == 'OK') {
            $ac_created_at = date("Y-m-d H:i:s");
            $ac_updated_at = date("Y-m-d H:i:s");
            $ac_id = trim($request->ac_id);
//            $ac_nc_id = trim($request->ac_nc_id);
//            $ac_name = trim($request->ac_name);
//            $ac_phone = trim($request->ac_phone);
//            $ac_chit_scheme = trim($request->ac_chit_scheme);
//            $ac_chit_value = trim($request->ac_chit_value);
            $ac_cg_id = trim($request->ac_cg_id);
            $ac_no_of_members = trim($request->ac_no_of_members);
            $ac_no_of_installment = trim($request->ac_no_of_installment);
//            $ac_max_installment_1=trim($request->ac_max_installment_1);
//            $ac_max_installment_2=trim($request->ac_max_installment_2);
//            $ac_max_installment_3=trim($request->ac_max_installment_3);
//            $ac_max_installment_4=trim($request->ac_max_installment_4);
//            $ac_max_installment_5=trim($request->ac_max_installment_5);
//            $ac_max_installment_6=trim($request->ac_max_installment_6);
//            $ac_max_installment_7=trim($request->ac_max_installment_7);
//            $ac_max_installment_8=trim($request->ac_max_installment_8);
//            $ac_max_installment_9=trim($request->ac_max_installment_9);
//            $ac_max_installment_10=trim($request->ac_max_installment_10);
//            $ac_max_installment_11=trim($request->ac_max_installment_11);
//            $ac_max_installment_12=trim($request->ac_max_installment_12);
//            $ac_max_installment_13=trim($request->ac_max_installment_13);
//            $ac_max_installment_14=trim($request->ac_max_installment_14);
//            $ac_max_installment_15=trim($request->ac_max_installment_15);
//            $ac_max_installment_16=trim($request->ac_max_installment_16);
//            $ac_max_installment_17=trim($request->ac_max_installment_17);
//            $ac_max_installment_18=trim($request->ac_max_installment_18);
//            $ac_max_installment_19=trim($request->ac_max_installment_19);
//            $ac_max_installment_20=trim($request->ac_max_installment_20);
//            $ac_max_installment_21=trim($request->ac_max_installment_21);
//            foreach($ac_ceilings as $ac_ceiling):
//    echo $ac_ceiling."<br>";
//    endforeach;
//    print_r($ac_ceiling);
//            $ac_chit_no_2=trim($request->ac_chit_no_2);
//            $ac_chit_no_3=trim($request->ac_chit_no_3);
//            $ac_chit_no_4=trim($request->ac_chit_no_4);
//            $ac_chit_no_5=trim($request->ac_chit_no_5);
//            $ac_chit_no_6=trim($request->ac_chit_no_6);
//            $ac_chit_no_7=trim($request->ac_chit_no_7);
//            $ac_chit_no_8=trim($request->ac_chit_no_8);
//            $ac_chit_no_9=trim($request->ac_chit_no_9);
//            $ac_chit_no_10=trim($request->ac_chit_no_10);
//            $ac_chit_no_11=trim($request->ac_chit_no_11);
//            $ac_chit_no_12=trim($request->ac_chit_no_12);
//            $ac_chit_no_13=trim($request->ac_chit_no_13);
//            $ac_chit_no_14=trim($request->ac_chit_no_14);
//            $ac_chit_no_15=trim($request->ac_chit_no_15);
//            $ac_chit_no_16=trim($request->ac_chit_no_16);
//            $ac_chit_no_17=trim($request->ac_chit_no_17);
//            $ac_chit_no_18=trim($request->ac_chit_no_18);
//            $ac_chit_no_19=trim($request->ac_chit_no_19);
//            $ac_chit_no_20=trim($request->ac_chit_no_20);
//            $ac_chit_no_21=trim($request->ac_chit_no_21);


            $ac_date_of_joining = trim($request->ac_date_of_joining);
            $ac_first_payment = trim($request->ac_first_payment);
//            $ac_log = $log;
            $ac_status = trim($request->ac_status);
            $ac_created_at = $ac_created_at;
            $ac_updated_at = $ac_updated_at;
            $payload = array(
//                 'ac_customer_id' => $ac_customer_id,
//                'ac_name' => $ac_name,
//                'ac_phone' => $ac_phone,
//                'ac_chit_scheme' => $ac_chit_scheme,
//                'ac_chit_value' => $ac_chit_value, 
                'ac_cg_id' => $ac_cg_id,
//                'ac_nc_id'=>$ac_nc_id,
                'ac_no_of_members' => $ac_no_of_members,
                'ac_no_of_installment' => $ac_no_of_installment,
//                'ac_max_installment_1' => $ac_max_installment_1,
//                'ac_max_installment_2' => $ac_max_installment_2,
//                'ac_max_installment_3' => $ac_max_installment_3,
//                'ac_max_installment_4' => $ac_max_installment_4,
//                'ac_max_installment_5' => $ac_max_installment_5,
//                'ac_max_installment_6' => $ac_max_installment_6,
//                'ac_max_installment_7' => $ac_max_installment_7,
//                'ac_max_installment_8' => $ac_max_installment_8,
//                'ac_max_installment_9' => $ac_max_installment_9,
//                'ac_max_installment_10' => $ac_max_installment_10,
//                'ac_max_installment_11' => $ac_max_installment_11,
//                'ac_max_installment_12' => $ac_max_installment_12,
//                'ac_max_installment_13' => $ac_max_installment_13,
//                'ac_max_installment_14' => $ac_max_installment_14,
//                'ac_max_installment_15' => $ac_max_installment_15,
//                'ac_max_installment_16' => $ac_max_installment_16,
//                'ac_max_installment_17' => $ac_max_installment_17,
//                'ac_max_installment_18' => $ac_max_installment_18,
//                'ac_max_installment_19' => $ac_max_installment_19,
//                'ac_max_installment_20' => $ac_max_installment_20,
//                'ac_max_installment_21' => $ac_max_installment_21,
//                'ac_chit_no_2' => $ac_chit_no_2,
//                'ac_chit_no_3' => $ac_chit_no_3,
//                'ac_chit_no_4' => $ac_chit_no_4,
//                'ac_chit_no_5' => $ac_chit_no_5,
//                'ac_chit_no_6' => $ac_chit_no_6,
//                'ac_chit_no_7' => $ac_chit_no_7,
//                'ac_chit_no_8' => $ac_chit_no_8,
//                'ac_chit_no_9' => $ac_chit_no_9,
//                'ac_chit_no_10' => $ac_chit_no_10,
//                'ac_chit_no_11' => $ac_chit_no_11,
//                'ac_chit_no_12' => $ac_chit_no_12,
//                'ac_chit_no_13' => $ac_chit_no_13,
//                'ac_chit_no_14' => $ac_chit_no_14,
//                'ac_chit_no_15' => $ac_chit_no_15,
//                'ac_chit_no_16' => $ac_chit_no_16,
//                'ac_chit_no_17' => $ac_chit_no_17,
//                'ac_chit_no_18' => $ac_chit_no_18,
//                'ac_chit_no_19' => $ac_chit_no_19,
//                'ac_chit_no_20' => $ac_chit_no_20,
//                'ac_chit_no_21' => $ac_chit_no_21,
                'ac_date_of_joining' => $ac_date_of_joining,
                'ac_first_payment' => $ac_first_payment,
//                'ac_log' => $ac_log,
                'ac_status' => $ac_status,
                'ac_created_at' => $ac_created_at,
                'ac_updated_at' => $ac_updated_at,
            );
            if ($ac_id == -1) {
                $payload['ac_created_at'] = date("Y-m-d H:i:s");
                $payload['ac_updated_at'] = date("Y-m-d H:i:s");

                $obj->status = $this->App->insertDbIfNotExists($payload, "addchits", " ''");
                $lastid = $this->db->insert_id('addchits');
                $cd_ceiling_arr=[];
                $cd_ceiling_arr = $request->cd_ceiling;
                $obj->arrcount   = count($cd_ceiling_arr); 
//                $cd_ceiling = trim();
//                var_dump($cd_ceiling_arr);
//exit;
//                if (count($cd_ceiling_arr) != 0) {
//                    
//                    for ($i = 0; $i < count($cd_ceiling_arr); $i++) {
//                        if ($i == 0) {
//                            $status = 'completed';
//                        }
//                        $payload1['cd_ac_id'] = $lastid;
//                        $payload1['cd_chit_no'] = $i+1;
//                        $payload1['cd_ceiling'] = $cd_ceiling_arr[$i];
//                        
//                    }
//                        $obj->status = $this->App->insertDbIfNotExists($payload1, "chit_details", " ''");
//
//                }

                if ($obj->status == 'OK') {
                    $ac_id = $this->db->insert_id();
                    $obj->message = "Addchits entry created successfully";
                } else {
                    //$obj->message = "Sorry could not proceed, " . $ac_no_of_members . " is already taken!";
                }
            } else {
                $payload['ac_updated_at'] = date("Y-m-d H:i:s");
                $obj->status = $this->App->updateDbIfNotExists(
                        array('from' => "addchits", 'where' => "ac_id = '$ac_id'",
                            'data' => $payload), " '' AND ac_id != '$ac_id'");
                if ($obj->status == 'OK') {
                    $obj->message = "Addchits entry updated";
                } else {
                    $obj->message = 'Sorry,Entered: ' . '' . " is already existing in DB";
                }
            }
        }
        $this->output->set_output(json_encode($obj, JSON_PRETTY_PRINT));
    }

    public function add_edit_chituser() {
        $this->output->set_header('Access-Control-Allow-Origin: *');
        $this->output->set_header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization");
        $this->output->set_header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
        $this->output->set_content_type('application/json');
        $this->load->helper('string');
        $obj = new stdClass();
        $obj->status = "FAILED";
        $obj->message = "";
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);

        $obj->token_status = $this->decodedToken->status;
        if ($request && $this->decodedToken->status == 'OK') {
            $cu_created_at = date("Y-m-d H:i:s");
            $cu_updated_at = date("Y-m-d H:i:s");
            $cu_id = trim($request->cu_id);
            $cu_nc_id = trim($request->cu_nc_id);
            $cu_ac_id = trim($request->cu_ac_id);
            $cu_created_at = $cu_created_at;
            $cu_updated_at = $cu_updated_at;


            $payload = array(
                'cu_id' => $cu_id,
                'cu_nc_id' => $cu_nc_id,
                'cu_ac_id' => $cu_ac_id,
                'cu_created_at' => $cu_created_at,
                'cu_updated_at' => $cu_updated_at,
            );

            if ($cu_id == -1) {
                $payload['cu_created_at'] = date("Y-m-d H:i:s");
                $payload['cu_updated_at'] = date("Y-m-d H:i:s");

                $obj->status = $this->App->insertDbIfNotExists($payload, "chit_users", "  ''");
                if ($obj->status == 'OK') {
                    $cg_id = $this->db->insert_id();
                    $obj->message = "chit_users entry created successfully";
                } else {
                    $obj->message = "Sorry could not proceed, " . $cu_id . " is already taken!";
                }
            } else {
                $payload['cu_updated_at'] = date("Y-m-d H:i:s");

                $obj->status = $this->App->updateDbIfNotExists(
                        array('from' => "chit_users", 'where' => "cu_id = '$cu_id'",
                            'data' => $payload), "cu_id = '$cu_id' AND cu_id != '$cu_id'");
                if ($obj->status == 'OK') {
                    $obj->message = "chit_users entry updated";
                } else {
                    $obj->message = 'Sorry,Entered: ' . $cu_id . " is already existing in DB";
                }
            }
        }
        $this->output->set_output(json_encode($obj, JSON_PRETTY_PRINT));
    }

    public function get_all_newcustomer() {
        $obj = new stdClass();
        $obj->message = "";
        $obj->status = "OK";
        $search = $this->input->post('term');
        $query = "nc_customer_id LIKE '%$search%'";
        $data = $this->App->getFromDb(array(
            'from' => 'newcustomers',
//            'fields' => "nc_customer_id  as text, nc_name  as id,nc_phone  as value",
            'fields' => "nc_name  as text, nc_id  as id",
            'where' => $query,
            'orderkey' => 'nc_name',
            'order' => 'ASC',
        ));
        $obj->data = $data;
        $this->output->set_output(json_encode($obj, JSON_PRETTY_PRINT));
    }

    public function get_selected_newcustomer() {
        $this->load->helper('string');
        $obj = new stdClass();
        $obj->status = "FAILED";
        $obj->message = "";
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);

        $obj->token_status = $this->decodedToken->status;
        if ($request && $this->decodedToken->status == 'OK') {
            $obj->status = "OK";
            $check_id = trim($request->id);
            $query = "nc_id = '$check_id'";
            $obj->data = $this->App->getFromDb(array('from' => 'newcustomers',
                'fields' => "nc_name as text, nc_id as id",
                'where' => $query,
                'orderkey' => 'nc_name',
                'order' => 'ASC',
            ));
        }
        $this->output->set_output(json_encode($obj, JSON_PRETTY_PRINT));
    }

//    
// public function get_countries() {
//        $obj = new stdClass();
//        $obj->status = "FAILED";
//        $obj->message = "";
//        $postdata = file_get_contents("php://input");
//        $request = json_decode($postdata);
//
//        if ($request) {
//            $obj->status = "OK";
//            $data = $this->App->getFromDb(array(
//                'from' => 'countries',
//                'orderkey' => 'name',
//                'order' => 'ASC',
//            ));
//            $obj->data = $data;
//        }
//
//        $this->output->set_output(json_encode($obj, JSON_PRETTY_PRINT));
//    }
//
//    public function get_states() {
//        $obj = new stdClass();
//        $obj->status = "FAILED";
//        $obj->message = "";
//        $postdata = file_get_contents("php://input");
//        $request = json_decode($postdata);
//
//        if ($request) {
//            $obj->status = "OK";
//            $id = $request->id;
//            $data = $this->App->getFromDb(array(
//                'from' => 'newcustomers',
//                'where' => "nc_customer_id = '$id'",
//                'orderkey' => 'name',
//                'order' => 'ASC',
//            ));
//            $obj->data = $data;
//        }
//
//        $this->output->set_output(json_encode($obj, JSON_PRETTY_PRINT));
//    }
//
//    public function get_cities() {
//        $obj = new stdClass();
//        $obj->status = "FAILED";
//        $obj->message = "";
//        $postdata = file_get_contents("php://input");
//        $request = json_decode($postdata);
//
//        if ($request) {
//            $obj->status = "OK";
//            $id = $request->id;
//            $data = $this->App->getFromDb(array(
//                'from' => 'cities',
//                'where' => "state_id = '$id'",
//                'orderkey' => 'name',
//                'order' => 'ASC',
//            ));
//            $obj->data = $data;
//        }
//
//        $this->output->set_output(json_encode($obj, JSON_PRETTY_PRINT));
//    }



    public function get_all_chitscheme() {
        $obj = new stdClass();
        $obj->message = "";
        $obj->status = "OK";
        $search = $this->input->post('term');
        $query = "cs_chit_scheme LIKE '%$search%'";
        $data = $this->App->getFromDb(array(
            'from' => 'chit_scheme',
            'fields' => "cs_chit_scheme  as text, cs_chit_scheme as id",
            'where' => $query,
            'orderkey' => 'cs_chit_scheme',
            'order' => 'ASC',
        ));
        $obj->data = $data;
        $this->output->set_output(json_encode($obj, JSON_PRETTY_PRINT));
    }

    public function get_all_chitschememonth() {
        $obj = new stdClass();
        $obj->status = "FAILED";
        $obj->message = "";
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);

        if ($request) {
            $obj->status = "OK";
            $id = $request->id;
            $data = $this->App->getFromDb(array(
                'from' => 'chit_scheme',
                'where' => "ac_id = '$id'",
                'orderkey' => 'chit_scheme_month',
                'order' => 'ASC',
            ));
            $obj->data = $data;
        }

        $this->output->set_output(json_encode($obj, JSON_PRETTY_PRINT));
    }

    public function get_selected_chitscheme() {
        $this->load->helper('string');
        $obj = new stdClass();
        $obj->status = "FAILED";
        $obj->message = "";
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);

        $obj->token_status = $this->decodedToken->status;
        if ($request && $this->decodedToken->status == 'OK') {
            $obj->status = "OK";
            $check_id = trim($request->id);
            $query = "cs_chit_scheme = '$check_id'";
            $obj->data = $this->App->getFromDb(array('from' => 'chit_scheme',
                'fields' => "cs_chit_scheme as text, cs_chit_scheme as id",
                'where' => $query,
                'orderkey' => 'cs_chit_scheme',
                'order' => 'ASC',
            ));
        }
        $this->output->set_output(json_encode($obj, JSON_PRETTY_PRINT));
    }

    public function get_all_chitvalue() {
        $obj = new stdClass();
        $obj->message = "";
        $obj->status = "OK";
        $search = $this->input->post('term');
        $query = "ac_chit_value LIKE '%$search%'";
        $data = $this->App->getFromDb(array(
            'from' => 'chit_value',
            'fields' => "ac_chit_value  as text, ac_chit_value as id",
            'where' => $query,
            'orderkey' => 'ac_chit_value',
            'order' => 'ASC',
        ));
        $obj->data = $data;
        $this->output->set_output(json_encode($obj, JSON_PRETTY_PRINT));
    }

    public function get_selected_chitvalue() {
        $this->load->helper('string');
        $obj = new stdClass();
        $obj->status = "FAILED";
        $obj->message = "";
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);

        //$obj->token_status = $this->decodedToken->status;
        if ($request) {
            $obj->status = "OK";
            $check_id = trim($request->id);
            $query = "ac_chit_value = '$check_id'";
            $obj->data = $this->App->getFromDb(array('from' => 'chit_value',
                'fields' => "ac_chit_value as text, ac_chit_value as id",
                'where' => $query,
                'orderkey' => 'ac_chit_value',
                'order' => 'ASC',
            ));
        }
        $this->output->set_output(json_encode($obj, JSON_PRETTY_PRINT));
    }

    public function delete_obj($id) {

        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Request-Headers: GET,POST,OPTIONS,DELETE,PUT");
        header("Access-Control-Allow-Headers: authorization, Content-Type");

        $this->db->where('ac_id', $id);
        $delete = $this->db->delete('addchits');

        //$delete=$this->api_model->delete($id);

        $response = array(
            'status' => 'success',
            'delete' => ""
        );

        $this->output
                ->set_status_header(200)
                ->set_content_type('application/json')
                ->set_output(json_encode($response));
    }

    public function get_all_chitgroup() {
        $obj = new stdClass();
        $obj->message = "";
        $obj->status = "OK";
        $search = $this->input->post('term');
        $query = "cg_group_name LIKE '%$search%'";
        // $query = "vr_room_name LIKE '%$search%'";
//        $query .= " AND vr_active = 'Y'";
        $data = $this->App->getFromDb(array(
            'from' => 'chit_group',
            'fields' => "cg_group_name as text, cg_id as id",
            'where' => $query,
            'orderkey' => "cg_group_name",
            'order' => 'ASC',
        ));
        $obj->data = $data;
        $this->output->set_output(json_encode($obj, JSON_PRETTY_PRINT));
    }

    public function get_selected_chitgroup() {
        $this->load->helper('string');
        $obj = new stdClass();
        $obj->status = "FAILED";
        $obj->message = "";
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);

        $obj->token_status = $this->decodedToken->status;
        if ($request && $this->decodedToken->status == 'OK') {
            $obj->status = "OK";
            $check_id = trim($request->id);
            $query = "cg_id = '$check_id'";
            $obj->data = $this->App->getFromDb(array('from' => 'chit_group',
                'fields' => "cg_group_name as text, cg_id as id",
                'where' => $query,
                'orderkey' => 'cg_group_name',
                'order' => 'ASC',
            ));
        }
        $this->output->set_output(json_encode($obj, JSON_PRETTY_PRINT));
    }

}
