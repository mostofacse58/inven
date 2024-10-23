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
<a class="btn btn-sm btn-primary pull-right" style="margin-right:0px;" href="<?php echo base_url(); ?>commonr/pistatusreport/downloadExcel<?php echo "/$department_id";
 if($pi_status!='') echo "/$pi_status"; else echo "/All"; 
 if($pi_no!='') echo "/$pi_no"; else echo "/All";
 if($product_code!='') echo "/$product_code"; else echo "/All";
 if($purchase_type_id!='') echo "/$purchase_type_id"; else echo "/All";
 echo "/$from_date/$to_date";  ?>">
<i class="fa fa-file-excel-o"></i>
Download Excel
</a>
<!-- 
<a class="btn btn-sm btn-primary pull-right" style="margin-right:0px;" href="<?php echo base_url(); ?>commonr/pistatusreport/downloadPdf<?php //echo "/$category_id/$rack_id/$box_id/$department_id/$product_code";  ?>">
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
  <form class="form-horizontal" action="<?php echo base_url();?>commonr/pistatusreport/reportrResult" method="POST" enctype="multipart/form-data">
        <div class="box-body">
          <div class="form-group">
              <label class="col-sm-1 control-label">PI NO</label>
              <div class="col-sm-2">
                  <input type="text" name="pi_no"   class="form-control" placeholder="NO" value="<?php if (isset($info))
                      echo $info->pi_no;
                  else
                      echo set_value('pi_no');
                  ?>">
                  <span class="error-msg"><?php echo form_error("pi_no"); ?></span>
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
              <select class="form-control select2" required name="pi_status" id="pi_status">
                <option value="All">All Status</option>
                <option value="1"
                  <?php  if(isset($info)) echo 1==$info->pi_status? 'selected="selected"':0; else echo set_select('pi_status',1);?>>
                    Done</option>
                  <option value="2"
                  <?php  if(isset($info)) echo 2==$info->pi_status? 'selected="selected"':0; else echo set_select('pi_status',2);?>>
                    Pending</option>
                  <option value="3"
                  <?php  if(isset($info)) echo 3==$info->pi_status? 'selected="selected"':0; else echo set_select('pi_status',3);?>>
                    Overflow</option>
                  
              </select>
             <span class="error-msg"><?php echo form_error("pi_status");?></span>
            </div>
            <label class="col-sm-1 control-label">Department <span style="color:red;">  *</span></label>
           <div class="col-sm-2">
            <select class="form-control select2" name="department_id" id="department_id">> 
              <?php foreach ($dlist as $rows) { ?>
                <option value="<?php echo $rows->department_id; ?>" 
                <?php if (isset($info))
                    echo $rows->department_id == $info->department_id ? 'selected="selected"' : 0;
                else
                    echo $rows->department_id == $this->session->userdata('department_id') ? 'selected="selected"' : 0;
                ?>><?php echo $rows->department_name; ?></option>
                    <?php } ?>
                </select>
              <span class="error-msg"><?php echo form_error("use_type");?></span>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-1 control-label">Pur. Type <span style="color:red;">  *</span></label>
           <div class="col-sm-3">
            <select class="form-control select2" name="purchase_type_id" id="purchase_type_id">> 
              <option value="All" selected="selected">All</option>
              <?php foreach ($ptlist as $rows) { ?>
                <option value="<?php echo $rows->purchase_type_id; ?>" 
                <?php if (isset($info))
                    echo $rows->purchase_type_id == $info->purchase_type_id ? 'selected="selected"' : 0;
                else
                    echo $rows->purchase_type_id == set_value('purchase_type_id') ? 'selected="selected"' : 0;
                ?>><?php echo $rows->p_type_name; ?></option>
                    <?php } ?>
                </select>
              <span class="error-msg"><?php echo form_error("use_type");?></span>
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
                  <th style="text-align:center;width:3%;">SN</th>
                  <th style="text-align:center;width:8%">PI NO</th>
                  <th style="text-align:center;width:8%">PI Date</th>
                  <th style="text-align:center;width:8%">Demand Date</th>
                  <th style="text-align:center;width:7%">Pur.Type</th>
                  <th style="text-align:center;width:7%">Invoice No</th>
                  <th style="width:15%;">Item/Materials Name</th>
                  <th style="text-align:center;width:8%">Item Code 项目代码</th>
                  <th style="text-align:center;width:7%">Unit Price</th>
                  <th style="text-align:center;width:7%">Currency</th>
                  <th style="text-align:center;width:7%">PI Qty</th>                  
                  <th style="text-align:center;width:7%">PO Qty</th>
                  <th style="text-align:center;width:7%">IN Qty</th>
                  <th style="text-align:center;width:7%">DUE Qty</th>

              </tr>
              </thead>
              <tbody>
              <?php $grandtotal=0; $grandamount=0;
              if(isset($resultdetail)&&!empty($resultdetail)): $i=1;
                foreach($resultdetail as $row):
                    $bdcolor='';
                    if($row->pi_date>='2020-01-01'){
                     if(($row->purchased_qty-$row->in_qty)<0) $bdcolor="background-color: red";
                     if($row->purchased_qty>$row->in_qty) $bdcolor="background-color: yellow"; 
                    }
                  ?>
                  <tr>
                    <td style="text-align:center;">
                      <?php echo $i++; ?></td>
                     <td style="text-align:center;"><a href="<?php echo base_url()?>dashboard/viewpipdf/<?php echo $row->pi_id;?>" target="_blank">
                      <?php echo $row->pi_no;  ?></a></td> 
                    <td style="text-align:center;">
                      <?php echo findDate($row->pi_date);  ?></td>
                    <td style="text-align:center;">
                      <?php echo findDate($row->demand_date);  ?></td>
                    <td class="text-center"><?php 
                      if($row->purchase_type_id==1||$row->purchase_type_id==2) echo "Overseas"; 
                      else echo "Local"; ?></td>
                    <td style=""><?php echo getInvoiceNo($row->product_id,$row->pi_no);?></td>
                    <td style=""><?php echo $row->product_name;?></td>
                    <td style="text-align:center;">
                      <?php echo $row->product_code;  ?></td> 
                    <td style="text-align:center;">
                      <?php echo $row->unit_price;  ?></td>
                    <td style="text-align:center;">
                      <?php echo "$row->currency";  ?></td>
                      <td style="text-align:center;">
                      <?php echo $row->purchased_qty;  ?></td> 
                    <td style="text-align:center;">
                      <?php echo $row->po_qty;  ?></td> 
                    <td style="text-align:center;">
                      <?php
                      if($row->pi_date>='2020-01-01'){
                      echo $row->in_qty; 
                      }else{
                        echo $row->purchased_qty;
                      }?></td> 
                    <td style="text-align:center; <?php echo $bdcolor; ?>">
                      <?php 
                      if($row->pi_date>='2020-01-01'){
                        echo $row->purchased_qty-$row->in_qty; 
                      }else{
                        echo "0.00";
                      } ?></td> 
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
