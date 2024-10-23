<?php
class Dpo_model extends CI_Model {
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
      if($this->input->get('department_id')!='All'){
          $department_id=$this->input->get('department_id');
          $condition=$condition."  AND pm.for_department_id='$department_id' ";
        }

      if($this->input->get('from_date')!=''&&$this->input->get('to_date') !=' '){
        $from_date=$this->input->get('from_date');
        $to_date=$this->input->get('to_date');
        $condition.=" AND pm.po_date BETWEEN '$from_date' AND '$to_date'";
      }
     }
     $department_id=$this->session->userdata('department_id');
     if($this->input->get('product_code')!=''){
        $query=$this->db->query("SELECT pm.*,d.department_name,u.user_name,
          d1.department_name as for_department_name,s.supplier_name      
          FROM  po_master pm 
          INNER JOIN po_pline pmd ON(pm.po_id=pmd.po_id)
          LEFT JOIN department_info d ON(pm.department_id=d.department_id)
          LEFT JOIN department_info d1 ON(pm.for_department_id=d1.department_id) 
          INNER JOIN supplier_info s ON(pm.supplier_id=s.supplier_id)
          LEFT JOIN user u ON(u.id=pm.created_by) 
          WHERE  pm.po_status>2 AND pm.po_status!=5
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
          WHERE pm.po_status>2 AND pm.po_status!=5  $condition");
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
      if($this->input->get('department_id')!='All'){
          $department_id=$this->input->get('department_id');
          $condition=$condition."  AND pm.for_department_id='$department_id' ";
        }
  
      if($this->input->get('from_date')!=''&&$this->input->get('to_date') !=' '){
        $from_date=$this->input->get('from_date');
        $to_date=$this->input->get('to_date');
        $condition.=" AND pm.po_date BETWEEN '$from_date' AND '$to_date'";
      }
     }
     $department_id=$this->session->userdata('department_id');
    if($this->input->get('product_code')!=''){
      $result=$this->db->query("SELECT pm.*,d.department_name,u.user_name,
        d1.department_name as for_department_name,s.supplier_name      
        FROM  po_master pm 
        INNER JOIN po_pline pmd ON(pm.po_id=pmd.po_id)
        LEFT JOIN department_info d ON(pm.department_id=d.department_id)
        LEFT JOIN department_info d1 ON(pm.for_department_id=d1.department_id) 
        INNER JOIN supplier_info s ON(pm.supplier_id=s.supplier_id)
        LEFT JOIN user u ON(u.id=pm.created_by) 
        WHERE  pm.po_status>1 AND pm.po_status!=5
        $condition
        GROUP BY pm.po_id
      ORDER BY pm.po_id DESC LIMIT $start,$limit")->result();
     }else{
      $result=$this->db->query("SELECT pm.*,d.department_name,u.user_name,
            d1.department_name as for_department_name,s.supplier_name
        FROM  po_master pm 
        LEFT JOIN department_info d ON(pm.department_id=d.department_id)
        LEFT JOIN department_info d1 ON(pm.for_department_id=d1.department_id) 
        INNER JOIN supplier_info s ON(pm.supplier_id=s.supplier_id)
        LEFT JOIN user u ON(u.id=pm.created_by) 
        WHERE  pm.po_status>1 AND pm.po_status!=5
        $condition
        ORDER BY pm.po_id DESC LIMIT $start,$limit")->result();
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


  
}
