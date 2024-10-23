<?php
class Applications_model extends CI_Model {
  function renames($value=FALSE)  {
    $department_id=$this->session->userdata('department_id');
    $result=$this->db->query("SELECT pm.*
      FROM  payment_application_master pm 
      WHERE pm.to_department_id=$department_id
      ORDER BY pm.payment_id DESC 
      LIMIT 0,2")->result();
    return $result;
  }
  //////////////////////////////////
  public function get_count(){
    $condition=' ';
    if($_GET){
      if($this->input->get('applications_no')!=''){
        $applications_no=$this->input->get('applications_no');
        $condition=$condition."  AND pm.applications_no='$applications_no' ";
      }
      if($this->input->get('supplier_id')!='All'){
        $supplier_id=$this->input->get('supplier_id');
        $condition=$condition."  AND pm.supplier_id='$supplier_id' ";
      }
      if($this->input->get('from_date')!=''&&$this->input->get('to_date') !=' '){
        $from_date=alterDateFormat($this->input->get('from_date'));
        $to_date=alterDateFormat($this->input->get('to_date'));
        $condition.=" AND pm.applications_date BETWEEN '$from_date' AND '$to_date'";
      }
     }
    $department_id=$this->session->userdata('department_id');
    $query=$this->db->query("SELECT pm.*,d.department_name,
    	u.user_name, p.supplier_name
      FROM  payment_application_master pm 
      LEFT JOIN department_info d ON(pm.department_id=d.department_id)
      LEFT JOIN supplier_info p ON(pm.supplier_id=p.supplier_id) 
      LEFT JOIN user u ON(u.id=pm.prepared_by) 
      WHERE pm.to_department_id=$department_id $condition");
       
     $data = count($query->result());
     return $data;
    }
  function lists($limit,$start) {
    $condition=' ';
    if($_GET){
      if($this->input->get('applications_no')!=''){
        $applications_no=$this->input->get('applications_no');
        $condition=$condition."  AND pm.applications_no='$applications_no' ";
      }
    
      if($this->input->get('supplier_id')!='All'){
        $supplier_id=$this->input->get('supplier_id');
        $condition=$condition."  AND pm.supplier_id='$supplier_id' ";
      }
      if($this->input->get('from_date')!=''&&$this->input->get('to_date') !=' '){
        $from_date=alterDateFormat($this->input->get('from_date'));
        $to_date=alterDateFormat($this->input->get('to_date'));
        $condition.=" AND pm.applications_date BETWEEN '$from_date' AND '$to_date'";
      }
     }
  $department_id=$this->session->userdata('department_id');
    $result=$this->db->query("SELECT pm.*,
      d.department_name,d.dept_head_email,u.user_name,u.email_address,
      u.mobile,p.supplier_name,
      u2.user_name as checked_by,u3.user_name as approved_by_name,
      u3.email_address as approved_email_address,
      d2.department_name as acc_department_name,
      d2.dept_head_email as acc_dept_head_email,
      u4.user_name as received_by
      FROM  payment_application_master pm 
      LEFT JOIN department_info d ON(pm.to_department_id=d.department_id)
      LEFT JOIN department_info d2 ON(pm.department_id=d2.department_id)
      INNER JOIN supplier_info p ON(pm.supplier_id=p.supplier_id)
      LEFT JOIN user u ON(u.id=pm.prepared_by) 
      LEFT JOIN user u2 ON(u2.id=pm.checked_by)
      LEFT JOIN user u3 ON(u3.id=pm.approved_by)
      LEFT JOIN user u4 ON(u4.id=pm.received_by) 
      WHERE pm.to_department_id=$department_id  
      $condition
      ORDER BY pm.payment_id 
      DESC LIMIT $start,$limit")->result();
    return $result;
  }
  function get_info($payment_id){
     $result=$this->db->query("SELECT pm.*,
      d.department_name,d.dept_head_email,
      u.user_name,u.email_address,
     	u.mobile,p.supplier_name,
      u2.user_name as checked_by,
      u3.user_name as approved_by_name,
      u3.email_address as approved_email_address,
      d2.department_name as acc_department_name,
      d2.dept_head_email as acc_dept_head_email,
      u4.user_name as received_by,
      u5.user_name as verified_by,c.*
      FROM  payment_application_master pm 
      LEFT JOIN department_info d ON(pm.to_department_id=d.department_id)
      LEFT JOIN department_info d2 ON(pm.department_id=d2.department_id)
      LEFT JOIN company_info c ON(pm.company_id=c.id)
      INNER JOIN supplier_info p ON(pm.supplier_id=p.supplier_id)
      LEFT JOIN user u ON(u.id=pm.prepared_by) 
      LEFT JOIN user u2 ON(u2.id=pm.checked_by)
      LEFT JOIN user u3 ON(u3.id=pm.approved_by)
      LEFT JOIN user u4 ON(u4.id=pm.received_by)
      LEFT JOIN user u5 ON(u5.id=pm.verified_by)
      WHERE pm.payment_id=$payment_id")->row();
    return $result;
    }
    public function getDetails($payment_id=''){
     $result=$this->db->query("SELECT a.*,h.head_name
          FROM payment_application_detail a
          INNER JOIN  acccunt_head_info h ON(a.head_id=h.head_id)
          WHERE a.payment_id=$payment_id 
          ORDER BY a.detail_id ASC")->result();
     return $result;
    }
    public function getDetails3($payment_id=''){
     $result=$this->db->query("SELECT a.*
          FROM payment_po_amount a
          WHERE a.payment_id=$payment_id 
          ORDER BY a.id ASC")->result();
     return $result;
    }
    public function getDetails4($payment_id=''){
     $result=$this->db->query("SELECT a.*
          FROM payment_bill_info a
          WHERE a.payment_id=$payment_id 
          ORDER BY a.id ASC")->result();
     return $result;
    }
    public function getDetails1($payment_id='',$head_id=FALSE){
      $result=$this->db->query("SELECT a.*,p.department_name
          FROM payment_dept_amount a
          INNER JOIN pa_dept_code p ON(p.dcode=a.dcode)
          WHERE a.payment_id=$payment_id AND a.head_id=$head_id
          ORDER BY a.id ASC")->result();
      if(count($result)<1){
        $result=$this->db->query("SELECT a.*,p.department_name
          FROM payment_dept_amount a
          INNER JOIN pa_dept_code p ON(p.dcode=a.dcode)
          WHERE a.payment_id=$payment_id
          ORDER BY a.id ASC")->result();
      }
     return $result;
    }

  function save($data,$payment_id) {
      $data['supplier_id']=$this->input->post('supplier_id');
      $data['company_id']=$this->input->post('company_id');
      $data['other_name']=$this->input->post('other_name');
      $data['approved_by']=$this->input->post('approved_by');
      $data['applications_date']=alterDateFormat($this->input->post('applications_date'));
      $data['to_department_id']=$this->session->userdata('department_id');
      $data['description']=$this->input->post('description');
      $data['vat_add_per']=$this->input->post('vat_add_per');
      $data['vat_add_amount']=$this->input->post('vat_add_amount');
      $data['ait_add_per']=$this->input->post('ait_add_per');
      $data['ait_add_amount']=$this->input->post('ait_add_amount');
      $data['sub_total']=$this->input->post('sub_total');
      $data['vat_less_per']=$this->input->post('vat_less_per');
      $data['vat_less_amount']=$this->input->post('vat_less_amount');
      $data['ait_less_per']=$this->input->post('ait_less_per');
      $data['ait_less_amount']=$this->input->post('ait_less_amount');
      $data['other_note']=$this->input->post('other_note');
      $data['other_plus_minus']=$this->input->post('other_plus_minus');
      $data['other_amount']=$this->input->post('other_amount');
      $data['total_amount']=$this->input->post('total_amount');
      $data['dtotal_amount']=$this->input->post('dtotal_amount');
      $data['pa_type']=$this->input->post('pa_type');
      $data['verification_need']=$this->input->post('verification_need');
      $data['pa_limit']=$this->input->post('pa_limit');
      $data['currency']=$this->input->post('currency');
      //if($po_number)
      //$data['po_number']=implode(",",$po_number);
      $data['prepared_by']=$this->session->userdata('user_id');
      $data['prepared_date']=date('Y-m-d');
      ////////////////////////////////////////
      if($payment_id==FALSE){
        $applications_no=$this->db->query("SELECT IFNULL(MAX(payment_id),0) as applications_no
             FROM payment_application_master 
             WHERE 1")->row('applications_no');
        $applications_no ='BDPA-'.str_pad($applications_no + 1, 6, '0', STR_PAD_LEFT);
        $data['applications_no']=$applications_no;
        /////////////////////////////////
        $exarray=explode(".",$data['attachemnt_file']);
        $exten=$exarray[1];
        $newname=$applications_no.'.'.$exten;
        $oldname=$data['attachemnt_file'];
        rename("./payment/".$oldname, "./payment/".$newname);
        $data['attachemnt_file']=$newname;
        /////////////////////////////////
        $query=$this->db->insert('payment_application_master',$data);
        $payment_id=$this->db->insert_id();
      }else{
        $info=$this->db->query("SELECT a.*
          FROM payment_application_master a
          WHERE a.payment_id=$payment_id ")->row();
        ////////////
        $exarray=explode(".",$data['attachemnt_file']);
        $exten=$exarray[1];
        $newname=$info->applications_no.'.'.$exten;
        $oldname=$data['attachemnt_file'];
        rename("./payment/".$oldname, "./payment/".$newname);
        $data['attachemnt_file']=$newname;
        ///////////////////////////////
        $this->db->WHERE('payment_id',$payment_id);
        $this->db->UPDATE('payment_application_master',$data);
        $this->db->WHERE('payment_id',$payment_id);
        $this->db->delete('payment_application_detail');
        $this->db->WHERE('payment_id',$payment_id);
        $this->db->delete('payment_dept_amount');
        $this->db->WHERE('payment_id',$payment_id);
        $this->db->delete('payment_po_amount');
        $this->db->WHERE('payment_id',$payment_id);
        $this->db->delete('payment_bill_info');
      } 
      $head_id=$this->input->post('head_id');
      $amount=$this->input->post('amount');
      $parameter=$this->input->post('parameter');
      $remarks=$this->input->post('remarks');
      
      $i=0;
      foreach ($head_id as $value) {
         $data1['head_id']=$value;
         $par= $parameter[$i];
         $data1['payment_id']=$payment_id;
         $data1['amount']=$amount[$i];
         $data1['remarks']=$remarks[$i];
         $data1['pa_type']=$this->input->post('pa_type');
         $query=$this->db->insert('payment_application_detail',$data1);
         $id=0;
         $dvar="dcode$par";
         $avar="damount$par";
         $dcode=$this->input->post("$dvar");
         $damount=$this->input->post("$avar");

          foreach ($dcode as $value2) {
            if($damount[$id]!=0){
             $data2['dcode']=$value2;
             $data2['payment_id']=$payment_id;
             $data2['head_id']=$value;
             $data2['damount']=$damount[$id];
             $data2['percentage']=$damount[$id]*100/$data1['amount'];
             $data2['pa_type']=$this->input->post('pa_type');
             $query=$this->db->insert('payment_dept_amount',$data2);
            }
            $id++;
           }
         $i++;
       }
       $i=0;
       if ($data1['pa_type']!='Advance') {
        $po_number=$this->input->post('po_number');
        $pamount=$this->input->post('pamount');
        $actual_amount=$this->input->post('actual_amount');
        $pocurrency=$this->input->post('pocurrency');
        $due_amount=$this->input->post('due_amount');
        $grn_amount=$this->input->post('grn_amount');
        if(count($po_number)>0&&$po_number!=''){
         foreach ($po_number as $value3) {
           $data3['po_number']=$value3;
           $data3['payment_id']=$payment_id;
           $data3['pamount']=$pamount[$i];
           $data3['actual_amount']=$actual_amount[$i];
           $data3['pocurrency']=$pocurrency[$i];
           $data3['grn_amount']=$grn_amount[$i];
           $data3['due_amount']=$due_amount[$i];
           $query=$this->db->insert('payment_po_amount',$data3);
           $i++;
         }}
         }

        $bill_no=$this->input->post('bill_no');
        $bamount=$this->input->post('bamount');
        $i=0;
        if(count($bill_no)>0&&$bill_no!=''){
         foreach ($bill_no as $value3) {
           $data4['bill_no']=$value3;
           $data4['payment_id']=$payment_id;
           $data4['bamount']=$bamount[$i];
           $query=$this->db->insert('payment_bill_info',$data4);
           $i++;
         }}
      return $query;
    }
  
  function delete($payment_id) {
    $this->db->WHERE('payment_id',$payment_id);
    $query=$this->db->delete('payment_application_detail');
    $this->db->WHERE('payment_id',$payment_id);
    $query=$this->db->delete('payment_application_master');
    $this->db->WHERE('payment_id',$payment_id);
    $query=$this->db->delete('payment_dept_amount');
    $this->db->WHERE('payment_id',$payment_id);
    $query=$this->db->delete('payment_po_amount');
    $this->db->WHERE('payment_id',$payment_id);
    $query=$this->db->delete('payment_bill_info');
    return $query;
  }
   ///////////////////////////
   function approved($payment_id) {
      $this->db->WHERE('payment_id',$payment_id);
      $query=$this->db->Update('payment_application_master',array('status'=>2));
      return $query;
   }
  function submit($payment_id) {
    $this->db->WHERE('payment_id',$payment_id);
    $query=$this->db->Update('payment_application_master',array('status'=>2));
    return $query;
 }
 function decisions($payment_id) {
    $data=array();
    $data['status']=$this->input->post('status');
    $data['comment_note']=$this->session->userdata('user_name').":".$this->input->post('comment_note');
    $this->db->WHERE('payment_id',$payment_id);
    $query=$this->db->Update('payment_application_master',$data);
    return $query;
 }
  function getAccountHead() {
    $query=$this->db->query("SELECT * FROM acccunt_head_info 
      ORDER BY head_name ASC")->result();
    return $query;
  }
  
}
