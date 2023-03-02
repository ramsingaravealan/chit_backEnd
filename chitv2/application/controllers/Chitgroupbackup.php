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
        
//        $query="SELECT chit_scheme.cs_chit_scheme, chit_group.* FROM chit_scheme LEFT JOIN chit_group ON chit_scheme.cs_id = chit_group.cg_chit_scheme_id";
      $this->db->select('*');
	$this->db->from(['chit_group','chit_scheme']);
        $joins = array("chit_scheme", "chit_scheme.cs_id = chit_group.cg_chit_scheme_id", "left");
        $this->db->where('chit_scheme.cs_id=chit_group.cg_chit_scheme_id');
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
//                    . " OR cg_max_installment_1  LIKE '%$search%'"
//                    . " OR cg_max_installment_2  LIKE '%$search%'"
//                    . " OR cg_max_installment_3  LIKE '%$search%'"
//                    . " OR cg_max_installment_4  LIKE '%$search%'"
//                    . " OR cg_max_installment_5  LIKE '%$search%'"
//                    . " OR cg_max_installment_6  LIKE '%$search%'"
//                    . " OR cg_max_installment_7  LIKE '%$search%'"
//                    . " OR cg_max_installment_8  LIKE '%$search%'"
//                    . " OR cg_max_installment_9  LIKE '%$search%'"
//                    . " OR cg_max_installment_10  LIKE '%$search%'"
//                    . " OR cg_max_installment_11  LIKE '%$search%'"
//                    . " OR cg_max_installment_12  LIKE '%$search%'"
//                    . " OR cg_max_installment_13  LIKE '%$search%'"
//                    . " OR cg_max_installment_14  LIKE '%$search%'"
//                    . " OR cg_max_installment_15  LIKE '%$search%'"
//                    . " OR cg_max_installment_16  LIKE '%$search%'"
//                    . " OR cg_max_installment_17  LIKE '%$search%'"
//                    . " OR cg_max_installment_18  LIKE '%$search%'"
//                    . " OR cg_max_installment_19  LIKE '%$search%'"
//                    . " OR cg_max_installment_20 LIKE '%$search%'"
//                    . " OR cg_max_installment_21  LIKE '%$search%'"
//                     . " OR cg_max_installment_22  LIKE '%$search%'"
//                    . " OR cg_max_installment_23  LIKE '%$search%'"
//                    . " OR cg_max_installment_24  LIKE '%$search%'"
//                    . " OR cg_max_installment_25  LIKE '%$search%'"
//                    . " OR cg_max_installment_26  LIKE '%$search%'"
//                    . " OR cg_max_installment_27  LIKE '%$search%'"
//                    . " OR cg_max_installment_28  LIKE '%$search%'"
//                    . " OR cg_max_installment_29  LIKE '%$search%'"
//                    . " OR cg_max_installment_30  LIKE '%$search%'"
//                    . " OR cg_max_installment_31  LIKE '%$search%'"
//                    . " OR cg_max_installment_32  LIKE '%$search%'"
//                    . " OR cg_max_installment_33  LIKE '%$search%'"
//                    . " OR cg_max_installment_34  LIKE '%$search%'"
//                    . " OR cg_max_installment_35  LIKE '%$search%'"
//                    . " OR cg_max_installment_36  LIKE '%$search%'"
//                    . " OR cg_max_installment_37  LIKE '%$search%'"
//                    . " OR cg_max_installment_38  LIKE '%$search%'"
//                    . " OR cg_max_installment_39  LIKE '%$search%'"
//                    . " OR cg_max_installment_40  LIKE '%$search%'"
//                    . " OR cg_max_installment_41  LIKE '%$search%'"
//                    . " OR cg_max_installment_42  LIKE '%$search%'"
//                    . " OR cg_max_installment_43  LIKE '%$search%'"
//                    . " OR cg_max_installment_44  LIKE '%$search%'"
//                    . " OR cg_max_installment_45  LIKE '%$search%'"
//                    . " OR cg_max_installment_46  LIKE '%$search%'"
//                    . " OR cg_max_installment_47  LIKE '%$search%'"
//                    . " OR cg_max_installment_48  LIKE '%$search%'"
//                    . " OR cg_max_installment_49  LIKE '%$search%'"
//                    . " OR cg_max_installment_50  LIKE '%$search%'"
//                    
//                    . " OR cg_chit_no_1  LIKE '%$search%'"
//                     . " OR cg_chit_no_2  LIKE '%$search%'"
//                     . " OR cg_chit_no_3  LIKE '%$search%'"
//                     . " OR cg_chit_no_4  LIKE '%$search%'"
//                     . " OR cg_chit_no_5  LIKE '%$search%'"
//                     . " OR cg_chit_no_6  LIKE '%$search%'"
//                     . " OR cg_chit_no_7  LIKE '%$search%'"
//                     . " OR cg_chit_no_8  LIKE '%$search%'"
//                     . " OR cg_chit_no_9  LIKE '%$search%'"
//                     . " OR cg_chit_no_10  LIKE '%$search%'"
//                     . " OR cg_chit_no_11  LIKE '%$search%'"
//                     . " OR cg_chit_no_12  LIKE '%$search%'"
//                     . " OR cg_chit_no_13  LIKE '%$search%'"
//                     . " OR cg_chit_no_14  LIKE '%$search%'"
//                     . " OR cg_chit_no_15  LIKE '%$search%'"
//                     . " OR cg_chit_no_16  LIKE '%$search%'"
//                     . " OR cg_chit_no_17  LIKE '%$search%'"
//                     . " OR cg_chit_no_18  LIKE '%$search%'"
//                     . " OR cg_chit_no_19  LIKE '%$search%'"
//                     . " OR cg_chit_no_20  LIKE '%$search%'"
//                     . " OR cg_chit_no_21  LIKE '%$search%'"
//                    . " OR cg_chit_no_22  LIKE '%$search%'"
//                    . " OR cg_chit_no_23  LIKE '%$search%'"
//                    . " OR cg_chit_no_24  LIKE '%$search%'"
//                    . " OR cg_chit_no_25  LIKE '%$search%'"
//                    . " OR cg_chit_no_26  LIKE '%$search%'"
//                    . " OR cg_chit_no_27  LIKE '%$search%'"
//                    . " OR cg_chit_no_28  LIKE '%$search%'"
//                    . " OR cg_chit_no_29  LIKE '%$search%'"
//                    . " OR cg_chit_no_30  LIKE '%$search%'"
//                    . " OR cg_chit_no_31  LIKE '%$search%'"
//                    . " OR cg_chit_no_32  LIKE '%$search%'"
//                    . " OR cg_chit_no_33  LIKE '%$search%'"
//                    . " OR cg_chit_no_34  LIKE '%$search%'"
//                    . " OR cg_chit_no_35  LIKE '%$search%'"
//                    . " OR cg_chit_no_36  LIKE '%$search%'"
//                    . " OR cg_chit_no_37  LIKE '%$search%'"
//                    . " OR cg_chit_no_38  LIKE '%$search%'"
//                    . " OR cg_chit_no_39  LIKE '%$search%'"
//                    . " OR cg_chit_no_40  LIKE '%$search%'"
//                    . " OR cg_chit_no_41  LIKE '%$search%'"
//                    . " OR cg_chit_no_42  LIKE '%$search%'"
//                    . " OR cg_chit_no_43  LIKE '%$search%'"
//                    . " OR cg_chit_no_44  LIKE '%$search%'"
//                    . " OR cg_chit_no_45  LIKE '%$search%'"
//                    . " OR cg_chit_no_46  LIKE '%$search%'"
//                    . " OR cg_chit_no_47  LIKE '%$search%'"
//                    . " OR cg_chit_no_48  LIKE '%$search%'"
//                    . " OR cg_chit_no_49  LIKE '%$search%'"
//                    . " OR cg_chit_no_50  LIKE '%$search%'"
                    
                    . " OR cg_created_at LIKE '%$search%'"
                    . " OR cg_updated_at LIKE '%$search%'"
                    . ")";

            if (!empty($request->search)) {
                $query = $query . " AND " . $search_fields;
            }
            $joins = array("chit_scheme", "chit_scheme.cs_id = chit_group.cg_chit_scheme_id", "left");
            $joins = array(
               
               
            );
             $ct = $this->App->getFromDb(array('from' => 'chit_group', 'fields' =>  "COUNT(cg_id) as total" , 'join_left' => $joins, 'where' =>"chit_scheme.cs_id=chit_group.cg_chit_scheme_id", $query));
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
//            $cg_max_installment_1=trim($request->cg_max_installment_1);
//            $cg_max_installment_2=trim($request->cg_max_installment_2);
//            $cg_max_installment_3=trim($request->cg_max_installment_3);
//            $cg_max_installment_4=trim($request->cg_max_installment_4);
//            $cg_max_installment_5=trim($request->cg_max_installment_5);
//            $cg_max_installment_6=trim($request->cg_max_installment_6);
//            $cg_max_installment_7=trim($request->cg_max_installment_7);
//            $cg_max_installment_8=trim($request->cg_max_installment_8);
//            $cg_max_installment_9=trim($request->cg_max_installment_9);
//            $cg_max_installment_10=trim($request->cg_max_installment_10);
//            $cg_max_installment_11=trim($request->cg_max_installment_11);
//            $cg_max_installment_12=trim($request->cg_max_installment_12);
//            $cg_max_installment_13=trim($request->cg_max_installment_13);
//            $cg_max_installment_14=trim($request->cg_max_installment_14);
//            $cg_max_installment_15=trim($request->cg_max_installment_15);
//            $cg_max_installment_16=trim($request->cg_max_installment_16);
//            $cg_max_installment_17=trim($request->cg_max_installment_17);
//            $cg_max_installment_18=trim($request->cg_max_installment_18);
//            $cg_max_installment_19=trim($request->cg_max_installment_19);
//            $cg_max_installment_20=trim($request->cg_max_installment_20);
//            $cg_max_installment_21=trim($request->cg_max_installment_21);
//            $cg_max_installment_22=trim($request->cg_max_installment_22);
//            $cg_max_installment_23=trim($request->cg_max_installment_23);
//            $cg_max_installment_24=trim($request->cg_max_installment_24);
//            $cg_max_installment_25=trim($request->cg_max_installment_25);
//            $cg_max_installment_26=trim($request->cg_max_installment_26);
//            $cg_max_installment_27=trim($request->cg_max_installment_27);
//            $cg_max_installment_28=trim($request->cg_max_installment_28);
//            $cg_max_installment_29=trim($request->cg_max_installment_29);
//            $cg_max_installment_30=trim($request->cg_max_installment_30);
//            $cg_max_installment_31=trim($request->cg_max_installment_31);
//            $cg_max_installment_32=trim($request->cg_max_installment_32);
//            $cg_max_installment_33=trim($request->cg_max_installment_33);
//            $cg_max_installment_34=trim($request->cg_max_installment_34);
//            $cg_max_installment_35=trim($request->cg_max_installment_35);
//            $cg_max_installment_36=trim($request->cg_max_installment_36);
//            $cg_max_installment_37=trim($request->cg_max_installment_37);
//            $cg_max_installment_38=trim($request->cg_max_installment_38);
//            $cg_max_installment_39=trim($request->cg_max_installment_39);
//            $cg_max_installment_40=trim($request->cg_max_installment_40);
//            $cg_max_installment_41=trim($request->cg_max_installment_41);
//            $cg_max_installment_42=trim($request->cg_max_installment_42);
//            $cg_max_installment_43=trim($request->cg_max_installment_43);
//            $cg_max_installment_44=trim($request->cg_max_installment_44);
//            $cg_max_installment_45=trim($request->cg_max_installment_45);
//            $cg_max_installment_46=trim($request->cg_max_installment_46);
//            $cg_max_installment_47=trim($request->cg_max_installment_47);
//            $cg_max_installment_48=trim($request->cg_max_installment_48);
//            $cg_max_installment_49=trim($request->cg_max_installment_49);
//            $cg_max_installment_50=trim($request->cg_max_installment_50);
//            
//            
//            
//             $cg_chit_no_1=trim($request->cg_chit_no_1);
//              $cg_chit_no_2=trim($request->cg_chit_no_2);
//               $cg_chit_no_3=trim($request->cg_chit_no_3);
//                $cg_chit_no_4=trim($request->cg_chit_no_4);
//                 $cg_chit_no_5=trim($request->cg_chit_no_5);
//                  $cg_chit_no_6=trim($request->cg_chit_no_6);
//                   $cg_chit_no_7=trim($request->cg_chit_no_7);
//                    $cg_chit_no_8=trim($request->cg_chit_no_8);
//                     $cg_chit_no_9=trim($request->cg_chit_no_9);
//                      $cg_chit_no_10=trim($request->cg_chit_no_10);
//                       $cg_chit_no_11=trim($request->cg_chit_no_11);
//                        $cg_chit_no_12=trim($request->cg_chit_no_12);
//                         $cg_chit_no_13=trim($request->cg_chit_no_13);
//                         $cg_chit_no_14=trim($request->cg_chit_no_14);
//                         $cg_chit_no_15=trim($request->cg_chit_no_15);
//                         $cg_chit_no_16=trim($request->cg_chit_no_16);
//                         $cg_chit_no_17=trim($request->cg_chit_no_17);
//                         $cg_chit_no_18=trim($request->cg_chit_no_18);
//                         $cg_chit_no_19=trim($request->cg_chit_no_19);
//                         $cg_chit_no_20=trim($request->cg_chit_no_20);
//                         $cg_chit_no_21=trim($request->cg_chit_no_21);
//                         $cg_chit_no_22=trim($request->cg_chit_no_22);
//                         $cg_chit_no_23=trim($request->cg_chit_no_23);
//                         $cg_chit_no_24=trim($request->cg_chit_no_24);
//                         $cg_chit_no_25=trim($request->cg_chit_no_25);
//                         $cg_chit_no_26=trim($request->cg_chit_no_26);
//                         $cg_chit_no_27=trim($request->cg_chit_no_27);
//                         $cg_chit_no_28=trim($request->cg_chit_no_28);
//                         $cg_chit_no_29=trim($request->cg_chit_no_29);
//                         $cg_chit_no_30=trim($request->cg_chit_no_30);
//                         $cg_chit_no_31=trim($request->cg_chit_no_31);
//                         $cg_chit_no_32=trim($request->cg_chit_no_32);
//                         $cg_chit_no_33=trim($request->cg_chit_no_33);
//                         $cg_chit_no_34=trim($request->cg_chit_no_34);
//                         $cg_chit_no_35=trim($request->cg_chit_no_35);
//                         $cg_chit_no_36=trim($request->cg_chit_no_36);
//                         $cg_chit_no_37=trim($request->cg_chit_no_37);
//                         $cg_chit_no_38=trim($request->cg_chit_no_38);
//                         $cg_chit_no_39=trim($request->cg_chit_no_39);
//                         $cg_chit_no_40=trim($request->cg_chit_no_40);
//                         $cg_chit_no_41=trim($request->cg_chit_no_41);
//                         $cg_chit_no_42=trim($request->cg_chit_no_42);
//                         $cg_chit_no_43=trim($request->cg_chit_no_43);
//                         $cg_chit_no_44=trim($request->cg_chit_no_44);
//                         $cg_chit_no_45=trim($request->cg_chit_no_45);
//                         $cg_chit_no_46=trim($request->cg_chit_no_46);
//                         $cg_chit_no_47=trim($request->cg_chit_no_47);
//                         $cg_chit_no_48=trim($request->cg_chit_no_48);
//                         $cg_chit_no_49=trim($request->cg_chit_no_49);
//                         $cg_chit_no_50=trim($request->cg_chit_no_50);
//            $cg_log = $log;
//$cg_created_at=$cg_created_at;
//$cg_updated_at=$cg_updated_at;
            $payload = array(
                 'cg_group_name' => $cg_group_name,
                'cg_chit_scheme_id' => $cg_chit_scheme_id,
                'cg_chit_value_id' => $cg_chit_value_id,
//                'cg_chit_month' => $cg_chit_month,
                'cg_chit_members' => $cg_chit_members,
               
//                'cg_max_installment_1' => $cg_max_installment_1,
//                'cg_max_installment_2' => $cg_max_installment_2,
//                'cg_max_installment_3' => $cg_max_installment_3,
//                'cg_max_installment_4' => $cg_max_installment_4,
//                'cg_max_installment_5' => $cg_max_installment_5,
//                'cg_max_installment_6' => $cg_max_installment_6,
//                'cg_max_installment_7' => $cg_max_installment_7,
//                'cg_max_installment_8' => $cg_max_installment_8,
//                'cg_max_installment_9' => $cg_max_installment_9,
//                'cg_max_installment_10' => $cg_max_installment_10,
//                'cg_max_installment_11' => $cg_max_installment_11,
//                'cg_max_installment_12' => $cg_max_installment_12,
//                'cg_max_installment_13' => $cg_max_installment_13,
//                'cg_max_installment_14' => $cg_max_installment_14,
//                'cg_max_installment_15' => $cg_max_installment_15,
//                'cg_max_installment_16' => $cg_max_installment_16,
//                'cg_max_installment_17' => $cg_max_installment_17,
//                'cg_max_installment_18' => $cg_max_installment_18,
//                'cg_max_installment_19' => $cg_max_installment_19,
//                'cg_max_installment_20' => $cg_max_installment_20,
//                'cg_max_installment_21' => $cg_max_installment_21,
//                'cg_max_installment_22' => $cg_max_installment_22,
//                'cg_max_installment_23' => $cg_max_installment_23,
//                'cg_max_installment_24' => $cg_max_installment_24,
//                'cg_max_installment_25' => $cg_max_installment_25,
//                'cg_max_installment_26' => $cg_max_installment_26,
//                'cg_max_installment_27' => $cg_max_installment_27,
//                'cg_max_installment_28' => $cg_max_installment_28,
//                'cg_max_installment_29' => $cg_max_installment_29,
//                'cg_max_installment_30' => $cg_max_installment_30,
//                'cg_max_installment_31' => $cg_max_installment_31,
//                'cg_max_installment_32' => $cg_max_installment_32,
//                'cg_max_installment_33' => $cg_max_installment_33,
//                'cg_max_installment_34' => $cg_max_installment_34,
//                'cg_max_installment_35' => $cg_max_installment_35,
//                'cg_max_installment_36' => $cg_max_installment_36,
//                'cg_max_installment_37' => $cg_max_installment_37,
//                'cg_max_installment_38' => $cg_max_installment_38,
//                'cg_max_installment_39' => $cg_max_installment_39,
//                'cg_max_installment_40' => $cg_max_installment_40,
//                'cg_max_installment_41' => $cg_max_installment_41,
//                'cg_max_installment_42' => $cg_max_installment_42,
//                'cg_max_installment_43' => $cg_max_installment_43,
//                'cg_max_installment_44' => $cg_max_installment_44,
//                'cg_max_installment_45' => $cg_max_installment_45,
//                'cg_max_installment_46' => $cg_max_installment_46,
//                'cg_max_installment_47' => $cg_max_installment_47,
//                'cg_max_installment_48' => $cg_max_installment_48,
//                'cg_max_installment_49' => $cg_max_installment_49,
//                'cg_max_installment_50' => $cg_max_installment_50,
//                'cg_chit_no_1' => $cg_chit_no_1,
//                'cg_chit_no_2' => $cg_chit_no_2,
//                'cg_chit_no_3' => $cg_chit_no_3,
//                'cg_chit_no_4' => $cg_chit_no_4,
//                'cg_chit_no_5' => $cg_chit_no_5,
//                'cg_chit_no_6' => $cg_chit_no_6,
//                'cg_chit_no_7' => $cg_chit_no_7,
//                'cg_chit_no_8' => $cg_chit_no_8,
//                'cg_chit_no_9' => $cg_chit_no_9,
//                'cg_chit_no_10' => $cg_chit_no_10,
//                'cg_chit_no_11' => $cg_chit_no_11,
//                'cg_chit_no_12' => $cg_chit_no_12,
//                'cg_chit_no_13' => $cg_chit_no_13,
//                'cg_chit_no_14' => $cg_chit_no_14,
//                'cg_chit_no_15' => $cg_chit_no_15,
//                'cg_chit_no_16' => $cg_chit_no_16,
//                'cg_chit_no_17' => $cg_chit_no_17,
//                'cg_chit_no_18' => $cg_chit_no_18,
//                'cg_chit_no_19' => $cg_chit_no_19,
//                 'cg_chit_no_20' => $cg_chit_no_20,
//                 'cg_chit_no_21' => $cg_chit_no_21,
//                'cg_chit_no_22' => $cg_chit_no_22,
//                'cg_chit_no_23' => $cg_chit_no_23,
//                'cg_chit_no_24' => $cg_chit_no_24,
//                'cg_chit_no_25' => $cg_chit_no_25,
//                'cg_chit_no_26' => $cg_chit_no_26,
//                'cg_chit_no_27' => $cg_chit_no_27,
//                'cg_chit_no_28' => $cg_chit_no_28,
//                'cg_chit_no_29' => $cg_chit_no_29,
//                'cg_chit_no_30' => $cg_chit_no_30,
//                'cg_chit_no_31' => $cg_chit_no_31,
//                'cg_chit_no_32' => $cg_chit_no_32,
//                'cg_chit_no_33' => $cg_chit_no_33,
//                'cg_chit_no_34' => $cg_chit_no_34,
//                'cg_chit_no_35' => $cg_chit_no_35,
//                'cg_chit_no_36' => $cg_chit_no_36,
//                'cg_chit_no_37' => $cg_chit_no_37,
//                'cg_chit_no_38' => $cg_chit_no_38,
//                'cg_chit_no_39' => $cg_chit_no_39,
//                'cg_chit_no_40' => $cg_chit_no_40,
//                'cg_chit_no_41' => $cg_chit_no_41,
//                'cg_chit_no_42' => $cg_chit_no_42,
//                'cg_chit_no_43' => $cg_chit_no_43,
//                'cg_chit_no_44' => $cg_chit_no_44,
//                'cg_chit_no_45' => $cg_chit_no_45,
//                'cg_chit_no_46' => $cg_chit_no_46,
//                'cg_chit_no_47' => $cg_chit_no_47,
//                'cg_chit_no_48' => $cg_chit_no_48,
//                'cg_chit_no_49' => $cg_chit_no_49,
//                'cg_chit_no_50' => $cg_chit_no_50,
                
//                'cg_log' => $cg_log,
//               'cg_created_at' =>$cg_created_at,
               // 'cg_updated_at'=>$cg_updated_at
            );
