<?php
class Assetdetail_model extends CI_Model {
    function search() {
        $ventura_code=$this->input->post('ventura_code');
        $result=$this->db->query("SELECT pd.*,p.product_name,p.china_name,p.product_code,
          p.product_image,c.category_name,b.brand_name,s.supplier_name,e.employee_name,aim.employee_id
          FROM  product_detail_info pd 
          INNER JOIN product_info p ON(p.product_id=pd.product_id)
          INNER JOIN category_info c ON(p.category_id=c.category_id)
          LEFT JOIN supplier_info s ON(pd.supplier_id=s.supplier_id)
          LEFT JOIN brand_info b ON(p.brand_id=b.brand_id)
          LEFT JOIN user u ON(u.id=p.user_id) 
          LEFT JOIN asset_issue_master aim ON(pd.product_detail_id=aim.product_detail_id AND aim.entry_check=1)
          LEFT JOIN employee_idcard_info e ON(aim.employee_id=e.employee_cardno)
          WHERE 1 AND (pd.asset_encoding='$ventura_code' OR pd.ventura_code='$ventura_code')")->row();
        return $result;
      }
   function movementhistory() {
      $ventura_code=$this->input->post('ventura_code');
      $result=$this->db->query("SELECT  aim.*,pd.*,
        l.location_name,d.department_name,e.employee_name
        FROM asset_issue_master aim 
        INNER JOIN product_detail_info pd ON(aim.product_detail_id=pd.product_detail_id)
        LEFT JOIN employee_idcard_info e ON(aim.employee_id=e.employee_cardno)
        LEFT JOIN location_info l ON(aim.location_id=l.location_id)
        LEFT JOIN department_info d ON(aim.take_department_id=d.department_id)
        WHERE (pd.asset_encoding='$ventura_code' OR pd.ventura_code='$ventura_code')
        ORDER BY aim.issue_date ASC ")->result();
      return $result;
    }
   public function getSparesList() {
    $ventura_code=$this->input->post('ventura_code');
    $result=$this->db->query("SELECT  p.*,sd.*,
        u.unit_name,sm.*
        FROM item_issue_detail sd 
        INNER JOIN store_issue_master sm ON(sd.issue_id=sm.issue_id)
        INNER JOIN product_detail_info pd ON(sm.product_detail_id=pd.product_detail_id)
        INNER JOIN product_info p ON(sd.product_id=p.product_id)
        INNER JOIN product_unit u ON(p.unit_id=u.unit_id)
        WHERE pd.asset_encoding='$ventura_code' OR pd.ventura_code='$ventura_code' ")->result();
      return $result;
   }
   function servicinghistory($ventura_code) {
      $result=$this->db->query("SELECT  g.*,pd.*
        FROM gatepass_costing g 
        INNER JOIN product_detail_info pd ON(g.product_detail_id=pd.product_detail_id)
        WHERE (pd.asset_encoding='$ventura_code' OR pd.ventura_code='$ventura_code') ")->result();
      return $result;
    }
  function gatepassHistory($ventura_code) {
      $result=$this->db->query("SELECT  gd.product_code,gd.product_name,
        gd.product_quantity,gd.remarks,
        g.*,i.issue_to_name
        FROM gatepass_details gd 
        INNER JOIN gatepass_master g ON(g.gatepass_id=gd.gatepass_id)
        LEFT JOIN  issue_to_master i ON(g.issue_to=i.issue_to)
        WHERE (gd.product_code='$ventura_code' OR gd.remarks LIKE '%$ventura_code%') AND g.gatepass_status>=4 ")->result();
      return $result;
    }
  
  // function gatepassHistory($ventura_code) {
  //     $result=$this->db->query("SELECT  gd.product_code,gd.product_name,
  //       gd.product_quantity,gd.remarks,
  //       pd.ventura_code,pd.asset_encoding,
  //       g.*,i.issue_to_name
  //       FROM gatepass_details gd 
  //       INNER JOIN gatepass_master g ON(g.gatepass_id=gd.gatepass_id)
  //       LEFT JOIN  issue_to_master i ON(g.issue_to=i.issue_to)
  //       INNER JOIN product_detail_info pd ON(gd.product_code=pd.ventura_code OR gd.product_code=pd.asset_encoding)
  //       WHERE (gd.product_code='$ventura_code' OR gd.remarks LIKE '%$ventura_code%') AND g.gatepass_status>=4 ")->result();
  //     return $result;
  //   }
}
