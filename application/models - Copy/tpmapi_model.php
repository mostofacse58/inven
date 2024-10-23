<?php
class Tpmapi_model extends CI_Model {
     function search($ventura_code) {
        $result=$this->db->query("SELECT pd.*,p.product_name,
        	p.product_code,p.china_name,
            ps.assign_date_time,ps.product_status_id,ps.machine_status,
            ps.from_location_name,ps.to_location_name
          FROM  product_status_info ps 
          INNER JOIN product_detail_info pd ON(pd.product_detail_id=ps.product_detail_id OR pd.ventura_code=ps.ventura_code) 
          INNER JOIN product_info p ON(p.product_id=pd.product_id)
          WHERE pd.department_id=12  AND ps.take_over_status=1
          AND (pd.tpm_serial_code='$ventura_code' OR pd.ventura_code='$ventura_code') ")->row();
        if(count($result)<1){
        $result=$this->db->query("SELECT pd.product_detail_id,
            p.product_name,p.china_name,
            pd.tpm_serial_code,pd.ventura_code,
            0 as product_status_id,
            'CENTRAL GODOWN' as to_location_name,
            pd.takeover_date as assign_date_time,
            pd.tpm_status as machine_status,
            p.product_name,p.product_code
            FROM product_detail_info pd
            INNER JOIN product_info p ON(pd.product_id=p.product_id)
            WHERE pd.department_id=12  
            AND (pd.tpm_serial_code='$ventura_code' 
                OR pd.ventura_code='$ventura_code')")->row();
            return $result;
        }
        return $result;
    }
    function assets($ventura_code) {
        $result=$this->db->query("SELECT pd.*,p.product_name,p.product_code,p.china_name,
          c.category_name,b.brand_name,d.department_name,e.employee_name,
          l.location_name,s.supplier_name
          FROM  product_detail_info pd 
          INNER JOIN product_info p ON(p.product_id=pd.product_id)
          INNER JOIN category_info c ON(p.category_id=c.category_id)
          LEFT JOIN brand_info b ON(p.brand_id=b.brand_id)
          LEFT JOIN supplier_info s ON(pd.supplier_id=s.supplier_id)
          LEFT JOIN asset_issue_master aim ON(pd.product_detail_id=aim.product_detail_id AND aim.take_over_status=1)
          LEFT JOIN location_info l ON(aim.location_id=l.location_id)
          LEFT JOIN department_info d ON(aim.take_department_id=d.department_id)
          LEFT JOIN employee_idcard_info e ON(aim.employee_id=e.employee_cardno)
          WHERE pd.ventura_code='$tpm_serial_code' OR pd.asset_encoding='$tpm_serial_code'")->row();
        return $result;
    }
  
    
   function location(){
      $result=$this->db->query("SELECT line_no FROM floorline_info 
        WHERE line_no!='EGM' ORDER BY line_no ASC")->result();
      return $result;
    }
    
    
 
}
