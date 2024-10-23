<?php
class Purhrequisn_model extends CI_Model {
	public function get_count(){
    $condition=' ';
    if($_GET){
      if($this->input->get('pi_no')!=''){
        $pi_no=$this->input->get('pi_no');
        $condition=$condition."  AND pm.pi_no LIKE '%$pi_no%' ";
      }
      if($this->input->get('product_code')!=''){
        $product_code=$this->input->get('product_code');
        $condition=$condition."  AND (pmd.product_code LIKE '%$product_code%' OR pmd.product_name LIKE '%$product_code%') ";
      }
      if($this->input->get('department_id')!='All'){
        $department_id=$this->input->get('department_id');
        $condition=$condition."  AND pm.department_id='$department_id' ";
      }
      if($this->input->get('pi_status')!='All'){
        $pi_status=$this->input->get('pi_status');
        $condition=$condition."  AND pm.pi_status='$pi_status' ";
      }
      if($this->input->get('purchase_type_id')!='All'){
        $purchase_type_id=$this->input->get('purchase_type_id');
        $condition=$condition." AND pm.purchase_type_id='$purchase_type_id' ";
      }
      if($this->input->get('from_date')!=''&&$this->input->get('to_date') !=' '){
        $from_date=$this->input->get('from_date');
        $to_date=$this->input->get('to_date');
        $condition.=" AND pm.pi_date BETWEEN '$from_date' AND '$to_date'";
      }
     }
     $department_id=$this->session->userdata('department_id');
     if($this->input->get('product_code')!=''){
      $query=$this->db->query("SELECT pm.*,pt.department_name,u.user_name,
          d.department_name as responsible_department_name       
          FROM  pi_master pm 
          INNER JOIN pi_item_details pmd ON(pm.pi_id=pmd.pi_id)
          LEFT JOIN department_info pt ON(pm.department_id=pt.department_id)
          LEFT JOIN department_info d ON(pm.responsible_department=d.department_id) 
          LEFT JOIN user u ON(u.id=pm.requested_by) 
          WHERE pm.pi_status>=4  AND pm.pi_status!=8 
          AND pm.responsible_department=15  
          $condition
          GROUP BY pm.pi_id");
     }else{
      $query=$this->db->query("SELECT pm.*,pt.department_name,u.user_name,
          d.department_name as responsible_department_name       
          FROM  pi_master pm 
          LEFT JOIN department_info pt ON(pm.department_id=pt.department_id)
          LEFT JOIN department_info d ON(pm.responsible_department=d.department_id) 
          LEFT JOIN user u ON(u.id=pm.requested_by) 
          WHERE pm.pi_status>=4  AND pm.pi_status!=8
          AND pm.responsible_department=15  
          $condition
          GROUP BY pm.pi_id");
     }
    $data = count($query->result());
    return $data;

    }
    function lists($limit,$start){
      $department_id=$this->session->userdata('department_id');
      $condition=' ';
      if($_GET){
        if($this->input->get('pi_no')!=''){
          $pi_no=$this->input->get('pi_no');
          $condition=$condition."  AND pm.pi_no  LIKE '%$pi_no%' ";
        }
        if($this->input->get('product_code')!=''){
          $product_code=$this->input->get('product_code');
           $condition=$condition."  AND (pmd.product_code LIKE '%$product_code%' OR pmd.product_name LIKE '%$product_code%') ";
        }
        if($this->input->get('department_id')!='All'){
          $department_id=$this->input->get('department_id');
          $condition=$condition."  AND pm.department_id='$department_id' ";
        }
        if($this->input->get('pi_status')!='All'){
          $pi_status=$this->input->get('pi_status');
          $condition=$condition."  AND pm.pi_status='$pi_status' ";
        }
        if($this->input->get('purchase_type_id')!='All'){
          $purchase_type_id=$this->input->get('purchase_type_id');
          $condition=$condition."  AND pm.purchase_type_id='$purchase_type_id' ";
        }
        if($this->input->get('from_date')!=''&&$this->input->get('to_date') !=' '){
          $from_date=$this->input->get('from_date');
          $to_date=$this->input->get('to_date');
          $condition.=" AND pm.pi_date BETWEEN '$from_date' AND '$to_date'";
        }
      }
      if($this->input->get('product_code')!=''){
        $result=$this->db->query("SELECT pm.*,pt.department_name,u.user_name,
        d.department_name as responsible_department_name,
        dr.deptrequisn_no      
        FROM  pi_master pm 
        INNER JOIN pi_item_details pmd ON(pm.pi_id=pmd.pi_id)
        LEFT JOIN department_info pt ON(pm.department_id=pt.department_id)
        LEFT JOIN department_info d ON(pm.responsible_department=d.department_id)
        LEFT JOIN deptrequisn_master dr ON(pm.deptrequisn_id=dr.deptrequisn_id) 
        LEFT JOIN user u ON(u.id=pm.requested_by) 
        WHERE pm.pi_status>=4  AND pm.pi_status!=8 
        AND pm.responsible_department=15  
        $condition
        GROUP BY pm.pi_id
        ORDER BY pm.pi_status ASC, pm.approved_date DESC LIMIT $start,$limit")->result();   
      }else{
        $result=$this->db->query("SELECT pm.*,pt.department_name,u.user_name,
        d.department_name as responsible_department_name,
        dr.deptrequisn_no      
        FROM  pi_master pm 
        LEFT JOIN department_info pt ON(pm.department_id=pt.department_id)
        LEFT JOIN department_info d ON(pm.responsible_department=d.department_id)
        LEFT JOIN deptrequisn_master dr ON(pm.deptrequisn_id=dr.deptrequisn_id) 
        LEFT JOIN user u ON(u.id=pm.requested_by) 
        WHERE pm.pi_status>=4  AND pm.pi_status!=8
        AND pm.responsible_department=15  
        $condition
        GROUP BY pm.pi_id
        ORDER BY pm.pi_status ASC, pm.approved_date DESC LIMIT $start,$limit")->result();
      }
      
      return $result;
    }

     function get_info1($pi_id){
      $department_id=$this->session->userdata('department_id');
         $result=$this->db->query("SELECT pm.*
          FROM  pi_master pm 
          WHERE pm.pi_id=$pi_id")->row();
        return $result;
    }
   
   function received($pi_id) {
      $data=array();
      $data['pi_status']=6;
      $data['received_date']=date('Y-m-d H:i:s');
      $data['received_time']=date('H:i:s');
      $data['received_by']=$this->session->userdata('user_id');
      $this->db->WHERE('pi_id',$pi_id);
      $query=$this->db->Update('pi_master',$data);
      return $query;
  }
   function rejected() {
      $data=array();
      $pi_id=$this->input->post('pi_id');
      $data['pi_status']=$this->input->post('pi_status1');
      $data['reject_note']=$this->session->userdata('user_name').":".$this->input->post('reject_note');
      $this->db->WHERE('pi_id',$pi_id);
      $query=$this->db->Update('pi_master',$data);
      ////////////////////////
      $cdata['comments']=$this->session->userdata('user_name').":".$this->input->post('reject_note');
      $cdata['pi_id']=$pi_id;
      $cdata['date']=date('Y-m-d');
      $cdata['user_name']=$this->session->userdata('user_name');
      $query=$this->db->insert('pi_comment_info',$cdata);
      
      return $query;
  }
  function save($pi_id) {
      $info=$this->get_info1($pi_id);
      if($info->pi_status==7)
      $data['price_updated']=2;
      else
      $data['price_updated']=1;
      $this->db->WHERE('pi_id',$pi_id);
      $query=$this->db->Update('pi_master',$data);
      //////////////////////////////////////
      $pi_detail_id=$this->input->post('pi_detail_id');
      $amount=$this->input->post('amount');
      $unit_price=$this->input->post('unit_price');
      $currency=$this->input->post('currency');
      $product_id=$this->input->post('product_id');
      $supplier_id=$this->input->post('supplier_id');
      $cnc_rate_in_hkd=$this->input->post('cnc_rate_in_hkd');
      $po_no=$this->input->post('po_no');
      $erp_item_code=$this->input->post('erp_item_code');
      $file_no=$this->input->post('file_no');
      $i=0;
       foreach ($pi_detail_id as $value) {
        $data1=array();
        $data1['amount']=$amount[$i];
        $data1['unit_price']=$unit_price[$i];
        $data1['currency']=$currency[$i];
        $data1['supplier_id']=$supplier_id[$i];
        $data1['cnc_rate_in_hkd']=$cnc_rate_in_hkd[$i];
        $data1['po_no']=$po_no[$i];
        $data1['erp_item_code']=$erp_item_code[$i];
        $data1['file_no']=$file_no[$i];
        $data1['erp_udate']=date('Y-m-d H:i:s');
        $this->db->WHERE('pi_id',$pi_id);
        $this->db->WHERE('product_id',$product_id[$i]);
        $this->db->WHERE('pi_detail_id',$value);
        $query=$this->db->UPDATE('pi_item_details',$data1);
        
        $i++;
       }
   
      return $query;
    }

  
}
