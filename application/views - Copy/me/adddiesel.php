  <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>asset/datepickerbootstrap/css/datepicker.css">
<script type="text/javascript" src="<?php echo base_url();?>asset/datepickerbootstrap/js/bootstrap-datepicker.js"></script>
<script>
 $(document).ready(function(){
  //////////////////date picker//////////////////////
    $('.date').datepicker({
      "format":"dd/mm/yyyy",
      "todayHighlight": true,
      "autoclose":true
    });

   });
 function formsubmit(){
  var error_status=false;
  var issue_date=$("#issue_date").val();
  var issue_qty= parseFloat($("#issue_qty").val());
  var fuel_using_dept_id=$("#fuel_using_dept_id").val();
    if(fuel_using_dept_id == ''){
      error_status=true;
      $("#alertMessageHTML").html("Please select Department!!");
      $("#alertMessagemodal").modal("show");
    } else {
      $('select[name=fuel_using_dept_id]').css('border', '1px solid #ccc');
    }
    var taken_by=$("#taken_by").val();
    if(taken_by == ''){
      error_status=true;
      $("#alertMessageHTML").html("Please select Taken By!!");
      $("#alertMessagemodal").modal("show");
    } else {
      $('select[name=taken_by]').css('border', '1px solid #ccc');      
    }
    var motor_id=$("#motor_id").val();
    if(motor_id == ''){
      error_status=true;
      $("#alertMessageHTML").html("Please select Vehicle!!");
      $("#alertMessagemodal").modal("show");
    } else {
      $('select[name=motor_id]').css('border', '1px solid #ccc');      
    }
    if(issue_date == '') {
      error_status=true;
      $("#issue_date").css('border', '1px solid #f00');
    } else {
      $("#issue_date").css('border', '1px solid #ccc');      
    }
    if(issue_qty == ''||issue_qty ==0) {
      error_status=true;
      $("#issue_qty").css('border', '1px solid #f00');
    } else {
      $("#issue_qty").css('border', '1px solid #ccc');      
    }
    if(error_status==true){
      return false;
    }else{
      $('button[type=submit]').attr('disabled','disabled');
      return true;
    }
}
function fuelreading(){
    var fuel_r_start_point_km_liter=parseFloat($.trim($("#fuel_r_start_point_km_liter").val()));
    var on_officicer_km=parseFloat($.trim($("#on_officicer_km").val()));
    var fuel_r_end_point_km_liter=parseFloat($.trim($("#fuel_r_end_point_km_liter").val()));
    ////////////
    if($.trim(fuel_r_start_point_km_liter)==""||isNaN(fuel_r_start_point_km_liter)){
      $("#fuel_r_start_point_km_liter").val(0);
      fuel_r_start_point_km_liter=0;
     }
     if($.trim(on_officicer_km)==""||isNaN(on_officicer_km)){
      $("#on_officicer_km").val(0);
      on_officicer_km=0;
     }
     if($.trim(fuel_r_end_point_km_liter)==""||isNaN(fuel_r_end_point_km_liter)){
      $("#fuel_r_end_point_km_liter").val(0);
      fuel_r_end_point_km_liter=0;
     }
    if(fuel_r_start_point_km_liter!=""&&fuel_r_end_point_km_liter!=""){
    var run_km_liter=fuel_r_end_point_km_liter-fuel_r_start_point_km_liter-on_officicer_km;
    $("#run_km_liter").val(run_km_liter);
    }
  }
  function runhours(){
    var start_hour=parseFloat($.trim($("#start_hour").val()));
    var stop_hour=parseFloat($.trim($("#stop_hour").val()));
    if($.trim(start_hour)==""||isNaN(start_hour)){
      $("#start_hour").val(0);
     }
     if($.trim(stop_hour)==""||isNaN(stop_hour)){
      $("#stop_hour").val(0);
     }
    if(start_hour!=""&&stop_hour!=""){
     var run_hour=stop_hour-start_hour;
     $("#run_hour").val(run_hour);
    }
  }
  function calculations(){
    var issue_qty=parseFloat($.trim($("#issue_qty").val()));
    var unit_price=parseFloat($.trim($("#unit_price").val()));
    if($.trim(issue_qty)==""||isNaN(issue_qty)){
      $("#issue_qty").val(0);
     }
     if($.trim(unit_price)==""||isNaN(unit_price)){
      $("#unit_price").val(0);
     }
    if(issue_qty!=""&&unit_price!=""){
     var amount=unit_price*issue_qty;
     $("#amount").val(amount);
    }
  }
</script>
<div class="row">
<div class="col-md-12">
  <div class="panel panel-success">
  <div class="box-header">
<div class="widget-block">
<div class="widget-head">
<h5><?php echo ucwords($heading); ?></h5>
<div class="widget-control pull-right">

