<?php
class Itassetreport_model extends CI_Model {
	 function reportResult(){
	/////////////////
	$result=$this->db->query("SELECT pd.*,p.product_name,
        p.product_code,p.china_name,r.ram_type,
        c.category_name,b.brand_name,l.location_name,
        s.supplier_name,aim.employee_id,
        pd.it_status,d.department_name,d.division,e.employee_name
        FROM  product_detail_info pd 
        INNER JOIN product_info p ON(p.product_id=pd.product_id)
        INNER JOIN category_info c ON(p.category_id=c.category_id)
        LEFT JOIN brand_info b ON(p.brand_id=b.brand_id)
        LEFT JOIN supplier_info s ON(pd.supplier_id=s.supplier_id)
        LEFT JOIN asset_issue_master aim ON(pd.product_detail_id=aim.product_detail_id AND aim.take_over_status=1)
        LEFT JOIN location_info l ON(aim.location_id=l.location_id)
        LEFT JOIN ram_info r ON(pd.ram_id=r.ram_id)
        LEFT JOIN department_info d ON(aim.take_department_id=d.department_id)
        LEFT JOIN employee_idcard_info e ON(aim.employee_id=e.employee_cardno)
        WHERE  pd.department_id=1 AND pd.machine_other=2
        ORDER BY pd.ventura_code ASC")->result();
	 return $result;
	}
	
  
}