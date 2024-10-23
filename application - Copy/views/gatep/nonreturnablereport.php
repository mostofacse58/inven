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
<a class="btn btn-sm btn-primary pull-right" style="margin-right:0px;" href="<?php echo base_url(); ?>gatep/report/nonreturnableExcel<?php echo "/$department_id/$gatepass_type/$issue_from/$wh_whare";
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
      <form class="form-horizontal" action="<?php echo base_url();?>gatep/report/nonreturnableResult" method="POST" enctype="multipart/form-data">
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
            <label class="col-sm-1 control-label">Type  <span style="color:red;">  *</span></label>
           <div class="col-sm-2">
            <select class="form-control select2" required name="gatepass_type" id="gatepass_type">
                <option value="2"
                  <?php  if(isset($info)) echo 2==$info->gatepass_type? 'selected="selected"':0; else echo set_select('gatepass_type',2);?>>
                    Non-Returnable Material</option>
                <option value="3"
                  <?php  if(isset($info)) echo 3==$info->gatepass_type? 'selected="selected"':0; else echo set_select('gatepass_type',3);?>>
                    Finished Goods</option>
                <option value="4"
                  <?php  if(isset($info)) echo 4==$info->gatepass_type? 'selected="selected"':0; else echo set_select('gatepass_type',4);?>>
                    Stock Transfer</option>
              </select>
           <span class="error-msg"><?php echo form_error("gatepass_type");?></span>
         </div>
            <label class="col-sm-1 control-label">Date <span style="color:red;">  *</span></label>
	          <div class="col-sm-2">
	              <input type="text" name="from_date" readonly class="form-control date" placeholder="From Date" value="<?php echo set_value('from_date'); ?>">
	              <span class="error-msg"><?php echo form_error("from_date"); ?></span>
	          </div>
	          <div class="col-sm-2">
	              <input type="text" name="to_date" readonly class="form-control date" placeholder="To Date" value="<?php echo set_value('to_date'); ?>">
	              <span class="error-msg"><?php echo form_error("to_date"); ?></span>
	          </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">From<span style="color:red;">  *</span></label>
            <div class="col-sm-2">
              <select class="form-control select2" required name="issue_from" id="issue_from">
                <option value="All" <?php echo 'All'==set_value('issue_from')? 'selected="selected"':0; ?>>All</option>
                <option value="Ventura"
                  <?php  if(isset($info)) echo 'Ventura'==$info->issue_from? 'selected="selected"':0; else echo set_select('issue_from','Ventura');?>>
                    Ventura</option>
                <option value="E-Floor"
                  <?php  if(isset($info)) echo 'E-Floor'==$info->issue_from? 'selected="selected"':0; else echo set_select('issue_from','E-Floor');?>>
                    E-Floor</option>
                <option value="MSSFB-3"
                  <?php  if(isset($info)) echo 'MSSFB-3'==$info->issue_from? 'selected="selected"':0; else echo set_select('issue_from','MSSFB-3');?>>
                    MSSFB-3</option>
                <option value="CDF"
                  <?php  if(isset($info)) echo 'CDF'==$info->issue_from? 'selected="selected"':0; else echo set_select('issue_from','CDF');?>>
                    CDF</option>
                <option value="CGN"
                  <?php  if(isset($info)) echo 'CGN'==$info->issue_from? 'selected="selected"':0; else echo set_select('issue_from','CGN');?>>
                    CGN</option>
                <option value="VD"
                  <?php  if(isset($info)) echo 'VD'==$info->issue_from? 'selected="selected"':0; else echo set_select('issue_from','VD');?>>
                    VD</option>
                <option value="SFB-01"
                  <?php  if(isset($info)) echo 'SFB-01'==$info->issue_from? 'selected="selected"':0; else echo set_select('issue_from','SFB-01');?>>
                    SFB-01</option>
              </select>                    
            <span class="error-msg"><?php echo form_error("issue_from");?></span>
            </div>
            <label class="col-sm-1 control-label">Issue To  <span style="color:red;">  *</span></label>
           <div class="col-sm-2">
            <select class="form-control select2" name="wh_whare" id="wh_whare">
                <option value="All" <?php echo 'All'==set_value('wh_whare')? 'selected="selected"':0; ?>>All</option>
                <option value="Ventura"
                  <?php  if(isset($info)) echo 'Ventura'==$info->wh_whare? 'selected="selected"':0; else echo set_select('wh_whare','Ventura');?>>
                    Ventura</option>
                <option value="E-Floor"
                  <?php  if(isset($info)) echo 'E-Floor'==$info->wh_whare? 'selected="selected"':0; else echo set_select('wh_whare','E-Floor');?>>
                    E-Floor</option>
                <option value="MSSFB-3"
                  <?php  if(isset($info)) echo 'MSSFB-3'==$info->wh_whare? 'selected="selected"':0; else echo set_select('wh_whare','MSSFB-3');?>>
                    MSSFB-3</option>
                 <option value="CDF"
                  <?php  if(isset($info)) echo 'CDF'==$info->wh_whare? 'selected="selected"':0; else echo set_select('wh_whare','CDF');?>>
                    CDF</option>
                <option value="CGN"
                  <?php  if(isset($info)) echo 'CGN'==$info->wh_whare? 'selected="selected"':0; else echo set_select('wh_whare','CGN');?>>
                    CGN</option>
                <option value="VD"
                  <?php  if(isset($info)) echo 'VD'==$info->wh_whare? 'selected="selected"':0; else echo set_select('wh_whare','VD');?>>
                    VD</option>
                <option value="SFB-01"
                  <?php  if(isset($info)) echo 'SFB-01'==$info->wh_whare? 'selected="selected"':0; else echo set_select('wh_whare','SFB-01');?>>
                    SFB-01</option>
              </select>
           <span class="error-msg"><?php echo form_error("wh_whare");?></span>
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
<?php if($department_id!='All'){  ?>
	   <h3 align="center" style="margin:0;padding: 5px">
	   <b>Department: 
	<?php 
   $department_name=$this->db->query("SELECT * FROM department_info 
    WHERE department_id=$department_id")->row('department_name'); echo "$department_name";
    ?>
	</b></h3>
  <?php }
 // print_r($resultdetail);
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
              <th style="width:8%">Department</th>
              <th style="text-align:center;width:8%">Date</th>
              <th style="text-align:center;width:8%">Gate Pass No</th>
              <th style="text-align:center;width:8%">From</th>
              <th style="text-align:center;width:8%">Issue To</th>
              <th style="text-align:center;width:8%">
                <?php if($gatepass_type==3) echo "File No"; else echo "Matrial Code"; ?></th>
              <th style="width:15%;">Item/Materials Name</th>
              <th style="text-align:center;width:8%">Out Qty</th>
              <th style="text-align:center;width:5%">Unit</th>
               <?php if($gatepass_type==3){ ?>
               <th style="width:10%;text-align:center">PO No</th>
               <th style="width:10%;text-align:center">Carton No</th>
               <th style="width:10%;text-align:center">Bag Qty</th>
               <th style="width:10%;text-align:center">Invoice No</th>
              <?php } ?>
              <th style="text-align:center;width:10%">Carried Name(ID)</th>
              </tr>
              </thead>
              <tbody>
              <?php 
              $grandtotal=0;
              $bagtotal=0;
              if(isset($resultdetail)&&!empty($resultdetail)): $i=1;
                foreach($resultdetail as $row):
                  $bagtotal=$bagtotal+$row->bag_qty;
                  $grandtotal=$grandtotal+$row->product_quantity;

                    ?>
                  <tr>
                    <td style="text-align:center;">
                    <?php echo $i++; ?></td>
                    <td style="text-align:center;">
                    <?php echo $row->department_name; ?></td>
                    <td style="text-align:center;">
                    <?php echo findDate($row->create_date);
                     echo " $row->create_time"; ?></td>
                    <td ><?php echo $row->gatepass_no;?></td>
                    <td style="text-align:center;">
                      <?php echo $row->issue_from;  ?></td> 
                      <td style="text-align:center;">
                      <?php if($row->wh_whare=='OTHER') 
                      echo $row->issue_to_name; 
                      else echo $row->wh_whare;  ?></td> 
                    <td style="text-align:center;word-break: break-all;">
                      <?php echo $row->product_code;  ?></td> 
                    <td style="text-align:center;word-break: break-all;">
                      <?php echo $row->product_name;  ?></td>  
                    <td style="text-align:center;">
                    <?php echo $row->product_quantity;  ?></td>
                    <td style="text-align:center;">
                    <?php echo $row->unit_name;  ?></td>
                    <?php if($gatepass_type==3){ ?>
                    <td class="tg-baqh" style="text-align:center">
                        <?php echo $row->po_no; ?></td>
                    <td class="tg-baqh" style="text-align:center">
                        <?php echo $row->carton_no; ?></td>
                    <td class="tg-baqh" style="text-align:center">
                      <?php echo $row->bag_qty; ?></td>
                    <td class="tg-baqh" style="text-align:center">
                      <?php echo $row->invoice_no; ?></td>
                    <?php } ?>
                    <td style="vertical-align: text-top;text-align:center;">
                    <?php  echo "$row->carried_by ($row->employee_id)"; ?></td>
                  </tr>
                  <?php
                  endforeach;
              endif;
              ?>
              <tr>
                  <th style="text-align:right;" colspan="8">Total</th>
                  <th style="text-align:center;width:10%"><?php echo $grandtotal; ?></th>
                  <?php if($gatepass_type==3){ ?>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th><?php echo $bagtotal; ?></th>
                  <?php } ?>
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
