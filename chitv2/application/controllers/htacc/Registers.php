<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Registers extends MY_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function get_all_registers() {
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

            $query = "reg_id > 0";

            $search_fields = "("
                    . "reg_id LIKE '%$search%'"
                    . " OR reg_full_name LIKE '%$search%'"
                    . " OR reg_email LIKE '%$search%'"
                    . " OR reg_password LIKE '%$search%'"
                    . " OR reg_primary_address LIKE '%$search%'"
                    . " OR reg_country_id LIKE '%$search%'"
                    . " OR reg_state_id LIKE '%$search%'"
                    . " OR reg_city_id LIKE '%$search%'"
                    . " OR reg_phone_number LIKE '%$search%'"
                    . " OR reg_photo LIKE '%$search%'"
                    . " OR reg_active LIKE '%$search%'"
                    . " OR reg_log LIKE '%$search%'"
                    . ")";

            if (!empty($request->search)) {
                $query = $query . " AND " . $search_fields;
            }
            $joins = array(
            );
            $ct = $this->App->getFromDb(array('from' => 'registers', 'fields' => "COUNT(reg_id) as total", 'join_left' => $joins, 'where' => $query));
            $rdata = $this->App->getFromDb(array('from' => 'registers',
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

    public function add_edit_register() {
        $this->load->helper('string');
        $obj = new stdClass();
        $obj->status = "FAILED";
        $obj->message = "";
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);

        $obj->token_status = $this->decodedToken->status;
        if ($request && $this->decodedToken->status == 'OK') {
            $log = date("Y-m-d H:i:s");
            $reg_id = trim($request->reg_id);
            $reg_full_name = ucwords(trim($request->reg_full_name));
            $reg_email = trim($request->reg_email);
            $reg_password = trim($request->reg_password);
            $reg_primary_address = trim($request->reg_primary_address);
            $reg_country_id = trim($request->reg_country_id);
            $reg_state_id = trim($request->reg_state_id);
            $reg_city_id = trim($request->reg_city_id);
            $reg_phone_number = trim($request->reg_phone_number);
            $reg_photo = trim($request->reg_photo);
            $reg_active = trim($request->reg_active);
            $reg_log = $log;

            $payload = array(
                'reg_full_name' => $reg_full_name,
                'reg_email' => $reg_email,
                'reg_password' => $reg_password,
                'reg_primary_address' => $reg_primary_address,
                'reg_country_id' => $reg_country_id,
                'reg_state_id' => $reg_state_id,
                'reg_city_id' => $reg_city_id,
                'reg_phone_number' => $reg_phone_number,
                'reg_photo' => $reg_photo,
                'reg_active' => $reg_active,
                'reg_log' => $reg_log,
            );
            if (empty($reg_password)) {
                unset($payload["reg_password"]);
            } else {
                $payload["reg_password"] = $this->encryption->encrypt($reg_password);
            }
            if ($reg_id == -1) {
                $obj->status = $this->App->insertDbIfNotExists($payload, "registers", "reg_full_name = '$reg_full_name'");
                if ($obj->status == 'OK') {
                    $reg_id = $this->db->insert_id();
                    $obj->message = "EndUser entry created successfully";
                } else {
                    $obj->message = "Sorry could not proceed, " . $reg_full_name . " is already taken!";
                }
            } else {
                $obj->status = $this->App->updateDbIfNotExists(
                        array('from' => "registers", 'where' => "reg_id = '$reg_id'",
                            'data' => $payload), "reg_full_name = '$reg_full_name' AND $reg_id != '$$reg_id'");
                if ($obj->status == 'OK') {
                    $obj->message = "EndUser entry updated";
                } else {
                    $obj->message = 'Sorry,Entered: ' . $reg_full_name . " is already existing in DB";
                }
            }
        }
        $this->output->set_output(json_encode($obj, JSON_PRETTY_PRINT));
    }
        public function get_all_country_countries(){
        $obj = new stdClass();
        $obj->message = "";
        $obj->status = "OK";
        $search = $this->input->post('term');
                $query = "name LIKE '%$search%'";
                        $data = $this->App->getFromDb(array(
            'from' => 'countries',
            'fields' => "name as text, id as id",
            'where' => $query,
            'orderkey' => 'name',
            'order' => 'ASC',
        ));
        $obj->data = $data;
        $this->output->set_output(json_encode($obj, JSON_PRETTY_PRINT));
    }
    public function get_selected_countries() {
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
            $query = "id = '$check_id'";
            $obj->data = $this->App->getFromDb(array('from' => 'countries',
                'fields' => "name as text, id as id",
                'where' => $query,
                'orderkey' => 'name',
                'order' => 'ASC',
            ));
        }
        $this->output->set_output(json_encode($obj, JSON_PRETTY_PRINT));
    }
    public function get_all_state_states(){
        $obj = new stdClass();
        $obj->message = "";
        $obj->status = "OK";
        $search = $this->input->post('term');
                $enduser_country_id = $this->input->post('reg_country_id');
                $query = "name LIKE '%$search%'";
                                $query .= " AND country_id = '$reg_country_id'";
            
                        $data = $this->App->getFromDb(array(
            'from' => 'states',
            'fields' => "name as text, id as id",
            'where' => $query,
            'orderkey' => 'name',
            'order' => 'ASC',
        ));
        $obj->data = $data;
        $this->output->set_output(json_encode($obj, JSON_PRETTY_PRINT));
    }
    public function get_selected_states() {
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
            $query = "id = '$check_id'";
            $obj->data = $this->App->getFromDb(array('from' => 'states',
                'fields' => "name as text, id as id",
                'where' => $query,
                'orderkey' => 'name',
                'order' => 'ASC',
            ));
        }
        $this->output->set_output(json_encode($obj, JSON_PRETTY_PRINT));
    }
    public function get_all_city_cities(){
        $obj = new stdClass();
        $obj->message = "";
        $obj->status = "OK";
        $search = $this->input->post('term');
                $enduser_state_id = $this->input->post('reg_state_id');
                $query = "name LIKE '%$search%'";
                                $query .= " AND state_id = '$reg_state_id'";
            
                        $data = $this->App->getFromDb(array(
            'from' => 'cities',
            'fields' => "name as text, id as id",
            'where' => $query,
            'orderkey' => 'name',
            'order' => 'ASC',
        ));
        $obj->data = $data;
        $this->output->set_output(json_encode($obj, JSON_PRETTY_PRINT));
    }
    public function get_selected_cities() {
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
            $query = "id = '$check_id'";
            $obj->data = $this->App->getFromDb(array('from' => 'cities',
                'fields' => "name as text, id as id",
                'where' => $query,
                'orderkey' => 'name',
                'order' => 'ASC',
            ));
        }
        $this->output->set_output(json_encode($obj, JSON_PRETTY_PRINT));
    }
}
