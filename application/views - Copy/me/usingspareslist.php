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
<a class="btn btn-sm btn-primary pull-right" style="margin-right:0px;" href="<?php echo base_url(); ?>me/usingspares/add">
<i class="fa fa-plus"></i>
Add Using
</a>
</div>
</div>
</div>
</div>
            <!-- /.box-header -->
        <div class="box-body">
           <form class="form-horizontal" action="<?php echo base_url();?>me/usingspares/lists" method="GET" enctype="multipart/form-data">
            <div class="form-group">
              <label class="col-sm-1 control-label">Location </label>
              <div class="col-sm-2">
                <select class="form-control select2" name="line_id" id="line_id">> 
              <option value="" selected="selected">===Select Location===</option>
              <?php foreach ($flist as $rows) { ?>
                <option value="<?php echo $rows->line_id; ?>" 
                <?php if (isset($info))
                    echo $rows->line_id == $info->line_id ? 'selected="selected"' : 0;
                else
                    echo $rows->line_id == set_value('line_id') ? 'selected="selected"' : 0;
                ?>><?php echo $rows->line_no; ?></option>
                    <?php } ?>
                </select>
              </div>
              <div class="col-sm-2">
                <input type="text" name="using_ref_no" class="form-control" placeholder="Ref. NO" value="<?php  echo set_value('using_ref_no'); ?>" autofocus>
              </div>
              <label class="col-sm-1 control-label">Date</label>
                <div class="col-sm-2">
                <input type="text" name="from_date" readonly="" class="form-control date" placeholder="From Date" value="<?php  echo set_value('from_date'); ?>">
              </div>
              <div class="col-sm-2">
                <input type="text" name="to_date" readonly="" class="form-control date" placeholder="To Date" value="<?php  echo set_value('to_date'); ?>">
              </div>
              <div class="col-sm-2">
              <button type="submit" class="btn btn-success pull-left"> Search 搜索 </button>
              <a class="btn btn-sm btn-primary pull-right" style="margin-right:0px;" href="<?php echo base_url(); ?>common/issued/lists">All</a>
            </div>
            </div>
             <!-- /.box-body -->
          </form>
        <div class="table-responsive table-bordered">
          <table id="example12" class="table table-bordered table-striped" style="width:100%;border:#000" >
            <thead>
            <tr>
              <th style="width:8%;">Date</th>
              <th style="width:8%;">Ref No</th>
              <th style="width:8%;">Location</th>
              <th style="width:20%;">Purpose of Use</th>
              <th style="text-align:center;width:10%">TPM CODE (TPM代码)</th>
              <th style="width:12%;">Requisition</th>
              <th style="width:12%;">ME Name</th>
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
                <td class="text-center"><?php echo findDate($row->use_date); ?></td>
                <td class="text-center"><?php echo $row->using_ref_no; ?></td>
                <td class="text-center"><?php echo $row->line_no; ?></td>
                <td><?php echo "$row->use_purpose";?></td>
                <td style="text-align:center">
                  <?php echo $row->asset_encoding; ; ?></td>
                <td class="text-center"><?php echo $row->requisition_no; ?></td>
                <td class="text-center"><?php echo $row->me_name; ?></td>
                <td class="text-center"><?php echo $row->user_name; ?></td>
                <td style="text-align:center">
                    <!-- Single button -->
                <div class="btn-group">
                    <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-gear tiny-icon"></i><span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu pull-right" role="menu">
                    <li> <a href="<?php echo base_url()?>me/usingspares/view/<?php echo $row->spares_use_id;?>" target="_blank"><i class="fa fa-eye tiny-icon"></i>View</a></li>
                      <li> <a href="<?php echo base_url()?>me/usingspares/edit/<?php echo $row->spares_use_id;?>"><i class="fa fa-edit tiny-icon"></i>Edit 编辑</a></li>
                        <?php if($this->session->userdata('delete')=='YES'){ ?>
                      <li><a href="#" class="delete" data-pid="<?php echo $row->spares_use_id;?>"><i class="fa fa-trash-o tiny-icon"></i>Delete 删除</a></li>
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
  location.href="<?php echo base_url();?>me/usingspares/delete/"+rowId;
}else{
  return false;
}
});
});//jquery ends here
</script>