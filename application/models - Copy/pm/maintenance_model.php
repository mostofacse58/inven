<?php
class Maintenance_model extends CI_Model {
  public function get_count(){
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
      $data=$this->db->query("SELECT count(sm.pm_id) as counts
          FROM  pm_master sm 
          WHERE sm.department_id=$department_id  
          AND pm_status='Pending'
           $condition")->row('counts');
      //$data = count($query->result());
      return $data;
    }
  function lists($limit,$start) {
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
          WHERE sm.department_id=$department_id  
          AND pm_status='Pending'
          $condition 
          ORDER BY sm.pm_id ASC,sm.pm_date ASC
         LIMIT $start,$limit")->result();
      return $result;
    }


  function get_info($pm_id){
      $department_id=$this->session->userdata('department_id');
      $result=$this->db->query("SELECT sm.*
        FROM  pm_master sm 
        WHERE sm.pm_id=$pm_id")->row();
      return $result;
  }

   
function save($pm_id) {
    $department_id=$this->session->userdata('department_id');
    $data=array();
    $data['user_id']=$this->session->userdata('user_id');
    $data['department_id']=$department_id;
    $data['pm_status']='Pending';
    $tpm_code=$this->input->post('tpm_code');
    $pm_date=$this->input->post('pm_date');
    $i=0;
    foreach ($tpm_code as $value) {
      $code=trim($value);
      $info=$this->db->query("SELECT p.product_model,p.product_name
        FROM  product_detail_info pd , product_info p 
        WHERE p.product_id=pd.product_id 
        AND (pd.tpm_serial_code='$code' OR pd.asset_encoding='$code' OR pd.ventura_code='$code') ")->row();

      $data['tpm_code']=$code;
      $data['pm_date']=$pm_date[$i];
      $data['model_no']=$info->product_model;
      $data['product_name']=$info->product_name;
    if($pm_id==FALSE){
      $query=$this->db->insert('pm_master',$data);
    }else{
      $this->db->WHERE('pm_id',$pm_id);
      $query=$this->db->update('pm_master',$data);
    }
    $i++;
    }
   return $query;
  }

  function delete($pm_id) {
       $this->db->WHERE('pm_id',$pm_id);
      $query=$this->db->delete('pm_master');
      return $query;
  }

   function getchecklist($tpm_code){
    $department_id=$this->session->userdata('department_id');
    $info=$this->db->query("SELECT p.category_id,p.product_model
        FROM  product_info p,product_detail_info pd
        WHERE pd.product_id=p.product_id 
        AND (pd.tpm_serial_code='$tpm_code' OR pd.ventura_code='$tpm_code') ")->row();
    $model_no=$info->product_model;
    $category_id=$info->category_id;
    if($department_id!=12){
      $result=$this->db->query("SELECT *
          FROM  maintenance_checklist  
          WHERE department_id=$department_id
          AND category_id=$category_id
          ORDER BY id ASC")->result();
    }else{
      $result=$this->db->query("SELECT *
          FROM  maintenance_checklist  
          WHERE department_id=$department_id
          AND  model_no='$model_no'
          ORDER BY id ASC")->result();
    }
    
      return $result;

   }
   function updatepm($pm_id) {
    $department_id=$this->session->userdata('department_id');
    $data=array();
    $data['sref_no']=$this->input->post('sref_no');
    $data['work_by']=$this->input->post('work_by');
    $data['work_date']=alterDateFormat($this->input->post('work_date'));
    $data['pm_status']='Done';
    if($_FILES['before_image']['name']!=""){
      $config['upload_path'] = './pm/';
      $config['allowed_types'] = 'PNG|png|jpg|jpeg';
      $config['max_size'] = '300000';
      $config['encrypt_name'] = TRUE;
      $config['detect_mime'] = TRUE;
      $this->load->library('upload', $config);
      if ($this->upload->do_upload("before_image")){
        $upload_info = $this->upload->data();
        $data['before_image']=$upload_info['file_name'];
      }}
      if($_FILES['after_image']['name']!=""){
      $config['upload_path'] = './pm/';
      $config['allowed_types'] = 'PNG|png|jpg|jpeg';
      $config['max_size'] = '300000';
      $config['encrypt_name'] = TRUE;
      $config['detect_mime'] = TRUE;
      $this->load->library('upload', $config);
      if ($this->upload->do_upload("after_image")){
        $upload_info = $this->upload->data();
        $data['after_image']=$upload_info['file_name'];
      }}
      if($_FILES['image1']['name']!=""){
      $config['upload_path'] = './pm/';
      $config['allowed_types'] = 'PNG|png|jpg|jpeg';
      $config['max_size'] = '300000';
      $config['encrypt_name'] = TRUE;
      $config['detect_mime'] = TRUE;
      $this->load->library('upload', $config);
      if ($this->upload->do_upload("image1")){
        $upload_info = $this->upload->data();
        $data['image1']=$upload_info['file_name'];
      }}
      if($_FILES['image2']['name']!=""){
      $config['upload_path'] = './pm/';
      $config['allowed_types'] = 'PNG|png|jpg|jpeg';
      $config['max_size'] = '300000';
      $config['encrypt_name'] = TRUE;
      $config['detect_mime'] = TRUE;
      $this->load->library('upload', $config);
      if ($this->upload->do_upload("image2")){
        $upload_info = $this->upload->data();
        $data['image2']=$upload_info['file_name'];
      }}

    $this->db->WHERE('pm_id',$pm_id);
    $query=$this->db->update('pm_master',$data);
    //print_r($data); exit;
    ////////////////////////
    $check_name=$this->input->post('check_name');
    $id=$this->input->post('id');
    $ok_or_not=$this->input->post('ok_or_not');
    $notes=$this->input->post('notes');
    $i=0;
    $data2['user_id']=$this->session->userdata('user_id');
    $data2['pm_id']=$pm_id;
    $data2['department_id']=$department_id;
    foreach ($id as $value) {
      $data2['id']=$value;
      $data2['check_name']=$check_name[$i];
      $data2['ok_or_not']=$ok_or_not[$i];
      $data2['notes']=$notes[$i];
      $query=$this->db->insert('pm_details',$data2);
 
    $i++;
    }
    //////////////////////////
    
    $data3=array();
    $data3['user_id']=$this->session->userdata('user_id');
    $data3['department_id']=$department_id;
    $data3['pm_status']='Pending';
    $data3['tpm_code']=$this->input->post('tpm_code');
    $data3['pm_date']=$this->input->post('next_pm_date');
    $data3['model_no']=$this->input->post('model_no');
    $data3['product_name']=$this->input->post('product_name');
    $query=$this->db->insert('pm_master',$data3);
   return $query;
  }
  function getworkdetail($pm_id){
    $department_id=$this->session->userdata('department_id');
    $result=$this->db->query("SELECT *
          FROM  pm_details  
          WHERE pm_id='$pm_id' AND department_id=$department_id
          ORDER BY id ASC")->result();
      return $result;

   }
   function getsdetail($sref_no){
    $result=$this->db->query("SELECT d.*,p.product_name
          FROM  spares_use_master sm
          INNER JOIN  spares_use_detail d ON(d.spares_use_id=sm.spares_use_id)  
          INNER JOIN  product_info p ON(d.product_id=p.product_id)  
          WHERE sm.using_ref_no='$sref_no' 
          ORDER BY d.spares_use_detail_id ASC")->result();
      return $result;

   }

}
