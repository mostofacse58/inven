<?php
class Tutorial_model extends CI_Model {

    function getmenu(){
            $result=$this->db->query("SELECT id,menu,title
            FROM sop_master
            WHERE 1
            ORDER BY id ASC")->result();
          return $result;
    }
     function getinfo($id){
            $result=$this->db->query("SELECT *
            FROM sop_master
            WHERE id=$id")->row();
          return $result;
    }
  
}
