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
          <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" action="<?php echo base_url();?>me/machine/save<?php if(isset($info)) echo "/$info->product_id"; ?>" method="POST" enctype="multipart/form-data">
              <div class="box-body">
                <div class="form-group">
                  <label class="col-sm-2 control-label">English Name <span style="color:red;">  *</span></label>
                  <div class="col-sm-4">
                    <input type="text" name="product_name" required class="form-control" placeholder="English Name" value="<?php if(isset($info->product_name)) echo $info->product_name; else echo set_value('product_name'); ?>">
                   <span class="error-msg"><?php echo form_error("product_name");?></span>
                  </div>
                 <label class="col-sm-2 control-label">Chinese Name </label>
                  <div class="col-sm-4">
                     <input type="text" name="china_name"  class="form-control" placeholder="Chinese Name" value="<?php if(isset($info->china_name)) echo $info->china_name; else echo set_value('china_name'); ?>">
                    <span class="error-msg"><?php echo form_error("china_name"); ?></span>
                  </div>                  
                </div>
                 <div class="form-group">
                  <label class="col-sm-2 control-label">Category Name 分类名称<span style="color:red;">  *</span></label>
                  <div class="col-sm-4">
                    <select class="form-control select2" required name="category_id" id="category_id">
                      <option value="">Select Category</option>
                      <?php foreach ($clist as $value) {  ?>
                        <option value="<?php echo $value->category_id; ?>"
                          <?php  if(isset($info)) echo $value->category_id==$info->category_id? 'selected="selected"':0; else echo set_select('category_id',$value->category_id);?>>
                          <?php echo $value->category_name; ?></option>
                        <?php } ?>
                    </select>
                   <span class="error-msg"><?php echo form_error("category_id");?></span>
                  </div>
                  <label class="col-sm-2 control-label">Brand Name <span style="color:red;">  *</span></label>
                  <div class="col-sm-3">
                  <select class="form-control select2" required name="brand_id" id="brand_id">
                      <option value="">Select Brand</option>
                      <?php foreach ($blist as $value) {  ?>
                        <option value="<?php echo $value->brand_id; ?>"
                          <?php  if(isset($info)) echo $value->brand_id==$info->brand_id? 'selected="selected"':0; else echo set_select('brand_id',$value->brand_id);?>>
                          <?php echo $value->brand_name; ?></option>
                        <?php } ?>
                    </select>
                   <span class="error-msg"><?php echo form_error("brand_id");?></span>
                  </div>
                 
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label">Product Model<span style="color:red;">  *</span></label>
                  <div class="col-sm-4">
                    <input type="text" name="product_model"  class="form-control" value="<?php if(isset($info)) echo $info->product_model; else echo set_value('product_model'); ?>"> 
                    <span class="error-msg"><?php echo form_error("product_model"); ?></span>
                  </div>
                  <label class="col-sm-2 control-label">Machine Type 机器的种类</label>
                  <div class="col-sm-3">
                    <select class="form-control select2" name="machine_type_id" id="machine_type_id">
                      <option value="">Select Machine Type 机器的种类</option>
                      <?php foreach ($mtlist as $value) {  ?>
                        <option value="<?php echo $value->machine_type_id; ?>"
                          <?php  if(isset($info)) echo $value->machine_type_id==$info->machine_type_id? 'selected="selected"':0; else echo set_select('machine_type_id',$value->machine_type_id);?>>
                          <?php echo $value->machine_type_name; ?></option>
                        <?php } ?>
                    </select>
                   <span class="error-msg"><?php echo form_error("mtype_id");?></span>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label">Material Type</label>
                   <div class="col-sm-4">
                    <select class="form-control select2" name="mtype_id" id="mtype_id">
                      <option value="">Select Material Type</option>
                      <?php foreach ($mlist as $value) {  ?>
                        <option value="<?php echo $value->mtype_id; ?>"
                          <?php  if(isset($info)) echo $value->mtype_id==$info->mtype_id? 'selected="selected"':0; else echo set_select('mtype_id',$value->mtype_id);?>>
                          <?php echo $value->mtype_name; ?></option>
                        <?php } ?>
                    </select>
                   <span class="error-msg"><?php echo form_error("mtype_id");?></span>
                 </div>
               <label class="col-sm-2 control-label">Unit</label>
                   <div class="col-sm-3">
                    <select class="form-control select2" name="unit_id" id="unit_id">
                      <option value="">Select Unit</option>
                      <?php 
                      $ulist=$this->db->query("SELECT * FROM product_unit")->result();
                      foreach ($ulist as $value) {  ?>
                        <option value="<?php echo $value->unit_id; ?>"
                          <?php  if(isset($info)) echo $value->unit_id==$info->unit_id? 'selected="selected"':0; else echo set_select('unit_id',$value->unit_id);?>>
                          <?php echo $value->unit_name; ?></option>
                        <?php } ?>
                    </select>
                   <span class="error-msg"><?php echo form_error("unit_id");?></span>
                 </div>
          </div><!-- ///////////////////// -->
          <div class="form-group">
               
                 <label class="col-sm-2 control-label">Minimum Stock  Qty<span style="color:red;">  *</span></label>
                <div class="col-sm-3">
                  <input type="text" name="minimum_stock"  class="form-control integerchk" value="<?php if(isset($info)) echo $info->minimum_stock; else echo '0'; ?>"> 
                  <span class="error-msg"><?php echo form_error("minimum_stock"); ?></span>
                </div>
              </div>

          <div class="form-group">
            <label class="col-sm-2 control-label">Description</label>
            <div class="col-sm-4">
              <textarea  name="note" class="form-control" rows="2"><?php if(isset($info)) echo $info->product_description; else echo set_value('product_description'); ?> </textarea>
               <span class="error-msg"><?php echo form_error("product_description");?></span>
            </div>
                <label class="col-sm-2 control-label">Product Picture</label>
                    <div class="col-sm-3">
                        <input type="file" class="form-control"  name="product_image">
                      <?php if (isset($info->product_image) &&!empty($info->product_image)) { ?>
                        <div style="margin-top:20px;">
                        <img src="<?php echo base_url(); ?>product/<?php echo $info->product_image; ?>" class="img-thumbnail" style="width:100px;height:auto;"/>
                        </div>
                      <?php } ?>
                    </div>
          </div><!-- ///////////////////// -->
         </div>
              <!-- /.box-body -->
              <div class="box-footer">
                 <div class="col-sm-4"><a href="<?php echo base_url(); ?>me/machine/lists" class="btn btn-info"><i class="fa fa-arrow-circle-o-left" aria-hidden="true"></i> Back</a></div>
                 <div class="col-sm-4">
                <button type="submit" class="btn btn-info pull-right">SAVE 保存</button>
                </div>
              </div>
              <!-- /.box-footer -->
            </form>
          </div>
        </div>
   
   </div>
 </div>
 
