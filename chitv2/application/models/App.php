<?php

// Created by Dev
class App extends CI_Model {

    public function updateDb($projections) {
        if ($projections != null) {
            $this->db->where($projections["where"]);
            $v = $this->db->update($projections["from"], $projections["data"]);
            return $v;
        }

        return -1;
    }

    public function deleteDb($projections) {
        if ($projections != null) {
            $this->db->where($projections["where"]);
            $this->db->delete($projections["from"]);
        }
    }

    public function updateDbIfNotExists($projections, $whereFlag) {
        if ($projections != null) {

            $existing = $this->getFromDb(array('from' => $projections["from"], 'where' => $whereFlag));
            if (count($existing) == 0) {
                $this->db->where($projections["where"]);
                $this->db->update($projections["from"], $projections["data"]);
                return "OK";
            }
        }

        return "FAILED";
    }

    public function insertDb($data, $tbl) {

        $this->db->insert($tbl, $data);
        return $this->db->insert_id();
    }
    
    public function insertForce($data, $tbl, $whereFlag) {
       
        $this->db->where($whereFlag);
        $this->db->delete($tbl);
        $this->db->insert($tbl, $data);
        return "OK";
        
    }
    
    public function insertOrUpdate($data, $tbl, $whereFlag) {
        $existing = $this->getFromDb(array('from' => $tbl, 'where' => $whereFlag));
        if (count($existing) == 0) {
            $this->db->insert($tbl, $data);
            return "OK";
        }else{
            $this->db->where($whereFlag);
            $this->db->update($tbl, $data);
        }
        return "FAILED";
    }

    public function insertDbIfNotExists($data, $tbl, $whereFlag) {
        $existing = $this->getFromDb(array('from' => $tbl, 'where' => $whereFlag));
        if (count($existing) == 0) {
            $this->db->insert($tbl, $data);
            return "OK";
        }
        return "FAILED";
    }

    public function getFromDb($projections) {

        if ($projections != null) {
            if (isset($projections["fields"])) {
                $this->db->select($projections["fields"]);
            } else {
                $this->db->select('*');
            }
            $this->db->from($projections["from"]);
            if (isset($projections["where"])) {
                $this->db->where($projections["where"]);
            }

            if (isset($projections["orderkey"]) && isset($projections["order"])) {
                $this->db->order_by($projections["orderkey"], $projections["order"]);
            }

            if (isset($projections["group_by"])) {
                $this->db->group_by($projections["group_by"]);
            }
            if (isset($projections["having"])) {
                $this->db->having($projections["having"]);
            }
            
            if (isset($projections["join_left"])) {
                foreach ($projections["join_left"] as $joins) {
                     $this->db->join($joins["table"], $joins["condition"], 'left');
                }
                
               // $this->db->join('user_email ue', 'ue.user_id = e.id', 'left');
            }

            if (isset($projections["num"]) && isset($projections["startfrom"])) {
                $this->db->limit($projections["num"], $projections["startfrom"]); // 5 records starting from 1st record
            }
            $query = $this->db->get();

            return $query->result();
        }
    }

}

