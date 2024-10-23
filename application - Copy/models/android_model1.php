<?php
class Android_model1 extends CI_Model {
     function search($tpm_serial_code) {
        $result=$this->db->query("SELECT pd.*,
          p.product_name,
          p.product_code,p.china_name,
          c.category_name,mt.machine_type_name,
          b.brand_name,fl.line_no,s.supplier_name
          FROM  product_detail_info pd 
          INNER JOIN product_info p ON(p.product_id=pd.product_id)
          INNER JOIN category_info c ON(p.category_id=c.category_id)
          LEFT JOIN machine_type mt ON(p.machine_type_id=mt.machine_type_id)
          LEFT JOIN brand_info b ON(p.brand_id=b.brand_id)
          LEFT JOIN supplier_info s ON(pd.supplier_id=s.supplier_id)
          LEFT JOIN floorline_info fl ON(pd.line_id=fl.line_id)
          WHERE pd.department_id=12 AND 
           (pd.tpm_serial_code='$tpm_serial_code' 
            OR pd.ventura_code='$tpm_serial_code') ")->row();
        return $result;
    }

    function assets($tpm_serial_code) {
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
   function getdowntime($tpm_serial_code) {
        $result=$this->db->query("SELECT  md.*,ps.takeover_date,ps.takeover_date,
          fl.line_no,s.supervisor_name,m.me_name
          FROM machine_downtime_info md 
          INNER JOIN product_status_info ps ON(md.product_status_id=ps.product_status_id)
          INNER JOIN floorline_info fl ON(ps.line_id=fl.line_id)
          INNER JOIN product_detail_info pd ON(ps.product_detail_id=pd.product_detail_id)
          LEFT JOIN supervisor_info s ON(md.supervisor_id=s.supervisor_id)
          LEFT JOIN me_info m ON(md.me_id=m.me_id)
          WHERE pd.tpm_serial_code LIKE '$tpm_serial_code' OR pd.ventura_code LIKE '$tpm_serial_code' ")->result();
        return $result;
    }
   public function getUseSparesList($tpm_serial_code) {
    $result=$this->db->query("SELECT  p.*,sd.*,u.unit_name,
          sm.use_date,sm.using_ref_no,fl.line_no
          FROM spares_use_detail sd 
          INNER JOIN spares_use_master sm ON(sd.spares_use_id=sm.spares_use_id)
          INNER JOIN product_detail_info pd ON(sm.product_detail_id=pd.product_detail_id)
          INNER JOIN product_info p ON(sd.product_id=p.product_id)
          INNER JOIN product_unit u ON(p.unit_id=u.unit_id)
          LEFT JOIN floorline_info fl ON(sm.line_id=fl.line_id)
          LEFT JOIN me_info m ON(sm.me_id=m.me_id)
          WHERE pd.tpm_serial_code='$tpm_serial_code' OR pd.ventura_code='$tpm_serial_code' ")->result();
        return $result;
   }
   function prints(){
    $result=$this->db->query("SELECT pd.*,p.product_name,p.product_code
          FROM  product_detail_info pd 
          INNER JOIN product_info p ON(p.product_id=pd.product_id)
          WHERE pd.department_id=12 
          ORDER BY pd.ventura_code ASC LIMIT 0,10")->result();
    return $result;
   }
    
 
}
