<?php
class Look_up_model extends CI_Model {
    function __construct() {
        parent::__construct();
    }
 
   function getProductNames($term) {
    $department_id=$this->session->userdata('department_id');
    $medical_yes=$this->session->userdata('medical_yes');
    $data=date('Y-m-d');
        $result=$this->db->query("SELECT p.*,c.category_name,u.unit_name,m.mtype_name
         FROM product_info p
          INNER JOIN category_info c ON(p.category_id=c.category_id)
          INNER JOIN product_unit u ON(p.unit_id=u.unit_id)
          LEFT JOIN material_info m ON(p.mtype_id=m.mtype_id)
          WHERE p.product_type=2 AND p.department_id=$department_id 
          AND p.medical_yes=$medical_yes AND p.machine_other=2 AND p.product_status=1
          AND (p.product_code LIKE '%$term%' or p.product_name LIKE '%$term%') 
          ORDER BY p.product_name ASC")->result();
        return $result;
    }
    function getItemFifoWise($term) {
      $department_id=$this->session->userdata('department_id');
      $medical_yes=$this->session->userdata('medical_yes');
      $data=date('Y-m-d');
      $result=$this->db->query("SELECT sm.CRRNCY as currency,sm.box_name,
        sm.EXCH_RATE as cnc_rate_in_hkd,sm.FIFO_CODE,
        sm.UPRICE as unit_price,p.product_id,
        p.product_name,p.product_code,
        u.unit_name,sm.specification,
        IFNULL(SUM(sm.QUANTITY),0)   as main_stock
        FROM stock_master_detail sm
        INNER JOIN product_info p ON(p.product_id=sm.product_id)
        INNER JOIN product_unit u ON(p.unit_id=u.unit_id)
        WHERE p.product_type=2 AND  p.main_stock>0
        AND p.department_id=$department_id  
        AND sm.department_id=$department_id 
        AND p.product_status=1 AND p.medical_yes=2
        AND (sm.ITEM_CODE LIKE '%$term%' 
        OR p.product_name LIKE '%$term%' 
        OR sm.FIFO_CODE LIKE '%$term%') 
        GROUP BY sm.FIFO_CODE
        ORDER BY sm.id ASC")->result();
      return $result;
    }
    
    function getItemFifoWiseMedical($term) {
      $department_id=$this->session->userdata('department_id');
      $medical_yes=$this->session->userdata('medical_yes');
      $data=date('Y-m-d');
      $result=$this->db->query("SELECT sm.CRRNCY as currency,sm.box_name,
        sm.EXCH_RATE as cnc_rate_in_hkd,sm.FIFO_CODE,
        sm.UPRICE as unit_price,p.product_id,
        p.product_name,p.product_code,
        u.unit_name,sm.specification, 
        IFNULL(SUM(sm.QUANTITY),0)   as main_stock
        FROM stock_master_detail sm
        INNER JOIN product_info p ON(p.product_id=sm.product_id)
        INNER JOIN product_unit u ON(p.unit_id=u.unit_id)
        WHERE p.product_type=2 AND p.department_id=$department_id  
        AND sm.department_id=$department_id 
        AND p.product_status=1 AND p.medical_yes=1
        AND (sm.ITEM_CODE LIKE '%$term%' 
        OR p.product_name LIKE '%$term%' 
        OR sm.FIFO_CODE LIKE '%$term%') 
        GROUP BY sm.FIFO_CODE
        ORDER BY sm.id ASC")->result();
      return $result;
    }
    function getItemFifoWise3($term) {
      $department_id=$this->session->userdata('department_id');
      $medical_yes=$this->session->userdata('medical_yes');
      $data=date('Y-m-d');
      $result=$this->db->query("SELECT sm.CRRNCY as currency,sm.box_name,
        sm.EXCH_RATE as cnc_rate_in_hkd,sm.FIFO_CODE,
        sm.UPRICE as unit_price,p.product_id,
        p.product_name,p.product_code,
        u.unit_name, 
        (SELECT IFNULL(SUM(sm2.QUANTITY),0) as ddd 
        FROM stock_master_detail sm2 
        WHERE sm.FIFO_CODE=sm2.FIFO_CODE AND sm.department_id=sm2.department_id
        AND sm.product_id=sm2.product_id)  as main_stock
        FROM stock_master_detail sm
        INNER JOIN product_info p ON(p.product_id=sm.product_id)
        INNER JOIN product_unit u ON(p.unit_id=u.unit_id)
        WHERE p.product_type=2 AND p.department_id=$department_id  
        AND sm.department_id=$department_id AND p.product_status=1
        AND (sm.TRX_TYPE='GRN' OR sm.TRX_TYPE='OPENING')
        AND (sm.ITEM_CODE LIKE '%$term%' OR p.product_name LIKE '%$term%') 
        ORDER BY sm.FIFO_CODE ASC")->result();
      return $result;
    }
    function getProductNamesAll($term) {
    $department_id=$this->session->userdata('department_id');
    $medical_yes=$this->session->userdata('medical_yes');
    $data=date('Y-m-d');
        $result=$this->db->query("SELECT p.*,c.category_name,u.unit_name,m.mtype_name
         FROM product_info p
          INNER JOIN category_info c ON(p.category_id=c.category_id)
          INNER JOIN product_unit u ON(p.unit_id=u.unit_id)
          LEFT JOIN material_info m ON(p.mtype_id=m.mtype_id)
          WHERE p.product_type=2 AND p.department_id=$department_id 
          AND p.medical_yes=$medical_yes AND p.product_status=1
          AND (p.product_code LIKE '%$term%' or p.product_name LIKE '%$term%') 
          ORDER BY p.product_name ASC")->result();
        return $result;
    }
  function getdepartmentwiseItem($department_id,$term) {
    $result=$this->db->query("SELECT p.*,c.category_name,u.unit_name
     FROM product_info p
      INNER JOIN category_info c ON(p.category_id=c.category_id)
      LEFT JOIN product_unit u ON(p.unit_id=u.unit_id)
      WHERE p.department_id=$department_id  AND p.product_status=1
      AND p.product_type=2
      AND (p.product_code LIKE '%$term%' 
      or p.product_name LIKE '%$term%') 
      ORDER BY p.product_name ASC")->result();
    return $result;
  }
  function getdepartmentwiseItem2($department_id,$product_type,$term) {
    $result=$this->db->query("SELECT p.*,c.category_name,u.unit_name
     FROM product_info p
      INNER JOIN category_info c ON(p.category_id=c.category_id)
      LEFT JOIN product_unit u ON(p.unit_id=u.unit_id)
      WHERE p.department_id=$department_id  
      AND p.product_status=1
      AND p.type='$product_type'
      AND p.product_type=2
      AND (p.product_code LIKE '%$term%' OR p.product_name LIKE '%$term%') 
      ORDER BY p.product_name ASC")->result();
    return $result;
  }
  function getProductNamesTPM($term) {
    $department_id=$this->session->userdata('department_id');
    $data=date('Y-m-d');
        $result=$this->db->query("SELECT p.*,c.category_name,u.unit_name,m.mtype_name
         FROM product_info p
          INNER JOIN category_info c ON(p.category_id=c.category_id)
          INNER JOIN product_unit u ON(p.unit_id=u.unit_id)
          LEFT JOIN material_info m ON(p.mtype_id=m.mtype_id)
          WHERE p.product_type=2 AND p.product_status=1
           AND p.department_id=$department_id 
          AND p.medical_yes=2 AND p.machine_other=1
          AND (p.product_code LIKE '%$term%' or p.product_name LIKE '%$term%') 
          ORDER BY p.product_name ASC")->result();
        return $result;
    }
	function get_company_info(){
	   $data = $this->db->query("SELECT * FROM company_info where id='1'")->row();
	   return $data ;
	}
  function getPOLists($payment_id=FALSE){
    if($payment_id==FALSE){
      $condition='';
    }else{
       $condition=" AND a.payment_id!=$payment_id";
    }
    $department_id=$this->session->userdata('department_id');
    if($this->session->userdata('user_id')==1){
      $user_id=$this->session->userdata('user_id');
      $result=$this->db->query("SELECT p.po_number FROM po_master p
      WHERE p.po_status=3 AND p.user_id=$user_id
      AND p.total_amount>(SELECT IFNULL(SUM(a.pamount),0) as ammount 
      FROM payment_po_amount a 
      WHERE a.po_number=p.po_number  
      $condition) ")->result();
    }else{
      $result=$this->db->query("SELECT d.* FROM 

      (SELECT p.po_number FROM po_master p
      WHERE p.for_department_id=$department_id AND p.po_status=3
      AND p.total_amount>(SELECT IFNULL(SUM(a.pamount),0) as ammount 
      FROM payment_po_amount a 
      WHERE a.po_number=p.po_number  $condition)
      UNION 
      SELECT a.po_number FROM purchase_master a
      WHERE a.department_id=$department_id AND a.status!=5
      AND a.po_number NOT IN (SELECT a.po_number FROM payment_po_amount a 
      WHERE 1 $condition)
      UNION 
      SELECT p.PO_NUMBER as po_number FROM bd_po_summary p
      WHERE p.TOTAL_AMT>(SELECT IFNULL(SUM(a.pamount),0) as ammount FROM payment_po_amount a 
      WHERE a.po_number=p.PO_NUMBER  $condition)
      
      )as d GROUP By d.po_number ORDER BY d.po_number ASC")->result();
    }
    return $result;
    // $result=$this->db->query("SELECT d.* FROM (SELECT p.po_number FROM po_master p
    //   WHERE p.for_department_id=$department_id AND p.po_status=3
    //   AND p.po_number NOT IN (SELECT a.po_number FROM payment_po_amount a WHERE 1 $cond)
    //   UNION 
    //   SELECT a.po_number FROM purchase_master a
    //   WHERE a.department_id=$department_id AND a.status!=5
    //   AND a.po_number NOT IN (SELECT a.po_number FROM payment_po_amount a WHERE 1 $cond)
    //   UNION 
    //   SELECT a.PO_NUMBER as po_number FROM BD_PO_SUMMARY a
    //   WHERE a.PO_NUMBER NOT IN (SELECT a.po_number FROM payment_po_amount a WHERE 1 $cond)
    //   )as d GROUP By d.po_number ORDER BY d.po_number ASC
    //   ")->result();
  }

	function getlocation(){
      $result=$this->db->query("SELECT * FROM location_info 
        WHERE 1 ORDER BY location_id ASC")->result();
      return $result;
  }
  function payment_term(){
    $result=$this->db->query("SELECT * FROM payment_term_info 
      WHERE 1 ORDER BY pay_term ASC")->result();
    return $result;
  }
  function getPayTo(){
    $result=$this->db->query("SELECT * FROM payment_to_info 
      WHERE 1 ORDER BY pay_to_name ASC")->result();
    return $result;
  }
  function getCode(){
    $result=$this->db->query("SELECT * FROM pa_dept_code 
      WHERE 1 ORDER BY id ASC")->result();
    return $result;
  }
  function clist(){
    $result=$this->db->query("SELECT * FROM currency_table 
      WHERE 1 ORDER BY id ASC")->result();
    return $result;
  }
  function getMainLocation(){
      $result=$this->db->query("SELECT * FROM main_location 
        WHERE 1 ORDER BY mlocation_id ASC")->result();
      return $result;
    }
    function getSymptom(){
      $result=$this->db->query("SELECT * FROM symptoms_info 
        WHERE 1 ORDER BY symptoms_id ASC")->result();
      return $result;
    }
    function getInjury(){
      $result=$this->db->query("SELECT * FROM injury_table 
        WHERE 1 ORDER BY injury_id ASC")->result();
      return $result;
    }
	function getCategory($department_id){
	   $department_id=$this->session->userdata('department_id');
	   if($this->session->userdata('user_type')!=1)
	     $data = $this->db->query("SELECT * FROM category_info 
	   	   WHERE department_id=$department_id")->result();
	   else
	     $data = $this->db->query("SELECT * FROM category_info 
	   	    WHERE 1")->result();
	   return $data ;
	}
  function getItemList(){
     $department_id=$this->session->userdata('department_id');
         $data = $this->db->query("SELECT * FROM product_info 
         WHERE department_id=$department_id 
         AND product_type=2")->result();
     return $data ;
  }

	function getMainProduct($department_id){
	    $data = $this->db->query("SELECT product_id, 
	    CONCAT(product_model,' (',product_name,')') as product_name
	    FROM product_info 
	   	WHERE department_id=$department_id 
      AND product_type=1 AND machine_other=2")->result();
	    return $data ;

	}
  function getMainProductMachine($department_id){
      $data = $this->db->query("SELECT product_id, 
      CONCAT(product_model,' (',product_name,')') as product_name
      FROM product_info 
      WHERE department_id=$department_id 
      AND product_type=1 AND machine_other=1")->result();
    return $data ;
  }
  function getMainProductSerial(){
      $department_id=$this->session->userdata('department_id');
           $result=$this->db->query("SELECT pd.product_detail_id,
            CONCAT(p.product_name,' (',pd.asset_encoding,')') as product_name,pd.ventura_code
            FROM product_detail_info pd, product_info p
            WHERE pd.product_id=p.product_id 
            AND pd.detail_status=1 AND pd.machine_other=2 
            AND pd.department_id=$department_id")->result();
      return $result;

  }
 function getMainProductSerial1(){
    $department_id=$this->session->userdata('department_id');
    $result=$this->db->query("SELECT pd.product_detail_id,
          CONCAT(p.product_name,' (',pd.asset_encoding,')-(',pd.ventura_code,')') as product_name
          FROM product_detail_info pd, product_info p
          WHERE pd.product_id=p.product_id  AND pd.machine_other=2 
          AND pd.department_id=$department_id")->result();
    return $result;

  }
   function get_ProductnameSerial($product_detail_id){
      $product_name=$this->db->query("SELECT CONCAT(p.product_name,' (',pd.asset_encoding,')') as product_name
            FROM product_detail_info pd, product_info p
            WHERE pd.product_id=p.product_id 
            AND pd.detail_status=1 AND pd.machine_other=2 
            AND pd.product_detail_id=$product_detail_id")->row('product_name');
        
      return $product_name;
    }
     function getMaterialType(){
        $result=$this->db->query("SELECT * FROM material_info 
            WHERE 1")->result();
        return $result;
    }
    
    function getBrand(){
    	$department_id=$this->session->userdata('department_id');
        $result=$this->db->query("SELECT * FROM brand_info 
            WHERE department_id=$department_id")->result();
        return $result;
    }
    function getMachineType(){
        $result=$this->db->query("SELECT * FROM machine_type 
            WHERE 1 ")->result();
        return $result;
    }
    function get_box(){
    	$department_id=$this->session->userdata('department_id');
        $result=$this->db->query("SELECT b.box_id,CONCAT(b.box_name,'(',r.rack_name,')') as box_name
        FROM box_info b,rack_info r  
        WHERE r.rack_id=b.rack_id 
        AND b.department_id=$department_id")->result();
        return $result;
    }
    
    function get_sparesStock($product_id){
      $stockin=$this->db->query("SELECT stock_quantity as stockin 
      	FROM product_info WHERE product_id=$product_id")->row('stockin');

      $purchaseqty=$this->db->query("SELECT IFNULL(SUM(quantity),0) as purchaseqty 
      	FROM purchase_detail 
        WHERE product_id=$product_id  AND status!=5")->row('purchaseqty');

      $stockout1=$this->db->query("SELECT IFNULL(SUM(quantity),0) as stockout1 
      	FROM spares_use_detail 
        WHERE product_id=$product_id")->row('stockout1');

      $stockout2=$this->db->query("SELECT IFNULL(SUM(quantity),0) as stockout2 
      	FROM item_issue_detail 
        WHERE product_id=$product_id")->row('stockout2');
      return ($stockin+$purchaseqty-$stockout1-$stockout2);
    }
    
    function get_PIStock($product_id){
      $department_id=12;
      $piqty=$this->db->query("SELECT IFNULL(SUM(pd.purchased_qty),0) as piqty 
      	FROM pi_item_details pd,pi_master pm 
        WHERE pm.pi_id=pd.pi_id AND pd.product_id=$product_id 
        AND pd.department_id=$department_id 
        AND pm.pi_status!=8 AND pm.pi_status=7 
        AND pm.pi_date>='2020-01-01' ")->row('piqty');

      $purchaseqty=$this->db->query("SELECT IFNULL(SUM(pd.quantity),0) as purchaseqty 
      	FROM purchase_detail pd,purchase_master pm
         WHERE pd.purchase_id=pm.purchase_id 
         AND pm.status!=5 AND pd.product_id=$product_id 
         AND pd.department_id=$department_id 
         AND pm.purchase_date>='2020-01-01' 
         AND pd.pi_no IS NOT NULL ")->row('purchaseqty');
      if(($piqty-$purchaseqty)>0){
        return ($piqty-$purchaseqty);
      }else{
        return 0;
      }
      
    }
  //////////////////////////////////////////////
  function get_monthlyqty($product_id,$month=FALSE){
      if($month!=FALSE){
      $total_quantity=$this->db->query("SELECT total_quantity 
        FROM every_month_using_qty 
        WHERE product_id=$product_id  
        AND month='$month'")->row('total_quantity');
      return $total_quantity;
      }else{
         $info=$this->db->query("SELECT * 
        FROM every_month_using_qty 
        WHERE product_id=$product_id  
        ")->result();
      return $info;
      }
    }
  function getTotalQty($product_id){
      $total=$this->db->query("SELECT count(*) as total
        FROM product_detail_info 
        WHERE product_id=$product_id ")->row('total');
      return $total;
    }
	function postList(){
       $result=$this->db->query("SELECT * FROM post  
        WHERE 1")->result();
        return $result;
	 }
	 function getFloorLine(){
      $result=$this->db->query("SELECT * FROM floorline_info 
        ORDER BY line_no ASC")->result();
      return $result;
    }
    function getSupplier(){
      $result=$this->db->query("SELECT * FROM supplier_info 
      ORDER BY supplier_name ASC")->result();
      return $result;
    }
    function getBranch(){
      $result=$this->db->query("SELECT * FROM company_info 
      ORDER BY id ASC")->result();
      return $result;
    }
    function getFloor(){
    $result=$this->db->query("SELECT * FROM floor_info 
      WHERE floor_no!='EGM'")->result();
      return $result;
  }
	 function departmentList(){
	 	$department_id=$this->session->userdata('department_id');
      $result=$this->db->query("SELECT * FROM department_info  
            WHERE 1 
            ORDER BY department_name ASC")->result();
      return $result;
	 }
   function departmentList2(){
    $department_id=$this->session->userdata('department_id');
      $result=$this->db->query("SELECT * FROM department_info  
            WHERE 1 
            ORDER BY department_id ASC")->result();
      return $result;
   }
   function approvedUserList(){
      $result=$this->db->query("SELECT * FROM user  
            WHERE status='ACTIVE' AND (super_user=1 OR super_user=2) 
            ORDER BY user_name ASC")->result();
      return $result;
   }
   function hdepartmentList(){
    $department_id=$this->session->userdata('department_id');
      $result=$this->db->query("SELECT * FROM department_info  
            WHERE stock_holder=1 
            AND department_id!=25 
            AND department_id!=26
            ORDER BY department_id ASC")->result();
      return $result;
   }
    function getPI(){
    	$department_id=$this->session->userdata('department_id');
        $result=$this->db->query("SELECT pi_id,pi_no 
          FROM pi_master     
          WHERE department_id=$department_id 
          AND pi_status>=2")->result();
        return $result;
    }
    function getPIType(){
    	$department_id=$this->session->userdata('department_id');
        $result=$this->db->query("SELECT * FROM purchase_type     
          WHERE 1")->result();
        return $result;
    }
    function getPOType(){
      $department_id=$this->session->userdata('department_id');
        $result=$this->db->query("SELECT * FROM po_type     
          WHERE 1")->result();
        return $result;
    }
    function getIssueTotalQty($requisition_no,$product_id){
    	 return $this->db->query("SELECT IFNULL(SUM(iid.quantity),0) as qty 
        FROM store_issue_master m,item_issue_detail iid 
    		WHERE iid.issue_id=m.issue_id 
        AND iid.product_id=$product_id
        AND m.requisition_no='$requisition_no' ")->row('qty');
    }
    function getIssueQty($product_id){
      return $this->db->query("SELECT COUNT(*) as qty 
        FROM product_detail_info 
        WHERE product_id=$product_id")->row('qty');

    }
	public function qcode_function($code,$level='S',$size=2){ 		
			$this->load->library('ci_qr_code');
			$this->config->load('qr_code');
			$qr_code_config = array(); 
			$qr_code_config['cacheable'] 	= $this->config->item('cacheable');
			$qr_code_config['cachedir'] 	= $this->config->item('cachedir');
			$qr_code_config['imagedir'] 	= $this->config->item('imagedir');
			$qr_code_config['errorlog'] 	= $this->config->item('errorlog');
			$qr_code_config['ciqrcodelib'] 	= $this->config->item('ciqrcodelib');
			$qr_code_config['quality'] 		= $this->config->item('quality');
			$qr_code_config['size'] 		= $this->config->item('size');
			$qr_code_config['black'] 		= $this->config->item('black');
			$qr_code_config['white'] 		= $this->config->item('white');
			$this->ci_qr_code->initialize($qr_code_config);
			$image_name =$code.'.png';
			$params['data'] = $code;
			$params['level'] = 'L';
			$params['size'] =7;
			$params['savename'] = FCPATH.$qr_code_config['imagedir'].$image_name;
		    $this->ci_qr_code->generate($params); 
			$qr_code_image_url = base_url().$qr_code_config['imagedir'].$image_name;
			return $qr_code_image_url;
		}
    public function qcode_functiongoods($code,$level='S',$size=2){     
      $this->load->library('ci_qr_code');
      $this->config->load('qr_code');
      $qr_code_config = array(); 
      $qr_code_config['cacheable']  = $this->config->item('cacheable');
      $qr_code_config['cachedir']   = $this->config->item('cachedir');
      $qr_code_config['imagedir']   = $this->config->item('imagedir');
      $qr_code_config['errorlog']   = $this->config->item('errorlog');
      $qr_code_config['ciqrcodelib']  = $this->config->item('ciqrcodelib');
      $qr_code_config['quality']    = $this->config->item('quality');
      $qr_code_config['size']     = $this->config->item('size');
      $qr_code_config['black']    = $this->config->item('black');
      $qr_code_config['white']    = $this->config->item('white');
      $this->ci_qr_code->initialize($qr_code_config);
      $randomPswd=strtoupper(substr(md5('VENTURALEATHERWAREMFYBDLTD'.mt_rand(0,100)),0,8));
      $image_name =$randomPswd.'.png';
      $params['data'] = $code;
      $params['level'] = 'L';
      $params['size'] =3;
      $params['savename'] = FCPATH.$qr_code_config['imagedir'].$image_name;
        $this->ci_qr_code->generate($params); 
      $qr_code_image_url = base_url().$qr_code_config['imagedir'].$image_name;
      return $qr_code_image_url;
      }
		public function qcode_functionline($code,$level='S',$size=2){ 		
			$this->load->library('ci_qr_code');
			$this->config->load('qr_code');
			$qr_code_config = array(); 
			$qr_code_config['cacheable'] 	= $this->config->item('cacheable');
			$qr_code_config['cachedir'] 	= $this->config->item('cachedir');
			$qr_code_config['imagedir'] 	= $this->config->item('imagedir');
			$qr_code_config['errorlog'] 	= $this->config->item('errorlog');
			$qr_code_config['ciqrcodelib'] 	= $this->config->item('ciqrcodelib');
			$qr_code_config['quality'] 		= $this->config->item('quality');
			$qr_code_config['size'] 		= $this->config->item('size');
			$qr_code_config['black'] 		= $this->config->item('black');
			$qr_code_config['white'] 		= $this->config->item('white');
			$this->ci_qr_code->initialize($qr_code_config);
			$randomPswd=strtoupper(substr(md5('VENTURALEATHERWAREMFYBDLTD'.mt_rand(0,100)),0,8));
			$image_name =$randomPswd.'.png';
			$params['data'] = $code;
			$params['level'] = 'L';
			$params['size'] =2;
			$params['savename'] = FCPATH.$qr_code_config['imagedir'].$image_name;
		  $this->ci_qr_code->generate($params); 
			$qr_code_image_url = base_url().$qr_code_config['imagedir'].$image_name;
			return $qr_code_image_url;
			}

		public function qcode_functionHCM($employee_id,$level='S',$size=2000){ 
			$info=$this->db->query("SELECT * FROM employee_idcard_info 
            WHERE employee_id=$employee_id")->row();

			$this->load->library('ci_qr_code');
			$this->config->load('qr_code');
			$qr_code_config = array(); 
			$qr_code_config['cacheable'] 	= $this->config->item('cacheable');
			$qr_code_config['cachedir'] 	= $this->config->item('cachedir');
			$qr_code_config['imagedir'] 	= $this->config->item('imagedir');
			$qr_code_config['errorlog'] 	= $this->config->item('errorlog');
			$qr_code_config['ciqrcodelib'] 	= $this->config->item('ciqrcodelib');
			$qr_code_config['quality'] 		= $this->config->item('quality');
			$qr_code_config['size'] 		= $this->config->item('size');
			$qr_code_config['black'] 		= $this->config->item('black');
			$qr_code_config['white'] 		= $this->config->item('white');
			$this->ci_qr_code->initialize($qr_code_config);
			$image_name =$info->employee_cardno.'.jpg';
      $params['data'] = "Name: $info->employee_name 
      Designation: $info->designation 
      Division: $info->division
      Department: $info->department_name
      ID NO: $info->employee_cardno
      Date of Joining: $info->join_date
      Blood Group: $info->blood_group
      www.bdventura.com";
			$params['level'] = 'H';
			$params['size'] =2500;
			$params['savename'] = FCPATH.$qr_code_config['imagedir'].$image_name;
		    $this->ci_qr_code->generate($params); 
			$qr_code_image_url = base_url().$qr_code_config['imagedir'].$image_name;
			return $qr_code_image_url;
			}

      function tmpstockcrud(){
        echo "stringsss";
    
    }
    

    function storecrud($actiontype=FALSE,$product_id=FALSE,$quantity,$editqty=FALSE){
      $department_id=$this->session->userdata('department_id');
      if($actiontype=="ADD"){
        $this->db->set('main_stock', "main_stock+$quantity", FALSE);
        $this->db->where('product_id', $product_id);
        $this->db->update('product_info');
      }elseif($actiontype=="MINUS"){
        $this->db->set('main_stock', "main_stock-$quantity", FALSE);
        $this->db->where('product_id', $product_id);
        $this->db->update('product_info');
      }elseif($actiontype=="EDIT"){
         $this->db->set('main_stock', "main_stock+$quantity-$editqty", FALSE);
        $this->db->where('product_id', $product_id);
        $this->db->update('product_info');
      }
      return 1;
    }
    function valuecrud($actiontype=FALSE,$product_id=FALSE,$amount,$editqty=FALSE){
      $department_id=$this->session->userdata('department_id');
      if($actiontype=="ADD"){
        $this->db->set('stock_value_hkd', "stock_value_hkd+$amount", FALSE);
        $this->db->where('product_id', $product_id);
        $this->db->update('product_info');
      }elseif($actiontype=="MINUS"){
        $this->db->set('stock_value_hkd', "stock_value_hkd-$amount", FALSE);
        $this->db->where('product_id', $product_id);
        $this->db->update('product_info');
      }elseif($actiontype=="EDIT"){
         $this->db->set('stock_value_hkd', "stock_value_hkd+$amount-$editqty", FALSE);
        $this->db->where('product_id', $product_id);
        $this->db->update('product_info');
      }
      return 1;
    }

    function getPINote($pi_id=FALSE){
      $data=$this->db->query("SELECT GROUP_CONCAT(date, ' ', comments  SEPARATOR '<br>')  as notes
        FROM pi_comment_info 
              WHERE pi_id=$pi_id GROUP BY pi_id")->row('notes');
      if(count($data)>0)
      return $data;
      else return '';
  
    }
     function getGatepassIN($gatepass_id=FALSE){
      $data=$this->db->query("SELECT GROUP_CONCAT(date_time , ';', user_name , ',Comments:', comments  SEPARATOR '<br>')  as notes
        FROM gatein_comments 
        WHERE gatepass_id=$gatepass_id 
        GROUP BY gatepass_id")->row('notes');
      if(count($data)>0)
      return $data;
      else return '';
  
    }

}