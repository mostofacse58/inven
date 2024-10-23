<?php
class Chargeback_model extends CI_Model {
    function lists(){
        $result=$this->db->query("SELECT m.*
            FROM chargeback_info m
            WHERE 1
            ORDER BY m.chargeback_id")->result();
        return $result;
    }
    
    function get_info($chargeback_id){
        $result=$this->db->query("SELECT * FROM chargeback_info 
            WHERE chargeback_id=$chargeback_id")->row();
        return $result;
    }
    function save($chargeback_id=FALSE){
        $data=array();
        $data['chargeback_name']=$this->input->post('chargeback_name');
        $data['description']=$this->input->post('description');
        if($chargeback_id==FALSE){
        $query=$this->db->insert('chargeback_info',$data);
        }else{
          $this->db->WHERE('chargeback_id',$chargeback_id);
          $query=$this->db->update('chargeback_info',$data);
        }
       return $query;
     
    }
    function delete($chargeback_id) {
        $this->db->WHERE('chargeback_id',$chargeback_id);
        $query=$this->db->delete('chargeback_info');
        return $query;
  }

  
}
