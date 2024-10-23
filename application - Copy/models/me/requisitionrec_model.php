<?php
class Requisitionrec_model extends CI_Model {
  public function get_count(){
    $condition=' ';
    if($_GET){
      if($this->input->get('product_code')!=''){
        $product_code=$this->input->get('product_code');
       // $condition=$condition."  AND pmd.product_code LIKE '%$product_code%' ";
      }
      if($this->input->get('requisition_no')!=''){
        $requisition_no=$this->input->get('requisition_no');
        $condition=$condition."  AND pm.requisition_no='$requisition_no' ";
      }
      if($this->input->get('department_id')!='All'){
        $department_id1=$this->input->get('department_id');
        $condition=$condition."  AND pm.department_id='$department_id1' ";
      }
     }
    $department_id=$this->session->userdata('department_id');
      if($this->input->get('product_code')!=''){
        $data=$this->db->query("SELECT count(*) as counts     
            FROM  requisition_master pm 
            WHERE pm.responsible_department=12 AND pm.general_or_tpm=2
            AND pm.requisition_status>1 AND pm.pr_type=1 $condition 
            GROUP BY pm.requisition_id")->row('counts');

      }else{
        $data=$this->db->query("SELECT count(*) as counts 
            FROM  requisition_master pm       
            WHERE pm.responsible_department=12 AND pm.general_or_tpm=2
            AND pm.requisition_status>1 AND pm.pr_type=1 ")->row('counts');
      }
     return $data;
    }
    function lists($limit,$start) {
        $condition=' ';
        if($_GET){
          if($this->input->get('product_code')!=''){
            $product_code=$this->input->get('product_code');
            $condition=$condition."  AND pmd.product_code LIKE '%$product_code%' ";
          }
          if($this->input->get('requisition_no')!=''){
            $requisition_no=$this->input->get('requisition_no');
            $condition=$condition."  AND pm.requisition_no='$requisition_no' ";
          }
          if($this->input->get('department_id')!='All'){
            $department_id1=$this->input->get('department_id');
            $condition=$condition."  AND pm.department_id='$department_id1' ";
          }
         }
         $department_id=$this->session->userdata('department_id');
        if($this->input->get('product_code')!=''){
          $result=$this->db->query("SELECT pm.*,pt.department_name,u.user_name,
          d.department_name as responsible_department_name       
          FROM  requisition_master pm 
          LEFT JOIN requisition_item_details pmd ON(pm.requisition_id=pmd.requisition_id)
          LEFT JOIN department_info pt ON(pm.department_id=pt.department_id)
          LEFT JOIN department_info d ON(pm.responsible_department=d.department_id) 
          LEFT JOIN user u ON(u.id=pm.requested_by) 
          WHERE pm.responsible_department=12 
          AND pm.requisition_status>1 AND pm.general_or_tpm=2 $condition
          GROUP BY pm.requisition_id 
          ORDER BY pm.requisition_status ASC,requisition_id DESC
          LIMIT $start,$limit")->result();

        }else{
          $result=$this->db->query("SELECT pm.*,pt.department_name,u.user_name,
          d.department_name as responsible_department_name       
          FROM  requisition_master pm 
          LEFT JOIN department_info pt ON(pm.department_id=pt.department_id)
          LEFT JOIN department_info d ON(pm.responsible_department=d.department_id) 
          LEFT JOIN user u ON(u.id=pm.requested_by) 
          WHERE pm.responsible_department=12 
          AND pm.requisition_status>1 AND pm.general_or_tpm=2 $condition
          ORDER BY pm.requisition_status ASC,requisition_id DESC
          LIMIT $start,$limit")->result();
        }
        
      return $result;
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
   function received($requisition_id) {
      $data=array();
      $data['requisition_status']=3;
      $data['approved_by']=$this->session->userdata('user_id');
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
