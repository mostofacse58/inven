<?php
class Material_model extends CI_Model {

    function lists(){
        $result=$this->db->query("SELECT a.*
            FROM material_info a 
            ORDER BY a.mtype_id")->result();
        return $result;
    }

    
    function get_info($mtype_id){
        $result=$this->db->query("SELECT * FROM material_info 
            WHERE mtype_id=$mtype_id")->row();
        return $result;
    }
    function save($mtype_id=FALSE){
        $data=array();
        $data['mtype_name']=$this->input->post('mtype_name');
        $data['user_id']=$this->session->userdata('user_id');
        if($mtype_id==FALSE){
        $query=$this->db->insert('material_info',$data);
        }else{
          $this->db->WHERE('mtype_id',$mtype_id);
          $query=$this->db->update('material_info',$data);
        }
       return $query;
     
    }
    function delete($mtype_id) {
        $this->db->WHERE('mtype_id',$mtype_id);
        $query=$this->db->delete('material_info');
        return $query;
  }

  
}
