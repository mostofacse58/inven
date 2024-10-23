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
      $this->db->insert('product_status_info',$data);
      return $this->db->insert_id();
    }

    function checkcat($category_name){
      $category_name=strtoupper($category_name);
      $department_id=$this->session->userdata('department_id');
      $result=$this->db->query("SELECT category_id 
        FROM category_info  
        WHERE category_name='$category_name' 
        AND department_id=12")->row();
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
        AND p.department_id=12")->row();
      if(count($result)>0){
        return $result->product_id;
      }else{
        return 0;
      }
    }
    function checkSN($tpm_serial_code,$product_id){
      $tpm_serial_code=strtoupper($tpm_serial_code);
      $department_id=$this->session->userdata('department_id');
      $result=$this->db->query("SELECT p.product_detail_id 
        FROM product_detail_info p
        WHERE p.tpm_serial_code='$tpm_serial_code' 
        AND p.product_id=$product_id 
        AND p.department_id=12")->row();
      if (count($result)>0) {
        return $result->product_detail_id;
      }else{
        return 0;
      }
    }
    function checklocation($line_no){
      $line_no=strtoupper($line_no);
      $result=$this->db->query("SELECT line_id FROM
        floorline_info  
        WHERE line_no='$line_no' ")->row();
      if (count($result)>0) {
        return $result->line_id;
      }else{
        $data['line_no']=$line_no;
        $this->db->insert('floorline_info',$data);
        $line_id=$this->db->insert_id();
        return $line_id;
      }
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
    function checkType($machine_type_name){
      $machine_type_name=strtoupper($machine_type_name);
      $result=$this->db->query("SELECT machine_type_id FROM
        machine_type  
        WHERE machine_type_name='$machine_type_name' ")->row();
      if (count($result)>0) {
        return $result->machine_type_id;
      }else{
        $data['machine_type_name']=$machine_type_name;
        $this->db->insert('machine_type',$data);
        $machine_type_id=$this->db->insert_id();
        return $machine_type_id;
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
