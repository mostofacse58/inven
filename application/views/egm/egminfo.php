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
            <form class="form-horizontal" action="<?php echo base_url();?>egm/egmman/save<?php if(isset($info)) echo "/$info->me_id"; ?>" method="POST" enctype="multipart/form-data">
              <div class="box-body">
                <div class="form-group">
                  <label class="col-sm-2 control-label">ME Name<span style="color:red;">  *</span></label>
                  <div class="col-sm-3">
                    <input type="text" name="me_name" class="form-control" placeholder="ME Name" value="<?php if(isset($info->me_name)) echo $info->me_name; else echo set_value('me_name'); ?>" autofocus>
                   <span class="error-msg"><?php echo form_error("me_name");?></span>
                  </div>
                  <label class="col-sm-2 control-label">Designation <span style="color:red;">  *</span></label>
                  <div class="col-sm-3">
                    <select class="form-control select2" name="post_id" id="post_id">
                    <option value="" selected="selected">Select Designation</option>
                    <?php foreach($plist as $rows){  ?>
                    <option value="<?php echo $rows->post_id; ?>" 
                      <?php if(isset($info->post_id))echo $rows->post_id==$info->post_id? 'selected="selected"':0; else
                       echo $rows->post_id==set_value('post_id')? 'selected="selected"':0; ?>><?php echo $rows->post_name; ?></option>
                    <?php }  ?>
                  </select>                    
                  <span class="error-msg"><?php echo form_error("post_id");?></span>
                  </div>
                  
               
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label">Mobile No. 手机号码。</label>
                  <div class="col-sm-3">
                    <input type="text" name="mobile_no" class="form-control" placeholder="Mobile No. 手机号码。" value="<?php if(isset($info->mobile_no)) echo $info->mobile_no; else echo set_value('mobile_no'); ?>">
                   <span class="error-msg"><?php echo form_error("mobile_no");?></span>
                  </div>
                  <label class="col-sm-2 control-label">ID NO<span style="color:red;">  *</span></label>
                  <div class="col-sm-3">
                    <input type="text" name="id_no" class="form-control" placeholder="ID NO" value="<?php if(isset($info->id_no)) echo $info->id_no; else echo set_value('id_no'); ?>">
                   <span class="error-msg"><?php echo form_error("id_no");?></span>
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
                      <th style="width:20%">ME Name</th>
                      <th style="width:15%" class="text-center">Designation</th>
                      <th style="width:10%" class="text-center">Mobile No. 手机号码。</th>
                      <th style="width:10%" class="text-center">ID NO</th>
                      <th  style="text-align:center;width:10%">Actions 行动</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php
                  if($list&&!empty($list)):
                      foreach($list as $row):
                          ?>
                          <tr>
                              <td><?php echo $row->me_name;?></td>
                              <td class="text-center"><?php echo $row->post_name;?></td>
                              <td class="text-center"><?php echo $row->mobile_no;?></td>
                              <td class="text-center"><?php echo $row->id_no;?></td>
                              <td style="text-align:center">
                                <a class="btn btn-success" href="<?php echo base_url()?>egm/egmman/edit/<?php echo $row->me_id;?>"><i class="fa fa-edit tiny-icon"></i></a>
                                &nbsp;&nbsp;&nbsp;&nbsp;                                        
                          <a href="#" class="btn btn-danger delete" data-pid="<?php echo $row->me_id;?>"><i class="fa fa-trash-o tiny-icon"></i></a>
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
  job=confirm("Are you sure you want to delete this ME?");
   if(job==true){
  e.preventDefault();
  var rowId=$(this).data('pid');
  var url=$(this).attr("href");
  $.ajax({
   type:"GET",
   url:"<?php echo base_url();?>egm/egmman/checkDelete 删除/"+rowId,
     success:function(data){
      if(data=="EXISTS"){
        $("#alertMessageHTML").html("Sorry, this information can't be deleted.!!");
        $("#alertMessagemodal").modal("show");
      }else{
        location.href="<?php echo base_url();?>egm/egmman/delete/"+rowId;
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
