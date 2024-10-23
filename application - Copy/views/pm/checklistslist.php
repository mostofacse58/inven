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
<a class="btn btn-sm btn-primary pull-right" style="margin-right:0px;" href="<?php echo base_url(); ?>pm/checklists/addFile">
<i class="fa fa-cloud-upload"></i>
Upload
</a> 
&nbsp;&nbsp;&nbsp;
<a class="btn btn-sm btn-primary pull-right" style="margin-right:0px;" href="<?php echo base_url(); ?>pm/checklists/add">
<i class="fa fa-plus"></i>
Add
</a>&nbsp;&nbsp;&nbsp;
</div>
</div>
</div>
</div>
            <!-- /.box-header -->
        <div class="box-body">
          <form class="form-horizontal" action="<?php echo base_url();?>pm/checklists/lists" method="GET" enctype="multipart/form-data">
            <div class="form-group">
              <label class="col-sm-2 control-label">Asset Model No </label>
              <div class="col-sm-2">
                <input type="text" name="model_no" class="form-control" placeholder="Search 搜索 Model no" value="<?php  echo set_value('model_no'); ?>" autofocus>
              </div>
              <label class="col-sm-2 control-label">Check Name </label>
              <div class="col-sm-3">
                <input type="text" name="work_name" class="form-control" placeholder="Search Name" value="<?php  echo set_value('work_name'); ?>" autofocus>
              </div>
            
              <div class="col-sm-2">
              <button type="submit" class="btn btn-success pull-left"> Search 搜索 </button>
              <a class="btn btn-sm btn-primary pull-right" style="margin-right:0px;" href="<?php echo base_url(); ?>pm/checklists/lists">All</a>
            </div>
            </div>
             <!-- /.box-body -->
          </form>
        <div class="table-responsive table-bordered">
          <table id="example12" class="table table-bordered table-striped" style="width:100%;border:#000" >
            <thead>
            <tr>
              <th style="width:4%;">SN</th>
              <th style="width:30%;">Model/Category</th>
              <th style="width:50%;">Name</th>
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
                <td class="text-center"><?php echo "$row->model_no $row->category_name"; ?></td>
                <td><?php echo $row->check_name;?></td>
                <td style="text-align:center">
                    <!-- Single button -->
                <div class="btn-group">
                    <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-gear tiny-icon"></i><span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu pull-right" role="menu">
                      <li> <a href="<?php echo base_url()?>pm/checklists/edit/<?php echo $row->id;?>">
                        <i class="fa fa-edit tiny-icon"></i>Edit 编辑</a></li>
                      <?php if($this->session->userdata('delete')=='YES'){ ?>
                      <li><a href="#" class="delete" data-pid="<?php echo $row->id;?>">
                        <i class="fa fa-trash-o tiny-icon"></i>Delete 删除</a></li>
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
      location.href="<?php echo base_url();?>pm/checklists/delete/"+rowId;
    }else{
      return false;
    }
  });
});//jquery ends here
</script>