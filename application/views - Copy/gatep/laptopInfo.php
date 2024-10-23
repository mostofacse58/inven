<script language="javascript" type="text/javascript">
$(document).ready(function() {
  $('.popup').click(function(event) {
     var urls='<?php echo base_url();?>gatep/laptop/showbar';
     event.preventDefault();
     window.open(urls, "popupWindow", "width=1050,height=700,scrollbars=yes");
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
<button type="submit" class="btn btn-info pull-left popup">Print</button>
<!-- <a class="btn btn-sm btn-primary pull-right" style="margin-right:0px;" href="<?php echo base_url();?>gatep/laptop/showbar">
<i class="fa fa-plus"></i>
print
</a> -->
</div>
</div>
</div>
</div>
<div class="box box-info">
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" action="<?php echo base_url();?>gatep/laptop/save<?php if(isset($info)) echo "/$info->laptop_id"; ?>" method="POST" enctype="multipart/form-data">
              <div class="box-body">
                <div class="form-group">
                  <label class="col-sm-2 control-label">Employee Name<span style="color:red;">  *</span></label>
                  <div class="col-sm-3">
                    <select class="form-control select2" required name="employee_id" id="employee_id">
                      <option value="">Select Employee</option>
                      <?php foreach ($elist as $value) {  ?>
                        <option value="<?php echo $value->employee_id; ?>"
                          <?php  if(isset($info)) echo $value->employee_id==$info->employee_id? 'selected="selected"':0; else echo set_select('employee_id',$value->employee_id);?>>
                          <?php echo $value->employee_name; ?></option>
                        <?php } ?>
                    </select>
                   <span class="error-msg"><?php echo form_error("employee_id");?></span>
                  </div>
                  <label class="col-sm-2 control-label">Brand Name</label>
                  <div class="col-sm-3">
                    <select class="form-control select2" required name="brand_id" id="brand_id">
                      <option value="">Select Brand</option>
                      <?php foreach ($blist as $value) {  ?>
                        <option value="<?php echo $value->brand_id; ?>"
                          <?php  if(isset($info)) echo $value->brand_id==$info->brand_id? 'selected="selected"':0; else echo set_select('brand_id',$value->brand_id);?>>
                          <?php echo $value->brand_name; ?></option>
                        <?php } ?>
                    </select>
                   <span class="error-msg"><?php echo form_error("brand_id");?></span>
                  </div>              
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label">Serail No<span style="color:red;">  *</span></label>
                  <div class="col-sm-3">
                    <input type="text" name="sn_no" class="form-control" placeholder="Serail No" value="<?php if(isset($info->sn_no)) echo $info->sn_no; else echo set_value('sn_no'); ?>">
                   <span class="error-msg"><?php echo form_error("sn_no");?></span>
                  </div>
                  <label class="col-sm-2 control-label">User ID<span style="color:red;">  *</span></label>
                  <div class="col-sm-3">
                    <input type="text" name="user_no" class="form-control" placeholder="User ID" value="<?php if(isset($info->user_no)) echo $info->user_no; else echo set_value('user_no'); ?>">
                   <span class="error-msg"><?php echo form_error("user_no");?></span>
                  </div>
                  <div class="col-sm-2">
                <button type="submit" class="btn btn-success pull-left">SAVE</button>
                </div>
                </div>

              <!-- /.box-body -->
            </form>
          </div>
            <!-- /.box-header -->
            <div class="box-body box">
              <div class="col-md-12">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th style="width:4%">SN</th>
                    <th style="width:20%">Employee Name(ID)</th>
                    <th style="width:10%" class="text-center">Department </th>
                    <th style="width:10%" class="text-center">Brand </th>
                    <th style="width:20%" class="text-center">Serial No</th>
                    <th style="width:20%" class="text-center">User NO</th>
                    <th style="width:20%" class="text-center">Status</th>
                    <th  style="text-align:center;width:15%">Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php
                  if($list&&!empty($list)): $i=1;
                      foreach($list as $row):
                          ?>
                      <tr>
                        <td class="text-center"><?php echo $i++;?></td>
                        <td><?php echo "$row->employee_name ($row->employee_no)";?></td>
                        <td class="text-center"><?php echo $row->department_name;?></td>
                        <td class="text-center"><?php echo $row->brand_name;?></td>
                        <td class="text-center"><?php echo $row->sn_no;?></td>
                        <td class="text-center"><?php echo $row->user_no;?></td>
                        <td style="text-align:center">
                        <span class="btn btn-xs btn-<?php echo ($row->status==2)?"danger":"success";?>">
                            <?php echo ($row->status==2)?"Pending":"Approved";?>
                        </span>
                  </td>
                        <td style="text-align:center">
                          <div class="btn-group">
                      <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                          <i class="fa fa-gear tiny-icon"></i><span class="caret"></span>
                      </button>
                      <ul class="dropdown-menu pull-right" role="menu">
                        <?php if($row->status==2){  ?>
                         <li><a href="<?php echo base_url()?>gatep/laptop/approved/<?php echo $row->laptop_id;?>">
                        <i class="fa fa-check tiny-icon"></i> Approve</a>
                      </li>
                      <?php }else{ ?>
                       <li><a href="<?php echo base_url()?>gatep/laptop/reject/<?php echo $row->laptop_id;?>">
                        <i class="fa fa-ban tiny-icon"></i> Reject</a>
                      </li>
                      <?php } ?>
                       <li><a href="<?php echo base_url()?>gatep/laptop/edit/<?php echo $row->laptop_id;?>">
                        <i class="fa fa-edit tiny-icon"></i> Edit</a>
                      </li>
                      <li><a href="#" class="delete" data-pid="<?php echo $row->laptop_id;?>">
                        <i class="fa fa-trash-o tiny-icon"></i> Delete</a></li>
                      </ul>
                    </div>
                       
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
        Sorry, this Employee can't be deleted!!
        </div>
      </div><!-- /.modal-content -->
    </div>
  </div>

<script>
$(document).ready (function(){
  ///////////////////  CHECK BEFOR DELETING ATTACHEMNT//////////////////////
$(".delete").click(function(e){
  job=confirm("Are you sure you want to delete this information?");
   if(job==true){
  e.preventDefault();
  var rowId=$(this).data('pid');
  var url=$(this).attr("href");
  $.ajax({
   type:"GET",
   url:"<?php echo base_url();?>gatep/laptop/checkDelete/"+rowId,
     success:function(data){
      if(data=="EXISTS"){
        $("#deleteMessage").modal("show");
      }else{
        location.href="<?php echo base_url();?>gatep/laptop/delete/"+rowId;
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
