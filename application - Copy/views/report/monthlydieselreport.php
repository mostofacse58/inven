<script src="<?php echo base_url('asset/js/plugins/datepicker/bootstrap-datepicker.js'); ?>"></script>
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
  <?php if(isset($resultdetail)&&!empty($resultdetail)){ ?>
<a class="btn btn-sm btn-primary pull-right" style="margin-right:0px;" href="<?php echo base_url(); ?>me/monthlydieselreport/downloadExcel<?php echo "/$motor_id/$fuel_using_dept_id/$driver_id/$from_date/$to_date";  ?>">
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
      <form class="form-horizontal" action="<?php echo base_url();?>me/monthlydieselreport/reportrResult" method="POST" enctype="multipart/form-data">
        <div class="box-body">
          <div class="form-group">
            <label class="col-sm-2 control-label">Vehicle <span style="color:red;">  *</span></label>
            <div class="col-sm-3">
              <select class="form-control" name="motor_id" id="motor_id">
              <option value="All">All</option>
              <?php foreach($mlist as $rows){  ?>
              <option value="<?php echo $rows->motor_id; ?>" 
                <?php echo $rows->motor_id==set_value('motor_id')? 'selected="selected"':0; ?>>
                 <?php echo $rows->motor_name; ?></option>
              <?php }  ?>
            </select>                    
            <span class="error-msg"><?php echo form_error("motor_id");?></span>
          </div>
          <label class="col-sm-2 control-label">Department <span style="color:red;">  *</span></label>
          <div class="col-sm-3">
              <select class="form-control" name="fuel_using_dept_id" id="fuel_using_dept_id">
              <option value="All">All</option>
              <?php foreach($dlist as $rows){  ?>
              <option value="<?php echo $rows->fuel_using_dept_id; ?>" 
                <?php echo $rows->fuel_using_dept_id==set_value('fuel_using_dept_id')? 'selected="selected"':0; ?>>
                 <?php echo $rows->fuel_using_dept_name; ?></option>
              <?php }  ?>
            </select>                    
            <span class="error-msg"><?php echo form_error("fuel_using_dept_id");?></span>
            </div>
            </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Taken By <span style="color:red;">  *</span></label>
            <div class="col-sm-3">
              <select class="form-control" name="driver_id" id="driver_id">
              <option value="All">All</option>
              <?php foreach($tlist as $rows){  ?>
              <option value="<?php echo $rows->driver_id; ?>" 
                <?php echo $rows->driver_id==set_value('driver_id')? 'selected="selected"':0; ?>>
                 <?php echo $rows->driver_name; ?></option>
              <?php }  ?>
            </select>                    
            <span class="error-msg"><?php echo form_error("driver_id");?></span>
            </div>
             <label class="col-sm-1 control-label">From Date</label>
              <div class="col-sm-2">
                <input type="text" name="from_date" readonly  class="form-control date" placeholder="From Date" value="<?php  echo set_value('from_date');?>">
                  <span class="error-msg"><?php echo form_error("from_date"); ?></span>
              </div>
              <label class="col-sm-1 control-label">To Date</label>
              <div class="col-sm-2">
                  <input type="text" name="to_date"  readonly class="form-control date" id="inputEmail3" placeholder="To Date" value="<?php echo set_value('to_date'); ?>">
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
      <div class="table-responsive table-bordered">
      <table class="table table-bordered table-striped colortd" style="width:99%;border:#000" >
          <thead>
      <tr>
      <th style="width:4%;">SN</th>
      <th style="width:8%;">Date</th>
      <th style="width:8%;">Department</th>
      <th style="width:15%">Vehicles Name</th>
      <th style="width:10%;text-align:center">Fuel Reading at Start Point</th>
      <th style="width:10%;text-align:center">Fuel Reading at Stop Point</th>
      <th style="text-align:center;width:10%">Run(KM)(Liter)</th>
      <th style="text-align:center;width:10%">Start Run Hr</th>
      <th style="text-align:center;width:10%">Stop Run Hr</th>
      <th style="text-align:center;width:10%">Run Hr</th>
      <th style="text-align:center;width:8%">Diesel Qty</th>
      <th style="text-align:center;width:8%">Taken By</th>
      <th style="text-align:center;width:7%">Req No</th>
      <th style="text-align:center;width:6%">Non Official KM</th>
      <th style="text-align:center;width:6%">Amount</th>
      </tr>
      </thead>
      <tbody>
      <?php $grandtotal=0; $totalcost=0;
      if(isset($resultdetail)&&!empty($resultdetail)): $i=1;
        foreach($resultdetail as $row):
          $grandtotal=$grandtotal+$row->issue_qty;
          $totalcost=$totalcost+$row->amount;
          ?>
      <tr>
      <td style="text-align:center">
        <?php echo $i++; ; ?></td>
      <td class="text-center">
        <?php echo findDate($row->issue_date); ?></td>
      <td><?php echo $row->fuel_using_dept_name;?></td>
      <td style="text-align:center">
        <?php echo $row->motor_name; ; ?></td>
      <td style="text-align:center">
        <?php echo $row->fuel_r_start_point_km_liter;  ?></td>  
      <td style="text-align:center">
        <?php echo $row->fuel_r_end_point_km_liter;  ?></td>
      <td style="vertical-align: text-top">
      <?php  echo $row->run_km_liter; ?></td> 
      <td style="vertical-align: text-top">
      <?php echo $row->start_hour;  ?></td>
      <td style="vertical-align: text-top">
      <?php  echo $row->stop_hour; ?></td> 
      <td style="vertical-align: text-top">
      <?php  echo $row->run_hour; ?></td>
      <td style="vertical-align: text-top">
      <?php  echo $row->issue_qty; ?></td>
      <td style="vertical-align: text-top">
      <?php  echo $row->driver_name; ?></td>
      <td style="vertical-align: text-top">
      <?php  echo $row->req_no; ?></td>
      <td style="vertical-align: text-top">
      <?php  echo $row->on_officicer_km; ?></td>
      <td style="vertical-align: text-top">
      <?php  echo $row->amount; ?></td>
      </tr>
      <?php
      endforeach;
  endif;
  ?>
  <tr>
      <th style="text-align:right;" colspan="10">Grand Total</th>
      <th style="text-align:center;"><?php echo $grandtotal; ?></th>
      <th style="text-align:right;" colspan="3"> </th>
      <th style="text-align:center;"><?php echo $totalcost; ?></th>
  </tr>
 
  </tbody>
  </table>
  <h4 style="text-align: right;">Available Stock Balance: <?php echo  $this->db->query("SELECT main_stock FROM product_info 
      WHERE product_id=3614")->row('main_stock'); ?>
      </h4>
</div>
</div>
  <!-- /.box-header -->
  <!-- /.box-body -->
  </div>
  </div>
 </div>
