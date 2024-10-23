<?php
class Bulkupload_model extends CI_Model{
     ////////////// save Excel ///////////
    function insertproduct($data) {
      $this->db->insert('product_info',$data);
      return $this->db->insert_id();
    }

    function checkcat($category_name){
      $category_name=strtoupper($category_name);
      $department_id=$this->input->post('department_id');
      $result=$this->db->query("SELECT category_id 
        FROM category_info  
        WHERE category_name='$category_name' 
        AND department_id=$department_id")->row();
      if (count($result)>0) {
        return $result->category_id;
      }else{
        $data['category_name']=$category_name;
        $data['department_id']=$department_id;
        $this->db->insert('category_info',$data);
        $category_id=$this->db->insert_id();
        return $category_id;
      }
    }
    function checkproduct($product_name,$category_name){
      $department_id=$this->input->post('department_id');
      $result=$this->db->query("SELECT p.product_id 
        FROM product_info p,
        category_info c 
        WHERE p.product_name='$product_name' 
        AND p.category_id=c.category_id
        AND c.category_name='$category_name' 
        AND p.department_id=12")->row();
      if(count($result)>0){
        return $result->product_id;
      }else{
        return 0;
      }
    }

    function checklocation($box_name){
      $result=$this->db->query("SELECT box_id FROM
        box_info  
        WHERE box_name='$box_name' ")->row();
      if (count($result)>0) {
        return $result->box_id;
      }else{
        $data['box_name']=$box_name;
        $this->db->insert('box_info',$data);
        $box_id=$this->db->insert_id();
        return $box_id;
      }
    }
    function checkUnit($unit_name){
      $result=$this->db->query("SELECT unit_id FROM
        product_unit  
        WHERE unit_name='$unit_name' ")->row();
      if (count($result)>0) {
        return $result->unit_id;
      }else{
        $data['unit_name']=$unit_name;
        $this->db->insert('product_unit',$data);
        $unit_id=$this->db->insert_id();
        return $unit_id;
      }
    }
    
  

  
}
