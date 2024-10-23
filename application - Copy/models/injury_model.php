<?php
class Injury_model extends CI_Model {

    function lists(){
        $department_id=$this->session->userdata('department_id');
        $result=$this->db->query("SELECT a.*
            FROM injury_table a 
            WHERE 1
            ORDER BY a.injury_id")->result();
        return $result;
    }

    
    function get_info($injury_id){
        $result=$this->db->query("SELECT * FROM injury_table 
            WHERE injury_id=$injury_id")->row();
        return $result;
    }
    function save($injury_id=FALSE){
        $data=array();
        $data['injury_name']=$this->input->post('injury_name');
        if($injury_id==FALSE){
        $query=$this->db->insert('injury_table',$data);
        }else{
          $this->db->WHERE('injury_id',$injury_id);
          $query=$this->db->update('injury_table',$data);
        }
       return $query;
     
    }
    function delete($injury_id) {
        $this->db->WHERE('injury_id',$injury_id);
        $query=$this->db->delete('injury_table');
        return $query;
  }

  
}
