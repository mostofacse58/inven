<?php
class Category_model extends CI_Model {

    function lists(){
        if($this->session->userdata('user_type')==1){
            $result=$this->db->query("SELECT c.*,d.department_name
            FROM category_info c,department_info d
            WHERE c.department_id=d.department_id 
            ORDER BY c.category_id")->result();
        }else{
            $department_id=$this->session->userdata('department_id');
            $result=$this->db->query("SELECT c.*,d.department_name
            FROM category_info c,department_info d
            WHERE c.department_id=d.department_id AND c.department_id=$department_id
            ORDER BY c.category_id")->result();
        }
        return $result;
    }

    
    function get_info($category_id){
        $result=$this->db->query("SELECT * FROM category_info 
            WHERE category_id=$category_id")->row();
        return $result;
    }
    function save($category_id=FALSE){
        $data=array();
        $data['category_name']=strtoupper($this->input->post('category_name'));
        $data['department_id']=$this->input->post('department_id');
        $data['cat_type']=$this->input->post('cat_type');
        $data['user_id']=$this->session->userdata('user_id');
        if($category_id==FALSE){
        $query=$this->db->insert('category_info',$data);
        }else{
          $this->db->WHERE('category_id',$category_id);
          $query=$this->db->update('category_info',$data);
        }
       return $query;
     
    }
    function delete($category_id) {
        $this->db->WHERE('category_id',$category_id);
        $query=$this->db->delete('category_info');
        return $query;
  }

  
}
