<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Materialusing extends My_Controller {
    function __construct(){
        parent::__construct();
        
        $this->load->model('egm/materialusing_model');
     }
    
    function lists(){
      if($this->session->userdata('user_id')) {
      $data=array();
      if($this->input->post('perpage')!='') $perpage=$this->input->post('perpage'); else $perpage=10;
        ////////////////////////////////////
        $this->load->library('pagination');
        $config['base_url']=base_url().'egm/materialusing/lists/';
        $config["uri_segment"] = 4;
        $config['total_rows'] = $this->materialusing_model->get_count();
        $config['per_page'] = $perpage;
        $choice = $config["total_rows"] / $config["per_page"];
        $config["num_links"] = floor($choice);
        $config['full_tag_open'] = '<ul class="pagination pagination-sm pull-right">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = false;
        $config['last_link'] = false;
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['prev_link'] = '<span aria-hidden="true">&laquo Prev</span>';
        $config['prev_tag_open'] = '<li class="prev">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = '<span aria-hidden="true">Next »</span>';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = "</a></li>";
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        ////////////////////////////////////////
        $this->pagination->initialize($config); 
        $data['page'] = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $data['pagination'] = $this->pagination->create_links();
        //echo $data["page"]; exit();///////////
        $data['list']=$this->materialusing_model->lists($config["per_page"],$data['page'] );
        ////////////////////////////////////////
        $data['heading']='Using Material List';
        $data['display']='egm/materialusinglist';
        $this->load->view('admin/master',$data);
        } else {
          redirect("logincontroller");
        }

      // $data=array();
      //   if($this->session->userdata('user_id')) {
      //   $data['heading']='Using Material List';
      //   $data['list']=$this->materialusing_model->lists();
      //   $data['display']='egm/materialusinglist';
      //   $this->load->view('admin/master',$data);
      //   } else {
      //     redirect("logincontroller");
      //   }
       }
    function add(){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Add Using';
        $data['flist']=$this->look_up_model->getFloorLine();
        $data['display']='me/addusingspares';
        $this->load->view('admin/master',$data);
        } else {
           redirect("logincontroller");
        }
    }
    function edit($spares_use_id){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Edit Using';
        $data['info']=$this->materialusing_model->get_info($spares_use_id);
        $data['flist']=$this->look_up_model->getFloorLine();
        $data['detail']=$this->materialusing_model->getDetails($spares_use_id);
        $data['display']='me/addusingspares';
        $this->load->view('admin/master',$data);
        } else {
           redirect("logincontroller");
        }
    }
    function getMachineLine(){
          $line_id=$this->input->post('line_id');
           $result=$this->db->query("SELECT pd.product_detail_id,
            CONCAT(pd.tpm_serial_code,' (',p.product_name,')') as product_name
            FROM product_status_info ps
            INNER JOIN product_detail_info pd ON(ps.product_detail_id=pd.product_detail_id)
            INNER JOIN floorline_info fl ON(ps.line_id=fl.line_id)
            INNER JOIN product_info p ON(p.product_id=pd.product_id)
            WHERE ps.department_id=12 
            and ps.line_id=$line_id GROUP BY pd.product_detail_id")->result();
          ;
      echo '<option value="">Select Machine Name(TMP CODE)</option>';
      foreach ($result as $value) {
        echo '<option value="'.$value->product_detail_id.'" >'.$value->product_name.'</option>';
      }
    exit;
   }
    function save($spares_use_id=FALSE){
        if($this->input->post('use_type')==1){
          $this->form_validation->set_rules('product_detail_id','Machine Name','trim|required');
        }else{
          $this->form_validation->set_rules('use_purpose','Purpose','trim|required');
        }
        $this->form_validation->set_rules('line_id','Location','trim|required');
        $this->form_validation->set_rules('other_id','Other ID','trim');
        
        $this->form_validation->set_rules('use_date','Date','trim|required');
        $this->form_validation->set_rules('me_id','ME','trim');
         if ($this->form_validation->run() == TRUE) {
            $check=$this->materialusing_model->save($spares_use_id);
            if($check && !$spares_use_id){
               $this->session->set_userdata('exception','Saved successfully');
               }elseif($check&& $spares_use_id){
                   $this->session->set_userdata('exception','Update successfully');
               }else{
                 $this->session->set_userdata('exception','Submission Failed');
               }
          redirect("egm/materialusing/lists");
         }else{
            $data['heading']='Add Using';
            if($spares_use_id){
              $data['heading']='Edit Using';
              $data['info']=$this->materialusing_model->get_info($spares_use_id);  
            }
            $data['flist']=$this->look_up_model->getFloorLine();
            $data['display']='me/addusingspares';
            $this->load->view('admin/master',$data);
         }

    }
    function delete($spares_use_id=FALSE){
      $check=$this->materialusing_model->delete($spares_use_id);
        if($check){ 
           $this->session->set_userdata('exception','Delete successfully');
         }else{
           $this->session->set_userdata('exception','Delete Failed');
        }
      redirect("egm/materialusing/lists");
    }
////////////////////////
public function suggestions(){
        $term = $this->input->get('term', true);
        if (strlen($term) < 1 || !$term) {
            die("<script type='text/javascript'>setTimeout(function(){ window.top.location.href = '" . base_url('dashboard') . "'; }, 10);</script>");
        }
        $rows = $this->look_up_model->getProductNames($term);
        if ($rows){
            $c = str_replace(".", "", microtime(true));
            $r = 0;
            foreach ($rows as $row) {
              $stock=$this->look_up_model->get_sparesStock($row->product_id);
                $description="Material Type: $row->mtype_name";
                if($row->mdiameter!=''){
                  $description=$description.", Diameter:$row->mdiameter";
                }
                if($row->mthread_count!=''){
                  $description=$description.", Thread Count:$row->mthread_count";
                }
                if($row->mlength!=''){
                  $description=$description.", Length:$row->mlength";
                }
                $pr[] = array('id' => ($c + $r), 'product_id' => $row->product_id, 'label' => $row->product_name . " (" . $row->product_code . ")",'category_name' => $row->category_name ,'unit_name' => $row->unit_name,'description' => $description, 'product_name' => $row->product_name,'product_code' => $row->product_code, 'stock' =>$stock);
                $r++;
            }
            header('Content-Type: application/json');
            die(json_encode($pr));
            exit;
        }else{
            $dsad='';
            header('Content-Type: application/json');
            die(json_encode($dsad));
            exit;
        }
    }
    function view($spares_use_id=FALSE){
    if ($this->session->userdata('user_id')) {
        $data['heading']='Invoice Material ';
            $data['info']=$this->materialusing_model->get_info($spares_use_id);
            $data['flist']=$this->look_up_model->getFloorLine();
            $data['detail']=$this->materialusing_model->getDetails($spares_use_id);
            $pdfFilePath='sparesInvoice'.date('Y-m-d H:i').'.pdf';
            $this->load->library('mpdf');
            $mpdf = new mPDF('bn','A4','','','15','15','15','18');
            $header = $this->load->view('header', $data, true);
            $html=$this->load->view('me/viewMaterialUning', $data, true);
            $mpdf->setHtmlHeader($header);
            $mpdf->pagenumPrefix = '  Page ';
            $mpdf->pagenumSuffix = ' - ';
            $mpdf->nbpgPrefix = ' out of ';
            $mpdf->nbpgSuffix = '';
            $mpdf->setFooter('{DATE H:i:s j/m/Y}{PAGENO}{nbpg}');
            $mpdf->WriteHTML($html);
            $mpdf->Output();
        } else {
           redirect("logincontroller");
        }
      }
 
   
 }