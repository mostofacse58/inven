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



  function formsubmit(){
  var error_status=false;
 
  var ex_fty_date=$("#ex_fty_date").val();
  if(ex_fty_date == ''){
    error_status=true;
    $('input[name=ex_fty_date]').css('border', '1px solid #f00');
  } else {
    $('input[name=ex_fty_date]').css('border', '1px solid #ccc');      
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
      var machineries_part=$("#machineries_part").val();
      if($.trim(machineries_part)==""|| $.isNumeric(machineries_part)==false){
        $("#machineries_part").val(0);
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
        <form class="form-horizontal" action="<?php echo base_url(); ?>shipping/import/save<?php if (isset($info)) echo "/$info->import_id"; ?>" method="POST" enctype="multipart/form-data" onsubmit="return formsubmit();">
         <div class="box-body">
          <div class="form-group">
          <label class="col-sm-2 control-label"><?php echo lang('ex_fty_date'); ?> 
          <span style="color:red;">  *</span></label>
           <div class="col-sm-3">
            <div class="input-group date">
             <div class="input-group-addon">
               <i class="fa fa-calendar"></i>
             </div>
             <input type="text" name="ex_fty_date" readonly id="ex_fty_date" class="form-control pull-right" value="<?php if(isset($info)) echo $info->ex_fty_date; else echo date('Y-m-d'); ?>">
           </div>
           <span class="error-msg"><?php echo form_error("ex_fty_date");?></span>
          </div>
         <label class="col-sm-2 control-label"><?php echo lang('port_of_loading'); ?>
         <span style="color:red;">  *</span></label>
         <div class="col-sm-3">
            <select class="form-control select2" name="port_of_loading" id="port_of_loading" required="">
              <option value=""><?php echo lang('select'); ?></option>
              <?php foreach ($plist as $value) {  ?>
              <option value="<?php echo $value->port_of_loading; ?>"
              <?php  if(isset($info)) echo $value->port_of_loading==$info->port_of_loading? 'selected="selected"':0; 
              else echo set_select('port_of_loading',$value->port_of_loading);?>>
              <?php echo "$value->port_of_loading"; ?></option>
              <?php } ?>
            </select>
           <span class="error-msg"><?php echo form_error("port_of_loading");?></span>
         </div>
         <div class="col-sm-1">
            <a href="javascript:;" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#portModal"><i class="fa fa-plus"></i></a>
          </div>
         </div>
        <div class="form-group">
         <label class="col-sm-2 control-label"><?php echo lang('routing'); ?>
         <span style="color:red;">  *</span></label>
         <div class="col-sm-3">
           <input type="text" name="routing" id="routing" class="form-control" value="<?php if(isset($info)) echo $info->routing; else echo set_value('routing'); ?>">
           <span class="error-msg"><?php echo form_error("routing");?></span>
         </div>
         <label class="col-sm-2 control-label"><?php echo lang('port_of_discharge'); ?>
         <span style="color:red;">  *</span></label>
         <div class="col-sm-3">
          <select class="form-control select2" name="port_of_discharge" id="port_of_discharge" style="width: 100%" required>
            <option value=""><?php echo lang('select'); ?></option>
            <option value="CHATTOGRAM"
              <?php  if(isset($info)) echo 'CHATTOGRAM'==$info->port_of_discharge? 'selected="selected"':0; else echo set_select('port_of_discharge','CHATTOGRAM');?>>
                CHATTOGRAM</option>
            <option value="DAC"
              <?php  if(isset($info)) echo 'DAC'==$info->port_of_discharge? 'selected="selected"':0; else echo set_select('port_of_discharge','DAC');?>>
                DAC</option>
            </select>
           <span class="error-msg"><?php echo form_error("port_of_discharge");?></span>
          </div>
        </div>
        <div class="form-group">
         <label class="col-sm-2 control-label"><?php echo lang('shipped_qty'); ?>
          <span style="color:red;">  *</span></label>
         <div class="col-sm-3">
           <input type="text"  name="shipped_qty" id="shipped_qty" class="form-control integerchk" value="<?php if(isset($info)) echo $info->shipped_qty; else echo set_value('shipped_qty'); ?>" onkeyup="return checkQuantity();">
           <span class="error-msg"><?php echo form_error("shipped_qty");?></span>
         </div>
         <label class="col-sm-2 control-label"><?php echo lang('shipping_packages'); ?>
         <span style="color:red;"> * </span></label>
         <div class="col-sm-3">
           <input type="text"  name="shipping_packages" id="shipping_packages" class="form-control" value="<?php if(isset($info)) echo $info->shipping_packages; else echo set_value('shipping_packages'); ?>">
           <span class="error-msg"><?php echo form_error("shipping_packages");?></span>
         </div>
         </div>
         <div class="form-group">
         <label class="col-sm-2 control-label"><?php echo lang('building_material'); ?>
          <span style="color:red;">  *</span></label>
         <div class="col-sm-3">
           <input type="text"  name="building_material" id="building_material" class="form-control integerchk" onfocus="this.select();" value="<?php if(isset($info)) echo $info->building_material; elseif(set_value('building_material')) echo set_value('building_material');  else echo 0; ?>" onkeyup="return checkQuantity();">
           <span class="error-msg"><?php echo form_error("building_material");?></span>
         </div>
         <label class="col-sm-2 control-label"><?php echo lang('cutting_die_material'); ?>
         <span style="color:red;"> * </span></label>
         <div class="col-sm-3">
           <input type="text"  name="cutting_die_material" id="cutting_die_material" class="form-control integerchk" onfocus="this.select();" value="<?php if(isset($info)) echo $info->cutting_die_material; elseif(set_value('cutting_die_material')) echo set_value('cutting_die_material');  else echo 0;  ?>" onkeyup="return checkQuantity();">
           <span class="error-msg"><?php echo form_error("cutting_die_material");?></span>
         </div>
         </div>
         <div class="form-group">
         <label class="col-sm-2 control-label"><?php echo lang('machineries_part'); ?>
          <span style="color:red;">  *</span></label>
         <div class="col-sm-3">
           <input type="text"  name="machineries_part" id="machineries_part" class="form-control integerchk" onfocus="this.select();" value="<?php if(isset($info)) echo $info->machineries_part; elseif(set_value('machineries_part')) echo set_value('machineries_part');  else echo 0;  ?>" onkeyup="return checkQuantity();">
           <span class="error-msg"><?php echo form_error("machineries_part");?></span>
         </div>
         <label class="col-sm-2 control-label"><?php echo lang('others_weight'); ?>
         <span style="color:red;"> * </span></label>
         <div class="col-sm-3">
           <input type="text"  name="others_weight" id="others_weight" class="form-control integerchk" onfocus="this.select();" value="<?php if(isset($info)) echo $info->others_weight; elseif(set_value('others_weight')) echo set_value('others_weight');  else echo 0;  ?>" onkeyup="return checkQuantity();">
           <span class="error-msg"><?php echo form_error("others_weight");?></span>
         </div>
         </div>
         <div class="form-group">
         <label class="col-sm-2 control-label"><?php echo lang('mmk_weight'); ?>
          <span style="color:red;">  *</span></label>
         <div class="col-sm-3">
           <input type="text"  name="mmk_weight" id="mmk_weight" class="form-control integerchk" onfocus="this.select();" value="<?php if(isset($info)) echo $info->mmk_weight; elseif(set_value('mmk_weight')) echo set_value('mmk_weight');  else echo 0;  ?>" onkeyup="return checkQuantity();">
           <span class="error-msg"><?php echo form_error("mmk_weight");?></span>
         </div>
         <label class="col-sm-2 control-label"><?php echo lang('mkm_weight'); ?>
         <span style="color:red;"> * </span></label>
         <div class="col-sm-3">
           <input type="text"  name="mkm_weight" id="mkm_weight" class="form-control integerchk" onfocus="this.select();" value="<?php if(isset($info)) echo $info->mkm_weight; elseif(set_value('mkm_weight')) echo set_value('mkm_weight');  else echo 0;  ?>" onkeyup="return checkQuantity();">
           <span class="error-msg"><?php echo form_error("mkm_weight");?></span>
         </div>
         </div>
         <div class="form-group">
         <label class="col-sm-2 control-label"><?php echo lang('coach_weight'); ?>
          <span style="color:red;">  *</span></label>
         <div class="col-sm-3">
           <input type="text"  name="coach_weight" id="coach_weight" class="form-control integerchk" onfocus="this.select();" value="<?php if(isset($info)) echo $info->coach_weight; elseif(set_value('coach_weight')) echo set_value('coach_weight');  else echo 0;  ?>" onkeyup="return checkQuantity();">
           <span class="error-msg"><?php echo form_error("coach_weight");?></span>
         </div>
         <label class="col-sm-2 control-label"><?php echo lang('katespade_weight'); ?>
         <span style="color:red;"> * </span></label>
         <div class="col-sm-3">
           <input type="text"  name="katespade_weight" id="katespade_weight" class="form-control integerchk" onfocus="this.select();" value="<?php if(isset($info)) echo $info->katespade_weight; elseif(set_value('katespade_weight')) echo set_value('katespade_weight');  else echo 0;  ?>" onkeyup="return checkQuantity();">
           <span class="error-msg"><?php echo form_error("katespade_weight");?></span>
         </div>
         </div>

         <div class="form-group">
         <label class="col-sm-2 control-label"><?php echo lang('file_no'); ?>
          <span style="color:red;">  *</span></label>
         <div class="col-sm-3">
           <select class="form-control select2" name="file_no[]" id="file_no" required=""  multiple="multiple" data-placeholder="Select multiple file">
              <option value=""><?php echo lang('select'); ?></option>
              <?php if(isset($info)) $fdetail=explode(",",$info->file_no);
              foreach ($flist as $value) {  ?>
              <option value="<?php echo $value->file_no; ?>" <?php if(isset($info))
                  {if(in_array($value->file_no, $fdetail)) echo 'selected="selected"';}else{
                   if(isset($_POST['file_no'])) if(in_array($value->file_no, $_POST['file_no'])) echo 'selected="selected"';
                    } ?>><?php echo $value->file_no; ?></option>
              <?php } ?>
            </select>
           <span class="error-msg"><?php echo form_error("file_no");?></span>
         </div>
         <label class="col-sm-2 control-label"><?php echo lang('season'); ?>
         <span style="color:red;"> * </span></label>
         <div class="col-sm-3">
           <select class="form-control select2" name="season[]" id="season" required=""  multiple="multiple" data-placeholder="Select multiple season">
              <option value=""><?php echo lang('select'); ?></option>
              <?php if(isset($info)) $sedetail=explode(",",$info->season);
              foreach ($selist as $value) {  ?>
              <option value="<?php echo $value->season; ?>" <?php if(isset($info))
                  {if(in_array($value->season, $sedetail)) echo 'selected="selected"';}else{
                   if(isset($_POST['season'])) if(in_array($value->season, $_POST['season'])) echo 'selected="selected"';
                    } ?>><?php echo $value->season; ?></option>
              <?php } ?>
            </select>
           <span class="error-msg"><?php echo form_error("season");?></span>
         </div>
         </div>

         <div class="form-group">
         <label class="col-sm-2 control-label"><?php echo lang('customer_name'); ?>
          <span style="color:red;">  *</span></label>
         <div class="col-sm-3">
           <select class="form-control select2" name="customer_name[]" id="customer_name" required=""  multiple="multiple" data-placeholder="Select multiple customer">
              <option value=""><?php echo lang('select'); ?></option>
              <?php if(isset($info)) $cdetail=explode(",",$info->customer_name);
              foreach ($clist as $value) {  ?>
              <option value="<?php echo $value->customer_name; ?>" <?php if(isset($info))
                  {if(in_array($value->customer_name, $cdetail)) echo 'selected="selected"';}else{
                   if(isset($_POST['customer_name'])) if(in_array($value->customer_name, $_POST['customer_name'])) echo 'selected="selected"';
                    } ?>><?php echo $value->customer_name; ?></option>
              <?php } ?>
            </select>
           <span class="error-msg"><?php echo form_error("customer_name");?></span>
         </div>
         <label class="col-sm-2 control-label"><?php echo lang('supplier'); ?> 1
         <span style="color:red;"> * </span></label>
         <div class="col-sm-3">
           <select class="form-control select2" name="supplier_name" id="supplier_name" required="">
              <option value=""><?php echo lang('select'); ?></option>
              <?php foreach ($slist as $value) {  ?>
              <option value="<?php echo $value->supplier_name; ?>"
              <?php  if(isset($info)) echo $value->supplier_name==$info->supplier_name? 'selected="selected"':0; 
              else echo set_select('supplier_name',$value->supplier_name);?>>
              <?php echo "$value->supplier_name"; ?></option>
              <?php } ?>
            </select>
           <span class="error-msg"><?php echo form_error("supplier_name");?></span>
         </div>
         </div>
         <div class="form-group">
         <label class="col-sm-2 control-label"><?php echo lang('invoice_no'); ?>
          <span style="color:red;">  *</span></label>
         <div class="col-sm-3">
           <input type="text"  name="invoice_no" id="invoice_no" class="form-control" value="<?php if(isset($info)) echo $info->invoice_no; else echo set_value('invoice_no'); ?>">
           <span class="error-msg"><?php echo form_error("invoice_no");?></span>
         </div>
         <label class="col-sm-2 control-label"><?php echo lang('invoice_date'); ?> 
          <span style="color:red;">  *</span></label>
           <div class="col-sm-3">
            <div class="input-group date">
             <div class="input-group-addon">
               <i class="fa fa-calendar"></i>
             </div>
             <input type="text" name="invoice_date" readonly id="invoice_date" class="form-control pull-right" value="<?php if(isset($info)) echo $info->invoice_date; else echo date('Y-m-d'); ?>">
           </div>
           <span class="error-msg"><?php echo form_error("invoice_date");?></span>
          </div>
        </div>
        <div class="form-group">
         <label class="col-sm-2 control-label"><?php echo lang('invoice_amount'); ?>
         <span style="color:red;">  *</span></label>
         <div class="col-sm-3">
           <input type="text"  name="invoice_amount" id="invoice_amount" class="form-control integerchk" value="<?php if(isset($info)) echo $info->invoice_amount; else echo set_value('invoice_amount'); ?>">
           <span class="error-msg"><?php echo form_error("invoice_amount");?></span>
         </div>
         <label class="col-sm-2 control-label"><?php echo lang('supplier'); ?> 2
         <span style="color:red;"> * </span></label>
         <div class="col-sm-3">
           <select class="form-control select2" name="supplier_name2" id="supplier_name2" required="">
              <option value=""><?php echo lang('select'); ?></option>
              <?php foreach ($s2list as $value) {  ?>
              <option value="<?php echo $value->supplier_name2; ?>"
              <?php  if(isset($info)) echo $value->supplier_name2==$info->supplier_name2? 'selected="selected"':0; 
              else echo set_select('supplier_name2',$value->supplier_name2);?>>
              <?php echo "$value->supplier_name2"; ?></option>
              <?php } ?>
            </select>
           <span class="error-msg"><?php echo form_error("supplier_name2");?></span>
         </div>
         </div>
        <div class="form-group">
         <label class="col-sm-2 control-label"><?php echo lang('hk_re_export_inv'); ?>
         <span style="color:red;">  </span></label>
         <div class="col-sm-3">
           <input type="text"  name="hk_re_export_inv" id="hk_re_export_inv" class="form-control" value="<?php if(isset($info)) echo $info->hk_re_export_inv; else echo set_value('hk_re_export_inv'); ?>">
           <span class="error-msg"><?php echo form_error("hk_re_export_inv");?></span>
         </div>
         <label class="col-sm-2 control-label"><?php echo lang('shipping_terms'); ?>
         <span style="color:red;"> * </span></label>
         <div class="col-sm-3">
            <select class="form-control select2" name="shipping_terms" id="shipping_terms" required="">
              <option value=""><?php echo lang('select'); ?></option>
              <?php foreach ($tlist as $value) {  ?>
              <option value="<?php echo $value->shipping_terms; ?>"
              <?php  if(isset($info)) echo $value->shipping_terms==$info->shipping_terms? 'selected="selected"':0; 
              else echo set_select('shipping_terms',$value->shipping_terms);?>>
              <?php echo "$value->shipping_terms"; ?></option>
              <?php } ?>
            </select>
           <span class="error-msg"><?php echo form_error("shipping_terms");?></span>
         </div>
         </div>
         <div class="form-group">
         <label class="col-sm-2 control-label"><?php echo lang('vessel_voyage'); ?>
         <span style="color:red;">  </span></label>
         <div class="col-sm-3">
           <input type="text"  name="vessel_voyage" id="vessel_voyage" class="form-control" value="<?php if(isset($info)) echo $info->vessel_voyage; else echo set_value('vessel_voyage'); ?>">
           <span class="error-msg"><?php echo form_error("vessel_voyage");?></span>
         </div>
         <label class="col-sm-2 control-label"><?php echo lang('carrier_name'); ?>
         <span style="color:red;"> * </span></label>
         <div class="col-sm-3">
            <select class="form-control select2" name="carrier_name" id="carrier_name" required="">
              <option value=""><?php echo lang('select'); ?></option>
              <?php foreach ($calist as $value) {  ?>
              <option value="<?php echo $value->carrier_name; ?>"
              <?php  if(isset($info)) echo $value->carrier_name==$info->carrier_name? 'selected="selected"':0; else echo set_select('carrier_name',$value->carrier_name);?>>
              <?php echo "$value->carrier_name"; ?></option>
              <?php } ?>
            </select>
           <span class="error-msg"><?php echo form_error("carrier_name");?></span>
         </div>
         </div>
        <div class="form-group">
         <label class="col-sm-2 control-label"><?php echo lang('etd_port'); ?> 
          <span style="color:red;">  *</span></label>
           <div class="col-sm-3">
            <div class="input-group date">
             <div class="input-group-addon">
               <i class="fa fa-calendar"></i>
             </div>
             <input type="text" name="etd_port" readonly id="etd_port" class="form-control pull-right" value="<?php if(isset($info)) echo $info->etd_port; else echo date('Y-m-d'); ?>">
           </div>
           <span class="error-msg"><?php echo form_error("etd_port");?></span>
          </div>
         <label class="col-sm-2 control-label"><?php echo lang('eta_port'); ?> 
          <span style="color:red;">  *</span></label>
           <div class="col-sm-3">
            <div class="input-group date">
             <div class="input-group-addon">
               <i class="fa fa-calendar"></i>
             </div>
             <input type="text" name="eta_port" readonly id="eta_port" class="form-control pull-right" value="<?php if(isset($info)) echo $info->eta_port; else echo date('Y-m-d'); ?>">
           </div>
           <span class="error-msg"><?php echo form_error("eta_port");?></span>
          </div>
        </div>
        <div class="form-group">
         <label class="col-sm-2 control-label"><?php echo lang('bl_no'); ?>
          <span style="color:red;">  *</span></label>
         <div class="col-sm-3">
           <input type="text"  name="bl_no" id="bl_no" class="form-control" value="<?php if(isset($info)) echo $info->bl_no; else echo set_value('bl_no'); ?>">
           <span class="error-msg"><?php echo form_error("bl_no");?></span>
         </div>
         <label class="col-sm-2 control-label"><?php echo lang('obl_no'); ?>
         <span style="color:red;"> * </span></label>
         <div class="col-sm-3">
           <input type="text"  name="obl_no" id="obl_no" class="form-control" value="<?php if(isset($info)) echo $info->obl_no; else echo set_value('obl_no'); ?>">
           <span class="error-msg"><?php echo form_error("obl_no");?></span>
         </div>
        </div>
        <div class="form-group">
         <label class="col-sm-2 control-label"><?php echo lang('container_no'); ?>
          <span style="color:red;">  *</span></label>
         <div class="col-sm-3">
           <input type="text"  name="container_no" id="container_no" class="form-control" value="<?php if(isset($info)) echo $info->container_no; else echo set_value('container_no'); ?>">
           <span class="error-msg"><?php echo form_error("container_no");?></span>
         </div>
         <label class="col-sm-2 control-label"><?php echo lang('number_of_consignment'); ?>
         <span style="color:red;"> * </span></label>
         <div class="col-sm-3">
           <input type="text"  name="number_of_consignment" id="number_of_consignment" class="form-control integerchk" value="<?php if(isset($info)) echo $info->number_of_consignment; else echo set_value('number_of_consignment'); ?>">
           <span class="error-msg"><?php echo form_error("number_of_consignment");?></span>
         </div>
        </div>
        <div class="form-group">
         <label class="col-sm-2 control-label"><?php echo lang('korea_to_hkg_port'); ?>
          <span style="color:red;">  *</span></label>
         <div class="col-sm-3">
           <input type="text"  name="korea_to_hkg_port" id="korea_to_hkg_port" class="form-control integerchk" value="<?php if(isset($info)) echo $info->korea_to_hkg_port; else echo set_value('korea_to_hkg_port'); ?>">
           <span class="error-msg"><?php echo form_error("korea_to_hkg_port");?></span>
         </div>
         <label class="col-sm-2 control-label"><?php echo lang('trucking_fee'); ?>
         <span style="color:red;"> * </span></label>
         <div class="col-sm-3">
           <input type="text"  name="trucking_fee" id="trucking_fee" class="form-control integerchk" value="<?php if(isset($info)) echo $info->trucking_fee; else echo set_value('trucking_fee'); ?>">
           <span class="error-msg"><?php echo form_error("trucking_fee");?></span>
         </div>
        </div>
        <div class="form-group">
         <label class="col-sm-2 control-label"><?php echo lang('freight_amount'); ?>
          <span style="color:red;">  *</span></label>
         <div class="col-sm-3">
           <input type="text"  name="freight_amount" id="freight_amount" class="form-control integerchk" value="<?php if(isset($info)) echo $info->freight_amount; else echo set_value('freight_amount'); ?>">
           <span class="error-msg"><?php echo form_error("freight_amount");?></span>
         </div>
         <label class="col-sm-2 control-label"><?php echo lang('export_declaration'); ?>
         <span style="color:red;"> * </span></label>
         <div class="col-sm-3">
           <input type="text"  name="export_declaration" id="export_declaration" class="form-control" value="<?php if(isset($info)) echo $info->export_declaration; else echo set_value('export_declaration'); ?>">
           <span class="error-msg"><?php echo form_error("export_declaration");?></span>
         </div>
        </div>
        <div class="form-group">
         <label class="col-sm-2 control-label"><?php echo lang('air_reason_record'); ?>
          <span style="color:red;">  *</span></label>
         <div class="col-sm-3">
           <input type="text"  name="air_reason_record" id="air_reason_record" class="form-control" value="<?php if(isset($info)) echo $info->air_reason_record; else echo set_value('air_reason_record'); ?>">
           <span class="error-msg"><?php echo form_error("air_reason_record");?></span>
         </div>
          <label class="col-sm-2 control-label">Attachment</label>
          <div class="col-sm-3">
            <input type="file" class="form-control"  name="attachment" class="form-control" >
            <?php if(isset($info) &&!empty($info->attachment)) { ?>
              <div style="margin-top:10px;">
              <a href="<?php echo base_url(); ?>dashboard/shipping/<?php echo $info->attachment ?>">Download</a>
              </div>
            <?php } ?>
          </div>
        </div><!-- ///////////////////// -->
  
<br><br>
</div>
  <!-- /.box-body -->
  <div class="box-footer">
      <div class="col-sm-4"><a href="<?php echo base_url(); ?>shipping/import/lists" class="btn btn-info">
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
        url:"<?php echo base_url()?>"+'shipping/import/getShipTo',
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