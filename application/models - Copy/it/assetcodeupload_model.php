<?php
class Assetcodeupload_model extends CI_Model{
     ////////////// save Excel ///////////
    function insertproduct($data) {
      $this->db->insert('product_info',$data);
      return $this->db->insert_id();
    }
    function insertSN($data) {
      $this->db->insert('product_detail_info',$data);
      return $this->db->insert_id();
    }
    function insertIssue($data) {
      $this->db->insert('asset_issue_master',$data);
      return $this->db->insert_id();
    }
     function checkBrand($brand_name){
      $brand_name=strtoupper($brand_name);
      $result=$this->db->query("SELECT brand_id FROM
        brand_info  
        WHERE brand_name='$brand_name' ")->row();
      if (count($result)>0) {
        return $result->brand_id;
      }else{
        $data['brand_name']=$brand_name;
        $this->db->insert('brand_info',$data);
        $brand_id=$this->db->insert_id();
        return $brand_id;
      }
    }

    function checkcat($category_name){
      $category_name=strtoupper($category_name);
      $department_id=$this->session->userdata('department_id');
      $result=$this->db->query("SELECT category_id 
        FROM category_info  
        WHERE category_name='$category_name' AND department_id=$department_id")->row();
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
    function checkproduct($product_name,$product_code,$category_name){
      $department_id=$this->session->userdata('department_id');
      $result=$this->db->query("SELECT p.product_id 
        FROM product_info p,
        category_info c 
        WHERE p.product_name='$product_name' 
        AND p.product_code='$product_code' 
        AND p.category_id=c.category_id
        AND c.category_name='$category_name' 
        AND p.department_id=$department_id")->row();
      if(count($result)>0){
        return $result->product_id;
      }else{
        return 0;
      }
    }
    function checkSN($asset_encoding,$product_id){
      $department_id=$this->session->userdata('department_id');
      $asset_encoding=strtoupper($asset_encoding);
      $result=$this->db->query("SELECT p.product_detail_id 
        FROM product_detail_info p
        WHERE p.asset_encoding='$asset_encoding' 
        AND p.product_id=$product_id 
        AND p.department_id=$department_id")->row();
      if (count($result)>0) {
        return $result->product_detail_id;
      }else{
        return 0;
      }
    }
    function checklocation($location_name){
      $location_name=strtoupper($location_name);
      $result=$this->db->query("SELECT location_id FROM
        location_info  
        WHERE location_name='$location_name' ")->row();
      if (count($result)>0) {
        return $result->location_id;
      }else{
        $data['location_name']=$location_name;
        $this->db->insert('location_info',$data);
        $location_id=$this->db->insert_id();
        return $location_id;
      }
    }
    function checkDPT($department_name){
      $department_name=strtoupper($department_name);
      $result=$this->db->query("SELECT department_id 
        FROM department_info  
        WHERE department_name='$department_name' ")->row();
        return $result->department_id;
      
    }

  

  

  
}
