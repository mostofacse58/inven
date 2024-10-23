<?php
class deptrequisnapp_model extends CI_Model {
  public function get_count(){
    $department_id=$this->session->userdata('department_id');
    $condition=' ';
    if($_GET){
      if($this->input->get('pi_no')!=''){
        $pi_no=$this->input->get('pi_no');
        $condition=$condition."  AND pm.pi_no='$pi_no' ";
      }
      if($this->input->get('pi_status')!='All'){
        $pi_status=$this->input->get('pi_status');
        $condition=$condition."  AND pm.pi_status='$pi_status' ";
      }
     }
    $query=$this->db->query("SELECT pm.*,pt.p_type_name,u.user_name       
      FROM  pi_master pm 
      LEFT JOIN purchase_type pt ON(pm.purchase_type_id=pt.purchase_type_id)
      LEFT JOIN user u ON(u.id=pm.requested_by) 
      WHERE pm.pi_status>1 AND pm.department_id=$department_id AND pm.pi_type=2 $condition");
      $data = count($query->result());
      return $data;
    }
    function lists($limit,$start) {
        $condition=' ';
        if($_GET){
          if($this->input->get('pi_no')!=''){
            $pi_no=$this->input->get('pi_no');
            $condition=$condition."  AND pm.pi_no='$pi_no' ";
          }
          if($this->input->get('pi_status')!='All'){
          $pi_status=$this->input->get('pi_status');
          $condition=$condition."  AND pm.pi_status='$pi_status' ";
        }
        }
        $department_id=$this->session->userdata('department_id');
        $result=$this->db->query("SELECT pm.*,pt.p_type_name,u.user_name,d.department_name,dr.deptrequisn_no       
          FROM  pi_master pm 
          LEFT JOIN purchase_type pt ON(pm.purchase_type_id=pt.purchase_type_id)
          LEFT JOIN department_info d ON(pm.department_id=d.department_id)
          LEFT JOIN deptrequisn_master dr ON(pm.deptrequisn_id=dr.deptrequisn_id) 
          LEFT JOIN user u ON(u.id=pm.requested_by) 
          WHERE pm.pi_status>1 AND pm.department_id=$department_id  AND pm.pi_type=2 $condition
          ORDER BY pm.pi_id DESC LIMIT $start,$limit")->result();
        return $result;
    }

    public function getDetails($pi_id=''){
     $result=$this->db->query("SELECT p.*,c.category_name,u.unit_name,pud.*
          FROM pi_item_details pud
          LEFT JOIN product_info p ON(pud.product_id=p.product_id)
          LEFT JOIN category_info c ON(p.category_id=c.category_id)
          LEFT JOIN product_unit u ON(p.unit_id=u.unit_id)
          WHERE pud.pi_id=$pi_id 
          ORDER BY p.product_name ASC")->result();
     return $result;
    }
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
  function approved($pi_id) {
      $data=array();
      $data['pi_status']=3;
      $data['confirmed_date']=date('Y-m-d');
      $data['confirmed_by']=$this->session->userdata('user_id');
      $this->db->WHERE('pi_id',$pi_id);
      $query=$this->db->Update('pi_master',$data);
      return $query;
  }
   
  
}
