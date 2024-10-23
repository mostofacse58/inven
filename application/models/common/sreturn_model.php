<?php
class Sreturn_model extends CI_Model {
  public function get_count(){
    $condition=' ';
    if($_GET){
 
      if($this->input->get('suppler_id')!=''){
        $suppler_id=$this->input->get('suppler_id');
        $condition=$condition."  AND sm.suppler_id='$suppler_id' ";
      }
      if($this->input->get('product_code')!=''){
        $product_code=$this->input->get('product_code');
        $condition=$condition."  AND (pmd.product_code LIKE '%$product_code%' ) ";
      }
      if($this->input->get('from_date')!=''&&$this->input->get('to_date') !=' '){
        $from_date=$this->input->get('from_date');
        $to_date=$this->input->get('to_date');
        $condition.=" AND sm.sreturn_date BETWEEN '$from_date' AND '$to_date'";
      }
     }
   $department_id=$this->session->userdata('department_id');
      $data=$this->db->query("SELECT count(sm.sreturn_id) as counts
          FROM  sreturn_master sm 
          WHERE sm.department_id=$department_id 
           $condition")->row('counts');
      //$data = count($query->result());
      return $data;
    }
  function lists($limit,$start) {
    $condition=' ';
    if($_GET){

      if($this->input->get('suppler_id')!=''){
        $suppler_id=$this->input->get('suppler_id');
        $condition=$condition."  AND sm.suppler_id='$suppler_id' ";
      }
      if($this->input->get('product_code')!=''){
        $product_code=$this->input->get('product_code');
        $condition=$condition."  AND (pmd.product_code LIKE '%$product_code%' ) ";
      }
  
   
      if($this->input->get('from_date')!=''&&$this->input->get('to_date') !=' '){
        $from_date=$this->input->get('from_date');
        $to_date=$this->input->get('to_date');
        $condition.=" AND sm.sreturn_date BETWEEN '$from_date' AND '$to_date'";
      }
     }
     $department_id=$this->session->userdata('department_id');
    $result=$this->db->query("SELECT sm.*,d.department_name,
          u.user_name,
          'View' as totalquantity
          FROM  sreturn_master sm 
          LEFT JOIN department_info d ON(sm.department_id=d.department_id)
          LEFT JOIN user u ON(u.id=sm.user_id) 
          WHERE sm.department_id=$department_id 
          $condition 
          ORDER BY sm.sreturn_id DESC 
         LIMIT $start,$limit")->result();
      return $result;
    }


    function get_info($sreturn_id){
        $department_id=$this->session->userdata('department_id');
        $result=$this->db->query("SELECT sm.*,d.department_name,d2.department_name as from_department_name,
          m.employee_name,u.user_name,l.location_name,
          pd.product_detail_id,pd.asset_encoding,u1.user_name as received_by_name,
          (SELECT SUM(sd.quantity) FROM item_sreturn_detail sd 
          WHERE sm.sreturn_id=sd.sreturn_id) as totalquantity
          FROM  sreturn_master sm 
          LEFT JOIN department_info d ON(sm.department_id=d.department_id)
          LEFT JOIN department_info d2 ON(sm.department_id=d2.department_id)
          LEFT JOIN employee_idcard_info m ON(sm.employee_id=m.employee_cardno)
          LEFT JOIN location_info l ON(sm.location_id=l.location_id)
          LEFT JOIN user u ON(u.id=sm.user_id) 
          LEFT JOIN user u1 ON(u1.id=sm.received_by) 
          LEFT JOIN product_detail_info pd ON(sm.product_detail_id=pd.product_detail_id)
          WHERE sm.sreturn_id=$sreturn_id")->row();
        return $result;
    }
     public function getDetails($sreturn_id=''){
   $result=$this->db->query("SELECT sd.*,p.*,sd.unit_price,
        c.category_name,u.unit_name,m.mtype_name,
        (SELECT SUM(QUANTITY) as main_stock FROM stock_master_detail sm 
        WHERE sm.product_id=sd.product_id AND sd.FIFO_CODE=sm.FIFO_CODE) as main_stock
        FROM item_sreturn_detail sd
        INNER JOIN product_info p ON(sd.product_id=p.product_id)
        INNER JOIN category_info c ON(p.category_id=c.category_id)
        INNER JOIN product_unit u ON(p.unit_id=u.unit_id)
        LEFT JOIN material_info m ON(p.mtype_id=m.mtype_id)
        WHERE sd.sreturn_id=$sreturn_id 
        ORDER BY p.product_name ASC")->result();
   return $result;
  }

   
function save($sreturn_id) {
    $department_id=$this->session->userdata('department_id');
    $data=array();
    $data['sreturn_note']=$this->input->post('sreturn_note');
    $data['po_number']=$this->input->post('po_number');
    $data['sreturn_date']=alterDateFormat($this->input->post('sreturn_date'));
    $data['user_id']=$this->session->userdata('user_id');
    $data['department_id']=$department_id;
    
    $product_id=$this->input->post('product_id');
    $quantity=$this->input->post('quantity');
    $product_code=$this->input->post('product_code');
    $FIFO_CODE=$this->input->post('FIFO_CODE');
    $cnc_rate_in_hkd=$this->input->post('cnc_rate_in_hkd');
    ////////////////////////////////
    $i=0;
    if($sreturn_id==FALSE){
      $sreturn_ref_no=strtoupper(substr(md5('VLMBD234'.mt_rand(0,100)),0,2));;
      $sreturn_ref_no =date('ymd').str_pad($sreturn_ref_no + 1, 6, '0', STR_PAD_LEFT);
      $data['sreturn_count']=$sreturn_ref_no+1;
      $data['sreturn_ref_no']=$sreturn_ref_no;
      $query=$this->db->insert('sreturn_master',$data);
      $sreturn_id=$this->db->insert_id();
    }else{
      $oldresult=$this->db->query("SELECT sd.*
        FROM item_sreturn_detail sd 
        WHERE sd.sreturn_id=$sreturn_id 
        ORDER BY sd.product_id ASC")->result();
      foreach ($oldresult as $row1){
        $this->look_up_model->storecrud("ADD",$row1->product_id,$row1->quantity);
        $this->look_up_model->valuecrud("ADD",$row1->product_id,$row1->amount_hkd);
      }
      $this->db->WHERE('sreturn_id',$sreturn_id);
      $query=$this->db->UPDATE('sreturn_master',$data);
      $this->db->WHERE('sreturn_id',$sreturn_id);
      $this->db->delete('item_sreturn_detail');
      $this->db->WHERE('sreturn_id',$sreturn_id);
      $this->db->WHERE('TRX_TYPE','ISSUE');
      $this->db->delete('stock_master_detail');

    }
    $total_amount_hkd=0;
    foreach($product_id as $value) {
      $fifocode=$FIFO_CODE[$i];
      $fifoinfo=$this->db->query("SELECT * FROM stock_master_detail 
          WHERE FIFO_CODE='$fifocode' 
          AND (TRX_TYPE='GRN' OR TRX_TYPE='OPENING' OR TRX_TYPE='RETURN') ")->row();

      $currency[$i]=$fifoinfo->CRRNCY;
      $unit_price[$i]=$fifoinfo->UPRICE;
      $sub_total[$i]=$fifoinfo->UPRICE*$quantity[$i];

      $hkdrate=getHKDRate($currency[$i]);
      //print_r($fifoinfo); echo "<br>"; echo $hkdrate; exit();
      $data1['product_id']=$value;
      $data1['product_code']=$product_code[$i];
      $data1['sreturn_id']=$sreturn_id;
      $data1['quantity']=$quantity[$i];
      $data1['unit_price']=$unit_price[$i];
      $data1['sub_total']=$sub_total[$i];
      $data1['amount_hkd']=$sub_total[$i]*$hkdrate;
      $data1['FIFO_CODE']=$FIFO_CODE[$i];
      $data1['currency']=$currency[$i];
      $data1['cnc_rate_in_hkd']=$cnc_rate_in_hkd[$i];
      $data1['department_id']=$this->session->userdata('department_id');
      $data1['date']=alterDateFormat($this->input->post('sreturn_date'));
      $data1['user_id']=$this->session->userdata('user_id');
      $data1['file_no']=$this->input->post('file_no');
      $query=$this->db->insert('item_sreturn_detail',$data1);
      ////////////////////
      $total_amount_hkd=$total_amount_hkd+$data1['amount_hkd'];
      ///////////////////stock////////////////////////////
      $this->look_up_model->storecrud("MINUS",$value,$quantity[$i]);
      $this->look_up_model->valuecrud("MINUS",$value,$data1['amount_hkd']);
      /////////////////Stock Master Data//////////////////////
        $datas=array();
        $datas['TRX_TYPE']="ISSUE";
        if($data['sreturn_type']!=3){
          $datas['received_department_id']=$this->input->post('department_id');
        }
        $datas['department_id']=$this->session->userdata('department_id');
        $datas['product_id']=$value;
        $datas['INDATE']= alterDateFormat($this->input->post('sreturn_date'));
        $datas['ITEM_CODE']=$product_code[$i];
        $datas['FIFO_CODE']=$data1['FIFO_CODE'];
        $datas['LOCATION']=$this->session->userdata('dept_shortcode');
        $datas['LOCATION1']="BP01";
        $datas['CRRNCY']=$currency[$i];
        $datas['EXCH_RATE']=$cnc_rate_in_hkd[$i];        
        $datas['QUANTITY']=-$quantity[$i];
        $datas['UPRICE']=$unit_price[$i];
        $datas['TOTALAMT']=-$sub_total[$i];
        $datas['TOTALAMT_HKD']=-($sub_total[$i]*$hkdrate);
        $datas['TOTALPRICE']=$quantity[$i]*$unit_price[$i];
        $datas['sreturn_id']=$sreturn_id;
        $datas['file_no']=$this->input->post('file_no');
        $datas['REF_CODE']=$this->db->query("SELECT sreturn_ref_no FROM sreturn_master 
          WHERE sreturn_id=$sreturn_id ")->row('sreturn_ref_no');
        $datas['CRT_USER']=$this->session->userdata('user_name');
        $datas['CRT_DATE']=date('Y-m-d H:i:s');
        $datas['user_id']=$this->session->userdata('user_id');
        $datas['notes']=$this->input->post('sreturn_note');
        $this->db->insert('stock_master_detail',$datas);
         ////////////////////////////////////////
      $i++;
    }
      $datahkd['total_amount_hkd']=$total_amount_hkd;
      $this->db->WHERE('sreturn_id',$sreturn_id);
      $query=$this->db->UPDATE('sreturn_master',$datahkd);
    
    return $query;
  }

  function delete($sreturn_id) {
      $oldresult=$this->db->query("SELECT sd.*
        FROM item_sreturn_detail sd 
        WHERE sd.sreturn_id=$sreturn_id ORDER BY sd.product_id ASC")->result();
      foreach ($oldresult as $row1){
         $this->look_up_model->storecrud("ADD",$row1->product_id,$row1->quantity);
         $this->look_up_model->valuecrud("ADD",$row1->product_id,$row1->amount_hkd);
      }
      $this->db->WHERE('sreturn_id',$sreturn_id);
      $query=$this->db->delete('item_sreturn_detail');
      $this->db->WHERE('sreturn_id',$sreturn_id);
      $query=$this->db->delete('sreturn_master');
      $this->db->WHERE('sreturn_id',$sreturn_id);
      $this->db->WHERE('TRX_TYPE','ISSUE');
      $this->db->delete('stock_master_detail');
      return $query;
  }

 
  

}
