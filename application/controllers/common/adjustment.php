<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Adjustment extends My_Controller {
    function __construct(){
        parent::__construct();
        $this->load->model('common/adjustment_model');
     }
    
    function lists(){
      $data=array();
          $data=array();
        if($this->input->post('perpage')!='') 
        $perpage=$this->input->post('perpage'); else $perpage=20;
        $this->load->library('pagination');
        $config['base_url']=base_url().'common/adjustment/lists/';
        $config['suffix'] = '?' . http_build_query($_GET, '', "&");
        $config["uri_segment"] = 4;
        $config['total_rows'] = $this->adjustment_model->get_count();
        $total_rows=$config['total_rows'];
        $config['per_page'] = $perpage;
        $choice = $config["total_rows"] / $config["per_page"];
        $config["num_links"] = 2;
        $config['full_tag_open'] = '<ul class="pagination pagination-sm pull-right">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = 'First';
        $config['last_link'] = 'Last';
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
      //////////////////////////////////////////
        $this->pagination->initialize($config); 
        $data['page'] = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $pagination = $this->pagination->create_links();
        $data['pagination']='<p>We have ' . $total_rows . ' records in ' . $choice . ' pages ' . $pagination . '</p>';
        $data['list']=$this->adjustment_model->lists($config["per_page"],$data['page']);
        $this->form_validation->set_rules('location','Location','trim');
        $this->form_validation->set_rules('employee_name','Name','trim');
        $data['llist']=$this->look_up_model->getlocation();
        ////////////////////////////
        $data['heading']='Item Adjustment List';
        $data['display']='common/adjustmentlist';
        $this->load->view('admin/master',$data);
       }
    function add(){
      $data['heading']='Add Adjustment';
      $data['ilist']=$this->look_up_model->getItemList();
      $data['dlist']=$this->look_up_model->departmentList();
      $data['display']='common/addadjustment';
      $this->load->view('admin/master',$data);
      
    }
    function edit($adjustment_id){
      $data['heading']='Edit Adjustment';
      $data['ilist']=$this->look_up_model->getItemList();
      $data['info']=$this->adjustment_model->get_info($adjustment_id);
      $data['dlist']=$this->look_up_model->departmentList();
      $data['display']='common/addadjustment';
      $this->load->view('admin/master',$data);
     }

    function save($adjustment_id=FALSE){
        $department_id=$this->session->userdata('department_id');
        $this->form_validation->set_rules('product_id','Item','trim|required');
        $this->form_validation->set_rules('INDATE','Date','trim|required');
        if ($this->form_validation->run() == TRUE) {
        $check=$this->adjustment_model->save($adjustment_id);
        if($check && !$adjustment_id){
           $this->session->set_userdata('exception','Saved successfully');
           }elseif($check&& $adjustment_id){
               $this->session->set_userdata('exception','Update successfully');
           }else{
             $this->session->set_userdata('exception','Submission Failed');
           }
        redirect("common/adjustment/lists");
       }else{
          $data['heading']='Add Adjustment';
          if($adjustment_id){
            $data['heading']='Edit Adjustment';
            $data['info']=$this->adjustment_model->get_info($adjustment_id);  
          }
          $data['ilist']=$this->look_up_model->getItemList();
          $data['dlist']=$this->look_up_model->departmentList();
          $data['display']='common/addadjustment';
          $this->load->view('admin/master',$data);
       }
    }

    function delete($adjustment_id=FALSE){
      $info=$this->db->query("SELECT *
        FROM stock_adjustment_details  
        WHERE adjustment_id=$adjustment_id")->row();
      $FIFO=$info->FIFO_CODE;
      $result=$this->db->query("SELECT *
        FROM stock_master_detail  
        WHERE FIFO_CODE='$FIFO' AND TRX_TYPE!='ADJUSTMENT' ")->result();
        $check=$this->adjustment_model->delete($adjustment_id);
        if($check){ 
           $this->session->set_userdata('exception','Delete successfully');
         }else{
           $this->session->set_userdata('exception','Delete Failed');
        }
        redirect("common/adjustment/lists");
      
    }
  ////////////////////////
 
    function view($adjustment_id=FALSE){
    if ($this->session->userdata('user_id')) {
        $data['heading']='Invoice Spares ';
            $data['info']=$this->adjustment_model->get_info($adjustment_id);
            $data['dlist']=$this->look_up_model->departmentList();
            $data['detail']=$this->adjustment_model->getDetails($adjustment_id);
            $pdfFilePath='sparesInvoice'.date('Y-m-d H:i').'.pdf';
            $this->load->library('mpdf');
            $mpdf = new mPDF('bn','A4','','','5','5','10','18');
            $mpdf->useAdobeCJK = true;
            $mpdf->SetAutoFont(AUTOFONT_ALL);
            $mpdf->autoScriptToLang = true;
            $mpdf->autoLangToFont = true;
            $header = $this->load->view('header', $data, true);
            $html=$this->load->view('common/viewMaterialUsing', $data, true);
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

    public function getproductinfo() {
        $ITEM_CODE = $this->input->post('ITEM_CODE');
        $department_id = $this->input->post('department_id');
        $info = $this->db->query("SELECT p.*,u.unit_name 
         FROM product_info p, product_unit u
          WHERE p.unit_id=u.unit_id 
          AND p.product_code='$ITEM_CODE' 
          AND p.department_id=$department_id")->row(); 
       echo json_encode($info);
    }

    public function getitemAllFifo(){
      $ITEM_CODE = $this->input->post('ITEM_CODE');
      $department_id = $this->input->post('department_id');
       //////////////////////////////
      $detail=$this->db->query("SELECT a.*,
        IFNULL(SUM(a.QUANTITY),0) as main_stock
        FROM stock_master_detail a
        WHERE a.department_id=$department_id 
        AND  a.ITEM_CODE='$ITEM_CODE'
        GROUP BY a.FIFO_CODE 
        ORDER BY a.FIFO_CODE DESC")->result();
       $i=0;
       $id=0;
        if(isset($detail)):
          foreach ($detail as  $value) {
            if($value->main_stock>0){
             $str='<tr id="row_' . $id . '"><td style="text-align:center"><b>' . ($id +1).'</b></td> <td><input type="hidden" name="LOCATION[]"  value="'.$value->LOCATION.'"  id="LOCATION_'  .$id. '"> <input type="text" name="FIFO_CODE[]" class="form-control" readonly placeholder="'.$value->FIFO_CODE.'" value="'.$value->FIFO_CODE.'"  style="margin-bottom:5px;width:98%" id="FIFO_CODE_'  .$id. '"/> </td>';
          
            $str.= '<td> <input type="text" name="stock[]" readonly class="form-control" placeholder="Stock" 
            value="'.$value->main_stock.'" style="margin-bottom:5px;width:98%;text-align:center" id="stock_'.$id.'"> </td>';
            $str.= '<td> <input type="text" name="QUANTITY[]" value="0" class="form-control"  placeholder="QUANTITY" style="width:98%;float:left;text-align:center"  id="QUANTITY_' .$id. '"> </td>';
            $str.= '<td><input type="text" readonly name="UPRICE[]"  class="form-control" placeholder="Unit Price" 
            value="'.$value->UPRICE.'" style="margin-bottom:5px;width:98%;text-align:center" id="UPRICE_'.$id.'"> </td>';
         
            $str.='<td><input type="text" name="CRRNCY[]" readonly class="form-control" placeholder="Currency" value="'.$value->CRRNCY.'" style="margin-bottom:5px;width:98%;text-align:center" id="CRRNCY_'.$id.'"></td> ';
            $str.= '</tr>';
            echo $str;
          
          $id++;
        }
        }
        endif;
    }
 
   
 }