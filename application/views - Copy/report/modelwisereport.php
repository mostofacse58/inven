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
<a class="btn btn-sm btn-primary pull-right" style="margin-right:0px;" href="<?php echo base_url(); ?>me/modelwisereport/downloadExcel<?php echo "/$category_id/$product_id/$floor_id/$tpm_serial_code";  ?>">
<i class="fa fa-file-excel-o"></i>
Download
</a>
<?php } ?>
</div>
</div>
</div>

</div>
<div class="box box-info">
      <!-- form start -->
      <form class="form-horizontal" action="<?php echo base_url();?>me/modelwisereport/reportResult" method="POST" enctype="multipart/form-data">
        <div class="box-body">
          <div class="form-group">
          <label class="col-sm-2 control-label">Machine Model</label>
           <div class="col-sm-5">
              <select class="form-control select2" name="product_id" id="product_id">
              <option value="All">All</option>
              <?php foreach($plist as $rows){  ?>
              <option value="<?php echo $rows->product_id; ?>" 
                <?php if(isset($product_id))echo $rows->product_id==$product_id? 'selected="selected"':0; else
                 echo $rows->product_id==set_value('product_id')? 'selected="selected"':0; ?>>
                 <?php echo $rows->product_name; ?></option>
              <?php }  ?>
            </select>                    
            <span class="error-msg"><?php echo form_error("product_id");?></span>
            </div>
            <div class="col-sm-1">
            <button type="submit" class="btn btn-success pull-left"> Search 搜索 </button>
          </div>
          </div>
        </div>
        <!-- /.box-body -->
       <!--  <div class="box-footer">
           <div class="col-sm-6"></div>
           <div class="col-sm-2">
          <button type="submit" class="btn btn-info pull-left">Result</button>
          </div>
        </div> -->
      </form>
    </div>
      <!-- /.box-header -->

      <!-- /.box-body -->
    </div>
  </div>
 </div>
