<?php

defined('BASEPATH') OR exit('No direct script access allowed');
class Chitvalue extends MY_Controller {
  
    public function __construct() {
        parent::__construct();
        $this->output->set_header('Access-Control-Allow-Origin: *');
        $this->output->set_header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization");
        $this->output->set_header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
        $this->output->set_content_type('application/json');
    }
     public function get_all_chitvalue() {
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

            $query = "cv_id > 0";


            $search_fields = "("
                    . "cv_id LIKE '%$search%'"
                   // . " OR cs_chit_scheme   LIKE '%$search%'"
                    . " OR cv_chit_value  LIKE '%$search%'"
//                     . " OR cv_max_installment_1  LIKE '%$search%'"
//                    . " OR cv_max_installment_2  LIKE '%$search%'"
//                    . " OR cv_max_installment_3  LIKE '%$search%'"
//                    . " OR cv_max_installment_4  LIKE '%$search%'"
//                    . " OR cv_max_installment_5  LIKE '%$search%'"
//                    . " OR cv_max_installment_6  LIKE '%$search%'"
//                    . " OR cv_max_installment_7  LIKE '%$search%'"
//                    . " OR cv_max_installment_8  LIKE '%$search%'"
//                    . " OR cv_max_installment_9  LIKE '%$search%'"
//                    . " OR cv_max_installment_10  LIKE '%$search%'"
//                    . " OR cv_max_installment_11  LIKE '%$search%'"
//                    . " OR cv_max_installment_12  LIKE '%$search%'"
//                    . " OR cv_max_installment_13  LIKE '%$search%'"
//                    . " OR cv_max_installment_14  LIKE '%$search%'"
//                    . " OR cv_max_installment_15  LIKE '%$search%'"
//                    . " OR cv_max_installment_16  LIKE '%$search%'"
//                    . " OR cv_max_installment_17  LIKE '%$search%'"
//                    . " OR cv_max_installment_18  LIKE '%$search%'"
//                    . " OR cv_max_installment_19  LIKE '%$search%'"
//                    . " OR cv_max_installment_20 LIKE '%$search%'"
//                    . " OR cv_max_installment_21  LIKE '%$search%'"
                    
//                    . " OR cv_log LIKE '%$search%'"
                    ." OR cv_created_at LIKE '%$search%'"
                     ." OR cv_updated_at LIKE '%$search%'"
                    . ")";

            if (!empty($request->search)) {
                $query = $query . " AND " . $search_fields;
            }
            $joins = array(
            );
            $ct = $this->App->getFromDb(array('from' => 'chit_value', 'fields' => "COUNT(cv_id) as total", 'join_left' => $joins, 'where' => $query));
            $rdata = $this->App->getFromDb(array('from' => 'chit_value',
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
    
    public function add_edit_chitvalue() {
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
//            $log = date("Y-m-d H:i:s");
            $cv_created_at=date("Y-m-d H:i:s");
            $cv_updated_at=date("Y-m-d H:i:s");
            $cv_id = trim($request->cv_id);
           // $cs_chit_scheme= trim($request->cs_chit_scheme);
          $cv_chit_value= trim($request->cv_chit_value);      
//            $cv_log = $log;
          $cv_created_at=$cv_created_at;
          $cv_updated_at=$cv_updated_at;

            $payload = array(
                //'cs_chit_scheme' => $cs_chit_scheme,
                'cv_chit_value' => $cv_chit_value,
//               'cv_max_installment_1' => $cv_max_installment_1,
//                'cv_max_installment_2' => $cv_max_installment_2,
//                'cv_max_installment_3' => $cv_max_installment_3,
//                'cv_max_installment_4' => $cv_max_installment_4,
//                'cv_max_installment_5' => $cv_max_installment_5,
//                'cv_max_installment_6' => $cv_max_installment_6,
//                'cv_max_installment_7' => $cv_max_installment_7,
//                'cv_max_installment_8' => $cv_max_installment_8,
//                'cv_max_installment_9' => $cv_max_installment_9,
//                'cv_max_installment_10' => $cv_max_installment_10,
//                'cv_max_installment_11' => $cv_max_installment_11,
//                'cv_max_installment_12' => $cv_max_installment_12,
//                'cv_max_installment_13' => $cv_max_installment_13,
//                'cv_max_installment_14' => $cv_max_installment_14,
//                'cv_max_installment_15' => $cv_max_installment_15,
//                'cv_max_installment_16' => $cv_max_installment_16,
//                'cv_max_installment_17' => $cv_max_installment_17,
//                'cv_max_installment_18' => $cv_max_installment_18,
//                'cv_max_installment_19' => $cv_max_installment_19,
//                'cv_max_installment_20' => $cv_max_installment_20,
//                'cv_max_installment_21' => $cv_max_installment_21,
                
                
                
//                'cv_log' => $cv_log,
                'cv_created_at'=>$cv_created_at,
                'cv_updated_at'=>$cv_updated_at
            );
//            if ($cs_id == -1) {
//                $obj->status = $this->App->insertDbIfNotExists($payload, "chit_scheme");
//                if ($obj->status == 'OK') {
//                    $nc_id = $this->db->insert_id();
//                    $obj->message = "Chitscheme entry created successfully";
//                } else {
//                    $obj->message = "Sorry could not proceed,  is already taken!";
//                }
//            } else {
//                $obj->status = $this->App->updateDbIfNotExists(
//                        array('from' => "addchits", 'where' => "cs_id = '$cs_id'",
//                            'data' => $payload));
//                if ($obj->status == 'OK') {
//                    $obj->message = "Chitscheme entry updated";
//                } else {
//                    $obj->message = "Sorry,Entered  is already existing in DB";
//                }
//            }
            if ($cv_id == -1) {
                $obj->status = $this->App->insertDbIfNotExists($payload, "chit_value", "  ''");
                if ($obj->status == 'OK') {
                    $cv_id = $this->db->insert_id();
                    $obj->message = "chit_value entry created successfully";
                } else {
//                    $obj->message = "Sorry could not proceed, " . $cs_chit_scheme . " is already taken!";
                }
            } else {
                $obj->status = $this->App->updateDbIfNotExists(
                        array('from' => "chit_value", 'where' => "cv_id = '$cv_id'",
                            'data' => $payload), "cv_chit_value = '$cv_chit_value' AND cv_id != '$cv_id'");
                if ($obj->status == 'OK') {
                    $obj->message = "chitvalue entry updated";
                } else {
                    $obj->message = 'Sorry,Entered: ' . $cv_chit_value . " is already existing in DB";
                }
            }
        }
        $this->output->set_output(json_encode($obj, JSON_PRETTY_PRINT));
    }
     public function delete_obj($id) {

        	header("Access-Control-Allow-Origin: *");
          header("Access-Control-Request-Headers: GET,POST,OPTIONS,DELETE,PUT");
          header("Access-Control-Allow-Headers: authorization, Content-Type"); 

        $this->db->where('cv_id', $id);
        $delete = $this->db->delete('chit_value');

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
