<?php
class Files_model extends CI_Model {

    function lists(){
        
        $result=$this->db->query("SELECT *
            FROM shipping_file_style_info 
            ORDER BY id")->result();
        return $result;
    }

    
    function get_info($id){
        $result=$this->db->query("SELECT * FROM shipping_file_style_info 
            WHERE id=$id ")->row();
        return $result;
    }
    function save($id=FALSE){
        $data=array();
        $data['file_no']=$this->input->post('file_no');
        $data['user_id']=$this->session->userdata('user_id');
        $data['create_date']=date('Y-m-d');
        if($id==FALSE){
        $query=$this->db->insert('shipping_file_style_info',$data);
        }else{
          $this->db->WHERE('id',$id);
          $query=$this->db->update('shipping_file_style_info',$data);
        }
       return $query;
     
    }
    function delete($id) {
        $this->db->WHERE('id',$id);
        $query=$this->db->delete('shipping_file_style_info');
        return $query;
  }

  
}
