<style>
   table.table-bordered tbody tr td{
        border-bottom: 1px solid #e2e2e2;
    }
    table.table-bordered tbody tr td:last-child{
        border: 1px solid #e2e2e2;

    }
    table.table-bordered tbody tr td h3{margin:0px;}
    .form-control {
      display: block;
      width: 100%;
      height: 34px;
      padding: 3px 6px;
      font-size: 16px;
      line-height: 1.42857143;
      color: #555;
      background-color: #fff;
      background-image: none;
      border: 1px solid #ccc;
      border-radius: 4px;
      -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
      box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
      -webkit-transition: border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;
      -o-transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
      transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
    }
    .error-msg{display:none;}
    .form-control{
        -webkit-border-radius:4px;
        -moz-border-radius:4px;
        border-radius:4px;
    }
    .select2-container--default .select2-selection--single, .select2-selection .select2-selection--single {
      border: 1px solid #4C4C4C;
      border-radius: 0;
      height: 34px;
      padding: 3px 6px;
      font-size: 16px;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
      color: #444;
      line-height: 34px;
    }
</style>
<script src="<?php echo base_url('asset/js/plugins/datepicker/bootstrap-datepicker.js'); ?>"></script>
<script type="text/javascript">
var count = 1
$(function () {
  $(document).on('click','input[type=number]',function(){ this.select(); });
    $('.date').datepicker({
        "format": "yyyy-mm-dd",
        "todayHighlight": true,
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


  function formsubmit(){
  var error_status=false;
  var chargeback_id=$("#chargeback_id").val();

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
 function checkQuantity(){
      var building_material=$("#building_material").val();
      if($.trim(building_material)==""|| $.isNumeric(building_material)==false){
        $("#building_material").val(0);
      }
      var cutting_die_material=$("#cutting_die_material").val();
      if($.trim(cutting_die_material)==""|| $.isNumeric(cutting_die_material)==false){
        $("#cutting_die_material").val(0);
      }
      var eta_uttara_factory=$("#eta_uttara_factory").val();
      if($.trim(eta_uttara_factory)==""|| $.isNumeric(eta_uttara_factory)==false){
        $("#eta_uttara_factory").val(0);
      }
      var others_weight=$("#others_weight").val();
      if($.trim(others_weight)==""|| $.isNumeric(others_weight)==false){
        $("#others_weight").val(0);
      }
      var mmk_weight=$("#mmk_weight").val();
      if($.trim(mmk_weight)==""|| $.isNumeric(mmk_weight)==false){
        $("#mmk_weight").val(0);
      }
      var mkm_weight=$("#mkm_weight").val();
      if($.trim(mkm_weight)==""|| $.isNumeric(mkm_weight)==false){
        $("#mkm_weight").val(0);
      }
      var coach_weight=$("#coach_weight").val();
      if($.trim(coach_weight)==""|| $.isNumeric(coach_weight)==false){
        $("#coach_weight").val(0);
      }
      var katespade_weight=$("#katespade_weight").val();
      if($.trim(katespade_weight)==""|| $.isNumeric(katespade_weight)==false){
        $("#katespade_weight").val(0);
      }
      var shipped_qty=$("#shipped_qty").val();
      if($.trim(shipped_qty)==""|| $.isNumeric(shipped_qty)==false){
        $("#shipped_qty=").val(0);
      }

    }


</script>
<div class="row">
    <div class="col-md-12">
        <div class="box box-info">
      <!-- /.box-header -->
        <form class="form-horizontal" action="<?php echo base_url(); ?>shipping/bdimport/save<?php if (isset($info)) echo "/$info->import_id"; ?>" method="POST" enctype="multipart/form-data" onsubmit="return formsubmit();">
         <div class="box-body">
          
        <div class="form-group">
         <label class="col-sm-2 control-label"><?php echo lang('courier_freight_usd'); ?>
          <span style="color:red;">  *</span></label>
         <div class="col-sm-3">
           <input type="text"  name="courier_freight_usd" id="courier_freight_usd" class="form-control integerchk" value="<?php if(isset($info)) echo $info->courier_freight_usd; else echo set_value('courier_freight_usd'); ?>" onkeyup="return checkQuantity();">
           <span class="error-msg"><?php echo form_error("courier_freight_usd");?></span>
         </div>
         <label class="col-sm-2 control-label"><?php echo lang('cnf_from_broker_tkd'); ?>
         <span style="color:red;"> * </span></label>
         <div class="col-sm-3">
           <input type="text"  name="cnf_from_broker_tkd" id="cnf_from_broker_tkd" class="form-control integerchk" value="<?php if(isset($info)) echo $info->cnf_from_broker_tkd; else echo set_value('cnf_from_broker_tkd'); ?>">
           <span class="error-msg"><?php echo form_error("cnf_from_broker_tkd");?></span>
         </div>
         </div>
         <div class="form-group">
         <label class="col-sm-2 control-label"><?php echo lang('logistics_charges_tkd'); ?>
          <span style="color:red;">  *</span></label>
         <div class="col-sm-3">
           <input type="text"  name="logistics_charges_tkd" id="logistics_charges_tkd" class="form-control integerchk" value="<?php if(isset($info)) echo $info->logistics_charges_tkd; elseif(set_value('logistics_charges_tkd')) echo set_value('logistics_charges_tkd');  else echo 0; ?>" onkeyup="return checkQuantity();">
           <span class="error-msg"><?php echo form_error("logistics_charges_tkd");?></span>
         </div>
         <label class="col-sm-2 control-label"><?php echo lang('uepz_gate_tips'); ?>
         <span style="color:red;"> * </span></label>
         <div class="col-sm-3">
           <input type="text"  name="uepz_gate_tips" id="uepz_gate_tips" class="form-control integerchk" value="<?php if(isset($info)) echo $info->uepz_gate_tips; elseif(set_value('uepz_gate_tips')) echo set_value('uepz_gate_tips');  else echo 0;  ?>" onkeyup="return checkQuantity();">
           <span class="error-msg"><?php echo form_error("uepz_gate_tips");?></span>
         </div>
         </div>
         <div class="form-group">
         	<label class="col-sm-2 control-label"><?php echo lang('eta_uttara_factory'); ?> 
          <span style="color:red;">  *</span></label>
           <div class="col-sm-3">
            <div class="input-group date">
             <div class="input-group-addon">
               <i class="fa fa-calendar"></i>
             </div>
             <input type="text" name="eta_uttara_factory" readonly id="eta_uttara_factory" class="form-control pull-right" value="<?php if(isset($info)) echo $info->eta_uttara_factory; else echo date('Y-m-d'); ?>">
           </div>
           <span class="error-msg"><?php echo form_error("eta_uttara_factory");?></span>
          </div>
         <label class="col-sm-2 control-label"><?php echo lang('exception_remarks'); ?>
          <span style="color:red;">  *</span></label>
         <div class="col-sm-3">
           <input type="text"  name="exception_remarks" id="exception_remarks" class="form-control" value="<?php if(isset($info)) echo $info->exception_remarks; elseif(set_value('exception_remarks')) echo set_value('exception_remarks');  else echo 0;  ?>" onkeyup="return checkQuantity();">
           <span class="error-msg"><?php echo form_error("exception_remarks");?></span>
         </div>
         </div>
        
    
  
  
<br><br>
</div>
  <!-- /.box-body -->
  <div class="box-footer">
      <div class="col-sm-4"><a href="<?php echo base_url(); ?>shipping/bdimport/lists" class="btn btn-info">
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

