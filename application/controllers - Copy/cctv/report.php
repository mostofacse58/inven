<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Report extends My_Controller {
  function __construct(){
        parent::__construct();
        $this->load->model('cctv/camerastatus_model');
     }
	public function index(){
	    $department_id=$this->session->userdata('department_id');
        $data['offlinelist']=$this->db->query("SELECT c.*,l.location_name,
        	pd.asset_encoding,aim.issue_purpose
        	FROM cctv_maintain c 
        	INNER JOIN product_detail_info pd ON(pd.product_detail_id=c.product_detail_id)
        	LEFT JOIN asset_issue_master aim ON(pd.product_detail_id=aim.product_detail_id AND aim.entry_check=1)
        	INNER JOIN location_info l ON(l.location_id=c.location_id)
        	WHERE c.cctv_status=1")->result();

		$data['locationwiseCCTV']=$this->db->query("SELECT COUNT(pd.product_detail_id) as countcctv,l.location_name
		    FROM asset_issue_master aim
		    INNER JOIN product_detail_info pd ON(pd.product_detail_id=aim.product_detail_id)
		    INNER JOIN product_info p ON(p.product_id=pd.product_id)
		    INNER JOIN location_info l ON(l.location_id=aim.location_id)
		    WHERE p.category_id=83 and pd.it_status=1 
		    GROUP BY aim.location_id 
		    ORDER BY countcctv DESC")->result();

		$data['totalcctv']=$this->db->query("SELECT COUNT(pd.product_detail_id) as countcctv
		    FROM product_detail_info pd
		    INNER JOIN product_info p ON(p.product_id=pd.product_id)
		    WHERE p.category_id=83 and pd.it_status=1")->row('countcctv');
		$data['heading']=' CCTV Dashboard';
		$data['display']='cctv/report';
		$this->load->view('admin/master',$data);
	}
  

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */