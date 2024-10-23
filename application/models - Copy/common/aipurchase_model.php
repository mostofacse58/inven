<?php
class Aipurchase_model extends CI_Model {
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
      if($this->input->get('product_code')!=''){
        $product_code=$this->input->get('product_code');
        $condition=$condition."  AND (pmd.product_code LIKE '%$product_code%' OR pmd.product_name LIKE '%$product_code%') ";
      }
      if($this->input->get('for_department_id')!='All'){
        $for_department_id=$this->input->get('department_id');
        $condition=$condition."  AND pm.for_department_id=$for_department_id ";
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
          FROM  purchase_master pm 
          INNER JOIN purchase_detail pmd ON(pm.purchase_id=pmd.purchase_id)
          LEFT JOIN department_info d ON(pm.for_department_id=d.department_id) 
          INNER JOIN supplier_info s ON(pm.supplier_id=s.supplier_id)
          LEFT JOIN user u ON(u.id=pm.user_id) 
          WHERE pm.for_department_id=$department_id AND pm.status>=2 AND pm.status!=5
          $condition
          GROUP BY pm.purchase_id")->result();
     }else{
        $query=$this->db->query("SELECT pm.*,u.user_name,
          d.department_name as for_department_name,s.supplier_name      
          FROM  purchase_master pm 
          LEFT JOIN department_info d ON(pm.for_department_id=d.department_id) 
          INNER JOIN supplier_info s ON(pm.supplier_id=s.supplier_id)
          LEFT JOIN user u ON(u.id=pm.user_id) 
          WHERE pm.for_department_id=$department_id AND pm.status>=2 AND pm.status!=5
          $condition")->result();
         }
     $data = count($query);
     return $data;
    }
  function lists($limit,$start) {
    $condition=' ';
    if($_GET){
      if($this->input->get('reference_no')!=''){
        $reference_no=$this->input->get('reference_no');
        $condition=$condition."  AND pm.reference_no='$reference_no' ";
      }
      if($this->input->get('product_code')!=''){
        $product_code=$this->input->get('product_code');
        $condition=$condition."  AND (pmd.product_code LIKE '%$product_code%' OR pmd.product_name LIKE '%$product_code%') ";
      }
      if($this->input->get('for_department_id')!='All'){
        $for_department_id=$this->input->get('department_id');
        $condition=$condition."  AND pm.for_department_id=$for_department_id ";
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
          FROM  purchase_master pm 
          INNER JOIN purchase_detail pmd ON(pm.purchase_id=pmd.purchase_id)
          LEFT JOIN department_info d ON(pm.for_department_id=d.department_id) 
          INNER JOIN supplier_info s ON(pm.supplier_id=s.supplier_id)
          LEFT JOIN user u ON(u.id=pm.user_id) 
          WHERE pm.for_department_id=$department_id AND pm.status>=2 AND pm.status!=5
          $condition
        GROUP BY pm.purchase_id
        ORDER BY pm.purchase_id DESC LIMIT $start,$limit")->result();
     }else{
      $result=$this->db->query("SELECT pm.*,u.user_name,
          d.department_name as for_department_name,s.supplier_name,s.company_name      
          FROM  purchase_master pm 
          LEFT JOIN department_info d ON(pm.for_department_id=d.department_id) 
          INNER JOIN supplier_info s ON(pm.supplier_id=s.supplier_id)
          LEFT JOIN user u ON(u.id=pm.user_id) 
          WHERE pm.for_department_id=$department_id AND pm.status>=2 AND  pm.status!=5
          $condition
        ORDER BY pm.purchase_id DESC LIMIT $start,$limit")->result();
       }
      return $result;
    }
    
   function received($purchase_id) {
    $oldresult=$this->db->query("SELECT sd.*,pm.*
        FROM purchase_detail sd,purchase_master pm 
        WHERE sd.purchase_id=$purchase_id AND sd.purchase_id=pm.purchase_id 
        ORDER BY sd.product_id ASC")->result();
    foreach ($oldresult as $row1){
      ////////// Minus from BDWH Location////////
      $datas=array();
      $datas['TRX_TYPE']="TRFB";
      $datas['department_id']=$row1->for_department_id;
      $datas['product_id']=$row1->product_id;
      $datas['INDATE']=date('Y-m-d');
      $datas['ITEM_CODE']=$row1->product_code;
      $datas['FIFO_CODE']=$row1->FIFO_CODE;
      $datas['LOCATION']="BDWH";
      $datas['LOCATION1']=$this->session->userdata('dept_shortcode');
      $datas['CRRNCY']=$row1->currency;
      $datas['EXCH_RATE']=$row1->cnc_rate_in_hkd;        
      $datas['QUANTITY']=-$row1->quantity;
      $datas['UPRICE']=$row1->unit_price;
      $datas['TOTALAMT']=-$row1->amount;
      $datas['TOTALAMT_HKD']=-$row1->amount_hkd;
      $datas['receive_id']=$row1->purchase_id;
      $datas['REF_CODE']=$row1->reference_no;
      $datas['CRT_USER']=$this->session->userdata('user_name');
      $datas['CRT_DATE']=date('Y-m-d');
      $datas['user_id']=$this->session->userdata('user_id');
      $this->db->insert('stock_master_detail',$datas);
      //////////////////// Plus BHR01 Location////
      $datas=array();
      $datas['TRX_TYPE']="TRFB";
      $datas['department_id']=$row1->for_department_id;
      $datas['product_id']=$row1->product_id;
      $datas['INDATE']=date('Y-m-d');
      $datas['ITEM_CODE']=$row1->product_code;
      $datas['FIFO_CODE']=$row1->FIFO_CODE;
      $datas['LOCATION']=$this->session->userdata('dept_shortcode');
      $datas['LOCATION1']="BDWH";
      $datas['CRRNCY']=$row1->currency;
      $datas['EXCH_RATE']=$row1->cnc_rate_in_hkd;        
      $datas['QUANTITY']=$row1->quantity;
      $datas['UPRICE']=$row1->unit_price;
      $datas['TOTALAMT']=$row1->amount;
      $datas['TOTALAMT_HKD']=-$row1->amount_hkd;
      $datas['receive_id']=$row1->purchase_id;
      $datas['REF_CODE']=$row1->reference_no;
      $datas['CRT_USER']=$this->session->userdata('user_name');
      $datas['CRT_DATE']=date('Y-m-d');
      $datas['user_id']=$this->session->userdata('user_id');
      $this->db->insert('stock_master_detail',$datas);
    }
    ////////////////
    $data=array();
    $data['status']=3;
    $data['received_date']=date('Y-m-d');
    $data['received_by']=$this->session->userdata('user_id');
    $data['head_id']=$this->session->userdata('user_id');
    $this->db->WHERE('purchase_id',$purchase_id);
    $query=$this->db->Update('purchase_master',$data);
    $this->db->WHERE('purchase_id',$purchase_id);
    $query=$this->db->update('purchase_detail',array('status'=>3));
    /////////////////////
    return $query;
 }
   
   
 
    
  
}
