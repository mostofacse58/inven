<?php
class Usingspares_model extends CI_Model {
   public function get_count(){
    $condition=' ';
    if($_GET){
      if($this->input->get('using_ref_no')!=''){
        $using_ref_no=$this->input->get('using_ref_no');
        $condition=$condition."  AND (sm.using_ref_no LIKE '%$using_ref_no%') ";
      }
      if($this->input->get('line_id')!=''){
        $line_id=$this->input->get('line_id');
        $condition=$condition."  AND sm.line_id=$line_id ";
      }
      if($this->input->get('from_date')!=''&&$this->input->get('to_date') !=' '){
        $from_date=$this->input->get('from_date');
        $to_date=$this->input->get('to_date');
        $condition.=" AND sm.use_date BETWEEN '$from_date' AND '$to_date'";
      }
     }
    $department_id=$this->session->userdata('department_id');
      $data=$this->db->query("SELECT count(*) as counts
        FROM  spares_use_master sm 
        LEFT JOIN user u ON(u.id=sm.user_id) 
        WHERE sm.department_id=12 AND sm.use_date>='2020-01-01' 
        $condition
        ORDER BY sm.spares_use_id DESC")->row('counts');
      return $data;
    }

    function lists($limit,$start) {
      $condition=' ';
      if($_GET){
        if($this->input->get('using_ref_no')!=''){
          $using_ref_no=$this->input->get('using_ref_no');
          $condition=$condition."  AND (sm.using_ref_no LIKE '%$using_ref_no%') ";
        }
        if($this->input->get('line_id')!=''){
          $line_id=$this->input->get('line_id');
          $condition=$condition."  AND sm.line_id=$line_id ";
        }
        if($this->input->get('from_date')!=''&&$this->input->get('to_date') !=' '){
          $from_date=$this->input->get('from_date');
          $to_date=$this->input->get('to_date');
          $condition.=" AND sm.use_date BETWEEN '$from_date' AND '$to_date'";
        }
       }
      $department_id=$this->session->userdata('department_id');
      $result=$this->db->query("SELECT sm.*,m.me_name,fl.line_no,u.user_name
        FROM  spares_use_master sm 
        LEFT JOIN me_info m ON(sm.me_id=m.me_id)
        LEFT JOIN floorline_info fl ON(sm.line_id=fl.line_id)
        LEFT JOIN user u ON(u.id=sm.user_id) 
        WHERE sm.department_id=12 AND sm.use_date>='2020-01-01' $condition
        ORDER BY sm.spares_use_id DESC 
        LIMIT $start,$limit")->result();
      return $result;
    }
    function get_info($spares_use_id){
      $result=$this->db->query("SELECT sm.*,p.product_name,p.product_code,
        m.me_name,u.user_name,pd.tpm_serial_code,fl.line_no,
        (SELECT SUM(sd.quantity) FROM spares_use_detail sd WHERE sm.spares_use_id=sd.spares_use_id) as totalquantity
        FROM  spares_use_master sm 
        LEFT JOIN product_detail_info pd ON(sm.asset_encoding=pd.asset_encoding 
        OR sm.asset_encoding=pd.ventura_code OR sm.asset_encoding=pd.tpm_serial_code)
        
        LEFT JOIN product_info p ON(p.product_id=pd.product_id)
        LEFT JOIN me_info m ON(sm.me_id=m.me_id)
        LEFT JOIN floorline_info fl ON(sm.line_id=fl.line_id)
        LEFT JOIN user u ON(u.id=sm.user_id) 
        WHERE sm.department_id=12 and 
         sm.spares_use_id=$spares_use_id")->row();
      return $result;
    }

   
    function save($spares_use_id) {
      $checkstock=1;
        $data=array();
        $data['use_type']=$this->input->post('use_type');
        $data['line_id']=$this->input->post('line_id');
        $data['TRX_TYPE']=$this->input->post('TRX_TYPE');
       //  if($this->input->post('use_type')==1){
       //  $data['product_detail_id']=$this->input->post('product_detail_id');
       // }else{
        $data['use_purpose']=$this->input->post('use_purpose');
        $data['asset_encoding']=$this->input->post('asset_encoding');
        $data['take_department_id']=$this->input->post('take_department_id');
        // }
        $data['me_id']=$this->input->post('me_id');
        $data['other_id']=$this->input->post('other_id');
        $data['requisition_no']=$this->input->post('requisition_no');
        $data['use_date']=alterDateFormat($this->input->post('use_date'));
        $data['user_id']=$this->session->userdata('user_id');
        $data['department_id']=12;
        $product_id=$this->input->post('product_id');
        $product_code=$this->input->post('product_code');
        $quantity=$this->input->post('quantity');
        //$unit_price=$this->input->post('unit_price');
        $FIFO_CODE=$this->input->post('FIFO_CODE');
        //$currency=$this->input->post('currency');
        $specification=$this->input->post('specification');
        $cnc_rate_in_hkd=$this->input->post('cnc_rate_in_hkd');
        $i=0;
        if($spares_use_id==FALSE){
          $using_ref_no=$this->db->query("SELECT MAX(spares_use_id) as using_ref_no
             FROM spares_use_master WHERE department_id=12")->row('using_ref_no');
          $using_ref_no ='ME'.str_pad($using_ref_no + 1, 6, '0', STR_PAD_LEFT);
          $data['using_ref_no']=$using_ref_no;
          $query=$this->db->insert('spares_use_master',$data);
          $spares_use_id=$this->db->insert_id();
        }else{
         $oldresult=$this->db->query("SELECT sd.*
          FROM spares_use_detail sd 
          WHERE sd.spares_use_id=$spares_use_id ORDER BY sd.product_id ASC")->result();
          foreach ($oldresult as $row1){
             $this->look_up_model->storecrud("ADD",$row1->product_id,$row1->quantity);
             $this->look_up_model->valuecrud("ADD",$row1->product_id,$row1->amount_hkd);
          }
          $this->db->WHERE('spares_use_id',$spares_use_id);
          $query=$this->db->update('spares_use_master',$data);
          $this->db->WHERE('spares_use_id',$spares_use_id);
          $this->db->delete('spares_use_detail');
          ////////////////////
          $this->db->WHERE('issue_id',$spares_use_id);
          $this->db->WHERE('department_id',12);
          $this->db->delete('stock_master_detail');
        }
        //////////////////////////////
        $total_amount_hkd=0;
        foreach ($product_id as $value) {
          $fifocode=$FIFO_CODE[$i];
          $fifoinfo=$this->db->query("SELECT * FROM stock_master_detail 
              WHERE FIFO_CODE='$fifocode' 
              AND (TRX_TYPE='GRN' OR TRX_TYPE='OPENING' OR TRX_TYPE='RETURN') ")->row();

          $currency[$i]=$fifoinfo->CRRNCY;
          $unit_price[$i]=$fifoinfo->UPRICE;
          //$sub_total[$i]=$fifoinfo->UPRICE*$quantity[$i];

          $hkdrate=getHKDRate($currency[$i]);
           $data1['product_id']=$value;
           $data1['spares_use_id']=$spares_use_id;
           $data1['quantity']=$quantity[$i];
           $data1['FIFO_CODE']=$FIFO_CODE[$i];
           $data1['product_code']=$product_code[$i];
           $data1['specification']=$specification[$i];
           $data1['unit_price']=$unit_price[$i];
           $data1['amount']=$unit_price[$i]*$quantity[$i];
           $data1['amount_hkd']=$unit_price[$i]*$quantity[$i]*$hkdrate;
           $data1['currency']=$currency[$i];
           $data1['cnc_rate_in_hkd']=$cnc_rate_in_hkd[$i];
           $data1['TRX_TYPE']=$data['TRX_TYPE'];
           $data1['date']=alterDateFormat($this->input->post('use_date'));
           $data1['user_id']=$this->session->userdata('user_id');
           $query=$this->db->insert('spares_use_detail',$data1);
           //////////////////////
           $total_amount_hkd=$total_amount_hkd+$data1['amount_hkd'];
           ////////////////////////
           $this->look_up_model->storecrud("MINUS",$value,$quantity[$i]);
           $this->look_up_model->valuecrud("MINUS",$value,$data1['amount_hkd']);
           /////////////////Stock Master Data//////////////////////
          $datas=array();
          $datas['TRX_TYPE']=$data['TRX_TYPE'];
          $datas['received_department_id']=$this->input->post('take_department_id');
          $datas['department_id']=$this->session->userdata('department_id');
          $datas['product_id']=$value;
          $datas['INDATE']=alterDateFormat($this->input->post('use_date'));
          $datas['ITEM_CODE']=$product_code[$i];
          $datas['specification']=$specification[$i];
          $datas['FIFO_CODE']=$data1['FIFO_CODE'];
          $datas['LOCATION']=$this->session->userdata('dept_shortcode');
          $datas['LOCATION1']="BP01";
          $datas['CRRNCY']=$currency[$i];
          $datas['EXCH_RATE']=$cnc_rate_in_hkd[$i];        
          $datas['QUANTITY']=-$quantity[$i];
          $datas['UPRICE']=$unit_price[$i];
          $datas['TOTALAMT']=-($quantity[$i]*$unit_price[$i]);
          $datas['TOTALAMT_HKD']=-($unit_price[$i]*$quantity[$i]*$hkdrate);
          $datas['TOTALAMT_T']=$quantity[$i]*$unit_price[$i];
          $datas['TOTALPRICE']=$quantity[$i]*$unit_price[$i];
          $datas['issue_id']=$spares_use_id;
          $datas['REF_CODE']=$this->db->query("SELECT using_ref_no FROM spares_use_master 
            WHERE spares_use_id=$spares_use_id ")->row('using_ref_no');
          $datas['CRT_USER']=$this->session->userdata('user_name');
          $datas['CRT_DATE']=date('Y-m-d H:i:s');
          $datas['user_id']=$this->session->userdata('user_id');
          $datas['notes']=$this->input->post('use_purpose');
          $this->db->insert('stock_master_detail',$datas);
           ////////////////////////////////////////
             $i++;
          }
          $datahkd['total_amount_hkd']=$total_amount_hkd;
          $this->db->WHERE('spares_use_id',$spares_use_id);
          $query=$this->db->UPDATE('spares_use_master',$datahkd);
        return $query;
    }
  
    function delete($spares_use_id) {
        $oldresult=$this->db->query("SELECT sd.*
            FROM spares_use_detail sd WHERE sd.spares_use_id=$spares_use_id 
            ORDER BY sd.product_id ASC")->result();
        foreach ($oldresult as $row1){
           $this->look_up_model->storecrud("ADD",$row1->product_id,$row1->quantity);
           $this->look_up_model->valuecrud("ADD",$row1->product_id,$row1->amount_hkd);
        }
        $this->db->WHERE('spares_use_id',$spares_use_id);
        $query=$this->db->delete('spares_use_detail');
        $this->db->WHERE('spares_use_id',$spares_use_id);
        $query=$this->db->delete('spares_use_master');
        $this->db->WHERE('issue_id',$spares_use_id);
        $this->db->WHERE('department_id',12);
        $this->db->delete('stock_master_detail');
        return $query;
  }
  public function getDetails($spares_use_id=''){
   $result=$this->db->query("SELECT p.*,sd.*,c.category_name,u.unit_name,m.mtype_name,
        (SELECT SUM(QUANTITY) as main_stock FROM stock_master_detail sm 
        WHERE sm.product_id=sd.product_id 
        AND sd.FIFO_CODE=sm.FIFO_CODE) as main_stock
        FROM spares_use_detail sd
        INNER JOIN product_info p ON(sd.product_id=p.product_id)
        INNER JOIN category_info c ON(p.category_id=c.category_id)
        INNER JOIN product_unit u ON(p.unit_id=u.unit_id)
        LEFT JOIN material_info m ON(p.mtype_id=m.mtype_id)
        WHERE sd.spares_use_id=$spares_use_id 
        ORDER BY p.product_name ASC")->result();
   return $result;
  }

    
  
}
