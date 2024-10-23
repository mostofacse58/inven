<?php
class Rfi_model extends CI_Model {
	public function get_count(){
    $condition=' ';
    if(isset($_GET)){
      if($this->input->get('rfi_no')!=''){
        $rfi_no=$this->input->get('rfi_no');
        $condition=$condition."  AND pm.rfi_no='$rfi_no' ";
      }
     }
    $department_id=$this->session->userdata('department_id');
      $data=$this->db->query("SELECT count(*) as counts  
        FROM  rfi_master pm 
          WHERE pm.department_id=$department_id 
          $condition")->row('counts');
      return $data;
    }
    
    function lists($limit,$start) {
        $department_id=$this->session->userdata('department_id');
        $condition=' ';
        if(isset($_GET)){
          if($this->input->get('rfi_no')!=''){
            $rfi_no=$this->input->get('rfi_no');
            $condition=$condition."  AND pm.rfi_no='$rfi_no' ";
          }
         }
        $result=$this->db->query("SELECT pm.*,pt.department_name,u.user_name,
          d.department_name as responsible_department_name       
          FROM  rfi_master pm 
          LEFT JOIN department_info pt ON(pm.department_id=pt.department_id)
          LEFT JOIN department_info d ON(pm.responsible_department=d.department_id) 
          LEFT JOIN user u ON(u.id=pm.requested_by) 
          WHERE pm.department_id=$department_id  $condition
          ORDER BY pm.rfi_id DESC, pm.rfi_status ASC LIMIT $start,$limit")->result();
        return $result;
    }
    function get_info($rfi_id){
      $department_id=$this->session->userdata('department_id');
         $result=$this->db->query("SELECT pm.*,pt.department_name,
          u.user_name as requested_by,h.user_name as dept_head,
          a.user_name as approved_by,
          d.department_name as responsible_department_name       
          FROM  rfi_master pm 
          LEFT JOIN department_info pt ON(pm.department_id=pt.department_id)
          LEFT JOIN department_info d ON(pm.responsible_department=d.department_id)
          LEFT JOIN user h ON(h.id=pm.dept_head) 
          LEFT JOIN user a ON(a.id=pm.approved_by) 
          LEFT JOIN user u ON(u.id=pm.requested_by)
          WHERE pm.rfi_id=$rfi_id")->row();
        return $result;
    }
    function save($rfi_id) {
      $department_id=$this->session->userdata('department_id');
      $data=array();
      $data['rfi_date']=alterDateFormat($this->input->post('rfi_date'));
      $data['pr_type']=$this->input->post('pr_type');
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
      $quantity=$this->input->post('quantity');
      $remarks=$this->input->post('remarks');
      $i=0;
      if($rfi_id==FALSE){
        $counts=$this->db->query("SELECT MAX(rfi_id) as counts
             FROM rfi_master WHERE 1")->row('counts');
        $rfi_no ='RFI'.date('mY').str_pad($counts + 1, 8, '0', STR_PAD_LEFT);
        $data['rfi_no']=$rfi_no;
        $query=$this->db->insert('rfi_master',$data);
        $rfi_id=$this->db->insert_id();
      }else{
        $this->db->WHERE('rfi_id',$rfi_id);
        $query=$this->db->UPDATE('rfi_master',$data);
        $this->db->WHERE('rfi_id',$rfi_id);
        $this->db->delete('rfi_item_details');
      } 
      foreach ($product_id as $value) {
         $data1['product_id']=$value;
         $data1['rfi_id']=$rfi_id;
         $data1['product_code']=$product_code[$i];
         $data1['product_name']=$product_name[$i];
         $data1['specification']=$specification[$i];
         $data1['quantity']=$quantity[$i];
         $data1['remarks']=$remarks[$i];
         $data1['department_id']=$this->session->userdata('department_id');
         $query=$this->db->insert('rfi_item_details',$data1);
         $i++;
       }
      return $query;
    }
  
    function delete($rfi_id) {
        $this->db->WHERE('rfi_id',$rfi_id);
        $query=$this->db->delete('rfi_item_details');
        $this->db->WHERE('rfi_id',$rfi_id);
        $query=$this->db->delete('rfi_master');
        return $query;
     }
  public function getDetails($rfi_id=''){
   $result=$this->db->query("SELECT pud.*,p.*,c.category_name,u.unit_name
        FROM rfi_item_details pud
        INNER JOIN product_info p ON(pud.product_id=p.product_id)
        INNER JOIN category_info c ON(p.category_id=c.category_id)
        INNER JOIN product_unit u ON(p.unit_id=u.unit_id)
        WHERE pud.rfi_id=$rfi_id 
        ORDER BY p.product_name ASC")->result();
   return $result;
  }
 function getRfiProduct($pr_type,$term) {
    $department_id=$this->session->userdata('department_id');
      $data=date('Y-m-d');
      $result=$this->db->query("SELECT p.*,c.category_name,u.unit_name
       FROM product_info p
        INNER JOIN category_info c ON(p.category_id=c.category_id)
        INNER JOIN product_unit u ON(p.unit_id=u.unit_id)
        WHERE p.product_type=$pr_type 
        AND p.department_id=$department_id 
        AND p.product_status=1
        AND (p.product_code LIKE '%$term%' or p.product_name LIKE '%$term%') 
        ORDER BY p.product_name ASC")->result();
      return $result;
  }
    
   function submit($rfi_id) {
      $data=array();
      $data['rfi_status']=2;
      $data['submited_date_time']=date('Y-m-d  h:i:s a');
      $this->db->WHERE('rfi_id',$rfi_id);
      $query=$this->db->Update('rfi_master',$data);
      return $query;
  }
  
}
