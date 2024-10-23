<div class="row">
        <div class="col-xs-12">
   <div class="box box-primary">
            <div class="box-header">
              <div class="widget-block">
             
<div class="widget-head">
<h5><?php echo ucwords($heading); ?></h5>
<div class="widget-control pull-right">
<a class="btn btn-sm btn-primary pull-right" style="margin-right:0px;" href="<?php echo base_url(); ?>psubmit/add">
<i class="fa fa-plus"></i>
Submit Request
</a>
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
                          <li> <a href="<?php echo base_url()?>psubmit/view/<?php echo $row->project_id;?>">
                            <i class="fa fa-eye tiny-icon"></i>View </a></li>
                          <?php if($row->project_status==1){  ?>
                          <li> <a href="<?php echo base_url()?>psubmit/submit/<?php echo $row->project_id;?>"><i class="fa fa-edit tiny-icon"></i>Submit </a></li>
                          <li> <a href="<?php echo base_url()?>psubmit/edit/<?php echo $row->project_id;?>"><i class="fa fa-edit tiny-icon"></i>Edit 编辑</a></li>
                            <?php if($this->session->userdata('delete')=='YES'){ ?>
                          <li><a href="#"  class="delete" data-pid="<?php echo $row->project_id;?>"><i class="fa fa-trash-o tiny-icon"></i>Delete 删除</a></li>
                        <?php } ?>
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
 
<script>
$(document).ready (function(){
  ///////////////////  CHECK BEFOR DELETING ATTACHEMNT//////////////////////
$(".delete").click(function(e){
  job=confirm("Are you sure you want to delete this Project?");
   if(job==true){
    location.href="<?php echo base_url();?>psubmit/delete/"+rowId;
  }
});
});//jquery ends here
</script>
