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
  });
 function formsubmit(){
  var error_status=false;
  var category_id=$("#category_id").val();
  //var asset_encoding=$("#asset_encoding").val();
  var date=$("#date").val();
    if(category_id == ''){
      error_status=true;
      $("#alertMessageHTML").html("Please select Category!!");
      $("#alertMessagemodal").modal("show");
    } 
  
    // if(asset_encoding == ''){
    //   error_status=true;
    //   $('input[name=asset_encoding]').css('border', '1px solid #f00');
    // } else {
    //   $('input[name=asset_encoding]').css('border', '1px solid #ccc');      
    // }

    var location_name=$("#location_name").val();
    if(location_name == ''){
      error_status=true;
      $("#alertMessageHTML").html("Please select Location!!");
      $("#alertMessagemodal").modal("show");
    } else {
      $('select[name=location_name]').css('border', '1px solid #ccc');      
    }
  if(date == '') {
    error_status=true;
    $("#date").css('border', '1px solid #f00');
  } else {
    $("#date").css('border', '1px solid #ccc');      
  }
  if(error_status==true){
    return false;
  }else{
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
      <form class="form-horizontal" action="<?php echo base_url();?>it/maintenance/save<?php if(isset($info)) echo "/$info->maintenance_id"; ?>" method="POST" enctype="multipart/form-data"  onsubmit="return formsubmit();">
        <div class="box-body">
          <div class="form-group">
         
         <label class="col-sm-2 control-label">Category<span style="color:red;">  *</span></label>
          <div class="col-sm-3">
           <select class="form-control select2" name="category_id" id="category_id">
          <option value="" selected="selected">Select Category</option>
          <?php foreach ($clist as $rows) { ?>
            <option value="<?php echo $rows->category_id; ?>" 
            <?php if (isset($info))
                echo $rows->category_id == $info->category_id ? 'selected="selected"' : 0;
                else
                echo $rows->category_id == set_value('category_id')? 'selected="selected"' : 0;
            ?>><?php echo $rows->category_name; ?></option>
                <?php } ?>
            </select>
          <span class="error-msg"><?php echo form_error("category_id"); ?></span>
        </div>
        <label class="col-sm-2 control-label ">TPM Code/Asset No <span style="color:red;"> </span></label>
          <div class="col-sm-3">
           <input type="text" name="asset_encoding" id="asset_encoding" class="form-control" value="<?php if(isset($info)) echo $info->asset_encoding; else echo set_value('asset_encoding'); ?>">
           <span class="error-msg">
            <?php echo form_error("asset_encoding");?></span>
         </div>
      </div>
      <!-- ///////////////////// -->
        <div class="form-group">           
          <label class="col-sm-2 control-label">Location <span style="color:red;">  *</span></label>
          <div class="col-sm-3">
            <select class="form-control select2" name="location_name" id="location_name" style="width: 100%">
              <option value="">Select Location</option>
              <?php foreach ($llist as $value) {  ?>
                <option value="<?php echo $value->location_name; ?>"
                  <?php  if(isset($info)) echo $value->location_name==$info->location_name? 'selected="selected"':0; else echo $value->location_name==$this->session->userdata('location_name')? 'selected="selected"':0; ?>>
                  <?php echo $value->location_name; ?></option>
                <?php } ?>
            </select>
           <span class="error-msg"><?php echo form_error("location_name");?></span>
          </div>
          </div>
          <div class="form-group">
          <label class="col-sm-2 control-label">Date <span style="color:red;">  *</span></label>
           <div class="col-sm-3">
              <div class="input-group date">
               <div class="input-group-addon">
                 <i class="fa fa-calendar"></i>
               </div>
               <input type="text" name="date" id="date" readonly class="form-control pull-right" value="<?php if(isset($info)) echo findDate($info->date); else echo date('d/m/Y'); ?>">
             </div>
           <span class="error-msg"><?php echo form_error("date");?></span>
          </div>

          <label class="col-sm-2 control-label">Next Service Date <span style="color:red;">  </span></label>
           <div class="col-sm-3">
              <div class="input-group date">
               <div class="input-group-addon">
                 <i class="fa fa-calendar"></i>
               </div>
               <input type="text" name="next_service_date" id="date" readonly class="form-control pull-right" value="<?php if(isset($info)) echo findDate($info->next_service_date); else echo set_value('next_service_date');?>">
             </div>
           <span class="error-msg"><?php echo form_error("date");?></span>
         </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">Team member<span style="color:red;">*  </span></label>
           <div class="col-sm-3">
            <select class="form-control select2" name="team_member" id="team_member">
              <option value="">Select ME</option>
              <?php $melist=$this->db->query("SELECT * FROM me_info")->result();
              foreach ($melist as $value) {  ?>
                <option value="<?php echo $value->me_name; ?>"
                  <?php  if(isset($info)) echo $value->me_name==$info->team_member? 'selected="selected"':0; else echo set_select('team_member',$value->me_name);?>>
                  <?php echo $value->me_name; ?></option>
                <?php } ?>
            </select>
           <span class="error-msg"><?php echo form_error("team_member");?></span>
         </div>
         <label class="col-sm-2 control-label">Team member 2<span style="color:red;">  </span></label>
           <div class="col-sm-3">
            <select class="form-control select2" name="team_member2" id="team_member2">
              <option value="">Select ME</option>
              <?php $melist=$this->db->query("SELECT * FROM me_info")->result();
              foreach ($melist as $value) {  ?>
                <option value="<?php echo $value->me_name; ?>"
                  <?php  if(isset($info)) echo $value->me_name==$info->team_member2? 'selected="selected"':0; else echo set_select('team_member2',$value->me_name);?>>
                  <?php echo $value->me_name; ?></option>
                <?php } ?>
            </select>
           <span class="error-msg"><?php echo form_error("team_member2");?></span>
          </div>
          </div>
          <div class="form-group">
          <label class="col-sm-2 control-label">Customer Review</label>
            <div class="col-sm-3">
              <textarea  name="customer_review" class="form-control" rows="2"><?php if(isset($info)) echo $info->customer_review; else echo set_value('customer_review'); ?> </textarea>
               <span class="error-msg"><?php echo form_error("customer_review");?></span>
            </div>
          
          <label class="col-sm-2 control-label">Work Note <span style="color:red;">  *</span></label>
            <div class="col-sm-3">
              <textarea  name="work_note" class="form-control" rows="2"><?php if(isset($info)) echo $info->work_note; else echo set_value('work_note'); ?> </textarea>
               <span class="error-msg"><?php echo form_error("work_note");?></span>
            </div>
          </div>
          <div class="form-group">
          <label class="col-sm-2 control-label">Spare Parts <span style="color:red;">  </span></label>
            <div class="col-sm-4">
              <textarea  name="spare_parts" class="form-control" rows="2"><?php if(isset($info)) echo $info->spare_parts; else echo set_value('spare_parts'); ?> </textarea>
               <span class="error-msg"><?php echo form_error("spare_parts");?></span>
            </div>
          </div><!-- ///////////////////// -->
          
         </div>
        <!-- /.box-body -->
        <div class="box-footer">
           <div class="col-sm-4">
            <a href="<?php echo base_url(); ?>it/maintenance/lists" class="btn btn-info"><i class="fa fa-arrow-circle-o-left" aria-hidden="true"></i> Back</a></div>
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

