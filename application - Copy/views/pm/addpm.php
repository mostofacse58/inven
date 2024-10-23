<script src="<?php echo base_url('asset/js/plugins/datepicker/bootstrap-datepicker.js'); ?>"></script>
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
</div>

        <div class="box box-info">
      <!-- /.box-header -->
    <form class="form-horizontal" action="<?php echo base_url(); ?>pm/maintenance/updatepm<?php if (isset($info)) echo "/$info->pm_id"; ?>" method="POST" enctype="multipart/form-data" onsubmit="return formsubmit();">
         <div class="box-body">
         <div class="form-group">
         <label class="col-sm-2 control-label">Work Date<span style="color:red;">  *</span> </label>
         <div class="col-sm-2">
               <div class="input-group date">
             <div class="input-group-addon">
               <i class="fa fa-calendar"></i>
             </div>
             <input type="text" name="work_date" readonly id="work_date" class="form-control pull-right" value="<?php  echo date('d/m/Y'); ?>">
           </div>
           <span class="error-msg"><?php echo form_error("work_date");?></span>
          </div>
          <label class="col-sm-2 control-label ">Asset Code </label>
           <div class="col-sm-2 ">
             <input type="text" name="tpm_code" id="tpm_code" class="form-control" readonly value="<?php if(isset($info)) echo $info->tpm_code; else echo set_value('tpm_code'); ?>">
             <span class="error-msg"><?php echo form_error("tpm_code");?></span>
           </div>
           <label class="col-sm-2 control-label ">Model No </label>
           <div class="col-sm-2 ">
             <input type="text" name="model_no" id="model_no" class="form-control" readonly value="<?php if(isset($info)) echo $info->model_no; else echo set_value('model_no'); ?>">
             <span class="error-msg"><?php echo form_error("model_no");?></span>
           </div>
      </div><!-- ///////////////////// -->
      <div class="form-group">
           <label class="col-sm-2 control-label ">Product Name </label>
           <div class="col-sm-6 ">
             <input type="text" name="product_name" id="product_name" class="form-control" readonly value="<?php if(isset($info)) echo $info->product_name; else echo set_value('product_name'); ?>">
             <span class="error-msg"><?php echo form_error("product_name");?></span>
           </div>
      </div><!-- ///////////////////// -->
      <div class="form-group">
           <label class="col-sm-2 control-label ">Spare Ref. No </label>
           <div class="col-sm-2 ">
             <input type="text" name="sref_no" id="sref_no" class="form-control" value="<?php if(isset($info)) echo $info->sref_no; else echo set_value('sref_no'); ?>">
             <span class="error-msg"><?php echo form_error("sref_no");?></span>
           </div>
           <label class="col-sm-2 control-label ">Work By </label>
           <div class="col-sm-2 ">
             <input type="text" name="work_by" id="work_by" class="form-control" value="<?php if(isset($info)) echo $info->work_by; else echo set_value('work_by'); ?>">
             <span class="error-msg"><?php echo form_error("work_by");?></span>
           </div>
           <label class="col-sm-2 control-label">Next PM Date<span style="color:red;">  *</span> </label>
             <div class="col-sm-2">
                   <div class="input-group date">
                 <div class="input-group-addon">
                   <i class="fa fa-calendar"></i>
                 </div>
                 <input type="text" name="next_pm_date" readonly id="next_pm_date" class="form-control pull-right">
               </div>
               <span class="error-msg"><?php echo form_error("next_pm_date");?></span>
              </div>
            </div><!-- ///////////////////// -->
        <div class="form-group">
            <label class="col-sm-2 control-label">Remarks<span style="color:red;">  </span></label>
           <div class="col-sm-6">
           <input type="text" name="remarks" id="remarks" class="form-control" placeholder="Note" value="<?php if(isset($info->remarks)) echo $info->remarks; else echo set_value('remarks'); ?>">
           <span class="error-msg"><?php echo form_error("remarks");?></span>
         </div>         
        
        </div><!-- ///////////////////// -->
         <div class="form-group">
          <label class="col-sm-2 control-label">Before Picture</label>
          <div class="col-sm-3">
            <input type="file" class="form-control"  name="before_image" class="form-control">
          </div>
          <label class="col-sm-2 control-label">After Picture</label>
          <div class="col-sm-3">
            <input type="file" class="form-control"  name="after_image" class="form-control">
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">Work Picture 1</label>
          <div class="col-sm-3">
            <input type="file" class="form-control"  name="image1" class="form-control">
          </div>
          <label class="col-sm-2 control-label">Work Picture 2</label>
          <div class="col-sm-3">
            <input type="file" class="form-control"  name="image2" class="form-control">
          </div>
        </div>
   
