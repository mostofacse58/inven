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
  $(document).on('click','input[type=number]',function(){ this.select(); });
    $('.date').datepicker({
        "format": "dd/mm/yyyy",
        "todayHighlight": true,
        "startDate": '-0d',
        "autoclose": true
    });
    });
///////////////////////////////////////////

//called when key is pressed in textbox
  $("#employee_id").keypress(function (e) {
     //if the letter is not digit then display error and don't type anything
     if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
        $('input[name=employee_id]').css('border', '1px solid #f00');
      return false;
    }else{
      $('input[name=employee_id]').css('border', '1px solid #ccc');
    }
  });
//////////////
var deletedRow=[];
<?php  
if(isset($info)){ ?>
     var id=<?php echo  count($detail); ?>;
     <?php }else{ ?>
    var id=0;
    <?php } ?>

$(document).ready(function(){
 
////////////////////////////////////
$("#AddManualItem").click(function(){
  var nodeStr = '<tr id="row_' + id + '"><td  style="text-align:center"><b>' + (id+1) + '</b></td><td><input type="text" name="particulars[]"  class="form-control"  placeholder="Particulars" style="margin-bottom:5px;width:98%" id="particulars_' + id + '" required></td>'+
  ' <td><input type="text" name="quantity[]" onfocus="this.select();" value="1"  class="form-control"  placeholder="Quantity" style="width:98%;float:left;text-align:center"  id="quantity_' + id + '"/></td>' +
  ' <td><input type="text" name="unit_name[]" onfocus="this.select();" value=""  class="form-control"  placeholder="Unit" style="width:98%;float:left;text-align:center"  id="unit_name_' + id + '"/></td> '+
  '<td> <input type="text" name="unit_price[]" class="form-control" placeholder="Price" style="margin-bottom:5px;width:98%;text-align:center" onblur="return calculateRow(' + id + ');" onkeyup="return calculateRow('+ id +');" value="0"  id="unit_price_' + id + '"/> </td>' +
  '<td> <input type="text" name="amount[]" readonly class="form-control" placeholder="Amount" style="margin-bottom:5px;width:98%;text-align:center" value="0.00"  id="amount_' + id + '"/> </td>' +
  '<td> <input type="text" name="weight[]" class="form-control" placeholder="weight" style="width:98%;"  id="weight_' + id + '"  onblur="return calculateRow(' + id + ');" onkeyup="return calculateRow('+ id +');"></td>'+
  '<td><input type="text" name="length[]" class="form-control integerchk" placeholder="Length" style="width:100%;float:left"  id="length_' + id + '" value="0" onblur="return calculateRow(' + id + ');" onkeyup="return calculateRow('+ id +');"></td>'+
  '<td><input type="text" name="width[]" class="form-control integerchk" placeholder="Width" style="width:100%;float:left"  id="width_' + id + '" value="0" onblur="return calculateRow(' + id + ');" onkeyup="return calculateRow('+ id +');"></td>'+
  '<td><input type="text" name="height[]" class="form-control integerchk" placeholder="Height" style="width:100%;float:left"  id="height_' + id + '" value="0" onblur="return calculateRow(' + id + ');" onkeyup="return calculateRow('+ id +');"></td>'+
  '<td><input type="text" name="vol_weight[]" readonly class="form-control" placeholder="vol_weight" style="width:100%;float:left" value="0" id="vol_weight_' + id + '"></td>'+
  '<td style="text-align:center"><button class="btn btn-danger btn-xs" onclick="return deleter(' + id + ');" style="margin-top:5px;"><i class="fa fa-trash-o"></i> </button> </td> </tr>';
    $("#form-table tbody").append(nodeStr);
    updateRowNo();
    id++;
    
  });//addField

  ///////////////////////
  
    });


  function formsubmit(){
  var error_status=false;
  var chargeback_id=$("#chargeback_id").val();
  var serviceNum=$("#form-table tbody tr").length;
  var chk;
  if(serviceNum<1){
    $("#alertMessageHTML").html("Please Adding at least one Material!!");
    $("#alertMessagemodal").modal("show");
    error_status=true;
  }
  var issuer=$("#issuer").val();
  if(issuer == ''){
    error_status=true;
    $('input[name=issuer]').css('border', '1px solid #f00');
  } else {
    $('input[name=issuer]').css('border', '1px solid #ccc');      
  }
  var issue_date=$("#issue_date").val();
  if(issue_date == ''){
    error_status=true;
    $('input[name=issue_date]').css('border', '1px solid #f00');
  } else {
    $('input[name=issue_date]').css('border', '1px solid #ccc');      
  }
  var shipper_name=$("#shipper_name").val();
  if(shipper_name == ''){
    error_status=true;
    $('input[name=shipper_name]').css('border', '1px solid #f00');
  } else {
    $('input[name=shipper_name]').css('border', '1px solid #ccc');      
  }
  var ship_address=$("#ship_address").val();
  if(ship_address == ''){
    error_status=true;
    $('input[name=ship_address]').css('border', '1px solid #f00');
  } else {
    $('input[name=ship_address]').css('border', '1px solid #ccc');      
  }
  var ship_name=$("#ship_name").val();
  if(ship_name == ''){
    error_status=true;
    $('input[name=ship_name]').css('border', '1px solid #f00');
  } else {
    $('input[name=ship_name]').css('border', '1px solid #ccc');      
  }
  var ship_address=$("#ship_address").val();
  if(ship_address == ''){
    error_status=true;
    $('input[name=ship_address]').css('border', '1px solid #f00');
  } else {
    $('input[name=ship_address]').css('border', '1px solid #ccc');      
  }
  if(currency == '') {
    error_status=true;
    $("#alertMessageHTML").html("Please select currency!!");
    $("#alertMessagemodal").modal("show");
  } else {
    $("#currency").css('border', '1px solid #ccc');      
  }
  if(chargeback_id == '') {
    error_status=true;
    $("#alertMessageHTML").html("Please select charge back!!");
    $("#alertMessagemodal").modal("show");
  } else {
    $("#chargeback_id").css('border', '1px solid #ccc');      
  }
 if(shipping_mode == '') {
    error_status=true;
    $("#alertMessageHTML").html("Please select shipping mode!!");
    $("#alertMessagemodal").modal("show");
  } else {
    $("#shipping_mode").css('border', '1px solid #ccc');      
  }

   for(var i=0;i<serviceNum;i++){
    if($("#particulars_"+i).val()==''){
      $("#particulars_"+i).css('border', '1px solid #f00');
      error_status=true;
    }
    if($("#quantity_"+i).val()==''||$("#quantity_"+i).val()==0){
      $("#quantity_"+i).css('border', '1px solid #f00');
      error_status=true;
    }
    if($("#unit_name_"+i).val()==''){
      $("#unit_name_"+i).css('border', '1px solid #f00');
      error_status=true;
    }

  }
  if(demand_eta == '') {
    error_status=true;
    $("#demand_eta").css('border', '1px solid #f00');
  } else {
    $("#demand_eta").css('border', '1px solid #ccc');      
  }
  if(error_status==true){
    return false;
  }else{
    $('button[type=submit]').attr('disabled','disabled');
    return true;
  }
}
//////////////////////////////
    function deleter(id){
        $("#row_"+id).remove();
        deletedRow.push(id);
        updateRowNo();
    }
    /////////////////////////////////////////////////////
    //////////UPDATE ROW NUmber
    ///////////////////////////////////////////////////////
    function updateRowNo(){
    var numRows=$("#form-table tbody tr").length;
    for(var r=0;r<numRows;r++){
        $("#form-table tbody tr").eq(r).find("td:first b").text(r+1);
    }
    }
    ////////////////////////////////////////////
    //////////CHECK QUANTITY
    ///////////////////////////////////////////
    function checkQuantity(id){
       var quantity=$("#quantity_"+id).val();
       if($.trim(quantity)==""|| $.isNumeric(quantity)==false){
          $("#quantity_"+id).val(0);
        }
      calculateRow(id);
    }
     ////// TOTAL SUM
    ////////////////////////////////////////////
    function totalSum(){
        var totalAmount=0;
        for(var i=0;i<id;i++){
        if(deletedRow.indexOf(i)<0) {

          totalAmount += parseFloat($.trim($("#amount_" + i).val()));
          var length= parseFloat($.trim($("#length_" + i).val()));
          var width= parseFloat($.trim($("#width_" + i).val()));
          var height= parseFloat($.trim($("#height_" + i).val()));
          var vol_weight=(length*width*height)/5000;
          ///alert(vol_weight);
          $("#vol_weight_"+i).val(vol_weight);
        }
        }
        $("#total_amount").val(totalAmount.toFixed(2));
      }
      //////////////////////////////////////////////
    /////////////CALCULATE ROW
    //////////////////////////////////////////////
    function calculateRow(id){
        var unit_price=$("#unit_price_"+id).val();
        var quantity=$("#quantity_"+id).val();
        if($.trim(quantity)==""|| $.isNumeric(quantity)==false){
            quantity=1;
        }
        if($.trim(unit_price)==""|| $.isNumeric(unit_price)==false){
            unit_price=0;
        }
        var quantityAndPrice=parseFloat($.trim(unit_price))*parseFloat($.trim(quantity));
        $("#amount_"+id).val(quantityAndPrice.toFixed(2));
        totalSum();
    }


