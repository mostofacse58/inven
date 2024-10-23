<?php
class Laptopinout_model extends CI_Model {
    function checkingBarcode(){
      $sn_no=$this->input->post('sn_no');
      $result=$this->db->query("SELECT l.*,e.*
      FROM  laptop_info l
      LEFT JOIN  employee_info e ON(l.employee_id=e.employee_id)
      WHERE  l.sn_no='$sn_no'  AND l.status=1")->row();
      return $result;
    }
     function checkOutlaptop(){
      $sn_no=$this->input->post('sn_no');
      $result=$this->db->query("SELECT g.*
        FROM  gatepass_laptop g 
        INNER JOIN  laptop_info l ON(g.laptop_id=l.laptop_id)
        WHERE l.sn_no='$sn_no' AND g.gatepass_status=1 AND 
        g.gatepass_date!='' ")->row();
      return $result;
    }
    function checkINlaptop(){
      $sn_no=$this->input->post('sn_no');
      $result=$this->db->query("SELECT g.*
        FROM  gatepass_laptop g 
        INNER JOIN  laptop_info l ON(g.laptop_id=l.laptop_id)
        WHERE l.sn_no='$sn_no' AND g.gatepass_status=2 AND 
        g.gatepass_date!='' 
        ORDER BY g.gatepass_id DESC")->row();
      //print_r($result); exit();
      return $result;
    }
    function get_detail($gatepass_id){
    $result=$this->db->query("SELECT gd.*,u.unit_name
          FROM  gatepass_details gd 
          INNER JOIN product_unit u ON(gd.unit_id=u.unit_id)
          WHERE gd.gatepass_id=$gatepass_id")->result();
    return $result;
  }
  function checkingInproduct(){
      $sn_no=$this->input->post('sn_no');
      $result=$this->db->query("SELECT g.*,u.user_name as created_by,
      u1.user_name as approved_by,i.*,d.department_name
      FROM  gatepass_laptop g 
      INNER JOIN  laptop_info i ON(g.laptop_id=i.laptop_id)
      INNER JOIN department_info d ON(g.department_id=d.department_id)
      LEFT JOIN user u ON(u.id=g.user_id)
      LEFT JOIN user u1 ON(u1.id=g.approved_by) 
      WHERE g.gatepass_status=4 AND g.sn_no='$sn_no'")->row();
      return $result;
    }
  function get_detailIn($gatepass_id){
    $result=$this->db->query("SELECT gd.*,u.unit_name,
          (gd.product_quantity-(SELECT IFNULL(SUM(gid.return_qty),0) FROM gatein_details gid 
          WHERE gd.detail_id=gid.detail_id)) as qty
          FROM  gatepass_details gd,product_unit u 
          WHERE gd.unit_id=u.unit_id AND gd.returnable=2 AND (gd.product_quantity-(SELECT IFNULL(SUM(gid.return_qty),0) FROM gatein_details gid 
          WHERE gd.detail_id=gid.detail_id))>0 AND
          gd.gatepass_id=$gatepass_id")->result();
    return $result;
  }

 
}
