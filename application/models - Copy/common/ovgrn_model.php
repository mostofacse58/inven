<?php
class Ovgrn_model extends CI_Model {
  public function get_count(){
    $condition=' ';
    if($_GET){
      if($this->input->get('reference_no')!=''){
        $reference_no=$this->input->get('reference_no');
        $condition=$condition."  AND pm.reference_no='$reference_no' ";
      }
      if($this->input->get('po_number')!=''){
        $po_number=$this->input->get('po_number');
        $condition=$condition."  AND pm.po_number='$po_number' ";
      }
      if($this->input->get('invoice_no')!=''){
        $invoice_no=$this->input->get('invoice_no');
        $condition=$condition."  AND pm.invoice_no='$invoice_no' ";
      }
      if($this->input->get('product_code')!=''){
        $product_code=$this->input->get('product_code');
        $condition=$condition."  AND (pmd.product_code LIKE '%$product_code%') ";
      }
      if($this->input->get('from_date')!=''&&$this->input->get('to_date') !=' '){
        $from_date=$this->input->get('from_date');
        $to_date=$this->input->get('to_date');
        $condition.=" AND pm.po_date BETWEEN '$from_date' AND '$to_date'";
      }
     }

     $department_id=$this->session->userdata('department_id');
     if($this->input->get('product_code')!=''){
        $query=$this->db->query("SELECT pm.*,u.user_name,
          d.department_name as for_department_name,s.supplier_name      
          FROM  purchase_master_cn pm 
          INNER JOIN purchase_detail_cn pmd ON(pm.purchase_id=pmd.purchase_id)
          LEFT JOIN department_info d ON(pm.for_department_id=d.department_id) 
          INNER JOIN supplier_info s ON(pm.supplier_id=s.supplier_id)
          LEFT JOIN user u ON(u.id=pm.user_id) 
          WHERE pm.for_department_id=$department_id  AND pm.status!=5 AND pm.grn_type=1
          $condition
          GROUP BY pm.purchase_id");
     }else{
        $query=$this->db->query("SELECT pm.*,u.user_name,
          d.department_name as for_department_name,s.supplier_name      
          FROM  purchase_master_cn pm 
          LEFT JOIN department_info d ON(pm.for_department_id=d.department_id) 
          INNER JOIN supplier_info s ON(pm.supplier_id=s.supplier_id)
          LEFT JOIN user u ON(u.id=pm.user_id) 
          WHERE pm.status!=5 AND  pm.for_department_id=$department_id AND pm.grn_type=1 
          $condition");
         }
     $data = count($query->result());
     return $data;
    }
  function lists($limit,$start) {
    $condition=' ';
    if($_GET){
      if($this->input->get('reference_no')!=''){
        $reference_no=$this->input->get('reference_no');
        $condition=$condition."  AND pm.reference_no='$reference_no' ";
      }
      if($this->input->get('po_number')!=''){
        $po_number=$this->input->get('po_number');
        $condition=$condition."  AND pm.po_number='$po_number' ";
      }
      if($this->input->get('invoice_no')!=''){
        $invoice_no=$this->input->get('invoice_no');
        $condition=$condition."  AND pm.invoice_no='$invoice_no' ";
      }
      if($this->input->get('product_code')!=''){
        $product_code=$this->input->get('product_code');
        $condition=$condition."  AND (pmd.product_code LIKE '%$product_code%') ";
      }
      if($this->input->get('from_date')!=''&&$this->input->get('to_date') !=' '){
        $from_date=$this->input->get('from_date');
        $to_date=$this->input->get('to_date');
        $condition.=" AND pm.po_date BETWEEN '$from_date' AND '$to_date'";
      }
     }
    $department_id=$this->session->userdata('department_id');
    if($this->input->get('product_code')!=''){
      $result=$this->db->query("SELECT pm.*,u.user_name,
          d.department_name as for_department_name,s.supplier_name,s.company_name      
          FROM  purchase_master_cn pm 
          INNER JOIN purchase_detail_cn pmd ON(pm.purchase_id=pmd.purchase_id)
          LEFT JOIN department_info d ON(pm.for_department_id=d.department_id) 
          INNER JOIN supplier_info s ON(pm.supplier_id=s.supplier_id)
          LEFT JOIN user u ON(u.id=pm.user_id) 
          WHERE  pm.status!=5 AND pm.grn_type=1 AND  pm.for_department_id=$department_id 
          $condition
        GROUP BY pm.purchase_id
        ORDER BY pm.purchase_id DESC LIMIT $start,$limit")->result();
     }else{
      $result=$this->db->query("SELECT pm.*,u.user_name,
          d.department_name as for_department_name,s.supplier_name,s.company_name      
          FROM  purchase_master_cn pm 
          LEFT JOIN department_info d ON(pm.for_department_id=d.department_id) 
          INNER JOIN supplier_info s ON(pm.supplier_id=s.supplier_id)
          LEFT JOIN user u ON(u.id=pm.user_id) 
          WHERE pm.status!=5 AND pm.grn_type=1 AND  pm.for_department_id=$department_id 
          $condition
        ORDER BY pm.purchase_id DESC 
        LIMIT $start,$limit")->result();
       }
      return $result;
    }
    function get_info($purchase_id){
         $result=$this->db->query("SELECT pm.*,pi.pi_no,s.supplier_name,
          u.user_name,u1.user_name as received_by_name,
          (SELECT SUM(pud.quantity) FROM purchase_detail_cn pud 
          WHERE pm.purchase_id=pud.purchase_id) as totalquantity
          FROM  purchase_master_cn pm 
          LEFT JOIN pi_master pi ON(pm.pi_id=pi.pi_id)
          LEFT JOIN supplier_info s ON(pm.supplier_id=s.supplier_id)
          LEFT JOIN user u ON(u.id=pm.user_id) 
          LEFT JOIN user u1 ON(u1.id=pm.received_by) 
          WHERE pm.purchase_id=$purchase_id")->row();
        return $result;
    }
   
 function returns($purchase_id){
    $data2['received_by']=$this->session->userdata('user_id');
    $data2['status']=1;
    $this->db->where('purchase_id', $purchase_id);
    $query=$this->db->update('purchase_master_cn',$data2);
    return $query;
  }
   function received($purchase_id){
    $data2['received_by']=$this->session->userdata('user_id');
    $data2['received_date']=date('Y-m-d');
    $data2['status']=3;
    $this->db->where('purchase_id', $purchase_id);
    $query=$this->db->update('purchase_master_cn',$data2);
    return $query;
  }
 
    
  
}
