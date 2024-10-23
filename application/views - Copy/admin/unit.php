<script type="text/javascript">
var  baseURL = '<?php echo base_url();?>';
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
            <!-- form start -->
            <form class="form-horizontal" action="<?php echo base_url();?>unit/save<?php if(isset($info)) echo "/$info->unit_id"; ?>" method="POST" enctype="multipart/form-data">
              <div class="box-body">
                <div class="form-group">
                  <label class="col-sm-2 control-label">Unit Name 单价<span style="color:red;">  *</span></label>
                  <div class="col-sm-3">
                    <input type="text" name="unit_name" class="form-control" placeholder="Unit Name" value="<?php if(isset($info->unit_name)) echo $info->unit_name; else echo set_value('unit_name'); ?>">
                   <span class="error-msg"><?php echo form_error("unit_name");?></span>
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
              <div class="col-md-6">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                      <th style="width:50%">Unit Name 单价</th>
                      <th  style="text-align:center;width:8%">Actions 行动</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php
                  if($list&&!empty($list)):
                      foreach($list as $row):
                          ?>
                          <tr>
                              <td><?php echo $row->unit_name;?></td>
                              <td style="text-align:center">
                                <a class="btn btn-success" href="<?php echo base_url()?>unit/edit/<?php echo $row->unit_id;?>"><i class="fa fa-edit tiny-icon"></i></a>
                                &nbsp;&nbsp;&nbsp;&nbsp;                                        
                                <a href="#" data-pid="<?php echo $row->unit_id;?>" class="btn btn-danger delete" ><i class="fa fa-trash-o tiny-icon"></i></a>
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
   url:"<?php echo base_url();?>unit/checkDelete 删除/"+rowId,
     success:function(data){
      if(data=="EXISTS"){
        $("#alertMessageHTML").html("Sorry, this information can't be deleted.!!");
        $("#alertMessagemodal").modal("show");
      }else{
        location.href="<?php echo base_url();?>unit/delete/"+rowId;
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

