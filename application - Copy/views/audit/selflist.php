<script src="<?php echo base_url('asset/js/plugins/datepicker/bootstrap-datepicker.js'); ?>"></script>
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
            <!-- /.box-scheduleer -->
            <div class="box-body box">
              <div class="col-md-12">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                      <th style="width:10%">Quarter</th>
                      <th style="width:10%">Type</th>
                       <th style="width:10%">Category</th>
                      <th style="width:20%">Department</th>
                      <th style="width:10%">Start Date</th>
                      <th style="width:10%">End Date</th>
                      <th style="width:20%">Note</th>
                      <th style="width:10%">Status</th>
                      <th  style="text-align:center;width:10%">Actions</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php
                  if($list&&!empty($list)):
                      foreach($list as $row):
                          ?>
                          <tr>
                              <td class=""><?php if($row->quater==1) echo "1st";
                              elseif($row->quater==2) echo "2nd";
                              elseif($row->quater==3) echo "3rd";
                              elseif($row->quater==4) echo "4th"; 
                              elseif($row->quater==5) echo "Yearly"; ?></td>
                              
                              <td class=""><?php echo $row->atype;?></td>
                              <td class=""><?php echo $row->acategory;?></td>
                              <td class=""><?php echo $row->department_name;?></td>
                              <td class=""><?php echo $row->start_date;?></td>
                              <td class=""><?php echo $row->end_date;?></td>
                              <td class=""><?php echo $row->note;?></td>
                              <td style="text-align: center;">
                                <?php if($row->status==1) echo "Draft";
                              elseif($row->status==2) echo "Pending";
                              elseif($row->status==3) echo "Completed";
                              ?></td>
                              <td style="text-align:center">
                                <!-- Single button -->
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                    <i class="fa fa-gear tiny-icon"></i><span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu pull-right" role="menu">
                                    <li> <a href="<?php echo base_url()?>audit/selfa/loadExcel/<?php echo $row->master_id;?>" target="_blank">
                                      <i class="fa fa-eye tiny-icon"></i>View</a></li>
                                      <?php $date=date('Y-m-d');
                                      if($row->status==2&&$row->start_date<=$date&&$row->end_date>=$date){ ?>
                                      <li> <a href="<?php echo base_url()?>audit/selfa/edit/<?php echo $row->master_id;?>"><i class="fa fa-send tiny-icon"></i>GO</a></li>
                                      <?php } ?>
                                      <?php 
                                      if($row->status==2){ ?>
                                      <li> <a href="<?php echo base_url()?>audit/selfa/submit/<?php echo $row->master_id;?>"><i class="fa fa-send tiny-icon"></i>SUBMIT</a></li>
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
        Sorry, this Head can't be deleted!!
        </div>
      </div><!-- /.modal-content -->
    </div>
  </div>

<script>
$(document).ready (function(){
var count = 1

    $('.date').datepicker({
        "format": "dd/mm/yyyy",
        "todayHighlight": true,
        "autoclose": true
    });


//////////////
  ///////////////////  CHECK BEFOR DELETING ATTACHEMNT//////////////////////
$(".delete").click(function(e){
  job=confirm("Are you sure you want to delete this Head?");
   if(job==true){
  e.preventDefault();
  var rowId=$(this).data('pid');
  var url=$(this).attr("href");
  $.ajax({
   type:"GET",
   url:"<?php echo base_url();?>audit/schedule/checkDelete/"+rowId,
     success:function(data){
      if(data=="EXISTS"){
        $("#deleteMessage").modal("show");
      }else{
        location.href="<?php echo base_url();?>audit/schedule/delete/"+rowId;
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
