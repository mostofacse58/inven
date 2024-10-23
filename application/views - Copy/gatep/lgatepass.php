<style type="text/css">
  .error-msg{display: none;}
</style>
<script type="text/javascript">
var url1="<?php echo base_url(); ?>gatep/lgatepass/lists";
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
            <!-- /.box-header -->
            <div class="box-body">
              <form class="form-horizontal" action="<?php echo base_url();?>gatep/lgatepass/lists" method="POST" enctype="multipart/form-data">
              <div class="form-group">
                <label class="col-sm-3 control-label">Gate Pass No</label>
                <div class="col-sm-3">
                  <input type="text" name="lgatepass_no" class="form-control" placeholder="Gate Pass No" value="<?php  echo set_value('lgatepass_no'); ?>" autofocus>
                </div>
                <div class="col-sm-1">
                <button type="submit" class="btn btn-success pull-left"> Search </button>
              </div>
              <div class="col-sm-1">
                <a class="btn btn-sm btn-primary pull-right" style="margin-right:0px;" href="<?php echo base_url(); ?>gatep/lgatepass/lists">All</a>
              </div>
              </div>
            </form>
            <!-- <div class="table-responsive table-bordered"> -->
              <table id="" class="table table-bordered table-striped" style="width:100%;border:#000" >
                <thead>
              <tr>
                  <th style="width:5%;text-align:center">SN</th>
                  <th style="width:10%;text-align:center">Gatepass No</th>
                  <th style="width:8%;text-align:center">SN NO</th>
                  <th style="width:10%;text-align:center">Name</th>
                  <th style="width:15%;text-align:center">Gate out Date</th>
                  <th style="text-align:center;width:20%">Gate In Date</th>
                  <th style="text-align:center;width:6%">Status</th>
                  <th  style="text-align:center;width:5%">Action</th>
              </tr>
              </thead>
              <tbody>
              <?php
              if($list&&!empty($list)): $i=1;
                foreach($list as $row):
                    ?>
                  <tr>
                <td style="text-align:center">
                <?php echo $i++; ; ?></td>
                <td style="text-align:center"><?php echo $row->gatepass_no;?></td>
                <td><?php echo $row->sn_no;?></td>
                <td><?php echo $row->employee_name;?></td>                
                <td style="text-align:center">
                <?php echo findDate($row->gatepass_date); echo " $row->gatepass_time"; ?></td>
                <td style="text-align:center">
                <?php echo findDate($row->gate_in_date); echo " $row->gate_in_time"; ?></td>
               <td style="text-align:center">
                  <span class="btn btn-xs btn-<?php echo ($row->gatepass_status==1)?"danger":"success";?>">
                      <?php echo ($row->gatepass_status==1)?"Out":"In";?>
                  </span>
                  </td>
                    <td style="text-align:center">
                        <!-- Single button -->
                    <div class="btn-group">
                      <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                          <i class="fa fa-gear tiny-icon"></i><span class="caret"></span>
                      </button>
                      <ul class="dropdown-menu pull-right" role="menu">
                         <?php if($row->gatepass_status==1){  ?>
                       <li><a href="<?php echo base_url()?>gatep/lgatepass/gatein/<?php echo $row->gatepass_id;?>">
                        <i class="fa fa-arrow-circle-right tiny-icon"></i>In</a>
                      </li>
                      <?php } ?>
                       <?php if($this->session->userdata('delete')=='YES'){ ?>
                        <li><a href="#" class="delete" data-pid="<?php echo $row->gatepass_id;?>"><i class="fa fa-trash-o tiny-icon"></i>Delete</a></li>
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


              <!-- </div> -->
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
        Sorry, this Machine can't be deleted.
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
  $.ajax({
   type:"GET",
   url:"<?php echo base_url();?>gatep/lgatepass/checkMachineUse/"+rowId,
     success:function(data){
      if(data=="EXISTS"){
        $("#deleteMessage").modal("show");
      }else{
        location.href="<?php echo base_url();?>gatep/lgatepass/delete/"+rowId;
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
