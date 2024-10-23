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
            <form class="form-horizontal" action="<?php echo base_url();?>shipping/supplier/save<?php if(isset($info)) echo "/$info->id"; ?>" method="POST" enctype="multipart/form-data">
              <div class="box-body">
                <div class="form-group">
                  <label class="col-sm-2 control-label">Supplier Name<span style="color:red;">  *</span></label>
                  <div class="col-sm-5">
                    <input type="text" name="supplier_name" class="form-control" placeholder="Supplier Name" value="<?php if(isset($info->supplier_name)) echo $info->supplier_name; else echo set_value('supplier_name'); ?>" autofocus>
                   <span class="error-msg"><?php echo form_error("supplier_name");?></span>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label">Address</label>
                  <div class="col-sm-5">
                    <input type="text" name="description" class="form-control" placeholder="Address" value="<?php if(isset($info->description)) echo $info->description; else echo set_value('description'); ?>">
                   <span class="error-msg"><?php echo form_error("description");?></span>
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
                      <th style="width:20%">Supplier Name</th>
                      <th style="width:15%">Address</th>
                      <th  style="text-align:center;width:10%">Actions 行动</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php
                  if($list&&!empty($list)):
                      foreach($list as $row):
                          ?>
                          <tr>
                              <td class=""><?php echo $row->supplier_name;?></td>
                              <td><?php echo $row->description;?></td>
                              <td style="text-align:center">
                                <a class="btn btn-success" href="<?php echo base_url()?>shipping/supplier/edit/<?php echo $row->id;?>"><i class="fa fa-edit tiny-icon"></i></a>
                                &nbsp;&nbsp;&nbsp;&nbsp;                                        
                          <a href="#" class="btn btn-danger delete" data-pid="<?php echo $row->id;?>"><i class="fa fa-trash-o tiny-icon"></i></a>
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
        Sorry, this info can't be deleted!!
        </div>
      </div><!-- /.modal-content -->
    </div>
  </div>

<script>
$(document).ready (function(){
  ///////////////////  CHECK BEFOR DELETING ATTACHEMNT//////////////////////
$(".delete").click(function(e){
  job=confirm("Are you sure you want to delete this info?");
   if(job==true){
  e.preventDefault();
  var rowId=$(this).data('pid');
  var url=$(this).attr("href");
  $.ajax({
   type:"GET",
   url:"<?php echo base_url();?>shipping/supplier/checkDelete/"+rowId,
     success:function(data){
      if(data=="EXISTS"){
        $("#deleteMessage").modal("show");
      }else{
        location.href="<?php echo base_url();?>shipping/supplier/delete/"+rowId;
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
