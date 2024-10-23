<?php
class Archievemachine_model extends CI_Model {
    function lists() {
        $department_id=$this->session->userdata('department_id');
        $result=$this->db->query("SELECT ps.*,pd.*,p.product_name,p.product_code,
          c.category_name,mt.machine_type_name,fl.line_no
          FROM product_status_info ps
          INNER JOIN floorline_info fl ON(ps.line_id=fl.line_id)
          INNER JOIN product_detail_info pd ON(ps.product_detail_id=pd.product_detail_id)
          INNER JOIN product_info p ON(p.product_id=pd.product_id)
          INNER JOIN category_info c ON(p.category_id=c.category_id)
          LEFT JOIN machine_type mt ON(p.machine_type_id=mt.machine_type_id)
          LEFT JOIN user u ON(u.id=ps.user_id) 
          WHERE ps.take_over_status=2 
          ORDER BY ps.product_status_id DESC")->result();
        return $result;
    }
   

  
}