//            if ($cg_id == -1) {
//                $obj->status = $this->App->insertDbIfNotExists($payload, "chit_group");
//                if ($obj->status == 'OK') {
//                    $nc_id = $this->db->insert_id();
//                    $obj->message = "Chitscheme entry created successfully";
//                } else {
//                    $obj->message = "Sorry could not proceed,  is already taken!";
//                }
//            } else {
//                $obj->status = $this->App->updateDbIfNotExists(
//                        array('from' => "chit_group", 'where' => "cg_id = '$cg_id'",
//                            'data' => $payload));
//                if ($obj->status == 'OK') {
//                    $obj->message = "Chitscheme entry updated";
//                } else {
//                    $obj->message = "Sorry,Entered  is already existing in DB";
//                }
//            }
//            if ($cg_id == -1) {
//                $obj->status = $this->App->insertDbIfNotExists($payload, "chit_group", "  ''");
//                if ($obj->status == 'OK') {
//                    $cg_id = $this->db->insert_id();
//                    $obj->message = "chit_group entry created successfully";
//                } else {
////                    $obj->message = "Sorry could not proceed, " . $cs_chit_scheme . " is already taken!";
//                }
//            } 
//            else {
//                $obj->status = $this->App->updateDbIfNotExists(
//                        array('from' => "chit_group", 'where' => "cg_id = '$cg_id'",
//                            'data' => $payload), "cg_group_name = '$cg_group_name' AND cg_id != '$cg_id'");
//                if ($obj->status == 'OK') {
//                    $obj->message = "chitvalue entry updated";
//                } else {
//                    $obj->message = 'Sorry,Entered: ' . $cg_group_name . " is already existing in DB";
//                }
//            }
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
    
