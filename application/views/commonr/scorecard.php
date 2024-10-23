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
      <a class="btn btn-sm btn-primary pull-right" style="margin-right:0px;" href="<?php echo base_url(); ?>commonr/scorecard/downloadExcel<?php 
       if($supplier_id!='') echo "/$supplier_id"; else echo "/All"; 
       if($po_number!='') echo "/$po_number"; else echo "/All";
       echo "/$from_date/$to_date";  ?>">
      <i class="fa fa-file-excel-o"></i>
      Download Excel
      </a>
      <?php } ?>
      </div>
    </div>
  </div>
</div>
<div class="box box-info">
    <!-- form start -->
    <form class="form-horizontal" action="<?php echo base_url();?>commonr/scorecard/reportrResult" method="POST" enctype="multipart/form-data">
      <div class="box-body">
        <div class="form-group">
          <label class="col-sm-2 control-label">Supplier Name  <span style="color:red;">  *</span></label>
           <div class="col-sm-4">
            <select class="form-control select2" name="supplier_id" id="supplier_id">
              <option value="All" <?php echo 'All'==set_value('supplier_id')? 'selected="selected"':0; ?>>All</option>
              <?php foreach($slist as $rows){  ?>
              <option value="<?php echo $rows->supplier_id; ?>" 
                <?php echo $rows->supplier_id==set_value('supplier_id')? 'selected="selected"':0; ?>>
                 <?php echo $rows->supplier_name; ?></option>
              <?php }  ?>
            </select>
          </div>
          <label class="col-sm-1 control-label">
          PO/WO<span style="color:red;">  </span></label>
          <div class="col-sm-2">
            <input class="form-control" name="po_number" id="po_number" value="<?php echo set_value('po_number'); ?>">
          <span class="error-msg"><?php echo form_error("po_number");?></span>
          </div>
        </div>
      <div class="form-group">
        <label class="col-sm-2 control-label">
          From Date<span style="color:red;">  </span></label>
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
                <th style="text-align:center;width:10%">SUPPLIER NAME</th>
                <th style="width:15%;">WORK ORDER</th>
                <th style="text-align:center;width:10%">DELIVERY (Weight=40%)</th>
                <th style="text-align:center;width:10%">QUALITY (Weight=40%)</th>
                <th style="text-align:center;width:10%">PO ACK (Weight=10%)</th>
                <th style="text-align:center;width:10%">PAYMENT_TERMS (Weight=10%)</th>
                <th style="text-align:center;width:10%">SCORE</th>
            </tr>
            </thead>
            <tbody>
            <?php 
            $grandtotal=0;  
            $counts=0;
            $delivery_rate=0;
            $qualityrate=0;
            $payment_term_rate=0;
            $resposive_rate=0;
            if(isset($resultdetail)&&!empty($resultdetail)): 
              $i=1;
              foreach($resultdetail as $row){
                $counts++;
                $deliveryrate=$this->scorecard_model->getDelivery($row->po_number);
                $paymenttermrate=$this->scorecard_model->getPayment($row->po_number);
                $quality_rate=$this->scorecard_model->getQuality($row->po_number);

                $delivery_rate=$delivery_rate+$deliveryrate;
                $payment_term_rate=$payment_term_rate+$paymenttermrate;
                $qualityrate=$qualityrate+$quality_rate;
                
                $d1= new DateTime("$row->approved_date_time"); // first date
                $d2= new DateTime("$row->acknow_date_time"); // second date
                $interval= $d1->diff($d2); // get difference between two dates
                $hours=($interval->days * 24) + $interval->h;
                if($hours<=12) $rrate=5;
                elseif($hours>12&&$hours<=24) $rrate=4;
                elseif($hours>24&&$hours<=36) $rrate=3;
                elseif($hours>36&&$hours<=48) $rrate=2;
                else $rrate=1;
                $resposive_rate=$resposive_rate+$rrate;
                /////////////////////////////////////
                ?>
                <tr>
                  <td style="text-align:center;">
                    <?php echo $i++; ?></td>
                  <td style=""><?php echo $row->supplier_name;?></td>
                  <td style="text-align:center;">
                    <?php echo $row->po_number; ?></td>
                  <td style="text-align:center;">
                    <?php echo $deliveryrate;  ?></td>
                  <td style="text-align:center;">
                    <?php echo $quality_rate;  ?></td> 
                  <td style="text-align:center;">
                    <?php echo $rrate;  ?></td> 
                  <td style="vertical-align: text-top;text-align:center;">
                  <?php  echo $paymenttermrate; ?></td>
                  <td style="vertical-align: text-top;text-align:center;">
                  <?php  
                    $total=($deliveryrate*40)/100+($quality_rate*40)/100+($rrate*10)/100+($paymenttermrate*10)/100;
                    echo $total;
                    $grandtotal=$grandtotal+$total;
                    /////////////////////////////////
                  ?>
                  </td>
                </tr>
                <?php
              }
            
            ?>
            <tr>
              <th style="text-align:right;" colspan="3">Average</th>
              <th style="text-align:center;">
                <?php echo number_format($delivery_rate*40/(100*$counts),2); ?> 
              </th>
              <th style="text-align:center;">
                <?php echo number_format($qualityrate*40/(100*$counts),2); ?> 
              </th>
              <th style="text-align:center;">
                <?php echo number_format($resposive_rate*10/(100*$counts),2); ?> 
              </th>
              <th style="text-align:center;">
                <?php echo number_format($payment_term_rate*10/(100*$counts),2); ?> 
              </th>
              <th style="text-align:center;">
                <?php echo number_format($grandtotal/$counts,2); ?>
              </th>
             </tr>
             <?php endif; ?>
            </tbody>
            </table>
          </div>
  </div>
    <!-- /.box-header -->

    <!-- /.box-body -->
  </div>
</div>
</div>
