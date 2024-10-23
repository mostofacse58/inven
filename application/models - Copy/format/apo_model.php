<?php
class Apo_model extends CI_Model {
  public function get_count(){
    $condition=' ';
    if($_GET){
      if($this->input->get('po_number')!=''){
        $po_number=$this->input->get('po_number');
        $condition=$condition."  AND pm.po_number='$po_number' ";
      }
      if($this->input->get('product_code')!=''){
        $product_code=$this->input->get('product_code');
        $condition=$condition."  AND (pmd.product_code LIKE '%$product_code%' OR pmd.product_name LIKE '%$product_code%') ";
      }
      if($this->input->get('for_department_id')!='All'){
        $for_department_id=$this->input->get('for_department_id');
        $condition=$condition."  AND pm.for_department_id='$for_department_id' ";
      }
      if($this->input->get('supplier_id')!='All'){
        $supplier_id=$this->input->get('supplier_id');
        $condition=$condition."  AND pm.supplier_id='$supplier_id' ";
      }
      if($this->input->get('from_date')!=''&&$this->input->get('to_date') !=' '){
        $from_date=$this->input->get('from_date');
        $to_date=$this->input->get('to_date');
        $condition.=" AND pm.po_date BETWEEN '$from_date' AND '$to_date'";
      }
     }
     if($this->input->get('product_code')!=''){
        $query=$this->db->query("SELECT pm.*,d.department_name,u.user_name,
          d1.department_name as for_department_name,s.supplier_name      
          FROM  po_master pm 
          INNER JOIN po_pline pmd ON(pm.po_id=pmd.po_id)
          LEFT JOIN department_info d ON(pm.department_id=d.department_id)
          LEFT JOIN department_info d1 ON(pm.for_department_id=d1.department_id) 
          INNER JOIN supplier_info s ON(pm.supplier_id=s.supplier_id)
          LEFT JOIN user u ON(u.id=pm.created_by) 
          WHERE pm.department_id=15  AND pm.po_status>1 AND pm.po_status!=5
          $condition
          GROUP BY pm.po_id");
     }else{
        $query=$this->db->query("SELECT pm.*,d.department_name,u.user_name,
              d1.department_name as for_department_name,s.supplier_name
          FROM  po_master pm 
          LEFT JOIN department_info d ON(pm.department_id=d.department_id)
          LEFT JOIN department_info d1 ON(pm.for_department_id=d1.department_id) 
          INNER JOIN supplier_info s ON(pm.supplier_id=s.supplier_id)
          LEFT JOIN user u ON(u.id=pm.created_by) 
          WHERE pm.department_id=15 
          AND pm.po_status>1 AND pm.po_status!=5  
          $condition");
         }
     $data = count($query->result());
     return $data;
    }
  function lists($limit,$start) {
      $condition=' ';
    if($_GET){
      if($this->input->get('po_number')!=''){
        $po_number=$this->input->get('po_number');
        $condition=$condition."  AND pm.po_number='$po_number' ";
      }
      if($this->input->get('product_code')!=''){
        $product_code=$this->input->get('product_code');
        $condition=$condition."  AND (pmd.product_code LIKE '%$product_code%' OR pmd.product_name LIKE '%$product_code%') ";
      }
      if($this->input->get('for_department_id')!='All'){
        $for_department_id=$this->input->get('for_department_id');
        $condition=$condition."  AND pm.for_department_id='$for_department_id' ";
      }
      if($this->input->get('supplier_id')!='All'){
        $supplier_id=$this->input->get('supplier_id');
        $condition=$condition."  AND pm.supplier_id='$supplier_id' ";
      }
      if($this->input->get('from_date')!=''&&$this->input->get('to_date') !=' '){
        $from_date=$this->input->get('from_date');
        $to_date=$this->input->get('to_date');
        $condition.=" AND pm.po_date BETWEEN '$from_date' AND '$to_date'";
      }
     }
    if($this->input->get('product_code')!=''){
      $result=$this->db->query("SELECT pm.*,d.department_name,u.user_name,
        d1.department_name as for_department_name,s.supplier_name      
        FROM  po_master pm 
        INNER JOIN po_pline pmd ON(pm.po_id=pmd.po_id)
        LEFT JOIN department_info d ON(pm.department_id=d.department_id)
        LEFT JOIN department_info d1 ON(pm.for_department_id=d1.department_id) 
        INNER JOIN supplier_info s ON(pm.supplier_id=s.supplier_id)
        LEFT JOIN user u ON(u.id=pm.created_by) 
        WHERE pm.department_id=15  
        AND pm.po_status>1 AND pm.po_status!=5
        $condition
        GROUP BY pm.po_id
      ORDER BY pm.po_id DESC 
      LIMIT $start,$limit")->result();
     }else{
      $result=$this->db->query("SELECT pm.*,d.department_name,u.user_name,
            d1.department_name as for_department_name,s.supplier_name
        FROM  po_master pm 
        LEFT JOIN department_info d ON(pm.department_id=d.department_id)
        LEFT JOIN department_info d1 ON(pm.for_department_id=d1.department_id) 
        INNER JOIN supplier_info s ON(pm.supplier_id=s.supplier_id)
        LEFT JOIN user u ON(u.id=pm.created_by) 
        WHERE pm.department_id=15  
        AND pm.po_status>1 AND pm.po_status!=5
        $condition
        ORDER BY pm.po_id DESC 
        LIMIT $start,$limit")->result();
       }
      return $result;
    }

  public function getDetails($po_id=''){
   $result=$this->db->query("SELECT p.*,c.category_name,pud.*
        FROM po_pline pud
        LEFT JOIN product_info p ON(pud.product_id=p.product_id)
        LEFT JOIN category_info c ON(p.category_id=c.category_id)
        WHERE pud.po_id=$po_id 
        ORDER BY pud.product_name ASC")->result();
   return $result;
  }
  //////////////////////////////////
 function approved($po_id) {
    $data=array();
    $data['po_status']=3;
    $data['approved_date']=date('Y-m-d');
    $data['approved_date_time']=date('Y-m-d H:i:s');
    $data['approved_by']=$this->session->userdata('user_id');
    $this->db->WHERE('po_id',$po_id);
    $query=$this->db->Update('po_master',$data);
    return $query;
 }
 ///////////////////////////////////
 function returns($po_id) {
    $data=array();
    $data['po_status']=1;
    $data['return_date']=date('Y-m-d');
    $this->db->WHERE('po_id',$po_id);
    $query=$this->db->update('po_master',$data);
    return $query;
 }

  
}
