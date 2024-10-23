<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Qr_code_generate extends CI_Controller {
	public function index(){ 		
		
			// $this->load->library('ci_qr_code');
			// $this->config->load('qr_code');
			// $qr_code_config = array(); 
			// $qr_code_config['cacheable'] 	= $this->config->item('cacheable');
			// $qr_code_config['cachedir'] 	= $this->config->item('cachedir');
			// $qr_code_config['imagedir'] 	= $this->config->item('imagedir');
			// $qr_code_config['errorlog'] 	= $this->config->item('errorlog');
			// $qr_code_config['ciqrcodelib'] 	= $this->config->item('ciqrcodelib');
			// $qr_code_config['quality'] 		= $this->config->item('quality');
			// $qr_code_config['size'] 		= $this->config->item('size');
			// $qr_code_config['black'] 		= $this->config->item('black');
			// $qr_code_config['white'] 		= $this->config->item('white');
			// $this->ci_qr_code->initialize($qr_code_config);
			// $image_name = 'qr_code_test.png';
			// $params['data'] = 'dsadsadsadsadsadsadsadsadsa';
			// $params['level'] = 'H';
			// $params['size'] =10;
			// $params['savename'] = FCPATH.$qr_code_config['imagedir'].$image_name;
		    //    $this->ci_qr_code->generate($params); 
			// $qr_code_image_url = base_url().$qr_code_config['imagedir'].$image_name;
			// return $qr_code_image_url;
		    $this->load->view('qr_code'); 
			
			}
}
// END qr_code_generate Controller class
/* End of file qr_code_generate.php */
/* Location: ./application/controllers/qr_code_generate.php */