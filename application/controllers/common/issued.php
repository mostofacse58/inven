<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Issued extends My_Controller {
    function __construct(){
        parent::__construct();
        $this->load->model('common/issued_model');
        $this->load->model('shipping/import_model');
     }
    
    function lists(){
      $data=array();
          $data=array();
        if($this->input->post('perpage')!='') 
        $perpage=$this->input->post('perpage'); else $perpage=20;
        $this->load->library('pagination');
        $config['base_url']=base_url().'common/issued/lists/';
        $config['suffix'] = '?' . http_build_query($_GET, '', "&");
        $config["uri_segment"] = 4;
        $config['total_rows'] = $this->issued_model->get_count();
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
        $total_rows=$config['total_rows'];
        $pagination = $this->pagination->create_links();
        $data['pagination']='<p>We have ' . $total_rows . ' records in ' . $choice . ' pages ' . $pagination . '</p>';
        $data['list']=$this->issued_model->lists($config["per_page"],$data['page']);
        $this->form_validation->set_rules('location','Location','trim');
        $this->form_validation->set_rules('employee_name','Name','trim');
        $data['llist']=$this->look_up_model->getlocation();
        ////////////////////////////
        $data['heading']='Issued List';
        $data['display']='common/issuedlist';
        $this->load->view('admin/master',$data);
       }
    function add(){
      $data['collapse']='YES';
      $data['heading']='Add Issue';
      $data['clist']=$this->look_up_model->clist();
      $department_id=$this->session->userdata('department_id');
      $data['dlist']=$this->look_up_model->departmentList();
      $data['mlist']=$this->look_up_model->getMainProductSerial();
      $data['llist']=$this->look_up_model->getlocation();
      $data['flist']=$this->import_model->getdata('shipping_file_style_info');
      $data['display']='common/addissued';
      $this->load->view('admin/master',$data);
    }

    function edit($issue_id){
      $data['collapse']='YES';
      $data['heading']='Edit Issue';
      $data['clist']=$this->look_up_model->clist();
      $department_id=$this->session->userdata('department_id');
      $data['info']=$this->issued_model->get_info($issue_id);
      $data['dlist']=$this->look_up_model->departmentList();
      $data['detail']=$this->issued_model->getDetails($issue_id);
      $data['mlist']=$this->look_up_model->getMainProductSerial();
      $data['llist']=$this->look_up_model->getlocation();
      $data['flist']=$this->import_model->getdata('shipping_file_style_info');
      $data['display']='common/addissued';
      $this->load->view('admin/master',$data);
     }
    function searchemployee(){
       $item=$this->input->post('item');
       $department_id=$this->input->post('department_id');
        $data=$this->db->query("SELECT * FROM employee_info 
          WHERE department_id=$department_id 
          AND (employee_name LIKE '%$item%' OR  emp_card_id='$item') ")->result();
       foreach($data as $service):
            echo "<li class='employee_class'  data-ids='".$service->employee_id."' onclick='addFieldEmployee(this);'>".$service->emp_card_id."</li>";
        endforeach;
    }
    function save($issue_id=FALSE){
        $department_id=$this->session->userdata('department_id');
        $this->form_validation->set_rules('issue_type','Issue type','trim|required');
        $this->form_validation->set_rules('issue_date','Date','trim|required');
         if ($this->form_validation->run() == TRUE) {
          /////////////////////////////////
          $product_id=$this->input->post('product_id');
          $product_code=$this->input->post('product_code');
          $FIFO_CODE=$this->input->post('FIFO_CODE');
          $quantity=$this->input->post('quantity');
          $i=0;
          foreach ($product_id as $value) {
            $fifo=$FIFO_CODE[$i];
            $product_code1=$product_code[$i];
            $fifoStock=$this->db->query("SELECT IFNULL(SUM(sm.QUANTITY),0) as fifoStock
              FROM stock_master_detail sm
              WHERE sm.department_id=$department_id 
              AND sm.product_id=$value 
              AND sm.FIFO_CODE='$fifo' ")->row('fifoStock');

            // $main_stock=$this->db->query("SELECT p.main_stock
            //   FROM product_info p
            //   WHERE p.department_id=$department_id 
            //   AND p.product_id=$value")->row('main_stock');
            $preIssueQty=0;
            if($issue_id!=FALSE){
              $preIssueQty=$this->db->query("SELECT IFNULL(SUM(quantity),0) as quantity 
              FROM item_issue_detail
              WHERE issue_id=$issue_id 
              AND product_id=$value ")->row('quantity');
            }
          // echo "$fifoStock  =$preIssueQty =$main_stock"; exit();

            if($quantity[$i]>($fifoStock+$preIssueQty)) {
              $this->session->set_userdata('exception',"This $product_code1 stock not available");
              if($issue_id==FALSE)
                redirect("common/issued/add");  
              else 
                redirect("common/issued/edit/$issue_id"); 
            }
            $i++;
          }
        /////////////////////////////////
        $check=$this->issued_model->save($issue_id);
        if($check && !$issue_id){
           $this->session->set_userdata('exception','Saved successfully');
           }elseif($check&& $issue_id){
               $this->session->set_userdata('exception','Update successfully');
           }else{
             $this->session->set_userdata('exception','Submission Failed');
           }
        redirect("common/issued/add");
       }else{
          $data['heading']='Add Issue';
          if($issue_id){
            $data['heading']='Edit Issue';
            $data['info']=$this->issued_model->get_info($issue_id);  
          }
          $data['dlist']=$this->look_up_model->departmentList();
          $data['mlist']=$this->look_up_model->getMainProductSerial();
          $data['flist']=$this->import_model->getdata('shipping_file_style_info');
          $data['display']='common/addissued';
          $this->load->view('admin/master',$data);
       }
    }

    function delete($issue_id=FALSE){
      $check=$this->issued_model->delete($issue_id);
        if($check){ 
           $this->session->set_userdata('exception','Delete successfully');
         }else{
           $this->session->set_userdata('exception','Delete Failed');
        }
      redirect("common/issued/lists");
    }
  ////////////////////////
  public function suggestions(){
        $term = $this->input->get('term', true);
        if (strlen($term) < 1 || !$term) {
            die("<script type='text/javascript'>setTimeout(function(){ window.top.location.href = '" . base_url('dashboard') . "'; }, 10);</script>");
        }
        $rows=$this->look_up_model->getItemFifoWise($term);
        if($rows){
            $c = str_replace(".", "", microtime(true));
            $r = 0;
            foreach ($rows as $row) {
              if($row->main_stock>0){
              $stock=$row->main_stock;
              $pr[] = array('id' => ($c + $r), 'product_id' => $row->product_id, 
                'label' => $row->product_name . " (" . $row->product_code . ")". "-(FIFO=" . $row->FIFO_CODE . ")-(Stock=" . $row->main_stock . ")-(Spec=". $row->specification . ")",
                'currency' => $row->currency ,'unit_name' => $row->unit_name,'FIFO_CODE' => $row->FIFO_CODE, 'product_name' => $row->product_name,'product_code' => $row->product_code,'unit_price' => $row->unit_price, 'stock' =>$stock, 'cnc_rate_in_hkd' =>$row->cnc_rate_in_hkd, 'specification' =>$row->specification);
              $r++;}
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
    public function getprinfo(){
      $requisition_no = $this->input->post('requisition_no');
      $info=$this->db->query("SELECT pm.* ,pd.product_detail_id   
          FROM  requisition_master pm 
          LEFT JOIN product_detail_info pd ON(pd.asset_encoding=pm.asset_encoding OR pd.tpm_serial_code=pm.asset_encoding OR pd.ventura_code=pm.asset_encoding)
          WHERE pm.requisition_no='$requisition_no' AND pm.general_or_tpm=1")->row();
      $data=array('department_id'=>$info->department_id,
        'employee_id'=>$info->employee_id,
        'asset_encoding'=>$info->asset_encoding,
        'product_detail_id'=>$info->product_detail_id,
        'line_id'=>$info->line_id,
        'location_id'=>$info->location_id,
        'file_no'=>$info->file_no);
      echo  json_encode($data);
    }
    public function getprwiseitem(){
        $requisition_no = $this->input->post('requisition_no');
        // $detail=$this->db->query("SELECT p.* ,prd.*,u.unit_name,c.category_name
        //   FROM requisition_item_details prd
        //   INNER JOIN requisition_master pr ON(pr.requisition_id=prd.requisition_id)
        //   INNER JOIN product_info p ON(prd.product_id=p.product_id)
        //   INNER JOIN product_unit u ON(u.unit_id=p.unit_id)
        //   INNER JOIN category_info c ON(c.category_id=p.category_id)
        //   WHERE pr.requisition_no='$requisition_no' ")->result();
      $requisition_id=$this->db->query("SELECT requisition_id 
        FROM requisition_master 
        WHERE requisition_no='$requisition_no'")->row('requisition_id');
        //////////////////////////////
      $department_id=$this->session->userdata('department_id');
      $medical_yes=$this->session->userdata('medical_yes');
      $data=date('Y-m-d');
      $detail=$this->db->query("SELECT IFNULL(SUM(sm.QUANTITY),0) as main_stock,
        sm.CRRNCY as currency,sm.EXCH_RATE as cnc_rate_in_hkd,sm.FIFO_CODE,
        sm.UPRICE as unit_price,p.product_id,
        p.product_name,p.product_code,u.unit_name,
        prd.required_qty,sm.specification
        FROM stock_master_detail sm
        INNER JOIN product_info p ON(p.product_id=sm.product_id)
        INNER JOIN requisition_item_details prd ON(p.product_id=prd.product_id)        
        INNER JOIN product_unit u ON(p.unit_id=u.unit_id)
        WHERE p.product_type=2 AND p.department_id=$department_id  
        AND sm.department_id=$department_id 
        AND  prd.requisition_id=$requisition_id
        GROUP BY sm.product_id,sm.FIFO_CODE 
        ORDER BY sm.product_id DESC,sm.FIFO_CODE ASC")->result();
       $i=0;
       $id=0;
        if(isset($detail)):
          foreach ($detail as  $value) {
            if($value->main_stock>0){
            $stock=$value->main_stock;
            $sub_total=$value->required_qty*$value->unit_price;
             $str='<tr id="row_' . $id . '"><td style="text-align:center"><input type="hidden" value="'.$value->product_id.'" name="product_id[]"  id="product_id_' . $id . '"/><b>' . ($id +1).'</b></td> <td> <input type="text" name="product_name[]" class="form-control" readonly placeholder="'.$value->product_name.'" value="'.$value->product_name.'"  style="margin-bottom:5px;width:98%" id="product_item_'  .$id. '"/> </td>';
            $str.= '<td> <input type="text" name="product_code[]" readonly class="form-control" placeholder="Item Code" value="'.$value->product_code.'"  style="margin-bottom:5px;width:98%" id="product_code_'.$id. '"/> </td>';
            $str.= '<td> <input type="text" name="specification[]" readonly class="form-control" value="'.$value->specification.'"  style="margin-bottom:5px;width:98%" id="specification_'.$id. '"/> </td>';
            $str.= '<td><input type="text" readonly name="FIFO_CODE[]"  class="form-control" placeholder="FIFO_CODE" value="'.$value->FIFO_CODE.'"  style="margin-bottom:5px;width:98%" id="FIFO_CODE_'.$id. '"/> </td>';
            $str.= '<td> <input type="text" name="stock[]" readonly class="form-control" placeholder="Stock" 
            value="'.$stock.'" style="margin-bottom:5px;width:98%;text-align:center" id="stock_'.$id.'"> </td>';
            $str.= '<td> <input type="text" name="quantity[]" value="'.$value->required_qty.'" onblur="return checkQuantity(' .$id.');" onkeyup="return checkQuantity(' .$id.');" class="form-control"  placeholder="Quantity" style="width:60%;float:left;text-align:center"  id="quantity_' .$id. '"> <label  style="width:38%;float:left">'.$value->unit_name.'</label></td>';
            $str.= '<td><input type="text" readonly name="unit_price[]"  class="form-control" placeholder="Unit Price" 
            value="'.$value->unit_price.'" onblur="return calculateRow(' .$id.');" onkeyup="return calculateRow(' .$id.');" style="margin-bottom:5px;width:98%;text-align:center" id="unit_price_'.$id.'"> </td>';
            $str.= '<td> <input type="text" name="sub_total[]" readonly class="form-control" placeholder="Amount" 
            value="'.$sub_total.'" style="margin-bottom:5px;width:98%;text-align:center" id="sub_total_'.$id.'"> </td>';
            $str.='<td><input type="text" name="currency[]" readonly class="form-control" placeholder="Rate" 
                value="'.$value->currency.'" style="margin-bottom:5px;width:98%;text-align:center" id="currency_'.$id.'"></td> ';
            $str.= '<td> <input type="text" name="cnc_rate_in_hkd[]" readonly class="form-control" placeholder="Rate" 
                value="'.$value->cnc_rate_in_hkd.'" style="margin-bottom:5px;width:98%;text-align:center" id="cnc_rate_in_hkd_'.$id.'"> </td>';
            $str.= '<td style"text-align:center"><button class="btn btn-danger btn-xs" onclick="return deleter('. $id .');" style="margin-top:5px;"><i class="fa fa-trash-o"></i></button></td></tr>';
            echo $str;
          
          $id++;
         }
        }
        endif;
    }
    public function getFilewiseitem(){
      $file_no = $this->input->post('file_no');
      //////////////////////////////
      $department_id=$this->session->userdata('department_id');
      $medical_yes=$this->session->userdata('medical_yes');
      $data=date('Y-m-d');

      $detail=$this->db->query("SELECT sm.CRRNCY as currency,sm.box_name,
        sm.EXCH_RATE as cnc_rate_in_hkd,sm.FIFO_CODE,sm.specification,
        sm.UPRICE as unit_price,p.product_id,
        p.product_name,p.product_code,
        u.unit_name, 
        IFNULL(SUM(sm.QUANTITY),0)   as main_stock
        FROM stock_master_detail sm
        INNER JOIN product_info p ON(p.product_id=sm.product_id)
        INNER JOIN product_unit u ON(p.unit_id=u.unit_id)
        WHERE p.product_type=2 
        AND p.department_id=$department_id  
        AND sm.department_id=$department_id AND p.product_status=1
        AND sm.file_no ='$file_no' 
        GROUP BY sm.FIFO_CODE
        ORDER BY sm.id ASC")->result();
       $i=0;
       $id=0;

        if(isset($detail)):
          foreach ($detail as  $value) {
            if($value->main_stock>0){
            $stock=$value->main_stock;
            $PrieWithQty=$stock*$value->unit_price;
             $str='<tr id="row_' . $id . '"><td style="text-align:center"><input type="hidden" value="'.$value->product_id.'" name="product_id[]"  id="product_id_' . $id . '"/><b>' . ($id +1).'</b></td> <td> <input type="text" name="product_name[]" class="form-control" readonly placeholder="'.$value->product_name.'" value="'.$value->product_name.'"  style="margin-bottom:5px;width:98%" id="product_item_'  .$id. '"/> </td>';
            
            $str.= '<td> <input type="text" name="product_code[]" readonly class="form-control" placeholder="Item Code" value="'.$value->product_code.'"  style="margin-bottom:5px;width:98%" id="product_code_'.$id. '"/> </td>';
            $str.= '<td> <input type="text" name="specification[]" readonly class="form-control" value="'.$value->specification.'"  style="margin-bottom:5px;width:98%" id="specification_'.$id. '"/> </td>';
            $str.= '<td><input type="text" name="FIFO_CODE[]" readonly class="form-control" placeholder="FIFO_CODE" value="'.$value->FIFO_CODE.'"  style="margin-bottom:5px;width:98%" id="FIFO_CODE_'.$id. '"/> </td>';
            $str.= '<td> <input type="text" name="stock[]" readonly class="form-control" placeholder="Stock" 
            value="'.$stock.'" style="margin-bottom:5px;width:98%;text-align:center" id="stock_'.$id.'"> </td>';
            $str.= '<td> <input type="text" name="quantity[]" value="'.$stock.'" onblur="return checkQuantity(' .$id.');" onkeyup="return checkQuantity(' .$id.');" class="form-control"  placeholder="Quantity" style="width:60%;float:left;text-align:center"  id="quantity_' .$id. '" required> <label  style="width:38%;float:left">'.$value->unit_name.'</label></td>';
            $str.= '<td><input type="text" readonly name="unit_price[]"  class="form-control" placeholder="Unit Price" 
            value="'.$value->unit_price.'" onblur="return calculateRow(' .$id.');" onkeyup="return calculateRow(' .$id.');" style="margin-bottom:5px;width:98%;text-align:center" id="unit_price_'.$id.'"> </td>';
            $str.= '<td> <input type="text" name="sub_total[]" readonly class="form-control" placeholder="Amount" 
            value="'.$PrieWithQty.'" style="margin-bottom:5px;width:98%;text-align:center" id="sub_total_'.$id.'"> </td>';
            $str.='<td><input type="text" name="currency[]" readonly class="form-control" placeholder="Rate" 
                value="'.$value->currency.'" style="margin-bottom:5px;width:98%;text-align:center" id="currency_'.$id.'"></td> ';
            $str.= '<td> <input type="text" name="cnc_rate_in_hkd[]" readonly class="form-control" placeholder="Rate" 
                value="'.$value->cnc_rate_in_hkd.'" style="margin-bottom:5px;width:98%;text-align:center" id="cnc_rate_in_hkd_'.$id.'"> </td>';
            $str.= '<td style"text-align:center"><button class="btn btn-danger btn-xs" onclick="return deleter('. $id .');" style="margin-top:5px;"><i class="fa fa-trash-o"></i></button></td></tr>';
            echo $str;
          
          $id++;
         }
       }
        endif;
    }
    function view($issue_id=FALSE){
        // Use the Mpdf class to generate a PDF
        $this->load->library('mPDF');

        $mpdf = new \Mpdf\Mpdf(); // Create an instance of Mpdf

        $html = '<h1>Hello, World!</h1><p>This is a PDF generated by Mpdf.</p>';
        $mpdf->WriteHTML($html); // Write HTML to PDF
        $mpdf->Output(); // Output the PDF
         
      }
      function returnback($issue_id=FALSE){
      $check=$this->issued_model->returnback($issue_id);
        if($check){ 
           $this->session->set_userdata('exception','Return successfully');
         }else{
           $this->session->set_userdata('exception','Delete Failed');
        }
      redirect("common/issued/lists");
    }
 
   
 }