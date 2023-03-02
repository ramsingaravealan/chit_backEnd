<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class Translations extends MY_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function get_all_translations() {
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


            $query = "trx_id > 0";

            $search_fields = "(trx_id LIKE '%$search%' OR trx_key LIKE '%$search%' OR trx_en LIKE '%$search%' OR trx_es LIKE '%$search%' OR trx_ln1 LIKE '%$search%' OR trx_ln2 LIKE '%$search%' OR trx_ln3 LIKE '%$search%' OR trx_ln4 LIKE '%$search%' OR trx_active LIKE '%$search%' OR trx_log LIKE '%$search%')";
            if (!empty($request->search)) {
                $query = $query . " AND " . $search_fields;
            }
            $joins = array(
            );
            $ct = $this->App->getFromDb(array('from' => 'translations', 'fields' => "COUNT(trx_id) as total", 'join_left' => $joins, 'where' => $query));
            $rdata = $this->App->getFromDb(array('from' => 'translations',
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

    public function mass_edit_translation() {
        $this->load->helper('string');
        $obj = new stdClass();
        $obj->status = "FAILED";
        $obj->message = "";
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);

        $obj->token_status = $this->decodedToken->status;
        if ($request && $this->decodedToken->status == 'OK') {
            //$user_backoffice_admin_id = $request->user_backoffice_admin_id;
            //$this->setTimeZone($user_backoffice_admin_id);
            $log = date("Y-m-d H:i:s");

//            $trx_id = trim($request->trx_id);
//            $trx_key = strtolower(trim($request->trx_key));
//            $trx_en = trim($request->trx_en);
//            $trx_es = trim($request->trx_es);
//            $trx_ln1 = trim($request->trx_ln1);
//            $trx_ln2 = trim($request->trx_ln2);
//            $trx_ln3 = trim($request->trx_ln3);
//            $trx_ln4 = trim($request->trx_ln4);
//            $trx_active = trim($request->trx_active);
//            $trx_log = trim($log);

            $payloads = $request->payload;

            foreach ($payloads as $value) {
                $trx_id = $value->trx_id;
                $this->App->updateDb(
                        array('from' => "translations", 'where' => "trx_id = '$trx_id'",
                            'data' => array(
                                'trx_en' => $value->trx_en,
                                'trx_es' => $value->trx_es,
                                'trx_ln1' => $value->trx_ln1,
                                'trx_ln2' => $value->trx_ln2,
                                'trx_ln3' => $value->trx_ln3,
                                'trx_ln4' => $value->trx_ln4,
                                //'trx_active' => $value->trx_active,
                                'trx_log' => $log,
                )));
            }


            $obj->status = "OK";
            $obj->message = "Translation entry updated";
//            $obj->updated = $this->App->getFromDb(array(
//                'from' => 'translations',
//                'where' => "trx_id = '$trx_id'"
//            ));
        }
        $this->output->set_output(json_encode($obj, JSON_PRETTY_PRINT));
    }

    public function add_edit_translation() {
        $this->load->helper('string');
        $obj = new stdClass();
        $obj->status = "FAILED";
        $obj->message = "";
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);

        $obj->token_status = $this->decodedToken->status;
        if ($request && $this->decodedToken->status == 'OK') {
            //$user_backoffice_admin_id = $request->user_backoffice_admin_id;
            //$this->setTimeZone($user_backoffice_admin_id);
            $log = date("Y-m-d H:i:s");

            $trx_id = trim($request->trx_id);
            //$trx_key = strtolower(trim($request->trx_key));
            $trx_key = trim($request->trx_key);
            $trx_en = trim($request->trx_en);
            $trx_es = trim($request->trx_es);
            $trx_ln1 = trim($request->trx_ln1);
            $trx_ln2 = trim($request->trx_ln2);
            $trx_ln3 = trim($request->trx_ln3);
            $trx_ln4 = trim($request->trx_ln4);
           // $trx_active = trim($request->trx_active);
            $trx_log = trim($log);

            if ($trx_id == -1) {
                $obj->status = $this->App->insertDbIfNotExists(array(
                    'trx_key' => $trx_key,
                    'trx_en' => $trx_en,
                    'trx_es' => $trx_es,
                    'trx_ln1' => $trx_ln1,
                    'trx_ln2' => $trx_ln2,
                    'trx_ln3' => $trx_ln3,
                    'trx_ln4' => $trx_ln4,
                    //'trx_active' => $trx_active,
                    'trx_log' => $trx_log,
                        ), "translations", "trx_key = '$trx_key'");
                if ($obj->status == 'OK') {
                    $trx_id = $this->db->insert_id();
                    $obj->message = "Translation entry created successfully";
                } else {
                    $obj->message = "Sorry could not proceed, " . $trx_key . " is already taken!";
                }
            } else {
                $obj->status = $this->App->updateDbIfNotExists(
                        array('from' => "translations", 'where' => "trx_id = '$trx_id'",
                            'data' => array(
                                'trx_key' => $trx_key,
                                'trx_en' => $trx_en,
                                'trx_es' => $trx_es,
                                'trx_ln1' => $trx_ln1,
                                'trx_ln2' => $trx_ln2,
                                'trx_ln3' => $trx_ln3,
                                'trx_ln4' => $trx_ln4,
                                //'trx_active' => $trx_active,
                                'trx_log' => $trx_log,
                            )), "trx_key = '$trx_key' AND trx_id != '$trx_id'");
                if ($obj->status == 'OK') {
                    $obj->message = "Translation entry updated";
                    $obj->updated = $this->App->getFromDb(array(
                        'from' => 'translations',
                        'where' => "trx_id = '$trx_id'"
                    ));
                } else {
                    $obj->message = 'Sorry,Entered: ' . $trx_key . " is already existing in DB";
                }
            }
        }
        $this->output->set_output(json_encode($obj, JSON_PRETTY_PRINT));
    }

    public function getlang() {
        $obj = new stdClass();
        $obj->status = "OK";
        $obj->message = "";
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);
        if ($request) {
            $trs = $this->App->getFromDb(array(
                'from' => 'translations'
            ));
            $lang = $request->lang;
            $objLang = array();
            foreach ($trs as $value) {
                if ($lang == 'en') {
                    $objLang[$value->trx_key] = $value->trx_en;
                } else if ($lang == 'es') {
                    $objLang[$value->trx_key] = $value->trx_es;
                }
            }
            $obj->data = $objLang;
        }


        $this->output->set_output(json_encode($obj, JSON_PRETTY_PRINT));
    }

}
