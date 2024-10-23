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
            <form class="form-horizontal" action="<?php echo base_url();?>indent/save<?php if(isset($info)) echo "/$info->pi_id"; ?>" method="POST" enctype="multipart/form-data">
              <div class="box-body">
                <div class="form-group">
                  <label class="col-sm-2 control-label">PI NO<span style="color:red;">  *</span></label>
                  <div class="col-sm-4">
                    <input type="text" name="pi_no" class="form-control" placeholder="PI NO" value="<?php if(isset($info)) echo $info->pi_no; else echo set_value('pi_no'); ?>" autofocus>
                   <span class="error-msg"><?php echo form_error("pi_no");?></span>
                  </div>
                  <div class="col-sm-2">
                <button type="submit" class="btn btn-success pull-left"><i class="fa fa-save"></i> 
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
                      <th style="width:5%">SN</th>
                      <th style="width:20%">PI NO</th>
                      <th style="width:15%">PI Date</th>
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
                    <td><?php echo $row->pi_no;?></td>
                    <td><?php echo findDate($row->pi_date);?></td>
                    <td style="text-align:center">
                      <a class="btn btn-success" href="<?php echo base_url()?>indent/edit/<?php echo $row->pi_id;?>">
                        <i class="fa fa-edit tiny-icon"></i></a>
                      &nbsp;&nbsp;&nbsp;&nbsp;                                        
                      <a href="#" class="delete btn btn-success" data-pid="<?php echo $row->pi_id;?>"><i class="fa fa-trash-o tiny-icon"></i></a>
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
        Sorry, this PI can't be deleted.
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
   url:"<?php echo base_url();?>indent/checkPI/"+rowId,
     success:function(data){
      if(data=="EXISTS"){
        $("#deleteMessage").modal("show");
      }else{
        location.href="<?php echo base_url();?>indent/delete/"+rowId;
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