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
<a class="btn btn-sm btn-primary pull-right" style="margin-right:0px;" href="<?php echo base_url(); ?>gatep/itemledger/resultPDF<?php echo "/$product_code";
if($from_date!=''&&$to_date!='') echo "/$from_date/$to_date";  ?>">
<i class="fa fa-plus"></i>
Download
</a>
<?php } ?>
</div>
</div>
</div>

</div>
<div class="box box-info">
      <!-- form start -->
      <form class="form-horizontal" action="<?php echo base_url();?>gatep/itemledger/searchResult" method="POST" enctype="multipart/form-data">
        <div class="box-body">
          <div class="form-group">
            <label class="col-sm-2 control-label">Product Code<span style="color:red;">  *</span></label>
            <div class="col-sm-2">
             <input type="text" name="product_code"   class="form-control"  placeholder="Code" value="<?php echo set_value('product_code'); ?>">                   
            <span class="error-msg"><?php echo form_error("product_code");?></span>
            </div>
            <label class="col-sm-2 control-label">From Date</label>
	          <div class="col-sm-2">
	              <input type="text" name="from_date"   class="form-control date" id="inputEmail3" placeholder="From Date" value="<?php echo set_value('from_date'); ?>">
	              <span class="error-msg"><?php echo form_error("from_date"); ?></span>
	          </div>
	           <label class="col-sm-2 control-label">To Date</label>
	          <div class="col-sm-2">
	              <input type="text" name="to_date"   class="form-control date" id="inputEmail3" placeholder="To Date" value="<?php echo set_value('to_date'); ?>">
	              <span class="error-msg"><?php echo form_error("to_date"); ?></span>
	          </div>
          </div>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
           <div class="col-sm-6"></div>
           <div class="col-sm-2">
          <button type="submit" class="btn btn-info pull-left">Result</button>
          </div>
        </div>
      </form>
      <!-- /////////////////////////////////// -->
<?php if(isset($resultdetail)){ ?>
	   <h3 align="center" style="margin:0;padding: 5px">
	   <b>Item Ledger </b></h3>
	 <?php if($from_date!=''){  ?>
	   <h4 align="center" style="margin:0;padding: 5px">
	   <b>
	From Date: <?php echo date("jS M-Y", strtotime("$from_date")); ?>
	  &nbsp;&nbsp;&nbsp;&nbsp; To Date: <?php echo date("jS M-Y", strtotime("$to_date"));  ?>
	</b></h4>
	<?php } ?>
      <div class="table-responsive table-bordered">
              <table class="table table-bordered table-striped" style="width:99%;border:#000" >
              <thead>
              <tr>
              <th style="text-align:center;width:5%;">SN</th>
              <th style="text-align:center;width:10%">Create Date</th>
              <th style="text-align:center;width:10%">In Date</th>
              <th style="text-align:center;width:10%">Gatepass No</th>
              <th style="width:15%;">Item/Materials Name</th>
              <th style="text-align:center;width:10%">Carried Name(ID)</th>
              <th style="text-align:center;width:8%">Out Qty</th>
              <th style="text-align:center;width:8%">In Qty</th>
              <th style="text-align:center;width:8%">Balance Qty</th>
              </tr>
              </thead>
              <tbody>
              <?php $balance=0;
              if(isset($resultdetail)&&!empty($resultdetail)): $i=1;
                foreach($resultdetail as $row):
                  if($row->type==1)
                  $balance=$balance+$row->product_quantity;
                  else $balance=$balance-$row->product_quantity;
                    ?>
                  <tr>
                    <td style="text-align:center;">
                    <?php echo $i++; ?></td>
                    <td style="text-align:center;">
                    <?php echo $row->create_date; echo " $row->create_time"; ?></td>
                    <td style="text-align:center;">
                    <?php echo $row->checkin_datetime; ?></td>
                    <td ><?php echo $row->gatepass_no;?></td>
                    <td style="text-align:center;">
                      <?php echo $row->product_name;  ?></td> 
                    <td style="vertical-align: text-top;text-align:center;">
                    <?php  echo "$row->carried_by ($row->employee_id)"; ?></td> 
                    <td style="text-align:center;">
                    <?php if($row->type==1) echo $row->product_quantity; else echo '';  ?></td>
                    <td style="text-align:center;">
                    <?php if($row->type==2) echo $row->product_quantity; else echo '';  ?></td>
                    <td style="text-align:center;">
                    <?php echo $balance; echo " $row->unit_name";  ?></td>
                  </tr>
                  <?php
                  endforeach;
              endif;
              ?>
              <tr>
                    <td style="text-align:right;" colspan="8">Total Balance</td>
                    <td style="text-align:center;">
                    <?php echo $balance;   echo " $row->unit_name";?></td>
                  </tr>
              </tbody>
              </table>
              </div>
              <?php } ?>
    </div>
    <!-- /.box-header -->
    </div>
  </div>
 </div>
