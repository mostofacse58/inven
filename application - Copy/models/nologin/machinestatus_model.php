<?php
class Machinestatus_model extends CI_Model {
	 function reportResult(){
	/////////////////
	$result=$this->db->query("
		SELECT pd.*,p.product_name,p.product_code,p.china_name,
		c.category_name,mt.machine_type_name,f.floor_no,
		fl.line_no,pd.tpm_status as machine_status
		FROM  product_detail_info pd 
		INNER JOIN product_info p ON(p.product_id=pd.product_id)
		INNER JOIN category_info c ON(p.category_id=c.category_id)
		LEFT JOIN machine_type mt ON(p.machine_type_id=mt.machine_type_id)
		LEFT JOIN floorline_info fl ON(pd.line_id=fl.line_id)
		LEFT JOIN floor_info f ON(fl.floor_id=f.floor_id)
		WHERE pd.department_id=12 AND pd.machine_other=1  
		GROUP BY pd.product_detail_id 
		ORDER BY pd.ventura_code  ASC")->result();
	// $result=$this->db->query("SELECT pd.*,p.product_name,p.product_code,p.china_name,
	//     c.category_name,mt.machine_type_name,
	//     b.brand_name,fl.line_no,s.supplier_name,pds.machine_status,pds.assign_date,f.floor_no
	//     FROM  product_detail_info pd 
	//     INNER JOIN product_info p ON(p.product_id=pd.product_id)
	//     INNER JOIN category_info c ON(p.category_id=c.category_id)
	//     LEFT JOIN machine_type mt ON(p.machine_type_id=mt.machine_type_id)
	//     LEFT JOIN brand_info b ON(p.brand_id=b.brand_id)
	//     LEFT JOIN supplier_info s ON(pd.supplier_id=s.supplier_id)
	//     LEFT JOIN product_status_info pds ON(pd.product_detail_id=pds.product_detail_id AND pds.take_over_status=1)
	//     LEFT JOIN floorline_info fl ON(pds.line_id=fl.line_id)
	//     LEFT JOIN floor_info f ON(fl.floor_id=f.floor_id)
	//     WHERE pd.department_id=12  
	//     GROUP BY pd.product_detail_id 
	//     ORDER BY pd.ventura_code ASC")->result();
	  return $result;
	}
	function getidledays($product_detail_id){
		$dates='';
		$result=$this->db->query("SELECT pds.* 
			FROM product_status_info pds 
			WHERE pds.product_detail_id=$product_detail_id AND  pds.department_id=12
			ORDER BY pds.product_status_id DESC")->result();
		foreach ($result as  $value) {
			if($value->machine_status==2){
                $dates=$value->assign_date;
				continue;
			}else{
				break;			
			}
		}
		$date=date_create("$dates");
	    $date1=date("Y-m-d");
	    $date2=date_create("$date1");
	    $diff=date_diff($date,$date2);//OP: +272 days 
	    $dayss=$diff->format("%a");
	    $dayss=$dayss+1;
	    return $dayss;
	}
	public function getStatusFor($product_detail_id='',$date=FALSE){
		$result=$this->db->query("SELECT pds.machine_status FROM product_status_info pds 
			WHERE pds.product_detail_id=$product_detail_id AND  pds.department_id=12 AND 
			pds.assign_date<='$date' AND pds.takeover_date>='$date'  ")->row();
		if(count($result)>0){
		   return $result->machine_status;
		}else{
		   return 6; 
		}
		//    $dates=date('Y-m-d');
		//    $date1=date('Y-m-d', strtotime($dates. ' -7 day'));           
		//    $date2=date('Y-m-d', strtotime($dates. ' -14 day'));
		//    $date3=date('Y-m-d', strtotime($dates. ' -21 day'));
		//    $date4=date('Y-m-d', strtotime($dates. ' -28 day'));
		//    $date5=date('Y-m-d', strtotime($dates. ' -35 day'));
		//    $date6=date('Y-m-d', strtotime($dates. ' -42 day'));
		//    $date7=date('Y-m-d', strtotime($dates. ' -49 day'));
		//    $date8=date('Y-m-d', strtotime($dates. ' -56 day'));
		//    $date9=date('Y-m-d', strtotime($dates. ' -63 day'));
		//    $date10=date('Y-m-d', strtotime($dates. ' -70 day'));
		//    $date11=date('Y-m-d', strtotime($dates. ' -77 day'));
		//    $date12=date('Y-m-d', strtotime($dates. ' -84 day'));
		//    $date13=date('Y-m-d', strtotime($dates. ' -91 day'));
		//    $date14=date('Y-m-d', strtotime($dates. ' -98 day'));
		//    $date15=date('Y-m-d', strtotime($dates. ' -105 day'));
		//    $date16=date('Y-m-d', strtotime($dates. ' -112 day'));

		// $result=$this->db->query("
		//     SELECT IFNULL(pds.machine_status,0) as status1 FROM product_status_info pds 
		//     WHERE pds.product_detail_id=$product_detail_id AND  pds.department_id=12 AND 
		//     pds.assign_date<='$date1' AND pds.takeover_date>='$date1'
		//     UNION 
		//     SELECT pds.machine_status as status2 FROM product_status_info pds 
		//     WHERE pds.product_detail_id=$product_detail_id AND  pds.department_id=12 AND 
		//     pds.assign_date<='$date2' AND pds.takeover_date>='$date2'
		//     UNION 
		//     SELECT pds.machine_status as status3 FROM product_status_info pds 
		//     WHERE pds.product_detail_id=$product_detail_id AND  pds.department_id=12 AND 
		//     pds.assign_date<='$date3' AND pds.takeover_date>='$date3'
		//     UNION 
		//     SELECT pds.machine_status as status4 FROM product_status_info pds 
		//     WHERE pds.product_detail_id=$product_detail_id AND  pds.department_id=12 AND 
		//     pds.assign_date<='$date4' AND pds.takeover_date>='$date4'
		//     UNION 
		//     SELECT pds.machine_status as status5 FROM product_status_info pds 
		//     WHERE pds.product_detail_id=$product_detail_id AND  pds.department_id=12 AND 
		//     pds.assign_date<='$date5' AND pds.takeover_date>='$date5'
		//     UNION 
		//     SELECT pds.machine_status as status6 FROM product_status_info pds 
		//     WHERE pds.product_detail_id=$product_detail_id AND  pds.department_id=12 AND 
		//     pds.assign_date<='$date6' AND pds.takeover_date>='$date6'
		//     UNION 
		//     SELECT pds.machine_status as status7 FROM product_status_info pds 
		//     WHERE pds.product_detail_id=$product_detail_id AND  pds.department_id=12 AND 
		//     pds.assign_date<='$date7' AND pds.takeover_date>='$date7'
		//     UNION 
		//     SELECT pds.machine_status as status8 FROM product_status_info pds 
		//     WHERE pds.product_detail_id=$product_detail_id AND  pds.department_id=12 AND 
		//     pds.assign_date<='$date8' AND pds.takeover_date>='$date8'
		//     UNION 
		//     SELECT pds.machine_status as status9 FROM product_status_info pds 
		//     WHERE pds.product_detail_id=$product_detail_id AND  pds.department_id=12 AND 
		//     pds.assign_date<='$date9' AND pds.takeover_date>='$date9'
		//     UNION 
		//     SELECT pds.machine_status as status10 FROM product_status_info pds 
		//     WHERE pds.product_detail_id=$product_detail_id AND  pds.department_id=12 AND 
		//     pds.assign_date<='$date10' AND pds.takeover_date>='$date10'
		//     UNION 
		//     SELECT pds.machine_status as status11 FROM product_status_info pds 
		//     WHERE pds.product_detail_id=$product_detail_id AND  pds.department_id=12 AND 
		//     pds.assign_date<='$date11' AND pds.takeover_date>='$date11'
		//     UNION 
		//     SELECT pds.machine_status as status12 FROM product_status_info pds 
		//     WHERE pds.product_detail_id=$product_detail_id AND  pds.department_id=12 AND 
		//     pds.assign_date<='$date12' AND pds.takeover_date>='$date12'
		//     UNION 
		//     SELECT pds.machine_status as status13 FROM product_status_info pds 
		//     WHERE pds.product_detail_id=$product_detail_id AND  pds.department_id=12 AND 
		//     pds.assign_date<='$date13' AND pds.takeover_date>='$date13'
		//     UNION 
		//     SELECT pds.machine_status as status14 FROM product_status_info pds 
		//     WHERE pds.product_detail_id=$product_detail_id AND  pds.department_id=12 AND 
		//     pds.assign_date<='$date14' AND pds.takeover_date>='$date14'
		//     UNION 
		//     SELECT pds.machine_status as status15 FROM product_status_info pds 
		//     WHERE pds.product_detail_id=$product_detail_id AND  pds.department_id=12 AND 
		//     pds.assign_date<='$date15' AND pds.takeover_date>='$date15'
		//     UNION 
		//     SELECT IFNULL(pds.machine_status,0) as status16 FROM product_status_info pds 
		//     WHERE pds.product_detail_id=$product_detail_id AND  pds.department_id=12 AND 
		//     pds.assign_date<='$date16' AND pds.takeover_date>='$date16' 
		//     ")->row();
		//   //print_r($result); exit();
		//    return $result;
	  
		
	}
  
}