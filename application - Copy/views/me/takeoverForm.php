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
                format: 'LT'
      });
 
    });
</script>

<div class="row">
  <div class="col-md-12">
    <div class="panel panel-success">
   <div class="box box-info">
          <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" action="<?php echo base_url();?>me/machinestatus/saveTakeover<?php if(isset($info)) echo "/$info->product_status_id"; ?>" method="POST" enctype="multipart/form-data">
        <div class="box-body">
         <div class="form-group">
          <label class="col-sm-2 control-label">Take Over Date <span style="color:red;"> * </span></label>
           <div class="col-sm-4">
                 <div class="input-group date">
               <div class="input-group-addon">
                 <i class="fa fa-calendar"></i>
               </div>
               <input type="text" name="takeover_date" readonly class="form-control pull-right" value="<?php echo set_value('takeover_date'); ?>">
             </div>
           <span class="error-msg"><?php echo form_error("takeover_date");?></span>
         </div>
          
        </div><!-- ///////////////////// -->
      </fieldset>
         <div class="form-group">
              <label class="col-sm-2 control-label">Note</label>
            <div class="col-sm-4">
              <textarea  name="note" class="form-control" rows="1"><?php if(isset($info->note)) echo $info->note; else echo set_value('note'); ?> </textarea>
               <span class="error-msg"><?php echo form_error("note");?></span>
            </div>
          </div><!-- ///////////////////// -->
         </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <input type="hidden" id="project_amount" value="0">
                 <input type="hidden" id="due_amount" value="0">
                 <div class="col-sm-4"><a href="<?php echo base_url(); ?>me/machinestatus/lists" class="btn btn-info"><i class="fa fa-arrow-circle-o-left" aria-hidden="true"></i> Back</a></div>
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
 