<?php
class License_model extends CI_Model {
  public function get_count(){
    $condition=' ';
    if($_POST){
        if($this->input->post('title_name')!=''){
          $title_name=$this->input->post('title_name');
          $condition=$condition."  AND p.title_name LIKE '%$title_name%'  ";
        }
      }
    $department_id=$this->session->userdata('department_id');
      $query=$this->db->query("SELECT * FROM comapny_document_info p
        WHERE p.type=2 AND p.department_id=$department_id $condition");
      $data = count($query->result());
      return $data;
    }

    function lists($limit,$start) {
      $department_id=$this->session->userdata('department_id');
      $condition=' ';
      if($_POST){
        if($this->input->post('title_name')!=''){
          $title_name=$this->input->post('title_name');
          $condition=$condition."  AND p.title_name LIKE '%$title_name%'  ";
        }
      // $this->session->set_userdata('itemsSearch',$condition);
      }
    if($this->session->userdata('itemsSearch')!=' '){
      //$condition=$this->session->userdata('itemsSearch');
    }

    $result=$this->db->query("SELECT p.*
        FROM  comapny_document_info p
        WHERE  p.type=2 AND p.department_id=$department_id $condition
        ORDER BY p.document_id DESC 
        LIMIT $start,$limit")->result();
      return $result;
    }
    ///////////

    function get_info($document_id){
      $department_id=$this->session->userdata('department_id');
        $result=$this->db->query("SELECT p.*
          FROM  comapny_document_info p
          WHERE p.department_id=$department_id 
          AND p.document_id=$document_id")->row();
        return $result;
    }
   
    function save($data,$document_id) {
        $data['title_name']=$this->input->post('title_name');
        $data['purchase_date']=$this->input->post('purchase_date');
        $data['expire_date']=$this->input->post('expire_date');
        $data['date']=$this->input->post('date');
        $data['department_id']=$this->session->userdata('department_id');
        $data['type']=2;
        $data['create_date']=date('Y-m-d');
        $data['description']=$this->input->post('description');
        if($document_id==FALSE){
          $data['created_by']=$this->session->userdata('user_id');
          $query=$this->db->insert('comapny_document_info',$data);
          $document_id=$this->db->insert_id();
        }else{
          $data['updated_by']=$this->session->userdata('user_id');
          $this->db->WHERE('document_id',$document_id);
          $query=$this->db->update('comapny_document_info',$data);
        }
      return $document_id;
    }
  
    function delete($document_id) {
        $this->db->WHERE('document_id',$document_id);
        $query=$this->db->delete('comapny_document_info');
        return $query;
  }


  
}
