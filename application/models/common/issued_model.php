<?php
class Issued_model extends CI_Model {
  public function get_count(){
    $condition=' ';
    if($_GET){
      if($this->input->get('employee_name')!=''){
        $employee_name=$this->input->get('employee_name');
        $condition=$condition."  AND (sm.employee_id LIKE '%$employee_name%') ";
      }
      if($this->input->get('location_id')!=''){
        $location_id=$this->input->get('location_id');
        $condition=$condition."  AND sm.location_id='$location_id' ";
      }
      if($this->input->get('issue_id')!=''){
        $issue_id=$this->input->get('issue_id');
        $condition=$condition."  AND sm.issue_id='$issue_id' ";
      }
      if($this->input->get('from_date')!=''&&$this->input->get('to_date') !=' '){
        $from_date=$this->input->get('from_date');
        $to_date=$this->input->get('to_date');
        $condition.=" AND sm.issue_date BETWEEN '$from_date' AND '$to_date'";
      }
     }
   $department_id=$this->session->userdata('department_id');
      $data=$this->db->query("SELECT count(sm.issue_id) as counts
          FROM  store_issue_master sm 
          WHERE sm.department_id=$department_id 
          AND sm.medical_yes=2 $condition")->row('counts');
      return $data;
    }
  function lists($limit,$start) {
    $condition=' ';
    if($_GET){
      if($this->input->get('employee_name')!=''){
        $employee_name=$this->input->get('employee_name');
        $condition=$condition."  AND (sm.employee_id LIKE '%$employee_name%') ";
      }
      if($this->input->get('location_id')!=''){
        $location_id=$this->input->get('location_id');
        $condition=$condition."  AND sm.location_id='$location_id' ";
      }
      if($this->input->get('issue_id')!=''){
        $issue_id=$this->input->get('issue_id');
        $condition=$condition."  AND sm.issue_id='$issue_id' ";
      }
      if($this->input->get('from_date')!=''&&$this->input->get('to_date') !=' '){
        $from_date=$this->input->get('from_date');
        $to_date=$this->input->get('to_date');
        $condition.=" AND sm.issue_date BETWEEN '$from_date' AND '$to_date'";
      }
     }
     $department_id=$this->session->userdata('department_id');
    $result=$this->db->query("SELECT sm.*,d.department_name,
          u.user_name,sm.employee_id as  employee_cardno,l.location_name,
          'View' as totalquantity
          FROM  store_issue_master sm 
          LEFT JOIN department_info d ON(sm.take_department_id=d.department_id)
          LEFT JOIN location_info l ON(sm.location_id=l.location_id)
          LEFT JOIN user u ON(u.id=sm.user_id) 
          WHERE sm.department_id=$department_id 
          AND sm.medical_yes=2 $condition 
          ORDER BY sm.issue_id DESC 
         LIMIT $start,$limit")->result();
      return $result;
    }


    function get_info($issue_id){
        $department_id=$this->session->userdata('department_id');
        $result=$this->db->query("SELECT sm.*,d.department_name,d2.department_name as from_department_name,
          m.employee_name,u.user_name,l.location_name,
          pd.product_detail_id,pd.asset_encoding,u1.user_name as received_by_name,
          (SELECT SUM(sd.quantity) FROM item_issue_detail sd 
          WHERE sm.issue_id=sd.issue_id) as totalquantity
          FROM  store_issue_master sm 
          LEFT JOIN department_info d ON(sm.take_department_id=d.department_id)
          LEFT JOIN department_info d2 ON(sm.department_id=d2.department_id)
          LEFT JOIN employee_idcard_info m ON(sm.employee_id=m.employee_cardno)
          LEFT JOIN location_info l ON(sm.location_id=l.location_id)
          LEFT JOIN user u ON(u.id=sm.user_id) 
          LEFT JOIN user u1 ON(u1.id=sm.received_by) 
          LEFT JOIN product_detail_info pd ON(sm.product_detail_id=pd.product_detail_id)
          WHERE sm.issue_id=$issue_id")->row();
        return $result;
    }
     public function getDetails($issue_id=''){
   $result=$this->db->query("SELECT sd.*,p.*,
        sd.unit_price,sd.currency,
        c.category_name,u.unit_name,m.mtype_name,
        (SELECT SUM(QUANTITY) as main_stock FROM stock_master_detail sm 
        WHERE sm.product_id=sd.product_id AND sd.FIFO_CODE=sm.FIFO_CODE) as main_stock
        FROM item_issue_detail sd
        INNER JOIN product_info p ON(sd.product_id=p.product_id)
        INNER JOIN category_info c ON(p.category_id=c.category_id)
        INNER JOIN product_unit u ON(p.unit_id=u.unit_id)
        LEFT JOIN material_info m ON(p.mtype_id=m.mtype_id)
        WHERE sd.issue_id=$issue_id 
        ORDER BY p.product_name ASC")->result();
   return $result;
  }
   
  function save($issue_id) {
    $department_id=$this->session->userdata('department_id');
    $data=array();
    $data['issue_type']=$this->input->post('issue_type');
    if($data['issue_type']==1){
      $data['take_department_id']=$this->input->post('take_department_id');
      $data['location_id']=$this->input->post('location_id');
    }elseif($data['issue_type']==2){
      $data['take_department_id']=$this->input->post('take_department_id');
      $data['employee_id']=$this->input->post('employee_id');
      $data['location_id']=$this->input->post('location_id');
    }else{
      $data['location_id']=$this->input->post('location_id');
    }
    if($this->input->post('product_detail_id')!=''){
      $data['product_detail_id']=$this->input->post('product_detail_id');
    }
    $data['issue_purpose']=$this->input->post('issue_purpose');
    $data['issue_for']=$this->input->post('issue_for');
    $data['requisition_no']=$this->input->post('requisition_no');
    $data['file_no']=$this->input->post('file_no');
    $data['issue_date']=alterDateFormat($this->input->post('issue_date'));
    $data['user_id']=$this->session->userdata('user_id');
    $data['department_id']=$department_id;
    
    $product_id=$this->input->post('product_id');
    $quantity=$this->input->post('quantity');
    //$unit_price=$this->input->post('unit_price');
    //$sub_total=$this->input->post('sub_total');
    $product_code=$this->input->post('product_code');
    $FIFO_CODE=$this->input->post('FIFO_CODE');
    $product_name=$this->input->post('product_name');
    $specification=$this->input->post('specification');
    $cnc_rate_in_hkd=$this->input->post('cnc_rate_in_hkd');
    ////////////////////////////////
    $i=0;
    $error='';
    if($issue_id==FALSE){
      $issue_ref_no=strtoupper(substr(md5('VLMBD234'.mt_rand(0,100)),0,2));;
      $issue_ref_no =date('ymd').str_pad($issue_ref_no + 1, 6, '0', STR_PAD_LEFT);
      $data['issue_ref_no']=$issue_ref_no;
      $query=$this->db->insert('store_issue_master',$data);
      $issue_id=$this->db->insert_id();
    }else{
      $oldresult=$this->db->query("SELECT sd.*
        FROM item_issue_detail sd 
        WHERE sd.issue_id=$issue_id 
        ORDER BY sd.product_id ASC")->result();
      foreach ($oldresult as $row1){
        $this->look_up_model->storecrud("ADD",$row1->product_id,$row1->quantity);
        $this->look_up_model->valuecrud("ADD",$row1->product_id,$row1->amount_hkd);
      }
      $this->db->WHERE('issue_id',$issue_id);
      $query=$this->db->UPDATE('store_issue_master',$data);
      $this->db->WHERE('issue_id',$issue_id);
      $this->db->delete('item_issue_detail');
      $this->db->WHERE('issue_id',$issue_id);
      $this->db->WHERE('TRX_TYPE','ISSUE');
      $this->db->delete('stock_master_detail');
    }
    $total_amount_hkd=0;
    foreach($product_id as $value) {
      $fifocode=$FIFO_CODE[$i];
      // $FifoStock=$this->db->query("SELECT IFNULL(SUM(QUANTITY),0) as main_stock 
      //   FROM stock_master_detail 
      //   WHERE FIFO_CODE='$fifocode' 
      //   AND department_id=$department_id ")->row();
      // if($FifoStock->main_stock>=$quantity[$i]){


        $fifoinfo=$this->db->query("SELECT * FROM stock_master_detail 
            WHERE FIFO_CODE='$fifocode' 
            AND (TRX_TYPE='GRN' 
              OR TRX_TYPE='OPENING' 
              OR TRX_TYPE='RETURN') ")->row();
  
        $currency[$i]=$fifoinfo->CRRNCY;
        $unit_price[$i]=$fifoinfo->UPRICE;
        $sub_total[$i]=$fifoinfo->UPRICE*$quantity[$i];

        $hkdrate=getHKDRate($currency[$i]);
        $data1['product_id']=$value;
        $data1['product_code']=$product_code[$i];
        $data1['product_name']=$product_name[$i];
        $data1['specification']=$specification[$i];
        $data1['issue_id']=$issue_id;
        $data1['quantity']=$quantity[$i];
        $data1['unit_price']=$unit_price[$i];
        $data1['sub_total']=$sub_total[$i];
        $data1['amount_hkd']=$sub_total[$i]*$hkdrate;
        $data1['FIFO_CODE']=$FIFO_CODE[$i];
        $data1['currency']=$currency[$i];
        $data1['cnc_rate_in_hkd']=$cnc_rate_in_hkd[$i];
        $data1['department_id']=$this->session->userdata('department_id');
        $data1['date']=alterDateFormat($this->input->post('issue_date'));
        $data1['user_id']=$this->session->userdata('user_id');
        $data1['file_no']=$this->input->post('file_no');
        $query=$this->db->insert('item_issue_detail',$data1);
        ////////////////////
        $total_amount_hkd=$total_amount_hkd+$data1['amount_hkd'];
        ///////////////////stock////////////////////////////
        $this->look_up_model->storecrud("MINUS",$value,$quantity[$i]);
        $this->look_up_model->valuecrud("MINUS",$value,$data1['amount_hkd']);
        /////////////////Stock Master Data//////////////////////
        $datas=array();
        $datas['TRX_TYPE']="ISSUE";
        if($data['issue_type']!=3){
          $datas['received_department_id']=$this->input->post('take_department_id');
        }
        $datas['department_id']=$this->session->userdata('department_id');
        $datas['product_id']=$value;
        $datas['INDATE']= alterDateFormat($this->input->post('issue_date'));
        $datas['ITEM_CODE']=$product_code[$i];
        $datas['specification']=$specification[$i];
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
        $datas['issue_id']=$issue_id;
        $datas['file_no']=$this->input->post('file_no');
        $datas['REF_CODE']=$this->db->query("SELECT issue_ref_no FROM store_issue_master 
          WHERE issue_id=$issue_id ")->row('issue_ref_no');
        $datas['CRT_USER']=$this->session->userdata('user_name');
        $datas['CRT_DATE']=date('Y-m-d H:i:s');
        $datas['user_id']=$this->session->userdata('user_id');
        $datas['notes']=$this->input->post('issue_purpose');
        $this->db->insert('stock_master_detail',$datas);
         ////////////////////////////////////////
      // }else{
      //   $error.="$fifocode ";
      // }
      $i++;
    }
      $datahkd['total_amount_hkd']=$total_amount_hkd;
      $this->db->WHERE('issue_id',$issue_id);
      $query=$this->db->UPDATE('store_issue_master',$datahkd);
      // if($error!=''){
      //   $this->session->set_userdata('exceptionw',"This FIFO Don't have Stock $error");
      // }
    
    return $query;
  }

  function delete($issue_id) {
      $oldresult=$this->db->query("SELECT sd.*
        FROM item_issue_detail sd 
        WHERE sd.issue_id=$issue_id ORDER BY sd.product_id ASC")->result();
      foreach ($oldresult as $row1){
         $this->look_up_model->storecrud("ADD",$row1->product_id,$row1->quantity);
         $this->look_up_model->valuecrud("ADD",$row1->product_id,$row1->amount_hkd);
      }
      $this->db->WHERE('issue_id',$issue_id);
      $query=$this->db->delete('item_issue_detail');
      $this->db->WHERE('issue_id',$issue_id);
      $query=$this->db->delete('store_issue_master');
      $this->db->WHERE('issue_id',$issue_id);
      $this->db->WHERE('TRX_TYPE','ISSUE');
      $this->db->delete('stock_master_detail');
      return $query;
  }

 
  

}
