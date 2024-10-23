<?php
class Finishedgoods_model extends CI_Model {
  public function get_count(){
    $condition=' ';
    if(isset($_POST)){
      if($this->input->post('style_no')!=''){
        $style_no=$this->input->post('style_no');
        $condition=$condition."  AND (pd.style_no='$style_no' OR pd.file_no='$style_no') ";
      }
     }
    $department_id=$this->session->userdata('department_id');
      $query=$this->db->query("SELECT * FROM finishedgoods_info pd
        WHERE pd.status=1 $condition");
      $data = count($query->result());
      return $data;
    }

  public  function lists($limit,$start){
       $condition=' ';
        if(isset($_POST)){
          if($this->input->post('style_no')!=''){
            $style_no=$this->input->post('style_no');
            $condition=$condition."  AND (pd.style_no='$style_no' OR pd.file_no='$style_no') ";
          }
         }
      $department_id=$this->session->userdata('department_id');
        $result=$this->db->query("SELECT pd.*
          FROM  finishedgoods_info pd 
          LEFT JOIN user u ON(u.id=pd.user_id) 
          WHERE  pd.status=1 $condition
          ORDER BY pd.file_no ASC LIMIT $start,$limit")->result();
    return $result;
 }
  public  function printsticker(){
    $result=$this->db->query("SELECT pd.*
      FROM  finishedgoods_info pd 
      LEFT JOIN user u ON(u.id=pd.user_id) 
      WHERE  pd.status=1
      ORDER BY pd.file_no ASC")->result();
    return $result;
 }

  function get_info($goods_id){
        $result=$this->db->query("SELECT pd.*
          FROM finishedgoods_info pd 
          LEFT JOIN user u ON(u.id=p.user_id) 
          WHERE  pd.goods_id=$goods_id")->row();
        return $result;
    }
   
    function save($goods_id) {
        $data=array();
        $data['file_no']=$this->input->post('file_no');
        $data['style_no']=$this->input->post('style_no');
        $data['color_name']=$this->input->post('color_name');
        $data['quantity']=$this->input->post('quantity');
        $data['floor_no']=$this->input->post('floor_no');
        $data['line_no']=$this->input->post('line_no');
        $data['user_id']=$this->session->userdata('user_id');
        $data['status']=1;
        $style_no=$this->input->post('style_no');
        if($goods_id==FALSE){
         $query=$this->db->insert('finishedgoods_info',$data);
        }else{
          $this->db->WHERE('goods_id',$goods_id);
         $query=$this->db->update('finishedgoods_info',$data);
        }
       return $query;
    }
  
    function delete($goods_id) {
        $this->db->WHERE('goods_id',$goods_id);
        $query=$this->db->delete('finishedgoods_info');
        return $query;
  }
  

  
}
