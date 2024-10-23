<?php
class Maintenance_model extends CI_Model {
  public function get_count(){
    $condition=' ';
    if($_GET){
      if($this->input->get('asset_encoding')!=''){
        $asset_encoding=$this->input->get('asset_encoding');
        $condition=$condition."  AND (pd.asset_encoding LIKE '%$asset_encoding%' OR pd.ventura_code LIKE '%$asset_encoding%' OR p.product_code LIKE '%$asset_encoding%') ";
      }
      
     }
    $department_id=$this->session->userdata('department_id');
      $query=$this->db->query("SELECT sim.* 
        FROM maintenance_history sim
        INNER JOIN product_detail_info pd ON(sim.asset_encoding=pd.asset_encoding OR sim.asset_encoding=pd.ventura_code)
        INNER JOIN product_info p ON(p.product_id=pd.product_id)
        WHERE 1  $condition");
      $data = count($query->result());
      return $data;
  }

  public function lists($limit,$start) {
    $department_id=$this->session->userdata('department_id');
    $condition=' ';
    if($_GET){
      if($this->input->get('asset_encoding')!=''){
        $asset_encoding=$this->input->get('asset_encoding');
        $condition=$condition."  AND (pd.asset_encoding LIKE '%$asset_encoding%' OR pd.ventura_code LIKE '%$asset_encoding%' OR p.product_code LIKE '%$asset_encoding%') ";
      }
      if($this->input->get('location_name')!=''){
        $location_name=$this->input->get('location_name');
        $condition=$condition."  AND sim.location_name='$location_name' ";
      }
     }
     $result=$this->db->query("SELECT pd.*,sim.*,p.product_name,p.product_code,c.category_name
      FROM maintenance_history sim
      LEFT JOIN product_detail_info pd ON(sim.asset_encoding=pd.asset_encoding OR sim.asset_encoding=pd.ventura_code)
      LEFT JOIN product_info p ON(p.product_id=pd.product_id)
      LEFT JOIN category_info c ON(p.category_id=c.category_id)
      LEFT JOIN user u ON(u.id=sim.user_id) 
      WHERE 1 $condition
      ORDER BY sim.maintenance_id DESC LIMIT $start,$limit")->result();
    return $result;
  }
  public function get_info($maintenance_id){
        $result=$this->db->query("SELECT pd.*,sim.*,p.product_name,p.product_code,
          c.category_name
          FROM maintenance_history sim
          LEFT JOIN product_detail_info pd ON(sim.asset_encoding=pd.asset_encoding OR sim.asset_encoding=pd.ventura_code)
          LEFT JOIN product_info p ON(p.product_id=pd.product_id)
          LEFT JOIN category_info c ON(p.category_id=c.category_id)
          LEFT JOIN user u ON(u.id=sim.user_id) 
          WHERE 1 AND sim.maintenance_id=$maintenance_id")->row();
        return $result;
    }
  
  public function save($maintenance_id) {
    $department_id=$this->session->userdata('department_id');
      $data=array();
      $data['category_id']=$this->input->post('category_id');
      $data['asset_encoding']=$this->input->post('asset_encoding');
      $data['date']=alterDateFormat($this->input->post('date'));
      $data['next_service_date']=alterDateFormat($this->input->post('next_service_date'));
      $data['location_name']=$this->input->post('location_name');
      $data['work_note']=$this->input->post('work_note');
      $data['team_member']=$this->input->post('team_member');
      $data['team_member2']=$this->input->post('team_member2');
      $data['spare_parts']=$this->input->post('spare_parts');
      $data['customer_review']=$this->input->post('customer_review');
      $data['user_id']=$this->session->userdata('user_id');
      if($maintenance_id==FALSE){
        $query=$this->db->insert('maintenance_history',$data);
        ///////////////////////
      }else{
        $this->db->WHERE('maintenance_id',$maintenance_id);
        $query=$this->db->update('maintenance_history',$data);
      }
    return $query;
  }
  public function getCategory(){
   $data = $this->db->query("SELECT * FROM category_info 
          WHERE 1")->result();
     return $data ;
  }
  public function delete($maintenance_id) {
        $this->db->WHERE('maintenance_id',$maintenance_id);
        $query=$this->db->delete('maintenance_history');
        return $query;
    }
  

  
}
