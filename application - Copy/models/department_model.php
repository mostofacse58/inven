<?php
class Department_model extends CI_Model {

    function lists() {
        $result=$this->db->query("SELECT * FROM department_info")->result();
        return $result;
    }
    function get_info($department_id){
        $result=$this->db->query("SELECT * FROM department_info WHERE department_id=$department_id")->row();
        return $result;
    }
    function save($department_id) {
        $data=array();
        $data['department_name']=strtoupper($this->input->post('department_name'));
        $data['dept_head_email']=$this->input->post('dept_head_email');
        if($department_id==FALSE){
        $query=$this->db->insert('department_info',$data);
        }else{
          $this->db->WHERE('department_id',$department_id);
          $query=$this->db->update('department_info',$data);
        }
        
         return $query;
     
    }
    function delete($department_id) {
        $this->db->WHERE('department_id',$department_id);
        $query=$this->db->delete('department_info');
        return $query;
  }

  
}
