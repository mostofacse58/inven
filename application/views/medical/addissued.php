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
            "endDate": '0d',
            "autoclose": true
        });
    });
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
var currencyselect='<?php if(isset($clist)){
     foreach ($clist as $rows) {?><option value="<?php echo $rows->currency; ?>"><?php echo "$rows->currency";?></option><?php }} ?> ';
$(document).ready(function(){

 var issue_type=$("#issue_type").val(); 
    if(issue_type==1){
       $(".departmentDiv").show();
       $(".employeeDiv").hide();
       $(".locationDiv").show();
    }else if(issue_type==2)  {
       $(".departmentDiv").show();
       $(".employeeDiv").show();
       $(".locationDiv").show();          
    }else{
      $(".departmentDiv").hide();
      $(".employeeDiv").hide();
      $(".locationDiv").show();
    }
  $("#issue_type").change(function(){
    var issue_type=$("#issue_type").val(); 
      if(issue_type==1){
         $(".departmentDiv").show();
         $(".employeeDiv").hide();
         $(".locationDiv").show();
      }else if(issue_type==2)  {
         $(".departmentDiv").show();
         $(".employeeDiv").show();
         $(".locationDiv").show();          
      }else{
        $(".departmentDiv").hide();
        $(".employeeDiv").hide();
        $(".locationDiv").show();
      }
    });

  $("#take_department_id").change(function(){
     $("#employeeFinder").val('');
     $("#employee_id").val('');
    });
  ///////////////////////
  ///////  Search 搜索 Medicine Barcode or QCODE or Put Name //////////////////
  $("#add_item").autocomplete({
        source: function (request, response) {
        $.ajax({
            type: 'get',
            url: '<?= base_url('medical/issued/suggestions'); ?>',
            dataType: "json",
            data: {
                term: request.term
            },
            success: function (data) {
                $(this).removeClass('ui-autocomplete-loading');
                response(data);
            }
        });
        },
        minLength: 3,
        autoFocus: false,
        delay: 250,
        response: function (event, ui) {
            if ($(this).val().length >= 16 && ui.content[0].id == 0) {
                bootbox.alert('Not Found', function () {
                    $('#add_item').focus();
                });
                $(this).removeClass('ui-autocomplete-loading');
                $(this).removeClass('ui-autocomplete-loading');
                $(this).val('');
            }
            else if (ui.content.length == 1 && ui.content[0].id != 0) {
                ui.item = ui.content[0];
                $(this).data('ui-autocomplete')._trigger('select', 'autocompleteselect', ui);
                $(this).autocomplete('close');
                $(this).removeClass('ui-autocomplete-loading');
            }
            else if (ui.content.length == 1 && ui.content[0].id == 0) {
                bootbox.alert('Not Found', function () {
                    $('#add_item').focus();
                });
                $(this).removeClass('ui-autocomplete-loading');
                $(this).val('');
            }
        },
        select: function (event, ui) {
            event.preventDefault();
            var unit_price=ui.item.unit_price;
            var productId=ui.item.product_id;
            var PFCODE=ui.item.FIFO_CODE;
            var sub_total=(parseFloat(unit_price)*1).toFixed(2);
            var chkname=1;
            if (ui.item.id !== 0) {
              for(var i=0;i<id;i++){
                var FCODE= parseInt($("#FIFO_CODE_" + i).val());
                if(FCODE==PFCODE){
                   chkname=2;
                }
               }
            if(chkname==2){
              $("#alertMessageHTML").html("This FIFO already added!!");
              $("#alertMessagemodal").modal("show");
            }else{
           //////////////////////////////
           var nodeStr = '<tr id="row_' + id + '"><td  style="text-align:center"><input type="hidden" value="'+ui.item.product_id+'" name="product_id[]"  id="product_id_' + id + '"/><b></b></td> <td> <input type="text" name="product_name[]" readonly class="form-control" placeholder="Product Name" value="'+ui.item.product_name+'" style="margin-bottom:5px;width:98%" id="product_name_' + id + '"/> </td>'+

            '<td> <input type="text" name="product_code[]" readonly class="form-control" placeholder="Medicine Code 项目代码" value="'+ui.item.product_code+'"  style="margin-bottom:5px;width:98%" id="product_code_' + id + '"/> </td>' +

             ' <td> <input type="text" name="FIFO_CODE[]" readonly class="form-control" placeholder="FIFO_CODE" style="margin-bottom:5px;width:98%;text-align:center" value="'+ui.item.FIFO_CODE+'"  id="FIFO_CODE' + id + '"/> </td>' +

            ' <td> <input type="text" name="stock[]" readonly class="form-control" placeholder="Stock" style="margin-bottom:5px;width:98%;text-align:center" value="'+ui.item.stock+'"  id="stock_' + id + '"/> </td>' +

            ' <td> <input type="text" name="quantity[]" onfocus="this.select();"  value="" onblur="return checkQuantity(' + id + ');" onkeyup="return checkQuantity(' + id + ');" class="form-control"  placeholder="Quantity" style="width:60%;float:left;text-align:center"  id="quantity_' + id + '"/> <label  style="width:38%;float:left">'+ui.item.unit_name+'</label></td>' +
            ' <td> <input type="text" readonly name="unit_price[]" class="form-control" placeholder="Unit Price" style="margin-bottom:5px;width:98%;text-align:center" value="'+ui.item.unit_price+'"  id="unit_price_' + id + '"  onblur="return calculateRow(' + id + ');" onkeyup="return calculateRow(' + id + ');"> </td>' +
            ' <td> <input type="text" name="sub_total[]" readonly class="form-control" placeholder="Amount" style="margin-bottom:5px;width:98%;text-align:center" value="'+sub_total+'"  id="sub_total_' + id + '"/> </td>' +
            '<td><input type="text" name="currency[]" readonly class="form-control" placeholder="CNC" style="margin-bottom:5px;width:98%;text-align:center" value="'+ui.item.currency+'"  id="currency_' + id + '"/> </td>' +
            ' <td><input type="text" name="cnc_rate_in_hkd[]" readonly class="form-control" placeholder="Rate" style="margin-bottom:5px;width:98%;text-align:center" value="'+ui.item.cnc_rate_in_hkd+'"  id="cnc_rate_in_hkd_' + id + '"/> </td>' +
            ' <td style="text-align:center"> <button class="btn btn-danger btn-xs" onclick="return deleter(' + id + ');" style="margin-top:5px;"><i class="fa fa-trash-o"></i> </button> </td> </tr>';
        $("#form-table tbody").append(nodeStr);
        $("#currency_"+id).val(ui.item.currency).change();
        updateRowNo();
        id++;
          //var row = add_invoice_item(ui.item);
          $("#add_item").val('');
        }
        } else {
          alert('Not Found');
        }
        }
    });
////////////// end Add Medicine///////////////////
    });

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
  function formsubmit(){
  var error_status=false;
  // var me_id=$("#me_id").val();
  var serviceNum=$("#form-table tbody tr").length;
  var chk;
  if(serviceNum<1){
    $("#alertMessageHTML").html("Please Adding at least one Medicine!!");
    $("#alertMessagemodal").modal("show");
    error_status=true;
  }
  var issue_date=$("#issue_date").val();
  var issue_type=$("#issue_type").val();
  if(issue_type==1){
    var take_department_id=$("#take_department_id").val();
    if(take_department_id == ''){
      error_status=true;
      $("#alertMessageHTML").html("Please select department!!");
      $("#alertMessagemodal").modal("show");
    }
   }else if(issue_type==2){
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
   }else if(issue_type==3){
    var location_id=$("#location_id").val();
    if(location_id == ''){
      error_status=true;
      $("#alertMessageHTML").html("Please select Location!!");
      $("#alertMessagemodal").modal("show");
    } else {
      $('select[name=location_id]').css('border', '1px solid #ccc');      
    }
   }
  for(var i=0;i<serviceNum;i++){
    if($("#product_code_"+i).val()==''){
      $("#product_code_"+i).css('border', '1px solid #f00');
      error_status=true;
    }
    if($("#quantity_"+i).val()==''||$("#quantity_"+i).val()==0){
      $("#quantity_"+i).css('border', '1px solid #f00');
      error_status=true;
    }
  }
  if(issue_date == '') {
    error_status=true;
    $("#issue_date").css('border', '1px solid #f00');
  } else {
    $("#issue_date").css('border', '1px solid #ccc');      
  }
  if(error_status==true){
    return false;
  }else{
    return true;
  }
}
 ////////////////////////////////////////////
    //////////CHECK QUANTITY
    ///////////////////////////////////////////
    function checkQuantity(id){
       var quantity=$("#quantity_"+id).val();
       var stock=$("#stock_"+id).val();
     if(stock-quantity<0){
         $("#alertMessageHTML").html("Not enough Stock!!");
         $("#alertMessagemodal").modal("show");
         $("#quantity_"+id).val(0);
      }else{
       if($.trim(quantity)==""|| $.isNumeric(quantity)==false){
            $("#quantity_"+id).val(0);

        }
      }
      calculateRow(id);
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
        ////////////// PUT VALUE ////////
        $("#sub_total_"+id).val(quantityAndPrice.toFixed(2));
       
    }//calculateRow


