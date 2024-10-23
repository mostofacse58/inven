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
  ///////////////////////////////////

  });
 function formsubmit(){
    var error_status=false;
    var product_detail_id=$("#product_detail_id").val();
    var issue_type=$("#issue_type").val();
    var return_date=$("#return_date").val();
    var from_department_id=$("#from_department_id").val();
    if(from_department_id == ''){
      error_status=true;
      $("#alertMessageHTML").html("Please select department!!");
      $("#alertMessagemodal").modal("show");
    }
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
    var product_id=$("#product_id").val();
    if(product_id == ''){
      error_status=true;
      $("#alertMessageHTML").html("Please select Location!!");
      $("#alertMessagemodal").modal("show");
    } else {
      $('select[name=product_id]').css('border', '1px solid #ccc');      
    }
   
  if(return_date == '') {
    error_status=true;
    $("#return_date").css('border', '1px solid #f00');
  } else {
    $("#return_date").css('border', '1px solid #ccc');      
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
      <form class="form-horizontal" action="<?php echo base_url();?>common/ireturn/save<?php if(isset($info)) echo "/$info->ireturn_id"; ?>" method="POST" enctype="multipart/form-data"  onsubmit="return formsubmit();">
        <div class="box-body">
      <!-- ///////////////////// -->
      <div class="form-group">           
          <label class="col-sm-2 control-label">Item <span style="color:red;">  *</span></label>
          <div class="col-sm-6">
            <select class="form-control select2" name="product_id" id="product_id" style="width: 100%" required>
              <option value="">Select Item</option>
              <?php foreach ($ilist as $value) {  ?>
                <option value="<?php echo $value->product_id; ?>"
                  <?php  if(isset($info)) echo $value->product_id==$info->product_id? 'selected="selected"':0; else echo $value->product_id==set_value('product_id')? 'selected="selected"':0; ?>>
                  <?php echo "$value->product_name($value->product_code)"; ?></option>
                <?php } ?>
            </select>
           <span class="error-msg"><?php echo form_error("product_id");?></span>
          </div>
           <label class="col-sm-2 control-label">Return Date <span style="color:red;">  *</span></label>
           <div class="col-sm-2">
              <div class="input-group date">
               <div class="input-group-addon">
                 <i class="fa fa-calendar"></i>
               </div>
               <input type="text" name="return_date" id="return_date" readonly class="form-control pull-right" value="<?php if(isset($info)) echo findDate($info->return_date); else echo date('d/m/Y'); ?>" required>
             </div>
           <span class="error-msg"><?php echo form_error("return_date");?></span>
         </div>
        </div>
      <div class="form-group">
         <label class="col-sm-2 control-label">Return Qty <span style="color:red;">  *</span></label>
            <div class="col-sm-2 ">
             <input type="text" name="return_qty" id="return_qty" class="form-control" value="<?php if(isset($info)) echo $info->return_qty; else echo set_value('return_qty'); ?>" required>
             <span class="error-msg"><?php echo form_error("return_qty");?></span>
             <span id="errmsg"></span>
           </div>
           <label class="col-sm-2 control-label">Unit Price<span style="color:red;">  *</span></label>
            <div class="col-sm-2 ">
             <input type="text" name="unit_price" id="unit_price" class="form-control" value="<?php if(isset($info)) echo $info->unit_price; else echo set_value('unit_price'); ?>" required>
             <span class="error-msg"><?php echo form_error("unit_price");?></span>
             <span id="errmsg"></span>
           </div>
           <label class="col-sm-2 control-label">Currency<span style="color:red;">  *</span></label>
            <div class="col-sm-2 ">
             <input type="text" name="currency" readonly id="currency" class="form-control" value="<?php if(isset($info)) echo $info->currency; else echo set_value('currency'); ?>" required>
             <span class="error-msg"><?php echo form_error("currency");?></span>
             <span id="errmsg"></span>
           </div>
           </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">
              From Department <span style="color:red;">  </span></label>
              <div class="col-sm-2">
              <select class="form-control select2" name="from_department_id" id="from_department_id" style="width: 100%"> 
              <option value="" selected="selected">Select Department</option>
              <?php foreach ($dlist as $rows) { ?>
                <option value="<?php echo $rows->department_id; ?>" 
                <?php if (isset($info))
                  echo $rows->department_id == $info->from_department_id ? 'selected="selected"' : 0;
                else
                  echo $rows->department_id == set_value('from_department_id') ? 'selected="selected"' : 0;
                ?>><?php echo $rows->department_name; ?></option>
                    <?php } ?>
                </select>
            <span class="error-msg"><?php echo form_error("from_department_id"); ?></span>
          </div>
        
          <label class="col-sm-2 control-label">Employee ID <span style="color:red;">  </span></label>
          <div class="col-sm-2">
            <input type="hidden" name="product_code" id="product_code" value="<?php if(isset($info)) echo $info->product_code; else echo set_value('product_code'); ?>">
            <input type="hidden" name="product_name" id="product_name" value="<?php if(isset($info)) echo $info->product_name; else echo set_value('product_name'); ?>">

           <input type="text" name="employee_id" maxlength="5" id="employee_id" class="form-control pull-right" value="<?php if(isset($info)) echo $info->employee_id; else echo set_value('employee_id'); ?>">
           <span class="error-msg"><?php echo form_error("employee_id");?></span>
           <span id="errmsg"></span>
         </div>
          <label class="col-sm-2 control-label">Asset Name (Serial No) <span style="color:red;">  </span></label>
          <div class="col-sm-2">
           <input type="text" name="ventura_code" id="ventura_code" class="form-control" value="<?php if(isset($info)) echo $info->ventura_code; else echo set_value('ventura_code'); ?>">
          <span class="error-msg"><?php echo form_error("ventura_code"); ?></span>
        </div>
      </div>
      <div class="form-group">
              <label class="col-sm-2 control-label">Note</label>
            <div class="col-sm-7">
              <textarea  name="return_note" class="form-control" rows="1"><?php if(isset($info)) echo $info->return_note; else echo set_value('return_note'); ?> </textarea>
               <span class="error-msg"><?php echo form_error("return_note");?></span>
            </div>
          </div><!-- ///////////////////// -->
         </div>
        <!-- /.box-body -->
        <div class="box-footer">
           <div class="col-sm-4">
            <a href="<?php echo base_url(); ?>common/ireturn/lists" class="btn btn-info"><i class="fa fa-arrow-circle-o-left" aria-hidden="true"></i> Back</a></div>
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
 <script>
 $(document).ready(function(){
  //////////////////date picker//////////////////////
    $('#product_id').on('change',function(){
    var product_id = $('#product_id').val();  
       $.ajax({
            url: '<?php echo base_url("common/ireturn/getproductinfo") ?>',
            method:"POST",
            data:{
                product_id : product_id
            },
            success:function(response) {
                var data = JSON.parse(response);
                $("#unit_price").val(data.unit_price);
                $("#product_code").val(data.product_code);
                $("#product_name").val(data.product_name);
                $("#currency").val(data.currency);
            },
            error:function(){
                alert("error");
            }
        });
    });
  });
</script>
