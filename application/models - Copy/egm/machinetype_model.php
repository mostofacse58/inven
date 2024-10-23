<?php
class Machinetype_model extends CI_Model {

    function lists(){
        $department_id=$this->session->userdata('department_id');
        $result=$this->db->query("SELECT a.*
            FROM machine_type a 
            WHERE  department_id=$department_id
            ORDER BY a.machine_type_id")->result();
        return $result;
    }

    
    function get_info($machine_type_id){
        $department_id=$this->session->userdata('department_id');
        $result=$this->db->query("SELECT * FROM machine_type 
            WHERE machine_type_id=$machine_type_id AND department_id=$department_id")->row();
        return $result;
    }
    function save($machine_type_id=FALSE){
        $department_id=$this->session->userdata('department_id');
        $data=array();
        $data['machine_type_name']=$this->input->post('machine_type_name');
        $data['department_id']=$this->session->userdata('department_id');
        if($machine_type_id==FALSE){
        $query=$this->db->insert('machine_type',$data);
        }else{
          $this->db->WHERE('machine_type_id',$machine_type_id);
          $query=$this->db->update('machine_type',$data);
        }
       return $query;
     
    }
    function delete($machine_type_id) {
        $department_id=$this->session->userdata('department_id');
        $this->db->WHERE('machine_type_id',$machine_type_id);
        $query=$this->db->delete('machine_type');
        return $query;
  }

  
}
