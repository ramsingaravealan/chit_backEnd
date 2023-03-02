<?php

defined('BASEPATH') OR exit('No direct script access allowed');
class Chitgroup extends MY_Controller {
     public function __construct() {
        parent::__construct();
        $this->output->set_header('Access-Control-Allow-Origin: *');
        $this->output->set_header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization");
        $this->output->set_header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
        $this->output->set_content_type('application/json');
    }
   public function getallchitgroup(){
        $this->output->set_header('Access-Control-Allow-Origin: *');
        $this->output->set_header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization");
        $this->output->set_header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
        $this->output->set_content_type('application/json');
//        $query="SELECT chit_scheme.cs_chit_scheme, chit_group.* FROM chit_scheme LEFT JOIN chit_group ON chit_scheme.cs_id = chit_group.cg_chit_scheme_id";
//      $str="chit_group','chit_scheme','chit_value";
//      if($_POST["search"])
//      {
//         $str = "("
//                    . "cg_id LIKE '%$search%'"
//                    . " OR cg_group_name   LIKE '%$search%'"
//                    . " OR cg_chit_scheme_id   LIKE '%$search%'"
//                    . " OR cg_chit_value_id  LIKE '%$search%'"
////                    . " OR cg_chit_month  LIKE '%$search%'"
//                    . " OR cg_chit_members  LIKE '%$search%'"
//
//                    . " OR cg_created_at LIKE '%$search%'"
//                    . " OR cg_updated_at LIKE '%$search%'"
//                    . ")";
//      }else{
//           $obj = new stdClass();
//        $obj->status = "FAILED";
//        $postdata = file_get_contents("php://input");
//        $request = json_decode($postdata);
//        $obj->token_status = $this->decodedToken->status;
//       if ($request && $this->decodedToken->status == 'OK') {
//           
//            $obj->status = "OK";
//
//
//            $num_per_page = $request->num_per_page;
//            $order_by = $request->order_by;
//            $order = $request->order;
//            $start_from = $request->start_from;
//            $search = trim($request->search);
//
//            $query = "cg_id > 0";
//
//
//            $search_fields = "("
//                    . "cg_id LIKE '%$search%'"
//                    . " OR cg_group_name   LIKE '%$search%'"
//                    . " OR cg_chit_scheme_id   LIKE '%$search%'"
//                    . " OR cg_chit_value_id  LIKE '%$search%'"
////                    . " OR cg_chit_month  LIKE '%$search%'"
//                    . " OR cg_chit_members  LIKE '%$search%'"
//
//                    . " OR cg_created_at LIKE '%$search%'"
//                    . " OR cg_updated_at LIKE '%$search%'"
//                    . ")";
//
//            if (!empty($request->search)) {
//                $query = $query . " AND " . $search_fields;
//            }
       $this->db->select('*');
	$this->db->from(['chit_group','chit_scheme','chit_value']);
        $joins = array("chit_scheme", "chit_scheme.cs_id = chit_group.cg_chit_scheme_id", "left");
        $joins = array("chit_value", "chit_value.cv_id = chit_group.cg_chit_value_id", "left");

        $this->db->where('chit_scheme.cs_id=chit_group.cg_chit_scheme_id');
        $this->db->where('chit_value.cv_id=chit_group.cg_chit_value_id');
// }
        $query = $this->db->get();
        //this is used for what query is running on last//
//         $str= $this->db->last_query();
//        echo"<pre>";
//        print_r($str);
//        exit;
        $response = array(
            'status' => 'success',
            'join' => $query->result(),
        );
//         $obj->total = 0;
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
  $this->output
                ->set_status_header(200)
                ->set_content_type('application/json')
                ->set_output(json_encode($response));
   }
  public function getallvalugroup(){
        
//        $query="SELECT chit_scheme.cs_chit_scheme, chit_group.* FROM chit_scheme LEFT JOIN chit_group ON chit_scheme.cs_id = chit_group.cg_chit_scheme_id";
      
      $this->db->select('*');
	$this->db->from(['chit_group','chit_value']);
        $joins = array("chit_value", "chit_value.cv_id = chit_group.cg_chit_value_id", "left");
        $this->db->where('chit_value.cv_id=chit_group.cg_chit_value_id');
        $query = $this->db->get();
        $response = array(
            'status' => 'success',
            'join' => $query->result(),
        );
        
  $this->output
                ->set_status_header(200)
                ->set_content_type('application/json')
                ->set_output(json_encode($response));
   }
  
        
    public function get_all_chitgroup() {
         $this->output->set_header('Access-Control-Allow-Origin: *');
        $this->output->set_header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization");
        $this->output->set_header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
        $this->output->set_content_type('application/json');
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

            $query = "cg_id > 0";


            $search_fields = "("
                    . "cg_id LIKE '%$search%'"
                    . " OR cg_group_name   LIKE '%$search%'"
                    . " OR cg_chit_scheme_id   LIKE '%$search%'"
                    . " OR cg_chit_value_id  LIKE '%$search%'"
//                    . " OR cg_chit_month  LIKE '%$search%'"
                    . " OR cg_chit_members  LIKE '%$search%'"

                    . " OR cg_created_at LIKE '%$search%'"
                    . " OR cg_updated_at LIKE '%$search%'"
                    . ")";

            if (!empty($request->search)) {
                $query = $query . " AND " . $search_fields;
            }
            $joins = array("chit_scheme", "chit_scheme.cs_id = chit_group.cg_chit_scheme_id", "left");
            $joins=[];
             $ct = $this->App->getFromDb(array('from' => 'chit_group', 'fields' =>  "COUNT(cg_id) as total" , 'join_left' => $joins, 'where' => $query));
           $rdata = $this->App->getFromDb(array('from' => 'chit_group',
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
            var_dump($rdata);
            exit;
            $obj->pages = $pgRound;
            $obj->data = $rdata;
            $obj->received = sizeof($rdata);
        }

        $this->output->set_output(json_encode($obj, JSON_PRETTY_PRINT));
    }
    
    public function add_edit_chitgroup() {
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
            $cg_created_at = date("Y-m-d H:i:s");
             $cg_updated_at = date("Y-m-d H:i:s");
            $cg_id = trim($request->cg_id);
            $cg_group_name= trim($request->cg_group_name);
            $cg_chit_scheme_id= trim($request->cg_chit_scheme_id);
            $cg_chit_value_id= trim($request->cg_chit_value_id);
//            $cg_chit_month= trim($request->cg_chit_month);
            $cg_chit_members= trim($request->cg_chit_members);

            $payload = array(
                 'cg_group_name' => $cg_group_name,
                'cg_chit_scheme_id' => $cg_chit_scheme_id,
                'cg_chit_value_id' => $cg_chit_value_id,
//                'cg_chit_month' => $cg_chit_month,
                'cg_chit_members' => $cg_chit_members,
             );

             if ($cg_id == -1) {
                 $payload['cg_created_at'] =  date("Y-m-d H:i:s");
                 $payload['cg_updated_at'] =  date("Y-m-d H:i:s");
                 
                $obj->status = $this->App->insertDbIfNotExists($payload, "chit_group", "  ''");
                if ($obj->status == 'OK') {
                    $cg_id = $this->db->insert_id();
                    $obj->message = "chit_group entry created successfully";
                } else {
                    $obj->message = "Sorry could not proceed, " . $cs_chit_scheme . " is already taken!";
                }
            } else {
                  $payload['cg_updated_at'] =  date("Y-m-d H:i:s");
                 
                $obj->status = $this->App->updateDbIfNotExists(
                        array('from' => "chit_group", 'where' => "cg_id = '$cg_id'",
                            'data' => $payload), "cg_group_name = '$cg_group_name' AND cg_id != '$cg_id'");
                if ($obj->status == 'OK') {
                    $obj->message = "chit_group entry updated";
                } else {
                    $obj->message = 'Sorry,Entered: ' . $cg_group_name . " is already existing in DB";
                }
            }
        }
        $this->output->set_output(json_encode($obj, JSON_PRETTY_PRINT));
    }
    

public function get_all_chitscheme() {
        $obj = new stdClass();
        $obj->message = "";
        $obj->status = "OK";
        $search = $this->input->post('term');
        $query = "cs_chit_scheme LIKE '%$search%'";
        // $query = "vr_room_name LIKE '%$search%'";
//        $query .= " AND vr_active = 'Y'";
        $data = $this->App->getFromDb(array(
            'from' => 'chit_scheme',
            'fields' => "cs_chit_scheme as text, cs_id as id",
            'where' => $query,
            'orderkey' => "cs_chit_scheme",
            'order' => 'ASC',
        ));
        $obj->data = $data;
        $this->output->set_output(json_encode($obj, JSON_PRETTY_PRINT));
    }
    public function get_selected_chitscheme() {
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
            $query = "cs_id = '$check_id'";
            $obj->data = $this->App->getFromDb(array('from' => 'chit_scheme',
                'fields' => "cs_chit_scheme as text, cs_id as id",
                'where' => $query,
                'orderkey' => 'cs_chit_scheme',
                'order' => 'ASC',
            ));
        }
        $this->output->set_output(json_encode($obj, JSON_PRETTY_PRINT));
    }
    public function left_chitscheme(){
//        $this->db->select('*');
        $lt="SELECT chit_scheme.cs_chit_scheme, chit_group.* FROM chit_scheme LEFT JOIN chit_group ON chit_scheme.cs_id = chit_group.cg_chit_scheme_id";
    
         $data = $lt;
        $this->output->set_output(json_encode($data, JSON_PRETTY_PRINT));
    }


     
    public function get_all_chitvalue() {
        $obj = new stdClass();
        $obj->message = "";
        $obj->status = "OK";
        $search = $this->input->post('term');
        $query = "cv_chit_value LIKE '%$search%'";
        $data = $this->App->getFromDb(array(
            'from' => 'chit_value',
            'fields' => "cv_chit_value  as text, cv_id as id",
            'where' => $query,
            'orderkey' => 'cv_chit_value',
            'order' => 'ASC',
        ));
        $obj->data = $data;
        $this->output->set_output(json_encode($obj, JSON_PRETTY_PRINT));
    }

    public function get_selected_chitvalue() {
        $this->load->helper('string');
        $obj = new stdClass();
        $obj->status = "FAILED";
        $obj->message = "";
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);

        //$obj->token_status = $this->decodedToken->status;
        if ($request ) {
            $obj->status = "OK";
            $check_id = trim($request->id);
            $query = "cv_id = '$check_id'";
            $obj->data = $this->App->getFromDb(array('from' => 'chit_value',
                'fields' => "cv_chit_value as text, cv_id as id",
                'where' => $query,
                'orderkey' => 'cv_chit_value',
                'order' => 'ASC',
            ));
        }
        $this->output->set_output(json_encode($obj, JSON_PRETTY_PRINT));
    }
    public function left_chitvalue(){
        $this->db->select('*');
        $lt="SELECT cv_chit_value
FROM chit_value
LEFT JOIN chit_group
ON chit_value.cv_chit_value = chit_group.cg_chit_value_id";
    }
     public function delete_obj($id) {

        	header("Access-Control-Allow-Origin: *");
          header("Access-Control-Request-Headers: GET,POST,OPTIONS,DELETE,PUT");
          header("Access-Control-Allow-Headers: authorization, Content-Type"); 

        $this->db->where('cg_id', $id);
        $delete = $this->db->delete('chit_group');

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
