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
      <form class="form-horizontal" action="<?php echo base_url();?>hoshin/actions/save<?php if(isset($info)) echo "/$info->actions_id"; ?>" method="POST" enctype="multipart/form-data">
        <div class="box-body">
          <div class="form-group">
            <label class="col-sm-2 control-label">Team</label>
             <div class="col-sm-4">
              <select class="form-control select2" name="team" id="team" required>
                <option value="">Select 选择</option>
                <option value="VSS" <?php  if(isset($info)) echo 'VSS'==$info->team? 'selected="selected"':0; else echo set_select('team','VSS');?>>VSS</option>
                <option value="MSS" <?php  if(isset($info)) echo 'MSS'==$info->team? 'selected="selected"':0; else echo set_select('team','MSS');?>>MSS</option>
                <option value="CSS" <?php  if(isset($info)) echo 'CSS'==$info->team? 'selected="selected"':0; else echo set_select('team','CSS');?>>CSS</option>
                <option value="ESS" <?php  if(isset($info)) echo 'ESS'==$info->team? 'selected="selected"':0; else echo set_select('team','ESS');?>>ESS</option>
                <option value="BSS" <?php  if(isset($info)) echo 'BSS'==$info->team? 'selected="selected"':0; else echo set_select('team','BSS');?>>BSS</option>
              </select>
             <span class="error-msg"><?php echo form_error("team");?></span>
           </div>
            <label class="col-sm-2 control-label">Department</label>
            <div class="col-sm-4">
            <select class="form-control select2" name="department_id" id="department_id" required>
              <option value="">Select 选择</option>
              <?php 
              foreach ($dlist as $value) {  ?>
                <option value="<?php echo $value->department_id; ?>"
                  <?php  if(isset($info)) echo $value->department_id==$info->department_id? 'selected="selected"':0; else echo set_select('department_id',$value->department_id);?>>
                  <?php echo $value->department_name; ?></option>
                <?php } ?>
            </select>
             <span class="error-msg"><?php echo form_error("department_id");?></span>
           </div>
      </div>  
      <div class="form-group">
        <label class="col-sm-2 control-label">Departmental Goal<span style="color:red;">  *</span></label>
        <div class="col-sm-10">
          <input type="text" name="departmental_goal" required class="form-control" placeholder="Departmental Goal" value="<?php if(isset($info->departmental_goal)) echo $info->departmental_goal; else echo set_value('departmental_goal'); ?>">
         <span class="error-msg"><?php echo form_error("departmental_goal");?></span>
        </div>
     </div>
     <div class="form-group">
        <label class="col-sm-2 control-label">Individual Goal<span style="color:red;">  *</span></label>
        <div class="col-sm-10">
          <input type="text" name="actions_name" required class="form-control" placeholder="Individual Goal" value="<?php if(isset($info->actions_name)) echo $info->actions_name; else echo set_value('actions_name'); ?>">
         <span class="error-msg"><?php echo form_error("actions_name");?></span>
        </div>
     </div>
     <div class="form-group">
        <label class="col-sm-2 control-label">Goal Category</label>
         <div class="col-sm-2">
          <select class="form-control select2" name="category" id="category" required>
            <option value="">Select 选择</option>
            <option value="Medium" <?php  if(isset($info)) echo 'Medium'==$info->category? 'selected="selected"':0; else echo set_select('category','Medium');?>>Medium</option>
            <option value="Positive" <?php  if(isset($info)) echo 'Positive'==$info->category? 'selected="selected"':0; else echo set_select('category','Positive');?>>Positive</option>
            <option value="Negative" <?php  if(isset($info)) echo 'Negative'==$info->category? 'selected="selected"':0; else echo set_select('category','Negative');?>>Negative</option>
          </select>
         <span class="error-msg"><?php echo form_error("category");?></span>
       </div>
        <label class="col-sm-2 control-label">Dateline <span style="color:red;">  *</span></label>
          <div class="col-sm-2">
             <div class="input-group date">
           <div class="input-group-addon">
             <i class="fa fa-calendar"></i>
           </div>
           <input type="text" name="end_date" readonly id="end_date" class="form-control pull-right" value="<?php if(isset($info)) echo findDate($info->end_date); else echo date('d/m/Y'); ?>">
         </div>
         <span class="error-msg"><?php echo form_error("end_date");?></span>
        </div>
    </div><!-- ///////////////////// -->
      <div class="form-group">
        <label class="col-sm-2 control-label">Person</label>
        <div class="col-sm-2">
           <input type="text" name="person_name"  class="form-control" placeholder="Person " value="<?php if(isset($info->person_name)) echo $info->person_name; else echo set_value('person_name'); ?>">
          <span class="error-msg"><?php echo form_error("person_name"); ?></span>
        </div>
        <label class="col-sm-2 control-label">Target Type</label>
         <div class="col-sm-2">
          <select class="form-control select2" name="target_type" id="target_type" required>
            <option value="%" <?php  if(isset($info)) echo '%'==$info->target_type? 'selected="selected"':0; else echo set_select('target_type','%');?>>Percentage</option>
            <option value="NUMBER" <?php  if(isset($info)) echo 'NUMBER'==$info->target_type? 'selected="selected"':0; else echo set_select('target_type','NUMBER');?>>NUMBER</option>
          </select>
         <span class="error-msg"><?php echo form_error("target_type");?></span>
       </div>
       <label class="col-sm-2 control-label">Target</label>
       <div class="col-sm-2">
           <input type="text" name="target"  class="form-control" placeholder="Target " value="<?php if(isset($info->target)) echo $info->target; else echo set_value('target'); ?>">
          <span class="error-msg"><?php echo form_error("target"); ?></span>
        </div>
   </div>
  </div>
        <!-- /.box-body -->
        <div class="box-footer">
           <div class="col-sm-4"><a href="<?php echo base_url(); ?>hoshin/actions/lists" class="btn btn-info"><i class="fa fa-arrow-circle-o-left" aria-hidden="true"></i> Back</a></div>
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
 
