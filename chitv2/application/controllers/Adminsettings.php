<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Adminsettings extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('sendsms_helper');
    }

    public function get_all_admin_settings() {
//        $obj = new stdClass();
//        $obj->status = "FAILED";
//        $postdata = file_get_contents("php://input");
//        $request = json_decode($postdata);
//        $obj->token_status = $this->decodedToken->status;
//        if ($request && $this->decodedToken->status == 'OK') {
//            $obj->status = "OK";
//
//
//            $num_per_page = $request->num_per_page;
//            $order_by = $request->order_by;
//            $order = $request->order;
//            $start_from = $request->start_from;
//            $search = trim($request->search);
//
//            $query = "as_id > 0";
//
//
//            $search_fields = "("
//                    . "as_id LIKE '%$search%'"
//                    . " OR as_company_name LIKE '%$search%'"
//                    . " OR as_logo LIKE '%$search%'"
//                    . " OR as_email LIKE '%$search%'"
//                    . " OR as_website LIKE '%$search%'"
//                    . " OR as_address LIKE '%$search%'"
//                    . " OR as_phone_no LIKE '%$search%'"
//                    . " OR as_company_commission LIKE '%$search%'"
//                    . " OR as_bank_charge LIKE '%$search%'"
//                    . " OR as_company_service_tax LIKE '%$search%'"
//                    . " OR as_customer_service_tax LIKE '%$search%'"
//                    . " OR as_tds LIKE '%$search%'"
//                    . " OR as_agent_service_charge LIKE '%$search%'"
//                    . " OR as_agent_start_date LIKE '%$search%'"
//                    . " OR as_log LIKE '%$search%'"
//                    . ")";
//
//            if (!empty($request->search)) {
//                $query = $query . " AND " . $search_fields;
//            }
//            $joins = array(
//            );
//            $ct = $this->App->getFromDb(array('from' => 'admin_settings', 'fields' => "COUNT(as_id) as total", 'join_left' => $joins, 'where' => $query));
//            $rdata = $this->App->getFromDb(array('from' => 'admin_settings',
//                'fields' => "*",
//                'join_left' => $joins,
//                'where' => $query,
//                'orderkey' => $order_by,
//                'order' => $order,
//                'num' => $num_per_page,
//                'startfrom' => $start_from));
//
//            $obj->total = 0;
//            if (sizeof($ct) > 0) {
//                $obj->total = $ct[0]->total;
//            }
//            $pg = $obj->total / $num_per_page;
//            $pgRound = round($pg);
//            if ($pg > $pgRound) {
//                $pgRound = $pgRound + 1;
//            }
//            $obj->pages = $pgRound;
//            $obj->data = $rdata;
//            $obj->received = sizeof($rdata);
//        }
//
//        $this->output->set_output(json_encode($obj, JSON_PRETTY_PRINT));
    }

    public function add_edit_adminsetting() {
//        $this->load->helper('string');
//        $obj = new stdClass();
//        $obj->status = "FAILED";
//        $obj->message = "";
//        $postdata = file_get_contents("php://input");
//        $request = json_decode($postdata);
//
//        $obj->token_status = $this->decodedToken->status;
//        if ($request && $this->decodedToken->status == 'OK') {
//            $log = date("Y-m-d H:i:s");
//            $as_id = trim($request->as_id);
//            $as_company_name = ucwords(trim($request->as_company_name));
//            $as_logo = trim($request->as_logo);
//            $as_email = trim($request->as_email);
//            $as_website = trim($request->as_website);
//            $as_address = trim($request->as_address);
//            $as_phone_no = trim($request->as_phone_no);
//            $as_company_commission = trim($request->as_company_commission);
//            $as_bank_charge = trim($request->as_bank_charge);
//            $as_company_service_tax = trim($request->as_company_service_tax);
//            $as_customer_service_tax = trim($request->as_customer_service_tax);
//            $as_tds = trim($request->as_tds);
//            $as_agent_service_charge = trim($request->as_agent_service_charge);
//            $as_agent_start_date = trim($request->as_agent_start_date);
//            $as_log = $log;
//
//            $payload = array(
//                'as_company_name' => $as_company_name,
//                'as_logo' => $as_logo,
//                'as_email' => $as_email,
//                'as_website' => $as_website,
//                'as_address' => $as_address,
//                'as_phone_no' => $as_phone_no,
//                'as_company_commission' => $as_company_commission,
//                'as_bank_charge' => $as_bank_charge,
//                'as_company_service_tax' => $as_company_service_tax,
//                'as_customer_service_tax' => $as_customer_service_tax,
//                'as_tds' => $as_tds,
//                'as_agent_service_charge' => $as_agent_service_charge,
//                'as_agent_start_date' => $as_agent_start_date,
//                'as_log' => $as_log,
//            );
//            if ($as_id == -1) {
//                $obj->status = $this->App->insertDbIfNotExists($payload, "admin_settings", "as_company_name = '$as_company_name'");
//                if ($obj->status == 'OK') {
//                    $as_id = $this->db->insert_id();
//                    $obj->message = "AdminSetting entry created successfully";
//                } else {
//                    $obj->message = "Sorry could not proceed, " . $as_company_name . " is already taken!";
//                }
//            } else {
//                $obj->status = $this->App->updateDbIfNotExists(
//                        array('from' => "admin_settings", 'where' => "as_id = '$as_id'",
//                            'data' => $payload), "as_company_name = '$as_company_name' AND as_id != '$as_id'");
//                if ($obj->status == 'OK') {
//                    $obj->message = "AdminSetting entry updated";
//                } else {
//                    $obj->message = 'Sorry,Entered: ' . $as_company_name . " is already existing in DB";
//                }
//            }
//        }
//        $this->output->set_output(json_encode($obj, JSON_PRETTY_PRINT));
    }

}