</script>
<div class="row">
    <div class="col-md-12">
        <div class="box box-info">
      <!-- /.box-header -->
        <form class="form-horizontal" action="<?php echo base_url(); ?>cc/courier/save<?php if (isset($info)) echo "/$info->courier_id"; ?>" method="POST" enctype="multipart/form-data" onsubmit="return formsubmit();">
         <div class="box-body">
         <div class="form-group">
          <label class="col-sm-2 control-label">Issuer Name<span style="color:red;">  *</span></label>
         <div class="col-sm-3">
           <input type="text" name="issuer" readonly id="issuer" class="form-control" value="<?php if(isset($info)) echo $info->issuer; else echo $this->session->userdata('user_name'); ?>">
           <span class="error-msg"><?php echo form_error("issuer");?></span>
         </div>
         <label class="col-sm-2 control-label">Authorised by<span style="color:red;">  *</span></label>
         <div class="col-sm-3">
            <select class="form-control select2" name="authorised_by" id="authorised_by" required="">
              <option value="">Select Any One</option>
              <?php foreach ($ulist as $value) {  ?>
              <option value="<?php echo $value->id; ?>"
              <?php  if(isset($info)) echo $value->id==$info->authorised_by? 'selected="selected"':0; 
              else echo set_select('authorised_by',$value->id);?>>
              <?php echo $value->user_name; ?></option>
              <?php } ?>
            </select>
            <span class="error-msg"><?php echo form_error("id"); ?></span>
            </div>
             
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">Date of Issue <span style="color:red;">  *</span></label>
           <div class="col-sm-3">
            <div class="input-group">
             <div class="input-group-addon">
               <i class="fa fa-calendar"></i>
             </div>
             <input type="text" name="issue_date" readonly id="issue_date" class="form-control pull-right" value="<?php if(isset($info)) echo findDate($info->issue_date); else echo date('d/m/Y'); ?>">
           </div>
           <span class="error-msg"><?php echo form_error("issue_date");?></span>
          </div>
         <label class="col-sm-2 control-label">Ship to Name<span style="color:red;">  *</span></label>
         <div class="col-sm-3">
            <select class="form-control select2" name="ship_id" id="ship_id" required="">
              <option value="">Select Any One</option>
              <?php foreach ($slist as $value) {  ?>
              <option value="<?php echo $value->ship_id; ?>"
              <?php  if(isset($info)) echo $value->ship_id==$info->ship_id? 'selected="selected"':0; 
              else echo set_select('ship_id',$value->ship_id);?>>
              <?php echo "$value->ship_name($value->ship_attention)"; ?></option>
              <?php } ?>
            </select>
           <span class="error-msg"><?php echo form_error("ship_id");?></span>
           <input type="hidden" name="ship_name" value="<?php if(isset($info)) echo $info->ship_name; else echo set_value('ship_name'); ?>">
         </div>
         <div class="col-sm-1">
            <a href="javascript:;" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#partyModal"><i class="fa fa-plus"></i></a>
          </div>
         </div>
        <div class="form-group">
         <label class="col-sm-2 control-label">Shipper Name<span style="color:red;">  *</span></label>
         <div class="col-sm-3">
           <input type="text" name="shipper_name" readonly id="shipper_name" class="form-control" value="<?php if(isset($info)) echo $info->shipper_name; else echo $this->session->userdata('company_name'); ?>">
           <span class="error-msg"><?php echo form_error("shipper_name");?></span>
         </div>
         <label class="col-sm-2 control-label">Ship to Address<span style="color:red;">  *</span></label>
         <div class="col-sm-3">
           <input type="text" readonly name="ship_address" id="ship_address" class="form-control" value="<?php if(isset($info)) echo $info->ship_address; else echo set_value('ship_address'); ?>">
           <span class="error-msg"><?php echo form_error("ship_address");?></span>
         </div>
         </div>
        <div class="form-group">
         <label class="col-sm-2 control-label">Shipper Address<span style="color:red;">  *</span></label>
         <div class="col-sm-3">
           <input type="text" readonly name="shipper_address" id="shipper_address" class="form-control" value="<?php if(isset($info)) echo $info->shipper_address; else echo $this->session->userdata('caddress'); ?>">
           <span class="error-msg"><?php echo form_error("shipper_address");?></span>
         </div>
         <label class="col-sm-2 control-label">Ship to Attention<span style="color:red;">  </span></label>
         <div class="col-sm-3">
           <input type="text"  name="ship_attention" id="ship_attention" class="form-control" value="<?php if(isset($info)) echo $info->ship_attention; else echo set_value('ship_attention'); ?>">
           <span class="error-msg"><?php echo form_error("ship_attention");?></span>
         </div>
         </div>
        <div class="form-group">
         <label class="col-sm-2 control-label">Shipper Attention<span style="color:red;">  *</span></label>
         <div class="col-sm-3">
           <input type="text"  name="shipper_attention" id="shipper_attention" class="form-control" value="<?php if(isset($info)) echo $info->shipper_attention; else echo set_value('shipper_attention'); ?>">
           <span class="error-msg"><?php echo form_error("shipper_attention");?></span>
         </div>
         <label class="col-sm-2 control-label">Ship to Telephone<span style="color:red;">  </span></label>
         <div class="col-sm-3">
           <input type="text" name="ship_telephone" id="ship_telephone" class="form-control" value="<?php if(isset($info)) echo $info->ship_telephone; else echo set_value('ship_telephone'); ?>">
           <span class="error-msg"><?php echo form_error("ship_telephone");?></span>
         </div>
         </div>
        <div class="form-group">
         <label class="col-sm-2 control-label">Shipper Telephone<span style="color:red;">  </span></label>
         <div class="col-sm-3">
           <input type="text" name="shipper_telephone" id="shipper_telephone" class="form-control" value="<?php if(isset($info)) echo $info->shipper_telephone; else echo set_value('shipper_telephone'); ?>">
           <span class="error-msg"><?php echo form_error("shipper_telephone");?></span>
         </div>
         <label class="col-sm-2 control-label">Ship to Email<span style="color:red;">  </span></label>
         <div class="col-sm-3">
           <input type="text" name="ship_email" id="ship_email" class="form-control" value="<?php if(isset($info)) echo $info->ship_email; else echo set_value('ship_email'); ?>">
           <span class="error-msg"><?php echo form_error("ship_email");?></span>
         </div>
         </div>
        <div class="form-group">
         <label class="col-sm-2 control-label">Shipper Email<span style="color:red;"> </span></label>
         <div class="col-sm-3">
           <input type="text" name="shipper_email" id="shipper_email" class="form-control" value="<?php if(isset($info)) echo $info->shipper_email; else echo set_value('shipper_email'); ?>">
           <span class="error-msg"><?php echo form_error("shipper_email");?></span>
         </div>
   
          <label class="col-sm-2 control-label">Attachment</label>
          <div class="col-sm-3">
            <input type="file" class="form-control"  name="attachment" class="form-control" >
            <?php if(isset($info) &&!empty($info->attachment)) { ?>
              <div style="margin-top:10px;">
              <a href="<?php echo base_url(); ?>dashboard/gatepassExcel/<?php echo $info->attachment ?>">Download</a>
              </div>
            <?php } ?>
          </div>
        </div><!-- ///////////////////// -->
      
 
    <div class="form-group">
      <div class="col-sm-12" style="">
       <a id="AddManualItem" class="btn btn-info">
        <i class="fa fa-plus-square"></i> Add Item</a>
      </div>
     </div><!-- ///////////////////// -->

