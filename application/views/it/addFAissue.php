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

  });
 function formsubmit(){
  var error_status=false;
  var product_detail_id=$("#product_detail_id").val();
  var issue_type=$("#issue_type").val();
  var issue_date=$("#issue_date").val();
    if(product_detail_id == ''){
      error_status=true;
      $("#alertMessageHTML").html("Please select Asset!!");
      $("#alertMessagemodal").modal("show");
    } else {
    }
  if(issue_type==1){
    var take_department_id=$("#take_department_id").val();
    if(take_department_id == ''){
      error_status=true;
      $("#alertMessageHTML").html("Please select department!!");
      $("#alertMessagemodal").modal("show");
    }
   }else if(issue_type==2){
    var take_department_id=$("#take_department_id").val();
    if(take_department_id == ''){
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
  if(issue_date == '') {
    error_status=true;
    $("#issue_date").css('border', '1px solid #f00');
  } else {
    $("#issue_date").css('border', '1px solid #ccc');      
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
      <form class="form-horizontal" action="<?php echo base_url();?>it/assetissue/save<?php if(isset($info)) echo "/$info->asset_issue_id"; ?>" method="POST" enctype="multipart/form-data"  onsubmit="return formsubmit();">
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
         <label class="col-sm-2 control-label ">Requisition No <span style="color:red;"> </span></label>
          <div class="col-sm-2">
           <input type="text" name="requisition_no" id="requisition_no" class="form-control pull-right" value="<?php if(isset($info)) echo $info->requisition_no; else echo set_value('requisition_no'); ?>">
           <span class="error-msg"><?php echo form_error("requisition_no");?></span>
         </div>
         
      </div>
      <!-- ///////////////////// -->
      <div class="form-group">
        <label class="col-sm-2 control-label departmentDiv">
          Department <span style="color:red;">  *</span></label>
          <div class="col-sm-3 departmentDiv">
          <select class="form-control select2" name="take_department_id" id="take_department_id" style="width: 100%"> 
          <option value="" selected="selected">===Select Department===</option>
          <?php foreach ($dlist as $rows) { ?>
            <option value="<?php echo $rows->department_id; ?>" 
            <?php if (isset($info))
              echo $rows->department_id == $info->take_department_id ? 'selected="selected"' : 0;
            else
              echo $rows->department_id == set_value('take_department_id') ? 'selected="selected"' : 0;
            ?>><?php echo $rows->department_name; ?></option>
                <?php } ?>
            </select>
        <span class="error-msg"><?php echo form_error("take_department_id"); ?></span>
      </div>
        <label class="col-sm-2 control-label employeeDiv">Employee ID <span style="color:red;">  *</span></label>
           <div class="col-sm-2 employeeDiv">
               <input type="text" name="employee_id" maxlength="5" id="employee_id" class="form-control pull-right" value="<?php if(isset($info)) echo $info->employee_id; else echo set_value('employee_id'); ?>">
               <span class="error-msg"><?php echo form_error("employee_id");?></span>
               <span id="errmsg"></span>
             </div>
            </div>
          <div class="form-group">           
          <label class="col-sm-2 control-label locationDiv">Location <span style="color:red;">  *</span></label>
          <div class="col-sm-2 locationDiv">
            <select class="form-control select2" name="location_id" id="location_id" style="width: 100%">
              <option value="">Select Location</option>
              <?php foreach ($llist as $value) {  ?>
                <option value="<?php echo $value->location_id; ?>"
                  <?php  if(isset($info)) echo $value->location_id==$info->location_id? 'selected="selected"':0; else echo $value->location_id==$this->session->userdata('input_location')? 'selected="selected"':0; ?>>
                  <?php echo $value->location_name; ?></option>
                <?php } ?>
            </select>
           <span class="error-msg"><?php echo form_error("location_id");?></span>
          </div>
          <?php if($this->session->userdata('department_id')==1){ ?>
          <label class="col-sm-1 control-label">IP<span style="color:red;">  </span></label>
          <div class="col-sm-2">
            <input type="text" name="real_ip_address" id="real_ip_address" class="form-control" value="<?php if(isset($info)) echo $info->real_ip_address; else echo set_value('real_ip_address'); ?>">
           <span class="error-msg"><?php echo form_error("real_ip_address");?></span>
         </div>
         <label class="col-sm-1 control-label">UPS <span style="color:red;">  </span></label>
          <div class="col-sm-2">
            <select class="form-control" name="ups_status" id="ups_status">
                <option value="N/A"
                <?php if(isset($info)) echo 'N/A'==$info->ups_status? 'selected="selected"':0; else echo set_select('ups_status','N/A');?>>N/A</option>
                <option value="1200VA"
                <?php if(isset($info)) echo '1200VA'==$info->ups_status? 'selected="selected"':0; else echo set_select('ups_status','1200VA');?>>1200VA</option>
                <option value="600VA"
                <?php if(isset($info)) echo '600VA'==$info->ups_status? 'selected="selected"':0; else echo set_select('ups_status','600VA');?>>600VA</option>
            </select>
           <span class="error-msg"><?php echo form_error("ups_status");?></span>
         </div>
       <?php } ?>
          <!-- <div class="col-sm-1 locationDiv">
            <a href="javascript:;" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#partyModal"><i class="fa fa-plus"></i></a>
          </div> -->
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">Status 状态 <span style="color:red;">  *</span></label>
          <div class="col-sm-2">
            <select class="form-control select2"  name="issue_status" id="issue_status">
              <option value="1"
                <?php  if(isset($info)) echo 1==$info->issue_status? 'selected="selected"':0; else echo set_select('issue_status',1);?>>
                  USED</option>
                  <option value="2"
                <?php  if(isset($info)) echo 2==$info->issue_status? 'selected="selected"':0; else echo set_select('issue_status',2);?>>
                  IDLE/Stock</option>
                <option value="3"
                <?php  if(isset($info)) echo 3==$info->issue_status? 'selected="selected"':0; else echo set_select('issue_status',3);?>>
                  UNDER SERVICE</option>
            </select>
           <span class="error-msg"><?php echo form_error("issue_status");?></span>
          </div>
          <label class="col-sm-2 control-label">Issue Date <span style="color:red;">  *</span></label>
           <div class="col-sm-2">
              <div class="input-group date">
               <div class="input-group-addon">
                 <i class="fa fa-calendar"></i>
               </div>
               <input type="text" name="issue_date" id="issue_date" readonly class="form-control pull-right" value="<?php if(isset($info)) echo findDate($info->issue_date); else echo date('d/m/Y'); ?>">
             </div>
           <span class="error-msg"><?php echo form_error("issue_date");?></span>
         </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">Asset Name (Serial No) <span style="color:red;">  *</span></label>
          <div class="col-sm-7">
           <select class="form-control select2" name="product_detail_id" id="product_detail_id">
          <option value="" selected="selected">===Select Asset Name (Serial No)===</option>
          <?php foreach ($mlist as $rows) { ?>
            <option value="<?php echo $rows->product_detail_id; ?>" 
            <?php if (isset($info))
                echo $rows->product_detail_id == $info->product_detail_id ? 'selected="selected"' : 0;
                else
                echo $rows->product_detail_id == set_value('product_detail_id')? 'selected="selected"' : 0;
            ?>><?php echo "$rows->product_name $rows->ventura_code"; ?></option>
                <?php } ?>
            </select>
          <span class="error-msg"><?php echo form_error("product_detail_id"); ?></span>
        </div>
      </div>
      <div class="form-group">
              <label class="col-sm-2 control-label">Note</label>
            <div class="col-sm-7">
              <textarea  name="issue_purpose" class="form-control" rows="1"><?php if(isset($info)) echo $info->issue_purpose; else echo set_value('issue_purpose'); ?> </textarea>
               <span class="error-msg"><?php echo form_error("issue_purpose");?></span>
            </div>
          </div><!-- ///////////////////// -->
         </div>
        <!-- /.box-body -->
        <div class="box-footer">
           <div class="col-sm-4">
            <a href="<?php echo base_url(); ?>it/assetissue/lists" class="btn btn-info"><i class="fa fa-arrow-circle-o-left" aria-hidden="true"></i> Back</a></div>
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