//    public function get_all_chitscheme() {
//        $obj = new stdClass();
//        $obj->message = "";
//        $obj->status = "OK";
//        $search = $this->input->post('term');
//        $query = "cs_chit_scheme LIKE '%$search%'";
//        $data = $this->App->getFromDb(array(
//            'from' => 'chit_scheme',
//            'fields' => "cs_chit_scheme  as text, cs_chit_scheme as id",
//            'where' => $query,
//            'orderkey' => 'cs_chit_scheme',
//            'order' => 'ASC',
//        ));
//        $obj->data = $data;
//        $this->output->set_output(json_encode($obj, JSON_PRETTY_PRINT));
//    }
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
//    public function get_selected_venue_rooms() {
//        $this->load->helper('string');
//        $obj = new stdClass();
//        $obj->status = "FAILED";
//        $obj->message = "";
//        $postdata = file_get_contents("php://input");
//        $request = json_decode($postdata);
//
//        $obj->token_status = $this->decodedToken->status;
//        if ($request && $this->decodedToken->status == 'OK') {
//            $obj->status = "OK";
//            $check_id = trim($request->id);
//            $query = "vr_id = '$check_id'";
//            $obj->data = $this->App->getFromDb(array('from' => 'venue_rooms',
//                'fields' => "vr_room_name as text, vr_id as id",
//                'where' => $query,
//                'orderkey' => "vr_room_name",
//                'order' => 'ASC',
//            ));
//        }
//        $this->output->set_output(json_encode($obj, JSON_PRETTY_PRINT));
//    }

     
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
