<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Rfq extends My_Controller {
    function __construct(){
        parent::__construct();
        $this->load->model('proc/rfq_model');
        
     }
    function lists(){
       $data=array();
        if($this->input->post('perpage')!='') 
        $perpage=$this->input->post('perpage'); else $perpage=20;
        $this->load->library('pagination');
        $config['base_url']=base_url().'proc/rfq/lists/';
        $config['suffix'] = '?' . http_build_query($_GET, '', "&");
        $config["uri_segment"] = 4;
        $config['total_rows'] = $this->rfq_model->get_count();
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
        $data['list']=$this->rfq_model->lists($config["per_page"],$data['page']);
        $this->form_validation->set_rules('location','Location','trim');
        $this->form_validation->set_rules('employee_name','Name','trim');
        $data['llist']=$this->look_up_model->getlocation();
        $data['dlist']=$this->look_up_model->departmentList();
        $data['slist']=$this->look_up_model->getSupplier();
        ////////////////////////////
        $data['heading']='RFQ List';
        $data['display']='proc/rfqlist';
        $this->load->view('admin/master',$data);
       }


    function add(){
      if($this->session->userdata('user_id')) {
        $data['heading']='Add RFQ';
        $data['collapse']='YES';
        $data['dlist']=$this->look_up_model->departmentList();
        $data['slist']=$this->look_up_model->getSupplier();
        $data['clist']=$this->look_up_model->clist();
        $data['display']='proc/addrfq';
        $this->load->view('admin/master',$data);
      }else{
        redirect("logincontroller");
      }
    }
    
    function edit($rfq_id){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Edit RFQ';
        $data['info']=$this->rfq_model->get_info($rfq_id);
        $data['slist']=$this->look_up_model->getSupplier();
        $data['dlist']=$this->look_up_model->departmentList();
        $data['clist']=$this->look_up_model->clist();
        $data['detail']=$this->rfq_model->getDetails($rfq_id);
        $data['display']='proc/editrfq';
        $this->load->view('admin/master',$data);
        } else {
          redirect("logincontroller");
        }
    }
   function save($rfq_id=FALSE){
      $check=$this->rfq_model->save($rfq_id);
      if($check && !$rfq_id){
       $this->session->set_userdata('exception','Saved successfully');
       }elseif($check&& $rfq_id){
           $this->session->set_userdata('exception','Update successfully');
       }else{
         $this->session->set_userdata('exception','Submission Failed');
       }
    redirect("proc/rfq/lists");
  }
  function delete3($rfq_id=FALSE){
    $check=$this->rfq_model->delete($rfq_id);
      if($check){ 
         $this->session->set_userdata('exception','Delete successfully');
       }else{
         $this->session->set_userdata('exception','Delete Failed');
      }
    redirect("proc/rfq/lists");
  }
  function deletefull2($rfq_id=FALSE){
    $department_id=$this->session->userdata('department_id');
    $detail=$this->rfq_model->getDetails($rfq_id);
    foreach ($detail as $value){
      $FIFO_CODE=$value->FIFO_CODE;
      $this->db->WHERE('FIFO_CODE',$FIFO_CODE);
      $this->db->WHERE('department_id',$department_id);
      $this->db->delete('item_issue_detail');
      $this->db->WHERE('FIFO_CODE',$FIFO_CODE);
      $this->db->WHERE('department_id',$department_id);
      $this->db->delete('stock_master_detail');
      $this->db->WHERE('FIFO_CODE',$FIFO_CODE);
      $this->db->WHERE('department_id',$department_id);
      $this->db->delete('rfq_detail');
    } 
    $this->session->set_userdata('exception','Delete successfully');
    $this->db->WHERE('rfq_id',$rfq_id);
    $this->db->WHERE('department_id',$department_id);
    $this->db->delete('rfq_master');
    redirect("proc/rfq/lists");
}


  function view($rfq_id=FALSE){
      $data['show']=1;
      $data['controller']=$this->router->fetch_class();
      $data['heading']='RFQ Form';
      $data['info']=$this->rfq_model->get_info($rfq_id);
      $data['detail']=$this->rfq_model->getDetails($rfq_id);
      $data['display']='proc/rfqview';
      $this->load->view('admin/master',$data);
    }
