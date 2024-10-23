<?php
class Season_model extends CI_Model {

    function lists(){
        
        $result=$this->db->query("SELECT *
            FROM shipping_season_info 
            ORDER BY id")->result();
        return $result;
    }

    
    function get_info($id){
        $result=$this->db->query("SELECT * FROM shipping_season_info 
            WHERE id=$id ")->row();
        return $result;
    }
    function save($id=FALSE){
        $data=array();
        $data['season']=$this->input->post('season');
        $data['user_id']=$this->session->userdata('user_id');
        $data['create_date']=date('Y-m-d');
        if($id==FALSE){
        $query=$this->db->insert('shipping_season_info',$data);
        }else{
          $this->db->WHERE('id',$id);
          $query=$this->db->update('shipping_season_info',$data);
        }
       return $query;
     
    }
    function delete($id) {
        $this->db->WHERE('id',$id);
        $query=$this->db->delete('shipping_season_info');
        return $query;
  }

  
}
