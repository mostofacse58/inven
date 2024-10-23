<?php
class Indent_model extends CI_Model {

    function lists(){
        $department_id=$this->session->userdata('department_id');
        $result=$this->db->query("SELECT a.*
            FROM pi_master a 
            WHERE department_id=$department_id
            ORDER BY a.pi_id")->result();
        return $result;
    }

    
    function get_info($pi_id){
        $result=$this->db->query("SELECT * FROM pi_master 
            WHERE pi_id=$pi_id")->row();
        return $result;
    }
    function save($pi_id=FALSE){
        $data=array();
        $data['pi_no']=$this->input->post('pi_no');
        $data['department_id']=$this->session->userdata('department_id');
        $data['pi_date']=date('Y-m-d');
        if($pi_id==FALSE){
        $query=$this->db->insert('pi_master',$data);
        }else{
          $this->db->WHERE('pi_id',$pi_id);
          $query=$this->db->update('pi_master',$data);
        }
       return $query;
    }
    function delete($pi_id) {
        $this->db->WHERE('pi_id',$pi_id);
        $query=$this->db->delete('pi_master');
        return $query;
  }

  
}
