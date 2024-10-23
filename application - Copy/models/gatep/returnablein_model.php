<?php
class Returnablein_model extends CI_Model {
 public function get_count(){
    $condition=' ';
    if(isset($_GET)){
      if($this->input->get('gatepass_no')!=''){
        $gatepass_no=$this->input->get('gatepass_no');
        $condition=$condition." AND g.gatepass_no LIKE '%$gatepass_no%' ";
      }
     }

    $user_id=$this->session->userdata('user_id');
      if($user_id==143){
        $condition=$condition." AND  (g.wh_whare='SFB-01' OR g.wh_whare='CDF') ";
      }elseif($user_id==125){
        $condition=$condition." AND  g.wh_whare='MSSFB-3' ";
      }elseif($user_id==157){
        $condition=$condition." AND  g.wh_whare='CGN' ";
      }elseif($user_id==172){
        $condition=$condition." AND  g.wh_whare='VD' ";
      }else{
        $condition=$condition." AND  g.wh_whare='Ventura' ";
      }

    $query=$this->db->query("SELECT * FROM gatepass_master g
        WHERE g.gatepass_type=1
        AND g.gatepass_status>=5 
        AND g.gatepass_type=1 $condition");
      $data = count($query->result());
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
      u1.user_name as approved_by,i.*,d.department_name
      FROM  gatepass_master g 
      LEFT JOIN  issue_to_master i ON(g.issue_to=i.issue_to)
      INNER JOIN department_info d ON(g.department_id=d.department_id)
      LEFT JOIN user u ON(u.id=g.user_id)
      LEFT JOIN user u1 ON(u1.id=g.approved_by) 
      WHERE g.gatepass_status>=5 
      AND g.gatepass_type=1 $condition
      ORDER BY g.returnable_status ASC,g.create_date DESC 
      LIMIT $start,$limit")->result();
    return $result;
  }

  function checkingBarcode(){
  	$gatepass_no=$this->input->post('gatepass_no');
    $result=$this->db->query("SELECT g.*,u.user_name as created_by,
    u1.user_name as approved_by,i.*,d.department_name
    FROM  gatepass_master g 
    LEFT JOIN  issue_to_master i ON(g.issue_to=i.issue_to)
    INNER JOIN department_info d ON(g.department_id=d.department_id)
    LEFT JOIN user u ON(u.id=g.user_id)
    LEFT JOIN user u1 ON(u1.id=g.approved_by) 
    WHERE g.gatepass_status>=5 AND g.gatepass_type=1 AND g.gatepass_no='$gatepass_no'")->row();
    return $result;
  }
  
 
  function checkingInproduct(){
      $gatepass_no=$this->input->post('gatepass_no');
      $result=$this->db->query("SELECT g.*,u.user_name as checked_by_name,
      u1.user_name as approved_by_name,i.*,d.department_name
      FROM  gatepass_master g 
      LEFT JOIN  issue_to_master i ON(g.issue_to=i.issue_to)
      INNER JOIN department_info d ON(g.department_id=d.department_id)
      LEFT JOIN user u ON(u.id=g.checked_by)
      LEFT JOIN user u1 ON(u1.id=g.approved_by) 
      WHERE g.gatepass_status=4 AND g.gatepass_no='$gatepass_no'")->row();
      return $result;
    }
  function get_detailIn($gatepass_id){
    $result=$this->db->query("SELECT gd.*,
          (gd.product_quantity-(SELECT IFNULL(SUM(gid.return_qty),0) FROM gatein_details gid 
          WHERE gd.detail_id=gid.detail_id)) as qty
          FROM  gatepass_details gd 
          WHERE gd.gatepass_type=1 AND (gd.product_quantity-(SELECT IFNULL(SUM(gid.return_qty),0) FROM gatein_details gid 
          WHERE gd.detail_id=gid.detail_id))>0 AND
          gd.gatepass_id=$gatepass_id")->result();
    return $result;
  }
  function get_detail($gatepass_id){
    $result=$this->db->query("SELECT gd.*,(SELECT IFNULL(SUM(gid.return_qty),0) 
          FROM gatein_details gid 
          WHERE gd.detail_id=gid.detail_id AND gd.gatepass_id=gid.gatepass_id) as qty
          FROM  gatepass_details gd 
          WHERE gd.gatepass_id=$gatepass_id")->result();
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
      $data2['user_name']=$this->session->userdata('user_name');
      if($return_qty[$i]>0){
        $query=$this->db->insert('gatein_details',$data2);
      }
    $i++;
    }
    $this->checkallin();
   return $query;
  } 

  function checkallin(){
    $result=$this->db->query("SELECT g.*,
          (SELECT IFNULL(SUM(gd.product_quantity),0) 
          FROM gatepass_details gd 
          WHERE gd.gatepass_id=g.gatepass_id) as outqty,
          (SELECT IFNULL(SUM(gid.return_qty),0) 
          FROM gatein_details gid 
          WHERE g.gatepass_id=gid.gatepass_id) as inqty
          FROM  gatepass_master g 
          WHERE g.returnable_status=1 
          AND g.gatepass_type=1")->result();
    foreach($result as  $value) {
      if($value->outqty==$value->inqty){
        $data['returnable_status']=2;
        $this->db->WHERE('gatepass_id',$value->gatepass_id);
        $result=$this->db->update('gatepass_master',$data);
      }
    }
    return $result;
  }
  function saveComments($gatepass_id){
      $data2['gatepass_id']=$gatepass_id;
      $data2['comments']=$this->input->post('comments');
      $data2['date_time']=date('Y-m-d h:i:a');
      $data2['user_name']=$this->session->userdata('user_name');
      $query=$this->db->insert('gatein_comments',$data2);
    return $query;
  } 

}
