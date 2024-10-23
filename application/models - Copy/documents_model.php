<?php
class Documents_model extends CI_Model {
    function lists() {
    $department_id=$this->session->userdata('department_id');
    $result=$this->db->query("SELECT p.*
        FROM  comapny_document_info p
        WHERE  p.type=1 
        AND p.department_id=$department_id 
        ORDER BY p.document_id DESC ")->result();
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
        $data['date']=$this->input->post('date');
        $data['department_id']=$this->session->userdata('department_id');
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
