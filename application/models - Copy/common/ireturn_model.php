<?php
class Ireturn_model extends CI_Model {
  public function get_count(){
    $condition=' ';
    if($_GET){
      if($this->input->get('employee_name')!=''){
        $employee_name=$this->input->get('employee_name');
        $condition=$condition."  AND (sm.employee_id LIKE '%$employee_name%') ";
      }
      if($this->input->get('from_department_id')!=''){
        $from_department_id=$this->input->get('from_department_id');
        $condition=$condition."  AND sm.from_department_id='$from_department_id' ";
      }
      if($this->input->get('from_date')!=''&&$this->input->get('to_date') !=' '){
        $from_date=$this->input->get('from_date');
        $to_date=$this->input->get('to_date');
        $condition.=" AND sm.return_date BETWEEN '$from_date' AND '$to_date'";
      }
     }
   $department_id=$this->session->userdata('department_id');
    $data=$this->db->query("SELECT count(sm.ireturn_id) as counts
          FROM  issue_return_info sm 
          WHERE sm.department_id=$department_id 
          $condition")->row('counts');
      return $data;
    }
  function lists($limit,$start) {
    $condition=' ';
    if($_GET){
      if($this->input->get('employee_name')!=''){
        $employee_name=$this->input->get('employee_name');
        $condition=$condition."  AND (sm.employee_id LIKE '%$employee_name%') ";
      }
      if($this->input->get('from_department_id')!=''){
        $from_department_id=$this->input->get('from_department_id');
        $condition=$condition."  AND sm.from_department_id='$from_department_id' ";
      }
      if($this->input->get('from_date')!=''&&$this->input->get('to_date') !=' '){
        $from_date=$this->input->get('from_date');
        $to_date=$this->input->get('to_date');
        $condition.=" AND sm.return_date BETWEEN '$from_date' AND '$to_date'";
      }
     }
     $department_id=$this->session->userdata('department_id');
    $result=$this->db->query("SELECT sm.*,d.department_name,
          u.user_name,sm.employee_id as  employee_cardno
          FROM  issue_return_info sm 
          LEFT JOIN department_info d ON(sm.from_department_id=d.department_id)
          LEFT JOIN user u ON(u.id=sm.user_id) 
          WHERE sm.department_id=$department_id 
          $condition 
          ORDER BY sm.ireturn_id DESC 
         LIMIT $start,$limit")->result();
      return $result;
    }


    function get_info($ireturn_id){
        $department_id=$this->session->userdata('department_id');
        $result=$this->db->query("SELECT sm.*,d.department_name,
          m.employee_name,u.user_name,
          pd.product_detail_id,pd.asset_encoding
          FROM  issue_return_info sm 
          LEFT JOIN department_info d ON(sm.from_department_id=d.department_id)
          LEFT JOIN employee_idcard_info m ON(sm.employee_id=m.employee_cardno)
          LEFT JOIN user u ON(u.id=sm.user_id) 
          LEFT JOIN product_detail_info pd ON(sm.product_detail_id=pd.product_detail_id)
          WHERE sm.ireturn_id=$ireturn_id")->row();
        return $result;
    }
 
   
function save($ireturn_id) {
    $department_id=$this->session->userdata('department_id');
    $data=array();
    $data['from_department_id']=$this->input->post('from_department_id');
    $data['employee_id']=$this->input->post('employee_id');
    if($this->input->post('ventura_code')!=''){
      $data['ventura_code']=$this->input->post('ventura_code');
      $ventura_code=$this->input->post('ventura_code');
      $data['product_detail_id']=$this->db->query("SELECT * FROM product_detail_info 
        WHERE ventura_code='$ventura_code' 
        OR asset_encoding='$ventura_code' 
        OR tpm_serial_code='$ventura_code' ")->row('product_detail_id');
    }
    $data['return_note']=$this->input->post('return_note');
    $data['return_date']=alterDateFormat($this->input->post('return_date'));
    $data['user_id']=$this->session->userdata('user_id');
    $data['product_id']=$this->input->post('product_id');
    $data['return_qty']=$this->input->post('return_qty');
    $data['return_note']=$this->input->post('return_note');
    $data['unit_price']=$this->input->post('unit_price');
    $data['product_name']=$this->input->post('product_name');
    $data['product_code']=$this->input->post('product_code');
    $data['currency']=$this->input->post('currency');
    $product_id=$this->input->post('product_id');
    $return_qty=$this->input->post('return_qty');
    $currency=$this->input->post('currency');
    $data['department_id']=$department_id;
    $year=date('y');
    $month=date('m');
    $day=date('dHi');
    $ymd="$year$month$day";
    $counts=$this->db->query("SELECT count(*) as counts FROM stock_master_detail 
    WHERE FIFO_CODE LIKE '$ymd%' AND (TRX_TYPE='GRN' OR TRX_TYPE='RETURN') ")->row('counts');
    $data['FIFO_CODE']=$ymd.str_pad($counts + 1, 4, '0', STR_PAD_LEFT).'R';
    //////////////////////////////////////
    $reference_no=strtoupper(substr(md5('VLMBD234'.mt_rand(0,100)),0,2));
    $data['reference_no'] =date('ymd').str_pad($reference_no + 1, 6, '0', STR_PAD_LEFT);
    $query=$this->db->insert('issue_return_info',$data);
    $ireturn_id=$this->db->insert_id();
    $this->look_up_model->storecrud("ADD",$product_id,$return_qty);

    $hkdrate=getHKDRate($data['currency']);
     /////////////////Stock Master Data//////////////////////
        $datas=array();
        $datas['TRX_TYPE']="RETURN";
        $datas['received_department_id']=$this->input->post('from_department_id');
        $datas['department_id']=$this->session->userdata('department_id');
        $datas['product_id']=$product_id;
        $datas['INDATE']=alterDateFormat($this->input->post('return_date'));
        $datas['ITEM_CODE']=$data['product_code'];
        $datas['FIFO_CODE']=$data['FIFO_CODE'];
        $datas['LOCATION']=$this->session->userdata('dept_shortcode');
        $datas['LOCATION1']="";
        $datas['CRRNCY']=$this->input->post('currency'); 
        $datas['EXCH_RATE']=$hkdrate;        
        $datas['QUANTITY']=$return_qty;
        $datas['UPRICE']=$data['unit_price'];
        $datas['TOTALAMT']=($return_qty*$data['unit_price']);
        $datas['TOTALAMT_HKD']=($return_qty*$data['unit_price']*$hkdrate);
        $datas['receive_id']=$ireturn_id;
        $datas['REF_CODE']=$data['reference_no'];
        $datas['CRT_USER']=$this->session->userdata('user_name');
        $datas['CRT_DATE']=date('Y-m-d');
        $datas['user_id']=$this->session->userdata('user_id');
        $datas['notes']=$this->input->post('return_note');
        $this->db->insert('stock_master_detail',$datas);
        $this->look_up_model->valuecrud("ADD",$product_id,$datas['TOTALAMT_HKD']);
    return $query;
  }

  function delete($ireturn_id) {
      $info=$this->db->query("SELECT *
        FROM issue_return_info  
        WHERE ireturn_id=$ireturn_id")->row();
      $this->look_up_model->storecrud("MINUS",$info->product_id,$info->return_qty);
      $this->db->WHERE('ireturn_id',$ireturn_id);
      $query=$this->db->delete('issue_return_info');
      $this->db->WHERE('receive_id',$ireturn_id);
      $this->db->WHERE('TRX_TYPE','RETURN');
      $this->db->delete('stock_master_detail');
      return $query;
  }

  

}