</script>
<div class="row">
    <div class="col-md-12">
        <div class="box box-info">
      <!-- /.box-header -->
        <form class="form-horizontal" action="<?php echo base_url(); ?>medical/issued/save<?php if (isset($info)) echo "/$info->issue_id"; ?>" method="POST" enctype="multipart/form-data" onsubmit="return formsubmit();">
         <div class="box-body">
         <div class="form-group">
          <label class="col-sm-2 control-label">Issue Type 问题类型 <span style="color:red;">  *</span></label>
           <div class="col-sm-3">
            <select class="form-control" name="issue_type" id="issue_type">
              <option value="2"
                <?php if(isset($info)) echo '2'==$info->issue_type? 'selected="selected"':0; else echo set_select('issue_type','2');?>>For Employee</option>
                <option value="1"
                <?php if(isset($info)) echo '1'==$info->issue_type? 'selected="selected"':0; else echo set_select('issue_type','1');?>>For Department</option>
                <option value="3"
                <?php if(isset($info)) echo '3'==$info->issue_type? 'selected="selected"':0; else echo set_select('issue_type','3');?>>For Location</option>
            </select>
           <span class="error-msg"><?php echo form_error("issue_type");?></span>
         </div>
         <label class="col-sm-1 control-label">Symptom <span style="color:red;">  </span></label>
            <div class="col-sm-5">
            <select class="form-control select2" name="symptoms_id[]" multiple="multiple" data-placeholder="Select multiple Symptom" style="width: 100%">
                <?php foreach($slist as $value){ ?>
                <option value="<?php echo $value->symptoms_id; ?>" <?php if(isset($info))
                  {if(in_array($value->symptoms_id, $sdetail)) echo 'selected="selected"';}else{
                   if(isset($_POST['symptoms_id'])) if(in_array($value->symptoms_id, $_POST['symptoms_id'])) echo 'selected="selected"';
                    } ?>><?php echo $value->symptoms_name; ?></option>
                  <?php } ?>
            </select>
            </div>
       </div>
       <div class="form-group">
         <label class="col-sm-2 control-label departmentDiv">Department <span style="color:red;">  *</span></label>
            <div class="col-sm-3 departmentDiv">
            <select class="form-control select2" name="take_department_id" id="take_department_id">> 
            <option value="" selected="selected">===Select Department===</option>
            <?php foreach ($dlist as $rows) { ?>
              <option value="<?php echo $rows->department_id; ?>" 
              <?php if (isset($info))
                  echo $rows->department_id == $info->take_department_id ? 'selected="selected"' : 0;
              else
                  echo $rows->department_id ==5 ? 'selected="selected"' : 0;
              ?>><?php echo $rows->department_name; ?></option>
                  <?php } ?>
              </select>
              <span class="error-msg"><?php echo form_error("take_department_id"); ?></span>
            </div>
            <label class="col-sm-1 control-label employeeDiv">Employee ID <span style="color:red;">  *</span></label>
           <div class="col-sm-2 employeeDiv">
             <input type="text" name="employee_id" maxlength="5" id="employee_id" class="form-control pull-right" value="<?php if(isset($info)) echo $info->employee_id; else echo set_value('employee_id'); ?>">
             <span class="error-msg"><?php echo form_error("employee_id");?></span>
             <span id="errmsg"></span>
           </div>
         </div>
         <div class="form-group">
           <label class="col-sm-2 control-label locationDiv">Location <span style="color:red;">  *</span></label>
          <div class="col-sm-3 locationDiv">
            <select class="form-control select2" name="location_id" id="location_id" style="width: 100%">
              <option value="">Select Location</option>
              <?php foreach ($llist as $value) {  ?>
                <option value="<?php echo $value->location_id; ?>"
                  <?php  if(isset($info)) echo $value->location_id==$info->location_id? 'selected="selected"':0; else echo set_select('location_id',$value->location_id);?>>
                  <?php echo $value->location_name; ?></option>
                <?php } ?>
            </select>
           <span class="error-msg"><?php echo form_error("location_id");?></span>
          </div>
          <label class="col-sm-1 control-label">Date </label>
         <div class="col-sm-2">
            <div class="input-group date">
             <div class="input-group-addon">
               <i class="fa fa-calendar"></i>
             </div>
             <input type="text" name="issue_date" readonly id="issue_date" class="form-control pull-right" value="<?php if(isset($info)) echo findDate($info->issue_date); else echo date('d/m/Y'); ?>">
           </div>
           <span class="error-msg"><?php echo form_error("issue_date");?></span>
          </div>
          <label class="col-sm-1 control-label">Injury <span style="color:red;">  </span></label>
            <div class="col-sm-2">
            <select class="form-control select2" name="injury_id" id="injury_id" style="width: 100%">
              <option value="">Select Injury</option>
              <?php foreach ($ilist as $value) {  ?>
                <option value="<?php echo $value->injury_id; ?>"
                  <?php  if(isset($info)) echo $value->location_id==$info->injury_id? 'selected="selected"':0; else echo set_select('injury_id',$value->injury_id);?>>
                  <?php echo $value->injury_name; ?></option>
                <?php } ?>
            </select>
            </div>
      </div><!-- ///////////////////// -->

    <div class="form-group">
    <label class="col-sm-2 control-label" style="margin-top: 14px">SCAN CODE or Search 搜索<span style="color:red;">  </span></label>
    <div class="col-sm-8">
      <div class="col-md-12" id="sticker" style="width: 100%; z-index: 2;">
        <div class="well well-sm"  style="overflow: hidden;">
          <div class="form-group" style="margin-bottom:0;">
            <div class="input-group wide-tip">
              <div class="input-group-addon" style="padding-left: 10px; padding-right: 10px;">
                <i class="fa fa-2x fa-barcode addIcon"></i></div>
              <input id="add_item" class="form-control ui-autocomplete-input input-lg" name="add_item" value="" placeholder="Please add Medicine to order list" autocomplete="off" tabindex="1" type="text">
            <div class="input-group-addon" style="padding-left: 10px; padding-right: 10px;">
          </div>
        </div>
        </div>
      <div class="clearfix"></div>
    </div>
  </div>
  </div>
  </div><!-- ///////////////////// -->
