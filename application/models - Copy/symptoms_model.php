<?php
class Symptoms_model extends CI_Model {

    function lists(){
        $department_id=$this->session->userdata('department_id');
        $result=$this->db->query("SELECT a.*
            FROM symptoms_info a 
            WHERE department_id=$department_id
            ORDER BY a.symptoms_id")->result();
        return $result;
    }

    
    function get_info($symptoms_id){
        $result=$this->db->query("SELECT * FROM symptoms_info 
            WHERE symptoms_id=$symptoms_id")->row();
        return $result;
    }
    function save($symptoms_id=FALSE){
        $data=array();
        $data['symptoms_name']=$this->input->post('symptoms_name');
        $data['department_id']=$this->session->userdata('department_id');
        if($symptoms_id==FALSE){
        $query=$this->db->insert('symptoms_info',$data);
        }else{
          $this->db->WHERE('symptoms_id',$symptoms_id);
          $query=$this->db->update('symptoms_info',$data);
        }
       return $query;
     
    }
    function delete($symptoms_id) {
        $this->db->WHERE('symptoms_id',$symptoms_id);
        $query=$this->db->delete('symptoms_info');
        return $query;
  }

  
}
