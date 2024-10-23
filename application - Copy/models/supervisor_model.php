<?php
class Supervisor_model extends CI_Model {

    function lists(){
        $result=$this->db->query("SELECT m.*,p.post_name
            FROM supervisor_info m,post p
            WHERE m.post_id=p.post_id 
            ORDER BY m.supervisor_id")->result();
        return $result;
    }

    
    function get_info($supervisor_id){
        $result=$this->db->query("SELECT * FROM supervisor_info 
            WHERE supervisor_id=$supervisor_id")->row();
        return $result;
    }
    function save($supervisor_id=FALSE){
        $data=array();
        $data['supervisor_name']=$this->input->post('supervisor_name');
        $data['post_id']=$this->input->post('post_id');
        $data['mobile_no']=$this->input->post('mobile_no');
        $data['id_no']=$this->input->post('id_no');
        $data['user_id']=$this->session->userdata('user_id');
        if($supervisor_id==FALSE){
        $query=$this->db->insert('supervisor_info',$data);
        }else{
          $this->db->WHERE('supervisor_id',$supervisor_id);
          $query=$this->db->update('supervisor_info',$data);
        }
       return $query;
     
    }
    function delete($supervisor_id) {
        $this->db->WHERE('supervisor_id',$supervisor_id);
        $query=$this->db->delete('supervisor_info');
        return $query;
  }

  
}
