<?php
class tpmsparesusing_model extends CI_Model {
	 function reportResult(){
    $result=$this->db->query("SELECT sm.*,f.floor_no,
          (SELECT IFNULL(SUM(sd.quantity),0) as qtt FROM spares_use_detail sd 
          WHERE sm.spares_use_id=sd.spares_use_id) as totalqty,
          (SELECT IFNULL(SUM(sd1.quantity*p.unit_price),0) as att FROM spares_use_detail sd1,product_info p
          WHERE sm.spares_use_id=sd1.spares_use_id AND sd1.product_id=p.product_id) as totatamount
          FROM spares_use_master sm
          LEFT JOIN floorline_info fl ON(sm.line_id=fl.line_id)
          INNER JOIN floor_info f ON(fl.floor_id=f.floor_id)
          WHERE sm.department_id=12 
          AND sm.use_date BETWEEN '2019-02-01' AND  '2019-02-31'
          ORDER BY sm.spares_use_id ASC")->result();
        return $result;
          
	}
 
 


}