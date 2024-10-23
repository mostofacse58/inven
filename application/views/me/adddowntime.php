  <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>asset/datepickerbootstrap/css/datepicker.css">
<script type="text/javascript" src="<?php echo base_url();?>asset/datepickerbootstrap/js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>asset/bootstrapdatetimepicker/js/moment.min.js"></script>

 <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>asset/bootstrapdatetimepicker/css/bootstrap-datetimepicker.min.css">
 <script type="text/javascript" src="<?php echo base_url();?>asset/bootstrapdatetimepicker/js/bootstrap-datetimepicker.min.js"></script>
<script>
  $(document).ready(function(){
    $(".select2").select2();
  });
    $(document).ready(function(){
      //////////////////date picker//////////////////////
      $('.date').datepicker({
        "format":"dd/mm/yyyy",
        "todayHighlight": true,
        "autoclose":true
      });
      $('.timepicker').datetimepicker({
                format: 'HH:mm:ss'
      });

     <?php if(isset($info)){ ?>
      var product_status_ids = "<?php echo $info->product_status_id; ?>";
      <?php  }else{ ?>
        var product_status_ids = "<?php echo set_value('product_status_id') ?>";
      <?php }?>
    ///////////////////
      ////////////////////////
       var line_id=$('#line_id').val();
            if(line_id !=''){
            $.ajax({
              type:"post",
              url:"<?php echo base_url()?>"+'me/downtime/getMachineLine/'+product_status_ids,
              data:{line_id:line_id},
              success:function(data){
                $("#product_status_id").empty();
                $("#product_status_id").append(data);
                if(product_status_ids != ''){
                  $('#product_status_id').val(product_status_ids).change();
                }
              }
            });
          }

      ///////////////////////
      $('#line_id').on('change',function(){
        var line_id=$('#line_id').val();
            if(line_id !=''){
            $.ajax({
              type:"post",
              url:"<?php echo base_url()?>"+'me/downtime/getMachineLine',
              data:{line_id:line_id},
              success:function(data){
                $("#product_status_id").empty();
                $("#product_status_id").append(data);
                if(product_status_ids != ''){
                  $('#product_status_id').val(product_status_ids).change();
                }
              }
            });
          }
          });
      //////////////////
    });
</script>
<div class="row">
  <div class="col-md-12">
    <div class="panel panel-success">
      <div class="box-header">
<div class="widget-block">
<div class="widget-head">
<h5><?php echo ucwords($heading); ?></h5>
<div class="widget-control pull-right">
  <a href="<?php echo base_url(); ?>me/downtime/lists" class="btn btn-info"><i class="fa fa-arrow-circle-o-left" aria-hidden="true"></i> Back</a>
