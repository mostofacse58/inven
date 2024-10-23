<?php
class Extragrn_model extends CI_Model {
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
        $condition=$condition."  AND (pmd.product_code LIKE '%$product_code%' ) ";
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
          WHERE pm.department_id=$department_id  AND pm.status!=5 AND pm.grn_type=2
          $condition
          GROUP BY pm.purchase_id")->result();
     }else{
        $query=$this->db->query("SELECT pm.*,u.user_name,
          d.department_name as for_department_name,s.supplier_name      
          FROM  purchase_master pm 
          LEFT JOIN department_info d ON(pm.for_department_id=d.department_id) 
          INNER JOIN supplier_info s ON(pm.supplier_id=s.supplier_id)
          LEFT JOIN user u ON(u.id=pm.user_id) 
          WHERE pm.department_id=$department_id  AND pm.status!=5 AND pm.grn_type=2 
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
        $condition=$condition."  AND (pmd.product_code LIKE '%$product_code%') ";
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
          WHERE pm.department_id=$department_id AND pm.status!=5 AND pm.grn_type=2
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
          WHERE pm.department_id=$department_id AND pm.status!=5 AND pm.grn_type=2
          $condition
        ORDER BY pm.purchase_id DESC LIMIT $start,$limit")->result();
       }
      return $result;
    }
    function get_info($purchase_id){
         $result=$this->db->query("SELECT pm.*,pi.pi_no,s.company_name,
          u.user_name,u1.user_name as received_by_name,
          (SELECT SUM(pud.quantity) FROM purchase_detail pud 
          WHERE pm.purchase_id=pud.purchase_id) as totalquantity
          FROM  purchase_master pm 
          LEFT JOIN pi_master pi ON(pm.pi_id=pi.pi_id)
          LEFT JOIN supplier_info s ON(pm.supplier_id=s.supplier_id)
          LEFT JOIN user u ON(u.id=pm.user_id) 
          LEFT JOIN user u1 ON(u1.id=pm.received_by) 
          WHERE pm.purchase_id=$purchase_id")->row();
        return $result;
    }
    function save($purchase_id) {
        $department_id=$this->session->userdata('department_id');
        $data=array();
        $data['supplier_id']=$this->input->post('supplier_id');
        $data['grand_total']=$this->input->post('grand_total');
        $data['purchase_date']=alterDateFormat($this->input->post('purchase_date'));
        $data['user_id']=$this->session->userdata('user_id');
        $data['department_id']=$department_id;
        $data['grn_type']=2;
        $data['for_department_id']=$this->input->post('for_department_id');
        $data['currency']=$this->input->post('currency');
        $data['tolerance_perc']=$this->input->post('tolerance_perc');
        $data['cnc_rate_in_hkd']=$this->input->post('cnc_rate_in_hkd');
        $data['po_number']=$this->input->post('po_number');
        $chkpo_number=$this->input->post('po_number');
        $data['po_id']=$this->input->post('po_id');
        $data['note']=$this->input->post('note');
        //$this->db->query("SELECT IFNULL(po_id,0) as po_id FROM po_master WHERE po_number='$chkpo_number' ")->row('po_id');
        ////////////////////////////////////////
        $product_id=$this->input->post('product_id');
        $quantity=$this->input->post('quantity');
        $unit_price=$this->input->post('unit_price');
        $amount=$this->input->post('amount');
        $product_code=$this->input->post('product_code');
        $pi_no=$this->input->post('pi_no');
        $po_qty=$this->input->post('po_qty');
        $i=0;
        $year=date('y');
        $month=date('m');
        $day=date('d');
        $ymd="$year$month$day";
        if($purchase_id==FALSE){
          $data['reference_no']=$ymd.$this->input->post('reference_no');
        $query=$this->db->insert('purchase_master',$data);
        $purchase_id=$this->db->insert_id();
        }
        // 2020-01-27
        // 0123-56-89
        
        $data1['currency']=$this->input->post('currency');
        $data1['cnc_rate_in_hkd']=$this->input->post('cnc_rate_in_hkd');
        foreach ($product_id as $value) {
          $counts=$this->db->query("SELECT count(*) as counts FROM purchase_detail 
            WHERE FIFO_CODE LIKE '$ymd%' ")->row('counts');
           $data1['FIFO_CODE']=$ymd.str_pad($counts + 1, 4, '0', STR_PAD_LEFT);
           $data1['purchase_id']=$purchase_id;
           $data1['product_id']=$value;
           $data1['pi_no']=$pi_no[$i];
           $chkpi_no=$pi_no[$i];
           $piinfo=$this->db->query("SELECT pi_id FROM pi_master 
            WHERE pi_no='$chkpi_no' ")->row('pi_id');
           if(!empty($piinfo))
           $data1['pi_id']=$piinfo;           
           $data1['po_qty']=$po_qty[$i];
           $data1['quantity']=$quantity[$i];
           $data1['unit_price']=$unit_price[$i];
           $data1['product_code']=$product_code[$i];
           $data1['amount']=$amount[$i];
           $data1['department_id']=$this->input->post('for_department_id');
           $query=$this->db->insert('purchase_detail',$data1);
           $this->look_up_model->storecrud("ADD",$value,$quantity[$i]);
           /////////////////Stock Master Data//////////////////////
            $datas=array();
            $datas['TRX_TYPE']="GRN";
            $datas['department_id']=$this->input->post('for_department_id');
            $datas['product_id']=$value;
            $datas['INDATE']=date('Y-m-d');
            $datas['ITEM_CODE']=$product_code[$i];
            $datas['FIFO_CODE']=$data1['FIFO_CODE'];
            $datas['LOCATION']="BDWH";
            $datas['CRRNCY']=$this->input->post('currency');
            $datas['EXCH_RATE']=$this->input->post('cnc_rate_in_hkd');         
            $datas['QUANTITY']=$quantity[$i];
            $datas['UPRICE']=$unit_price[$i];
            $datas['TOTALAMT']=$quantity[$i]*$unit_price[$i];
            $datas['TOTALAMT_T']=$quantity[$i]*$unit_price[$i];
            $datas['TOTALPRICE']=$quantity[$i]*$unit_price[$i];
            $datas['receive_id']=$purchase_id;
            $datas['supplier_id']=$this->input->post('supplier_id');
            $datas['REF_CODE']=$this->input->post('reference_no');
            $datas['CRT_USER']=$this->session->userdata('user_name');
            $datas['CRT_DATE']=date('Y-m-d');
            $datas['user_id']=$this->session->userdata('user_id');
            $this->db->insert('stock_master_detail',$datas);
            ////////////////////////////////////////
            $data2=array();
            $data2['last_receive_date']=date('Y-m-d');
            $this->db->WHERE('product_id',$value);
            $this->db->UPDATE('product_info',$data2);
             $i++;
           }
        return $query;
    }
  
  function delete($purchase_id) {
    $oldresult=$this->db->query("SELECT pm.*,sd.*
        FROM purchase_detail sd,purchase_master pm 
        WHERE sd.purchase_id=pm.purchase_id AND sd.purchase_id=$purchase_id   
        ORDER BY sd.product_id ASC")->result();
    foreach ($oldresult as $row1){
      $this->look_up_model->storecrud("MINUS",$row1->product_id,$row1->quantity);
      $datas=array();
      $datas['TRX_TYPE']="RTN";
      $datas['department_id']=$row1->for_department_id;
      $datas['product_id']=$row1->product_id;
      $datas['INDATE']=date('Y-m-d');
      $datas['ITEM_CODE']=$row1->product_code;
      $datas['FIFO_CODE']=$row1->FIFO_CODE;
      $datas['LOCATION']="BDWH";
      $datas['CRRNCY']=$row1->currency;
      $datas['EXCH_RATE']=$row1->cnc_rate_in_hkd;        
      $datas['QUANTITY']=-$row1->quantity;
      $datas['UPRICE']=$row1->unit_price;
      $datas['TOTALAMT']=-$row1->amount;
      $datas['TOTALAMT_T']=$row1->amount;
      $datas['TOTALPRICE']=$row1->amount;
      $datas['receive_id']=$row1->purchase_id;
      $datas['REF_CODE']=$row1->reference_no;
      $datas['CRT_USER']=$this->session->userdata('user_name');
      $datas['CRT_DATE']=date('Y-m-d');
      $datas['user_id']=$this->session->userdata('user_id');
      $this->db->insert('stock_master_detail',$datas);
    }
    $this->db->WHERE('purchase_id',$purchase_id);
    $query=$this->db->update('purchase_detail',array('status'=>5));
    $this->db->WHERE('purchase_id',$purchase_id);
    $query=$this->db->update('purchase_master',array('status'=>5));
    return $query;
  }
  public function getDetails($purchase_id=''){
   $result=$this->db->query("SELECT pud.*,p.*,c.category_name,u.unit_name
        FROM purchase_detail pud
        INNER JOIN product_info p ON(pud.product_id=p.product_id)
        INNER JOIN category_info c ON(p.category_id=c.category_id)
        INNER JOIN product_unit u ON(p.unit_id=u.unit_id)
        WHERE pud.purchase_id=$purchase_id AND pud.status!=5
        ORDER BY p.product_name ASC")->result();
   return $result;
  }
  function submit($purchase_id) {
    $this->db->WHERE('purchase_id',$purchase_id);
    $query=$this->db->Update('purchase_master',array('status'=>2));
    return $query;
 }
 
    
  
}
