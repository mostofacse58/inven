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
      <form class="form-horizontal" action="<?php echo base_url();?>medical/items/save<?php if(isset($info)) echo "/$info->product_id"; ?>" method="POST" enctype="multipart/form-data">
        <div class="box-body">
          <div class="form-group">
            <label class="col-sm-2 control-label">Medicine Name <span style="color:red;">  *</span></label>
            <div class="col-sm-4">
              <input type="text" name="product_name" required class="form-control" placeholder="Medicine Name" value="<?php if(isset($info->product_name)) echo $info->product_name; else echo set_value('product_name'); ?>">
             <span class="error-msg"><?php echo form_error("product_name");?></span>
            </div>
           <label class="col-sm-2 control-label">Medicine Name </label>
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
            <label class="col-sm-2 control-label">Model<span style="color:red;">  </span></label>
            <div class="col-sm-4">
              <input type="text" name="product_model" placeholder="Model" class="form-control" value="<?php if(isset($info)) echo $info->product_model; else echo set_value('product_model'); ?>"> 
              <span class="error-msg"><?php echo form_error("product_model"); ?></span>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">ITEM CODE <span style="color:red;">  </span></label>
            <div class="col-sm-4">
              <input type="text" name="product_code" placeholder="ITEM CODE" class="form-control" value="<?php if(isset($info)) echo $info->product_code; else echo set_value('product_code'); ?>"> 
              <span class="error-msg"><?php echo form_error("product_code"); ?></span>
            </div>
            <label class="col-sm-2 control-label">Unit Price<span style="color:red;">  *</span></label>
          <div class="col-sm-4">
            <input type="text" name="unit_price"  class="form-control integerchk" value="<?php if(isset($info)) echo $info->unit_price; else echo set_value('unit_price');  ?>"> 
            <span class="error-msg"><?php echo form_error("unit_price"); ?></span>
          </div>
           
          </div>
        <div class="form-group">
         <label class="col-sm-2 control-label">Unit</label>
             <div class="col-sm-4">
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
           <label class="col-sm-2 control-label">Box Name</label>
             <div class="col-sm-3">
              <select class="form-control select2" name="box_id" id="box_id">
                <option value="">Select Box</option>
                <?php 
                $blist=$this->look_up_model->get_box();
                foreach ($blist as $value) {  ?>
                  <option value="<?php echo $value->box_id; ?>"
                    <?php if(isset($info)) echo $value->box_id==$info->box_id? 'selected="selected"':0; else echo set_select('box_id',$value->box_id);?>>
                    <?php echo $value->box_name; ?></option>
                  <?php } ?>
              </select>
             <span class="error-msg"><?php echo form_error("box_id");?></span>
           </div>
    </div><!-- ///////////////////// -->
    <div class="form-group">
        <label class="col-sm-2 control-label">Opening Stock Qty<span style="color:red;">  *</span></label>
        <div class="col-sm-4">
          <input type="text" name="stock_quantity"  class="form-control integerchk" onfocus="this.select();"  value="<?php if(isset($info)) echo $info->stock_quantity; else echo set_value('stock_quantity'); ?>"> 
          <span class="error-msg"><?php echo form_error("stock_quantity"); ?></span>
        </div>
         <label class="col-sm-2 control-label">Safety Stock  Qty<span style="color:red;">  *</span></label>
        <div class="col-sm-3">
          <input type="text" name="minimum_stock" onfocus="this.select();"  class="form-control integerchk" value="<?php if(isset($info)) echo $info->minimum_stock; else echo set_value('minimum_stock'); ?>"> 
          <span class="error-msg"><?php echo form_error("minimum_stock"); ?></span>
        </div>
    </div><!-- ///////////////////// -->
    <div class="form-group">
      <label class="col-sm-2 control-label">Brand Name </label>
          <div class="col-sm-3">
          <select class="form-control select2" name="brand_id" id="brand_id">
              <option value="">Select Brand</option>
              <?php foreach ($brlist as $value) {  ?>
                <option value="<?php echo $value->brand_id; ?>"
                  <?php  if(isset($info)) echo $value->brand_id==$info->brand_id? 'selected="selected"':0; else echo set_select('brand_id',$value->brand_id);?>>
                  <?php echo $value->brand_name; ?></option>
                <?php } ?>
            </select>
           <span class="error-msg"><?php echo form_error("brand_id");?></span>
          </div>
        </div>

    <div class="form-group">
      <label class="col-sm-2 control-label">Picture</label>
          <div class="col-sm-3">
              <input type="file" class="form-control"  name="product_image">
            <?php if (isset($info->product_image) &&!empty($info->product_image)) { ?>
              <div style="margin-top:20px;">
              <img src="<?php echo base_url(); ?>product/<?php echo $info->product_image ?>" class="img-thumbnail" style="width:100px;height:auto;"/>
              </div>
            <?php } ?>
          </div>
          <label class="col-sm-3 control-label">Description</label>
            <div class="col-sm-3">
              <textarea  name="product_description" class="form-control" rows="2"><?php if(isset($info)) echo $info->product_description; else echo set_value('product_description'); ?> </textarea>
               <span class="error-msg"><?php echo form_error("product_description");?></span>
            </div>
          </div><!-- ///////////////////// -->
          <div class="form-group">
           <label class="col-sm-2 control-label">Head 头</label>
               <div class="col-sm-4">
                <select class="form-control select2" name="head_id" id="head_id" required>
                  <option value="">Select 选择</option>
                  <?php 
                  foreach ($hlist as $value) {  ?>
                    <option value="<?php echo $value->head_id; ?>"
                      <?php  if(isset($info)) echo $value->head_id==$info->head_id? 'selected="selected"':0; else echo set_select('head_id',$value->head_id);?>>
                      <?php echo $value->head_name; ?></option>
                    <?php } ?>
                </select>
               <span class="error-msg"><?php echo form_error("head_id");?></span>
             </div>
           </div>
      </div>
        <!-- /.box-body -->
        <div class="box-footer">
           <div class="col-sm-4"><a href="<?php echo base_url(); ?>medical/items/lists" class="btn btn-info"><i class="fa fa-arrow-circle-o-left" aria-hidden="true"></i> Back</a></div>
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
 
