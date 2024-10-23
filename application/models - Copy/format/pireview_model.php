<?php
class Pireview_model extends CI_Model {
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
          WHERE pm.pi_status>=3 AND pm.pi_status!=8  
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
          WHERE pm.pi_status>=3  AND pm.pi_status!=8
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
        WHERE pm.pi_status>=3  AND pm.pi_status!=8 
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
        WHERE pm.pi_status>=3  AND pm.pi_status!=8
        AND pm.responsible_department=15  
        $condition
        GROUP BY pm.pi_id
        ORDER BY pm.pi_status, pm.review_status ASC LIMIT $start,$limit")->result();
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
   
   function directreview($pi_id) {
      $data=array();
      $data['review_status']=2;
      $data['review_date']=date('Y-m-d H:i:s');
      $data['review_by']=$this->session->userdata('user_name');
      $this->db->WHERE('pi_id',$pi_id);
      $query=$this->db->Update('pi_master',$data);
      return $query;
  }
    
  function save($pi_id) {
      $info=$this->get_info1($pi_id);
      $data['review_status']=2;
      $data['review_date']=date('Y-m-d H:i:s');
      $data['review_by']=$this->session->userdata('user_name');
      $this->db->WHERE('pi_id',$pi_id);
      $query=$this->db->Update('pi_master',$data);
      //////////////////////////////////////
      $pi_detail_id=$this->input->post('pi_detail_id');
      $product_id=$this->input->post('product_id');
      $specification=$this->input->post('specification');
      $remarks=$this->input->post('remarks');
      $china_name=$this->input->post('china_name');
      $i=0;
       foreach ($pi_detail_id as $value) {
        $data1=array();
        $data1['remarks']=$remarks[$i];
        $data1['specification']=$specification[$i];
        $this->db->WHERE('pi_id',$pi_id);
        $this->db->WHERE('product_id',$product_id[$i]);
        $this->db->WHERE('pi_detail_id',$value);
        $query=$this->db->UPDATE('pi_item_details',$data1);
        $data2=array();
        $data2['china_name']=$china_name[$i];
        $data2['product_description']=$specification[$i];
        $this->db->WHERE('product_id',$product_id[$i]);
        $query=$this->db->UPDATE('product_info',$data2);
        $i++;
       }
   
      return $query;
    }

  
}
