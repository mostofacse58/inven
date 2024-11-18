<?php
class Requisitionapp_model extends CI_Model {
	public function get_count(){
      $department_id=$this->session->userdata('department_id');
      $mlocation_id=$this->session->userdata('mlocation_id');
      $condition=' ';
      if($mlocation_id!=''){
          $condition=$condition."  AND l.mlocation_id='$mlocation_id' AND pm.responsible_department=25 ";
        }
      
      if(isset($_GET)){
        if($this->input->get('requisition_no')!=''){
          $requisition_no=$this->input->get('requisition_no');
          $condition=$condition."  AND pm.requisition_no='$requisition_no' ";
        }
       }

      $query=$this->db->query("SELECT pm.*,pt.department_name,u.user_name,
          d.department_name as responsible_department_name       
          FROM  requisition_master pm 
          LEFT JOIN department_info pt ON(pm.department_id=pt.department_id)
          LEFT JOIN department_info d ON(pm.responsible_department=d.department_id) 
          LEFT JOIN location_info l ON(l.location_id=pm.location_id) 
          LEFT JOIN user u ON(u.id=pm.requested_by) 
          WHERE pm.department_id=$department_id 
          AND pm.requisition_status>1 AND pm.pr_type=1 
          AND pm.general_or_tpm=1 $condition");
      $data = count($query->result());
      return $data;
    }
    function lists($limit,$start) {
        $department_id=$this->session->userdata('department_id');
        $mlocation_id=$this->session->userdata('mlocation_id');
        $condition=' ';
        if($mlocation_id!=''){
          $condition=$condition."  AND l.mlocation_id='$mlocation_id' AND pm.responsible_department=25 ";
        }
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
          WHERE pm.department_id=$department_id 
          AND pm.requisition_status>1 
          AND pm.general_or_tpm=1 
          AND pm.pr_type=1 $condition
          ORDER BY pm.requisition_status ASC LIMIT $start,$limit")->result();
        //echo $this->db->last_query(); exit
        return $result;
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
   function approved($requisition_id) {
      $data=array();
      $data['requisition_status']=3;
      $data['aproved_date_time']=date('Y-m-d h:i:s a');
      $data['dept_head']=$this->session->userdata('user_id');
      $this->db->WHERE('requisition_id',$requisition_id);
      $query=$this->db->Update('requisition_master',$data);
      return $query;
     }
   function rejected($requisition_id) {
      $data=array();
      $data['requisition_status']=0;
      $this->db->WHERE('requisition_id',$requisition_id);
      $query=$this->db->Update('requisition_master',$data);
      return $query;
   }
   function returns($requisition_id) {
      $data=array();
      $data['requisition_status']=1;
      $this->db->WHERE('requisition_id',$requisition_id);
      $query=$this->db->Update('requisition_master',$data);
      return $query;
     }
  
}
