<?php
class Oldpr_model extends CI_Model {
	public function get_count(){
    $condition=' ';
    if(isset($_POST)){
      if($this->input->post('deptrequisn_no')!=''){
        $deptrequisn_no=$this->input->post('deptrequisn_no');
        $condition=$condition."  AND pm.deptrequisn_no='$deptrequisn_no' ";
      }
     }
      $query=$this->db->query("SELECT pm.*,pt.department_name,u.user_name,
          d.department_name as responsible_department_name       
          FROM  deptrequisn_master pm 
          LEFT JOIN department_info pt ON(pm.department_id=pt.department_id)
          LEFT JOIN department_info d ON(pm.responsible_department=d.department_id) 
          LEFT JOIN user u ON(u.id=pm.requested_by) 
          WHERE  pm.pi_type=1 $condition");
      $data = count($query->result());
      return $data;
    }
    function lists($limit,$start) {
        $department_id=$this->session->userdata('department_id');
        $condition=' ';
        if(isset($_POST)){
          if($this->input->post('deptrequisn_no')!=''){
            $deptrequisn_no=$this->input->post('deptrequisn_no');
            $condition=$condition."  AND pm.deptrequisn_no='$deptrequisn_no' ";
          }
         }
      $result=$this->db->query("SELECT pm.*,pt.department_name,u.user_name,
        d.department_name as responsible_department_name       
        FROM  deptrequisn_master pm 
        LEFT JOIN department_info pt ON(pm.department_id=pt.department_id)
        LEFT JOIN department_info d ON(pm.responsible_department=d.department_id) 
        LEFT JOIN user u ON(u.id=pm.requested_by) 
        WHERE  pm.pi_type=1 $condition
        ORDER BY pm.deptrequisn_id DESC LIMIT $start,$limit")->result();
      return $result;
    }

    function get_info($deptrequisn_id){
      $department_id=$this->session->userdata('department_id');
         $result=$this->db->query("SELECT pm.*,pt.department_name,
          u.user_name as requested_by,h.user_name as dept_head,
          a.user_name as approved_by,
          d.department_name as responsible_department       
          FROM  deptrequisn_master pm 
          LEFT JOIN department_info pt ON(pm.department_id=pt.department_id)
          LEFT JOIN department_info d ON(pm.responsible_department=d.department_id)
          LEFT JOIN user h ON(h.id=pm.dept_head) 
          LEFT JOIN user a ON(a.id=pm.approved_by) 
          LEFT JOIN user u ON(u.id=pm.requested_by)
          WHERE pm.deptrequisn_id=$deptrequisn_id AND pm.pi_type=1")->row();
        return $result;
    }
    function save($deptrequisn_id) {
      $department_id=$this->session->userdata('department_id');
      $data=array();
      $data['responsible_department']=15;
      $data['deptrequisn_date']=alterDateFormat($this->input->post('deptrequisn_date'));
      $data['demand_date']=alterDateFormat($this->input->post('demand_date'));
      $data['user_id']=$this->session->userdata('user_id');
      $data['requested_by']=$this->session->userdata('user_id');
      $data['department_id']=$department_id;
      $data['other_note']=$this->input->post('other_note');
      $data['create_date']=date('Y-m-d');
      //////////////////////////////
      $product_id=$this->input->post('product_id');
      $specification=$this->input->post('specification');
      $product_code=$this->input->post('product_code');
      $product_name=$this->input->post('product_name');
      $required_qty=$this->input->post('required_qty');
      $purchased_qty=$this->input->post('purchased_qty');
      $stock_qty=$this->input->post('stock_qty');
      $remarks=$this->input->post('remarks');
      $i=0;
      if($deptrequisn_id==FALSE){
        $deptrequisn_no=$this->db->query("SELECT IFNULL(MAX(deptrequisn_id),0) as deptrequisn_no
             FROM deptrequisn_master WHERE 1")->row('deptrequisn_no');
        $deptrequisn_no ='VLM'.date('mY').str_pad($deptrequisn_no + 1, 8, '0', STR_PAD_LEFT);
        $data['deptrequisn_no']=$deptrequisn_no;
        $query=$this->db->insert('deptrequisn_master',$data);
        $deptrequisn_id=$this->db->insert_id();
      }else{
        $this->db->WHERE('deptrequisn_id',$deptrequisn_id);
        $query=$this->db->UPDATE('deptrequisn_master',$data);
        $this->db->WHERE('deptrequisn_id',$deptrequisn_id);
        $this->db->delete('deptrequisn_item_details');
      } 
      foreach ($product_id as $value) {
         $data1['product_id']=$value;
         $data1['deptrequisn_id']=$deptrequisn_id;
         $data1['product_code']=$product_code[$i];
         $data1['product_name']=$product_name[$i];
         $data1['specification']=$specification[$i];
         $data1['required_qty']=$required_qty[$i];
         $data1['stock_qty']=$stock_qty[$i];
         $data1['purchased_qty']=$purchased_qty[$i];
         $data1['remarks']=$remarks[$i];
         $data1['department_id']=$this->input->post('responsible_department');
         $query=$this->db->insert('deptrequisn_item_details',$data1);
         $i++;
       }
      return $query;
    }
  
    function delete($deptrequisn_id) {
        $this->db->WHERE('deptrequisn_id',$deptrequisn_id);
        $query=$this->db->delete('deptrequisn_item_details');
        $this->db->WHERE('deptrequisn_id',$deptrequisn_id);
        $query=$this->db->delete('deptrequisn_master');
        return $query;
     }
  public function getDetails($deptrequisn_id=''){
   $result=$this->db->query("SELECT pud.*,p.*,c.category_name,u.unit_name
        FROM deptrequisn_item_details pud
        INNER JOIN product_info p ON(pud.product_id=p.product_id)
        INNER JOIN category_info c ON(p.category_id=c.category_id)
        INNER JOIN product_unit u ON(p.unit_id=u.unit_id)
        WHERE pud.deptrequisn_id=$deptrequisn_id 
        ORDER BY p.product_name ASC")->result();
   return $result;
  }
  public function getsafetyStock(){
   $department_id=$this->session->userdata('department_id');
   $medical_yes=$this->session->userdata('medical_yes');
      $result=$this->db->query("SELECT p.*,c.category_name,u.unit_name
       FROM product_info p
        INNER JOIN category_info c ON(p.category_id=c.category_id)
        INNER JOIN product_unit u ON(p.unit_id=u.unit_id)
        WHERE  p.department_id=$department_id AND p.product_type=2 
        AND  p.medical_yes=$medical_yes AND p.main_stock<p.minimum_stock
        ORDER BY p.product_name ASC")->result();
   return $result;
  }
 function getRequisitionProduct($term) {
      $data=date('Y-m-d');
      $department_id=$this->session->userdata('department_id');
      $medical_yes=$this->session->userdata('medical_yes');
      $result=$this->db->query("SELECT p.*,c.category_name,u.unit_name
       FROM product_info p
        INNER JOIN category_info c ON(p.category_id=c.category_id)
        INNER JOIN product_unit u ON(p.unit_id=u.unit_id)
        WHERE p.department_id=$department_id AND p.product_type=2 
        AND p.medical_yes=$medical_yes 
        AND (p.product_code LIKE '%$term%' or p.product_name LIKE '%$term%') 
        ORDER BY p.product_name ASC")->result();
      return $result;
    }
    
   function submit($deptrequisn_id) {
        $this->db->WHERE('deptrequisn_id',$deptrequisn_id);
        $query=$this->db->Update('deptrequisn_master',array('deptrequisn_status'=>2));
        return $query;
     }
  
}
