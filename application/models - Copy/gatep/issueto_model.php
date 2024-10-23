<?php
class Issueto_model extends CI_Model {
    function lists(){
        $department_id=$this->session->userdata('department_id');
        $result=$this->db->query("SELECT m.*
            FROM issue_to_master m
            WHERE 1
            ORDER BY m.issue_to")->result();
        return $result;
    }
    
    function get_info($issue_to){
        $result=$this->db->query("SELECT * FROM issue_to_master 
            WHERE issue_to=$issue_to")->row();
        return $result;
    }
    function save($issue_to=FALSE){
        $data=array();
        $data['issue_to_name']=$this->input->post('issue_to_name');
        $data['mobile_no']=$this->input->post('mobile_no');
        $data['address']=$this->input->post('address');
        $data['department_id']=$this->session->userdata('department_id');
        if($issue_to==FALSE){
        $query=$this->db->insert('issue_to_master',$data);
        }else{
          $this->db->WHERE('issue_to',$issue_to);
          $query=$this->db->update('issue_to_master',$data);
        }
       return $query;
     
    }
    function delete($issue_to) {
        $this->db->WHERE('issue_to',$issue_to);
        $query=$this->db->delete('issue_to_master');
        return $query;
  }

  
}
