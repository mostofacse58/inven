<?php
class Employee_model extends CI_Model {

    function lists() {
        $result=$this->db->query("SELECT * FROM employee_idcard_info 
            WHERE 1
            ORDER BY employee_id")->result();
        return $result;
    }
    function get_info($employee_id){
        $result=$this->db->query("SELECT * FROM employee_idcard_info 
            WHERE employee_id=$employee_id")->row();
        return $result;
    }
    function save($employee_id=FALSE){
        $data=array();
        $data['employee_name']=$this->input->post('employee_name');
        $data['designation']=$this->input->post('designation');
        $data['department_name']=$this->input->post('department_name');
        $data['join_date']=$this->input->post('join_date');
        $data['employee_cardno']=$this->input->post('employee_cardno');
        $data['division']=$this->input->post('division');
        if($employee_id==FALSE){
        $query=$this->db->insert('employee_idcard_info',$data);
        }else{
          $this->db->WHERE('employee_id',$employee_id);
          $query=$this->db->update('employee_idcard_info',$data);
        }
       return $query;
     
    }
    function delete($employee_id) {
        $this->db->WHERE('employee_id',$employee_id);
        $query=$this->db->delete('employee_info');
        return $query;
  }

  
}
