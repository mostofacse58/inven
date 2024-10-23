<?php
class Checklists_model extends CI_Model {
  public function get_count(){
    $condition=' ';
    if($_GET){
      if($this->input->get('work_name')!=''){
        $work_name=$this->input->get('work_name');
        $condition=$condition."  AND (sm.work_name LIKE '%$work_name%') ";
      }
      if($this->input->get('model_no')!=''){
        $model_no=$this->input->get('model_no');
        $condition=$condition."  AND sm.model_no='$model_no' ";
      }
   
     }
   $department_id=$this->session->userdata('department_id');
      $data=$this->db->query("SELECT count(sm.id) as counts
          FROM  maintenance_checklist sm 
          WHERE sm.department_id=$department_id 
           $condition")->row('counts');
      //$data = count($query->result());
      return $data;
    }
  function lists($limit,$start) {
    $condition=' ';
    if($_GET){
      if($this->input->get('work_name')!=''){
        $work_name=$this->input->get('work_name');
        $condition=$condition."  AND (sm.work_name LIKE '%$work_name%') ";
      }
      if($this->input->get('model_no')!=''){
        $model_no=$this->input->get('model_no');
        $condition=$condition."  AND sm.model_no='$model_no' ";
      }
   
     }
     $department_id=$this->session->userdata('department_id');
     $result=$this->db->query("SELECT sm.*,c.category_name
          FROM  maintenance_checklist sm 
          LEFT JOIN category_info c ON(c.category_id=sm.category_id)
          WHERE sm.department_id=$department_id 
          $condition 
          ORDER BY sm.id DESC 
         LIMIT $start,$limit")->result();
      return $result;
    }


    function get_info($id){
        $department_id=$this->session->userdata('department_id');
        $result=$this->db->query("SELECT sm.*
          FROM  maintenance_checklist sm 
          WHERE sm.id=$id")->row();
        return $result;
    }

   


  function delete($id) {
       $this->db->WHERE('id',$id);
      $query=$this->db->delete('maintenance_checklist');
      return $query;
  }

 
  

}
