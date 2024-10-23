<?php
class Adjustment_model extends CI_Model {
  public function get_count(){
    $condition=' ';
    if($_GET){
      if($this->input->get('product_code')!=''){
        $product_code=$this->input->get('product_code');
        $condition=$condition."  AND (sm.ITEM_CODE LIKE '%$product_code%') ";
      }
  
      if($this->input->get('from_date')!=''&&$this->input->get('to_date') !=' '){
        $from_date=$this->input->get('from_date');
        $to_date=$this->input->get('to_date');
        $condition.=" AND sm.INDATE BETWEEN '$from_date' AND '$to_date'";
      }
     }
   $department_id=$this->session->userdata('department_id');
    $data=$this->db->query("SELECT count(sm.adjustment_id) as counts
          FROM  stock_adjustment_details sm 
          WHERE sm.department_id=$department_id 
          $condition")->row('counts');
      return $data;
  }

  function lists($limit,$start) {
    $condition=' ';
    if($_GET){
      if($this->input->get('product_code')!=''){
        $product_code=$this->input->get('product_code');
        $condition=$condition."  AND (sm.ITEM_CODE LIKE '%$product_code%') ";
      }
     
      if($this->input->get('from_date')!=''&&$this->input->get('to_date') !=' '){
        $from_date=$this->input->get('from_date');
        $to_date=$this->input->get('to_date');
        $condition.=" AND sm.INDATE BETWEEN '$from_date' AND '$to_date'";
      }
     }
     $department_id=$this->session->userdata('department_id');
    $result=$this->db->query("SELECT sm.*,pd.product_name,
          u.user_name,d.department_name
          FROM  stock_adjustment_details sm 
          LEFT JOIN product_info pd ON(sm.product_id=pd.product_id)
          LEFT JOIN user u ON(u.id=sm.user_id) 
          INNER JOIN department_info d ON(sm.department_id=d.department_id)
          WHERE 1 
          $condition 
          ORDER BY sm.adjustment_id DESC 
         LIMIT $start,$limit")->result();
      return $result;
    }


    function get_info($adjustment_id){
        $department_id=$this->session->userdata('department_id');
        $result=$this->db->query("SELECT sm.*,u.user_name,
          pd.product_name
          FROM  stock_adjustment_details sm 
          LEFT JOIN department_info d ON(sm.from_department_id=d.department_id)
          LEFT JOIN product_info pd ON(sm.product_id=pd.product_id)
          WHERE sm.adjustment_id=$adjustment_id")->row();
        return $result;
    }
 
   
function save($adjustment_id) {
    $department_id=$this->session->userdata('department_id');
    $data=array();
    $data['department_id']=$this->input->post('department_id');
    $data['TRX_TYPE']="ADJUSTMENT";
    $data['reason_note']=$this->input->post('reason_note');
    $data['INDATE']=alterDateFormat($this->input->post('INDATE'));
    $data['user_id']=$this->session->userdata('user_id');
    $data['product_id']=$this->input->post('product_id');
    $data['unit_name']=$this->input->post('unit_name');
    $data['ITEM_CODE']=$this->input->post('ITEM_CODE');
    //$adjustment_no=strtoupper(substr(md5('VLMBD234'.mt_rand(0,100)),0,2));
    $data['adjustment_no'] ='ADJ'.date('ymdHi');

    $QUANTITY=$this->input->post('QUANTITY');
    $CRRNCY=$this->input->post('CRRNCY');
    $LOCATION=$this->input->post('LOCATION');
    $UPRICE=$this->input->post('UPRICE');
    $FIFO_CODE=$this->input->post('FIFO_CODE');
    //////////////////////////////////////
    $product_id=$this->input->post('product_id');
    $i=0;
    foreach ($FIFO_CODE as $value) {
  
      if($QUANTITY[$i]!=0){
      $hkdrate=getHKDRate($CRRNCY[$i]);
      $data['FIFO_CODE']=$value;
      $data['LOCATION']=$LOCATION[$i];
      $data['UPRICE']=$UPRICE[$i];
      $data['QUANTITY']=$QUANTITY[$i];
      $data['CRRNCY']=$CRRNCY[$i];
      $data['TOTALAMT']=$QUANTITY[$i]*$UPRICE[$i];
      $data['TOTALAMT_HKD']=$QUANTITY[$i]*$UPRICE[$i]*$hkdrate;
     // print_r($data); exit;
      $query=$this->db->insert('stock_adjustment_details',$data);
      $adjustment_id=$this->db->insert_id();
      //////////////////////
      $this->look_up_model->storecrud("ADD",$product_id,$QUANTITY[$i]);
       /////////////////Stock Master Data//////////////////////
          $datas=array();
          $datas['TRX_TYPE']="ADJUSTMENT";
          $datas['department_id']=$this->input->post('department_id');
          $datas['product_id']=$product_id;
          $datas['INDATE']=alterDateFormat($this->input->post('INDATE'));
          $datas['ITEM_CODE']=$data['ITEM_CODE'];
          $datas['FIFO_CODE']=$data['FIFO_CODE'];
          $datas['LOCATION']=$data['LOCATION'];
          $datas['CRRNCY']=$data['CRRNCY'];; 
          $datas['EXCH_RATE']=$hkdrate;        
          $datas['QUANTITY']=$data['QUANTITY'];
          $datas['UPRICE']=$data['UPRICE'];
          $datas['TOTALAMT']=($data['QUANTITY']*$data['UPRICE']);
          $datas['TOTALAMT_HKD']=($data['QUANTITY']*$data['UPRICE']*$hkdrate);
          $datas['receive_id']=$adjustment_id;
          $datas['REF_CODE']=$data['adjustment_no'];
          $datas['CRT_USER']=$this->session->userdata('user_name');
          $datas['CRT_DATE']=date('Y-m-d');
          $datas['user_id']=$this->session->userdata('user_id');
          $datas['notes']=$this->input->post('reason_note');
          $query=$this->db->insert('stock_master_detail',$datas);
      
    }
    $i++;
    }
   //print_r($datas); exit;
    return $query;
  }

  function delete($adjustment_id) {
      $info=$this->db->query("SELECT *
        FROM stock_adjustment_details  
        WHERE adjustment_id=$adjustment_id")->row();
      $adjustment_no=$info->adjustment_no;
      $this->look_up_model->storecrud("MINUS",$info->product_id,$info->QUANTITY);
      $this->db->WHERE('adjustment_id',$adjustment_id);
      $query=$this->db->delete('stock_adjustment_details');


      $this->db->WHERE('REF_CODE',$adjustment_no);
      $this->db->WHERE('TRX_TYPE','ADJUSTMENT');
      $this->db->delete('stock_master_detail');
      return $query;
  }

  

}