<div class="table-responsive">
<table class="table table-bordered" id="form-table">
<thead>
<tr>
  <th style="width:3%;text-align:center">SN</th>
  <th style="width:20%;text-align:center">Particulars</th>
  <th style="width:5%;text-align:center;">Qty</th>
  <th style="width:5%;text-align:center;">Unit </th>
  <th style="width:10%;text-align:center;">Unit Price (USD)</th>
  <th style="width:10%;text-align:center;">Amount(USD)</th>
  <th style="width:10%;text-align:center;">Weight(Kg)</th>
  <th style="width:4%;text-align:center;">Length(CM)</th>
  <th style="width:4%;text-align:center;">Width(CM)</th>
  <th style="width:4%;text-align:center;">Height(CM)</th>
  <th style="width:8%;text-align:center;">Volumetric Weight (Kg)</th>
  <th style="width:5%;text-align:center">
    <i class="fa fa-trash-o"></i></th></tr>
</thead>
<tbody>
 <?php
 $i=0;
 $id=0;
  if(isset($detail)):
    foreach ($detail as  $value) {
      $str='<tr id="row_' . $id . '"><td style="text-align:center"><b>' . ($id +1).'</b></td>';
      $str.= '<td><input type="text" name="particulars[]" class="form-control" placeholder="particulars" value="'.$value->particulars.'"  style="margin-bottom:5px;width:98%" id="particulars_'.$id. '"/> </td>';
      $str.= '<td><input type="text" name="quantity[]" value="'.$value->quantity.'"  class="form-control"  placeholder="Quantity" style="width:100%;float:left;text-align:center"  id="quantity_' .$id. '" onblur="return calculateRow(' .$id.');" onkeyup="return calculateRow(' .$id.');"></td>'; 
      $str.= '<td><input style="width:100%;float:left" class="form-control" name="unit_name[]" value="'.$value->unit_name.'" ></td>';
      $str.= '<td><input type="text" name="unit_price[]" value="'.$value->unit_price.'"  class="form-control"  placeholder="unit_price" style="width:100%;float:left;text-align:center"  id="unit_price_' .$id. '"  onblur="return calculateRow(' .$id.');" onkeyup="return calculateRow(' .$id.');">'; 
      $str.= '<td><input type="text" name="amount[]" value="'.$value->amount.'"  class="form-control"  placeholder="amount style="width:100%;float:left;text-align:center"  id="amount_' .$id. '"  onblur="return calculateRow(' .$id.');" onkeyup="return calculateRow(' .$id.');">';
      $str.= '<td><input type="text" name="weight[]" value="'.$value->weight.'"  class="form-control"  placeholder="weight" style="width:100%;float:left;text-align:center"  id="weight_' .$id. '"  onblur="return calculateRow(' .$id.');" onkeyup="return calculateRow(' .$id.');">';
      $str.= '<td><input type="text" name="length[]" value="'.$value->length.'"  class="form-control"  placeholder="length" style="width:100%;float:left;text-align:center"  id="length_' .$id. '"  onblur="return calculateRow(' .$id.');" onkeyup="return calculateRow(' .$id.');">';
      $str.= '<td><input type="text" name="width[]" value="'.$value->width.'"  class="form-control"  placeholder="width" style="width:100%;float:left;text-align:center"  id="width_' .$id. '"  onblur="return calculateRow(' .$id.');" onkeyup="return calculateRow(' .$id.');">';
      $str.= '<td><input type="text" name="vol_weight[]" value="'.$value->height.'"  class="form-control"  placeholder="height" style="width:100%;float:left;text-align:center"  id="height_' .$id. '"  onblur="return calculateRow(' .$id.');" onkeyup="return calculateRow(' .$id.');">';
      $str.= '<td><input type="text" name="vol_weight[]" value="'.$value->vol_weight.'"  class="form-control"  placeholder="vol_weight" style="width:100%;float:left;text-align:center" readonly id="vol_weight_' .$id. '">';
      $str.= '<td style"text-align:center"><button class="btn btn-danger btn-xs" style"text-align:center" onclick="return deleter('. $i .');" style="margin-top:5px;"><i class="fa fa-trash-o"></i></button></td></tr>';
      echo $str;
       ?>
      <?php 
      $id++;
       }
      endif;
      ?>