function viewpdf($rfq_id=FALSE){
  if ($this->session->userdata('user_id')) {
  $data['heading']='RFQ Items ';
      $data['info']=$this->rfq_model->get_info($rfq_id);
      $data['detail']=$this->rfq_model->getDetails($rfq_id);
      $pdfFilePath='ItemRFQInvoice'.date('Y-m-d H:i').'.pdf';
      $this->load->library('mpdf');
      $mpdf = new mPDF('bn','A4','','','5','5','10','18');
      $mpdf->useAdobeCJK = true;
      $mpdf->SetAutoFont(AUTOFONT_ALL);
      $mpdf->autoScriptToLang = true;
      $mpdf->autoLangToFont = true;
      $header = $this->load->view('header', $data, true);
      $html=$this->load->view('proc/viewItemsInvoice', $data, true);
      $mpdf->setHtmlHeader($header);
      $mpdf->pagenumPrefix = '  Page ';
      $mpdf->pagenumSuffix = ' - ';
      $mpdf->nbpgPrefix = ' out of ';
      $mpdf->nbpgSuffix = '';
      $mpdf->setFooter('{DATE H:i:s j/m/Y}{PAGENO}{nbpg}');
      $mpdf->WriteHTML($html);
      $mpdf->Output($pdfFilePath,'D');
  } else {
     redirect("logincontroller");
  }
}
//////////////////////////////
public function getRFIInfo(){
  $department_id=$this->session->userdata('department_id');
  $rfi_no = $this->input->post('rfi_no');
  $rfi_no=str_replace(" ","",$rfi_no);
  $info=$this->db->query("SELECT pm.*   
      FROM rfi_master pm 
      WHERE 1")->row();
  if($info){
    $data=array('check'=>'YES','currency'=>$info->currency,
      'for_department_id'=>$info->department_id,
      'rfi_id'=>$info->rfi_id,
      'rfi_no'=>$info->rfi_no);
  }else{
    $data=array('check'=>'NO');
  }
  echo  json_encode($data);
}
///////////////////////////////
public function getRFIwiseitem(){
    $blist=$this->look_up_model->get_box();
    $department_id=$this->session->userdata('department_id');
    $rfi_no = $this->input->post('rfi_no');
    $rfi_no=str_replace(" ","",$rfi_no);
    $detail=$this->db->query("SELECT pm.* ,prd.*,prd.quantity    
      FROM rfi_item_details prd,rfi_master pm
      WHERE pm.rfi_id=prd.rfi_id 
      AND pm.rfi_status=3
      AND pm.rfi_no='$rfi_no' ")->result();
    $i=0;
    $id=0;
    ///////////////
    if(isset($detail)):
      foreach ($detail as  $value) {
        $product_id=$value->product_id;
        $quantity=$value->quantity;
        if($quantity>0){
        $str='<tr id="row_' . $id . '"><td style="text-align:center"><input type="hidden" value="'.$value->product_id.'" name="product_id[]"  id="product_id_' . $id . '"/><b>' . ($id +1).'</b></td> <td> <input type="text" name="product_name[]" readonly class="form-control" placeholder="'.$value->product_name.'" value="'.$value->product_name.'"  style="margin-bottom:5px;width:98%" id="product_item_'  .$id. '"> </td>';
        $str.='<td><input type="text" name="product_code[]" readonly class="form-control" placeholder="Item Code" value="'.$value->product_code.'"  style="margin-bottom:5px;width:98%" id="product_code_'.$id. '"> </td>';
        $str.='<td><input type="text" name="specification[]" class="form-control" value="'.$value->specification.'"  style="margin-bottom:5px;width:98%" id="specification_'.$id. '"> </td>';

        $str.='<td><input type="text" name="quantity[]" readonly value="'.$quantity.'" onblur="return checkQuantity(' .$id.');" onkeyup="return checkQuantity(' .$id.');" class="form-control"  placeholder="Quantity" style="width:60%;float:left;text-align:center"  id="quantity_' .$id. '"> </td>';

        $str.='<td> <input type="text" name="unit_price[]"  class="form-control" placeholder="Unit Price" value="0.00" onblur="return calculateRow(' .$id.');" onkeyup="return calculateRow(' .$id.');"  style="margin-bottom:5px;text-align:center" id="unit_price_'.$id.'"/> </td>';
        $str.='<td> <input type="text" name="amount[]" readonly class="form-control" placeholder="Amount" value="0.00"   style="margin-bottom:5px;width:98%;text-align:center" id="amount_'.$id.'"> </td>';

        $str.='<td> <a class="btn btn-danger btn-xs" onclick="return deleter('. $id .');" style="margin-top:5px;"><i class="fa fa-trash-o"></i></a></td></tr>';
           echo $str;
      $id++;
      }
     }
    endif;
}
function submit($rfq_id=FALSE){
  $this->load->model('communication');
    $data['info']=$this->rfq_model->get_info($rfq_id); 
    $department_id=$data['info']->for_department_id;
    $emailaddress=$this->db->query("SELECT dept_head_email FROM department_info 
      WHERE department_id=$department_id")->row('dept_head_email');
    $subject="GRN RFQ Notification";
    $message=$this->load->view('grn_received_email', $data,true); 
  //$this->communication->send($emailaddress,$subject,$message);
  ////////////////////////
  $check=$this->rfq_model->submit($rfq_id);
    if($check){ 
      $this->session->set_userdata('exception','Send successfully');
     }else{
      $this->session->set_userdata('exception','Send Failed');
    }
  redirect("proc/rfq/lists");
  }

  //////////////////AJAX FOR DELETIN PRODUCT/////////////
  function checkItemsUse($rfq_id){
    $chk=$this->db->query("SELECT pd.* FROM rfq_detail pd
         WHERE pd.rfq_id=$rfq_id 
         AND pd.FIFO_CODE IN (SELECT u.FIFO_CODE FROM spares_use_detail u 
         WHERE pd.product_id=u.product_id) ")->result();

    $chk2=$this->db->query("SELECT pd.* FROM rfq_detail pd
         WHERE  pd.rfq_id=$rfq_id 
         AND pd.FIFO_CODE IN (SELECT u.FIFO_CODE FROM item_issue_detail u 
         WHERE pd.product_id=u.product_id) ")->result();

    if((count($chk)+count($chk2))>0){
        echo "EXISTS";
    }else{
        echo "DELETABLE";
    }
  }

      
 }