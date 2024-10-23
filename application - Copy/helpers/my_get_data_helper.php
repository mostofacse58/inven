<?php 

function bn2enNumber ($number){
    $search_array= array("১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯", "০");
    $replace_array= array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0");
    $en_number = str_replace($search_array, $replace_array, $number);
    return $en_number;
}
function en2bnNumber ($number){
    $replace_array= array("১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯", "০");
    $search_array= array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0");
    $bn_number = str_replace($search_array, $replace_array, $number);
    return $bn_number;
}
//////////////GET DIFFERENT DATE FORMAT///////////////
function findDate($date){
	$CI = & get_instance();
	$row=$CI->db->query("SELECT date_format FROM company_info where id='1'")->row();
	$format=null;
	if($date==''||$date==NULl){
		return '';
	}
	switch ($row->date_format) {
		case 'dd/mm/yyyy':
			$format='d/m/Y';
			break;
		case 'mm/dd/yyyy':
			$format='m/d/Y';
			break;
		case 'yyyy/mm/dd':
			$format='Y/m/d';
			break;
		default:
			$format='d/m/Y';
			break;
	}
	return date($format,strtotime($date));
}
function findDate3($date){
	$CI = & get_instance();
	$format='m/d/Y';
	return date($format,strtotime($date));
}
	/////////////////// alterDateFormat////////////////
function alterDateFormat($date){
	$CI = & get_instance();
	$row=$CI->db->query("SELECT date_format FROM company_info where id='1'")->row();
	$format=null;
	if($date==''||$date==NULl){
		return '';
	}
	if($date!=""){
		$dateSlug=explode('/',$date);
		//return $dateSlug[2].'-'.$dateSlug[1].'-'.$dateSlug[0];
		switch ($row->date_format) {
		case 'dd/mm/yyyy':
			$format=$dateSlug[2].'-'.$dateSlug[1].'-'.$dateSlug[0];
			break;
		case 'mm/dd/yyyy':
			$format=$dateSlug[2].'-'.$dateSlug[0].'-'.$dateSlug[1];
			break;
		case 'yyyy/mm/dd':
			$format=$dateSlug[0].'-'.$dateSlug[1].'-'.$dateSlug[2];
			break;
		default:
			$format=$dateSlug[2].'-'.$dateSlug[1].'-'.$dateSlug[0];
			break;
			}
	return $format;

	}else{
	 return "0000-00-00 00:00:00";
    }
}
function findDates($date){
	$CI = & get_instance();
 date_default_timezone_set('Asia/Dhaka');
 $row=$CI->db->query("SELECT date_format FROM company_info where id='1'")->row();
 $format=null;
 switch ($row->date_format) {
 	case 'dd/mm/yyyy':
 	$format='d/m/Y h:i:s A';
 	break;
 	case 'mm/dd/yyyy':
 	$format='m/d/Y h:i:s A';
 	break;
 	case 'yyyy/mm/dd':
 	$format='Y/m/d h:i:s A';
 	break;
 	default:
 	$format='d/m/Y h:i:s A';
 	break;
 }
 return date($format,strtotime($date));
 }
 function getGatepassType($status){

 $fullmean=null;
 switch ($status) {
 	case '1':
 	$fullmean='Returnable Material';
 	break;
 	case '2':
 	$fullmean='Non-Returnable Material';
 	break;
 	case '3':
 	$fullmean='Finished Goods';
 	break;
 	default:
 	$fullmean='Stock Transfer';
 	break;
 }
 return $fullmean;
 }
 
 
 function CheckStatus($status){
    $fullmean=null;
    switch ($status) {
 	case '1':
 	$fullmean='USED';
 	break;
 	case '2':
 	$fullmean='IDLE';
 	break;
 	case '3':
 	$fullmean='Under Service';
 	break;
 	case '4':
 	$fullmean='Deactive';
 	break;
 	case '5':
 	$fullmean='Dispose';
 	break;
 	case '6':
 	$fullmean='Not Found';
 	default:
 	$fullmean='Not Assign';
 	break;
 }
 return $fullmean;
 }
 function CheckStatus1($status){
	 $fullmean=null;
	 switch ($status) {
	 	case '1':
	 	$fullmean='USED';
	 	break;
	 	case '2':
	 	$fullmean='Return';
	 	break;
	 	case '3':
	 	$fullmean='Under Service';
	 	break;
	 	case '4':
	 	$fullmean='Deactive';
	 	break;
	 	case '5':
	 	$fullmean='Dispose';
	 	break;
	 	default:
	 	$fullmean='Not Assign';
	 	break;
	 }
 return $fullmean;
 }
 function CheckStatusGeneral($status){

 $fullmean=null;
 switch ($status) {
 	case '1':
 	$fullmean='USED';
 	break;
 	case '2':
 	$fullmean='IDLE';
 	break;
 	case '3':
 	$fullmean='Under Service';
 	break;
 	case '4':
 	$fullmean='Damage/Deactive';
 	break;
 	case '5':
 	$fullmean='Dispose';
 	break;
 	case '6':
 	$fullmean='Sold';
 	break;
 	case '7':
 	$fullmean='CSR';
 	break;
 	case '8':
 	$fullmean='LOST';
 	break;
 	case '9':
 	$fullmean='Dormant';
 	break;
 	case '10':
 	$fullmean='Transfer';
 	break;

 	default:
 	$fullmean='Not Assign';
 	break;
 }
 return $fullmean;	
 }
