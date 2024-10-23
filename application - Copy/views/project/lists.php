<div class="row">
        <div class="col-xs-12">
   <div class="box box-primary">
            <div class="box-header">
              <div class="widget-block">
             
<div class="widget-head">
<h5><?php echo ucwords($heading); ?></h5>
<div class="widget-control pull-right">

</div>
</div></div>

            </div>
            <!-- /.box-header -->
            <div class="box-body">
            <div class="table-responsive table-bordered">
              <table id="example1" class="table table-bordered table-striped" style="width:100%;border:#00" >
                 <thead>
                <tr>
                  <th style="width:15%;">Project Name 供应商名称</th>
                  <th style="width:10%">Department</th>
                  <th style="text-align:center;width:6%">Type </th>
                  <th style="text-align:center;width:8%">Co-oridinator</th>
                  <th style="text-align:center;width:8%">Start Date </th>
                  <th style="text-align:center;width:8%">End Date </th>
                  <th style="width:8%;text-align:center">Develop By</th>
                  <th style="width:8%;text-align:center">Pririoty</th>
                  <th style="text-align:center;width:8%">MMTQ</th>
                  <th style="text-align:center;width:6%">Status </th>
                  <th  style="text-align:center;width:5%">Actions 行动</th>
              </tr>
              </thead>
              <tbody>
              <?php
              if($list&&!empty($list)):
                foreach($list as $row):
                    ?>
                  <tr>
                    <td><?php echo $row->project_name;?></td>
                    <td style="text-align:center">
                      <?php echo $row->department_name; ; ?></td>
                    <td style="text-align:center">
                      <?php echo $row->p_type; ; ?></td>
                    <td style="text-align:center">
                      <?php echo $row->project_coordinator; ; ?></td>
                    <td style="text-align:center">
                      <?php echo $row->start_date; ?></td>
                    <td style="text-align:center">
                      <?php echo $row->end_date; ?></td> 
                    <td style="text-align:center">
                      <?php echo $row->developed_by; ?></td> 
                    <td style="text-align:center">
                    <?php if($row->priority==1) echo "Low" ; 
                    elseif($row->priority==2) echo "Medium" ;
                    elseif($row->priority==3) echo "High";
                     ?></td>
                    <td style="text-align:center">
                    <?php echo "$row->manpower|$row->money|$row->times|$row->quality";  ?></td>
                    <td style="text-align:center">
                    <span class="btn btn-xs btn-<?php echo ($row->project_status<=2)?"danger":"success";?>">
                    <?php if($row->project_status==1) echo "Draft" ; 
                    elseif($row->project_status==2) echo "Submit" ;
                    elseif($row->project_status==3) echo "Received";
                    elseif($row->project_status==4) echo "Waiting";
                    elseif($row->project_status==5) echo "Progress";
                    elseif($row->project_status==6) echo "Completed";
                     ?></span>
                   </td>
                    <td style="text-align:center">
                    <div class="btn-group">
                        <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            <i class="fa fa-gear tiny-icon"></i><span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu pull-right" role="menu">
                          <li> <a href="<?php echo base_url()?>project/view/<?php echo $row->project_id;?>">
                            <i class="fa fa-eye tiny-icon"></i>View </a></li>
                          <?php if($row->project_status==2){  ?>
                          <li> <a href="<?php echo base_url()?>project/receive/<?php echo $row->project_id;?>"><i class="fa fa-edit tiny-icon"></i>Receive </a></li>
                        <?php } ?>
                        <li> <a href="<?php echo base_url()?>project/edit/<?php echo $row->project_id;?>"><i class="fa fa-edit tiny-icon"></i>Edit 编辑</a></li>
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
 
<script>
$(document).ready (function(){
  ///////////////////  CHECK BEFOR DELETING ATTACHEMNT//////////////////////
$(".delete").click(function(e){
  job=confirm("Are you sure you want to delete this Project?");
   if(job==true){
  e.preventDefault();
  var rowId=$(this).data('pid');
  var url=$(this).attr("href");
  $.ajax({
   type:"GET",
   url:"<?php echo base_url();?>project/checkProject/"+rowId,
     success:function(data){
      if(data=="EXISTS"){
        $("#alertMessageHTML").html("Sorry, this information can't be deleted.!!");
        $("#alertMessagemodal").modal("show");
      }else{
        location.href="<?php echo base_url();?>project/delete/"+rowId;
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
