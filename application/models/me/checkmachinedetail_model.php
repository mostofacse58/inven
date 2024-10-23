<?php
class Checkmachinedetail_model extends CI_Model {
    function search($tpm_serial_code) {
        $result=$this->db->query("SELECT pd.*,p.product_name,p.product_code,p.china_name,
          c.category_name,mt.machine_type_name,b.brand_name,fl.line_no,s.supplier_name
          FROM  product_detail_info pd 
          INNER JOIN product_info p ON(p.product_id=pd.product_id)
          INNER JOIN category_info c ON(p.category_id=c.category_id)
          LEFT JOIN machine_type mt ON(p.machine_type_id=mt.machine_type_id)
          LEFT JOIN brand_info b ON(p.brand_id=b.brand_id)
          LEFT JOIN supplier_info s ON(pd.supplier_id=s.supplier_id)
          LEFT JOIN product_status_info pds ON(pd.product_detail_id=pds.product_detail_id AND pds.machine_status='USED')
          LEFT JOIN floorline_info fl ON(pds.line_id=fl.line_id)
          WHERE pd.department_id=12 AND 
           (pd.tpm_serial_code='$tpm_serial_code' OR pd.ventura_code='$tpm_serial_code'  OR pd.asset_encoding='$tpm_serial_code') ")->row();
        return $result;
    }
   function getdowntime($tpm_serial_code) {
        $result=$this->db->query("SELECT  md.*,
          md.line_id as line_no,md.supervisor_id as supervisor_name,
          md.me_id as me_name
          FROM machine_downtime_info md 
          INNER JOIN product_detail_info pd ON(md.product_status_id=pd.tpm_serial_code)
          WHERE pd.tpm_serial_code LIKE '$tpm_serial_code' OR pd.ventura_code LIKE '$tpm_serial_code' ")->result();
        return $result;
    }
    function getMovementList($tpm_serial_code) {
        $result=$this->db->query("SELECT  ps.*,fl.line_no,f.floor_no
          FROM product_detail_info pd 
          INNER JOIN product_status_info ps ON(ps.product_detail_id=pd.product_detail_id)
          LEFT JOIN floorline_info fl ON(ps.line_id=fl.line_id)
          LEFT JOIN floor_info f ON(fl.floor_id=f.floor_id)
          WHERE pd.tpm_serial_code LIKE '$tpm_serial_code' OR pd.ventura_code LIKE '$tpm_serial_code' ")->result();
         return $result;
    }
   public function getUseSparesList($tpm_serial_code) {
    $result=$this->db->query("SELECT  p.*,sd.*,u.unit_name,m.me_name,
          sm.use_date,sm.using_ref_no,fl.line_no
          FROM spares_use_detail sd 
          INNER JOIN spares_use_master sm ON(sd.spares_use_id=sm.spares_use_id)
          INNER JOIN product_detail_info pd ON(sm.asset_encoding=pd.asset_encoding 
          OR sm.asset_encoding=pd.ventura_code OR sm.asset_encoding=pd.tpm_serial_code)
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
