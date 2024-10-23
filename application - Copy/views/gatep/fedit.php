<style>
   table.table-bordered tbody tr td{
        border-bottom: 1px solid #e2e2e2;
    }
    table.table-bordered tbody tr td:last-child{
        border: 1px solid #e2e2e2;

    }
    table.table-bordered tbody tr td h3{margin:0px;}
    .employee-holder{
        position: absolute;
        top:30px;
        display: none;
        background-color: #ffffff;
        width:270px;
        border:1px solid #efefef;
        z-index: 1000;
        box-shadow: 0 0 4px 0px #ccc;
    }
    .employee-holder ul{
        list-style: none;
        margin: 0px;
        padding: 0px;
    }
    .employee-holder ul li{
        margin: 0px;
        list-style: none;
        width:100%;
        padding:5px 10px;
        color:#666;
        background-color: #fff;
        border-bottom: 1px solid #e2e2e2;
    }
    .employee-holder ul li:hover,.employee-holder ul li.active{
        background-color: #0C5889;
        color:#fff;
    }
    .error-msg{display:none;}
    .form-control{
        -webkit-border-radius:4px;
        -moz-border-radius:4px;
        border-radius:4px;
    }
</style>
<script src="<?php echo base_url('asset/js/plugins/datepicker/bootstrap-datepicker.js'); ?>"></script>
<script type="text/javascript">
var count = 1
$(function () {
  $(document).on('click','input[type=number]',
    function(){
   this.select(); 
 });
    $('.date').datepicker({
        "format": "dd/mm/yyyy",
        "todayHighlight": true,
        "startDate": '-0d',
        "autoclose": true
    });
    });

//////////////
var deletedRow=[];
<?php  
if(isset($info)){ ?>
     var id=<?php echo  count($detail); ?>;
     <?php }else{ ?>
    var id=0;
  <?php } ?>

//////////////////////////////

    /////////////////////////////////////////////////////
    //////////UPDATE ROW NUmber
    ///////////////////////////////////////////////////////
    function updateRowNo(){
    var numRows=$("#form-table tbody tr").length;
    for(var r=0;r<numRows;r++){
        $("#form-table tbody tr").eq(r).find("td:first b").text(r+1);
    }
    }
  function formsubmit(){
  var error_status=false;
  var wh_whare=$("#wh_whare").val();
  var issue_to=$("#issue_to").val();
  var return_date=$("#return_date").val();
  var serviceNum=$("#form-table tbody tr").length;
  var chk;
  if(serviceNum<1){
    $("#alertMessageHTML").html("Please Adding at least one Material!!");
    $("#alertMessagemodal").modal("show");
    error_status=true;
  }
  var create_date=$("#create_date").val();
  var gatepass_type=$("#gatepass_type").val();
  var employee_id=$("#employee_id").val();
  if(employee_id == ''){
    error_status=true;
    $('input[name=employee_id]').css('border', '1px solid #f00');
  } else {
    $('input[name=employee_id]').css('border', '1px solid #ccc');      
  }
  if(employee_id.length!=5&&employee_id != ''){
    error_status=true;
    $("#alertMessageHTML").html("Please Enter ID NO exactly 5 digit!!");
    $("#alertMessagemodal").modal("show");
  }
 if(wh_whare=='OTHER'){
  if(issue_to==''){
    error_status=true;
    $('select[name=issue_to]').css('border', '1px solid #f00');
    $("#alertMessageHTML").html("Please select issue to!!");
    $("#alertMessagemodal").modal("show");
  }
 }
  for(var i=0;i<serviceNum;i++){
    if($("#product_code_"+i).val()==''){
      $("#product_code_"+i).css('border', '1px solid #f00');
      error_status=true;
    }
    if($("#product_name_"+i).val()==''){
      $("#product_name_"+i).css('border', '1px solid #f00');
      error_status=true;
    }
    if($("#product_quantity_"+i).val()==''||$("#product_quantity_"+i).val()==0){
      $("#product_quantity_"+i).css('border', '1px solid #f00');
      error_status=true;
    }
    if($("#product_code_"+i).val()==''){
      $("#product_code_"+i).css('border', '1px solid #f00');
      error_status=true;
    }
  }
  if(create_date == '') {
    error_status=true;
    $("#create_date").css('border', '1px solid #f00');
  } else {
    $("#create_date").css('border', '1px solid #ccc');      
  }
  if(gatepass_type==1){
    if(return_date == '') {
      error_status=true;
      $("#return_date").css('border', '1px solid #f00');
    } else {
      $("#return_date").css('border', '1px solid #ccc');      
    }
  }
  if(error_status==true){
    return false;
  }else{
    $('button[type=submit]').attr('disabled','disabled');
    return true;
  }
}
  


