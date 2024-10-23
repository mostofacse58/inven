<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Po extends My_Controller {
function __construct(){
        parent::__construct();
        $this->load->model('format/purhrequisn_model');
        $this->load->model('format/po_model');
        $this->load->model('format/requisition_model');
        $this->load->model('format/deptrequisn_model');
        //UPDATE `po_master` SET `subtotal`=`total_amount`,`discount_amount`=0 WHERE 1;
     }
    
function lists(){
      if($this->session->userdata('user_id')) {
      $data=array();
      if($this->input->post('perpage')!='') $perpage=$this->input->post('perpage'); 
      else $perpage=10;
      ////////////////////////////////////
      $this->load->library('pagination');
      $config['base_url']=base_url().'format/po/lists/';
      $config['suffix'] = '?' . http_build_query($_GET, '', "&");
      $config["uri_segment"] = 4;
      $config['total_rows'] = $this->po_model->get_count();
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
      ////////////////////////////////////////
      $this->pagination->initialize($config); 
      $data['page'] = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
      $pagination = $this->pagination->create_links();
      $data['pagination']='<p>We have ' . $total_rows . ' records in ' . $choice . ' pages ' . $pagination . '</p>';      
      $data['lists']=$this->po_model->lists($config["per_page"],$data['page'] );
      $data['dlist']=$this->look_up_model->departmentList();
      $data['slist']=$this->look_up_model->getSupplier();
      ////////////////////////////////////////
      $data['heading']='PO/WO Lists';
      $data['display']='format/po_lists';
      $this->load->view('admin/master',$data);
      } else {
        redirect("logincontroller");
      }
  }

function add(){
    if($this->session->userdata('user_id')) {
      $data['collapse']='YES';
      $data['heading']='Add PO';
      $data['for_department_id']=$this->session->userdata('department_id');
      $data['clist']=$this->look_up_model->clist();
      $data['blist']=$this->look_up_model->getBranch();
      $data['ptlist']=$this->look_up_model->getPOType();
      $data['slist']=$this->look_up_model->getSupplier();
      $data['dlist']=$this->look_up_model->departmentList();
      $data['plist']=$this->look_up_model->payment_term();
      $data['display']='format/addpo';
      $this->load->view('admin/master',$data);
    }else{
      redirect("logincontroller");
    }
  }
  function addpitowo($pi_id){
    if($this->session->userdata('user_id')) {
      $data['collapse']='YES';
      $data['heading']='Add PO';
      $info=$this->deptrequisn_model->get_info($pi_id);
      $data['for_department_id']=$info->department_id;
      $data['clist']=$this->look_up_model->clist();
      $data['ptlist']=$this->look_up_model->getPOType();
      $data['slist']=$this->look_up_model->getSupplier();
      $data['dlist']=$this->look_up_model->departmentList();
      $data['plist']=$this->look_up_model->payment_term();
      $data['detail']=$this->po_model->getPIDetails($pi_id);
      $data['blist']=$this->look_up_model->getBranch();
      $data['suppcheck']='YES';
      $data['display']='format/addpo';
      $this->load->view('admin/master',$data);
    }else{
      redirect("logincontroller");
    }
  }
  function edit($po_id){
    if ($this->session->userdata('user_id')) {
      $data['collapse']='YES';
      $data['heading']='Edit PO';
      $data['suppcheck']='YES';
      $data['ptlist']=$this->look_up_model->getPOType();
      $data['clist']=$this->look_up_model->clist();
      $data['blist']=$this->look_up_model->getBranch();
      $data['info']=$this->po_model->get_info($po_id);
      $data['for_department_id']=$data['info']->for_department_id;
      $data['dlist']=$this->look_up_model->departmentList();
      $data['slist']=$this->look_up_model->getSupplier();
      $data['plist']=$this->look_up_model->payment_term();
      $data['detail']=$this->po_model->getDetails($po_id);
      $data['display']='format/addpo';
      $this->load->view('admin/master',$data);
      } else {
         redirect("logincontroller");
      }
  }
 
  function adddiscount($po_id=FALSE){
      $data['collapse']='YES';
      $data['show']=1;
      $data['info']=$this->po_model->get_info($po_id);
      $data['detail']=$this->po_model->getDetails($po_id);
      $data['heading']='PO/WO Information';
      $data['display']='format/adddiscount';
      $this->load->view('admin/master',$data);
  }
  function prtopo($requisition_id){
      $data['collapse']='YES';
      $data['heading']='Edit PO';
      $data['ptlist']=$this->look_up_model->getPOType();
      $data['clist']=$this->look_up_model->clist();
      $data['dlist']=$this->look_up_model->departmentList();
      $info=$this->requisition_model->get_info($requisition_id);
      $data['detail']=$this->po_model->getPRDetails($requisition_id);
      $data['department_id']=$info->department_id;
      $data['display']='format/addpo';
      $this->load->view('admin/master',$data);
  }

 function save($po_id=FALSE){
    $check=$this->po_model->save($po_id);
    if($check && !$po_id){
     $this->session->set_userdata('exception','Saved successfully');
     }elseif($check&& $po_id){
         $this->session->set_userdata('exception','Update successfully');
     }else{
       $this->session->set_userdata('exception','Submission Failed');
     }
    redirect("format/po/lists");
  }
  function savediscount($po_id=FALSE){
    $check=$this->po_model->savediscount($po_id);
    if($check){
       $this->session->set_userdata('exception','Update successfully');
     }else{
       $this->session->set_userdata('exception','Submission Failed');
     }
    redirect("format/po/lists");
  }
  function delete($po_id=FALSE){
    $check=$this->po_model->delete($po_id);
      if($check){ 
         $this->session->set_userdata('exception','Delete successfully');
       }else{
         $this->session->set_userdata('exception','Delete Failed');
      }
    redirect("format/po/lists");
  }
  /////////////////////////////
  public function suggestions(){
      $term = $this->input->get('term', true);
      $for_department_id = $this->input->get('for_department_id', true);
      if (strlen($term) < 1 || !$term) {
          die("<script type='text/javascript'>setTimeout(function(){ window.top.location.href = '" . base_url('dashboard') . "'; }, 10);</script>");
      }
      $rows = $this->look_up_model->getdepartmentwiseItem($for_department_id,$term);
      if ($rows){
          $c = str_replace(".", "", microtime(true));
          $r = 0;
          foreach ($rows as $row) {
            $product_name="$row->product_name";
              $pr[] = array('id' => ($c + $r), 'product_id' => $row->product_id,'safety_qty' => $row->minimum_stock, 'label' => $row->product_name . " (" . $row->product_code . ")". " (Stock=" . $row->main_stock . ")",'category_name' => $row->category_name ,'unit_name' => $row->unit_name,'product_name' =>$product_name ,'product_code' => $row->product_code, 'unit_price' => $row->unit_price,'image_link' => $row->product_image, 'stock' =>$row->main_stock, 'currency' =>$row->currency);
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
  function viewforapproved($po_id=FALSE){
      $data['show']=1;
      $data['info']=$this->po_model->get_info($po_id);
      $data['detail']=$this->po_model->getDetails($po_id);
      $data['heading']='PO/WO Information';
      $data['display']='format/woviewhtml';
      $this->load->view('admin/master',$data);
  }
  public function getcount(){
    $supplier_id = $this->input->post('supplier_id');
    $department_id = $this->input->post('for_department_id');
    $detail=$this->db->query("SELECT prd.*
      FROM pi_item_details  prd,pi_master pm 
      WHERE prd.supplier_id=$supplier_id 
      AND prd.pi_id=pm.pi_id AND pm.pi_status=7
      AND prd.department_id=$department_id 
      AND  prd.supplier_id NOT IN(SELECT po.supplier_id FROM po_pline po
      WHERE po.product_id=prd.product_id AND prd.pi_no=po.pi_no) ")->result();
    echo count($detail);
   
  }
  public function getSuppItem(){
    $supplier_id = $this->input->post('supplier_id');
    $department_id = $this->input->post('for_department_id');
    $detail=$this->db->query("SELECT prd.*,pm.pi_no
      FROM pi_item_details  prd, pi_master pm 
      WHERE prd.supplier_id=$supplier_id 
      AND prd.pi_id=pm.pi_id AND pm.pi_status=7
      AND prd.department_id=$department_id 
      AND  prd.supplier_id NOT IN(SELECT po.supplier_id FROM po_pline po
      WHERE po.product_id=prd.product_id 
      AND prd.pi_no=po.pi_no) ")->result();
    $i=0;
    $id=0;
    ///////////////
    if(isset($detail)):
      foreach ($detail as  $value) {
        $str='<tr id="row_' . $id . '"><td style="text-align:center"><input type="hidden" value="'.$value->product_id.'" name="product_id[]"  id="product_id_' . $id . '"/><b>' . ($id +1).'</b></td>';
      $str.='<td><textarea type="text" readonly name="product_code[]" class="form-control"  placeholder="Material Code  style="margin-bottom:5px;width:98%" id="product_item_'  .$id. '">'.$value->product_code.'</textarea> </td>';
      $str.='<td><textarea type="text" name="product_name[]" readonly class="form-control" placeholder="'.$value->product_name.'"  style="margin-bottom:5px;width:98%" id="product_item_'  .$id. '">'.$value->product_name.'</textarea></td>';
      $str.='<td><textarea type="text" name="specification[]"  class="form-control"  style="margin-bottom:5px;width:98%" id="specification_'  .$id. '">'.$value->specification.'</textarea></td>';
      $str.='<td> <input type="text" name="quantity[]" value="'.$value->purchased_qty.'" onblur="return checkQuantity('.$id. ');" onClick="this.select();" onkeyup="return checkQuantity('.$id. ');" class="form-control"  placeholder="Quantity" style="width:98%;float:left;text-align:center"  id="quantity_'.$id. '"> </td>';

      $str.='<td><input type="text" name="unit_name[]" readonly class="form-control" style="margin-bottom:5px;width:98%;text-align:center" value="'.$value->unit_name.'"  id="unit_name_' .$id.'"></td>' ;
      $str.='<td> <input type="text" name="unit_price[]" class="form-control" onClick="this.select();" placeholder="Price" style="margin-bottom:5px;width:98%;text-align:center" value="'.$value->unit_price.'" id="unit_price_'.$id. '" onblur="return checkUnitPrice('.$id.');" onClick="this.select();" onkeyup="return checkUnitPrice('.$id. ');"> </td>';

      $str.='<td> <input type="text" name="sub_total_amount[]" readonly class="form-control" placeholder="Sub Total" style="margin-bottom:5px;width:98%;text-align:center" value="'.$value->amount.'" id="sub_total_amount_'.$id.'"/> </td>';
      $str.='<td><input type="text" readonly name="pi_no[]" class="form-control" placeholder="PI NO" style="margin-bottom:5px;width:98%;text-align:center" id="pi_no_' .$id. '" value="'.$value->pi_no.'"></td>';
      $str.='<td><textarea name="remarks[]" class="form-control" placeholder="Remarks"  style="margin-bottom:0px;width:98%;padding: 2px 9px;" rows="2" id="remarks_'.$id.'"></textarea> </td>';
      $str.='<td style="text-align:center"><span class="btn btn-danger btn-xs" onclick="return deleter('.$id.');" style="margin-top:5px;"><i class="fa fa-trash-o"></i></span></td></tr>';
      echo $str;
      $id++;
      
     }
    endif;
}
  
  
  function submit($po_id=FALSE){
    $this->load->model('communication');
    $data['info']=$this->po_model->get_info($po_id); 
    $department_id=$data['info']->department_id;
    $emailaddress="roc.tan@bdventura.com";
    $subject="PO/WO Approval Notification";
    $message=$this->load->view('po_approval_email', $data,true); 
    //$this->communication->send($emailaddress,$subject,$message);
  ////////////////////////
  $check=$this->po_model->submit($po_id);
    if($check){ 
      $this->session->set_userdata('exception','Send successfully');
     }else{
      $this->session->set_userdata('exception','Send Failed');
    }
  redirect("format/po/lists");
  }
  function aknoledgement($po_id=FALSE){
  //   $this->load->model('communication');
  //   $data['info']=$this->po_model->get_info($po_id); 
  //   $department_id=$data['info']->department_id;
  //   $emailaddress="roc.tan@bdventura.com";
  //   $subject="PO/WO Approval Notification";
  //   $message=$this->load->view('po_approval_email', $data,true); 
  // //$this->communication->send($emailaddress,$subject,$message);
  // ////////////////////////
    $check=$this->po_model->aknoledgements($po_id);
      if($check){ 
        $this->session->set_userdata('exception','Acknowledgement successfully');
       }else{
        $this->session->set_userdata('exception','Acknowledgement Failed');
      }
    redirect("format/po/lists");
  }

  //////////////////////
   function deleteitem(){
      $po_id=$this->input->post('po_id');
      $product_id=$this->input->post('product_id');
      $chkiteminfo=$this->db->query("SELECT * FROM po_item_details 
            WHERE po_id=$po_id AND product_id=$product_id")->row();
      if(count($chkiteminfo)>0){
       $textpo.=" Remove this item ".$chkiteminfo->product_name." qty ".$chkiteminfo->required_qty."<br>";
      }
      if($textpo!=''){
        $data4['update_text']=$textpo;
        $data4['update_date']=date('Y-m-d');
        $data4['po_id']=$po_id;
        $this->db->insert('po_update_info',$data4);
       }
       $this->db->WHERE('po_id',$po_id);
       $this->db->WHERE('product_id',$product_id);
       $this->db->delete('po_item_details');
    echo TRUE;
  }
  function rejected($po_id=FALSE){
    $check=$this->po_model->rejected($po_id);
      if($check){ 
        $this->session->set_userdata('exception','Reject successfully');
       }else{
        $this->session->set_userdata('exception','Failed');
      }
    redirect("format/purhrequisn/lists");
  }
  function changeDate(){
      $po_id=$this->input->post('po_id');
      $data['delivery_date2']=alterDateFormat($this->input->post('delivery_date2'));
      $data['delivery_date3']=alterDateFormat($this->input->post('delivery_date3'));
      $this->db->where('po_id', $po_id);
      $this->db->update('po_master',$data);
      $this->session->set_userdata('exception','Save successfully');
      redirect("format/po/lists");
  }
  function giveRating(){
      $po_id=$this->input->post('po_id2');
      $data['resposive_rate']=$this->input->post('resposive_rate');
      $data['rate_submit_date']=date('Y-m-d');
      $this->db->where('po_id', $po_id);
      $this->db->update('po_master',$data);
      $this->session->set_userdata('exception','Save successfully');
      redirect("format/po/lists");
  }
   
}