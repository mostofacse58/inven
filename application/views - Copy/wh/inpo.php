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
<a class="btn btn-sm btn-primary pull-right" style="margin-right:0px;" href="<?php echo base_url(); ?>wh/stockin/add">
<i class="fa fa-plus"></i>
Add 
</a>
<a class="btn btn-sm btn-primary pull-right" style="margin-right:0px;" href="<?php echo base_url(); ?>wh/stockin/addbulk">
<i class="fa fa-plus"></i>
Uplaod Excel 
</a>
</div>
</div>
</div>
</div>
            <!-- /.box-header -->
        <div class="box-body">
          <div class="form-group">
            <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="info-box">
              <span class="info-box-icon bg-red"><i class="fa fa-th"></i></span>
              <div class="info-box-content">
              <span class="info-box-text">Waiting</span>
              <span class="info-box-number">
                <?php echo $waiting; ?> Pcs</span>
              </div>
              </div>
              </div>
              <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="info-box">
              <span class="info-box-icon bg-green"><i class="fa fa-th"></i></span>
              <div class="info-box-content">
              <span class="info-box-text">Already In</span>
              <span class="info-box-number">
                <?php echo $alreadyIn; ?> Pcs</span>
              </div>
              </div>
              </div>
              <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="info-box">
              <span class="info-box-icon bg-green"><i class="fa fa-th"></i></span>
              <div class="info-box-content">
              <span class="info-box-text">Total Carton</span>
              <span class="info-box-number">
                <?php echo $alreadyIn+$waiting; ?> Pcs</span>
              </div>
              </div>
              </div>
            </div>
          <div class="col-md-12 col-sm-12 col-xs-12" >
          <div class="table-responsive table-bordered">
          <table id="example1" class="table table-bordered table-striped" style="width:100%;border:#000" >
            <thead>
            <tr>
              <th style="width:4%;">SN</th>
              <th style="width:12%;">PO NO 订单号</th>
              <th style="text-align:center;width:10%">Total Pending Qty</th>
              <th style="text-align:center;width:10%">Total IN QTY</th>
              <th style="text-align:center;width:10%">Total Qty</th>
          </tr>
          </thead>
          <tbody>
          <?php
          if($list&&!empty($list)): 
            $i=1; $totalp=0; $totalc=0;
            foreach($list as $row):
              $totalp=$totalp+$row->pendingqty;
              $totalc=$totalc+$row->inqty;
                ?>
              <tr>
                <td style="text-align:center">
                <?php echo $i++; ?></td>
                <td class="text-center">
                  <!-- <a href="<?php echo base_url();?>wh/stockin/po/<?php echo $row->po_no; ?>"></a> -->
                  <?php echo $row->po_no; ?></td>
                <td class="text-center"><?php echo $row->pendingqty; ?></td>
                <td class="text-center"><?php echo $row->inqty; ?></td>
                <td class="text-center"><?php echo $row->pendingqty+$row->inqty; ?></td>
              </tr>
              <?php
              endforeach;
          endif;
          ?>
          <tr>
            <td style="text-align:center"></td>
            <td class="text-center">Grand Total</td>
            <td class="text-center"><?php echo $totalp; ?></td>
            <td class="text-center"><?php echo $totalc; ?></td>
            <td class="text-center"><?php echo $totalp+$totalc; ?></td>
          </tr>
          </tbody>
          </table>
     
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