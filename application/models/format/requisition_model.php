<?php
class Requisition_model extends CI_Model {
	public function get_count(){
    $condition=' ';
    if(isset($_GET)){
      if($this->input->get('requisition_no')!=''){
        $requisition_no=$this->input->get('requisition_no');
        $condition=$condition."  AND pm.requisition_no='$requisition_no' ";
      }
     }
    $department_id=$this->session->userdata('department_id');
      $data=$this->db->query("SELECT count(*) as counts  
        FROM  requisition_master pm 
          WHERE pm.department_id=$department_id 
          AND pm.pr_type=1 AND pm.general_or_tpm=1
          $condition")->row('counts');
      return $data;
    }
    
    function lists($limit,$start) {
        $department_id=$this->session->userdata('department_id');
        $condition=' ';
        if(isset($_GET)){
          if($this->input->get('requisition_no')!=''){
            $requisition_no=$this->input->get('requisition_no');
            $condition=$condition."  AND pm.requisition_no='$requisition_no' ";
          }
         }
        $result=$this->db->query("SELECT pm.*,pt.department_name,u.user_name,l.location_name,
          d.department_name as responsible_department_name       
          FROM  requisition_master pm 
          LEFT JOIN department_info pt ON(pm.department_id=pt.department_id)
          LEFT JOIN department_info d ON(pm.responsible_department=d.department_id) 
          LEFT JOIN location_info l ON(l.location_id=pm.location_id)
          LEFT JOIN user u ON(u.id=pm.requested_by) 
          WHERE pm.department_id=$department_id AND pm.general_or_tpm=1 AND pm.pr_type=1 $condition
          ORDER BY pm.requisition_id DESC, pm.requisition_status ASC LIMIT $start,$limit")->result();
        return $result;
    }
    function get_info($requisition_id){
      $department_id=$this->session->userdata('department_id');
         $result=$this->db->query("SELECT pm.*,pt.department_name,
          u.user_name as requested_by,h.user_name as dept_head,
          a.user_name as approved_by,e.employee_name,l.location_name,
          d.department_name as responsible_department_name       
          FROM  requisition_master pm 
          LEFT JOIN department_info pt ON(pm.department_id=pt.department_id)
          LEFT JOIN department_info d ON(pm.responsible_department=d.department_id)
          LEFT JOIN location_info l ON(l.location_id=pm.location_id)
          LEFT JOIN user h ON(h.id=pm.dept_head) 
          LEFT JOIN user a ON(a.id=pm.approved_by) 
          LEFT JOIN user u ON(u.id=pm.requested_by)
          LEFT JOIN employee_idcard_info e ON(e.employee_cardno=pm.employee_id) 
          WHERE pm.requisition_id=$requisition_id  AND pm.general_or_tpm=1")->row();
        return $result;
    }
    function save($requisition_id) {
      $department_id=$this->session->userdata('department_id');
      $data=array();
      $data['responsible_department']=$this->input->post('responsible_department');
      $data['requisition_date']=alterDateFormat($this->input->post('requisition_date'));
      $data['demand_date']=alterDateFormat($this->input->post('demand_date'));
      $data['user_id']=$this->session->userdata('user_id');
      $data['requested_by']=$this->session->userdata('user_id');
      $data['department_id']=$department_id;
      $data['employee_id']=$this->input->post('employee_id');
      $data['other_note']=$this->input->post('other_note');
      $data['asset_encoding']=trim($this->input->post('asset_encoding')," ");
      $data['file_no']=$this->input->post('file_no');
      $data['location_id']=$this->input->post('location_id');
      $data['create_date']=date('Y-m-d');
      //////////////////////////////
      $product_id=$this->input->post('product_id');
      $specification=$this->input->post('specification');
      $product_code=$this->input->post('product_code');
      $product_name=$this->input->post('product_name');
      $required_qty=$this->input->post('required_qty');
      $stock_qty=$this->input->post('stock_qty');
      $remarks=$this->input->post('remarks');
      $i=0;
      if($requisition_id==FALSE){
        $counts=$this->db->query("SELECT MAX(requisition_id) as counts
             FROM requisition_master WHERE 1")->row('counts');
        $requisition_no ='VLM'.date('mY').str_pad($counts + 1, 8, '0', STR_PAD_LEFT);
        $data['requisition_no']=$requisition_no;
        $query=$this->db->insert('requisition_master',$data);
        $requisition_id=$this->db->insert_id();
      }else{
        $this->db->WHERE('requisition_id',$requisition_id);
        $query=$this->db->UPDATE('requisition_master',$data);
        $this->db->WHERE('requisition_id',$requisition_id);
        $this->db->delete('requisition_item_details');
      } 
      foreach ($product_id as $value) {
         $data1['product_id']=$value;
         $data1['requisition_id']=$requisition_id;
         $data1['product_code']=$product_code[$i];
         $data1['product_name']=$product_name[$i];
         $data1['specification']=$specification[$i];
         $data1['required_qty']=$required_qty[$i];
         $data1['stock_qty']=$stock_qty[$i];
         $data1['remarks']=$remarks[$i];
         $data1['department_id']=$this->input->post('responsible_department');
         $query=$this->db->insert('requisition_item_details',$data1);
         $i++;
       }
      return $query;
    }
  
    function delete($requisition_id) {
        $this->db->WHERE('requisition_id',$requisition_id);
        $query=$this->db->delete('requisition_item_details');
        $this->db->WHERE('requisition_id',$requisition_id);
        $query=$this->db->delete('requisition_master');
        return $query;
     }
  public function getDetails($requisition_id=''){
   $result=$this->db->query("SELECT pud.*,p.*,c.category_name,u.unit_name
        FROM requisition_item_details pud
        INNER JOIN product_info p ON(pud.product_id=p.product_id)
        INNER JOIN category_info c ON(p.category_id=c.category_id)
        INNER JOIN product_unit u ON(p.unit_id=u.unit_id)
        WHERE pud.requisition_id=$requisition_id 
        ORDER BY p.product_name ASC")->result();
   return $result;
  }
 function getRequisitionProduct($responsible_department,$term) {
      $data=date('Y-m-d');
      $result=$this->db->query("SELECT p.*,c.category_name,u.unit_name
       FROM product_info p
        INNER JOIN category_info c ON(p.category_id=c.category_id)
        INNER JOIN product_unit u ON(p.unit_id=u.unit_id)
        WHERE p.department_id=$responsible_department AND p.product_type=2 AND p.product_status=1
        AND (p.product_code LIKE '%$term%' or p.product_name LIKE '%$term%') 
        ORDER BY p.product_name ASC")->result();
      return $result;
  }
    
   function submit($requisition_id) {
      $data=array();
      $data['requisition_status']=2;
      $data['submited_date_time']=date('Y-m-d  h:i:s a');
      $this->db->WHERE('requisition_id',$requisition_id);
      $query=$this->db->Update('requisition_master',$data);
      return $query;
  }
  
}
