<?php
class Checkout_model extends CI_Model {
 public function get_count(){
    $condition=' ';
    if(isset($_GET)){
      if($this->input->get('gatepass_no')!=''){
        $gatepass_no=$this->input->get('gatepass_no');
        $condition=$condition." AND g.gatepass_no LIKE '%$gatepass_no%' ";
      }
     }
      $department_id=$this->session->userdata('department_id');
      $data=$this->db->query("SELECT count(*) as counts FROM gatepass_master_stock g
        WHERE  g.gatepass_status>=4")->row('counts');
      
      return $data;
    }

  public  function lists($limit,$start){
    $condition=' ';
    if(isset($_GET)){
      if($this->input->get('gatepass_no')!=''){
      $gatepass_no=$this->input->get('gatepass_no');
      $condition=$condition." AND g.gatepass_no LIKE '%$gatepass_no%' ";
      }
     }
    $department_id=$this->session->userdata('department_id');
    $result=$this->db->query("SELECT g.*,u.user_name as created_by,
      u1.user_name as approved_by,d.department_name
      FROM  gatepass_master_stock g 
      INNER JOIN department_info d ON(g.department_id=d.department_id)
      LEFT JOIN user u ON(u.id=g.user_id)
      LEFT JOIN user u1 ON(u1.id=g.approved_by) 
      WHERE g.gatepass_status>=4
      ORDER BY g.gatepass_status ASC,g.create_date DESC  
      LIMIT $start,$limit")->result();
    return $result;
  }

  function checkoutBarcode(){
  	$gatepass_no=$this->input->post('gatepass_no');
    $result=$this->db->query("SELECT g.*,u.user_name as created_by,
    u1.user_name as approved_by,d.department_name
    FROM  gatepass_master_stock g 
    INNER JOIN department_info d ON(g.department_id=d.department_id)
    LEFT JOIN user u ON(u.id=g.user_id)
    LEFT JOIN user u1 ON(u1.id=g.approved_by) 
    WHERE g.gatepass_status=4 AND g.gatepass_no='$gatepass_no'")->row();
    return $result;
  }
  
  function get_info($gatepass_id){
      $result=$this->db->query("SELECT g.*,u.user_name as created_by,
      u1.user_name as approved_by,d.department_name
      FROM  gatepass_master_stock g 
      INNER JOIN department_info d ON(g.department_id=d.department_id)
      LEFT JOIN user u ON(u.id=g.user_id)
      LEFT JOIN user u1 ON(u1.id=g.approved_by) 
      WHERE g.gatepass_no='$gatepass_no'")->row();
      return $result;
    }
    function get_detail($gatepass_id){
    $result=$this->db->query("SELECT gd.*
          FROM  gatepass_details_stock gd 
          WHERE gd.gatepass_id=$gatepass_id")->result();
    return $result;
  }
  function checkinInproduct(){
      $gatepass_no=$this->input->post('gatepass_no');
      $result=$this->db->query("SELECT g.*,u.user_name as checked_by_name,
      u1.user_name as approved_by_name,d.department_name
      FROM  gatepass_master_stock g 
      INNER JOIN department_info d ON(g.department_id=d.department_id)
      LEFT JOIN user u ON(u.id=g.checked_by)
      LEFT JOIN user u1 ON(u1.id=g.approved_by) 
      WHERE g.gatepass_status=5 AND g.gatepass_no='$gatepass_no'")->row();
      return $result;
    }
  function get_detailIn($gatepass_id){
    $result=$this->db->query("SELECT gd.*,
          (gd.product_quantity-(SELECT IFNULL(SUM(gid.return_qty),0) FROM gatein_details gid 
          WHERE gd.detail_id=gid.detail_id)) as qty
          FROM  gatepass_details_stock gd 
          WHERE gd.gatepass_type=1 AND (gd.product_quantity-(SELECT IFNULL(SUM(gid.return_qty),0) FROM gatein_details gid 
          WHERE gd.detail_id=gid.detail_id))>0 AND
          gd.gatepass_id=$gatepass_id")->result();
    return $result;
  }
function saveIn($gatepass_id){
  $detail_id=$this->input->post('detail_id');
  $return_qty=$this->input->post('return_qty');
  $i=0;
  foreach ($detail_id as $value) {
    $data2['gatepass_id']=$gatepass_id;
    $data2['detail_id']=$value;
    $data2['return_qty']=$return_qty[$i];
    $data2['date_time']=date('Y-m-d h:i:a');
    if($return_qty[$i]>0){
      $query=$this->db->insert('gatein_details',$data2);
    }
  $i++;
  }
 return $query;

} 
public function get_count2(){
    $condition=' ';
    if(isset($_GET)){
      if($this->input->get('gatepass_no')!=''){
        $gatepass_no=$this->input->get('gatepass_no');
        $condition=$condition." AND g.gatepass_no LIKE '%$gatepass_no%' ";
      }
     }
      $department_id=$this->session->userdata('department_id');
      $query=$this->db->query("SELECT * FROM gatepass_master_stock g
        WHERE g.department_id=$department_id 
        AND g.gatepass_status>=5");
      $data = count($query->result());
      return $data;
    }

  public  function lists2($limit,$start){
    $condition=' ';
    if(isset($_GET)){
      if($this->input->get('gatepass_no')!=''){
      $gatepass_no=$this->input->get('gatepass_no');
      $condition=$condition." AND g.gatepass_no LIKE '%$gatepass_no%' ";
      }
     }
    $department_id=$this->session->userdata('department_id');
    $result=$this->db->query("SELECT g.*,u.user_name as created_by,
      u1.user_name as approved_by,d.department_name
      FROM  gatepass_master_stock g 
      INNER JOIN department_info d ON(g.department_id=d.department_id)
      LEFT JOIN user u ON(u.id=g.user_id)
      LEFT JOIN user u1 ON(u1.id=g.approved_by) 
      WHERE g.department_id=$department_id 
      AND g.gatepass_status>=5
      ORDER BY g.gatepass_id DESC 
      LIMIT $start,$limit")->result();
    return $result;
  }
    
   

  
}
