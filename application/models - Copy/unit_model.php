<?php
class Unit_model extends CI_Model {

    function lists(){
        $result=$this->db->query("SELECT *
            FROM product_unit  
            ORDER BY unit_id")->result();
        return $result;
    }

    function get_info($unit_id){
        $result=$this->db->query("SELECT * FROM product_unit 
            WHERE unit_id=$unit_id")->row();
        return $result;
    }
    function save($unit_id=FALSE){
        $data=array();
        $data['unit_name']=$this->input->post('unit_name');
        if($unit_id==FALSE){
        $query=$this->db->insert('product_unit',$data);
        }else{
          $this->db->WHERE('unit_id',$unit_id);
          $query=$this->db->update('product_unit',$data);
        }
       return $query;
     
    }
    function delete($unit_id) {
        $this->db->WHERE('unit_id',$unit_id);
        $query=$this->db->delete('product_unit');
        return $query;
  }
  function serial(){
    $result=$this->db->query("SELECT pd.*
          FROM  product_detail_info pd 
          WHERE pd.department_id=12 
          ORDER BY pd.code_count ASC")->result();
    return $result;
  }
  
}
