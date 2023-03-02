<?php

defined('BASEPATH') OR exit('No direct script access allowed');
class Addagent extends MY_Controller {
   
      public function __construct() {
        parent::__construct();
        $this->output->set_header('Access-Control-Allow-Origin: *');
        $this->output->set_header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization");
        $this->output->set_header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
        $this->output->set_content_type('application/json');
    }

    public function get_all_addagent() {
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

            $query = "ag_id > 0";


            $search_fields = "("
                    . "ag_id LIKE '%$search%'"
                    . " OR ag_name  LIKE '%$search%'"
                    . " OR ag_dob  LIKE '%$search%'"
                    . " OR ag_age  LIKE '%$search%'"
                    . " OR ag_gender LIKE '%$search%'"
                    . " OR ag_primary_number  LIKE '%$search%'"
                    . " OR ag_secondary_number  LIKE '%$search%'"
                    . " OR ag_education_qualification  LIKE '%$search%'"
                    . " OR ag_pan_number  LIKE '%$search%'"
                    . " OR ag_aadhaar_number  LIKE '%$search%'"
                    . " OR ag_martial_status  LIKE '%$search%'"
                    . " OR ag_permanant_address  LIKE '%$search%'"
                    . " OR ag_father_name  LIKE '%$search%'"
                    . " OR ag_father_phoneno  LIKE '%$search%'"
                    . " OR ag_father_adhar  LIKE '%$search%'"
                    . " OR ag_father_permanent_address  LIKE '%$search%'"
                    . " OR ag_mother_name  LIKE '%$search%'"
                    . " OR ag_mother_phoneno  LIKE '%$search%'"
                    . " OR ag_mother_adhar  LIKE '%$search%'"
                    . " OR ag_mother_permanent_address  LIKE '%$search%'"
                    . " OR ag_company_name  LIKE '%$search%'"
                    . " OR ag_company_phoneno  LIKE '%$search%'"
                    . " OR ag_company_email  LIKE '%$search%'"
                    . " OR ag_company_address  LIKE '%$search%'"
                    . " OR ag_ref_name_1  LIKE '%$search%'"
                    . " OR ag_ref_phoneno_1  LIKE '%$search%'"
                    . " OR ag_ref_adhar_1  LIKE '%$search%'"
                    . " OR ag_ref_permanent_address_1  LIKE '%$search%'"
                    . " OR ag_ref_name_2  LIKE '%$search%'"
                    . " OR ag_ref_adhar_2  LIKE '%$search%'"
                    . " OR ag_ref_permanent_address_2  LIKE '%$search%'"
                    . " OR ag_date_of_joining  LIKE '%$search%'"
                    . " OR ag_documents_provided  LIKE '%$search%'"
                    
                    . " OR ag_created_at LIKE '%$search%'"
                    . " OR ag_updated_at LIKE '%$search%'"
                    . ")";

            if (!empty($request->search)) {
                $query = $query . " AND " . $search_fields;
            }
            $joins = array(
            );
            $ct = $this->App->getFromDb(array('from' => 'addagent', 'fields' => "COUNT(ag_id) as total", 'join_left' => $joins, 'where' => $query));
            $rdata = $this->App->getFromDb(array('from' => 'addagent',
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

    public function add_edit_addagent() {
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
            $ag_created_at = date("Y-m-d H:i:s");
            $ag_updated_at = date("Y-m-d H:i:s");
            $ag_id = trim($request->ag_id);
            $ag_name = trim($request->ag_name);
            $ag_dob = trim($request->ag_dob);
            $ag_age = trim($request->ag_age);
            $ag_gender = trim($request->ag_gender);
            $ag_primary_number = trim($request->ag_primary_number);
            $ag_secondary_number = trim($request->ag_secondary_number);
            $ag_education_qualification = trim($request->ag_education_qualification);
            $ag_pan_number = trim($request->ag_pan_number);
            $ag_aadhaar_number = trim($request->ag_aadhaar_number);
            $ag_martial_status = trim($request->ag_martial_status);
            $ag_permanant_address = trim($request->ag_permanant_address);
            $ag_father_name = trim($request->ag_father_name);
            $ag_father_phoneno = trim($request->ag_father_phoneno);
            $ag_father_adhar = trim($request->ag_father_adhar);
            $ag_father_permanent_address = trim($request->ag_father_permanent_address);
            $ag_mother_name = trim($request->ag_mother_name);
            $ag_mother_phoneno = trim($request->ag_mother_phoneno);
            $ag_mother_adhar = trim($request->ag_mother_adhar);
            $ag_mother_permanent_address = trim($request->ag_mother_permanent_address);
            $ag_company_name = trim($request->ag_company_name);
            $ag_company_phoneno = trim($request->ag_company_phoneno);
            $ag_company_email = trim($request->ag_company_email);
            $ag_company_address = trim($request->ag_company_address);
            $ag_ref_name_1 = trim($request->ag_ref_name_1);
            $ag_ref_adhar_1 = trim($request->ag_ref_adhar_1);
            $ag_ref_permanent_address_1 = trim($request->ag_ref_permanent_address_1);
            $ag_ref_name_2 = trim($request->ag_ref_name_2);
            $ag_ref_phoneno_2 = trim($request->ag_ref_phoneno_2);
            $ag_ref_adhar_2 = trim($request->ag_ref_adhar_2);
            $ag_ref_permanent_address_2 = trim($request->ag_ref_permanent_address_2);
            $ag_date_of_joining = trim($request->ag_date_of_joining);
            $ag_documents_provided = trim($request->ag_documents_provided);
           
//            $ag_log = $log;
            $ag_created_at =$ag_created_at;
            $ag_updated_at=$ag_updated_at;
            $payload = array(
                'ag_name' => $ag_name,
                'ag_dob' => $ag_dob,
                'ag_age' => $ag_age,
                'ag_gender' => $ag_gender,
                'ag_primary_number' => $ag_primary_number,
                'ag_secondary_number' => $ag_secondary_number,
                'ag_education_qualification' => $ag_education_qualification,
                'ag_pan_number' => $ag_pan_number,
                'ag_aadhaar_number' => $ag_aadhaar_number,
                'ag_martial_status' => $ag_martial_status,
                'ag_permanant_address' => $ag_permanant_address,
                'ag_father_name' => $ag_father_name,
                'ag_father_phoneno' => $ag_father_phoneno,
                'ag_father_adhar' => $ag_father_adhar,
                'ag_father_permanent_address' => $ag_father_permanent_address,
                'ag_mother_name' => $ag_mother_name,
                'ag_mother_phoneno' => $ag_mother_phoneno,
                'ag_mother_adhar' => $ag_mother_adhar,
                'ag_mother_permanent_address' => $ag_mother_permanent_address,
                'ag_company_name' => $ag_company_name,
                'ag_company_phoneno' => $ag_company_phoneno,
                'ag_company_email' => $ag_company_email,
                'ag_company_address' => $ag_company_address,
                'ag_ref_name_1' => $ag_ref_name_1,
                'ag_ref_adhar_1' => $ag_ref_adhar_1,
                'ag_ref_permanent_address_1' => $ag_ref_permanent_address_1,
                'ag_ref_name_2' => $ag_ref_name_2,
                'ag_ref_phoneno_2' => $ag_ref_phoneno_2,
                'ag_ref_adhar_2' => $ag_ref_adhar_2,
                'ag_ref_permanent_address_2' => $ag_ref_permanent_address_2,
                'ag_date_of_joining' => $ag_date_of_joining,
                'ag_documents_provided' => $ag_documents_provided,
                
                
//                'ag_log' => $ag_log,
                'ag_created_at' =>$ag_created_at,
            'ag_updated_at'=>$ag_updated_at,
            );
            if ($ag_id == -1) {
                $payload['ag_created_at'] =  date("Y-m-d H:i:s");
                 $payload['ag_updated_at'] =  date("Y-m-d H:i:s");
                $obj->status = $this->App->insertDbIfNotExists($payload, "addagent", " ''");
                if ($obj->status == 'OK') {
                    $ag_id = $this->db->insert_id();
                    $obj->message = "addagent entry created successfully";
                } else {
                    //$obj->message = "Sorry could not proceed, " . $ac_no_of_members . " is already taken!";
                }
            } else {
                 $payload['ag_updated_at'] =  date("Y-m-d H:i:s");
                $obj->status = $this->App->updateDbIfNotExists(
                        array('from' => "addagent", 'where' => "ag_id = '$ag_id'",
                            'data' => $payload), "ag_pan_number = '$ag_pan_number' AND ag_id != '$ag_id'");
                if ($obj->status == 'OK') {
                    $obj->message = "addagent entry updated";
                } else {
                    $obj->message = 'Sorry,Entered: ' . $ag_pan_number . " is already existing in DB";
                }
            }
        }
        $this->output->set_output(json_encode($obj, JSON_PRETTY_PRINT));
    }

    

}
