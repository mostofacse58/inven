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
<a class="btn btn-sm btn-primary pull-right" style="margin-right:0px;" href="<?php echo base_url(); ?>wh/stockout/add">
<i class="fa fa-plus"></i>
Add 
</a>
<a class="btn btn-sm btn-primary pull-right" style="margin-right:0px;" href="<?php echo base_url(); ?>wh/stockout/addbulk">
<i class="fa fa-plus"></i>
Uplaod Excel 
</a>
</div>
</div>
</div>
</div>
            <!-- /.box-header -->
        <div class="box-body">
          <form class="form-horizontal" action="<?php echo base_url();?>wh/stockout/lists" method="GET" enctype="multipart/form-data">
           <div class="form-group">
              <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                <span class="info-box-icon bg-red"><i class="fa fa-th"></i></span>
                <div class="info-box-content">
                <span class="info-box-text">Waiting for Out</span>
                <span class="info-box-number">
                  <?php echo $waiting; ?> Pcs</span>
                </div>
                </div>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                <span class="info-box-icon bg-green"><i class="fa fa-th"></i></span>
                <div class="info-box-content">
                <span class="info-box-text">Already Out</span>
                <span class="info-box-number">
                  <?php echo $total-$waiting; ?> Pcs</span>
                </div>
                </div>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12" >
                  <div class="small-box bg-red" style="margin-top: -10px">
                  <div class="inner">
                  <h4>Total: <?php echo $total; ?> Pcs</h4>
                  <p>Dashboard</p>
                  </div>
                  <div class="icon">
                  <i class="ion ion-pie-graph"></i>
                  </div>
                  <a href="<?php echo base_url();?>wh/stockout/dashboard" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                  </div>
                  </div>
              </div>
              <div class="form-group">
              <label class="col-sm-1 control-label">Location </label>
              <div class="col-sm-2">
                <select class="form-control select2"  name="location" id="location">
                  <option value="">All Location</option>
                  <?php
                   foreach ($llist as $value) {  ?>
                    <option value="<?php echo $value->location; ?>"
                      <?php  echo set_select('location',$value->location); ?>>  <?php echo $value->location; ?></option>
                    <?php } ?>
                </select>
              </div>
              <div class="col-sm-2">
                <input type="text" name="barcode_no" class="form-control" placeholder="barcode no"  autofocus>
              </div>
              <div class="col-sm-2">
                <input type="text" name="po_no" class="form-control" placeholder="PO NO"  autofocus>
              </div>
              <div class="col-sm-2">
                <input type="text" name="export_invoice_no" class="form-control" placeholder="Invoice NO"  autofocus>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-1 control-label">Status </label>
              <div class="col-sm-2">
                <select class="form-control select2"  name="status" id="status">
                  <option value="All">All</option>
                  <option value="1">Waiting for Out</option>
                  <option value="2">OUT</option>
                                     
                </select>
              </div>
              
              <div class="col-sm-2">
              <button type="submit" class="btn btn-success pull-left"> Search 搜索 </button>
              <a class="btn btn-sm btn-primary pull-right" style="margin-right:0px;" href="<?php echo base_url(); ?>wh/stockout/lists">All</a>
            </div>
            
            </div>
             <!-- /.box-body -->
          </form>
        <div class="table-responsive table-bordered">
          <table id="example12" class="table table-bordered table-striped" style="width:100%;border:#000" >
            <thead>
            <tr>
              <th style="width:4%;">SN</th>
              <th style="width:8%;">CUSTOMER 顾客</th>
              <th style="width:10%;">FILE 文件</th>
              <th style="text-align:center;width:10%">PO NO 订单号</th>
              <th style="width:10%;">CARTON NO 纸箱编号</th>
              <th style="width:8%;">BAG QUANTITY 袋子数量</th>
              <th style="width:10%;text-align:center">FACTORY STYLE 工厂风格</th>
              <th style="text-align:center;width:10%">CUSTOMER STYLE 客户风格</th>
              <th style="width:8%;">COLOR 颜色</th>
              <th style="width:12%;">BARCODE NO 条形码编号</th>
              <th style="width:12%;">INVOICE NUMBER 发票编号 </th>
              <th style="width:8%;">OUT DOCUMENT NUMBER 出单号</th>
              <th style="width:8%;">LOCATION 地点</th>
              <th style="width:8%;">Date</th>
              <th style="width:8%;">Status</th>
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
                <td><?php echo $row->customer; ?></td>
                <td class="text-center"><?php echo $row->file_no; ?></td>
                <td class="text-center"><?php echo $row->po_no; ?></td>
                <td class="text-center"><?php echo $row->carton_no; ?></td>
                <td class="text-center"><?php echo $row->bag_qty; ?></td>
                <td class="text-center"><?php echo $row->factory_style; ?></td>
                <td class="text-center"><?php echo $row->customer_syle; ?></td>
                <td class="text-center"><?php echo $row->color; ?></td>
                <td class="text-center"><?php echo $row->barcode_no; ?></td>
                <td class="text-center"><?php echo $row->export_invoice_no; ?></td>
                <td class="text-center"><?php echo $row->out_document_no; ?></td>
                <td class="text-center"><?php echo $row->location; ?></td>
                <td class="text-center">
                  <?php echo findDate($row->create_date); ?></td>
                <td class="text-center">
                <span class="btn btn-xs btn-<?php echo ($row->out_status==1)?"danger":"success";?>">
                  <?php 
                    if($row->out_status==1) echo "Waiting for Out";
                    elseif($row->out_status==2) echo "Out";
                    ?>
                </span></td>
                <td style="text-align:center">
                    <!-- Single button -->
                <div class="btn-group">
                    <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-gear tiny-icon"></i><span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu pull-right" role="menu">
                    <!-- <li> <a href="<?php echo base_url()?>wh/stockout/view/<?php echo $row->id;?>" target="_blank"> -->
                      <!-- <i class="fa fa-eye tiny-icon"></i>View</a></li> -->
                      <?php if($row->out_status==1){ ?>
                      <li> <a href="<?php echo base_url()?>wh/stockout/edit/<?php echo $row->id;?>">
                        <i class="fa fa-edit tiny-icon"></i>Edit 编辑</a></li>
                        <?php if($this->session->userdata('delete')=='YES'){ ?>
                      <li><a href="#" class="delete" data-pid="<?php echo $row->id;?>"><i class="fa fa-trash-o tiny-icon"></i>Delete 删除</a></li>
                    <?php } ?>
                  <?php } ?>
                      <!--  <li> <a href="<?php echo base_url()?>wh/stockout/returnback/<?php echo $row->id;?>">
                        <i class="fa fa-arrow-left tiny-icon"></i>Return Back</a></li> -->
                    
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
<style>
  .small-box > .inner {
  padding: 0px 10px;
}
.small-box .icon {
  font-size: 56px;
}
</style>

<script>
$(document).ready (function(){
  ///////////////////  CHECK BEFOR DELETING ATTACHEMNT//////////////////////
$(".delete").click(function(e){
  job=confirm("Are you sure you want to delete this Information?");
   if(job==true){
  e.preventDefault();
  var rowId=$(this).data('pid');
  location.href="<?php echo base_url();?>wh/stockout/delete/"+rowId;
}else{
  return false;
}
});
});//jquery ends here
</script>