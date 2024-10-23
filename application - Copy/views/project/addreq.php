<script src="<?php echo base_url('asset/js/plugins/datepicker/bootstrap-datepicker.js'); ?>"></script>

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
            <form class="form-horizontal" action="<?php echo base_url();?>psubmit/save<?php if(isset($info)) echo "/$info->project_id"; ?>" method="POST" enctype="multipart/form-data">
              <div class="box-body">
                <div class="form-group">
                  <label class="col-sm-2 control-label">Name/Modification <span style="color:red;">  *</span></label>
                  <div class="col-sm-4">
                    <input type="text" name="project_name" class="form-control" placeholder="Project Name" value="<?php if(isset($info->project_name)) echo $info->project_name; else echo set_value('project_name'); ?>">
                   <span class="error-msg"><?php echo form_error("project_name");?></span>
                  </div>
                  <label class="col-sm-2 control-label ">Project Type <span style="color:red;">*  </span></label>
                  <div class="col-sm-4">
                  <select class="form-control select2" name="p_type" id="p_type" style="width: 100%"> 
                    <option value="NEW"
                        <?php if(isset($info)) echo 'NEW'==$info->p_type? 'selected="selected"':0; else echo set_select('p_type','NEW');?>>NEW</option>
                      <option value="MODIFY"
                        <?php if(isset($info)) echo 'MODIFY'==$info->p_type? 'selected="selected"':0; else echo set_select('p_type','MODIFY');?>>MODIFY</option>
                      </select>
                      <span class="error-msg"><?php echo form_error("p_type"); ?></span>
                    </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label">Project Co-ordinator <span style="color:red;">  *</span></label>
                  <div class="col-sm-3">
                    <input type="text" name="project_coordinator" class="form-control" value="<?php if(isset($info->project_coordinator)) echo $info->project_coordinator; else echo set_value('project_coordinator'); ?>" placeholder="Project Co-ordinator 1">
                   <span class="error-msg"><?php echo form_error("project_coordinator");?></span>
                  </div>
                  <div class="col-sm-3">
                    <input type="text" name="project_coordinator2" class="form-control" value="<?php if(isset($info->project_coordinator2)) echo $info->project_coordinator2; else echo set_value('project_coordinator2'); ?>" placeholder="Project Co-ordinator 2">
                   <span class="error-msg"><?php echo form_error("project_coordinator2");?></span>
                  </div>
                  <label class="col-sm-1 control-label parent_id">Parent <span style="color:red;">*  </span></label>
                  <div class="col-sm-3 parent_id">
                  <select class="form-control select2" name="parent_id" id="parent_id" style="width: 100%"> 
                    <option value="" selected="selected">Select 选择</option>
                    <?php foreach ($plist as $rows) { ?>
                      <option value="<?php echo $rows->project_id; ?>" 
                      <?php if (isset($info))
                          echo $rows->project_id == $info->parent_id ? 'selected="selected"' : 0;
                          else
                          echo $rows->project_id ==set_value('parent_id') ? 'selected="selected"' : 0;
                      ?>><?php echo $rows->project_name; ?></option>
                          <?php } ?>
                      </select>
                      <span class="error-msg"><?php echo form_error("parent_id"); ?></span>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label">Requirement <span style="color:red;">  *</span></label>
                  <div class="col-sm-10">
                    <textarea  name="project_requirement" class="form-control" rows="5"><?php if(isset($info)) echo $info->project_requirement; else echo set_value('project_requirement'); ?> </textarea>
                   <span class="error-msg"><?php echo form_error("project_coordinator");?></span>
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
                </div>
  
                <div class="form-group">
                  <label class="col-sm-2 control-label">Attachment 
                    <span style="color:red;">  </span></label>
                  <div class="col-sm-3">
                    <input type="file" class="form-control"  name="attachemnt_file[]" class="form-control" multiple="">
          
                    <span>Allows Type: jpg,png, pdf.</span>
                    <p class="error-msg"><?php  
                        if(isset($exception_err)) echo $exception_err; ?></p>
                  </div>
                </div>
                </div>
                <div class="box-footer">
                 <div class="col-sm-6">
                  <a href="<?php echo base_url(); ?>psubmit/lists" class="btn btn-info"><i class="fa fa-arrow-circle-o-left"></i> Back</a></div>
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
<script type="text/javascript">
  $(document).ready(function(){
  $(document).on('click','input[type=number]',function(){ this.select(); });
        $('.date').datepicker({
            "format": "dd/mm/yyyy",
            "todayHighlight": true,
            "autoclose": true
        });


 var p_type=$("#p_type").val(); 
    if(p_type=='NEW'){
       $(".parent_id").hide();
    }else{
      $(".parent_id").show();
    }
  $("#p_type").change(function(){
    var p_type=$("#p_type").val(); 
    if(p_type=='NEW'){
       $(".parent_id").hide();
    }else{
      $(".parent_id").show();
    }
    });

  });
</script>