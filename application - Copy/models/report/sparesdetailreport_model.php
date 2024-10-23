<?php
class Sparesdetailreport_model extends CI_Model {
    function getInfo() {
        $product_code=$this->input->post('product_code');
        $result=$this->db->query("SELECT p.*,c.category_name,
          m.mtype_name,u.unit_name,
          b.brand_name,bo.box_name
          FROM  product_info p
          INNER JOIN category_info c ON(p.category_id=c.category_id)
          LEFT JOIN material_info m ON(p.mtype_id=m.mtype_id)
          LEFT JOIN brand_info b ON(p.brand_id=b.brand_id)
          LEFT JOIN box_info bo ON(p.box_id=bo.box_id)
          INNER JOIN product_unit u ON(p.unit_id=u.unit_id)
          WHERE p.department_id=12 and p.product_type=2 and
          p.product_code='$product_code' ")->row();
        return $result;
    }
   public function reportrResult() {
    $product_code=$this->input->post('product_code');
    $result=$this->db->query("SELECT  p.*,sd.*,u.unit_name,
          sm.use_date,sm.using_ref_no,sm.use_purpose,fl.line_no,m.me_name,
          pd.ventura_code,pd.tpm_serial_code,pp.product_name as machine_name
          FROM spares_use_detail sd 
          INNER JOIN product_info p ON(sd.product_id=p.product_id)
          INNER JOIN spares_use_master sm ON(sd.spares_use_id=sm.spares_use_id)
          LEFT JOIN product_detail_info pd ON(sm.asset_encoding=pd.asset_encoding 
          OR sm.asset_encoding=pd.ventura_code OR sm.asset_encoding=pd.tpm_serial_code)
          
          LEFT JOIN product_info pp ON(pd.product_id=pp.product_id)
          LEFT JOIN floorline_info fl ON(sm.line_id=fl.line_id)
          INNER JOIN product_unit u ON(p.unit_id=u.unit_id)
          LEFT JOIN me_info m ON(sm.me_id=m.me_id)
          WHERE p.product_code='$product_code'
          ORDER BY sm.use_date ASC ")->result();
        return $result;
   }
  
}
