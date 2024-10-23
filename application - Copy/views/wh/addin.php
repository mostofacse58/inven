  <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>asset/datepickerbootstrap/css/datepicker.css">
<script type="text/javascript" src="<?php echo base_url();?>asset/datepickerbootstrap/js/bootstrap-datepicker.js"></script>

<script>
 $(document).ready(function(){
  //////////////////date picker//////////////////////
      $('.date').datepicker({
        "format":"dd/mm/yyyy",
        "todayHighlight": true,
        "autoclose":true
      });
  });
</script>

<div class="row">
  <div class="col-md-12">
    <div class="panel panel-success">
      <div class="box-header">
<div class="widget-block">
<div class="widget-head">
<h5><?php echo ucwords($heading); ?></h5>
<div class="widget-control pull-right">

</div>
</div>
</div>
</div>
   <div class="box box-info">
        <!-- form start -->
      <form class="form-horizontal" action="<?php echo base_url();?>wh/stockin/save<?php if(isset($info)) echo "/$info->id"; ?>" method="POST" enctype="multipart/form-data">
        <div class="box-body">
          <div class="form-group">
            <label class="col-sm-3 control-label">CUSTOMER 顾客<span style="color:red;">  *</span></label>
            <div class="col-sm-3">
              <input type="text" name="customer" required class="form-control" placeholder="customer" value="<?php if(isset($info)) echo $info->customer; else echo set_value('customer'); ?>">
             <span class="error-msg"><?php echo form_error("customer");?></span>
            </div>
           <label class="col-sm-3 control-label">FILE 文件</label>
            <div class="col-sm-3">
               <input type="text" name="file_no"  class="form-control" placeholder="FILE" value="<?php if(isset($info)) echo $info->file_no; else echo set_value('file_no'); ?>">
              <span class="error-msg"><?php echo form_error("file_no"); ?></span>
            </div>                  
          </div>
           <div class="form-group">
            <label class="col-sm-3 control-label">PO NO 订单号<span style="color:red;">  </span></label>
            <div class="col-sm-3">
              <input type="text" name="po_no" placeholder="PO NO 订单号" class="form-control" value="<?php if(isset($info)) echo $info->po_no; else echo set_value('po_no'); ?>"> 
              <span class="error-msg"><?php echo form_error("po_no"); ?></span>
            </div>
             <label class="col-sm-3 control-label">
              CARTON NO 纸箱编号 <span style="color:red;">  </span></label>
            <div class="col-sm-3">
              <input type="text" name="carton_no" class="form-control" value="<?php if(isset($info)) echo $info->carton_no; else echo set_value('carton_no'); ?>"> 
              <span class="error-msg"><?php echo form_error("carton_no"); ?></span>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label">
              BAG QUANTITY 袋子数量<span style="color:red;">  *</span></label>
          <div class="col-sm-3">
            <input type="text" name="bag_qty"  class="form-control integerchk" value="<?php if(isset($info)) echo $info->bag_qty; else echo set_value('bag_qty');  ?>"> 
            <span class="error-msg"><?php echo form_error("bag_qty"); ?></span>
          </div>
           <label class="col-sm-3 control-label">
              FACTORY STYLE 工厂风格 <span style="color:red;">  </span></label>
            <div class="col-sm-3">
              <input type="text" name="factory_style" class="form-control" value="<?php if(isset($info)) echo $info->factory_style; else echo set_value('factory_style'); ?>"> 
              <span class="error-msg"><?php echo form_error("factory_style"); ?></span>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">
              CUSTOMER STYLE 客户风格 <span style="color:red;">  *</span></label>
          <div class="col-sm-3">
            <input type="text" name="customer_syle"  class="form-control" value="<?php if(isset($info)) echo $info->customer_syle; else echo set_value('customer_syle');  ?>"> 
            <span class="error-msg"><?php echo form_error("customer_syle"); ?></span>
          </div>
           <label class="col-sm-3 control-label">
              COLOR 颜色 <span style="color:red;">  </span></label>
            <div class="col-sm-3">
              <input type="text" name="color" class="form-control" value="<?php if(isset($info)) echo $info->color; else echo set_value('color'); ?>"> 
              <span class="error-msg"><?php echo form_error("color"); ?></span>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">
              BARCODE NO 条形码编号<span style="color:red;">  *</span></label>
          <div class="col-sm-3">
            <input type="text" name="barcode_no"  class="form-control" value="<?php if(isset($info)) echo $info->barcode_no; else echo set_value('barcode_no');  ?>"> 
            <span class="error-msg"><?php echo form_error("barcode_no"); ?></span>
          </div>
           <label class="col-sm-3 control-label">
              INVOICE NUMBER 发票编号 <span style="color:red;">  </span></label>
            <div class="col-sm-3">
              <input type="text" name="export_invoice_no" class="form-control" value="<?php if(isset($info)) echo $info->export_invoice_no; else echo set_value('export_invoice_no'); ?>"> 
              <span class="error-msg"><?php echo form_error("export_invoice_no"); ?></span>
            </div>
        </div>
        <div class="form-group">
         <label class="col-sm-3 control-label">LOCATION 地点</label>
             <div class="col-sm-3">
              <select class="form-control select2" name="location" id="location">
                <option value="">Select 选择</option>
                <?php 
                foreach ($llists as $value) {  ?>
                  <option value="<?php echo $value->location; ?>"
                    <?php  if(isset($info)) echo $value->location==$info->location? 'selected="selected"':0; else echo set_select('location',$value->location);?>>
                    <?php echo $value->location; ?></option>
                  <?php } ?>
              </select>
             <span class="error-msg"><?php echo form_error("location");?></span>
           </div>
    </div><!-- ///////////////////// -->

      </div>
        <!-- /.box-body -->
        <div class="box-footer">
           <div class="col-sm-3"><a href="<?php echo base_url(); ?>wh/stockin/lists" class="btn btn-info"><i class="fa fa-arrow-circle-o-left" aria-hidden="true"></i> Back</a></div>
           <div class="col-sm-3">
          <button type="submit" class="btn btn-info pull-right">SAVE 保存</button>
          </div>
        </div>
        <!-- /.box-footer -->
      </form>
    </div>
  </div>
   
   </div>
 </div>
 
