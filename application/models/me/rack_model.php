<?php
class Rack_model extends CI_Model {

    function lists(){
        $department_id=$this->session->userdata('department_id');
        $result=$this->db->query("SELECT a.*
            FROM rack_info a WHERE a.department_id=$department_id
            ORDER BY a.rack_id ")->result();
        return $result;
    }

    
    function get_info($rack_id){
        $result=$this->db->query("SELECT * FROM rack_info 
            WHERE rack_id=$rack_id")->row();
        return $result;
    }
    function save($rack_id=FALSE){
        $data=array();
        $data['rack_name']=$this->input->post('rack_name');
        $data['department_id']=$this->session->userdata('department_id');
        if($rack_id==FALSE){
        $query=$this->db->insert('rack_info',$data);
        }else{
          $this->db->WHERE('rack_id',$rack_id);
          $query=$this->db->update('rack_info',$data);
        }
       return $query;
     
    }
    function delete($rack_id) {
        $this->db->WHERE('rack_id',$rack_id);
        $query=$this->db->delete('rack_info');
        return $query;
  }

  
}