</tbody>
</table>
</div>
     <div class="form-group">
      <label class="col-sm-2 control-label">Demand ETA <span style="color:red;">  *</span></label>
       <div class="col-sm-3">
        <div class="input-group date">
         <div class="input-group-addon">
           <i class="fa fa-calendar"></i>
         </div>
         <input type="text" name="demand_eta" readonly id="demand_eta" class="form-control pull-right" value="<?php if(isset($info)) echo findDate($info->demand_eta); else echo date('d/m/Y'); ?>">
       </div>
       <span class="error-msg"><?php echo form_error("demand_eta");?></span>
      </div>
      <label class="col-sm-2 control-label">Total Amount<span style="color:red;">  </span></label>
     <div class="col-sm-3">
       <input type="text" name="total_amount" readonly id="total_amount" class="form-control" value="<?php if(isset($info)) echo $info->total_amount; else echo set_value('total_amount'); ?>">
       <span class="error-msg"><?php echo form_error("total_amount");?></span>
     </div>
    </div>

      <div class="form-group">
        <label class="col-sm-2 control-label">Charges Back to  <span style="color:red;">  *</span></label>
        <div class="col-sm-3">
        <select class="form-control select2" name="chargeback_id" id="chargeback_id">
          <option value="">Select Any One</option>
          <?php foreach ($ilist as $value) {  ?>
          <option value="<?php echo $value->chargeback_id; ?>"
          <?php  if(isset($info)) echo $value->chargeback_id==$info->chargeback_id? 'selected="selected"':0; else echo set_select('chargeback_id',$value->chargeback_id);?>>
          <?php echo $value->chargeback_name; ?></option>
          <?php } ?>
        </select>
        <span class="error-msg"><?php echo form_error("chargeback_id"); ?></span>
        </div>
        <label class="col-sm-2 control-label">Shipping Mode<span style="color:red;">  *</span></label>
       <div class="col-sm-3">
        <select class="form-control select2" required name="shipping_mode" id="shipping_mode">
            <option value="Over Sea Courier"
              <?php  if(isset($info)) echo 'Over Sea Courier'==$info->shipping_mode? 'selected="selected"':0; else echo set_select('shipping_mode','Over Sea Courier');?>>
                Over Sea Courier</option>
            <option value="Local Courier"
              <?php  if(isset($info)) echo 'Local Courier'==$info->shipping_mode? 'selected="selected"':0; else echo set_select('shipping_mode','Local Courierr');?>>
                Local Courier</option>
            <option value="Over Sea Hand Carry"
              <?php  if(isset($info)) echo 'Over Sea Hand Carry'==$info->shipping_mode? 'selected="selected"':0; else echo set_select('shipping_mode','Over Sea Hand Carry');?>>
                Over Sea Hand Carry</option>
          </select>
       <span class="error-msg"><?php echo form_error("shipping_mode");?></span>
     </div>
     </div>
     <div class="form-group">
        <label class="col-sm-2 control-label chargeback_other">Account Name<span style="color:red;"> </span></label>
         <div class="col-sm-3 chargeback_other">
           <input type="text" name="account_name" id="account_name" class="form-control" value="<?php if(isset($info)) echo $info->account_name; else echo set_value('account_name'); ?>">
           <span class="error-msg"><?php echo form_error("account_name");?></span>
         </div>
         <label class="col-sm-2 control-label">Payment Mode<span style="color:red;">  *</span></label>
        <div class="col-sm-3">
          <select class="form-control select2" name="payment_method" id="payment_method" style="width: 100%">
            <option value="Prepaid"
              <?php  if(isset($info)) echo 'Prepaid'==$info->payment_method? 'selected="selected"':0; else echo set_select('payment_method','Prepaid');?>>
                Prepaid</option>
            <option value="Prepaid first then charge back"
              <?php  if(isset($info)) echo 'Prepaid first then charge back'==$info->payment_method? 'selected="selected"':0; else echo set_select('payment_method','Prepaid first then charge back');?>>
                Prepaid first then charge back</option>
            <option value="Collect"
              <?php  if(isset($info)) echo 'Collect'==$info->payment_method? 'selected="selected"':0; else echo set_select('payment_method','Collect');?>>
                Collect</option>
            </select>
         <span class="error-msg"><?php echo form_error("payment_method");?></span>
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-2 control-label chargeback_other">Account No<span style="color:red;"> </span></label>
         <div class="col-sm-3 chargeback_other">
           <input type="text" name="account_no_vlmbd" id="account_no_vlmbd" class="form-control" value="<?php if(isset($info)) echo $info->account_no_vlmbd; else echo set_value('account_no_vlmbd'); ?>">
           <span class="error-msg"><?php echo form_error("account_no_vlmbd");?></span>
         </div>
        <label class="col-sm-2 control-label">Note/Remarks</label>
            <div class="col-sm-3">
              <textarea  name="remarks" class="form-control" rows="3"><?php if(isset($info)) echo $info->remarks; else echo set_value('remarks'); ?> </textarea>
               <span class="error-msg"><?php echo form_error("remarks");?></span>
            </div>
           
      </div>
