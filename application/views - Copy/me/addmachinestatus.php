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
            <form class="form-horizontal" action="<?php echo base_url();?>me/machinestatus/save<?php if(isset($info)) echo "/$info->product_status_id"; ?>" method="POST" enctype="multipart/form-data">
              <div class="box-body">
                <div class="form-group">
                  <label class="col-sm-3 control-label">Product Name (TPM CODE (TPM代码)) <span style="color:red;">  *</span></label>
                  <div class="col-sm-7">
                   <select class="form-control select2" name="product_detail_id">
                  <option value="" selected="selected">===Select Product Name (TPM CODE (TPM代码))===</option>
                  <?php foreach ($mlist as $rows) { ?>
                    <option value="<?php echo $rows->product_detail_id; ?>" 
                    <?php if (isset($info))
                        echo $rows->product_detail_id == $info->product_detail_id ? 'selected="selected"' : 0;
                    else
                        echo $rows->product_detail_id == set_value('product_detail_id') ? 'selected="selected"' : 0;
                    ?>><?php echo $rows->product_name; ?></option>
                        <?php } ?>
                    </select>
                  <span class="error-msg"><?php echo form_error("product_detail_id"); ?></span>
                </div>

                </div>
                 <div class="form-group">
                  <label class="col-sm-2 control-label">Location <span style="color:red;">  *</span></label>
                  <div class="col-sm-2">
                    <select class="form-control select2" required name="line_id" id="line_id">
                      <option value="">Select Location</option>
                      <?php foreach ($flist as $value) {  ?>
                        <option value="<?php echo $value->line_id; ?>"
                          <?php  if(isset($info)) echo $value->line_id==$info->line_id? 'selected="selected"':0; else echo set_select('line_id',$value->line_id);?>>
                          <?php echo $value->line_no; ?></option>
                        <?php } ?>
                    </select>
                   <span class="error-msg"><?php echo form_error("line_id");?></span>
                  </div>
                  <label class="col-sm-2 control-label">Status 状态 <span style="color:red;">  *</span></label>
                  <div class="col-sm-2">
                    <select class="form-control select2" required name="machine_status" id="machine_status">
                      <option value="1"
                        <?php  if(isset($info)) echo 1==$info->machine_status? 'selected="selected"':0; else echo set_select('machine_status',1);?>>
                          USED</option>
                          <option value="2"
                        <?php  if(isset($info)) echo 2==$info->machine_status? 'selected="selected"':0; else echo set_select('machine_status',2);?>>
                          IDLE</option>
                          <option value="3"
                        <?php  if(isset($info)) echo 3==$info->machine_status? 'selected="selected"':0; else echo set_select('machine_status',3);?>>
                          UNDER SERVICE</option>
                    </select>
                   <span class="error-msg"><?php echo form_error("machine_status");?></span>
                  </div>
                  <label class="col-sm-2 control-label">Assign Date <span style="color:red;">  *</span></label>
                   <div class="col-sm-2">
                         <div class="input-group date">
                       <div class="input-group-addon">
                         <i class="fa fa-calendar"></i>
                       </div>
                       <input type="text" name="assign_date" readonly class="form-control pull-right" value="<?php if(isset($info)) echo findDate($info->assign_date); else echo set_value('assign_date'); ?>">
                     </div>
                   <span class="error-msg"><?php echo form_error("assign_date");?></span>
                 </div>
                 
                </div>
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
                 <div class="col-sm-4">
                  <a href="<?php echo base_url(); ?>me/machinestatus/lists" class="btn btn-info"><i class="fa fa-arrow-circle-o-left" aria-hidden="true"></i> Back</a></div>
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
 
