  <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>asset/datepickerbootstrap/css/datepicker.css">
<script type="text/javascript" src="<?php echo base_url();?>asset/datepickerbootstrap/js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>asset/bootstrapdatetimepicker/js/moment.min.js"></script>

 <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>asset/bootstrapdatetimepicker/css/bootstrap-datetimepicker.min.css">
 <script type="text/javascript" src="<?php echo base_url();?>asset/bootstrapdatetimepicker/js/bootstrap-datetimepicker.min.js"></script>
<script>
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
      var product_detail_ids = "<?php echo $info->product_detail_id; ?>";
      <?php  }else{ ?>
        var product_detail_ids = "<?php echo set_value('product_detail_id') ?>";
      <?php }?>
      ///////////////
      ////////////////////////
       var location_id=$('#location_id').val();
           if(location_id !=''){
            $.ajax({
              type:"post",
              url:"<?php echo base_url()?>"+'cctv/camerastatus/getCameraLine',
              data:{location_id:location_id},
              success:function(data){
                $("#product_detail_id").empty();
                $("#product_detail_id").append(data);
                if(product_detail_ids != ''){
                  $('#product_detail_id').val(product_detail_ids).change();
                }
              }
            });
          }

      ///////////////////////
      $('#location_id').on('change',function(){
        var location_id=$('#location_id').val();
            if(location_id !=''){
            $.ajax({
              type:"post",
              url:"<?php echo base_url()?>"+'cctv/camerastatus/getCameraLine',
              data:{location_id:location_id},
              success:function(data){
                $("#product_detail_id").empty();
                $("#product_detail_id").append(data);
                if(product_detail_ids != ''){
                  $('#product_detail_id').val(product_detail_ids).change();
                }
              }
            });
          }
          });
  });
 function formsubmit(){
  var error_status=false;
  var product_detail_id=$("#product_detail_id").val();
  var start_time=$("#start_time").val();
  var start_date=$("#start_date").val();
    if(product_detail_id == ''){
      error_status=true;
      $("#alertMessageHTML").html("Please select CCTV!!");
      $("#alertMessagemodal").modal("show");
    } else {
    }
  if(start_date == '') {
    error_status=true;
    $("#start_date").css('border', '1px solid #f00');
  } else {
    $("#start_date").css('border', '1px solid #ccc');      
  }
   if(start_time == '') {
    error_status=true;
    $("#start_time").css('border', '1px solid #f00');
  } else {
    $("#start_time").css('border', '1px solid #ccc');      
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
      <form class="form-horizontal" action="<?php echo base_url();?>cctv/camerastatus/save<?php if(isset($info)) echo "/$info->cctv_main_id"; ?>" method="POST" enctype="multipart/form-data"  onsubmit="return formsubmit();">
      <div class="box-body">
      <!-- ///////////////////// -->
      <div class="form-group">
        <div class="form-group">
          <label class="col-sm-2 control-label">Status 状态 <span style="color:red;">  *</span></label>
          <div class="col-sm-2">
            <select class="form-control select2"  name="cctv_status" id="cctv_status">
              <option value="1"
                <?php if(isset($info)) echo 1==$info->cctv_status? 'selected="selected"':0; else echo set_select('cctv_status',1);?>>
                  Offline</option>
                  <option value="2"
                <?php if(isset($info)) echo 2==$info->cctv_status? 'selected="selected"':0; else echo set_select('cctv_status',2);?>>
                  Online</option>
                  <option value="3"
                <?php if(isset($info)) echo 3==$info->cctv_status? 'selected="selected"':0; else echo set_select('cctv_status',3);?>>
                  Damage</option>
            </select>
           <span class="error-msg"><?php echo form_error("cctv_status");?></span>
          </div>
           <label class="col-sm-2 control-label locationDiv">Location <span style="color:red;">  *</span></label>
          <div class="col-sm-2 locationDiv">
            <select class="form-control select2" name="location_id" id="location_id" style="width: 100%">
              <option value="">Select Location</option>
              <?php foreach ($llist as $value) {  ?>
                <option value="<?php echo $value->location_id; ?>"
                  <?php  if(isset($info)) echo $value->location_id==$info->location_id? 'selected="selected"':0; else echo set_select('location_id',$value->location_id);?>>
                  <?php echo $value->location_name; ?></option>
                <?php } ?>
            </select>
           <span class="error-msg"><?php echo form_error("location_id");?></span>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">CCTV No <span style="color:red;">  *</span></label>
          <div class="col-sm-5">
          <select class="form-control select2" name="product_detail_id" id="product_detail_id">
          <option value="" selected="selected">===Select CCTV No===</option>
          <!-- <?php foreach ($mlist as $rows) { ?>
            <option value="<?php echo $rows->product_detail_id; ?>" 
            <?php if (isset($info))
                echo $rows->product_detail_id == $info->product_detail_id ? 'selected="selected"' : 0;
                else
                echo $rows->product_detail_id == set_value('product_detail_id')? 'selected="selected"' : 0;
            ?>><?php echo $rows->product_name; ?></option>
                <?php } ?> -->
            </select>
          <span class="error-msg"><?php echo form_error("product_detail_id"); ?></span>
        </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">Start Date <span style="color:red;">  *</span></label>
           <div class="col-sm-2">
              <div class="input-group date">
               <div class="input-group-addon">
                 <i class="fa fa-calendar"></i>
               </div>
               <input type="text" name="start_date" id="start_date" readonly class="form-control pull-right" value="<?php if(isset($info)) echo findDate($info->start_date); else echo date('d/m/Y'); ?>">
             </div>
           <span class="error-msg"><?php echo form_error("start_date");?></span>
         </div>
         <label class="col-sm-2 control-label">Start Time <span style="color:red;">  *</span></label>
           <div class="col-sm-2">
            <div class="input-group">
               <input type="text" name="start_time" class="form-control timepicker" value="<?php if(isset($info)) echo $info->start_time; else echo set_value('start_time'); ?>">
                <div class="input-group-addon">
                  <i class="fa fa-clock-o"></i>
                </div>
            </div>
           <span class="error-msg"><?php echo form_error("start_time");?></span>
         </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">End Date <span style="color:red;">  </span></label>
           <div class="col-sm-2">
              <div class="input-group date">
               <div class="input-group-addon">
                <i class="fa fa-calendar"></i>
               </div>
               <input type="text" name="end_date" id="end_date" readonly class="form-control pull-right" value="<?php if(isset($info)) echo findDate($info->end_date); else  echo set_value('end_date'); ?>">
             </div>
           <span class="error-msg"><?php echo form_error("end_date");?></span>
         </div>
         <label class="col-sm-2 control-label">End Time <span style="color:red;">  </span></label>
           <div class="col-sm-2">
            <div class="input-group">
               <input type="text" name="end_time" class="form-control timepicker" value="<?php if(isset($info)) echo $info->end_time; else echo set_value('end_time'); ?>">
                <div class="input-group-addon">
                  <i class="fa fa-clock-o"></i>
                </div>
            </div>
           <span class="error-msg"><?php echo form_error("end_time");?></span>
         </div>
        </div>
        <div class="form-group">
              <label class="col-sm-2 control-label">Problem</label>
            <div class="col-sm-3">
              <textarea  name="remarks" class="form-control" rows="2"><?php if(isset($info->remarks)) echo $info->remarks; else echo set_value('remarks'); ?> </textarea>
               <span class="error-msg"><?php echo form_error("remarks");?></span>
            </div>
            <label class="col-sm-2 control-label">Solution Note</label>
            <div class="col-sm-3">
              <textarea  name="repair_note" class="form-control" rows="2"><?php if(isset($info->repair_note)) echo $info->repair_note; else echo set_value('repair_note'); ?> </textarea>
               <span class="error-msg"><?php echo form_error("repair_note");?></span>
            </div>
          </div><!-- ///////////////////// -->
         </div>
        <!-- /.box-body -->
        <div class="box-footer">
           <div class="col-sm-4">
            <a href="<?php echo base_url(); ?>cctv/camerastatus/lists" class="btn btn-info"><i class="fa fa-arrow-circle-o-left" aria-hidden="true"></i> Back</a></div>
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
 