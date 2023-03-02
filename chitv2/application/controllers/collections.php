<?php

defined('BASEPATH') OR exit('No direct script access allowed');
class collections extends MY_Controller {
     public function __construct() {
        parent::__construct();
        $this->output->set_header('Access-Control-Allow-Origin: *');
        $this->output->set_header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization");
        $this->output->set_header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
        $this->output->set_content_type('application/json');
    }
    
public function get_all_collections() {
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


//            $num_per_page = $request->num_per_page;
            $order_by = $request->order_by;
            $order = $request->order;
//            $start_from = $request->start_from;
            $search = trim($request->search);

            $query = "col_id > 0";


            $search_fields = "("
                    . "col_id LIKE '%$search%'"
                    . "collection_id LIKE '%$search%'"
                    . " OR col_customer_id   LIKE '%$search%'"
                    . " OR col_name   LIKE '%$search%'"
                    . " OR col_phone   LIKE '%$search%'"
                    . " OR col_chit_scheme   LIKE '%$search%'"
                    . " OR col_chit_value  LIKE '%$search%'"
//                    . " OR col_chit_value  LIKE '%$search%'"
                    . " OR col_chit_installment  LIKE '%$search%'"
                    . " OR col_first_payment  LIKE '%$search%'"
                    . " OR col_payable_amount  LIKE '%$search%'"
                    . " OR col_new_payable_amount  LIKE '%$search%'"
                    . " OR col_outstanding  LIKE '%$search%'"
                     . " OR col_status  LIKE '%$search%'"
                    . " OR col_max_installment  LIKE '%$search%'"
                    . " OR col_chit_no  LIKE '%$search%'"
                    . " OR col_date  LIKE '%$search%'"
                    . " OR col_log LIKE '%$search%'"
                    . ")";

            if (!empty($request->search)) {
                $query = $query . " AND " . $search_fields;
            }
            $joins = array(
            );
            $ct = $this->App->getFromDb(array('from' => 'collections', 'fields' => "COUNT(col_id) as total", 'join_left' => $joins, 'where' => $query));
            $rdata = $this->App->getFromDb(array('from' => 'collections',
                'fields' => "*",
                'join_left' => $joins,
                'where' => $query,
                'orderkey' => $order_by,
                'order' => $order,
//                'num' => $num_per_page,
//                'startfrom' => $start_from
                    ));

            $obj->total = 0;
            if (sizeof($ct) > 0) {
                $obj->total = $ct[0]->total;
            }
            
            $chitdata = $this->App->getFromDb(array('from' => 'collections',
                'fields' => "*",
                'join_left' => $joins,
                'where' => " col_id IN (SELECT MAX(col_id) FROM collections GROUP BY col_chit_no)",
                'orderkey' => 'col_chit_no',
                'order' => 'asc',
//                'num' => $num_per_page,
//                'startfrom' => $start_from
                    ));

                    
//            $pg = $obj->total / $num_per_page;
//            $pgRound = round($pg);
//            if ($pg > $pgRound) {
//                $pgRound = $pgRound + 1;
//            }
//            $obj->pages = $pgRound;
            $obj->data = $rdata;
            $obj->chit_data = $chitdata;
            $obj->received = sizeof($rdata);
        }

