<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Customerdetails extends MY_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function get_all_customer_details() {
        
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

            $query = "cd_id > 0";

            $search_fields = "("
                    . "cd_id LIKE '%$search%'"
                    . " OR cd_name LIKE '%$search%'"
                    . " OR cd_dob LIKE '%$search%'"
                    . " OR cd_father_name LIKE '%$search%'"
                    . " OR cd_age LIKE '%$search%'"
                    . " OR cd_gender LIKE '%$search%'"
                    . " OR cd_marital_status LIKE '%$search%'"
                    . " OR cd_name_of_spouse LIKE '%$search%'"
                    . " OR cd_local_address LIKE '%$search%'"
                    . " OR cd_permanent_address LIKE '%$search%'"
                    . " OR cd_phone LIKE '%$search%'"
                    . " OR cd_name_of_the_office LIKE '%$search%'"
                    . " OR cd_office_address LIKE '%$search%'"
                    . " OR cd_designation LIKE '%$search%'"
                    . " OR cd_salary LIKE '%$search%'"
                    . " OR cd_pan_no LIKE '%$search%'"
                    . " OR cd_nominee_name LIKE '%$search%'"
                    . " OR cd_nominee_relationship LIKE '%$search%'"
                    . " OR cd_nominee_age LIKE '%$search%'"
                    . " OR cd_existing_subscriber LIKE '%$search%'"
                    . " OR cd_smcf_id_no LIKE '%$search%'"
                    . " OR cd_photo LIKE '%$search%'"
                    . " OR cd_log LIKE '%$search%'"
                    . ")";

            if (!empty($request->search)) {
                $query = $query . " AND " . $search_fields;
            }
            $joins = array(
            );
            $ct = $this->App->getFromDb(array('from' => 'customer_details', 'fields' => "COUNT(cd_id) as total", 'join_left' => $joins, 'where' => $query));
            $rdata = $this->App->getFromDb(array('from' => 'customer_details',
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

    public function add_edit_customer_detail() {
        $this->load->helper('string');
        $obj = new stdClass();
        $obj->status = "FAILED";
        $obj->message = "";
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);

        $obj->token_status = $this->decodedToken->status;
        if ($request && $this->decodedToken->status == 'OK') {
            $log = date("Y-m-d H:i:s");
            $rno= 'SSMC'.'-'.'8';
            $d=date('y');
            $month=date('m');
            $rand=rand(10,100);
            $receipt=$rno.$d.$month;
//for($i = 0; $i < 74; $i++){
//    $receipt++;
//    if(substr($receipt, 5) == '100'){
//    continue;
//    }
//}
            $cd_id = trim($request->cd_id);
            $cd_receipt_id=$receipt;
            $cd_name = ucwords(trim($request->cd_name));
            $cd_dob = trim($request->cd_dob);
            $cd_father_name = trim($request->cd_father_name);
            $cd_age = trim($request->cd_age);
            $cd_gender = trim($request->cd_gender);
            $cd_marital_status = trim($request->cd_marital_status);
            $cd_name_of_spouse = trim($request->cd_name_of_spouse);
            $cd_local_address = trim($request->cd_local_address);
            $cd_permanent_address = trim($request->cd_permanent_address);
            $cd_phone = trim($request->cd_phone);
            $cd_name_of_the_office = trim($request->cd_name_of_the_office);
            $cd_office_address = trim($request->cd_office_address);
            $cd_designation = trim($request->cd_designation);
            $cd_salary = trim($request->cd_salary);
            $cd_pan_no = trim($request->cd_pan_no);
            $cd_nominee_name = trim($request->cd_nominee_name);
            $cd_nominee_relationship = trim($request->cd_nominee_relationship);
            $cd_nominee_age = trim($request->cd_nominee_age);
            $cd_existing_subscriber = trim($request->cd_existing_subscriber);
            $cd_smcf_id_no = trim($request->cd_smcf_id_no);
            $cd_photo = trim($request->cd_photo);
            $cd_log = $log;

            $payload = array(
                'cd_receipt_id'=>$cd_receipt_id,
                'cd_name' => $cd_name,
                'cd_dob' => $cd_dob,
                'cd_father_name' => $cd_father_name,
                'cd_age' => $cd_age,
                'cd_gender' => $cd_gender,
                'cd_marital_status' => $cd_marital_status,
                'cd_name_of_spouse' => $cd_name_of_spouse,
                'cd_local_address' => $cd_local_address,
                'cd_permanent_address' => $cd_permanent_address,
                'cd_phone' => $cd_phone,
                'cd_name_of_the_office' => $cd_name_of_the_office,
                'cd_office_address' => $cd_office_address,
                'cd_designation' => $cd_designation,
                'cd_salary' => $cd_salary,
                'cd_pan_no' => $cd_pan_no,
                'cd_nominee_name' => $cd_nominee_name,
                'cd_nominee_relationship' => $cd_nominee_relationship,
                'cd_nominee_age' => $cd_nominee_age,
                'cd_existing_subscriber' => $cd_existing_subscriber,
                'cd_smcf_id_no' => $cd_smcf_id_no,
                'cd_photo' => $cd_photo,
                'cd_log' => $cd_log,
            );
            if ($cd_id == -1) {
                $obj->status = $this->App->insertDbIfNotExists($payload, "customer_details", "cd_name = '$cd_name'");
                if ($obj->status == 'OK') {
                    $cd_id = $this->db->insert_id();
                    $obj->message = "AdminSetting entry created successfully";
                } else {
                    $obj->message = "Sorry could not proceed, " . $cd_name . " is already taken!";
                }
            } else {
                $obj->status = $this->App->updateDbIfNotExists(
                        array('from' => "customer_details", 'where' => "cd_id = '$cd_id'",
                            'data' => $payload), "cd_name = '$cd_name' AND cd_id != '$cd_id'");
                if ($obj->status == 'OK') {
                    $obj->message = "AdminSetting entry updated";
                } else {
                    $obj->message = 'Sorry,Entered: ' . $cd_name . " is already existing in DB";
                }
            }
        }
        $this->output->set_output(json_encode($obj, JSON_PRETTY_PRINT));
    }
     public function delete_obj($id) {

        	header("Access-Control-Allow-Origin: *");
          header("Access-Control-Request-Headers: GET,POST,OPTIONS,DELETE,PUT");
          header("Access-Control-Allow-Headers: authorization, Content-Type"); 

        $this->db->where('cd_id', $id);
        $delete = $this->db->delete('customer_details');

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