<div class="table-responsive">
<table class="table table-bordered" id="form-table">
<thead>
<tr>
  <th style="width:4%;text-align:center">SN</th>
  <th style="width:50%;text-align:center">Name</th>
  <th style="width:10%;text-align:center">Status <input type="checkbox" id="checkbox_empAll"></th>
  <th style="width:12%;text-align:center;">Note</th>
</thead>
<tbody>
 <?php
 $id=0;
  if(isset($details)):
    foreach ($details as  $value){
      $str='<tr id="row_' . $id . '"><td style="text-align:center"><input type="hidden" value="'.$value->id.'" name="id[]"  id="product_id_' . $id . '"/><b>' . ($id +1).'</b></td>';
      $str.='<td><input type="hidden" name="check_name[]"  value="'.$value->check_name.'" id="check_name_'  .$id. '"> '.$value->check_name.'</td>';
      $str.='<td style="text-align:center"><input type="checkbox" name="ok_or_not[]" required value="Done" class="iCheck-helper checkbox_emp" id="ok_or_not" style="width: 25px">  </td>';
      $str.= '<td><input  name="notes[]" class="form-control"  placeholder="Note"  style="margin-bottom:0px;width:98%;padding: 2px 9px;"  id="notes_'.$id.'"></td>';
      $str.= '</tr>';
      echo $str;
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
  <div class="col-sm-4"><a href="<?php echo base_url(); ?>pm/maintenance/lists" class="btn btn-info">
    <i class="fa fa-arrow-circle-o-left" aria-hidden="true"></i> 
    Back</a></div>
  <div class="col-sm-4">
      <button type="submit" class="btn btn-info pull-right"> <i class="fa fa-save"></i> SAVE 保存</button>
  </div>
  </div>
  <!-- /.box-footer -->
</form>
</div>
</div>
</div>

<script type="text/javascript">
var count = 1
$(function () {
  $(document).on('click','input[type=number]',function(){ this.select(); });
    $('.date').datepicker({
        "format": "dd/mm/yyyy",
        "todayHighlight": true,
        "autoclose": true
    });
    });
$(document).ready(function(){
$("#checkbox_empAll").removeAttr("checked");
      // Check or Uncheck All checkboxes
      $("#checkbox_empAll").change(function(){
          $('.user_radio').each(function(i, obj) {
              if($(this).is(':checked')){
                  $('#checkbox_empAll').prop('checked',false);
                  $('.checkbox_emp').prop('checked',false);
                  return false;
              }
          });
          var checked = $(this).is(':checked');
          if(checked){
              $(".checkbox_emp").each(function(){
                  $(this).prop("checked",true);
              });
          }else{
              $(".checkbox_emp").each(function(){
                  $(this).prop("checked",false);
              });
          }
      });
      });
  function formsubmit(){
      var error_status=false;
      var serviceNum=$("#form-table tbody tr").length;
      var chk;
      $("input[name='check_name[]']:checked").each(function ()
        {
        });
      var work_date=$("#work_date").val();
      var next_pm_date=$("#next_pm_date").val();
      var sref_no=$("#sref_no").val();
      var model_no=$("#model_no").val();
      if(model_no == ''){
          error_status=true;
          $('input[name=model_no]').css('border', '1px solid #f00');
        } else {
          $('input[name=model_no]').css('border', '1px solid #ccc');      
        }
      if(work_date == '') {
        error_status=true;
        $("#work_date").css('border', '1px solid #f00');
      } else {
        $("#work_date").css('border', '1px solid #ccc');      
      }
       if(next_pm_date == '') {
        error_status=true;
        $("#next_pm_date").css('border', '1px solid #f00');
      } else {
        $("#next_pm_date").css('border', '1px solid #ccc');      
      }
      if(error_status==true){
        return false;
      }else{
        return true;
      }
      $(".error-flash").delay(5000).hide(200);
}

</script>