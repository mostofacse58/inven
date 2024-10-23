<?php
class Sop_model extends CI_Model {
  public function get_count(){
    $condition=' ';
    if($_POST){
      if($this->input->post('title')!=''){
        $title=$this->input->post('title');
        $condition=$condition."  AND p.title LIKE '%$title%'  ";
      }
    }
    $department_id=$this->session->userdata('department_id');
      $query=$this->db->query("SELECT * FROM sop_master p
        WHERE  p.department_id=$department_id 
        $condition");
      $data = count($query->result());
      return $data;
    }
    function lists($limit,$start) {
      $department_id=$this->session->userdata('department_id');
      $condition=' ';
      if($_POST){
        if($this->input->post('title')!=''){
          $title=$this->input->post('title');
          $condition=$condition."  AND p.title LIKE '%$title%'  ";
        }
      }
    $result=$this->db->query("SELECT p.*
        FROM  sop_master p
        WHERE  p.department_id=$department_id 
        $condition
        ORDER BY p.id DESC 
        LIMIT $start,$limit")->result();
      return $result;
    }
    ///////////
    function get_info($id){
      $department_id=$this->session->userdata('department_id');
      $result=$this->db->query("SELECT p.*
        FROM  sop_master p
        WHERE p.department_id=$department_id 
        AND p.id=$id")->row();
      return $result;
    }
    function save($id) {
        $data['title']=$this->input->post('title');
        $data['menu']=$this->input->post('menu');
        $data['description']=$this->input->post('description');
        $data['department_id']=$this->session->userdata('department_id');
        $data['create_date']=date('Y-m-d');
        if($_FILES['file_1']['name']!=""){
          $config1['upload_path'] = './sop/';
          $config1['allowed_types'] = 'jpg|jpeg|png|PNG|JPEG|JPG';
          $config1['max_size'] = '150000';
          $config1['encrypt_name'] = TRUE;
          $config1['detect_mime'] = TRUE;
          $this->load->library('upload', $config1);
          if ($this->upload->do_upload("file_1")){
          $upload_info1 = $this->upload->data();
          $data['file_1']=$upload_info1['file_name'];
        }
      }
        if($_FILES['file_2']['name']!=""){
          $config1['upload_path'] = './sop/';
          $config1['allowed_types'] = 'jpg|jpeg|png|PNG|JPEG|JPG';
          $config1['max_size'] = '150000';
          $config1['encrypt_name'] = TRUE;
          $config1['detect_mime'] = TRUE;
          $this->load->library('upload', $config1);
          if ($this->upload->do_upload("file_2")){
          $upload_info1 = $this->upload->data();
          $data['file_2']=$upload_info1['file_name'];
        }
      }
        if($_FILES['file_3']['name']!=""){
          $config1['upload_path'] = './sop/';
          $config1['allowed_types'] = 'jpg|jpeg|png|PNG|JPEG|JPG';
          $config1['max_size'] = '150000';
          $config1['encrypt_name'] = TRUE;
          $config1['detect_mime'] = TRUE;
          $this->load->library('upload', $config1);
          if ($this->upload->do_upload("file_3")){
          $upload_info1 = $this->upload->data();
          $data['file_3']=$upload_info1['file_name'];
        }
      }
        if($id==FALSE){
          $data['user_id']=$this->session->userdata('user_id');
          $query=$this->db->insert('sop_master',$data);
          $id=$this->db->insert_id();
        }else{
          $this->db->WHERE('id',$id);
          $query=$this->db->update('sop_master',$data);
        }
      return $id;
    }
  
    function delete($id) {
        $this->db->WHERE('id',$id);
        $query=$this->db->delete('sop_master');
        return $query;
  }


  
}
