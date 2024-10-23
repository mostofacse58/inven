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
<a class="btn btn-sm btn-primary pull-right" style="margin-right:0px;" href="<?php echo base_url(); ?>common/adjustment/add">
<i class="fa fa-plus"></i>
Add Adjustment
</a>
</div>
</div>
</div>
</div>
            <!-- /.box-header -->
        <div class="box-body">
          <form class="form-horizontal" action="<?php echo base_url();?>common/adjustment/lists" method="GET" enctype="multipart/form-data">
            <div class="form-group">
              <label class="col-sm-3 control-label">Iteam Code物料编码/Name 名称</label>
                <div class="col-sm-3">
                  <input type="text" name="product_code" class="form-control" placeholder="Item Code 项目代码/NAME" value="<?php  echo set_value('product_code'); ?>" autofocus>
                </div>
              <div class="col-sm-2">
                <input type="text" name="employee_id" class="form-control" placeholder="Search 搜索 ID NO" value="<?php  echo set_value('employee_id'); ?>" autofocus>
              </div>
            </div>
              <div class="form-group">
              <label class="col-sm-1 control-label">Date</label>
                <div class="col-sm-2">
                <input type="text" name="from_date" readonly="" class="form-control date" placeholder="From Date" value="<?php  echo set_value('from_date'); ?>">
              </div>
              <div class="col-sm-2">
                <input type="text" name="to_date" readonly="" class="form-control date" placeholder="To Date" value="<?php  echo set_value('to_date'); ?>">
              </div>
              <div class="col-sm-3">
              <button type="submit" class="btn btn-success pull-left"> Search 搜索 </button>
              <a class="btn btn-sm btn-primary pull-right" style="margin-right:0px;" href="<?php echo base_url(); ?>common/adjustment/lists">All</a>
            </div>
            </div>
             <!-- /.box-body -->
          </form>
        <div class="table-responsive table-bordered">
          <table id="example12" class="table table-bordered table-striped" style="width:100%;border:#00" >
            <thead>
            <tr>
              <th style="width:4%;">SN</th>
              <th style="width:6%;">Date</th>
              <th style="width:10%;">Department</th>
              <th style="width:20%;text-align:center">Product Name</th>
              <th style="text-align:center;width:10%">Item Code</th>
              <th style="width:6%;">Adjustment Qty</th>
              <th style="width:6%;">Unit Price</th>
              <th style="width:6%;">FIFO</th>
              <th style="text-align:center;width:5%;">Actions 行动</th>
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
                <td class="text-center">
                  <?php echo findDate($row->INDATE); ?></td>
                <td class="text-center">
                  <?php echo $row->department_name; ?></td>
                <td style="text-align:center">
                <?php echo $row->product_name; ?></td>
                <td style="text-align:center">
                  <?php echo $row->ITEM_CODE; ?></td>
                <td class="text-center"><?php echo $row->QUANTITY; ?></td>
                <td class="text-center"><?php echo $row->UPRICE; ?></td>
                <td style="text-align:center">
                  <?php echo $row->FIFO_CODE;  ?></td>
                <td style="text-align:center">
                <div class="btn-group">
                    <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-gear tiny-icon"></i><span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu pull-right" role="menu">
                    <?php if($this->session->userdata('delete')=='YES'){ ?>
                      <li><a href="#" class="delete" data-pid="<?php echo $row->adjustment_id;?>"><i class="fa fa-trash-o tiny-icon"></i>Delete 删除</a></li>
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
  location.href="<?php echo base_url();?>common/adjustment/delete/"+rowId;
}else{
  return false;
}
});
});//jquery ends here
</script>