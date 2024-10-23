<script src="<?php echo base_url('asset/js/plugins/datepicker/bootstrap-datepicker.js'); ?>"></script>
<script src="<?php echo base_url('asset/js/plugins/datepicker/bootstrap-datepicker.js'); ?>"></script>
<script>
    $(document).ready(function(){
       $('.date').datepicker({
            "format": "dd/mm/yyyy",
            "todayHighlight": true,
            "autoclose": true
        });
       
       var product_detail_ids = "<?php echo set_value('product_detail_id') ?>";
        var category_id=$('#category_id').val();
            if(category_id !=''){
            $.ajax({
              type:"post",
              url:"<?php echo base_url()?>"+'me/spareusingreport/getMachineTPM',
              data:{category_id:category_id},
              success:function(data){
                $("#product_detail_id").empty();
                $("#product_detail_id").append(data);
                if(product_detail_ids != ''){
                  $('#product_detail_id').val(product_detail_ids).change();
                }
              }
            });
          }
      ///////////////////////
      $('#category_id').on('change',function(){
        var category_id=$('#category_id').val();
            if(category_id !=''){
            $.ajax({
              type:"post",
              url:"<?php echo base_url()?>"+'me/spareusingreport/getMachineTPM',
              data:{category_id:category_id},
              success:function(data){
                $("#product_detail_id").empty();
                $("#product_detail_id").append(data);
                if(product_detail_ids != ''){
                  $('#product_detail_id').val(product_detail_ids).change();
                }
              }
            });
          }
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

</div>
</div>
</div>

</div>
<div class="box box-info">
      <!-- form start -->
      <form class="form-horizontal" action="<?php echo base_url();?>me/spareusingreport/reportrResult" method="POST" enctype="multipart/form-data">
        <div class="box-body">
          <div class="form-group">
            <label class="col-sm-2 control-label">Category Name 分类名称 <span style="color:red;">  *</span></label>
            <div class="col-sm-3">
              <select class="form-control" name="category_id" id="category_id">
              <option value="All">All</option>
              <?php foreach($clist as $rows){  ?>
              <option value="<?php echo $rows->category_id; ?>" 
                <?php if(isset($info->category_id))echo $rows->category_id==$info->category_id? 'selected="selected"':0; else
                 echo $rows->category_id==set_value('category_id')? 'selected="selected"':0; ?>>
                 <?php echo $rows->category_name; ?></option>
              <?php }  ?>
            </select>                    
            <span class="error-msg"><?php echo form_error("category_id");?></span>
            </div>
            <label class="col-sm-3 control-label">Product Name(TPM CODE (TPM代码)) <span style="color:red;">  *</span></label>
            <div class="col-sm-4">
              <select class="form-control select2" name="product_detail_id" id="product_detail_id">
                <option value="" selected="selected">Select Machine TPM</option>
                <option value="All" selected="">All</option>
              </select>

            <span class="error-msg"><?php echo form_error("product_detail_id");?></span>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-1 control-label">Use Type <span style="color:red;">  *</span></label>
            <div class="col-sm-2">
              <select class="form-control" name="use_type" id="use_type">
              <option value="All">All</option>
              <option value="1"> Machine</option>
              <option value="2"> Others</option>
            </select>                    
            <span class="error-msg"><?php echo form_error("use_type");?></span>
            </div>
            <label class="col-sm-1 control-label">Location </label>
            <div class="col-sm-2">
              <select class="form-control select2"  name="floor_id" id="floor_id">
                <option value="All">All</option>
                <?php
                 foreach ($flist as $value) {  ?>
                <option value="<?php echo $value->floor_id; ?>"
                    <?php  if(isset($floor_id)) echo $value->floor_id==$floor_id? 'selected="selected"':0; else echo set_select('floor_id',$value->floor_id);?>>  <?php echo $value->floor_no; ?></option>
                  <?php } ?>
              </select>
            </div>
              <div class="col-sm-2">
                  <input type="text" name="from_date" readonly  class="form-control date" id="inputEmail3" placeholder="From Date" value="<?php if (isset($info))
                          echo $info->from_date;
                      else
                          echo set_value('from_date');
                      ?>">
                  <span class="error-msg"><?php echo form_error("from_date"); ?></span>
              </div>
              <div class="col-sm-2">
                  <input type="text" name="to_date"  readonly class="form-control date" id="inputEmail3" placeholder="To Date" value="<?php if (isset($info))
                          echo $info->to_date;
                      else
                          echo set_value('to_date');
                      ?>">
                  <span class="error-msg"><?php echo form_error("to_date"); ?></span>
              </div>
              <div class="col-sm-2">
                  <input type="text" name="product_code"  class="form-control" placeholder="Product Code" value="<?php if (isset($info))
                          echo $info->product_code;
                      else
                          echo set_value('product_code');
                      ?>">
                  <span class="error-msg"><?php echo form_error("product_code"); ?></span>
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
    </div>
      <!-- /.box-header -->

      <!-- /.box-body -->
    </div>
  </div>
 </div>
