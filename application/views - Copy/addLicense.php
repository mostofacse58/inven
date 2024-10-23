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
        <form class="form-horizontal" action="<?php echo base_url();?>license/save<?php if(isset($info)) echo "/$info->document_id"; ?>" method="POST" enctype="multipart/form-data">
          <div class="box-body">
            <div class="form-group">
         <label class="col-sm-2 control-label">Title Name</label>
            <div class="col-sm-3">
              <textarea  name="title_name" class="form-control" rows="2"><?php if(isset($info->title_name)) echo $info->title_name; else echo set_value('title_name'); ?> </textarea>
               <span class="error-msg"><?php echo form_error("title_name");?></span>
            </div>
          <label class="col-sm-2 control-label">Description</label>
            <div class="col-sm-3">
              <textarea  name="description" class="form-control" rows="3"><?php if(isset($info->description)) echo $info->description; else echo set_value('description'); ?> </textarea>
               <span class="error-msg"><?php echo form_error("description");?></span>
            </div>
        </div><!-- ///////////////////// -->
        <div class="form-group">
          <label class="col-sm-2 control-label">Purchase Date <span style="color:red;">  *</span></label>
           <div class="col-sm-2">
               <div class="input-group date">
             <div class="input-group-addon">
               <i class="fa fa-calendar"></i>
             </div>
             <input type="text" name="purchase_date" readonly id="date" class="form-control pull-right" value="<?php if(isset($info)) echo findDate($info->purchase_date); else echo date('d/m/Y'); ?>">
           </div>
           <span class="error-msg"><?php echo form_error("purchase_date");?></span>
          </div>
           <label class="col-sm-3 control-label">Expiry Date <span style="color:red;">  *</span></label>
           <div class="col-sm-2">
               <div class="input-group date">
             <div class="input-group-addon">
               <i class="fa fa-calendar"></i>
             </div>
             <input type="text" name="expire_date" readonly id="date" class="form-control pull-right" value="<?php if(isset($info)) echo findDate($info->expire_date); else echo date('d/m/Y'); ?>">
           </div>
           <span class="error-msg"><?php echo form_error("expire_date");?></span>
          </div>

        </div><!-- ///////////////////// -->
         <div class="form-group">
          <label class="col-sm-2 control-label">Date <span style="color:red;">  *</span></label>
           <div class="col-sm-2">
               <div class="input-group date">
             <div class="input-group-addon">
               <i class="fa fa-calendar"></i>
             </div>
             <input type="text" name="date" readonly id="date" class="form-control pull-right" value="<?php if(isset($info)) echo findDate($info->date); else echo date('d/m/Y'); ?>">
           </div>
           <span class="error-msg"><?php echo form_error("date");?></span>
          </div>
            <label class="col-sm-3 control-label">Upload File <span style="color:red;">  </span></label>
             <div class="col-sm-5">
                 <div class="input-group">
                  <input type="file" class="form-control"  name="file_name" class="file">
                 <p class="error-msg"><?php  if(isset($exception_err)) echo $exception_err; ?></p>
                  </div>
                
             <?php if (isset($info->file_name) && !empty($info->file_name)) { ?>
                <div style="margin-top:20px;">
                  <a href="<?php echo base_url();?>license/fliedownload/<?php echo $info->file_name;?>" style="width:auto;text-decoration: none;">                  <button type="button"  class="btn btn-sm btn-primary">Download</button></a>
                  </div>
              <?php } ?>
              <span>Allows pdf,jpg,png,excel.</span>
           </div>
          </div><!-- ///////////////////// -->
         </div>
              <!-- /.box-body -->
        <div class="box-footer">
           <div class="col-sm-4"><a href="<?php echo base_url(); ?>license/lists" class="btn btn-info">
            <i class="fa fa-arrow-circle-o-left"></i> Back</a></div>
           <div class="col-sm-4">
          <button type="submit" class="btn btn-info pull-right"><i class="fa fa-save" ></i> SAVE</button>
          </div>
        </div>
        <!-- /.box-footer -->
      </form>
    </div>
  </div>
   
   </div>
 </div>