</div>
</div>
</div>
</div>
   <div class="box box-info">
    <!-- /.box-header -->
    <form class="form-horizontal" action="<?php echo base_url();?>me/dieselissue/save<?php if(isset($info)) echo "/$info->fuel_issue_id"; ?>" method="POST" enctype="multipart/form-data"  onsubmit="return formsubmit();">
      <div class="box-body">
        <div class="form-group">
          <label class="col-sm-2 control-label">
          Vehicle Name <span style="color:red;">  *</span></label>
          <div class="col-sm-2">
          <select class="form-control select2" name="motor_id" id="motor_id" style="width: 100%"> 
          <option value="" selected="selected">Select Vehicle</option>
          <?php foreach ($mlist as $rows) { ?>
            <option value="<?php echo $rows->motor_id; ?>" 
            <?php if (isset($info))
              echo $rows->motor_id == $info->motor_id ? 'selected="selected"' : 0;
            else
              echo $rows->motor_id == set_value('motor_id') ? 'selected="selected"' : 0;
            ?>><?php echo $rows->motor_name; ?></option>
                <?php } ?>
            </select>
        <span class="error-msg"><?php echo form_error("motor_id"); ?></span>
      </div>
       <label class="col-sm-1 control-label">Date <span style="color:red;">  *</span></label>
         <div class="col-sm-2">
          <div class="input-group date">
             <div class="input-group-addon">
               <i class="fa fa-calendar"></i>
             </div>
             <input type="text" name="issue_date" id="issue_date" readonly class="form-control pull-right" value="<?php if(isset($info)) echo findDate($info->issue_date); else echo set_value('issue_date'); ?>">
           </div>
         <span class="error-msg"><?php echo form_error("issue_date");?></span>
       </div>
      <label class="col-sm-2 control-label">
          Department <span style="color:red;">  *</span></label>
          <div class="col-sm-2">
          <select class="form-control select2" name="fuel_using_dept_id" id="fuel_using_dept_id" style="width: 100%"> 
          <option value="" selected="selected">Select Department</option>
          <?php foreach ($dlist as $rows) { ?>
            <option value="<?php echo $rows->fuel_using_dept_id; ?>" 
            <?php if (isset($info))
              echo $rows->fuel_using_dept_id == $info->fuel_using_dept_id ? 'selected="selected"' : 0;
            else
              echo $rows->fuel_using_dept_id == set_value('fuel_using_dept_id') ? 'selected="selected"' : 0;
            ?>><?php echo $rows->fuel_using_dept_name; ?></option>
                <?php } ?>
            </select>
        <span class="error-msg"><?php echo form_error("fuel_using_dept_id"); ?></span>
      </div>
      </div>
      <!-- ///////////////////// -->
      <div class="form-group">
        <label class="col-sm-2 control-label">
          Taken By <span style="color:red;">  *</span></label>
          <div class="col-sm-2">
          <select class="form-control select2" name="taken_by" id="taken_by" style="width: 100%"> 
          <option value="" selected="selected">Select Taken</option>
          <?php foreach ($tlist as $rows) { ?>
            <option value="<?php echo $rows->driver_id; ?>" 
            <?php if (isset($info))
              echo $rows->driver_id == $info->taken_by ? 'selected="selected"' : 0;
            else
              echo $rows->driver_id == set_value('taken_by') ? 'selected="selected"' : 0;
            ?>><?php echo $rows->driver_name; ?></option>
                <?php } ?>
            </select>
        <span class="error-msg"><?php echo form_error("taken_by"); ?></span>
      </div>
      <label class="col-sm-1 control-label ">Req. No <span style="color:red;"> </span></label>
          <div class="col-sm-2">
          <input type="text" name="req_no" id="req_no" class="form-control" value="<?php if(isset($info)) echo $info->req_no; else echo set_value('req_no'); ?>">
          <span class="error-msg"><?php echo form_error("req_no");?></span>
         </div>
        <label class="col-sm-2 control-label ">Issue Qty(Liter) <span style="color:red;">*</span></label>
          <div class="col-sm-2">
          <input type="text" name="issue_qty" id="issue_qty" class="form-control integerchk" value="<?php if(isset($info)) echo $info->issue_qty; else echo 0; ?>" onblur="return calculations();" onkeyup="return calculations();">
          <span class="error-msg"><?php echo form_error("issue_qty");?></span>
         </div>
      </div>
      <div class="form-group">
        <label class="col-sm-2 control-label">
          Product Name <span style="color:red;">  *</span></label>
          <div class="col-sm-2">
          <select class="form-control select2" name="product_id" id="product_id" style="width: 100%"> 
          <?php $plist=$this->db->query("SELECT * FROM product_info WHERE diesel_yes=1")->result();
           foreach ($plist as $rows) { ?>
            <option value="<?php echo $rows->product_id; ?>" 
            <?php if (isset($info))
              echo $rows->product_id == $info->product_id ? 'selected="selected"' : 0; else
              echo $rows->product_id == set_value('product_id') ? 'selected="selected"' : 0;
            ?>><?php echo "$rows->product_name($rows->main_stock)"; ?></option>
                <?php } ?>
            </select>
        <span class="error-msg"><?php echo form_error("taken_by"); ?></span>
      </div>
      <label class="col-sm-2 control-label ">Unit Price <span style="color:red;"> </span></label>
        <div class="col-sm-2">
         <input type="text" name="unit_price" id="unit_price" class="form-control integerchk" value="<?php if(isset($info)) echo $info->unit_price; else echo $rows->unit_price; ?>"  onblur="return calculations();" onkeyup="return calculations();">
         <span class="error-msg"><?php echo form_error("unit_price");?></span>
       </div>
       <label class="col-sm-2 control-label ">Amount <span style="color:red;"> </span></label>
        <div class="col-sm-2">
         <input type="text" name="amount" readonly id="amount" class="form-control  integerchk" value="<?php if(isset($info)) echo $info->amount; else echo 0; ?>">
         <span class="error-msg"><?php echo form_error("amount");?></span>
       </div>
      </div>
      <!-- ///////////////////// -->
      <div class="form-group">
       <label class="col-sm-2 control-label ">Fuel Reading at Start Point (Liter) <span style="color:red;"> </span></label>
          <div class="col-sm-2">
           <input type="text" name="fuel_r_start_point_km_liter" id="fuel_r_start_point_km_liter" class="form-control  integerchk" value="<?php if(isset($info)) echo $info->fuel_r_start_point_km_liter; else echo 0; ?>" onblur="return fuelreading();" onkeyup="return fuelreading();">
           <span class="error-msg"><?php echo form_error("fuel_r_start_point_km_liter");?></span>
         </div>
         <label class="col-sm-2 control-label ">Fuel Reading at Stop Point (Liter) <span style="color:red;"> </span></label>
          <div class="col-sm-2">
           <input type="text" name="fuel_r_end_point_km_liter" id="fuel_r_end_point_km_liter" class="form-control  integerchk" value="<?php if(isset($info)) echo $info->fuel_r_end_point_km_liter; else echo 0; ?>" onblur="return fuelreading();" onkeyup="return fuelreading();">
           <span class="error-msg"><?php echo form_error("fuel_r_end_point_km_liter");?></span>
         </div>
         <label class="col-sm-2 control-label ">Run KM/Liter <span style="color:red;"> </span></label>
          <div class="col-sm-2">
           <input type="text" name="run_km_liter" id="run_km_liter" class="form-control pull-right" value="<?php if(isset($info)) echo $info->run_km_liter; else echo 0; ?>">
           <span class="error-msg"><?php echo form_error("run_km_liter");?></span>
         </div>
      </div>
      <!-- ///////////////////// -->
      <div class="form-group">
       <label class="col-sm-2 control-label ">Start Run Hr <span style="color:red;"> </span></label>
          <div class="col-sm-2">
           <input type="text" name="start_hour" id="start_hour" class="form-control  integerchk" value="<?php if(isset($info)) echo $info->start_hour; else echo 0; ?>" onblur="return runhours();" onkeyup="return runhours();">
           <span class="error-msg"><?php echo form_error("start_hour");?></span>
         </div>
         <label class="col-sm-2 control-label ">Stop Run Hr <span style="color:red;"> </span></label>
          <div class="col-sm-2">
           <input type="text" name="stop_hour" id="stop_hour" class="form-control  integerchk" value="<?php if(isset($info)) echo $info->stop_hour; else echo 0; ?>" onblur="return runhours();" onkeyup="return runhours();">
           <span class="error-msg"><?php echo form_error("stop_hour");?></span>
         </div>
         <label class="col-sm-2 control-label ">Run Hr <span style="color:red;"> </span></label>
          <div class="col-sm-2">
           <input type="text" name="run_hour" id="run_hour" class="form-control  integerchk" value="<?php if(isset($info)) echo $info->run_hour; else echo 0; ?>">
           <span class="error-msg"><?php echo form_error("run_hour");?></span>
         </div>
      </div>
       
       <div class="form-group">
        <label class="col-sm-2 control-label ">
          Un-Official Km
          <span style="color:red;"> </span></label>
          <div class="col-sm-2">
           <input type="text" name="on_officicer_km" id="on_officicer_km" class="form-control" value="<?php if(isset($info)) echo $info->on_officicer_km; else echo 0; ?>" onblur="return fuelreading();" onkeyup="return fuelreading();">
           <span class="error-msg"><?php echo form_error("on_officicer_km");?></span>
         </div>
              <label class="col-sm-2 control-label">Note</label>
            <div class="col-sm-3">
              <textarea  name="notes" class="form-control" rows="1"><?php if(isset($info)) echo $info->notes; else echo set_value('notes'); ?> </textarea>
              <span class="error-msg"><?php echo form_error("notes");?></span>
            </div>
          </div><!-- ///////////////////// -->
         </div>
        <!-- /.box-body -->
        <div class="box-footer">
           <div class="col-sm-4">
            <a href="<?php echo base_url(); ?>me/dieselissue/lists" class="btn btn-info"><i class="fa fa-arrow-circle-o-left" aria-hidden="true"></i> Back</a></div>
           <div class="col-sm-4">
          <button type="submit" class="btn btn-info pull-right">SAVE 保存</button>
          </div>
        </div>
        <!-- /.box-footer -->
      </form>
    </div>
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
              <input type="text" class="form-control" name="location_name" placeholder="Location Name" value="">
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
