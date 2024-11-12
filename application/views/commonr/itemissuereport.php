<script src="<?php echo base_url('asset/js/plugins/datepicker/bootstrap-datepicker.js'); ?>"></script>
<script src="<?php echo base_url('asset/js/plugins/datepicker/bootstrap-datepicker.js'); ?>"></script>
<script>
    $(document).ready(function(){
       $('.date').datepicker({
            "format": "dd/mm/yyyy",
            "todayHighlight": true,
            "autoclose": true
        });
  var category_ids = "<?php echo set_value('category_id') ?>";
  var product_ids = "<?php echo set_value('product_id') ?>";
    var department_id=$('#department_id').val();
        if(department_id !=''){
        $.ajax({
          type:"post",
          url:"<?php echo base_url()?>"+'commonr/itemstock/getcategory',
          data:{department_id:department_id},
          success:function(data){
            $("#category_id").empty();
            $("#category_id").append(data);
            if(category_ids != ''){
              $('#category_id').val(category_ids).change();
            } }
        });
      }
      ///////////////////////
      $('#department_id').on('change',function(){
        var department_id=$('#department_id').val();
        if(department_id !=''){
        $.ajax({
          type:"post",
          url:"<?php echo base_url()?>"+'commonr/itemstock/getcategory',
          data:{department_id:department_id},
          success:function(data){
            $("#category_id").empty();
            $("#category_id").append(data);
            if(category_ids != ''){
              $('#category_id').val(category_ids).change();
            }}
        });
      
      }
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
<a class="btn btn-sm btn-primary pull-right" style="margin-right:0px;" href="<?php echo base_url(); ?>commonr/itemissuereport/downloadExcel<?php 
 echo "/$category_id/$department_id/$take_department_id/$mlocation_id/$location_id";  
 if($product_code!='') echo "/$product_code"; else echo "/All";
 if($employee_no!='') echo "/$employee_no"; else echo "/All";
 echo "/$from_date/$to_date";  ?>">
<i class="fa fa-file-excel-o"></i>
Download Excel
</a>
<!-- 
<a class="btn btn-sm btn-primary pull-right" style="margin-right:0px;" href="<?php echo base_url(); ?>commonr/itemissuereport/downloadPdf<?php //echo "/$category_id/$rack_id/$box_id/$department_id/$product_code";  ?>">
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
      <form class="form-horizontal" action="<?php echo base_url();?>commonr/itemissuereport/reportrResult" method="POST" enctype="multipart/form-data">
        <div class="box-body">
          <div class="form-group">
            <label class="col-sm-2 control-label">Holder Dept.</label>
            <div class="col-sm-2">
             <select class="form-control select2" name="department_id" id="department_id">
              <?php 
              foreach($dlist as $rows){  ?>
              <option value="<?php echo $rows->department_id; ?>" 
                <?php echo $rows->department_id==$this->session->userdata('department_id')? 'selected="selected"':0; ?>>
                 <?php echo $rows->department_name; ?></option>
              <?php }  ?>
            </select>                   
            <span class="error-msg"><?php echo form_error("department_id");?></span>
            </div>
            <label class="col-sm-2 control-label">Category Name 分类名称<span style="color:red;">  *</span></label>
            <div class="col-sm-2">
              <select class="form-control select2" name="category_id" id="category_id">
          
            </select>                    
            <span class="error-msg"><?php echo form_error("category_id");?></span>
            </div>
            <label class="col-sm-1 control-label">Receive Dept.</label>
            <div class="col-sm-2">
              <select class="form-control select2" name="take_department_id" id="take_department_id">
              <option value="All" <?php echo 'All'==set_value('department_id')? 'selected="selected"':0; ?>>All</option>
              <?php 
              foreach($dlist as $rows){  ?>
              <option value="<?php echo $rows->department_id; ?>" 
                <?php echo $rows->department_id==set_value('take_department_id')? 'selected="selected"':0; ?>>
                 <?php echo $rows->department_name; ?></option>
              <?php }  ?>
            </select>                    
            <span class="error-msg"><?php echo form_error("take_department_id");?></span>
            </div>
            
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">
           Item Code <span style="color:red;">  </span></label>
            <div class="col-sm-2">
              <input class="form-control" name="product_code" id="product_code" value="<?php echo set_value('product_code'); ?>" placeholder="Code">
            <span class="error-msg"><?php echo form_error("product_code");?></span>
            </div>
            <label class="col-sm-1 control-label">Date</label>
              <div class="col-sm-2">
                  <input type="text" name="from_date" readonly class="form-control date" placeholder="From Date" value="<?php if (isset($info))
                          echo $info->from_date;
                      else
                          echo set_value('from_date');
                      ?>">
                  <span class="error-msg"><?php echo form_error("from_date"); ?></span>
              </div>
              <div class="col-sm-2">
                  <input type="text" name="to_date" readonly class="form-control date" placeholder="To Date" value="<?php if (isset($info))
                          echo $info->to_date;
                      else
                          echo set_value('to_date');
                      ?>">
                  <span class="error-msg"><?php echo form_error("to_date"); ?></span>
              </div>
              <div class="col-sm-2">
                  <input type="text" name="employee_no"  class="form-control" placeholder="ID NO" value="<?php if (isset($info))
                          echo $info->employee_no;
                      else
                          echo set_value('employee_no');
                      ?>">
                  <span class="error-msg"><?php echo form_error("employee_no"); ?></span>
              </div>
              </div>
          <div class="form-group">
              <label class="col-sm-2 control-label">Main Area</label>
            <div class="col-sm-2">
              <select class="form-control select2" name="mlocation_id" id="mlocation_id">
              <option value="All" <?php echo 'All'==set_value('mlocation_id')? 'selected="selected"':0; ?>>All</option>
              <?php $mllist=$this->db->query("SELECT * FROM main_location")->result();
              foreach($mllist as $rows){  ?>
              <option value="<?php echo $rows->mlocation_id; ?>" 
                <?php echo $rows->mlocation_id==set_value('mlocation_id')? 'selected="selected"':0; ?>>
                 <?php echo $rows->mlocation_name; ?></option>
              <?php }  ?>
            </select>                    
            <span class="error-msg"><?php echo form_error("mlocation_id");?></span>
            </div>
            <label class="col-sm-1 control-label">Sub Location</label>
            <div class="col-sm-2">
              <select class="form-control select2" name="location_id" id="location_id">
              <option value="All" <?php echo 'All'==set_value('location_id')? 'selected="selected"':0; ?>>All</option>
              <?php $llist=$this->db->query("SELECT * FROM location_info")->result();
              foreach($llist as $rows){  ?>
              <option value="<?php echo $rows->location_id; ?>" 
                <?php echo $rows->location_id==set_value('location_id')? 'selected="selected"':0; ?>>
                 <?php echo $rows->location_name; ?></option>
              <?php }  ?>
            </select>                    
            <span class="error-msg"><?php echo form_error("location_id");?></span>
            </div>
            <div class="col-sm-1">
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
            <th style="text-align:center;width:10%">Issue Date</th>
            <th style="text-align:center;width:4%">Ref. No</th>
            <th style="width:15%;">Item/Materials Name</th>
            <th style="text-align:center;width:8%">Item Code 项目代码</th>
            <th style="text-align:center;width:8%">FIFO CODE</th>
            <th style="text-align:center;width:7%">Issue Qty</th>
            <th style="text-align:center;width:7%">Unit Price(Currency)</th>
            <th style="text-align:center;width:7%">Amount(HKD)</th>
            <th style="text-align:center;width:8%">Dept</th>
            <th style="text-align:center;width:8%">Location</th>
            <th style="text-align:center;width:7%">Employee</th>
            <th style="text-align:center;width:6%">Asset Code</th>
        </tr>
        </thead>
        <tbody>
        <?php $grandtotal=0; $grandpi=0;$grandamount=0;
        if(isset($resultdetail)&&!empty($resultdetail)): $i=1;
          foreach($resultdetail as $row):
            $grandtotal=$grandtotal+$row->quantity;
            $grandamount=$grandamount+$row->amount_hkd;
            ?>
            <tr>
              <td style="text-align:center;">
                <?php echo $i++; ?></td>
              <td style="text-align:center;">
                <?php echo findDate($row->issue_date);  ?></td>
              <td style="text-align:center;">
                <?php echo $row->issue_id; ?></td>
              <td style=""><?php echo $row->product_name;?></td>
              <td style="text-align:center;">
                <?php echo $row->product_code;  ?></td> 
              <td style="text-align:center;">
                <?php echo $row->FIFO_CODE;  ?></td> 
              <td style="vertical-align: text-top;text-align:center;">
              <?php  echo "$row->quantity $row->unit_name"; ?></td>
              <td style="vertical-align: text-top;text-align:center;">
              <?php  echo "$row->unit_price $row->currency"; ?></td>
              <td style="vertical-align: text-top;text-align:center;">
              <?php  echo $row->amount_hkd; ?></td>
              <td style="vertical-align: text-top;text-align:center;">
              <?php  echo $row->department_name; ?></td>
              <td style="vertical-align: text-top;text-align:center;">
              <?php  echo $row->location_name; ?></td>
              <td style="vertical-align: text-top;text-align:center;">
              <?php  echo "$row->employee_name($row->employee_id)"; ?></td>
              <td style="vertical-align: text-top;text-align:center;">
              <?php  echo $this->itemissuereport_model->getAssetCode($row->product_detail_id); ?></td>
            </tr>
            <?php
            endforeach;
        endif;
        ?>
        <tr>
            <th style="text-align:right;" colspan="6">
            Grand Total</th>
            <th style="text-align:center;">
            <?php echo $grandtotal; ?></th>
            <th style="text-align:right;"></th>
            <th style="text-align:center;">
                    <?php echo number_format($grandamount,2); ?> HKD</th>
            <th style="text-align:right;"></th>
            <th style="text-align:right;"></th>
            <th style="text-align:right;"></th>
            <th></th>
        </tr>
        </tbody>
        </table>
        </div>
    </div>
    <!-- /.box-body -->
    </div>
  </div>
 </div>
