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
<a class="btn btn-sm btn-primary pull-right" style="margin-right:0px;" href="<?php echo base_url(); ?>commonr/requisitionreport/downloadExcel<?php 
 if($take_department_id!='') echo "/$take_department_id"; else echo "/All";
 if($requisition_status!='') echo "/$requisition_status"; else echo "/All"; 
 if($requisition_no!='') echo "/$requisition_no"; else echo "/All";
 if($product_code!='') echo "/$product_code"; else echo "/All";
 
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
  <form class="form-horizontal" action="<?php echo base_url();?>commonr/requisitionreport/reportrResult" method="POST" enctype="multipart/form-data">
        <div class="box-body">
          <div class="form-group">
              <label class="col-sm-2 control-label">Req. NO</label>
              <div class="col-sm-2">
                  <input type="text" name="requisition_no"   class="form-control" placeholder="NO" value="<?php if (isset($info))
                      echo $info->requisition_no;
                  else
                      echo set_value('requisition_no');
                  ?>">
                <span class="error-msg"><?php echo form_error("requisition_no"); ?></span>
              </div>
              <label class="col-sm-1 control-label">Item Code</label>
              <div class="col-sm-2">
                  <input type="text" name="product_code"   class="form-control" placeholder="CODE" value="<?php if (isset($info))
                      echo $info->product_code;
                  else
                      echo set_value('product_code');
                  ?>">
                <span class="error-msg"><?php echo form_error("product_code"); ?></span>
              </div>
              <label class="col-sm-1 control-label">Status</label>
              <div class="col-sm-2">
              <select class="form-control select2" required name="requisition_status" id="requisition_status">
                <option value="All">All Status</option>
                <option value="1"
                  <?php  if(isset($info)) echo 1==$info->requisition_status? 'selected="selected"':0; else echo set_select('requisition_status',1);?>>
                    Delivery</option>
                  <option value="2"
                  <?php  if(isset($info)) echo 2==$info->requisition_status? 'selected="selected"':0; else echo set_select('requisition_status',2);?>>
                    Pending</option>
              </select>
             <span class="error-msg"><?php echo form_error("requisition_status");?></span>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">For Department <span style="color:red;">  *</span></label>
           <div class="col-sm-2">
            <select class="form-control select2" name="take_department_id" id="take_department_id">> 
              <option value="All" selected="selected">All</option>
              <?php foreach ($dlist as $rows) { ?>
              <option value="<?php echo $rows->department_id; ?>" 
                <?php if (isset($info))
                  echo $rows->department_id == $info->take_department_id ? 'selected="selected"' : 0;
                else
                  echo $rows->department_id == set_value('take_department_id') ? 'selected="selected"' : 0;
                ?>><?php echo $rows->department_name; ?></option>
                <?php } ?>
              </select>
           <span class="error-msg"><?php echo form_error("take_department_id");?></span>
         </div>
             <label class="col-sm-1 control-label">From Date</label>
              <div class="col-sm-2">
                <input type="text" name="from_date" readonly  class="form-control date"  placeholder="From Date" value="<?php if (isset($info))
                    echo $info->from_date;
                  else
                    echo set_value('from_date');
                   ?>">
                  <span class="error-msg"><?php echo form_error("from_date"); ?></span>
              </div>
               <label class="col-sm-1 control-label">To Date</label>
              <div class="col-sm-2">
                  <input type="text" name="to_date"  readonly class="form-control date"  placeholder="To Date" value="<?php if (isset($info))
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
                  <th style="text-align:center;width:3%;">SN</th>
                  <th style="text-align:center;width:8%">Req. NO</th>
                  <th style="text-align:center;width:8%">Req. Date</th>
                  <th style="text-align:center;width:8%">Demand Date</th>
                  <th style="width:15%;">Item/Materials Name</th>
                  <th style="text-align:center;width:8%">Item Code 项目代码</th>
                  <th style="text-align:center;width:7%">Request Qty</th>                  
                  <th style="text-align:center;width:7%">Request by</th>
                  <th style="text-align:center;width:7%">Note</th> 
              </tr>
              </thead>
              <tbody>
              <?php $grandtotal=0; $grandamount=0;
              if(isset($resultdetail)&&!empty($resultdetail)): $i=1;
                foreach($resultdetail as $row):
                    $bdcolor='';
                     if(($row->required_qty-($row->tpm_qty+$row->store_qty))<0) $bdcolor="background-color: red";
                     if($row->required_qty>($row->tpm_qty+$row->store_qty)) $bdcolor="background-color: yellow"; 
                  ?>
                  <tr>
                    <td style="text-align:center;">
                      <?php echo $i++; ?></td>
                     <td style="text-align:center;">
                      <?php echo $row->requisition_no;  ?></td> 
                    <td style="text-align:center;">
                      <?php echo findDate($row->requisition_date);  ?></td>
                    <td style="text-align:center;">
                      <?php echo findDate($row->demand_date);  ?></td>
                    <td style=""><?php echo $row->product_name;?></td>
                    <td style="text-align:center;">
                      <?php echo $row->product_code;  ?></td> 
                      <td style="text-align:center;">
                      <?php echo $row->required_qty;  ?></td> 
                    <td style="text-align:center;">
                      <?php echo getUserName($row->user_id);  ?></td> 
                    <td style="text-align:center;">
                      <?php 
                        echo $row->other_note; 
                      ?></td> 
                    </tr>
                  <?php
                  endforeach;
              endif;
              ?>
              </tbody>
              </table>
              </div>
    </div>
    <!-- /.box-header -->
    <!-- /.box-body -->
    </div>
  </div>
 </div>
