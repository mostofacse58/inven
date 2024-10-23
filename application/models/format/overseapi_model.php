<?php
class Overseapi_model extends CI_Model {
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
          WHERE pm.pi_status>=5 AND (pm.purchase_type_id=1 OR pm.purchase_type_id=2) AND pm.responsible_department=15  
          $condition
          GROUP BY pm.pi_id");
     }else{
      $query=$this->db->query("SELECT pm.*,pt.department_name,u.user_name,
          d.department_name as responsible_department_name       
          FROM  pi_master pm 
          LEFT JOIN department_info pt ON(pm.department_id=pt.department_id)
          LEFT JOIN department_info d ON(pm.responsible_department=d.department_id) 
          LEFT JOIN user u ON(u.id=pm.requested_by) 
          WHERE pm.pi_status>=5 AND (pm.purchase_type_id=1 OR pm.purchase_type_id=2) AND pm.responsible_department=15  
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
           $condition=$condition."  AND (pmd.product_code LIKE '%$product_code%' OR pmd.product_name LIKE '%$product_code%') ";;
        }
        if($this->input->get('department_id')!='All'){
          $department_id=$this->input->get('department_id');
          $condition=$condition."  AND pm.department_id='$department_id' ";
        }
        if($this->input->get('pi_status')!='All'){
          $pi_status=$this->input->get('pi_status');
          $condition=$condition."  AND pm.pi_status='$pi_status' ";
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
        WHERE pm.pi_status>=5 AND (pm.purchase_type_id=1 OR pm.purchase_type_id=2) AND pm.responsible_department=15  
        $condition
        GROUP BY pm.pi_id
        ORDER BY pm.pi_status ASC, pm.pi_id DESC LIMIT $start,$limit")->result();   
      }else{
        $result=$this->db->query("SELECT pm.*,pt.department_name,u.user_name,
        d.department_name as responsible_department_name,
        dr.deptrequisn_no      
        FROM  pi_master pm 
        LEFT JOIN department_info pt ON(pm.department_id=pt.department_id)
        LEFT JOIN department_info d ON(pm.responsible_department=d.department_id)
        LEFT JOIN deptrequisn_master dr ON(pm.deptrequisn_id=dr.deptrequisn_id) 
        LEFT JOIN user u ON(u.id=pm.requested_by) 
        WHERE pm.pi_status>=5 AND (pm.purchase_type_id=1 OR pm.purchase_type_id=2)  AND pm.responsible_department=15  
        $condition
        GROUP BY pm.pi_id
        ORDER BY pm.pi_status ASC, pm.pi_id DESC LIMIT $start,$limit")->result();
      }
      
      return $result;
    }
    ///////////////////////
   function get_info1($pi_id){
      $department_id=$this->session->userdata('department_id');
         $result=$this->db->query("SELECT pm.*,pt.department_name,
          NULL as promised_date,
          NULL as pi_date, NULL as pi_no, NULL as pi_id,NULL as purchase_type_id
          FROM  pi_master pm 
          LEFT JOIN department_info pt ON(pm.department_id=pt.department_id)
          LEFT JOIN department_info d ON(pm.responsible_department=d.department_id)
          LEFT JOIN user h ON(h.id=pm.dept_head) 
          LEFT JOIN user a ON(a.id=pm.approved_by) 
          LEFT JOIN user u ON(u.id=pm.requested_by)
          WHERE pm.pi_id=$pi_id")->row();
        return $result;
    }
   
   function received($pi_id) {
      $data=array();
      $data['pi_status']=6;
      $data['received_date']=date('Y-m-d');
      $data['received_by']=$this->session->userdata('user_id');
      $this->db->WHERE('pi_id',$pi_id);
      $query=$this->db->Update('pi_master',$data);
      return $query;
  }

  
}
