<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class PaginationExamples extends CI_Controller {
 
	public function index()
	{
		$this->load->library('pagination');
 
		$data_url = base_url() . "data/pagination-examples-data.json";
		$json = file_get_contents($data_url);
 
		$obj_data = json_decode($json);
 
		$total_rows = 1000;
		$per_page = 10;
 
		$config['base_url'] = base_url() . "index.php/PaginationExamples?";
		$config['total_rows'] = $total_rows;
		$config['per_page'] = $per_page;
		$config['page_query_string'] = TRUE;
 
		$this->pagination->initialize($config);
		$pagination = $this->pagination->create_links();
 
		if($pagination != "")
		{
			$num_pages = ceil($total_rows / $per_page);
			$pagination = '<p>We have ' . $total_rows . ' records in ' . $num_pages . ' pages ' . $pagination . '</p>';
			echo $pagination;
		}
 
		echo $this->create_table($obj_data);
	}
 
	public function __construct()
	{
		parent::__construct();
	}
}