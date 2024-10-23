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
<a class="btn btn-sm btn-primary pull-right" style="margin-right:0px;" href="<?php echo base_url(); ?>payment/report/supplierExcel<?php echo "/$department_id/$supplier_id";
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
      <form class="form-horizontal" action="<?php echo base_url();?>payment/report/supplierResult" method="POST" enctype="multipart/form-data">
        <div class="box-body">
          <div class="form-group">
            <label class="col-sm-2 control-label">Department Name<span style="color:red;">  *</span></label>
            <div class="col-sm-2">
              <select class="form-control select2" name="department_id" id="department_id">
              <option value="All" <?php echo 'All'==set_value('department_id')? 'selected="selected"':0; ?>>All</option>
              <?php foreach($dlist as $rows){  ?>
              <option value="<?php echo $rows->department_id; ?>" 
                <?php echo $rows->department_id==set_value('department_id')? 'selected="selected"':0; ?>>
                 <?php echo $rows->department_name; ?></option>
              <?php }  ?>
            </select>                    
            <span class="error-msg"><?php echo form_error("department_id");?></span>
            </div>
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
           <span class="error-msg"><?php echo form_error("supplier_id");?></span>
         </div>
       </div>
       <div class="form-group">
            <label class="col-sm-2 control-label">Date <span style="color:red;">  *</span></label>
	          <div class="col-sm-2">
	              <input type="text" name="from_date" readonly class="form-control date" placeholder="From Date" value="<?php echo set_value('from_date'); ?>">
	              <span class="error-msg"><?php echo form_error("from_date"); ?></span>
	          </div>
	          <div class="col-sm-2">
	              <input type="text" name="to_date" readonly class="form-control date" placeholder="To Date" value="<?php echo set_value('to_date'); ?>">
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
<?php if(isset($resultdetail)){ ?>
  <?php if($department_id!='All'){  ?>
  	   <h3 align="center" style="margin:0;padding: 5px">
  	   <b>Department: 
  	<?php 
     $department_name=$this->db->query("SELECT * FROM department_info 
      WHERE department_id=$department_id")->row('department_name'); 
     echo "$department_name";
      ?>
  	</b></h3>
  <?php } 
   ?>
   <?php if($supplier_id!='All'){  ?>
       <h3 align="center" style="margin:0;padding: 5px">
       <b>Supplier: 
    <?php 
     $supplier_name=$this->db->query("SELECT * FROM supplier_info 
      WHERE supplier_id=$supplier_id")->row('supplier_name'); 
     echo "$supplier_name";
      ?>
    </b></h3>
  <?php } 
   ?>
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
              <th style="width:8%">From Department</th>
              <th style="text-align:center;width:8%">Date</th>
              <th style="text-align:center;width:8%">PA No</th>
              <th style="text-align:center;width:15%">Supplier</th>
              <th style="text-align:center;width:8%">Description</th>
              <th style="width:8%;">Amount</th>
              <th style="text-align:center;width:15%">Department</th>
              <th style="width:8%;">Payment Term</th>
              <th style="text-align:center;width:10%">Remarks</th>
              </tr>
              </thead>
              <tbody>
              <?php 
              $grandtotal=0;
              if(isset($resultdetail)&&!empty($resultdetail)): $i=1;
                foreach($resultdetail as $row):
                  $grandtotal=$grandtotal+$row->amount;
                  ?>
                  <tr>
                    <td style="text-align:center;"><?php echo $i++; ?></td>
                    <td style="text-align:center;"><?php echo $row->department_name; ?></td>
                    <td style="text-align:center;">
                    <?php echo findDate($row->applications_date); ?></td>
                    <td style="text-align:center;"><?php echo $row->applications_no;?></td>
                    <td style="text-align:center;word-break: break-all;">
                      <?php echo $row->supplier_name;  ?></td> 
                    <td style="text-align:center;word-break: break-all;">
                      <?php echo $row->head_name;  ?></td> 
                    <td style="text-align:center;word-break: break-all;">
                      <?php echo number_format($row->amount,2);  ?></td>  
                    <td style="text-align:center;word-break: break-all;">
                    <?php echo $row->dcode_group;  ?></td>
                    <td style="text-align:center;">
                    <?php echo $row->pay_term;  ?></td>
                    <td style="text-align:center;">
                    <?php echo $row->remarks;  ?></td>
                  </tr>
                  <?php
                  endforeach;
                endif;
              ?>
              <tr>
                  <th style="text-align:right;" colspan="6">Total</th>
                  <th style="text-align:center;"><?php echo number_format($grandtotal,2); ?></th>
                  <th></th>
                  <th></th>
                  <th></th>
              </tr>
              </tbody>
              </table>
              </div>
              <?php } ?>
    </div>
      <!-- /.box-header -->

      <!-- /.box-body -->
    </div>
  </div>
 </div>
