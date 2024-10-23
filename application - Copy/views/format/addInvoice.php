<div class="row">
    <div class="col-md-12">
        <div class="box box-info">
      <!-- /.box-header -->
    <form class="form-horizontal" action="<?php echo base_url(); ?>format/grn/submit<?php if (isset($info)) echo "/$info->purchase_id"; ?>" method="POST" enctype="multipart/form-data" onsubmit="return formsubmit();">
         <div class="box-body">
         <div class="form-group">
          <label class="col-sm-3 control-label">PO No : <?php echo $info->po_number; ?></label>
          <label class="col-sm-2 control-label">Ref No : <?php echo $info->reference_no; ?></label>
          <label class="col-sm-2 control-label">Invoice No 发票号码<span style="color:red;"> * </span></label>
          <div class="col-sm-2">
            <input type="text" name="invoice_no" id="invoice_no" class="form-control pull-right" value="<?php if(isset($info)) echo $info->invoice_no; else echo set_value('invoice_no'); ?>" required>
          </div>
      </div><!-- ///////////////////// -->
</div>
  <!-- /.box-body -->
  <div class="box-footer">
  <div class="col-sm-4"><a href="<?php echo base_url(); ?>format/grn/lists" class="btn btn-info">
    <i class="fa fa-arrow-circle-o-left" aria-hidden="true"></i> 
    Back</a></div>
  <div class="col-sm-4">
      <button type="submit" class="btn btn-info pull-right">Send 发送</button>
  </div>
  </div>
  <!-- /.box-footer -->
</form>
</div>
</div>
</div>
