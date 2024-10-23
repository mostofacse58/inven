<script src="<?php echo base_url('asset/js/plugins/datepicker/bootstrap-datepicker.js'); ?>"></script>
<script>
  $(document).ready(function(){
     $('.date').datepicker({
          "format": "dd/mm/yyyy",
          "todayHighlight": true,
          "autoclose": true
      });
     <?php if(isset($box_id)){ ?>
    var box_ids = "<?php echo $box_id; ?>";
    <?php  }else{ ?>
      var box_ids = "<?php echo set_value('box_id') ?>";
    <?php }?>
  ///////////////////
  var category_ids = "<?php echo set_value('category_id') ?>";
  
  var department_id=$('#department_id').val();
      if(department_id !=''){
      $.ajax({
        type:"post",
        url:"<?php echo base_url()?>"+'commonr/ritemstock/getcategory',
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
        url:"<?php echo base_url()?>"+'commonr/ritemstock/getcategory',
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
  ////////////////////////
     var rack_id=$('#rack_id').val();
          if(rack_id !=''){
          $.ajax({
            type:"post",
            url:"<?php echo base_url()?>"+'commonr/ritemstock/getBox/',
            data:{rack_id:rack_id},
            success:function(data){
              $("#box_id").empty();
              $("#box_id").append(data);
              if(box_ids != ''){
                $('#box_id').val(box_ids).change();
              }
            }
          });
        }
    ///////////////////////
    $('#rack_id').on('change',function(){
      var rack_id=$('#rack_id').val();
        if(rack_id !=''){
        $.ajax({
          type:"post",
          url:"<?php echo base_url()?>"+'commonr/ritemstock/getBox',
          data:{rack_id:rack_id},
          success:function(data){
            $("#box_id").empty();
            $("#box_id").append(data);
            if(box_ids != ''){
              $('#box_id').val(box_ids).change();
            }
          }
        });
      }
    });
  });
</script>
<style type="text/css">
.colortd td{background-color:#FFDF00; }
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
<a class="btn btn-sm btn-primary pull-right" style="margin-right:0px;" href="<?php echo base_url(); ?>commonr/ritemstock/downloadExcel<?php echo "/$category_id/$rack_id/$box_id/$department_id/$product_code";  ?>">
<i class="fa fa-file-excel-o"></i>
Download Excel
</a>
<a class="btn btn-sm btn-primary pull-right" style="margin-right:0px;" href="<?php echo base_url(); ?>commonr/ritemstock/downloadPdf<?php echo "/$category_id/$rack_id/$box_id/$department_id/$product_code";  ?>">
<i class="fa fa-file-pdf-o"></i>
Download PDF
</a>
<?php } ?>
</div>
</div>
</div>

</div>
<div class="box box-info">
    <!-- form start -->
    <form class="form-horizontal" action="<?php echo base_url();?>commonr/ritemstock/reportrResult" method="POST" enctype="multipart/form-data">
      <div class="box-body">
        <div class="form-group">
          <label class="col-sm-2 control-label">
          Holder Department</label>
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
          <label class="col-sm-1 control-label">Rack</label>
          <div class="col-sm-2">
            <select class="form-control" name="rack_id" id="rack_id">
            <option value="All" <?php echo 'All'==set_value('rack_id')? 'selected="selected"':0; ?>>All</option>
            <?php $department_id=$this->session->userdata('department_id');
            $rlist=$this->db->query("SELECT * FROM rack_info WHERE department_id=$department_id")->result();
            foreach($rlist as $rows){  ?>
            <option value="<?php echo $rows->rack_id; ?>" 
              <?php echo $rows->rack_id==set_value('rack_id')? 'selected="selected"':0; ?>>
               <?php echo $rows->rack_name; ?></option>
            <?php }  ?>
          </select>                    
          <span class="error-msg"><?php echo form_error("rack_id");?></span>
          </div>
          
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">
          Box Name<span style="color:red;">  </span></label>
        <div class="col-sm-2">
          <select class="form-control select2" name="box_id" id="box_id">
            <option value="All" selected="selected">All</option>
            </select>
            <span class="error-msg"><?php echo form_error("box_id"); ?></span>
          </div>          
          <label class="col-sm-2 control-label">
          Search 搜索<span style="color:red;">  *</span></label>
          <div class="col-sm-3">
            <input class="form-control" name="product_code" id="product_code" value="<?php echo set_value('product_code'); ?>" placeholder="write as like Model,Code,Name">
          <span class="error-msg"><?php echo form_error("product_code");?></span>
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
                <th style="width:15%;">Item/Materials Name</th>
                <th style="width:10%">Category Name 分类名称</th>
                <th style="text-align:center;width:10%">Rack(Box)</th>
                <th style="text-align:center;width:10%">Item Code 项目代码</th>
                <th style="text-align:center;width:7%">Safety Stock</th>
                <th style="text-align:center;width:8%">Re-order Qty</th>
                <th style="text-align:center;width:8%">Stock Qty</th>
                <th style="text-align:center;width:8%">Unit Price</th>
                <th style="text-align:center;width:8%">Currency</th>
                <th style="text-align:center;width:10%">Stock Value(HKD)</th>
            </tr>
            </thead>
            <tbody>
            <?php $grandtotal=0; $totalvalue=0;$grandpi=0;
            if(isset($resultdetail)&&!empty($resultdetail)): $i=1;
              foreach($resultdetail as $row):
                $stock=$row->main_stock;
                $grandtotal=$grandtotal+$stock;
                $totalvalue=$totalvalue+$row->stock_value_hkd;
                $color="background-color: #FFF;color: #000;";
                $color2="background-color: #FFF;color: #000;";
                if($stock<$row->minimum_stock){
                  $color="background-color: #CE3130;color: #FFF;";
                }
                if($stock<$row->re_order_qty){
                  $color2="background-color: #FFDF00;color: #000;";
                } 
                ?>
                <tr>
                  <td style="text-align:center;background-color: #FFF;color: #000;">
                    <?php echo $i++; ?></td>
                  <td style="background-color: #FFF;color: #000;"><?php echo $row->product_name;?></td>
                  <td style="text-align:center;background-color: #FFF;color: #000;">
                    <?php echo $row->category_name; ?></td>
                  <td style="text-align:center;background-color: #FFF;color: #000;">
                    <?php echo $row->rack_name;  ?></td>
                    <td style="text-align:center;background-color: #FFF;color: #000;">
                    <?php echo $row->product_code;  ?></td> 
                  <td style="vertical-align: text-top;text-align:center;<?php echo $color; ?>">
                  <?php  echo $row->minimum_stock; ?></td>
                  <td style="vertical-align: text-top;text-align:center;<?php echo $color2; ?>">
                  <?php  echo $row->re_order_qty; ?></td>
                  <td style="vertical-align: text-top;text-align:center;background-color: #FFF;color: #000;">
                  <?php  echo "$stock $row->unit_name"; ?></td>
                  <td style="text-align:center;background-color: #FFF;color: #000;">
                      <?php echo $row->unit_price;  ?></td>
                  <td style="vertical-align: text-top;text-align:center;background-color: #FFF;color: #000;>">
                  <?php  echo $row->currency; ?></td>
                  <td style="vertical-align: text-top;text-align:right;background-color: #FFF;color: #000;">
                  <?php  echo number_format($row->stock_value_hkd,2); ?></td>
                </tr>
                <?php
                endforeach;
            endif;
            ?>
            <tr>
                <th style="text-align:right;" colspan="7">Grand Total</th>
                <th style="text-align:center;"><?php echo $grandtotal; ?></th>
                <th style="text-align:center;"></th>
                <th style="text-align:center;"></th>
                <th style="text-align:right;"><?php echo number_format($totalvalue,2); ?></th>
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
