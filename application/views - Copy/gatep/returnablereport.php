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
<a class="btn btn-sm btn-primary pull-right" style="margin-right:0px;" href="<?php echo base_url(); ?>gatep/report/returnablePDF<?php echo "/$pendingstatus/$department_id";
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
      <form class="form-horizontal" action="<?php echo base_url();?>gatep/report/returnableResult" method="POST" enctype="multipart/form-data">
        <div class="box-body">
          <div class="form-group">
            <label class="col-sm-2 control-label">Department Name<span style="color:red;">  *</span></label>
            <div class="col-sm-2">
              <select class="form-control" name="department_id" id="department_id">
              <option value="All" <?php echo 'All'==set_value('department_id')? 'selected="selected"':0; ?>>All</option>
              <?php foreach($dlist as $rows){  ?>
              <option value="<?php echo $rows->department_id; ?>" 
                <?php echo $rows->department_id==set_value('department_id')? 'selected="selected"':0; ?>>
                 <?php echo $rows->department_name; ?></option>
              <?php }  ?>
            </select>                    
            <span class="error-msg"><?php echo form_error("department_id");?></span>
            </div>
            <label class="col-sm-2 control-label">From Date</label>
	          <div class="col-sm-2">
	              <input type="text" name="from_date"  readonly class="form-control date" id="inputEmail3" placeholder="From Date" value="<?php echo set_value('from_date'); ?>">
	              <span class="error-msg"><?php echo form_error("from_date"); ?></span>
	          </div>
	           <label class="col-sm-2 control-label">To Date</label>
	          <div class="col-sm-2">
	              <input type="text" name="to_date"  readonly class="form-control date" id="inputEmail3" placeholder="To Date" value="<?php echo set_value('to_date'); ?>">
	              <span class="error-msg"><?php echo form_error("to_date"); ?></span>
	          </div>
          </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">Status<span style="color:red;">  *</span></label>
            <div class="col-sm-2">
              <select class="form-control" name="pendingstatus" id="pendingstatus">
              <option value="All" <?php echo 'All'==set_value('department_id')? 'selected="selected"':0; ?>>All</option>
              <option value="Pending" 
                <?php echo 'Pending'==set_value('pendingstatus')? 'selected="selected"':0; ?>>Pending</option>
              <option value="Done" 
                <?php echo 'Done'==set_value('pendingstatus')? 'selected="selected"':0; ?>>Done</option>
            </select>                    
            <span class="error-msg"><?php echo form_error("pendingstatus");?></span>
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
<?php if($department_id!='All'){  ?>
	   <h3 align="center" style="margin:0;padding: 5px">
	   <b>Department: 
	<?php 
   $department_name=$this->db->query("SELECT * FROM department_info 
    WHERE department_id=$department_id")->row('department_name'); echo "$department_name";
    ?>
	</b></h3>
  <?php } ?>
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
               <?php if($department_id=='All'){  ?>
              <th style="width:10%">Department</th>
              <?php } ?>
              <th style="text-align:center;width:10%">Date</th>
              <th style="text-align:center;width:10%">Gate Pass No</th>
              <th style="width:15%;">Item/Materials Name</th>
              <th style="text-align:center;width:8%">Out Qty</th>
              <th style="text-align:center;width:8%">In Qty</th>
              <th style="text-align:center;width:8%">Due Qty</th>
              <th style="text-align:center;width:15%">Issue To</th>
              <th style="text-align:center;width:10%">Carried Name(ID)</th>
              </tr>
              </thead>
              <tbody>
              <?php $grandtotal=0;
              if(isset($resultdetail)&&!empty($resultdetail)): $i=1;
                foreach($resultdetail as $row):
                  if($pendingstatus=='All'){
                    ?>
                  
                  <tr>
                    <td style="text-align:center;">
                    <?php echo $i++; ?></td>
                    <?php if($department_id=='All'){  ?>
                    <td style="text-align:center;">
                    <?php echo $row->department_name; ?></td>
                    <?php } ?>
                    <td style="text-align:center;">
                    <?php echo findDate($row->create_date); echo " $row->create_time"; ?></td>
                    <td ><?php echo $row->gatepass_no;?></td>
                    <td style="text-align:center;">
                      <?php echo $row->product_name;  ?></td>  
                    <td style="text-align:center;">
                    <?php echo $row->product_quantity;  ?></td>
                    <td style="text-align:center;">
                    <?php echo $row->qty;  ?></td>
                    <td style="text-align:center;">
                    <?php echo $row->product_quantity-$row->qty;  ?></td>
                    <td style="text-align:center;">
                    <?php echo $row->issue_to_name;  ?></td> 
                    <td style="vertical-align: text-top;text-align:center;">
                    <?php  echo "$row->carried_by ($row->employee_id)"; ?></td>
                  </tr>
                <?php }elseif($pendingstatus=='Pending'&&$row->product_quantity>$row->qty){ ?>
                  <tr>
                    <td style="text-align:center;">
                    <?php echo $i++; ?></td>
                    <?php if($department_id=='All'){  ?>
                    <td style="text-align:center;">
                    <?php echo $row->department_name; ?></td>
                    <?php } ?>
                    <td style="text-align:center;">
                    <?php echo findDate($row->create_date); echo " $row->create_time"; ?></td>
                    <td ><?php echo $row->gatepass_no;?></td>
                    <td style="text-align:center;">
                      <?php echo $row->product_name;  ?></td>  
                    <td style="text-align:center;">
                    <?php echo $row->product_quantity;  ?></td>
                    <td style="text-align:center;">
                    <?php echo $row->qty;  ?></td>
                    <td style="text-align:center;">
                    <?php echo $row->product_quantity-$row->qty;  ?></td>
                    <td style="text-align:center;">
                    <?php echo $row->issue_to_name;  ?></td> 
                    <td style="vertical-align: text-top;text-align:center;">
                    <?php  echo "$row->carried_by ($row->employee_id)"; ?></td>
                  </tr>
                  <?php }elseif($pendingstatus=='Done'&&$row->product_quantity==$row->qty){ ?>
                    <tr>
                    <td style="text-align:center;">
                    <?php echo $i++; ?></td>
                    <?php if($department_id=='All'){  ?>
                    <td style="text-align:center;">
                    <?php echo $row->department_name; ?></td>
                    <?php } ?>
                    <td style="text-align:center;">
                    <?php echo findDate($row->create_date); echo " $row->create_time"; ?></td>
                    <td ><?php echo $row->gatepass_no;?></td>
                    <td style="text-align:center;">
                      <?php echo $row->product_name;  ?></td>  
                    <td style="text-align:center;">
                    <?php echo $row->product_quantity;  ?></td>
                    <td style="text-align:center;">
                    <?php echo $row->qty;  ?></td>
                    <td style="text-align:center;">
                    <?php echo $row->product_quantity-$row->qty;  ?></td>
                    <td style="text-align:center;">
                    <?php echo $row->issue_to_name;  ?></td> 
                    <td style="vertical-align: text-top;text-align:center;">
                    <?php  echo "$row->carried_by ($row->employee_id)"; ?></td>
                  </tr>
                  <?php }
                  endforeach;
              endif;
              ?>
             <!--  <tr>
                  <th style="text-align:right;" colspan="7">Total</th>
                  <th style="text-align:center;width:10%"><?php echo $grandtotal; ?></th>
              </tr> -->
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
