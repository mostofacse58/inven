<?php
class Idcard_model extends CI_Model {

    function prints(){
        $result=$this->db->query("SELECT a.*
            FROM employee_idcard_info a 
            WHERE 1
            ORDER BY a.employee_id ASC LIMIT 0,1")->result();
        return $result;
    }

    
    function get_info($employee_id){
        $result=$this->db->query("SELECT * FROM employee_idcard_info 
            WHERE employee_id=$employee_id")->row();
        return $result;
    }
    

  
}