function CheckStatuspro($status){
 $fullmean=null;
 switch ($status) {
 	case '1':
 	$fullmean='USED';
 	break;
 	case '2':
 	$fullmean='IDLE';
 	break;
 	case '3':
 	$fullmean='Under Service';
 	break;
 	case '4':
 	$fullmean='Demage';
 	break;
 	case '5':
 	$fullmean='Dispose';
 	break;
 	case '6':
 	$fullmean='Sold';
 	break;
 	case '7':
 	$fullmean='CSR';
 	break;
 	case '8':
 	$fullmean='LOST';
 	break;
 	case '9':
 	$fullmean='Dormant';
 	break;
 	case '10':
 	$fullmean='Transfer';
 	break;
 	case '11':
 	$fullmean='Paper Free';
 	break;
 	default:
 	$fullmean='Not Used';
 	break;
 }
 return $fullmean;
 }
 ///////////////////////////
 function getDays($date){
    $date=date_create("$date");
    $date1=date("Y-m-d");
    $date2=date_create("$date1");
    $diff=date_diff($date,$date2);//OP: +272 days 
    return $diff->format("%a");
 }
 /////////////////////////
 function CheckDetailStatus($status){
 $fullmean=null;
 switch ($status) {
 	case '1':
 	$fullmean='ACTIVE';
 	break;
 	case '2':
 	$fullmean='DEACTIVE';
 	break;
 	case '3':
 	$fullmean='US';
 	break;
 	case '4':
 	$fullmean='Damage';
 	break;
 	case '5':
 	$fullmean='Dispose';
 	break;
 	case '6':
 	$fullmean='Sold';
 	break;
 	case '7':
 	$fullmean='CSR';
 	break;
 	case '8':
 	$fullmean='LOST';
 	break;
 	case '9':
 	$fullmean='Dormant';
 	break;
 	case '10':
 	$fullmean='Transfer';
 	break;
 	default:
 	$fullmean='Missing';
 	break;
 }
 return $fullmean;
 }
 function CheckDeactiveStatus($status){
 $fullmean=null;
 switch ($status) {
 	case '1':
 	$fullmean='SHIPPED BACK';
 	break;
 	case '2':
 	$fullmean='DISPOSED';
 	break;
 	case '3':
 	$fullmean='SOLD';
 	break;
 	case '4':
 	$fullmean='WAITING';
 	break;
 	default:
 	$fullmean='';
 	break;
 }
 return $fullmean;
 }
