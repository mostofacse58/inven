<?php
class ditem_model extends CI_Model {

    function lists(){
        $result=$this->db->query("SELECT c.*
        FROM manual_products c
        WHERE 1
        ORDER BY c.id")->result();
        return $result;
    }

    
    function get_info($id){
        $result=$this->db->query("SELECT * FROM manual_products 
            WHERE id=$id")->row();
        return $result;
    }
    function save($id=FALSE){
        $data=array();
        $data['product_name']=strtoupper($this->input->post('product_name'));
        $data['unit']=$this->input->post('unit');
        $data['unit_price']=$this->input->post('unit_price');
        $data['affected']=$this->input->post('affected');
        if($id==FALSE){
        $query=$this->db->insert('manual_products',$data);
        }else{
          $this->db->WHERE('id',$id);
          $query=$this->db->update('manual_products',$data);
        }
       return $query;
     
    }
    function delete($id) {
        $this->db->WHERE('id',$id);
        $query=$this->db->delete('manual_products');
        return $query;
  }

  
}
