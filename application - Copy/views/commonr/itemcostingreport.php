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
<style type="text/css">
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
<!-- <a class="btn btn-sm btn-primary pull-right" style="margin-right:0px;" href="<?php echo base_url(); ?>commonr/itemcostingreport/downloadExcel<?php //echo "/$category_id/$rack_id/$box_id/$department_id/$product_code";  ?>">
<i class="fa fa-file-excel-o"></i>
Download Excel
</a>
<a class="btn btn-sm btn-primary pull-right" style="margin-right:0px;" href="<?php echo base_url(); ?>commonr/itemcostingreport/downloadPdf<?php //echo "/$category_id/$rack_id/$box_id/$department_id/$product_code";  ?>">
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
      <form class="form-horizontal" action="<?php echo base_url();?>commonr/itemcostingreport/reportrResult" method="POST" enctype="multipart/form-data">
        <div class="box-body">
          <div class="form-group">
            <label class="col-sm-2 control-label">Category Name 分类名称<span style="color:red;">  *</span></label>
            <div class="col-sm-3">
              <select class="form-control select2" name="category_id" id="category_id">
              <option value="All" <?php echo 'All'==set_value('category_id')? 'selected="selected"':0; ?>>All</option>
              <?php foreach($clist as $rows){  ?>
              <option value="<?php echo $rows->category_id; ?>" 
                <?php echo $rows->category_id==set_value('category_id')? 'selected="selected"':0; ?>>
                 <?php echo $rows->category_name; ?></option>
              <?php }  ?>
            </select>                    
            <span class="error-msg"><?php echo form_error("category_id");?></span>
            </div>
            <label class="col-sm-1 control-label">Main Area</label>
            <div class="col-sm-2">
              <select class="form-control select2" name="mlocation_id" id="mlocation_id">
              <option value="All" <?php echo 'All'==set_value('mlocation_id')? 'selected="selected"':0; ?>>All</option>
              <?php 
              foreach($mllist as $rows){  ?>
              <option value="<?php echo $rows->mlocation_id; ?>" 
                <?php echo $rows->mlocation_id==set_value('mlocation_id')? 'selected="selected"':0; ?>>
                 <?php echo $rows->mlocation_name; ?></option>
              <?php }  ?>
            </select>                    
            <span class="error-msg"><?php echo form_error("mlocation_id");?></span>
            </div>
            <label class="col-sm-1 control-label">Location</label>
            <div class="col-sm-2">
              <select class="form-control select2" name="location_id" id="location_id">
              <option value="All" <?php echo 'All'==set_value('location_id')? 'selected="selected"':0; ?>>All</option>
              <?php 
              foreach($llist as $rows){  ?>
              <option value="<?php echo $rows->location_id; ?>" 
                <?php echo $rows->location_id==set_value('location_id')? 'selected="selected"':0; ?>>
                 <?php echo $rows->location_name; ?></option>
              <?php }  ?>
            </select>                    
            <span class="error-msg"><?php echo form_error("location_id");?></span>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">
            Item Code <span style="color:red;">  </span></label>
            <div class="col-sm-2">
              <input class="form-control" name="product_code" id="product_code" value="<?php echo set_value('product_code'); ?>" placeholder="Code">
            <span class="error-msg"><?php echo form_error("product_code");?></span>
            </div>
            <label class="col-sm-1 control-label">From Date</label>
              <div class="col-sm-2">
                  <input type="text" name="from_date" readonly  class="form-control date" id="inputEmail3" placeholder="From Date" value="<?php if (isset($info))
                          echo $info->from_date;
                      else
                          echo set_value('from_date');
                      ?>">
                  <span class="error-msg"><?php echo form_error("from_date"); ?></span>
              </div>
               <label class="col-sm-1 control-label">To Date</label>
              <div class="col-sm-2">
                  <input type="text" name="to_date"  readonly class="form-control date" id="inputEmail3" placeholder="To Date" value="<?php if (isset($info))
                          echo $info->to_date;
                      else
                          echo set_value('to_date');
                      ?>">
                  <span class="error-msg"><?php echo form_error("to_date"); ?></span>
              </div>
            <div class="col-sm-2">
          <button type="submit" class="btn btn-info pull-left">Result</button>
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
                <th style="text-align:center;width:5%;">SN</th>
                <th style="text-align:center;width:10%">Main Area</th>
                <th style="width:10%;text-align:center">Location Name</th>
                <th style="width:15%;text-align:center">Cost(BDT)</th>
              </tr>
              </thead>
              <tbody>
              <?php $grandtotal=0; $grandpi=0;
              if(isset($resultdetail)&&!empty($resultdetail)): $i=1;
                foreach($resultdetail as $row):
                $grandtotal=$grandtotal+$row->amount;
                ?>
                <tr>
                  <td style="text-align:center;">
                    <?php echo $i++; ?></td>
                  <td style="text-align:center;">
                    <?php echo $row->mlocation_name;?></td>
                  <td style="text-align:center;">
                    <?php echo $row->location_name;  ?></td> 
                  <td style="vertical-align: text-top;text-align:center;">
                  <?php  echo number_format($row->amount,2); ?></td>
                </tr>
                <?php
                endforeach;
              endif;
              ?>
              <tr>
              <th style="text-align:right;" colspan="3">
              Grand Total</th>
              <th style="text-align:center;">
                <?php echo number_format($grandtotal,2); ?></th>
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
