<?php
class Location_model extends CI_Model {

    function lists(){
        $department_id=$this->session->userdata('department_id');
        $result=$this->db->query("SELECT a.*
            FROM location_info a 
            WHERE 1
            ORDER BY a.location_id")->result();
        return $result;
    }

    
    function get_info($location_id){
        $result=$this->db->query("SELECT * FROM location_info 
            WHERE location_id=$location_id")->row();
        return $result;
    }
    function save($location_id=FALSE){
        $data=array();
        $data['location_name']=strtoupper($this->input->post('location_name'));
        $data['mlocation_id']=$this->input->post('mlocation_id');
        $data['department_id']=$this->session->userdata('department_id');
        if($location_id==FALSE){
        $query=$this->db->insert('location_info',$data);
        }else{
          $this->db->WHERE('location_id',$location_id);
          $query=$this->db->update('location_info',$data);
        }
       return $query;
     
    }
    function delete($location_id) {
        $this->db->WHERE('location_id',$location_id);
        $query=$this->db->delete('location_info');
        return $query;
  }

  
}
