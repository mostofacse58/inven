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
        <!-- form start -->
            <form class="form-horizontal" action="<?php echo base_url();?>location/save<?php if(isset($info)) echo "/$info->location_id"; ?>" method="POST" enctype="multipart/form-data">
              <div class="box-body">
                <div class="form-group">
                  <label class="col-sm-1 control-label">Main Area <span style="color:red;">  </span></label>
                  <div class="col-sm-2">
                    <select class="form-control select2" name="mlocation_id" id="mlocation_id">
                    <option value="" selected="selected">Select Area</option>
                    <?php $mdlist=$this->db->query("SELECT * FROM main_location")->result();
                    foreach($mdlist as $rows){  ?>
                    <option value="<?php echo $rows->mlocation_id; ?>" 
                      <?php if(isset($info->mlocation_id))echo $rows->mlocation_id==$info->mlocation_id? 'selected="selected"':0; else
                       echo $rows->mlocation_id==set_value('mlocation_id')? 'selected="selected"':0; ?>><?php echo $rows->mlocation_name; ?></option>
                    <?php }  ?>
                    </select>                    
                    <span class="error-msg"><?php echo form_error("mlocation_id");?></span>
                  </div>
                  <label class="col-sm-2 control-label">Location Name<span style="color:red;">  *</span></label>
                  <div class="col-sm-3">
                    <input type="text" name="location_name" class="form-control" placeholder="Location Name" value="<?php if(isset($info)) echo $info->location_name; else echo set_value('location_name'); ?>" autofocus>
                   <span class="error-msg"><?php echo form_error("location_name");?></span>
                  </div>
                  <div class="col-sm-2">
                <button type="submit" class="btn btn-success pull-left">
                <?php if(isset($info)) echo "Update"; else echo "SAVE 保存"; ?> </button>
                </div>
                </div>

              <!-- /.box-body -->
            </form>
          </div>
            <!-- /.box-header -->
            <div class="box-body box">
              <div class="col-md-8">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                      <th style="width:5%">SL No</th>
                      <th style="width:20%">Location Name</th>
                      <th  style="text-align:center;width:10%">Actions 行动</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php
                  if($list&&!empty($list)): $i=1;
                      foreach($list as $row):
                          ?>
                          <tr>
                              <td><?php echo $i++;?></td>
                              <td><?php echo $row->location_name;?></td>
                              <td style="text-align:center">
                                <a class="btn btn-success" href="<?php echo base_url()?>location/edit/<?php echo $row->location_id;?>"><i class="fa fa-edit tiny-icon"></i></a>
                                &nbsp;&nbsp;&nbsp;&nbsp;                                        
                                <!-- <a href="#" class="delete btn btn-success" data-pid="<?php echo $row->location_id;?>"><i class="fa fa-trash-o tiny-icon"></i></a> -->
                              </td>
                          </tr>
                      <?php
                      endforeach;
                  endif;
                  ?>
                  </tbody>
              </table>
            </div>
          </div>
            <!-- /.box-body -->
          </div>
        </div>
 </div>
 <div class="modal modal-danger fade bs-example-modal-sm " tabindex="-1" role="dialog" id="deleteMessage" aria-labelledby="mySmallModalLabel">
  <div class="modal-dialog modal-sm">
      <div class="modal-content">

        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
          <h4 class="modal-title" id="mySmallModalLabel"><i class="fa fa-bell-o"></i> System Alert</h4>
        </div>
        <div class="modal-body">
        Sorry, this Location Name can't be deleted.
        </div>
      </div><!-- /.modal-content -->
    </div>
  </div>
<script>
$(document).ready (function(){
  ///////////////////  CHECK BEFOR DELETING ATTACHEMNT//////////////////////
$(".delete").click(function(e){
  job=confirm("Are you sure you want to delete this Information?");
   if(job==true){
  e.preventDefault();
  var rowId=$(this).data('pid');
  var url=$(this).attr("href");
  $.ajax({
   type:"GET",
   url:"<?php echo base_url();?>location/checkLocation/"+rowId,
     success:function(data){
      if(data=="EXISTS"){
        $("#deleteMessage").modal("show");
      }else{
        location.href="<?php echo base_url();?>location/delete/"+rowId;
     }
},
error:function(){
  console.log("failed");
}
});
}
});
});//jquery ends here
</script>