</script>
<div class="row">
    <div class="col-md-12">
        <div class="box box-info">
      <!-- /.box-header -->
        <form class="form-horizontal" action="<?php echo base_url(); ?>gatep/gatepass/fsave<?php if (isset($info)) echo "/$info->gatepass_id"; ?>" method="POST" enctype="multipart/form-data" onsubmit="return formsubmit();">
         <div class="box-body">
         <div class="form-group">
          <label class="col-sm-2 control-label">Gatepass NO  <span style="color:red;">  *</span></label>
          <label class="col-sm-2 control-label"><?php if(isset($info)) echo $info->gatepass_no; ?>  </label>
          <input type="hidden" name="edit_status" value="<?php if(isset($info)) echo $info->edit_status; else  echo set_value('edit_status'); ?>">
          <input type="hidden" name="gatepass_no" value="<?php if(isset($info)) echo $info->gatepass_no; else  echo set_value('gatepass_no'); ?>">           
       </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">Vehicle No </label>
           <div class="col-sm-3 ">
               <input type="text" name="vehicle_no" id="vehicle_no" class="form-control" value="<?php if(isset($info)) echo $info->vehicle_no; else  echo set_value('vehicle_no'); ?>">
           </div>
           <span class="error-msg"><?php echo form_error("vehicle_no");?></span>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">Attachment</label>
          <div class="col-sm-3">
            <input type="file" class="form-control"  name="attachment" class="form-control" >
            <?php if(isset($info) &&!empty($info->attachment)) { ?>
              <div style="margin-top:10px;">
              <a href="<?php echo base_url(); ?>dashboard/gatepassExcel/<?php echo $info->attachment; ?>">Download</a>
              </div>
            <?php } ?>
          </div>
          <label class="col-sm-2 control-label">Container No/Lock No </label>
           <div class="col-sm-3">
               <input type="text" name="container_no" id="container_no" class="form-control" value="<?php if(isset($info)) echo $info->container_no; else  echo set_value('container_no'); ?>">
           </div>
           <span class="error-msg"><?php echo form_error("container_no");?></span>
          </div>
        </div><!-- ///////////////////// -->

    
<div class="table-responsive">
<table class="table table-bordered" id="form-table">
<thead>
<tr>
  <th style="width:3%;text-align:center">SN</th>
  <th style="width:10%;text-align:center">Material Code 项目代码</th>
  <th style="width:20%;text-align:center">Material Name 项目名</th>
  <th style="width:10%;text-align:center;">PO NO</th>
  <th style="width:10%;text-align:center;">Carton No</th>
  <th style="width:5%;text-align:center;">Qty</th>
  <th style="width:5%;text-align:center;">Unit </th>
  <th style="width:10%;text-align:center;">Bag Qty</th>
  <th style="width:10%;text-align:center;">Invoice No</th>
  <th style="width:15%;text-align:center;">Purpose/Remarks</th>
 
</thead>
<tbody>
 <?php
 $i=0;
 $id=0;
  if(isset($detail)):
    foreach ($detail as  $value) {
      $str='<tr id="row_' . $id . '">
      <td style="text-align:center"><b>' . ($id +1).'</b></td>';
      $str.= '<td><input type="hidden" name="detail_id[]" value="'.$value->detail_id.'"  id="detail_id_' .$id. '"><input type="text" readonly name="product_code[]" class="form-control" placeholder="Material Code" value="'.$value->product_code.'"  style="margin-bottom:5px;width:98%" id="product_code_'.$id. '"/> </td>';
      $str.='<td><input type="text" readonly name="product_name[]" class="form-control" placeholder="'.$value->product_name.'" value="'.$value->product_name.'"  style="margin-bottom:5px;width:98%" id="product_item_'  .$id. '"/> </td>';
      
      $str.= '<td><input type="text" readonly name="po_no[]" value="'.$value->po_no.'"  class="form-control"  placeholder="PO No" style="width:100%;float:left;text-align:center"  id="po_no_' .$id. '"></td>'; 
       
      $str.= '<td><input type="text" name="carton_no[]" value="'.$value->carton_no.'"  class="form-control"  placeholder="Carton No" style="width:100%;float:left;text-align:center"  id="carton_no_' .$id. '"><input type="hidden" name="pre_carton_no[]" value="'.$value->carton_no.'"  id="pre_carton_no_' .$id. '"></td>'; 
   
      $str.= '<td><input type="text" name="product_quantity[]" value="'.$value->product_quantity.'"  class="form-control"  placeholder="Quantity" style="width:100%;float:left;text-align:center"  id="product_quantity_' .$id. '"><input type="hidden" name="pre_product_quantity[]" value="'.$value->product_quantity.'"  id="pre_product_quantity_' .$id. '"></td>'; 
      $str.= '<td><input style="width:100%;float:left" readonly class="form-control" name="unit_name[]" value="'.$value->unit_name.'" ></td>';
      $str.= '<td><input type="text" name="bag_qty[]" value="'.$value->bag_qty.'"  class="form-control"  placeholder="Bag Qty" style="width:100%;float:left;text-align:center"  id="bag_qty_' .$id. '"><input type="hidden" name="pre_bag_qty[]" value="'.$value->bag_qty.'"  id="pre_bag_qty_' .$id. '"></td>'; 
      $str.= '<td><input type="text" readonly name="invoice_no[]" value="'.$value->invoice_no.'"  class="form-control"  placeholder="Invoice No" style="width:100%;float:left;text-align:center"  id="invoice_no_' .$id. '"></td>';
     
      $str.= '<td> <input type="text" readonly name="remarks[]" value="'.$value->remarks.'"  class="form-control" placeholder="Purpose" style="width:98%;"  id="remarks_' .$id. '"/></td>';
      echo $str;
       ?>
      <?php 
      $id++;
      $i++;
       }
      endif;
      ?>
</tbody>
</table>
</div>


  <!-- /.box-body -->
  <div class="box-footer">
      <div class="col-sm-4"><a href="<?php echo base_url(); ?>gatep/gatepass/lists" class="btn btn-info">
        <i class="fa fa-arrow-circle-o-left" aria-hidden="true"></i> 
        Back</a></div>
      <div class="col-sm-4">
          <button type="submit" class="btn btn-info pull-right">SAVE 保存</button>
      </div>
  </div>
  <!-- /.box-footer -->
</form>
</div>
</div>
</div>


