<?php
class Me_model extends CI_Model {

    function lists(){
        $department_id=$this->session->userdata('department_id');
        $result=$this->db->query("SELECT m.*,p.post_name
            FROM me_info m,post p
            WHERE m.post_id=p.post_id AND m.department_id=$department_id
            ORDER BY m.me_id")->result();
        return $result;
    }

    
    function get_info($me_id){
        $department_id=$this->session->userdata('department_id');
        $result=$this->db->query("SELECT * FROM me_info 
            WHERE me_id=$me_id AND m.department_id=$department_id")->row();
        return $result;
    }
    function save($me_id=FALSE){
        $data=array();
        $data['me_name']=$this->input->post('me_name');
        $data['post_id']=$this->input->post('post_id');
        $data['mobile_no']=$this->input->post('mobile_no');
        $data['id_no']=$this->input->post('id_no');
        $data['user_id']=$this->session->userdata('user_id');
        $data['department_id']=$this->session->userdata('department_id');
        if($me_id==FALSE){
        $query=$this->db->insert('me_info',$data);
        }else{
          $this->db->WHERE('me_id',$me_id);
          $query=$this->db->update('me_info',$data);
        }
       return $query;
     
    }
    function delete($me_id) {
        $this->db->WHERE('me_id',$me_id);
        $query=$this->db->delete('me_info');
        return $query;
  }

  
}
