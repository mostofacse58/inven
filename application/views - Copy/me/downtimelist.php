<div class="row">
        <div class="col-xs-12">
   <div class="box box-primary">
            <div class="box-header">
              <div class="widget-block">
             
<div class="widget-head">
<h5><?php echo ucwords($heading); ?></h5>
<div class="widget-control pull-right">
<a class="btn btn-sm btn-primary pull-right" style="margin-right:0px;" href="<?php echo base_url(); ?>me/downtime/addExcel">
<i class="fa fa-plus"></i>
Upload Excel
</a>
<a class="btn btn-sm btn-primary pull-right" style="margin-right:5px;" href="<?php echo base_url(); ?>me/downtime/add">
<i class="fa fa-plus"></i>
Add Machine Down Time
</a>
</div>
</div>
</div>
</div>
            <!-- /.box-header -->
            <div class="box-body">
              <form class="form-horizontal" action="<?php echo base_url();?>me/downtime/lists" method="POST" enctype="multipart/form-data">
              <div class="form-group">
                <label class="col-sm-3 control-label">TPM CODE (TPM代码)/Ventura CODE</label>
                <div class="col-sm-3">
                  <input type="text" name="tpm_serial_code" class="form-control" placeholder="TPM CODE (TPM代码)/Ventura CODE" value="<?php  echo set_value('tpm_serial_code'); ?>" autofocus>
                </div>
                <div class="col-sm-1">
                <button type="submit" class="btn btn-success pull-left"> Search 搜索 </button>
              </div>
              <div class="col-sm-1">
                <a class="btn btn-sm btn-primary pull-right" style="margin-right:0px;" href="<?php echo base_url(); ?>me/downtime/lists">All</a>
              </div>
              </div>
            </form>
            <div class="table-responsive table-bordered">
              <table id="" class="table table-bordered table-striped" style="width:100%;border:#00" >
                <thead>
                <tr>
                  <th style="text-align:center;width:4%">SN</th>
                  <th style="text-align:center;width:10%">Asset Name</th>
                  <th style="text-align:center;width:8%">TPM CODE (TPM代码)</th>
                  <th class="textcenter">Line Name</th>
                    <th class="textcenter">Date</th>
                    <th class="textcenter">Problem <br>Start Time</th>
                    <th class="textcenter">ME Response Time</th>
                    <th class="textcenter">Problem <br>End Time</th>
                    <th class="textcenter">Downtime <br> (In Minutes)</th>
                    <th class="textcenter">Problem</th>
                    <th class="textcenter">Actions 行动 Taken</th>
                    <th class="textcenter">Supervisor <br> Name</th>
                    <th class="textcenter">ME Name</th>
                    <th class="textcenter">Actions 行动</th>
              </tr>
              </thead>
              <tbody>
              <?php
              if($list&&!empty($list)):$i=1;
                foreach($list as $row):
                    ?>
                  <tr>
                    <td style="text-align:center">
                      <?php echo $i++;  ?></td>
                    <td><?php echo $row->product_name;?></td>
                    <td style="text-align:center">
                      <?php echo $row->tpm_serial_code;  ?></td>
                    <td class="textcenter"><?php echo   $row->line_no; ?></td>
                    <td class="textcenter"><?php echo findDate($row->down_date); ?></td>
                    <td class="textcenter">
                      <?php echo date("H:i:s A", strtotime($row->problem_start_time));  ?>
                    </td>
                    <td class="textcenter">
                      <?php echo date("H:i:s A", strtotime($row->me_response_time));  ?></td>
                    <td class="textcenter">
                      <?php echo date("H:i:s A", strtotime($row->problem_end_time));  ?>
                      </td>
                    <td class="textcenter"><?php echo $row->total_minuts; ?></td>
                    <td class="textcenter"><?php echo $row->problem_description; ?></td>
                    <td class="textcenter"><?php echo $row->action_taken; ?></td>
                    <td class="textcenter"><?php echo $row->supervisor_id; ?></td>
                    <td class="textcenter"><?php echo $row->me_id; ?></td>
                    <td style="text-align:center">
                        <!-- Single button -->
                    <div class="btn-group">
                        <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            <i class="fa fa-gear tiny-icon"></i><span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu pull-right" role="menu">
                          <li> <a href="<?php echo base_url()?>me/downtime/edit/<?php echo $row->machine_downtime_id;?>"><i class="fa fa-edit tiny-icon"></i>Edit 编辑</a></li>
                            <?php if($this->session->userdata('delete')=='YES'){ ?>
                          <li><a href="#" class="delete" data-pid="<?php echo $row->machine_downtime_id;?>"><i class="fa fa-trash-o tiny-icon"></i>Delete 删除</a></li>
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
   url:"<?php echo base_url();?>me/downtime/checkDelete 删除/"+rowId,
     success:function(data){
      if(data=="EXISTS"){
        $("#alertMessageHTML").html("Sorry, this information can't be deleted.!!");
        $("#alertMessagemodal").modal("show");
      }else{
        location.href="<?php echo base_url();?>me/downtime/delete/"+rowId;
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