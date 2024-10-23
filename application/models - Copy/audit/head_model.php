<?php
class Head_model extends CI_Model {

    function lists(){
        
        $result=$this->db->query("SELECT *
            FROM audit_head 
            ORDER BY head_id")->result();
        return $result;
    }

    
    function get_info($head_id){
        $result=$this->db->query("SELECT * FROM audit_head 
            WHERE head_id=$head_id ")->row();
        return $result;
    }
    function save($head_id=FALSE){
        
        $data=array();
        $data['head_name']=$this->input->post('head_name');
        $data['user_id']=$this->session->userdata('user_id');
        $data['create_date']=date('Y-m-d');
        if($head_id==FALSE){
        $query=$this->db->insert('audit_head',$data);
        }else{
          $this->db->WHERE('head_id',$head_id);
          $query=$this->db->update('audit_head',$data);
        }
       return $query;
     
    }
    function delete($head_id) {
        $this->db->WHERE('head_id',$head_id);
        $query=$this->db->delete('audit_head');
        return $query;
  }

  
}
