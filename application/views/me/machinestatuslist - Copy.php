<style type="text/css">
  .error-msg{display: none;}
</style>
<script type="text/javascript">
var url1="<?php echo base_url(); ?>me/machinestatus/lists";
  $(document).ready(function() {
    ////////////////////////////////
    $("#addNewTeam").click(function(){
    var note = $("#note").val();
    var error = 0;
   
    if(note==""){
      $("#note").css({"border-color":"red"});
      $("#note").parent().children("span").show(200).delay(3000).hide(200,function(){
      $("#note").css({"border-color":"#ccc"});
      });
      error=1;
    }
   
    if(error == 0) {
      $("#formId").submit();
      //document.location=url1;
    }

  });
    ////////////////////// CALLING AJAX FOR DELETE PRODUCT/////////
  $(".uservice").click(function(e){
    e.preventDefault();
    var rowId=$(this).data('pid');
     $("#product_status_id").val(rowId);
     $("#TeamModal").modal("show");
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
<a class="btn btn-sm btn-primary pull-right" style="margin-right:0px;" href="<?php echo base_url(); ?>me/machinestatus/add2">
<i class="fa fa-plus"></i>
Add Multiple Assign
</a> 
<!-- <a class="btn btn-sm btn-primary pull-right" style="margin-right:0px;" href="<?php echo base_url(); ?>me/machinestatus/add">
<i class="fa fa-plus"></i>
Add Single Assign
</a>
<a class="btn btn-sm btn-primary pull-right" style="margin-right:0px;" href="<?php echo base_url(); ?>me/machinestatus/mtakeover">
<i class="fa fa-plus"></i>
Multiple Transfer
</a> -->
</div>
</div>
</div>
</div>
          <!-- /.box-header -->
          <div class="box-body">
            <form class="form-horizontal" action="<?php echo base_url();?>me/machinestatus/lists" method="GET" enctype="multipart/form-data">
            <div class="form-group">
              <label class="col-sm-1 control-label">Location </label>
              <div class="col-sm-3">
                <select class="form-control select2"  name="line_id" id="line_id">
                  <option value="">All Location</option>
                  <?php
                   foreach ($flist as $value) {  ?>
                    <option value="<?php echo $value->line_id; ?>"
                      <?php  echo set_select('line_id',$value->line_id); ?>>  <?php echo $value->line_no; ?></option>
                    <?php } ?>
                </select>
              </div>
              <div class="col-sm-6">
                <input type="text" name="tpm_serial_code" class="form-control" placeholder="Search 搜索 like TPM/ventura code/Name/China name/Model/Type" value="<?php  echo set_value('tpm_serial_code'); ?>" autofocus>
              </div>
              <div class="col-sm-2">
              <button type="submit" class="btn btn-success pull-left"> Search 搜索 </button>
              <a class="btn btn-sm btn-primary pull-right" style="margin-right:0px;" href="<?php echo base_url(); ?>me/machinestatus/lists">All</a>
            </div>
            </div>

              <!-- /.box-body -->
            </form>
            <div class="table-responsive table-bordered">
              <table id="" class="table table-bordered table-striped" style="width:100%;border:#00" >
                <thead>
                <tr>
                  <th style="width:20%;">Asset Name</th>
                  <th style="width:8%">Ventura CODE</th>
                  <th style="text-align:center;width:8%">TPM CODE (TPM代码)</th>
                  <th style="width:6%;text-align:center">From Location</th>
                  <th style="width:6%;text-align:center">To Location</th>
                  <th style="text-align:center;width:10%">Assign Date</th>
                  <th style="text-align:center;width:6%">Type</th>
                  <th style="text-align:center;width:6%">Status 状态</th>
                  <th  style="text-align:center;width:5%">Actions 行动</th>
              </tr>
              </thead>
              <tbody>
              <?php
              if($list&&!empty($list)):
                foreach($list as $row):
                    ?>
                  <tr>
                    <td><?php echo $row->product_name;?></td>
                    <td style="text-align:center">
                      <?php echo $row->ventura_code; ; ?></td>
                    <td style="text-align:center">
                      <?php echo $row->tpm_serial_code; ; ?></td>
                    <td style="text-align:center"><?php echo $row->from_location_name; ?></td> 
                    <td style="text-align:center"><?php echo $row->to_location_name; ?></td> 
                    <td style="text-align:center"><?php echo findDate($row->assign_date);  ?></td>
                    <td style="text-align:center"> <?php echo $row->machine_type_name; ?></td> 
                    <td style="text-align:center">
                    <span class="btn btn-xs btn-success">
                      <?php 
                      echo CheckStatus($row->machine_status);
                      ?>
                    </span>
                    </td>
                    <td style="text-align:center">
                        <!-- Single button -->
                    <div class="btn-group">
                        <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            <i class="fa fa-gear tiny-icon"></i><span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu pull-right" role="menu">
                          <!-- <li> <a href="<?php echo base_url()?>me/machinestatus/takeoverForm/<?php echo $row->product_status_id;?>"><i class="fa fa-arrow-circle-o-right tiny-icon"></i>Take Over</a></li>
                          <?php if($row->machine_status!=2){ ?>
                          <li> <a href="<?php echo base_url()?>me/machinestatus/idle/<?php echo $row->product_status_id;?>"><i class="fa fa-arrow-circle-o-right tiny-icon"></i>IDLE</a></li>
                          <?php } ?>
                          <?php if($row->machine_status!=4){ ?>
                          <li><a href="#" data-pid="<?php echo $row->product_status_id; ?>" class="repairing"><i class="fa fa fa-trash-o tiny-icon"></i>Repairing</a></li>
                          <?php } ?>
                          <?php if($row->machine_status!=3){ ?>
                          <li><a href="#" data-pid="<?php echo $row->product_status_id; ?>" class="uservice"><i class="fa fa fa-trash-o tiny-icon"></i>Under Service</a></li> -->
                        <?php if($row->machine_status!=2){ ?>
                          <li> <a href="<?php echo base_url()?>me/machinestatus/edit/<?php echo $row->product_status_id;?>"><i class="fa fa-edit tiny-icon"></i>Edit 编辑</a></li>
                            <?php if($this->session->userdata('delete')=='YES'){ ?>
                          <li><a href="#" class="delete" data-pid="<?php echo $row->product_status_id;?>"><i class="fa fa-trash-o tiny-icon"></i>Delete 删除</a></li>
                        <?php } ?>
                         
                        
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
               <div class="box-tools">
                  <?php if(isset($pagination))echo $pagination; ?>
              </div>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
        </div>
 </div>

  <div class="modal fade " id="TeamModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title text-primary" id="myModalLabel"> Note</h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" id="formId" method="POST" action="<?php echo base_url()?>me/machinestatus/underservice">
          <div class="form-group">
            <label class="col-sm-2 control-label">Note </label>
            <div class="col-sm-9">
              <textarea class="form-control" name="note" rows="2" id="note" placeholder="Note"></textarea> 
              <span class="error-msg">Note field is required</span>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Date </label>
            <div class="col-sm-3">
              <input class="form-control date" name="takeover_date"  id="takeover_date" placeholder="Date"><span class="error-msg">Date field is required</span>
            </div>
          </div>
       <input type="hidden" name="product_status_id"  id="product_status_id">
       </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal"> Close</button>
        <button type="button" class="btn btn-primary" id="addNewTeam"><i class="fa fa-save"></i> OK</button>
      </div>
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
   url:"<?php echo base_url();?>me/machinestatus/checkMachineUse/"+rowId,
   success:function(data){
    if(data=="EXISTS"){
      $("#alertMessageHTML").html("Sorry, this information can't be deleted.!!");
      $("#alertMessagemodal").modal("show");
    }else{
      location.href="<?php echo base_url();?>me/machinestatus/delete/"+rowId;
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