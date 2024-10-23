<script src="<?php echo base_url('asset/js/plugins/datepicker/bootstrap-datepicker.js'); ?>"></script>
<script type="text/javascript">
var count = 1
$(function () {
$(document).on('click','input[type=number]',function(){ this.select(); });
  $('.date').datepicker({
      "format": "yyyy-mm-dd",
      "todayHighlight": true,
      "autoclose": true
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
  &nbsp;&nbsp;&nbsp;
<a class="btn btn-sm btn-primary pull-right" style="margin-right:0px;" href="<?php echo base_url(); ?>pm/maintenance/addFile">
<i class="fa fa-cloud-upload"></i>
Upload
</a> 
&nbsp;&nbsp;&nbsp;
<a class="btn btn-sm btn-primary pull-right" style="margin-right:0px;" href="<?php echo base_url(); ?>pm/maintenance/add">
<i class="fa fa-plus"></i>
Add
</a>&nbsp;&nbsp;&nbsp;
</div>
</div>
</div>
</div>
            <!-- /.box-header -->
        <div class="box-body">
          <form class="form-horizontal" action="<?php echo base_url();?>pm/maintenance/lists" method="GET" enctype="multipart/form-data">
            <div class="form-group">
              <label class="col-sm-2 control-label">Asset Model No </label>
              <div class="col-sm-2">
                <input type="text" name="model_no" class="form-control" placeholder="Search 搜索 Model no" value="<?php  echo set_value('model_no'); ?>" autofocus>
              </div>
              <label class="col-sm-2 control-label">Asset CODE </label>
              <div class="col-sm-3">
                <input type="text" name="tpm_code" class="form-control" placeholder="Search CODE" value="<?php  echo set_value('tpm_code'); ?>" autofocus>
              </div>
            
              <div class="col-sm-2">
              <button type="submit" class="btn btn-success pull-left"> Search 搜索 </button>
              <a class="btn btn-sm btn-primary pull-right" style="margin-right:0px;" href="<?php echo base_url(); ?>pm/maintenance/lists">All</a>
            </div>
            </div>
             <!-- /.box-body -->
          </form>
        <div class="table-responsive table-bordered">
          <table id="example12" class="table table-bordered table-striped" style="width:100%;border:#000" >
            <thead>
            <tr>
              <th style="width:4%;">SN</th>
              <th style="width:6%;">PM Date</th>
              <th style="width:8%;">Asset CODE</th>
              <th style="width:20%;">Name</th>
              <th style="width:8%;">Model</th>
              <th style="width:6%;">Work Date</th>
              <th style="width:6%;">Spares Ref</th>
              <th style="width:6%;">Status</th>
              <th style="text-align:center;width:10%;">Actions 行动</th>
          </tr>
          </thead>
          <tbody>
          <?php
          if($list&&!empty($list)): $i=$page+1;
            foreach($list as $row):
                ?>
              <tr>
                <td style="text-align:center">
                <?php echo $i++; ?></td>
                <td class="text-center"><?php echo $row->pm_date; ?></td>
                <td class="text-center"><?php echo $row->tpm_code; ?></td>
                <td class="text-center"><?php echo $row->product_name; ?></td>
                <td class="text-center"><?php echo $row->model_no; ?></td>
                <td class="text-center"><?php echo $row->work_date; ?></td>
                <td class="text-center"><?php echo $row->sref_no; ?></td>
                <td class="text-center">
                  <span class="btn btn-xs btn-<?php echo ($row->pm_status=='Pending')?"danger":"success";?>">
                    <?php echo $row->pm_status; ?>
                  </span></td>
                <td style="text-align:center">
                    <!-- Single button -->
                <div class="btn-group">
                    <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-gear tiny-icon"></i><span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu pull-right" role="menu">
                      <?php if($row->pm_status=='Pending'){  ?>
                      <li> <a href="<?php echo base_url()?>pm/maintenance/planm/<?php echo $row->pm_id;?>">
                        <i class="fa fa-edit tiny-icon"></i>Plan Work</a></li>
                      <li> <a href="<?php echo base_url()?>pm/maintenance/edit/<?php echo $row->pm_id;?>">
                        <i class="fa fa-edit tiny-icon"></i>Edit 编辑</a></li>
                      <?php if($this->session->userdata('delete')=='YES'){ ?>
                      <li><a href="#" class="delete" data-pid="<?php echo $row->pm_id;?>">
                        <i class="fa fa-trash-o tiny-icon"></i>Delete 删除</a></li>
                      <?php } ?>
                      <?php } ?>

                      <li> <a href="<?php echo base_url()?>pm/maintenance/view/<?php echo $row->pm_id;?>">
                        <i class="fa fa-eye tiny-icon"></i>View</a></li>
             
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
      location.href="<?php echo base_url();?>pm/maintenance/delete/"+rowId;
    }else{
      return false;
    }
  });
});//jquery ends here
</script>