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
        <!-- form start -->
      <form class="form-horizontal" action="<?php echo base_url();?>audit/package/save<?php if(isset($info)) echo "/$info->package_id"; ?>" method="POST" enctype="multipart/form-data">
        <div class="box-body">
           <div class="form-group">
            <label class="col-sm-2 control-label">Head<span style="color:red;">  *</span></label>
            <div class="col-sm-4">
              <select class="form-control select2" required name="head_id" id="head_id">
                <option value="">Select Head</option>
                <?php foreach ($hlist as $value) {  ?>
                  <option value="<?php echo $value->head_id; ?>"
                    <?php  if(isset($info)) echo $value->head_id==$info->head_id? 'selected="selected"':0; else echo set_select('head_id',$value->head_id);?>>
                    <?php echo $value->head_name; ?></option>
                  <?php } ?>
              </select>
             <span class="error-msg"><?php echo form_error("head_id");?></span>
            </div>
            <label class="col-sm-2 control-label">Sub Head<span style="color:red;">  </span></label>
            <div class="col-sm-4">
              <input type="text" name="sub_head_name" class="form-control" value="<?php if(isset($info)) echo $info->sub_head_name; else echo set_value('sub_head_name'); ?>"> 
              <span class="error-msg"><?php echo form_error("sub_head_name"); ?></span>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">
              Weight <span style="color:red;">  *</span></label>
            <div class="col-sm-2">
              <input type="text" name="weight"  class="form-control" value="<?php if(isset($info)) echo $info->weight; else echo set_value('weight'); ?>" style="width: 90%;float: left;"> 
              <span class="error-msg"><?php echo form_error("weight"); ?></span>
              <label class="control-label"  style="width: 10%;float: left;">%</label>
            </div>
            <label class="col-sm-2 control-label">For Year<span style="color:red;">  *</span></label>
          <div class="col-sm-2">
            <input type="text" name="year" <?php if(isset($info)) echo ""; ?>  class="form-control integerchk" value="<?php if(isset($info)) echo $info->year; else echo set_value('year');  ?>"> 
            <span class="error-msg"><?php echo form_error("year"); ?></span>
          </div>
          <label class="col-sm-2 control-label">Department<span style="color:red;"> </span></label>
            <div class="col-sm-2">
              <select class="form-control select2" required name="department_id" id="department_id">
                <option value="">Select Department</option>
                <?php foreach ($dlist as $value) {  ?>
                  <option value="<?php echo $value->department_id; ?>"
                    <?php  if(isset($info)) echo $value->department_id==$info->department_id? 'selected="selected"':0; else echo set_select('department_id',$value->department_id);?>>
                    <?php echo $value->department_name; ?></option>
                  <?php } ?>
              </select>
             <span class="error-msg"><?php echo form_error("department_id");?></span>
            </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">Category<span style="color:red;">  *</span></label>
             <div class="col-sm-2">
              <select class="form-control select2" name="acategory" id="acategory">
                <option value="Departmental"
                    <?php  if(isset($info)) echo 'Departmental'==$info->acategory? 'selected="selected"':0; else echo set_select('acategory','Departmental');?>>
                      Departmental</option>
                <option value="Inventory"
                    <?php  if(isset($info)) echo 'Inventory'==$info->acategory? 'selected="selected"':0; else echo set_select('acategory','Inventory');?>>
                      Inventory</option>
                <option value="Asset"
                    <?php  if(isset($info)) echo 'Asset'==$info->acategory? 'selected="selected"':0; else echo set_select('acategory','Asset');?>>
                      Asset</option>
              </select>
             <span class="error-msg"><?php echo form_error("quater");?></span>
           </div>
          <label class="col-sm-2 control-label">Criteria 5</label>
            <div class="col-sm-4">
              <textarea  name="criteria_1" class="form-control" rows="2"><?php if(isset($info)) echo $info->criteria_1; else echo set_value('criteria_1'); ?> </textarea>
               <span class="error-msg"><?php echo form_error("criteria_1");?></span>
            </div>
            
        </div><!-- ///////////////////// -->
        <div class="form-group">
          <label class="col-sm-2 control-label">Criteria 3</label>
            <div class="col-sm-4">
              <textarea  name="criteria_2" class="form-control" rows="2"><?php if(isset($info)) echo $info->criteria_2; else echo set_value('criteria_2'); ?> </textarea>
               <span class="error-msg"><?php echo form_error("criteria_2");?></span>
            </div>
          <label class="col-sm-2 control-label">Criteria 1</label>
            <div class="col-sm-4">
              <textarea  name="criteria_3" class="form-control" rows="2"><?php if(isset($info)) echo $info->criteria_3; else echo set_value('criteria_3'); ?> </textarea>
               <span class="error-msg"><?php echo form_error("criteria_3");?></span>
            </div>
       
        </div><!-- ///////////////////// -->
      </div>
        <!-- /.box-body -->
        <div class="box-footer">
           <div class="col-sm-4"><a href="<?php echo base_url(); ?>audit/package/lists" class="btn btn-info"><i class="fa fa-arrow-circle-o-left" aria-hidden="true"></i> Back</a></div>
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
 
