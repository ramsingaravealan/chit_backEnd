<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->output->set_header('Access-Control-Allow-Origin: *');
        $this->output->set_header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization");
        $this->output->set_header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
        $this->output->set_content_type('application/json');
    }

    public function get_all_users() {
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

            $query = "user_id > 0";


            $search_fields = "("
                    . "user_id LIKE '%$search%'"
                    . " OR user_name LIKE '%$search%'"
                    . " OR user_email LIKE '%$search%'"
                    . " OR user_password LIKE '%$search%'"
                    . " OR user_log LIKE '%$search%'"
                    . ")";

            if (!empty($request->search)) {
                $query = $query . " AND " . $search_fields;
            }
            $joins = array(
            );
            $ct = $this->App->getFromDb(array('from' => 'users', 'fields' => "COUNT(user_id) as total", 'join_left' => $joins, 'where' => $query));
            $rdata = $this->App->getFromDb(array('from' => 'users',
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

    public function add_edit_user() {
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
            $user_id = trim($request->user_id);
            $user_email = trim($request->user_email);
            $user_password = trim($request->user_password);
            $user_name = ucwords(trim($request->user_name));
//                                                            $user_type = trim($request->user_type);
            $user_log = $log;

            $payload = array(
                'user_email' => $user_email,
                'user_password' => $user_password,
                'user_name' => $user_name,
//                                            'user_type' => $user_type,
                'user_log' => $user_log,
            );
            if (empty($user_password)) {
                unset($payload["user_password"]);
            } else {
                $payload["user_password"] = $this->encryption->encrypt($user_password);
            }
            if ($user_id == -1) {
                $obj->status = $this->App->insertDbIfNotExists($payload, "users", "user_email = '$user_email'");
                if ($obj->status == 'OK') {
                    $user_id = $this->db->insert_id();
                    $obj->message = "User entry created successfully";
                } else {
                    $obj->message = "Sorry could not proceed, " . $user_email . " is already taken!";
                }
            } else {
                $obj->status = $this->App->updateDbIfNotExists(
                        array('from' => "users", 'where' => "user_id = '$user_id'",
                            'data' => $payload), "user_email = '$user_email' AND user_id != '$user_id'");
                if ($obj->status == 'OK') {
                    $obj->message = "User entry updated";
                } else {
                    $obj->message = 'Sorry,Entered: ' . $user_email . " is already existing in DB";
                }
            }
        }
        $this->output->set_output(json_encode($obj, JSON_PRETTY_PRINT));
    }
     public function delete_obj($id) {

        	header("Access-Control-Allow-Origin: *");
          header("Access-Control-Request-Headers: GET,POST,OPTIONS,DELETE,PUT");
          header("Access-Control-Allow-Headers: authorization, Content-Type"); 

        $this->db->where('user_id', $id);
        $delete = $this->db->delete('users');

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
