<?php
class Company_model extends CI_Model {
    function lists(){
        $result=$this->db->query("SELECT m.*
            FROM courier_name_info m
            WHERE 1
            ORDER BY m.courier_name_id")->result();
        return $result;
    }
    
    function get_info($courier_name_id){
        $result=$this->db->query("SELECT * FROM courier_name_info 
            WHERE courier_name_id=$courier_name_id")->row();
        return $result;
    }
    function save($courier_name_id=FALSE){
        $data=array();
        $data['courier_company']=$this->input->post('courier_company');
        $data['courier_address']=$this->input->post('courier_address');
        if($courier_name_id==FALSE){
        $query=$this->db->insert('courier_name_info',$data);
        }else{
          $this->db->WHERE('courier_name_id',$courier_name_id);
          $query=$this->db->update('courier_name_info',$data);
        }
       return $query;
     
    }
    function delete($courier_name_id) {
        $this->db->WHERE('courier_name_id',$courier_name_id);
        $query=$this->db->delete('courier_name_info');
        return $query;
  }

  
}