/////////////////date time separate//////////
	function dateSeparate($date=''){
		$slug=explode(' ', $date);
		return $slug[0];
	}

////////////////// FIND TAX RATE//////////
function getLineId($line_no=''){
	$CI = & get_instance();
	$line_id=$CI->db->query("SELECT line_id FROM floorline_info 
		WHERE line_no='$line_no'")->row('line_id');
	return $line_id;
}

/////////////////// banglaDateFormat////////////////
function banglaDateFormat($date){
	if($date!=""){
		$dateSlug=explode('-',$date);
		return $dateSlug[2].'/'.$dateSlug[1].'/'.$dateSlug[0];
	}else{
		return "00/00/0000";
	}
}
function getRack($box_id=''){
	$CI = & get_instance();
	if($box_id=='' ||$box_id==0){
		return " ";
	}else{
		$result=$CI->db->query("SELECT CONCAT(r.rack_name,' (',b.box_name,')') as rack_name
          FROM  box_info b
          LEFT JOIN rack_info r ON(b.rack_id=r.rack_id)
          WHERE b.box_id=$box_id ")->row();
	return $result->rack_name;
	}
	
}
//////////////////////// BILL SUM ON PROPOSAL ID////////////////
function getHKDRate($fromcurency){
	$CI = & get_instance();
	$sql=$CI->db->query("SELECT convert_rate FROM currency_convert_table 
		WHERE currency='$fromcurency' 
		AND in_currency='HKD' ")->row();
	return $sql->convert_rate;
}

function getThisYearQty($product_id){
	$CI = & get_instance();
	$year=date('Y');
	$sql=$CI->db->query("SELECT IFNULL(SUM(quantity),0) as qty FROM item_issue_detail 
		WHERE product_id='$product_id' AND date like '$year%' ")->row();
	return $sql->qty;
}
function getThisMonthQty($product_id){
	$CI = & get_instance();
	$month=date('Y-m-d');
	$sql=$CI->db->query("SELECT IFNULL(SUM(quantity),0) as qty,IFNULL(SUM(amount_hkd),0) as amount 
		FROM item_issue_detail 
		WHERE product_id='$product_id' AND date like '$month%' ")->row();
	return $sql;
}

function getCompanyInfo(){
	$CI = & get_instance();
	$row=$CI->db->query("SELECT * from company_info where id='1'")->row();
	return $row;
}
function getUserName($id=FALSE){
	if($id!=FALSE){
	$CI = &get_instance();
    $info=$CI->db->query("SELECT * FROM user WHERE id=$id")->row();
    return $info->user_name;
    }else{
        return '';
    }
}
function getSupplier($supplier_id=FALSE){
	if($supplier_id!=FALSE){
	$CI = &get_instance();
    $info=$CI->db->query("SELECT * FROM supplier_info WHERE supplier_id=$supplier_id")->row();
    return $info->supplier_name;
    }else{
        return '';
    }
} 
function getInvoiceNo($product_id=FALSE,$pi_no=FALSE){
	$CI = &get_instance();
    $info=$CI->db->query("SELECT pm.invoice_no FROM purchase_master_cn pm, purchase_detail_cn pd 
    	WHERE pd.purchase_id=pm.purchase_id 
    	AND pd.product_id=$product_id AND pd.pi_no='$pi_no'")->row();

    if(count((array)$info)>0){
    return $info->invoice_no;
    }else{
        return '';
    }
} 
function getSp($product_id=FALSE){
	
	$CI = &get_instance();
    $info=$CI->db->query("SELECT * FROM pi_item_details WHERE product_id=$product_id 
    	ORDER BY pi_detail_id DESC")->row();
    if(count($info)>0){
    return $info->specification;
    }else{
        return '';
    }
}
?>