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
      ///////////////
  });
 function formsubmit(){
  var error_status=false;
  var product_detail_id=$("#product_detail_id").val();
  var servicing_date=$("#servicing_date").val();
    if(product_detail_id == ''){
      error_status=true;
      $("#alertMessageHTML").html("Please select Asset!!");
      $("#alertMessagemodal").modal("show");
    } 
    var issuer_to_name=$("#issuer_to_name").val();
    var out_quantity=$("#out_quantity").val();
    if(issuer_to_name == ''){
      error_status=true;
      $('input[name=issuer_to_name]').css('border', '1px solid #f00');
    } else {
      $('input[name=issuer_to_name]').css('border', '1px solid #ccc');      
    }
    if(out_quantity == ''){
      error_status=true;
      $('input[name=out_quantity]').css('border', '1px solid #f00');
    } else {
      $('input[name=out_quantity]').css('border', '1px solid #ccc');      
    }

    var location_name=$("#location_name").val();
    if(location_name == ''){
      error_status=true;
      $("#alertMessageHTML").html("Please select Location!!");
      $("#alertMessagemodal").modal("show");
    } else {
      $('select[name=location_name]').css('border', '1px solid #ccc');      
    }
  if(servicing_date == '') {
    error_status=true;
    $("#servicing_date").css('border', '1px solid #f00');
  } else {
    $("#servicing_date").css('border', '1px solid #ccc');      
  }
  if(error_status==true){
    return false;
  }else{
    return true;
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
      <!-- form start -->
      <form class="form-horizontal" action="<?php echo base_url();?>it/gatepass/save<?php if(isset($info)) echo "/$info->gatepass_id"; ?>" method="POST" enctype="multipart/form-data"  onsubmit="return formsubmit();">
        <div class="box-body">
          <div class="form-group">
         
         <label class="col-sm-2 control-label">Asset Name (Serial No) <span style="color:red;">  *</span></label>
          <div class="col-sm-5">
           <select class="form-control select2" name="product_detail_id" id="product_detail_id">
          <option value="" selected="selected">Select Asset Name (Serial No)</option>
          <?php foreach ($mlist as $rows) { ?>
            <option value="<?php echo $rows->product_detail_id; ?>" 
            <?php if (isset($info))
            echo $rows->product_detail_id==$info->product_detail_id ? 'selected="selected"' : 0;
            else
            echo $rows->product_detail_id==set_value('product_detail_id')? 'selected="selected"' : 0;
            ?>>
            <?php echo $rows->product_name; ?></option>
            <?php } ?>
            </select>
          <span class="error-msg"><?php echo form_error("product_detail_id"); ?></span>
        </div>
        <label class="col-sm-2 control-label ">Ref. No <span style="color:red;"> </span></label>
          <div class="col-sm-2">
           <input type="text" name="reference_no" id="reference_no" class="form-control" value="<?php if(isset($info)) echo $info->reference_no; else echo set_value('reference_no'); ?>">
           <span class="error-msg"><?php echo form_error("reference_no");?></span>
         </div>
      </div>
      <!-- ///////////////////// -->
      <div class="box-body">
          <div class="form-group">
         <label class="col-sm-2 control-label locationDiv">Type <span style="color:red;">  *</span></label>
          <div class="col-sm-2">
            <select class="form-control select2" name="servicing_type" id="servicing_type" style="width: 100%">
                <option value="INHOUSE"
                  <?php  if(isset($info)) echo 'INHOUSE'==$info->servicing_type? 'selected="selected"':0; else echo 'INHOUSE'==$this->session->userdata('servicing_type')? 'selected="selected"':0; ?>>INHOUSE</option>
                <option value="OUTSIDE"
                  <?php  if(isset($info)) echo 'OUTSIDE'==$info->servicing_type? 'selected="selected"':0; else echo 'OUTSIDE'==$this->session->userdata('servicing_type')? 'selected="selected"':0; ?>>OUTSIDE</option>
            </select>
           <span class="error-msg"><?php echo form_error("servicing_type");?></span>
          </div>
         <label class="col-sm-2 control-label">For Department <span style="color:red;">  *</span></label>
          <div class="col-sm-2">
           <select class="form-control select2" name="for_department_id" id="for_department_id">
          <option value="" selected="selected">Select Department</option>
          <?php foreach ($dlist as $rows) { ?>
            <option value="<?php echo $rows->department_id; ?>" 
            <?php if (isset($info))
            echo $rows->department_id==$info->for_department_id ? 'selected="selected"' : 0;
            else
            echo $rows->department_id==set_value('for_department_id')? 'selected="selected"' : 0;
            ?>>
            <?php echo $rows->department_name; ?></option>
            <?php } ?>
            </select>
          <span class="error-msg"><?php echo form_error("for_department_id"); ?></span>
        </div>
        <label class="col-sm-2 control-label ">Employee ID <span style="color:red;"> </span></label>
          <div class="col-sm-2">
           <input type="text" name="employee_id" id="employee_id" class="form-control" value="<?php if(isset($info)) echo $info->employee_id; else echo set_value('employee_id'); ?>">
           <span class="error-msg"><?php echo form_error("employee_id");?></span>
         </div>
      </div>
        <div class="form-group">           
          <label class="col-sm-2 control-label locationDiv">Location <span style="color:red;">  *</span></label>
          <div class="col-sm-2">
            <select class="form-control select2" name="location_name" id="location_name" style="width: 100%">
              <option value="">Select Location</option>
              <?php foreach ($llist as $value) {  ?>
                <option value="<?php echo $value->location_name; ?>"
                  <?php  if(isset($info)) echo $value->location_name==$info->location_name? 'selected="selected"':0; else echo $value->location_name==$this->session->userdata('location_name')? 'selected="selected"':0; ?>>
                  <?php echo $value->location_name; ?></option>
                <?php } ?>
            </select>
           <span class="error-msg"><?php echo form_error("location_name");?></span>
          </div>
          <label class="col-sm-2 control-label">Servicing Date <span style="color:red;">  *</span></label>
           <div class="col-sm-2">
              <div class="input-group date">
               <div class="input-group-addon">
                 <i class="fa fa-calendar"></i>
               </div>
               <input type="text" name="servicing_date" id="servicing_date" readonly class="form-control pull-right" value="<?php if(isset($info)) echo findDate($info->servicing_date); else echo date('d/m/Y'); ?>">
             </div>
           <span class="error-msg"><?php echo form_error("servicing_date");?></span>
         </div>
         <label class="col-sm-1 control-label">Service Qty <span style="color:red;">  *</span></label>
           <div class="col-sm-2">
               <input type="text" name="out_quantity" maxlength="5" id="out_quantity" class="form-control pull-right" value="<?php if(isset($info)) echo $info->out_quantity; else echo 1; ?>">
               <span class="error-msg"><?php echo form_error("out_quantity");?></span>
               <span id="errmsg"></span>
             </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">Issue to <span style="color:red;">  *</span></label>
           <div class="col-sm-2">
               <input type="text" name="issuer_to_name" id="issuer_to_name" class="form-control" value="<?php if(isset($info)) echo $info->issuer_to_name; else echo set_value('issuer_to_name'); ?>">
               <span class="error-msg"><?php echo form_error("issuer_to_name");?></span>
             </div>
             <label class="col-sm-1 control-label">Cost <span style="color:red;">  </span></label>
           <div class="col-sm-2">
               <input type="text" name="servicing_cost" id="servicing_cost" class="form-control" value="<?php if(isset($info)) echo $info->servicing_cost; else echo set_value('servicing_cost'); ?>" required>
               <span class="error-msg"><?php echo form_error("servicing_cost");?></span>
             </div>
          </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">Problem</label>
            <div class="col-sm-3">
              <textarea  name="problem_details" class="form-control" rows="3"><?php if(isset($info)) echo $info->problem_details; else echo set_value('problem_details'); ?> </textarea>
               <span class="error-msg"><?php echo form_error("problem_details");?></span>
            </div>
          <label class="col-sm-2 control-label">Servicing</label>
            <div class="col-sm-4">
              <textarea  name="service_details" class="form-control" rows="3"><?php if(isset($info)) echo $info->service_details; else echo set_value('service_details'); ?> </textarea>
               <span class="error-msg"><?php echo form_error("service_details");?></span>
            </div>
          </div><!-- ///////////////////// -->
         </div>
        <!-- /.box-body -->
        <div class="box-footer">
           <div class="col-sm-4">
            <a href="<?php echo base_url(); ?>it/gatepass/lists" class="btn btn-info"><i class="fa fa-arrow-circle-o-left" aria-hidden="true"></i> Back</a></div>
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

