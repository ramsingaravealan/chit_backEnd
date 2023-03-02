<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Newcustomers extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->output->set_header('Access-Control-Allow-Origin: *');
        $this->output->set_header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization");
        $this->output->set_header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
        $this->output->set_content_type('application/json');
    }

    public function get_all_newcustomers() {
          $this->output->set_header('Access-Control-Allow-Origin: *');
        $this->output->set_header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization");
        $this->output->set_header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
        $this->output->set_content_type('application/json');
        
        $obj = new stdClass();
        $obj->status = "FAILED";
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);
        $obj->token_status = $this->decodedToken->status;
        if ($request && $this->decodedToken->status == 'OK') {
            $obj->status = "OK";


            $num_per_page = $request->num_per_page;
            $order_by = $request->order_by;
            $order = $request->order;
            $start_from = $request->start_from;
            $search = trim($request->search);

            $query = "nc_id > 0";


            $search_fields = "("
                    . "nc_id LIKE '%$search%'"
                    . "nc_customer_id LIKE '%$search%'"
                    . " OR nc_name LIKE '%$search%'"
                    . " OR nc_phone LIKE '%$search%'"
                    . " OR nc_dob LIKE '%$search%'"
                    . " OR nc_gender LIKE '%$search%'"
                    . " OR nc_present_address LIKE '%$search%'"
                    . " OR nc_present_city LIKE '%$search%'"
                    . " OR nc_present_state LIKE '%$search%'"
                    . " OR nc_present_pincode LIKE '%$search%'"
                    . " OR nc_permanent_address LIKE '%$search%'"
                    . " OR nc_permanent_city LIKE '%$search%'"
                    . " OR nc_permanent_state LIKE '%$search%'"
                    . " OR nc_permanent_pincode LIKE '%$search%'"
                    . " OR nc_id_proof LIKE '%$search%'"
                    . " OR nc_id_proof_no LIKE '%$search%'"
                    . " OR nc_father_name LIKE '%$search%'"
                    . " OR nc_father_adhar LIKE '%$search%'"
                    . " OR nc_father_phoneno LIKE '%$search%'"
                    . " OR nc_mother_name  LIKE '%$search%'"
                    . " OR nc_mother_adhar LIKE '%$search%'"
                    . " OR nc_martial_status LIKE '%$search%'"
                    . " OR nc_spouse_name LIKE '%$search%'"
                    . " OR nc_spouse_adhar LIKE '%$search%'"
                    . " OR nc_spouse_phoneno LIKE '%$search%'"
                    . " OR nc_reference_name_1 LIKE '%$search%'"
                    . " OR nc_reference_phone_1 LIKE '%$search%'"
                    . " OR nc_reference_name_2 LIKE '%$search%'"
                    . " OR nc_reference_phone_2 LIKE '%$search%'"
                    . " OR nc_nominee_name LIKE '%$search%'"
                    . " OR nc_nominee_phone LIKE '%$search%'"
                    . " OR nc_nominee_relationship LIKE '%$search%'"
                    . " OR nc_profile_photo LIKE '%$search%'"
                    . " OR nc_log LIKE '%$search%'"
                    . ")";

            if (!empty($request->search)) {
                $query = $query . " AND " . $search_fields;
            }
            $joins = array(
            );
            $ct = $this->App->getFromDb(array('from' => 'newcustomers', 'fields' => "COUNT(nc_id) as total", 'join_left' => $joins, 'where' => $query));
            $rdata = $this->App->getFromDb(array('from' => 'newcustomers',
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

    public function add_edit_newcustomers() {
        $this->output->set_header('Access-Control-Allow-Origin: *');
        $this->output->set_header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization");
        $this->output->set_header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
        $this->output->set_content_type('application/json');
//        $this->load->helper('string');
        $obj = new stdClass();
        $obj->status = "FAILED";
        $obj->message = "";
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);

        $obj->token_status = $this->decodedToken->status;
        if ($request && $this->decodedToken->status == 'OK') {
            $log = date("Y-m-d H:i:s");
            
//            $rno= 'SSMC'.'-'.'';
//            $d=date('y');
//            $month=date('m');
//            $rand=rand(1,10000);
//            $receipt=$rno.$d.$month.$rand;
            
            $nc_id = trim($request->nc_id);
//            $nc_customer_id=$receipt;
            $nc_customer_id=trim($request->nc_customer_id);
            $nc_name = trim($request->nc_name);
            $nc_phone = trim($request->nc_phone);
            $nc_dob = ucwords(trim($request->nc_dob));
            $nc_gender = ucwords(trim($request->nc_gender));
            $nc_present_address = ucwords(trim($request->nc_present_address));
            $nc_present_city = ucwords(trim($request->nc_present_city));
            $nc_present_state = ucwords(trim($request->nc_present_state));
            $nc_present_pincode = ucwords(trim($request->nc_present_pincode));
            $nc_permanent_address = ucwords(trim($request->nc_permanent_address));
            $nc_permanent_city = ucwords(trim($request->nc_permanent_city));
            $nc_permanent_state = ucwords(trim($request->nc_permanent_state));
            $nc_permanent_pincode = ucwords(trim($request->nc_permanent_pincode));
            $nc_id_proof = ucwords(trim($request->nc_id_proof));
            $nc_id_proof_no = ucwords(trim($request->nc_id_proof_no));
            $nc_father_name = ucwords(trim($request->nc_father_name));
            $nc_father_adhar = ucwords(trim($request->nc_father_adhar));
            $nc_father_phoneno = ucwords(trim($request->nc_father_phoneno));
            $nc_mother_name = ucwords(trim($request->nc_mother_name));
            $nc_mother_adhar = ucwords(trim($request->nc_mother_adhar));
            $nc_martial_status = ucwords(trim($request->nc_martial_status));
            $nc_spouse_name = ucwords(trim($request->nc_spouse_name));
            $nc_spouse_adhar = ucwords(trim($request->nc_spouse_adhar));
            $nc_spouse_phoneno = ucwords(trim($request->nc_spouse_phoneno));
            $nc_reference_name_1 = ucwords(trim($request->nc_reference_name_1));
            $nc_reference_phone_1 = ucwords(trim($request->nc_reference_phone_1));
            $nc_reference_name_2 = ucwords(trim($request->nc_reference_name_2));
            $nc_reference_phone_2 = ucwords(trim($request->nc_reference_phone_2));
            $nc_nominee_name = ucwords(trim($request->nc_nominee_name));
            $nc_nominee_phone = ucwords(trim($request->nc_nominee_phone));
            $nc_nominee_relationship = ucwords(trim($request->nc_nominee_relationship));
            $nc_profile_photo = ucwords(trim($request->nc_profile_photo));
            $nc_log = $log;

            $payload = array(
//                'nc_customer_id'=>$nc_customer_id,
                'nc_name' => $nc_name,
                'nc_phone' => $nc_phone,
                'nc_dob' => $nc_dob,
                'nc_gender' => $nc_gender,
                'nc_present_address' => $nc_present_address,
                'nc_present_city' => $nc_present_city,
                'nc_present_state' => $nc_present_state,
                'nc_present_pincode' => $nc_present_pincode,
                'nc_permanent_address' => $nc_permanent_address,
                'nc_permanent_city' => $nc_permanent_city,
                'nc_permanent_state' => $nc_permanent_state,
                'nc_permanent_pincode' => $nc_permanent_pincode,
                'nc_id_proof' => $nc_id_proof,
                'nc_id_proof_no' => $nc_id_proof_no,
                'nc_father_name' => $nc_father_name,
                'nc_father_adhar' => $nc_father_adhar,
                'nc_father_phoneno' => $nc_father_phoneno,
                'nc_mother_name' => $nc_mother_name,
                'nc_mother_adhar' => $nc_mother_adhar,
                'nc_martial_status' => $nc_martial_status,
                'nc_spouse_name' => $nc_spouse_name,
                'nc_spouse_adhar' => $nc_spouse_adhar,
                'nc_spouse_phoneno' => $nc_spouse_phoneno,
                'nc_reference_name_1' => $nc_reference_name_1,
                'nc_reference_phone_1' => $nc_reference_phone_1,
                'nc_reference_name_2' => $nc_reference_name_2,
                'nc_reference_phone_2' => $nc_reference_phone_2,
                'nc_nominee_name' => $nc_nominee_name,
                'nc_nominee_phone' => $nc_nominee_phone,
                'nc_nominee_relationship' => $nc_nominee_relationship,
                'nc_profile_photo' => $nc_profile_photo,
                'nc_log' => $nc_log,
            );
//            if ($nc_id == -1) {
//                $obj->status = $this->App->insertDbIfNotExists($payload, "newcustomers");
//                if ($obj->status == 'OK') {
//                    $nc_id = $this->db->insert_id();
//                    $obj->message = "Newcustomers entry created successfully";
//                } else {
//                    $obj->message = "Sorry could not proceed,  is already taken!";
//                }
//            } else {
//                $obj->status = $this->App->updateDbIfNotExists(
//                        array('from' => "newcustomers", 'where' => "nc_id = '$nc_id'",
//                            'data' => $payload));
//                if ($obj->status == 'OK') {
//                    $obj->message = "Newcustomers entry updated";
//                } else {
//                    $obj->message = "Sorry,Entered is already existing in DB";
//                }
//            }
            
//            if ($nc_id == -1) {
//                $obj->status = $this->App->insertDbIfNotExists($payload, "newcustomers", "  ''");
//                if ($obj->status == 'OK') {
//                    $nc_id = $this->db->insert_id();
//                    $obj->message = "newcustomers entry created successfully";
//                } else {
////                    $obj->message = "Sorry could not proceed, " . $cs_chit_scheme . " is already taken!";
//                }
//            } else {
//                $obj->status = $this->App->updateDbIfNotExists(
//                        array('from' => "newcustomers", 'where' => "nc_id = '$nc_id'",
//                            'data' => $payload), " nc_id != '$nc_id'");
//                if ($obj->status == 'OK') {
//                    $obj->message = "newcustomers entry updated";
//                } else {
//                    $obj->message = "Sorry,Entered:   is already existing in DB";
//                }
//            }
            
            if ($nc_id == -1) {
               
                     $rno= 'SSMC'.'-'.'';
            $d=date('y');
            $month=date('m');
            $rand=rand(1,10000);
            $receipt=$rno.$d.$month.$rand;
            $nc_customer_id=$receipt;
             $payload = array(
                'nc_customer_id'=>$nc_customer_id,
                'nc_name' => $nc_name,
                'nc_phone' => $nc_phone,
                'nc_dob' => $nc_dob,
                'nc_gender' => $nc_gender,
                'nc_present_address' => $nc_present_address,
                'nc_present_city' => $nc_present_city,
                'nc_present_state' => $nc_present_state,
                'nc_present_pincode' => $nc_present_pincode,
                'nc_permanent_address' => $nc_permanent_address,
                'nc_permanent_city' => $nc_permanent_city,
                'nc_permanent_state' => $nc_permanent_state,
                'nc_permanent_pincode' => $nc_permanent_pincode,
                'nc_id_proof' => $nc_id_proof,
                'nc_id_proof_no' => $nc_id_proof_no,
                'nc_father_name' => $nc_father_name,
                'nc_father_adhar' => $nc_father_adhar,
                'nc_father_phoneno' => $nc_father_phoneno,
                'nc_mother_name' => $nc_mother_name,
                'nc_mother_adhar' => $nc_mother_adhar,
                'nc_martial_status' => $nc_martial_status,
                'nc_spouse_name' => $nc_spouse_name,
                'nc_spouse_adhar' => $nc_spouse_adhar,
                'nc_spouse_phoneno' => $nc_spouse_phoneno,
                'nc_reference_name_1' => $nc_reference_name_1,
                'nc_reference_phone_1' => $nc_reference_phone_1,
                'nc_reference_name_2' => $nc_reference_name_2,
                'nc_reference_phone_2' => $nc_reference_phone_2,
                'nc_nominee_name' => $nc_nominee_name,
                'nc_nominee_phone' => $nc_nominee_phone,
                'nc_nominee_relationship' => $nc_nominee_relationship,
                'nc_profile_photo' => $nc_profile_photo,
                'nc_log' => $nc_log,
            );
                
                $obj->status = $this->App->insertDbIfNotExists($payload, "newcustomers", "  ''");
                if ($obj->status == 'OK') {
                    $nc_id = $this->db->insert_id();
                    $obj->message = "newcustomers entry created successfully";
                } else {
                    
                    $obj->message = "Sorry could not proceed, " . $nc_id_proof_no . " is already taken!";
                }
            } else {
                $obj->status = $this->App->updateDbIfNotExists(
                        array('from' => "newcustomers", 'where' => "nc_id = '$nc_id'",
                            'data' => $payload), "'' AND nc_id != '$nc_id'");
                if ($obj->status == 'OK') {
                    $obj->message = "newcustomers entry updated";
                } 
                else {
                    $obj->message = 'Sorry,Entered: ' . '' . " is already existing in DB";
                }
            }
        }
        $this->output->set_output(json_encode($obj, JSON_PRETTY_PRINT));
    }
     public function delete_obj($id) {

        	header("Access-Control-Allow-Origin: *");
          header("Access-Control-Request-Headers: GET,POST,OPTIONS,DELETE,PUT");
          header("Access-Control-Allow-Headers: authorization, Content-Type"); 

        $this->db->where('nc_id', $id);
        $delete = $this->db->delete('newcustomers');

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

}
