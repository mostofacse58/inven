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
        var floor_id=$('#floor_id').val();
            if(floor_id !=''){
            $.ajax({
              type:"post",
              url:"<?php echo base_url()?>"+'me/downtimereport/getMachineTPM',
              data:{floor_id:floor_id},
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
      $('#floor_id').on('change',function(){
        var floor_id=$('#floor_id').val();
            if(floor_id !=''){
            $.ajax({
              type:"post",
              url:"<?php echo base_url()?>"+'me/downtimereport/getMachineTPM',
              data:{floor_id:floor_id},
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
      <form class="form-horizontal" action="<?php echo base_url();?>me/downtimereport/reportrResult" method="POST" enctype="multipart/form-data">
        <div class="box-body">
          <div class="form-group">
            <label class="col-sm-2 control-label">Floor Name <span style="color:red;">  *</span></label>
            <div class="col-sm-3">
              <select class="form-control" name="floor_id" id="floor_id">
              <option value="" selected="selected">Select Floor Name</option>
              <option value="All">All</option>
              <?php foreach($flist as $rows){  ?>
              <option value="<?php echo $rows->floor_id; ?>" 
                <?php if(isset($info->floor_id))echo $rows->floor_id==$info->floor_id? 'selected="selected"':0; else
                 echo $rows->floor_id==set_value('floor_id')? 'selected="selected"':0; ?>>
                 <?php echo $rows->floor_no; ?></option>
              <?php }  ?>
            </select>                    
            <span class="error-msg"><?php echo form_error("floor_id");?></span>
            </div>
            <label class="col-sm-3 control-label">Product Name(TPM CODE (TPM代码)) <span style="color:red;">  *</span></label>
            <div class="col-sm-4">
              <select class="form-control select2" name="product_detail_id" id="product_detail_id">
                <option value="All" selected="selected">All</option>
              </select>

            <span class="error-msg"><?php echo form_error("product_detail_id");?></span>
            </div>
          </div>
          <div class="form-group">
                   <label class="col-sm-2 control-label">From Date<span style="color:red;">  *</span></label>

                        <div class="col-sm-3">
                            <input type="text" name="from_date"   class="form-control date" id="inputEmail3" placeholder="From Date" value="<?php if (isset($info))
                                    echo $info->from_date;
                                else
                                    echo set_value('from_date');
                                ?>">
                            <span class="error-msg"><?php echo form_error("from_date"); ?></span>
                        </div>
                         <label class="col-sm-3 control-label">To Date<span style="color:red;">  *</span></label>

                        <div class="col-sm-3">
                            <input type="text" name="to_date"   class="form-control date" id="inputEmail3" placeholder="To Date" value="<?php if (isset($info))
                                    echo $info->to_date;
                                else
                                    echo set_value('to_date');
                                ?>">
                            <span class="error-msg"><?php echo form_error("to_date"); ?></span>
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