        $this->output->set_output(json_encode($obj, JSON_PRETTY_PRINT));
    }
    public function add_edit_collections() {
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
            $col_id = trim($request->col_id);
            $collection_id = trim($request->collection_id);
             $col_customer_id = trim($request->col_customer_id);
            $col_name = trim($request->col_name);
             $col_phone = trim($request->col_phone);
            $col_chit_scheme = trim($request->col_chit_scheme);
            $col_chit_value = trim($request->col_chit_value);
            $col_chit_installment = trim($request->col_chit_installment);
             $col_chit_no=trim($request->col_chit_no);
            $col_max_installment=trim($request->col_max_installment);
          
            $col_first_payment = trim($request->col_first_payment);
             $col_outstanding = trim($request->col_outstanding);
             $col_status=trim($request->col_status);
           $col_new_payable_amount=trim($request->col_new_payable_amount);
             $col_payable_amount = trim($request->col_payable_amount);
            $col_date = trim($request->col_date);
            
            $col_log = $log;

            $payload = array(
                'col_customer_id' =>$col_customer_id,
                'collection_id' =>$collection_id,
                 'col_name' => $col_name,
                'col_phone' => $col_phone,
//                 'col_customer_id' => $col_customer_id,
                'col_chit_scheme' => $col_chit_scheme,
                'col_chit_value' => $col_chit_value,
                'col_chit_installment' => $col_chit_installment,
                 'col_chit_no' => $col_chit_no,
                 'col_max_installment' => $col_max_installment,
                'col_first_payment' => $col_first_payment,
                'col_payable_amount' => $col_payable_amount,
                'col_new_payable_amount'=>$col_new_payable_amount,
                 'col_outstanding' => $col_outstanding,
                'col_status'=>$col_status,
                'col_date' => $col_date,
                
                'col_log' => $col_log,
            );
            if ($col_id == -1) {
                $obj->status = $this->App->insertDbIfNotExists($payload, "collections", " ''");
                if ($obj->status == 'OK') {
                    $col_id = $this->db->insert_id();
                    $obj->message = "collections entry created successfully";
                } else {
                    //$obj->message = "Sorry could not proceed, " . $ac_no_of_members . " is already taken!";
                }
            } else {
                $obj->status = $this->App->updateDbIfNotExists(
                        array('from' => "collections", 'where' => "col_id = '$col_id'",
                            'data' => $payload), "col_customer_id = '' AND col_id != '$col_id'");
                if ($obj->status == 'OK') {
                    $obj->message = "collections entry updated";
                } else {
                    $obj->message = 'Sorry,Entered: ' . $col_customer_id . " is already existing in DB";
                }
            }
        }
        $this->output->set_output(json_encode($obj, JSON_PRETTY_PRINT));
    }
    public function get_all_quicksavepro_fiftythousand()
    {
        $obj = new stdClass();
        $obj->message = "";
        $obj->status = "OK";
//        $search = $this->input->post('term');
//        $query = "name LIKE '%$search%'";
        $data = $this->App->getFromDb(array(
            'from' => 'quicksavepro_fiftythousand',
//            'fields' => "name as text, id as id",
//            'where' => $query,
//            'orderkey' => 'name',
            'order' => 'ASC',
        ));
        $obj->data = $data;
        $this->output->set_output(json_encode($obj, JSON_PRETTY_PRINT));
    }
     public function get_all_valuesavepro_fivelakh()
    {
        $obj = new stdClass();
        $obj->message = "";
        $obj->status = "OK";
//        $search = $this->input->post('term');
//        $query = "name LIKE '%$search%'";
        $data = $this->App->getFromDb(array(
            'from' => 'valuesavepro_fivelakhs',
//            'fields' => "name as text, id as id",
//            'where' => $query,
//            'orderkey' => 'name',
            'order' => 'ASC',
        ));
        $obj->data = $data;
        $this->output->set_output(json_encode($obj, JSON_PRETTY_PRINT));
    }
    public function get_all_quicksavepro_fiftythousandjoin(){	
// $obj = new stdClass();
//        $obj->message = "";
//        $obj->status = "OK";
        
	$this->db->select('*');
	$this->db->from(['collections','quicksavepro_fiftythousand']); // this is first table name
//	$this->db->join('quicksavepro_fiftythousand', 'quicksavepro_fiftythousand.qft_id = collections.col_id','right outer');
//        $this->db->join('collections', 'collections.col_id = quicksavepro_fiftythousand.qft_id','right');// this is second table name with both table ids
//	$this->db->where('collections.col_chit_value=quicksavepro_fiftythousand.qft_chit_value');
        $query = $this->db->get();
//	return $query->result();
         $response = array(
            'status' => 'success',
            'join' => $query->result(),
        );
  $this->output
                ->set_status_header(200)
                ->set_content_type('application/json')
                ->set_output(json_encode($response));

	}

}