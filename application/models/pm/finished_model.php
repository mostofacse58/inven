<?php
class Finished_model extends CI_Model {
  function lists($year=FALSE) {
    $condition=' ';
    if($_GET){
      if($this->input->get('tpm_code')!=''){
        $tpm_code=$this->input->get('tpm_code');
        $condition=$condition."  AND (sm.tpm_code LIKE '%$tpm_code%') ";
      }
      if($this->input->get('model_no')!=''){
        $model_no=$this->input->get('model_no');
        $condition=$condition."  AND sm.model_no='$model_no' ";
      }
   
     }
     $department_id=$this->session->userdata('department_id');
    $result=$this->db->query("SELECT sm.*
          FROM  pm_master sm 
          WHERE sm.department_id=$department_id AND pm_status='Done'  
          AND work_date LIKE '$year%' 
          $condition 
          ORDER BY sm.pm_id DESC")->result();
      return $result;
    }


    function get_info($pm_id){
        $department_id=$this->session->userdata('department_id');
        $result=$this->db->query("SELECT sm.*
          FROM  pm_master sm 
          WHERE sm.pm_id=$pm_id")->row();
        return $result;
    }

  function getworkdetail($pm_id){
    $result=$this->db->query("SELECT *
          FROM  pm_details  
          WHERE pm_id='$pm_id' 
          ORDER BY id ASC")->result();
      return $result;

   }
  function getsdetail($sref_no){
    $sref_no=str_replace(' ', '', $sref_no);
    $sref_no=str_replace(',', "','", $sref_no);
    $result=$this->db->query("SELECT d.*,p.product_name
          FROM  spares_use_master sm
          INNER JOIN  spares_use_detail d ON(d.spares_use_id=sm.spares_use_id)  
          INNER JOIN  product_info p ON(d.product_id=p.product_id)  
          WHERE sm.using_ref_no IN ('$sref_no')
          ORDER BY d.spares_use_detail_id ASC")->result();
      return $result;

   }

}
