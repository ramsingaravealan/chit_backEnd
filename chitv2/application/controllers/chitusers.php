<?php


class chitusers extends MY_Controller{
    public function __construct() {
        parent::__construct();
        $this->output->set_header('Access-Control-Allow-Origin: *');
        $this->output->set_header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization");
        $this->output->set_header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
        $this->output->set_content_type('application/json');
    }
    public function get_all_addchit() {
       
        $obj = new stdClass();
        $obj->status = "FAILED";
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);
        $obj->token_status = $this->decodedToken->status;
        if ($request && $this->decodedToken->status == 'OK') {
            $obj->status = "OK";


           
            $order_by = $request->order_by;
             $num_per_page = $request->num_per_page;
            $order = $request->order;
            $start_from = $request->start_from;
            $search = trim($request->search);

            $query = "cu_id > 0";


            $search_fields = "("
                    . "cu_id LIKE '%$search%'"
                    . " OR cu_nc_id  LIKE '%$search%'"
                    . " OR cu_ac_id  LIKE '%$search%'"
                    . " OR cu_created_at  LIKE '%$search%'"
                    . " OR cu_updated_at LIKE '%$search%'"
                  
                    . ")";

            if (!empty($request->search)) {
                $query = $query . " AND " . $search_fields;
            }
            $joins = array(
            );
            $ct = $this->App->getFromDb(array('from' => 'chit_users', 'fields' => "COUNT(cu_id) as total", 'join_left' => $joins, 'where' => $query));
            $rdata = $this->App->getFromDb(array('from' => 'chit_users',
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
     public function add_edit_chituser() {
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
            $cu_created = date("Y-m-d H:i:s");
             $cu_updated = date("Y-m-d H:i:s");
            $cu_id = trim($request->cu_id);
            $cu_nc_id= $request->cu_nc_id;
            $cu_ac_id= trim($request->cu_ac_id);
            $cu_created_at=$cu_created;
            $cu_updated_at=$cu_updated;


            $payload = array(
//                 'cu_id' => $cu_id,
//                'cu_nc_id' => $cu_nc_id,
                'cu_ac_id' => $cu_ac_id,
                'cu_created_at'=>$cu_created_at,
                'cu_updated_at'=>$cu_updated_at,
             );

             if ($cu_id == -1) {
                 $payload['cu_created_at'] =  date("Y-m-d H:i:s");
                 $payload['cu_updated_at'] =  date("Y-m-d H:i:s");
                 
                $obj->status = $this->App->insertDbIfNotExists($payload, "chit_users", "  ''");
                if ($obj->status == 'OK') {
                    $cu_id = $this->db->insert_id();
                     $this->set_selected_chituser_additional_options($cu_id, $cu_nc_id);
                    $obj->message = "chit_users entry created successfully";
                } else {
                    $obj->message = "Sorry could not proceed, " . $cu_id . " is already taken!";
                }
            } else {
                  $payload['cu_updated_at'] =  date("Y-m-d H:i:s");
                 
                $obj->status = $this->App->updateDbIfNotExists(
                        array('from' => "chit_users", 'where' => "cu_id = '$cu_id'",
                            'data' => $payload), "cu_id = '$cu_id' AND cu_id != '$cu_id'");
                if ($obj->status == 'OK') {
                     $this->set_selected_chituser_additional_options($cu_id, $cu_nc_id);
                    $obj->message = "chit_users entry updated";
                } else {
                    $obj->message = 'Sorry,Entered: ' . $cu_id . " is already existing in DB";
                }
            }
        }
        $this->output->set_output(json_encode($obj, JSON_PRETTY_PRINT));
    }
   public function get_all_newcustomer() {
        $obj = new stdClass();
        $obj->message = "";
        $obj->status = "OK";
        $search = $this->input->post('term');
        $query = "nc_customer_id LIKE '%$search%'";
        $data = $this->App->getFromDb(array(
            'from' => 'newcustomers',
//            'fields' => "nc_customer_id  as text, nc_name  as id,nc_phone  as value",
            'fields' => "nc_name  as text, nc_id  as id",
            'where' => $query,
            'orderkey' => 'nc_name',
            'order' => 'ASC',
        ));
        $obj->data = $data;
        $this->output->set_output(json_encode($obj, JSON_PRETTY_PRINT));
    }
public function get_selected_newcustomer() {
        $this->load->helper('string');
        $obj = new stdClass();
        $obj->status = "FAILED";
        $obj->message = "";
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);

        $obj->token_status = $this->decodedToken->status;
        if ($request && $this->decodedToken->status == 'OK' ) {
            $obj->status = "OK";
            $check_id = trim($request->id);
            $query = "nc_id = '$check_id'";
            $obj->data = $this->App->getFromDb(array('from' => 'newcustomers',
                'fields' => "nc_name as text, nc_id as id",
                'where' => $query,
                'orderkey' => 'nc_name',
                'order' => 'ASC',
            ));
        }
        $this->output->set_output(json_encode($obj, JSON_PRETTY_PRINT));
    }
  private function set_selected_chituser_additional_options($selfId, $data = array()) {
        $this->App->deleteDb(array(
            'from' => 'chit_user_additional_option_map',
            'where' => "cuaomap_cu_id = '$selfId'"
        ));
//        var_dump($data);
//        exit;
        foreach ($data as $obj) {
            $this->App->insertDb(array(
                'cuaomap_nc_id' => $obj->id,
                'cuaomap_cu_id' => $selfId), 'chit_user_additional_option_map');
        }
    }
}