</div>
</div>
</div>
</div>
   <div class="box box-info">
          <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" action="<?php echo base_url();?>me/downtime/save<?php if(isset($info)) echo "/$info->machine_downtime_id"; ?>" method="POST" enctype="multipart/form-data" onsubmit="return adddowntime();">
              <div class="box-body">
                <div class="form-group">
                  <label class="col-sm-3 control-label">Select Location <span style="color:red;">  *</span></label>
                  <div class="col-sm-3">
                   <select class="form-control select2" name="line_id" id="line_id">
                  <option value="" selected="selected">===Select Location===</option>
                  <?php $llist=$this->db->query("SELECT * FROM floorline_info WHERE line_no!='EGM'")->result();
                  foreach ($llist as $rows) { ?>
                    <option value="<?php echo $rows->line_id; ?>" 
                    <?php if (isset($info))
                        echo $rows->line_id == $info->line_id ? 'selected="selected"' : 0;
                    else echo $rows->line_id == set_value('line_id') ? 'selected="selected"' : 0;
                    ?>><?php echo $rows->line_no; ?></option>
                        <?php } ?>
                    </select>
                  <span class="error-msg"><?php echo form_error("line_id"); ?></span>
                </div>
               </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label">Machine Name(TPM CODE) 机器名称（TPM代码） <span style="color:red;">  *</span></label>
                  <div class="col-sm-7">
                   <select class="form-control select2" name="product_status_id" id="product_status_id">
                  <option value="" selected="selected">===Select Machine Name(TPM CODE)===</option>
                  
                    </select>
                  <span class="error-msg"><?php echo form_error("product_status_id"); ?></span>
                </div>
               </div>
                   <div class="form-group">
                    <label class="col-sm-3 control-label">Date <span style="color:red;">  *</span></label>
                     <div class="col-sm-3">
                           <div class="input-group date">
                         <div class="input-group-addon">
                           <i class="fa fa-calendar"></i>
                         </div>
                         <input type="text" name="down_date" id="down_date" readonly class="form-control pull-right" value="<?php if(isset($info)) echo findDate($info->down_date); else echo set_value('down_date'); ?>">
                       </div>
                     <span class="error-msg"><?php echo form_error("down_date");?></span>
                   </div>
                   <label class="col-sm-2 control-label">Problem Start Time <span style="color:red;">  *</span></label>
                   <div class="col-sm-3">
                    <div class="input-group">
                       <input type="text" name="problem_start_time" class="form-control timepicker" id="problem_start_time" value="<?php if(isset($info)) echo $info->problem_start_time; else echo set_value('problem_start_time'); ?>">
                            <div class="input-group-addon">
                              <i class="fa fa-clock-o"></i>
                            </div>
                    </div>
                   <span class="error-msg"><?php echo form_error("problem_start_time");?></span>
                 </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">ME Response Time <span style="color:red;">  *</span></label>
                     <div class="col-sm-3">
                    <div class="input-group">
                       <input type="text" name="me_response_time" class="form-control timepicker" id="me_response_time" value="<?php if(isset($info)) echo $info->me_response_time; else echo set_value('me_response_time'); ?>">
                          <div class="input-group-addon">
                            <i class="fa fa-clock-o"></i>
                          </div>
                    </div>
                   <span class="error-msg"><?php echo form_error("problem_start_time");?></span>
                 </div>
                   <label class="col-sm-2 control-label">Problem End Time <span style="color:red;">  *</span></label>
                   <div class="col-sm-3">
                    <div class="input-group">
                       <input type="text" name="problem_end_time" class="form-control timepicker" id="problem_end_time" value="<?php if(isset($info)) echo $info->problem_end_time; else echo set_value('problem_end_time'); ?>">
                          <div class="input-group-addon">
                            <i class="fa fa-clock-o"></i>
                          </div>
                    </div>
                   <span class="error-msg"><?php echo form_error("problem_end_time");?></span>
                 </div>
                </div>
                <div class="form-group">
              <label class="col-sm-3 control-label">Problem Description <span style="color:red;">  *</span></label>
                <div class="col-sm-3">
                  <textarea  name="problem_description" id="problem_description" class="form-control" rows="2"><?php if(isset($info)) echo $info->problem_description; else echo set_value('problem_description'); ?> </textarea>
                   <span class="error-msg"><?php echo form_error("problem_description");?></span>
                </div>
                <label class="col-sm-2 control-label">Actions 行动 Taken <span style="color:red;">  *</span></label>
                <div class="col-sm-3">
                  <textarea  name="action_taken" id="action_taken" class="form-control" rows="2"><?php if(isset($info)) echo $info->action_taken; else echo set_value('action_taken'); ?> </textarea>
                   <span class="error-msg"><?php echo form_error("action_taken");?></span>
                </div>
             </div><!-- ///////////////////// -->
                 <div class="form-group">
                  <label class="col-sm-3 control-label">Supervisor Name <span style="color:red;">  *</span></label>
                  <div class="col-sm-3">
                    <select class="form-control select2" required name="supervisor_id" id="supervisor_id">
                      <option value="">Select Supervisor</option>
                      <?php $slist=$this->db->query("SELECT * FROM supervisor_info")->result();
                      foreach ($slist as $value) {  ?>
                        <option value="<?php echo $value->supervisor_id; ?>"
                          <?php  if(isset($info)) echo $value->supervisor_id==$info->supervisor_id? 'selected="selected"':0; else echo set_select('supervisor_id',$value->supervisor_id);?>>
                          <?php echo $value->supervisor_name; ?></option>
                        <?php } ?>
                    </select>
                   <span class="error-msg"><?php echo form_error("supervisor_id");?></span>
                  </div>
                  <label class="col-sm-2 control-label">ME Name <span style="color:red;">  *</span></label>
                   <div class="col-sm-3">
                    <select class="form-control select2" required name="me_id" id="me_id">
                      <option value="">Select ME</option>
                      <?php $melist=$this->db->query("SELECT * FROM me_info")->result();
                      foreach ($melist as $value) {  ?>
                        <option value="<?php echo $value->me_id; ?>"
                          <?php  if(isset($info)) echo $value->me_id==$info->me_id? 'selected="selected"':0; else echo set_select('me_id',$value->me_id);?>>
                          <?php echo $value->me_name; ?></option>
                        <?php } ?>
                    </select>
                   <span class="error-msg"><?php echo form_error("me_id");?></span>
                 </div>
                </div>
            <div class="form-group">
              <label class="col-sm-3 control-label">Down Time(In minutes) <span style="color:red;">  *</span></label>
                <div class="col-sm-3">
                 <input type="text" name="total_minuts" id="total_minuts" class="form-control integerchk" value="<?php if(isset($info)) echo $info->total_minuts; else echo set_value('total_minuts'); ?>"> 
                  <span class="error-msg"><?php echo form_error("total_minuts"); ?></span>
                </div>
             </div><!-- ///////////////////// -->
           </div>
          <!-- /.box-body -->
          <div class="box-footer">
             <div class="col-sm-4">
              <a href="<?php echo base_url(); ?>me/downtime/lists" class="btn btn-info"><i class="fa fa-arrow-circle-o-left" aria-hidden="true"></i> Back</a></div>
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
 
