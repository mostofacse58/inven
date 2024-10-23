<?php
class Brand_model extends CI_Model {

    function lists(){
        $department_id=$this->session->userdata('department_id');
        $result=$this->db->query("SELECT a.*
            FROM brand_info a 
            WHERE department_id=$department_id
            ORDER BY a.brand_id")->result();
        return $result;
    }
    function get_info($brand_id){
      $result=$this->db->query("SELECT * FROM brand_info 
            WHERE brand_id=$brand_id")->row();
      return $result;
    }
    function save($brand_id=FALSE){
        $data=array();
        $data['brand_name']=$this->input->post('brand_name');
        $data['department_id']=$this->session->userdata('department_id');
        if($brand_id==FALSE){
        $query=$this->db->insert('brand_info',$data);
        }else{
          $this->db->WHERE('brand_id',$brand_id);
          $query=$this->db->update('brand_info',$data);
        }
       return $query;
     
    }
    function delete($brand_id) {
        $this->db->WHERE('brand_id',$brand_id);
        $query=$this->db->delete('brand_info');
        return $query;
  }

  
}