<div class="table-responsive">
<table class="table table-bordered" id="form-table">
<thead>
<tr>
  <th style="width:5%;text-align:center">SL</th>
  <th style="width:17%;text-align:center">Medicine Name 项目名</th>
  <th style="width:15%;text-align:center">Medicine Code 项目代码</th>
  <th style="width:10%;text-align:center;">FIFO CODE</th>
  <th style="width:12%;text-align:center">Stock Qty</th>
  <th style="width:10%;text-align:center;">Quantity</th>
  <th style="width:8%;text-align:center;">Unit Price</th>
  <th style="width:8%;text-align:center;">Amount</th>
  <th style="width:4%;text-align:center;">Currency</th>
  <th style="width:8%;text-align:center;">Rate HKD</th>
  <th style="width:5%;text-align:center">
     <i class="fa fa-trash-o"></i></th></tr>
</thead>
<tbody>
 <?php
 $i=0;
 $id=0;
  if(isset($detail)):
    foreach ($detail as  $value) {
      $stock=$value->main_stock+$value->quantity;
      $optionTree="";
        foreach ($clist as $rowc):
            $selected=($rowc->currency==$value->currency)? 'selected="selected"':'';
            $optionTree.='<option value="'.$rowc->currency.'" '.$selected.'>'.$rowc->currency.'</option>'; 
        endforeach;   
       $str='<tr id="row_' . $id . '"><td style="text-align:center"><input type="hidden" value="'.$value->product_id.'" name="product_id[]"  id="product_id_' . $id . '"/><b>' . ($id +1).'</b></td> <td> <input type="text" name="product_name[]" class="form-control" readonly placeholder="'.$value->product_name.'" value="'.$value->product_name.'"  style="margin-bottom:5px;width:98%" id="product_item_'  .$id. '"/> </td>';
      $str.= '<td> <input type="text" name="product_code[]" readonly class="form-control" placeholder="Medicine Code" value="'.$value->product_code.'"  style="margin-bottom:5px;width:98%" id="product_code_'.$id. '"/> </td>';
      $str.= '<td><input type="text" name="FIFO_CODE[]"  class="form-control" placeholder="FIFO_CODE" value="'.$value->FIFO_CODE.'"  style="margin-bottom:5px;width:98%" id="FIFO_CODE_'.$id. '"/> </td>';
      $str.= '<td> <input type="text" name="stock[]" readonly class="form-control" placeholder="Stock" 
      value="'.$stock.'" style="margin-bottom:5px;width:98%;text-align:center" id="stock_'.$id.'"> </td>';
      $str.= '<td> <input type="text" name="quantity[]" value="'.$value->quantity.'" onblur="return checkQuantity(' .$id.');" onkeyup="return checkQuantity(' .$id.');" class="form-control"  placeholder="Quantity" style="width:60%;float:left;text-align:center"  id="quantity_' .$id. '"> <label  style="width:38%;float:left">'.$value->unit_name.'</label></td>';
      $str.= '<td><input type="text" name="unit_price[]"  class="form-control" placeholder="Unit Price" 
      value="'.$value->unit_price.'" onblur="return calculateRow(' .$id.');" onkeyup="return calculateRow(' .$id.');" style="margin-bottom:5px;width:98%;text-align:center" id="unit_price_'.$id.'" readonly> </td>';
      $str.= '<td> <input type="text" name="sub_total[]" readonly class="form-control" placeholder="Amount" 
      value="'.$value->sub_total.'" style="margin-bottom:5px;width:98%;text-align:center" id="sub_total_'.$id.'"> </td>';
      $str.= '<td> <input type="text" name="currency[]" readonly class="form-control" placeholder="CNC" 
      value="'.$value->currency.'" style="margin-bottom:5px;width:98%;text-align:center" id="currency_'.$id.'"> </td>';
      $str.= '<td> <input type="text" name="cnc_rate_in_hkd[]" readonly class="form-control" placeholder="Rate" 
      value="'.$value->cnc_rate_in_hkd.'" style="margin-bottom:5px;width:98%;text-align:center" id="cnc_rate_in_hkd_'.$id.'"> </td>';
      $str.= '<td style"text-align:center"> <button class="btn btn-danger btn-xs" onclick="return deleter('. $i .');" style="margin-top:5px;"><i class="fa fa-trash-o"></i></button></td></tr>';
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
</div>
  <!-- /.box-body -->
  <div class="box-footer">
      <div class="col-sm-4"><a href="<?php echo base_url(); ?>medical/issued/lists" class="btn btn-info">
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
        <h4 class="modal-title" id="myModalLabel">Add Location</h4>
      </div>

      <div class="modal-body">
        <form class="form-horizontal">
          <div class="form-group">
            <label class="col-sm-4 control-label">Location Name <span style="color:red;">  *</span></label>
            <div class="col-sm-7">
              <input type="text" class="form-control" name="location_name" id="location_name" placeholder="Location Name" value="">
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="addNewLocation">Save</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript" src="<?php echo base_url('asset/supplier.js');?>"></script>
