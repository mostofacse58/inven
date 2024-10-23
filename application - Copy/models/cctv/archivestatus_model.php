<?php
class Archivestatus_model extends CI_Model {
  public function get_count(){
    $condition=' ';
    if($_GET){
      if($this->input->get('asset_encoding')!=''){
        $asset_encoding=$this->input->get('asset_encoding');
        $condition=$condition."  AND (pd.asset_encoding LIKE '%$asset_encoding%' OR pd.ventura_code LIKE '%$asset_encoding%' OR p.product_code LIKE '%$asset_encoding%') ";
      }
     }
    $department_id=$this->session->userdata('department_id');
      $query=$this->db->query("SELECT ccs.* FROM cctv_maintain ccs
        INNER JOIN product_detail_info pd ON(ccs.product_detail_id=pd.product_detail_id)
        INNER JOIN product_info p ON(p.product_id=pd.product_id)
        WHERE ccs.cctv_status!=1  $condition");
      $data = count($query->result());
      return $data;
    }
  function lists($limit,$start) {
    $department_id=$this->session->userdata('department_id');
    $condition=' ';
    if($_GET){
      if($this->input->get('asset_encoding')!=''){
        $asset_encoding=$this->input->get('asset_encoding');
        $condition=$condition."  AND (pd.asset_encoding LIKE '%$asset_encoding%' OR pd.ventura_code LIKE '%$asset_encoding%' OR p.product_code LIKE '%$asset_encoding%') ";
      }
     }
     $result=$this->db->query("SELECT pd.*,pd.remarks as coveragearea,ccs.*,p.product_name,p.product_code,l.location_name
      FROM cctv_maintain ccs
      INNER JOIN product_detail_info pd ON(ccs.product_detail_id=pd.product_detail_id)
      INNER JOIN product_info p ON(p.product_id=pd.product_id)
      INNER JOIN location_info l ON(ccs.location_id=l.location_id)
      LEFT JOIN user u ON(u.id=ccs.create_id) 
      WHERE ccs.cctv_status!=1  $condition
      ORDER BY ccs.cctv_main_id DESC LIMIT $start,$limit")->result();
    return $result;
  }
    function get_info($cctv_main_id){
        $result=$this->db->query("SELECT ccs.*
          FROM cctv_maintain ccs
          WHERE  ccs.cctv_main_id=$cctv_main_id")->row();
        return $result;
    }
  
   function getlocation($product_detail_id) {
       $result=$this->db->query("SELECT l.location_name
          FROM asset_issue_master sim,location_info l
          WHERE sim.location_id=l.location_id AND sim.issue_status=1 
          AND sim.product_detail_id=$product_detail_id ")->row('location_name');
       if(count($result)>0)
        return $result;
       else return "";
    }

  
}
