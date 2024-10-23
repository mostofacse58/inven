<div class="row">
        <div class="col-xs-12">
   <div class="box box-primary">
            <div class="box-header">
              <div class="widget-block">
             
<div class="widget-head">
<h5><?php echo ucwords($heading); ?></h5>
<div class="widget-control pull-right">
<a class="btn btn-sm btn-primary pull-right" style="margin-right:0px;" href="<?php echo base_url(); ?>medical/issued/add">
<i class="fa fa-plus"></i>
Add Issue
</a>
</div>
</div>
</div>
</div>
            <!-- /.box-header -->
        <div class="box-body">
          <form class="form-horizontal" action="<?php echo base_url();?>medical/issued/lists" method="GET" enctype="multipart/form-data">
            <div class="form-group">
              <label class="col-sm-1 control-label">Location </label>
              <div class="col-sm-3">
                <select class="form-control select2"  name="location_id" id="location_id">
                  <option value="">All Location</option>
                  <?php
                   foreach ($llist as $value) {  ?>
                    <option value="<?php echo $value->location_id; ?>"
                      <?php  echo set_select('location_id',$value->location_id); ?>>  <?php echo $value->location_name; ?></option>
                    <?php } ?>
                </select>
              </div>
              <div class="col-sm-6">
                <input type="text" name="employee_name" class="form-control" placeholder="Search 搜索 ID NO" value="<?php  echo set_value('employee_name'); ?>" autofocus>
              </div>
              <div class="col-sm-2">
              <button type="submit" class="btn btn-success pull-left"> Search 搜索 </button>
              <a class="btn btn-sm btn-primary pull-right" style="margin-right:0px;" href="<?php echo base_url(); ?>medical/issued/lists">All</a>
            </div>
            </div>

              <!-- /.box-body -->
            </form>
        <div class="table-responsive table-bordered">
          <table class="table table-bordered table-striped" style="width:100%;border:#00" >
            <thead>
            <tr>
              <th style="width:8%;">For</th>
              <th style="width:8%;">Date</th>
              <th style="width:8%;">Department</th>
              <th style="width:20%;">Emp. ID</th>
              <th style="width:6%;text-align:center">Location</th>
              <th style="width:8%;">Total Qty</th>
              <th style="width:12%;">Issued By</th>
              <th style="text-align:center;width:5%;">Actions 行动</th>
          </tr>
          </thead>
          <tbody>
          <?php
          if($list&&!empty($list)):
            foreach($list as $row):
                ?>
              <tr>
                <td><?php if($row->issue_type==1) echo "Department"; elseif($row->issue_type==2) echo "Employee"; else echo "Location"; ?></td>

                <td class="text-center">
                  <?php echo findDate($row->issue_date); ?></td>
                <td class="text-center"><?php echo $row->department_name; ?></td>
                <td class="text-center">
                  <?php echo "$row->employee_id"; ?></td>
                  <td style="text-align:center">
                <?php echo $row->location_name; ?></td>
                <td class="text-center"><?php echo $row->totalquantity; ?></td>
                <td class="text-center"><?php echo $row->user_name; ?></td>
                <td style="text-align:center">
                    <!-- Single button -->
                <div class="btn-group">
                    <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-gear tiny-icon"></i><span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu pull-right" role="menu">
                    <li> <a href="<?php echo base_url()?>medical/issued/view/<?php echo $row->issue_id;?>" target="_blank">
                      <i class="fa fa-eye tiny-icon"></i>View</a></li>
                      <li> <a href="<?php echo base_url()?>medical/issued/edit/<?php echo $row->issue_id;?>">
                        <i class="fa fa-edit tiny-icon"></i>Edit 编辑</a></li>
                        <?php if($this->session->userdata('delete')=='YES'){ ?>
                      <li><a href="#" class="delete" data-pid="<?php echo $row->issue_id;?>"><i class="fa fa-trash-o tiny-icon"></i>Delete 删除</a></li>
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
  location.href="<?php echo base_url();?>medical/issued/delete/"+rowId;
}else{
  return false;
}
});
});//jquery ends here
</script>