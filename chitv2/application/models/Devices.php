<?php

// Created by Dev
class Devices extends CI_Model {
    
    function __construct(){
            parent::__construct();
            //load our second db and put in $db2
            $this->db2 = $this->load->database('devices', TRUE);
        }

    public function updateDb($projections) {
        if ($projections != null) {
            $this->db2->where($projections["where"]);
            $v = $this->db2->update($projections["from"], $projections["data"]);
            return $v;
        }
        return -1;
    }

    public function deleteDb($projections) {
        if ($projections != null) {
            $this->db2->where($projections["where"]);
            $this->db2->delete($projections["from"]);
        }
    }

    public function updateDbIfNotExists($projections, $whereFlag) {
        if ($projections != null) {

            $existing = $this->getFromDb(array('from' => $projections["from"], 'where' => $whereFlag));
            if (count($existing) == 0) {
                $this->db2->where($projections["where"]);
                $this->db2->update($projections["from"], $projections["data"]);
                return "OK";
            }
        }

        return "FAILED";
    }

    public function insertDb($data, $tbl) {

        $this->db2->insert($tbl, $data);
        return $this->db2->insert_id();
    }
    
    public function insertForce($data, $tbl, $whereFlag) {
       
        $this->db2->where($whereFlag);
        $this->db2->delete($tbl);
        $this->db2->insert($tbl, $data);
        return "OK";
        
    }
    
    public function insertOrUpdate($data, $tbl, $whereFlag) {
        $existing = $this->getFromDb(array('from' => $tbl, 'where' => $whereFlag));
        if (count($existing) == 0) {
            $this->db2->insert($tbl, $data);
            return "OK";
        }else{
            $this->db2->where($whereFlag);
            $this->db2->update($tbl, $data);
        }
        return "FAILED";
    }

    public function insertDbIfNotExists($data, $tbl, $whereFlag) {
        $existing = $this->getFromDb(array('from' => $tbl, 'where' => $whereFlag));
        if (count($existing) == 0) {
            $this->db2->insert($tbl, $data);
            return "OK";
        }
        return "FAILED";
    }

    public function getFromDb($projections) {

        if ($projections != null) {
            if (isset($projections["fields"])) {
                $this->db2->select($projections["fields"]);
            } else {
                $this->db2->select('*');
            }
            $this->db2->from($projections["from"]);
            if (isset($projections["where"])) {
                $this->db2->where($projections["where"]);
            }

            if (isset($projections["orderkey"]) && isset($projections["order"])) {
                $this->db2->order_by($projections["orderkey"], $projections["order"]);
            }

            if (isset($projections["group_by"])) {
                $this->db2->group_by($projections["group_by"]);
            }
            if (isset($projections["having"])) {
                $this->db2->having($projections["having"]);
            }
            
            if (isset($projections["join_left"])) {
                foreach ($projections["join_left"] as $joins) {
                     $this->db2->join($joins["table"], $joins["condition"], 'left');
                }
                
               // $this->db2->join('user_email ue', 'ue.user_id = e.id', 'left');
            }

            if (isset($projections["num"]) && isset($projections["startfrom"])) {
                $this->db2->limit($projections["num"], $projections["startfrom"]); // 5 records starting from 1st record
            }
            $query = $this->db2->get();

            return $query->result();
        }
    }

}