<br><br>
</div>
  <!-- /.box-body -->
  <div class="box-footer">
      <div class="col-sm-4"><a href="<?php echo base_url(); ?>cc/courier/lists" class="btn btn-info">
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


<div class="modal fade" id="partyModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Add Ship To Info</h4>
      </div>

      <div class="modal-body">
        <form class="form-horizontal">
          <div class="form-group">
            <label class="col-sm-4 control-label">Ship To Name <span style="color:red;">  *</span></label>
            <div class="col-sm-7">
              <input type="text" class="form-control" name="ship_name1" placeholder="Name" value="">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-4 control-label">Address <span style="color:red;">  *</span></label>
            <div class="col-sm-7">
              <input type="text" class="form-control" name="ship_address1">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-4 control-label">Attention </label>
            <div class="col-sm-7">
              <input type="text" class="form-control" name="ship_attention1">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-4 control-label">Telephone </label>
            <div class="col-sm-7">
              <input type="text" class="form-control" name="ship_telephone1">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-4 control-label">Email </label>
            <div class="col-sm-7">
              <input type="text" class="form-control" name="ship_email1">
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="addNew">Save</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript" src="<?php echo base_url('asset/shipto.js');?>"></script>

<script>
  $(document).ready(function(){
    ////////////////////////////
 $("#ship_id").change(function(){
      var ship_id=$("#ship_id").val();
      if(ship_id !=''){
      $.ajax({
        type:"post",
        url:"<?php echo base_url()?>"+'cc/courier/getShipTo',
        data:{ship_id:ship_id},
        success:function(data1){
          data1=JSON.parse(data1);
            $('#ship_name').val(data1.ship_name);
            $('#ship_address').val(data1.ship_address);
            $('#ship_attention').val(data1.ship_attention);
            $("#ship_telephone").val(data1.ship_telephone);
            $("#ship_email").val(data1.ship_email);
        }
      });
  }
  });
 var chargeback_id=$("#chargeback_id").val();
      if(chargeback_id==1){
        $(".chargeback_other").show();
       }else{
        $(".chargeback_other").hide();
       }

  $("#chargeback_id").change(function(){
      var chargeback_id=$("#chargeback_id").val();
      if(chargeback_id==1){
        $(".chargeback_other").show();
       }else{
        $(".chargeback_other").hide();
       }
  });

 
  });
</script>