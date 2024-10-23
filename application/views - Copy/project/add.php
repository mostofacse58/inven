<script src="<?php echo base_url('asset/js/plugins/datepicker/bootstrap-datepicker.js'); ?>"></script>
<script type="text/javascript">
$(function () {
  $(document).on('click','input[type=number]',function(){ this.select(); });
        $('.date').datepicker({
            "format": "dd/mm/yyyy",
            "todayHighlight": true,
            "autoclose": true
        });
    });
</script>
<div class="row">
  <div class="col-xs-12">
   <div class="box box-primary">
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
        <form class="form-horizontal" action="<?php echo base_url();?>project/save<?php if(isset($info)) echo "/$info->project_id"; ?>" method="POST" enctype="multipart/form-data">
          <div class="box-body">
            <div class="form-group">
              <label class="col-sm-2 control-label">Project Name <span style="color:red;">  *</span></label>
              <div class="col-sm-4">
                <input type="text" name="project_name" class="form-control" readonly value="<?php if(isset($info->project_name)) echo $info->project_name; else echo set_value('project_name'); ?>">
               <span class="error-msg"><?php echo form_error("project_name");?></span>
              </div>
              <label class="col-sm-2 control-label">Develop By<span style="color:red;"> *</span> </label>
              <div class="col-sm-2">
                <select class="form-control" name="developed_by" id="developed_by">
                  <option value="Mostofa"
                    <?php if(isset($info)) echo 'Mostofa'==$info->developed_by? 'selected="selected"':0; else echo set_select('developed_by','Mostofa');?>>Mostofa</option>
                  <option value="Al Amin"
                    <?php if(isset($info)) echo 'Al Amin'==$info->developed_by? 'selected="selected"':0; else echo set_select('developed_by','Al Amin');?>>Al Amin</option>
                </select>
                 <span class="error-msg"><?php echo form_error("developed_by");?></span>
              </div>
              
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label">Project Co-ordinator <span style="color:red;">  *</span></label>
              <div class="col-sm-4">
                <input type="text" name="project_coordinator" readonly class="form-control" value="<?php if(isset($info->project_coordinator)) echo $info->project_coordinator; else echo set_value('project_coordinator'); ?>">
               <span class="error-msg"><?php echo form_error("project_coordinator");?></span>
              </div>
              <label class="col-sm-2 control-label">Project Co-ordinator <span style="color:red;">  </span></label>
              <div class="col-sm-4">
                <input type="text" name="project_coordinator2" readonly class="form-control" value="<?php if(isset($info->project_coordinator2)) echo $info->project_coordinator2; else echo set_value('project_coordinator2'); ?>">
               <span class="error-msg"><?php echo form_error("project_coordinator2");?></span>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label">Requirement <span style="color:red;">  *</span></label>
              <div class="col-sm-10">
                <textarea  name="project_requirement" class="form-control" readonly rows="5"><?php if(isset($info)) echo $info->project_requirement; else echo set_value('project_requirement'); ?> </textarea>
               <span class="error-msg"><?php echo form_error("project_requirement");?></span>
              </div>
            </div>
             <div class="form-group">
              <label class="col-sm-2 control-label">Heat <span style="color:red;">  *</span></label>
                <div class="col-sm-2">
                <div class="checkbox">
                  <label>
                    <input type="checkbox" name="manpower" value="YES"  <?php if(isset($info)){  if($info->manpower == 'YES'){  echo "checked"; }else{echo "0";}} ?>>
                     Save Manpower</label>
                </div>
              </div>
              <div class="col-sm-2">
                <div class="checkbox">
                  <label>
                    <input type="checkbox" name="money" value="YES"  <?php if(isset($info)){  if($info->money == 'YES'){  echo "checked"; }else{echo "0";}} ?>>
                     Save Money</label>
                </div>
              </div>
              <div class="col-sm-2">
                <div class="checkbox">
                  <label>
                    <input type="checkbox" name="times" value="YES"  <?php if(isset($info)){  if($info->times == 'YES'){  echo "checked"; }else{echo "0";}} ?>>
                     Save Time</label>
                </div>
              </div>
              <div class="col-sm-2">
                <div class="checkbox">
                  <label>
                    <input type="checkbox" name="quality" value="YES"  <?php if(isset($info)){  if($info->quality == 'YES'){  echo "checked"; }else{echo "0";}} ?>>
                    Improve Quality</label>
                </div>
              </div>
            </div>
            <div class="form-group">
               <label class="col-sm-2 control-label">Start Date <span style="color:red;">  *</span></label>
              <div class="col-sm-2">
                <input type="text" readonly  name="start_date" class="form-control date"  value="<?php if(isset($info->start_date)) echo findDate($info->start_date); else echo set_value('start_date'); ?>">
               <span class="error-msg"><?php echo form_error("start_date");?></span>
              </div>
              <label class="col-sm-2 control-label">End Date <span style="color:red;">  *</span></label>
              <div class="col-sm-2">
                <input type="text" readonly  name="end_date" class="form-control date"  value="<?php if(isset($info->end_date)) echo findDate($info->end_date); else echo set_value('end_date'); ?>">
               <span class="error-msg"><?php echo form_error("end_date");?></span>
              </div>
              </div>
            <div class="form-group">
            
              <label class="col-sm-2 control-label">Priority<span style="color:red;"> *</span> </label>
              <div class="col-sm-2">
                <select class="form-control" name="priority" id="priority">
                  <option value="3"
                    <?php if(isset($info)) echo '3'==$info->priority? 'selected="selected"':0; else echo set_select('priority','3');?>>Low</option>
                  <option value="2"
                    <?php if(isset($info)) echo '2'==$info->priority? 'selected="selected"':0; else echo set_select('priority','2');?>>Medium</option>
                  <option value="1" 
                    <?php if(isset($info)) echo '1'==$info->priority? 'selected="selected"':0; else echo set_select('priority','1');?>>High</option>
                </select>
                 <span class="error-msg"><?php echo form_error("priority");?></span>
              </div>
              <label class="col-sm-2 control-label">Status<span style="color:red;">  </span> </label>
              <div class="col-sm-2">
                 <select class="form-control" name="project_status" id="project_status">
                  <option value="5"
                  <?php if(isset($info)) echo '5'==$info->project_status? 'selected="selected"':0; else echo set_select('project_status','5');?>>Received</option>
                  <option value="6"
                  <?php if(isset($info)) echo '6'==$info->project_status? 'selected="selected"':0; else echo set_select('project_status','6');?>>Waiting</option>
                  <option value="7"
                  <?php if(isset($info)) echo '7'==$info->project_status? 'selected="selected"':0; else echo set_select('project_status','7');?>>Progress</option>
                <option value="8"
                  <?php if(isset($info)) echo '8'==$info->project_status? 'selected="selected"':0; else echo set_select('project_status','8');?>>Completed</option>
              </select>
               <span class="error-msg"><?php echo form_error("project_status");?></span>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label">Development Note </label>
              <div class="col-sm-4">
                <textarea  name="development_note" class="form-control" rows="2"><?php if(isset($info)) echo $info->development_note; else echo set_value('development_note'); ?> </textarea>
               <span class="error-msg"><?php echo form_error("development_note");?></span>
              </div>
              <label class="col-sm-2 control-label">Special Note </label>
              <div class="col-sm-4">
              <textarea  name="special_note" class="form-control" rows="2"><?php if(isset($info)) echo $info->special_note; else echo set_value('special_note'); ?> </textarea>
               <span class="error-msg"><?php echo form_error("special_note");?></span>
              </div>
            </div>
            </div>
            <div class="box-footer">
             <div class="col-sm-6">
              <a href="<?php echo base_url(); ?>project/lists" class="btn btn-info"><i class="fa fa-arrow-circle-o-left"></i> Back</a></div>
             <div class="col-sm-4">
            <button type="submit" class="btn btn-success pull-left"><i class="fa fa-send"></i> SAVE 保存</button>
            </div>
          <!-- /.box-body -->
        </form>
      </div>
        <!-- /.box-header -->
      
      </div>
    </div>
 </div>
