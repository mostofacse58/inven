<?php
class Rfir_model extends CI_Model {
  public function get_count(){
    $condition=' ';
    if($_GET){
      if($this->input->get('product_code')!=''){
        $product_code=$this->input->get('product_code');
        $condition=$condition."  AND pmd.product_code LIKE '%$product_code%' ";
      }
      if($this->input->get('rfi_no')!=''){
        $rfi_no=$this->input->get('rfi_no');
        $condition=$condition."  AND pm.rfi_no='$rfi_no' ";
      }
      if($this->input->get('department_id')!='All'){
        $department_id1=$this->input->get('department_id');
        $condition=$condition."  AND pm.department_id='$department_id1' ";
      }
     }
    $department_id=$this->session->userdata('department_id');
    if($this->input->get('product_code')!=''){
      $query=$this->db->query("SELECT pm.*,pt.department_name,u.user_name
          FROM  rfi_master pm 
          LEFT JOIN rfi_item_details pmd ON(pm.rfi_id=pmd.rfi_id)
          LEFT JOIN department_info pt ON(pm.department_id=pt.department_id)
          LEFT JOIN user u ON(u.id=pm.requested_by) 
          WHERE pm.rfi_status>1 $condition 
          GROUP BY pm.rfi_id");

    }else{
      $query=$this->db->query("SELECT pm.*,pt.department_name,u.user_name
          FROM  rfi_master pm 
          LEFT JOIN department_info pt ON(pm.department_id=pt.department_id)
          LEFT JOIN user u ON(u.id=pm.requested_by) 
          WHERE  pm.rfi_status>2  $condition ");
    }
      
      $data = count($query->result());
      return $data;
    }
    function lists($limit,$start) {
        $condition=' ';
        if($_GET){
          if($this->input->get('product_code')!=''){
            $product_code=$this->input->get('product_code');
            $condition=$condition."  AND pmd.product_code LIKE '%$product_code%' ";
          }
          if($this->input->get('rfi_no')!=''){
            $rfi_no=$this->input->get('rfi_no');
            $condition=$condition."  AND pm.rfi_no='$rfi_no' ";
          }
          if($this->input->get('department_id')!='All'){
            $department_id1=$this->input->get('department_id');
            $condition=$condition."  AND pm.department_id='$department_id1' ";
          }
         }
         $department_id=$this->session->userdata('department_id');
        if($this->input->get('product_code')!=''){
          $result=$this->db->query("SELECT pm.*,pt.department_name,u.user_name
          FROM  rfi_master pm 
          LEFT JOIN rfi_item_details pmd ON(pm.rfi_id=pmd.rfi_id)
          LEFT JOIN department_info pt ON(pm.department_id=pt.department_id)
          LEFT JOIN user u ON(u.id=pm.requested_by) 
          WHERE pm.rfi_status>1 
          $condition
          GROUP BY pm.rfi_id 
          ORDER BY pm.rfi_status ASC,pm.aproved_date_time DESC
          LIMIT $start,$limit")->result();

        }else{
          $result=$this->db->query("SELECT pm.*,pt.department_name,u.user_name
          FROM  rfi_master pm 
          LEFT JOIN department_info pt ON(pm.department_id=pt.department_id)
          LEFT JOIN user u ON(u.id=pm.requested_by) 
          WHERE  pm.rfi_status>1
          $condition
          ORDER BY pm.rfi_status ASC,pm.aproved_date_time DESC
          LIMIT $start,$limit")->result();
        }
        
      return $result;
    }

  public function getDetails($rfi_id=''){
   $result=$this->db->query("SELECT pud.*,p.*,c.category_name,u.unit_name
        FROM rfi_item_details pud
        INNER JOIN product_info p ON(pud.product_id=p.product_id)
        INNER JOIN category_info c ON(p.category_id=c.category_id)
        INNER JOIN product_unit u ON(p.unit_id=u.unit_id)
        WHERE pud.rfi_id=$rfi_id 
        ORDER BY p.product_name ASC")->result();
   return $result;
  }
   function received($rfi_id) {
      $data=array();
      $data['rfi_status']=3;
      $data['received_date']=date('Y-m-d h:i:s a');
      $data['approved_by']=$this->session->userdata('user_id');
      $this->db->WHERE('rfi_id',$rfi_id);
      $query=$this->db->Update('rfi_master',$data);
      return $query;
  }
   function rejected($rfi_id) {
      $data=array();
      $data['rfi_status']=0;
      $this->db->WHERE('rfi_id',$rfi_id);
      $query=$this->db->Update('rfi_master',$data);
      return $query;
   }
   function returns($rfi_id) {
      $data=array();
      $data['rfi_status']=1;
      $this->db->WHERE('rfi_id',$rfi_id);
      $query=$this->db->Update('rfi_master',$data);
      return $query;
     }
  
}
