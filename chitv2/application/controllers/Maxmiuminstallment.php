<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Maxmiuminstallment extends MY_Controller {
     public function __construct() {
        parent::__construct();
        $this->output->set_header('Access-Control-Allow-Origin: *');
        $this->output->set_header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization");
        $this->output->set_header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
        $this->output->set_content_type('application/json');
    }
    public function get_all_maxinstallment() {
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

            $query = "max_id > 0";


            $search_fields = "("
                    . "max_id LIKE '%$search%'"
                   // . " OR cs_chit_scheme   LIKE '%$search%'"
                    . " OR max_installment  LIKE '%$search%'"
                    . " OR max_no_of_installment  LIKE '%$search%'"
                    . " OR max_log LIKE '%$search%'"
                    . ")";

            if (!empty($request->search)) {
                $query = $query . " AND " . $search_fields;
            }
            $joins = array(
            );
            $ct = $this->App->getFromDb(array('from' => 'maxinstallment', 'fields' => "COUNT(max_id) as total", 'join_left' => $joins, 'where' => $query));
            $rdata = $this->App->getFromDb(array('from' => 'maxinstallment',
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
      public function add_edit_maxinstallment() {
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
            $log = date("Y-m-d H:i:s");
            $max_id = trim($request->max_id);
           // $cs_chit_scheme= trim($request->cs_chit_scheme);
          $max_installment= trim($request->max_installment);   
          $max_no_of_installment = trim($request -> max_no_of_installment);
            $max_log = $log;

            $payload = array(
                //'cs_chit_scheme' => $cs_chit_scheme,
                'max_installment' => $max_installment,
               'max_no_of_installment'=>$max_no_of_installment,
                'max_log' => $max_log,
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
            if ($max_id == -1) {
                $obj->status = $this->App->insertDbIfNotExists($payload, "maxinstallment", "  ''");
                if ($obj->status == 'OK') {
                    $cv_id = $this->db->insert_id();
                    $obj->message = "maxinstallment entry created successfully";
                } else {
//                    $obj->message = "Sorry could not proceed, " . $cs_chit_scheme . " is already taken!";
                }
            } else {
                $obj->status = $this->App->updateDbIfNotExists(
                        array('from' => "maxinstallment", 'where' => "max_id = '$max_id'",
                            'data' => $payload), "max_installment = '$max_installment' AND max_id != '$max_id'");
                if ($obj->status == 'OK') {
                    $obj->message = "maxinstallment entry updated";
                } else {
                    $obj->message = 'Sorry,Entered: ' . $max_installment . " is already existing in DB";
                }
            }
        }
        $this->output->set_output(json_encode($obj, JSON_PRETTY_PRINT));
    }
     public function delete_obj($id) {

        	header("Access-Control-Allow-Origin: *");
          header("Access-Control-Request-Headers: GET,POST,OPTIONS,DELETE,PUT");
          header("Access-Control-Allow-Headers: authorization, Content-Type"); 

        $this->db->where('max_id', $id);
        $delete = $this->db->delete('max_installment');

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
