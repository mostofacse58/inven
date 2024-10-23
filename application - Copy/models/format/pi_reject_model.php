<?php
class Pi_reject_model extends CI_Model {
	public function get_count(){
    $condition=' ';
    if($_GET){
      if($this->input->get('pi_no')!=''){
        $pi_no=$this->input->get('pi_no');
        $condition=$condition."  AND pm.pi_no='$pi_no' ";
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
    $department_id1=$this->session->userdata('department_id');
      $query=$this->db->query("SELECT pm.*,pt.p_type_name,u.user_name
      FROM  pi_master pm 
      LEFT JOIN purchase_type pt ON(pm.purchase_type_id=pt.purchase_type_id)
      LEFT JOIN user u ON(u.id=pm.requested_by) 
      WHERE pm.pi_status=8 
      AND pm.responsible_department=15 
      $condition");
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
          if($this->input->get('department_id')!='All'){
          $department_id=$this->input->get('department_id');
          $condition=$condition."  AND pm.department_id='$department_id' ";
          }
          if($this->input->get('pi_status')!='All'){
            $pi_status=$this->input->get('pi_status');
            $condition=$condition."  AND pm.pi_status='$pi_status' ";
          }
        }
        $department_id1=$this->session->userdata('department_id');
        $result=$this->db->query("SELECT pm.*,pt.p_type_name,u.user_name,
          d.department_name,dr.deptrequisn_no       
          FROM  pi_master pm 
          LEFT JOIN purchase_type pt ON(pm.purchase_type_id=pt.purchase_type_id)
          LEFT JOIN department_info d ON(pm.department_id=d.department_id)
          LEFT JOIN deptrequisn_master dr ON(pm.deptrequisn_id=dr.deptrequisn_id) 
          LEFT JOIN user u ON(u.id=pm.requested_by) 
          WHERE pm.pi_status=8
          AND pm.responsible_department=15 $condition
          ORDER BY pm.pi_status ASC, pm.pi_id DESC 
          LIMIT $start,$limit")->result();
        return $result;
    }
    function get_info($pi_id){
         $result=$this->db->query("SELECT pm.*,pt.p_type_name,u.user_name,d.department_name,dr.deptrequisn_no 
          FROM  pi_master pm 
          LEFT JOIN purchase_type pt ON(pm.purchase_type_id=pt.purchase_type_id)
          LEFT JOIN department_info d ON(pm.department_id=d.department_id)
          LEFT JOIN deptrequisn_master dr ON(pm.deptrequisn_id=dr.deptrequisn_id) 
          LEFT JOIN user u ON(u.id=pm.requested_by) 
          WHERE pm.pi_id=$pi_id ")->row();
        return $result;
    }
   function statuscount($pi_status){
         $result=$this->db->query("SELECT count(*) as count 
          FROM  pi_master pm  
          WHERE pm.pi_status=$pi_status ")->row('count');
        return $result;
    }
  public function getDetails($pi_id=''){
   $result=$this->db->query("SELECT p.*,c.category_name,u.unit_name,pud.*
        FROM pi_item_details pud
        LEFTLEFT JOIN product_info p ON(pud.product_id=p.product_id)
        LEFT JOIN category_info c ON(p.category_id=c.category_id)
        LEFT JOIN product_unit u ON(p.unit_id=u.unit_id)
        WHERE pud.pi_id=$pi_id 
        ORDER BY p.product_name ASC")->result();
   return $result;
  }
 function getPIProduct($department_id,$term) {
    $result=$this->db->query("SELECT p.*,c.category_name,u.unit_name
     FROM product_info p
      INNER JOIN category_info c ON(p.category_id=c.category_id)
      INNER JOIN product_unit u ON(p.unit_id=u.unit_id)
      WHERE p.department_id=$department_id 
      AND (p.product_code LIKE '%$term%' or p.product_name LIKE '%$term%') 
      ORDER BY p.product_name ASC")->result();
    return $result;
    }
   function approved($pi_id) {
      $data=array();
      $data['pi_status']=6;
      $data['approved_date']=date('Y-m-d');
      $data['approved_by']=$this->session->userdata('user_id');
      $data['reject_note']='';
      $this->db->WHERE('pi_id',$pi_id);
      $query=$this->db->Update('pi_master',$data);
      return $query;
     }
    function returns($pi_id) {
      $data=array();
      $data['reject_note']=$this->session->userdata('user_name').":".$this->input->post('reject_note');
      $data['pi_status']=$this->input->post('pi_status');
      if($this->input->post('pi_status')==6)
      $data['approved_date']=date('Y-m-d');
      $data['approved_by']=$this->session->userdata('user_id');
      $this->db->WHERE('pi_id',$pi_id);
      $query=$this->db->Update('pi_master',$data);
      return $query;
     }
  
}
