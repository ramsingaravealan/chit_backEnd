<?php

defined('BASEPATH') OR exit('No direct script access allowed');
class Chitscheme extends MY_Controller {
   public function __construct() {
        parent::__construct();
        $this->output->set_header('Access-Control-Allow-Origin: *');
        $this->output->set_header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization");
        $this->output->set_header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
        $this->output->set_content_type('application/json');
    }
     public function get_all_chitscheme() {
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

            $query = "cs_id > 0";


            $search_fields = "("
                    . "cs_id LIKE '%$search%'"
                    . " OR cs_chit_scheme   LIKE '%$search%'"
                    . " OR cs_chit_month  LIKE '%$search%'"
//                    . " OR cs_log LIKE '%$search%'"
                    ."OR cs_created_at LIKE '%$search%' "
                     ."OR cs_updated_at LIKE '%$search%' "
                    . ")";

            if (!empty($request->search)) {
                $query = $query . " AND " . $search_fields;
            }
            $joins = array(
            );
            $ct = $this->App->getFromDb(array('from' => 'chit_scheme', 'fields' => "COUNT(cs_id) as total", 'join_left' => $joins, 'where' => $query));
            $rdata = $this->App->getFromDb(array('from' => 'chit_scheme',
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
    
    public function add_edit_chitscheme() {
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
            $cs_created_at = date("Y-m-d H:i:s");
             $cs_updated_at = date("Y-m-d H:i:s");
            $cs_id = trim($request->cs_id);
            $cs_chit_scheme= trim($request->cs_chit_scheme);
             $cs_chit_month= trim($request->cs_chit_month);
//            $cs_chit_value= trim($request->cs_chit_value);      
//            $cs_log = $log;
             $cs_created_at=$cs_created_at;
$cs_updated_at=$cs_updated_at;
            $payload = array(
                'cs_chit_scheme' => $cs_chit_scheme,
                'cs_chit_month' => $cs_chit_month,
                'cs_created_at' => $cs_created_at,
                'cs_updated_at' => $cs_updated_at
//                'cs_log' => $cs_log,
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
            if ($cs_id == -1) {
                $obj->status = $this->App->insertDbIfNotExists($payload, "chit_scheme", "  ''");
                if ($obj->status == 'OK') {
                    $cs_id = $this->db->insert_id();
                    $obj->message = "chit_scheme entry created successfully";
                } else {
//                    $obj->message = "Sorry could not proceed, " . $cs_chit_scheme . " is already taken!";
                }
            } else {
                $obj->status = $this->App->updateDbIfNotExists(
                        array('from' => "chit_scheme", 'where' => "cs_id = '$cs_id'",
                            'data' => $payload), "cs_chit_scheme = '$cs_chit_scheme' AND cs_id != '$cs_id'");
                if ($obj->status == 'OK') {
                    $obj->message = "chitscheme entry updated";
                } else {
                    $obj->message = 'Sorry,Entered: ' . $cs_chit_scheme . " is already existing in DB";
                }
            }
        }
        $this->output->set_output(json_encode($obj, JSON_PRETTY_PRINT));
    }
     public function delete_obj($id) {

        	header("Access-Control-Allow-Origin: *");
          header("Access-Control-Request-Headers: GET,POST,OPTIONS,DELETE,PUT");
          header("Access-Control-Allow-Headers: authorization, Content-Type"); 

        $this->db->where('cs_id', $id);
        $delete = $this->db->delete('chit_scheme');

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
