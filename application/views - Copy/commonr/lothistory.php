<script src="<?php echo base_url('asset/js/plugins/datepicker/bootstrap-datepicker.js'); ?>"></script>
<script>
$(document).ready(function(){
   $('.date').datepicker({
        "format": "dd/mm/yyyy",
        "todayHighlight": true,
        "autoclose": true
    });
  });
</script>
<style type="text/css">
.colortd td{background-color:#FFF; }
</style>
<div class="row">
<div class="col-xs-12">
 <div class="box box-primary">
    <div class="box-header">
    <div class="widget-block">
           
<div class="widget-head">
<h5><i class="fa fa-file-excel-o" aria-hidden="true"></i>
<?php echo ucwords($heading); ?></h5>
<div class="widget-control pull-right">
<?php if(isset($resultdetail)){ ?>
 <a class="btn btn-sm btn-primary pull-right" style="margin-right:0px;" href="<?php echo base_url(); ?>commonr/lothistory/downloadExcel<?php 
 if($product_code!='') echo "/$product_code"; else echo "/All"; 
 if($LOCATION!='') echo "/$LOCATION"; else echo "/All";
 if($po_no!='') echo "/$po_no"; else echo "/All";
 if($FIFO_CODE!='') echo "/$FIFO_CODE"; else echo "/All"; 
 echo "/$from_date/$to_date";  ?>">
<i class="fa fa-file-excel-o"></i>
Download Excel
</a>
<!--<a class="btn btn-sm btn-primary pull-right" style="margin-right:0px;" href="<?php echo base_url(); ?>commonr/lothistory/downloadPdf<?php //echo "/$category_id/$rack_id/$box_id/$department_id/$product_code";  ?>">
<i class="fa fa-file-pdf-o"></i>
Download PDF
</a> -->
<?php } ?>
</div>
</div>
</div>

</div>
<div class="box box-info">
    <!-- form start -->
    <form class="form-horizontal" action="<?php echo base_url();?>commonr/lothistory/reportrResult" method="POST" enctype="multipart/form-data">
      <div class="box-body">
        <div class="form-group">
          <label class="col-sm-1 control-label">
          Item Code<span style="color:red;">  </span></label>
          <div class="col-sm-2">
            <input class="form-control" name="product_code" id="product_code" value="<?php echo set_value('product_code'); ?>">
          <span class="error-msg"><?php echo form_error("product_code");?></span>
          </div>
          <label class="col-sm-1 control-label">
          Location<span style="color:red;">  </span></label>
          <div class="col-sm-2">
            <input class="form-control" name="LOCATION" id="LOCATION" value="<?php echo set_value('LOCATION'); ?>" >
          <span class="error-msg"><?php echo form_error("LOCATION");?></span>
          </div>
          <label class="col-sm-1 control-label">
          PO/WO<span style="color:red;">  </span></label>
          <div class="col-sm-2">
            <input class="form-control" name="po_no" id="po_no" value="<?php echo set_value('po_no'); ?>">
          <span class="error-msg"><?php echo form_error("po_no");?></span>
          </div>
          <label class="col-sm-1 control-label">
          Lot No<span style="color:red;">  </span></label>
          <div class="col-sm-2">
            <input class="form-control" name="FIFO_CODE" id="FIFO_CODE" value="<?php echo set_value('FIFO_CODE'); ?>">
          <span class="error-msg"><?php echo form_error("FIFO_CODE");?></span>
          </div>
        </div>
      <div class="form-group">
        <label class="col-sm-1 control-label">
          Entry Date<span style="color:red;">  </span></label>
          <div class="col-sm-2">
            <input class="form-control date" readonly name="from_date" id="from_date" value="<?php echo set_value('from_date'); ?>">
          <span class="error-msg"><?php echo form_error("from_date");?></span>
          </div>
          <label class="col-sm-1 control-label">
          To<span style="color:red;">  </span></label>
          <div class="col-sm-2">
            <input class="form-control date" readonly name="to_date" id="to_date" value="<?php echo set_value('to_date'); ?>">
          <span class="error-msg"><?php echo form_error("to_date");?></span>
          </div>
        <div class="col-sm-2">
        <button type="submit" class="btn btn-info pull-left">Search 搜索</button>
        </div>
        </div>
      </div>
      <!-- /.box-body -->
    </form>
    <!-- /////////////////////////////////// -->
    <div class="table-responsive table-bordered">
            <table class="table table-bordered table-striped colortd" style="width:99%;border:#000" >
              <thead>
            <tr>
                <th style="text-align:center;width:4%;">SN</th>
                <th style="text-align:center;width:7%">Lot No</th>
                <th style="text-align:center;width:7%">TRX TYPE</th>
                <th style="text-align:center;width:10%">Date</th>
                <th style="text-align:center;width:7%">REF. No</th>
                <th style="text-align:center;width:10%">Supplier</th>
                <th style="text-align:center;width:8%">Quantity</th>
                <th style="text-align:center;width:5%">Unit</th>
                <th style="text-align:center;width:8%">U Cost</th>
                <th style="text-align:center;width:8%">Total Amt</th>
                <th style="text-align:center;width:8%">Currency</th>
                <th style="text-align:center;width:10%">Item Code 项目代码</th>
                <th style="width:15%;">Item/Materials Name</th>
                <th style="text-align:center;width:8%">Location</th>
            </tr>
            </thead>
            <tbody>
            <?php $totalbalance=0; $totalvalue=0;$grandpi=0;
            if(isset($resultdetail)&&!empty($resultdetail)): $i=1;
              foreach($resultdetail as $row):
                if($i==1) $FIFO_CODE=$row->FIFO_CODE;

                if($row->FIFO_CODE==$FIFO_CODE){
                $stock=$row->QUANTITY;
                $totalbalance=$totalbalance+$stock;
                ?>
                <tr>
                  <td style="text-align:center;">
                    <?php echo $i++; ?></td>
                  <td style="text-align:center;">
                    <?php echo $row->FIFO_CODE; ?></td>
                  <td style="text-align:center;">
                    <?php echo $row->TRX_TYPE; ?></td>
                  <td style="vertical-align: text-top;text-align:center;">
                  <?php  echo $row->INDATE; ?></td> 
                  <td style="text-align:center;">
                    <?php echo $row->REF_CODE; ?></td> 
                  <td></td>
                  <td style="vertical-align: text-top;text-align:center;">
                  <?php  echo "$stock"; ?></td>
                  <td style="vertical-align: text-top;text-align:center;">
                  <?php  echo "$row->unit_name"; ?></td>
                  <td style="vertical-align: text-top;text-align:center;">
                  <?php  echo $row->UPRICE; ?></td>
                  <td style="vertical-align: text-top;text-align:center;">
                  <?php  echo $stock*$row->UPRICE; ?></td>
                  <td style="vertical-align: text-top;text-align:center;">
                  <?php  echo $row->CRRNCY; ?></td>
                  <td style="text-align:center;">
                    <?php echo $row->product_code; ?></td>
                  <td style=""><?php echo $row->product_name;?></td>                  
                  <td style="text-align:center;">
                    <?php echo $row->LOCATION;  ?></td>
                </tr>
                <?php
                  }else{  
                ?>
                <tr>
                  <td style="text-align:right;background-color: #CCD1D1" colspan="6">
                    Balance</td>
                  <td style="vertical-align: text-top;text-align:center;background-color: #CCD1D1">
                  <?php  echo number_format($totalbalance,2);  ?></td>
                  <td style="vertical-align: text-top;text-align:center;background-color: #CCD1D1"  colspan="7"></td>
                </tr>
                <?php 
                 $totalbalance=0; 
                 $stock=$row->QUANTITY;
                 $totalbalance=$totalbalance+$stock;
                 $FIFO_CODE=$row->FIFO_CODE
                 ?>
                 <tr>
                  <td style="text-align:center;">
                    <?php echo $i++; ?></td>
                  <td style="text-align:center;">
                    <?php echo $row->FIFO_CODE; ?></td>
                  <td style="text-align:center;">
                    <?php echo $row->TRX_TYPE; ?></td>
                  <td style="vertical-align: text-top;text-align:center;">
                  <?php  echo $row->INDATE; ?></td> 
                  <td style="text-align:center;">
                    <?php echo $row->REF_CODE; ?></td> 
                  <td></td>
                  <td style="vertical-align: text-top;text-align:center;">
                  <?php  echo "$stock"; ?></td>
                  <td style="vertical-align: text-top;text-align:center;">
                  <?php  echo "$row->unit_name"; ?></td>
                  <td style="vertical-align: text-top;text-align:center;">
                  <?php  echo $row->UPRICE; ?></td>
                  <td style="vertical-align: text-top;text-align:center;">
                  <?php  echo $stock*$row->UPRICE; ?></td>
                  <td style="vertical-align: text-top;text-align:center;">
                  <?php  echo $row->CRRNCY; ?></td>
                  <td style="text-align:center;">
                    <?php echo $row->product_code; ?></td>
                  <td style=""><?php echo $row->product_name;?></td>                  
                  <td style="text-align:center;">
                    <?php echo $row->LOCATION;  ?></td>
                </tr>
            <?php 
             }
              endforeach;
            endif;
            ?>
            <tr>
            <td style="text-align:right;background-color: #CCD1D1" colspan="6">
              Balance</td>
            <td style="vertical-align: text-top;text-align:center;background-color:  #CCD1D1">
            <?php  echo  number_format($totalbalance,2);  ?></td>
            <td style="vertical-align: text-top;text-align:center;background-color: #CCD1D1"  colspan="7"></td>
          </tr>
            </tbody>
            </table>
          </div>
  </div>
    <!-- /.box-header -->

    <!-- /.box-body -->
  </div>
</div>
</div>
