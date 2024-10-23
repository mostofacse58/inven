<?php
class Package_model extends CI_Model {

    function lists(){
        $result=$this->db->query("SELECT p.*,h.head_name,d.department_name
            FROM audit_package p
            INNER JOIN audit_head h ON(h.head_id=p.head_id)
            INNER JOIN department_info d ON(d.department_id=p.department_id)
            ORDER BY head_id ")->result();
        return $result;
    }
    function get_info($package_id){
        $result=$this->db->query("SELECT * FROM audit_package 
            WHERE package_id=$package_id ")->row();
        return $result;
    }
    function save($package_id=FALSE){
        $data=array();
        $data['head_id']=$this->input->post('head_id');
        $data['acategory']=$this->input->post('acategory');
        $data['sub_head_name']=$this->input->post('sub_head_name');
        $data['weight']=$this->input->post('weight');
        $data['year']=$this->input->post('year');
        $data['criteria_1']=$this->input->post('criteria_1');
        $data['criteria_2']=$this->input->post('criteria_2');
        $data['criteria_3']=$this->input->post('criteria_3');
        $data['department_id']=$this->input->post('department_id');
        $data['user_id']=$this->session->userdata('user_id');
        $data['create_date']=date('Y-m-d');
        if($package_id==FALSE){
        $query=$this->db->insert('audit_package',$data);
        }else{
          $this->db->WHERE('package_id',$package_id);
          $query=$this->db->update('audit_package',$data);
        }
       return $query;
     
    }
    function delete($package_id) {
        $this->db->WHERE('package_id',$package_id);
        $query=$this->db->delete('audit_package');
        return $query;
  }

  
}
