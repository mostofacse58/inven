<?php
class Grn_model extends CI_Model {
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
      if($this->input->get('for_department_id')!='All'){
        $for_department_id=$this->input->get('for_department_id');
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
          FROM  purchase_master_cn pm 
          INNER JOIN purchase_detail_cn pmd ON(pm.purchase_id=pmd.purchase_id)
          LEFT JOIN department_info d ON(pm.for_department_id=d.department_id) 
          INNER JOIN supplier_info s ON(pm.supplier_id=s.supplier_id)
          LEFT JOIN user u ON(u.id=pm.user_id) 
          WHERE  pm.status!=5 AND pm.grn_type=1
          $condition
          GROUP BY pm.purchase_id");
     }else{
        $query=$this->db->query("SELECT pm.*,u.user_name,
          d.department_name as for_department_name,s.supplier_name      
          FROM  purchase_master_cn pm 
          LEFT JOIN department_info d ON(pm.for_department_id=d.department_id) 
          INNER JOIN supplier_info s ON(pm.supplier_id=s.supplier_id)
          LEFT JOIN user u ON(u.id=pm.user_id) 
          WHERE pm.status!=5 AND pm.grn_type=1 
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
      if($this->input->get('for_department_id')!='All'){
        $for_department_id=$this->input->get('for_department_id');
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
          FROM  purchase_master_cn pm 
          INNER JOIN purchase_detail_cn pmd ON(pm.purchase_id=pmd.purchase_id)
          LEFT JOIN department_info d ON(pm.for_department_id=d.department_id) 
          INNER JOIN supplier_info s ON(pm.supplier_id=s.supplier_id)
          LEFT JOIN user u ON(u.id=pm.user_id) 
          WHERE  pm.status!=5 AND pm.grn_type=1 
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
          WHERE pm.status!=5 AND pm.grn_type=1 
          $condition
        ORDER BY pm.purchase_id DESC 
        LIMIT $start,$limit")->result();
       }
      return $result;
    }
    function get_info($purchase_id){
         $result=$this->db->query("SELECT pm.*,pi.pi_no,s.supplier_name,
          u.user_name,u1.user_name as received_by_name, '' as challan_date,
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
    function save($purchase_id) {
        $hkdrate=getHKDRate($this->input->post('currency'));
        ////////////////////////////////////////////////////
        $department_id=$this->session->userdata('department_id');
        $data=array();
        $data['supplier_id']=$this->input->post('supplier_id');
        //$data['grand_total']=$this->input->post('grand_total');
        $data['purchase_date']=alterDateFormat($this->input->post('purchase_date'));
        $data['user_id']=$this->session->userdata('user_id');
        $data['department_id']=$department_id;
        $data['for_department_id']=$this->input->post('for_department_id');;
        $data['currency']=$this->input->post('currency');
        $data['tolerance_perc']=$this->input->post('tolerance_perc');
        $data['cnc_rate_in_hkd']=$this->input->post('cnc_rate_in_hkd');
        $po_number=$this->input->post('po_number');
        $po_number=str_replace(" ","",$po_number);

        $data['po_number']=$po_number;
        $chkpo_number=$po_number;
        $data['po_id']=$this->input->post('po_id');
        $data['note']=$this->input->post('note');
        $data['file_no']=$this->input->post('file_no');
        //$this->db->query("SELECT IFNULL(po_id,0) as po_id FROM po_master WHERE po_number='$chkpo_number' ")->row('po_id');
        ////////////////////////////////////////
        $product_id=$this->input->post('product_id');
        $quantity=$this->input->post('quantity');
        $unit_price=$this->input->post('unit_price');
        $amount=$this->input->post('amount');
        $product_code=$this->input->post('product_code');
        $pi_no=$this->input->post('pi_no');
        $po_qty=$this->input->post('po_qty');
        $specification=$this->input->post('specification');
        $i=0;
        $year=date('y');
        $month=date('m');
        $day=date('dHis');
        $grand_total=0;
        $ymd="$year$month$day";
        if($purchase_id==FALSE){
          $data['reference_no']=$ymd;
          $query=$this->db->insert('purchase_master_cn',$data);
          $purchase_id=$this->db->insert_id();
        }
        $data1['currency']=$this->input->post('currency');
        /////////////////
        foreach ($product_id as $value) {
           $counts=$this->db->query("SELECT count(*) as counts 
            FROM stock_master_detail 
            WHERE FIFO_CODE LIKE '$ymd%' 
            AND (TRX_TYPE='GRN' OR TRX_TYPE='RETURN') ")->row('counts');
           $data1['FIFO_CODE']=$ymd.str_pad($counts + 1, 4, '0', STR_PAD_LEFT);
           $data1['purchase_id']=$purchase_id;
           $data1['product_id']=$value;
           $data1['pi_no']=trim($pi_no[$i]);
           $chkpi_no=trim($pi_no[$i]);
           $piinfo=$this->db->query("SELECT pi_id FROM pi_master 
            WHERE pi_no='$chkpi_no' ")->row('pi_id');
           if(!empty($piinfo))
           $data1['pi_id']=$piinfo;           
           $data1['po_qty']=$po_qty[$i];
           $data1['quantity']=$quantity[$i];
           $data1['unit_price']=$unit_price[$i];
           $data1['product_code']=$product_code[$i];
           $data1['specification']=$specification[$i];
           $grand_total=$grand_total+$amount[$i];
           $data1['amount']=$amount[$i];
           $data1['amount_hkd']=$amount[$i]*$hkdrate;
           $data1['department_id']=$department_id;
           $data1['box_name']=$box_name[$i];
           $data1['date']=alterDateFormat($this->input->post('purchase_date'));
           $query=$this->db->insert('purchase_detail_cn',$data1);
           $i++;
           }
          $data4['grand_total']=$grand_total;
          $this->db->WHERE('purchase_id',$purchase_id);
          $this->db->UPDATE('purchase_master_cn',$data4);
        return $query;
    }
  
  function delete($purchase_id) {
    $this->db->WHERE('purchase_id',$purchase_id);
    $query=$this->db->update('purchase_detail_cn',array('status'=>5));
    $this->db->WHERE('purchase_id',$purchase_id);
    $query=$this->db->update('purchase_master_cn',array('status'=>5));
    return $query;
  }
  public function getDetails($purchase_id=''){
   $result=$this->db->query("SELECT p.*,pud.*,c.category_name,u.unit_name,0 as unqualified_qty
        FROM purchase_detail_cn pud
        INNER JOIN product_info p ON(pud.product_id=p.product_id)
        INNER JOIN category_info c ON(p.category_id=c.category_id)
        INNER JOIN product_unit u ON(p.unit_id=u.unit_id)
        WHERE pud.purchase_id=$purchase_id AND pud.status!=5
        ORDER BY p.product_name ASC")->result();
   return $result;
  }
  function submit($purchase_id) {
    $this->db->WHERE('purchase_id',$purchase_id);
    $query=$this->db->update('purchase_master_cn',
      array('status'=>2,
        'submit_date'=>date('Y-m-d'),
        'invoice_no'=>$this->input->post('invoice_no')));
  return $query;
 }
 
    
  
}
