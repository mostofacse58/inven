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
            <form class="form-horizontal" action="<?php echo base_url();?>me/box/save<?php if(isset($info)) echo "/$info->box_id"; ?>" method="POST" enctype="multipart/form-data">
              <div class="box-body">
                <div class="form-group">
                  <label class="col-sm-2 control-label">Box/Shelves Name<span style="color:red;">  *</span></label>
                  <div class="col-sm-3">
                    <input type="text" name="box_name" class="form-control" placeholder="Box/Shelves Name" value="<?php if(isset($info->box_name)) echo $info->box_name; else echo set_value('box_name'); ?>" autofocus>
                   <span class="error-msg"><?php echo form_error("box_name");?></span>
                  </div>
                  <label class="col-sm-2 control-label">Rack Name <span style="color:red;">  *</span></label>
                  <div class="col-sm-3">
                    <select class="form-control select2" name="rack_id" id="rack_id">
                    <option value="" selected="selected">Select Rack Name</option>
                    <?php 
                    foreach($rlist as $rows){  ?>
                    <option value="<?php echo $rows->rack_id; ?>" 
                      <?php if(isset($info->rack_id))echo $rows->rack_id==$info->rack_id? 'selected="selected"':0; else
                       echo $rows->rack_id==set_value('rack_id')? 'selected="selected"':0; ?>><?php echo $rows->rack_name; ?></option>
                    <?php }  ?>
                  </select>                    
                  <span class="error-msg"><?php echo form_error("rack_id");?></span>
                  </div>
                  <div class="col-sm-2">
                <button type="submit" class="btn btn-success pull-left">SAVE 保存</button>
                </div>
               
                </div>
             

              <!-- /.box-body -->
            </form>
          </div>
            <!-- /.box-header -->
            <div class="box-body box">
              <div class="col-md-10">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                      <th style="width:20%;text-align: center;">Box/Shelves Name</th>
                      <th style="width:15%;text-align: center;" class="text-center">Rack Name</th>
                      <th  style="text-align:center;width:10%">Actions 行动</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php
                  if($list&&!empty($list)):
                      foreach($list as $row):
                          ?>
                          <tr>
                              <td style="text-align: center;"><?php echo $row->box_name;?></td>
                              <td class="text-center"><?php echo $row->rack_name;?></td>
                              <td style="text-align:center">
                                <a class="btn btn-success" href="<?php echo base_url()?>me/box/edit/<?php echo $row->box_id;?>"><i class="fa fa-edit tiny-icon"></i></a>
                                &nbsp;&nbsp;&nbsp;&nbsp;                                        
                          <a href="#" class="btn btn-danger delete" data-pid="<?php echo $row->box_id;?>"><i class="fa fa-trash-o tiny-icon"></i></a>
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
        Sorry, this Box can't be deleted!!
        </div>
      </div><!-- /.modal-content -->
    </div>
  </div>

<script>
$(document).ready (function(){
  ///////////////////  CHECK BEFOR DELETING ATTACHEMNT//////////////////////
$(".delete").click(function(e){
  job=confirm("Are you sure you want to delete this Box?");
   if(job==true){
  e.preventDefault();
  var rowId=$(this).data('pid');
  var url=$(this).attr("href");
  $.ajax({
   type:"GET",
   url:"<?php echo base_url();?>me/box/checkDelete 删除/"+rowId,
     success:function(data){
      if(data=="EXISTS"){
        $("#deleteMessage").modal("show");
      }else{
        location.href="<?php echo base_url();?>me/box/delete/"+rowId;
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
