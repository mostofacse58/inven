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
<a class="btn btn-sm btn-primary pull-right" style="margin-right:0px;" href="<?php echo base_url(); ?>commonr/Supplieritem/downloadExcel<?php 
 if($department_id!='') echo "/$department_id"; else echo "/All";
 if($category_id!='') echo "/$category_id"; else echo "/All"; 
 if($supplier_id!='') echo "/$supplier_id"; else echo "/All"; 
 if($product_code!='') echo "/$product_code"; else echo "/All";
 if($reference_no!='') echo "/$reference_no"; else echo "/All";
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
  <form class="form-horizontal" action="<?php echo base_url();?>commonr/Supplieritem/reportrResult" method="POST" enctype="multipart/form-data">
        <div class="box-body">
          <div class="form-group">
            <label class="col-sm-2 control-label">Holder Department</label>
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
            <label class="col-sm-2 control-label">Category 分类名称<span style="color:red;">  *</span></label>
            <div class="col-sm-2">
              <select class="form-control select2" name="category_id" id="category_id">
              <option value="All" <?php echo 'All'==set_value('category_id')? 'selected="selected"':0; ?>>All</option>
            </select>                    
            <span class="error-msg"><?php echo form_error("category_id");?></span>
            </div>
            <label class="col-sm-2 control-label">Supplier</label>
            <div class="col-sm-2">
              <select class="form-control select2" name="supplier_id" id="supplier_id">
              	<option value="All" <?php echo 'All'==set_value('supplier_id')? 'selected="selected"':0; ?>>All</option>
              <?php 
              foreach($palist as $rows){  ?>
              <option value="<?php echo $rows->supplier_id; ?>" 
                <?php if(isset($supplier_id)) echo $rows->supplier_id==$supplier_id? 'selected="selected"':0; ?>>
                 <?php echo $rows->supplier_name; ?></option>
              <?php }  ?>
            </select>                     
            <span class="error-msg"><?php echo form_error("supplier_id");?></span>
            </div>
            </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">
               Ref. No<span style="color:red;">  </span></label>
                <div class="col-sm-2">
                  <input class="form-control" name="reference_no" id="reference_no" value="<?php echo set_value('reference_no'); ?>" placeholder="reference_no">
                <span class="error-msg"><?php echo form_error("reference_no");?></span>
                </div>
            
          
            <label class="col-sm-2 control-label">
           Item Code <span style="color:red;">  </span></label>
            <div class="col-sm-2">
              <input class="form-control" name="product_code" id="product_code" value="<?php echo set_value('product_code'); ?>" placeholder="Code">
            <span class="error-msg"><?php echo form_error("product_code");?></span>
            </div>
            </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">From Date</label>
              <div class="col-sm-2">
                  <input type="text" name="from_date" readonly  class="form-control date" id="inputEmail3" placeholder="From Date" value="<?php if (isset($info))
                          echo $info->from_date;
                      else
                          echo set_value('from_date');
                      ?>">
                  <span class="error-msg"><?php echo form_error("from_date"); ?></span>
              </div>
               <label class="col-sm-2 control-label">To Date</label>
              <div class="col-sm-2">
                  <input type="text" name="to_date"  readonly class="form-control date" id="inputEmail3" placeholder="To Date" value="<?php if (isset($info))
                          echo $info->to_date;
                      else
                          echo set_value('to_date');
                      ?>">
                  <span class="error-msg"><?php echo form_error("to_date"); ?></span>
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
                  <th style="text-align:center;width:7%">Supplier Name</th>
                  <th style="text-align:center;width:10%">Receive Date</th>
                  <th style="text-align:center;width:10%">Ref/Invoice</th>
                  <th style="width:15%;">Item/Materials Name</th>
                  <th style="text-align:center;width:10%">Item Code 项目代码</th>
                  <th style="text-align:center;width:7%">FIFO NO</th>
                  <th style="text-align:center;width:7%">Receive Qty</th>
                  <th style="text-align:center;width:7%">Unit Price(Currency)</th>
                  <th style="text-align:center;width:7%">Amount(HKD)</th>
                  <th style="text-align:center;width:7%">PI NO</th>
                  <th style="text-align:center;width:7%">Specification</th>
              </tr>
              </thead>
              <tbody>
              <?php $grandtotal=0; $grandamount=0;
              if(isset($resultdetail)&&!empty($resultdetail)): $i=1;
                foreach($resultdetail as $row):
                  $grandtotal=$grandtotal+$row->quantity;
                  $grandamount=$grandamount+$row->amount_hkd;
                  ?>
                  <tr>
                    <td style="text-align:center;">
                      <?php echo $i++; ?></td>
                     <td style="text-align:center;">
                      <?php echo $row->supplier_name;  ?></td>
                    <td style="text-align:center;">
                      <?php echo findDate($row->purchase_date);  ?></td>
                    <td style="text-align:center;">
                      <?php echo $row->reference_no;  ?></td> 
                    <td style=""><?php echo $row->product_name;?></td>
                    <td style="text-align:center;">
                      <?php echo $row->product_code;  ?></td> 
                    <td style="text-align:center;">
                      <?php echo $row->FIFO_CODE;  ?></td> 
                    <td style="vertical-align: text-top;text-align:center;">
                    <?php  echo "$row->quantity $row->unit_name"; ?></td>
                    <td style="text-align:center;">
                      <?php echo "$row->unit_price $row->currency";  ?></td> 
                    <td style="text-align:center;">
                      <?php echo $row->amount_hkd;  ?></td> 
                    <td style="text-align:center;">
                      <?php echo $row->pi_no;  ?></td> 
                    <td style="text-align:center;">
                       <?php echo $row->specification;  ?></td>
                     
                    </tr>
                  <?php
                  endforeach;
              endif;
              ?>
              <tr>
                  <th style="text-align:right;" colspan="7">Grand Total</th>
                  <th style="text-align:center;"><?php echo $grandtotal; ?> </th>
                  <th style="text-align:center;"></th>
                  <th style="text-align:center;">
                    <?php echo number_format($grandamount,2); ?> HKD</th>
                  <th style="text-align:center;"></th>
                  <th></th>
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
