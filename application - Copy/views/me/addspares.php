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
            <form class="form-horizontal" action="<?php echo base_url();?>me/spares/save<?php if(isset($info)) echo "/$info->product_id"; ?>" method="POST" enctype="multipart/form-data">
              <div class="box-body">
                <div class="form-group">
                  <label class="col-sm-2 control-label">English Name英文名称<span style="color:red;">  *</span></label>
                  <div class="col-sm-4">
                    <input type="text" name="product_name" required class="form-control" placeholder="English Name英文名称" value="<?php if(isset($info->product_name)) echo $info->product_name; else echo set_value('product_name'); ?>">
                   <span class="error-msg"><?php echo form_error("product_name");?></span>
                  </div>
                 <label class="col-sm-2 control-label">Chinese name中文名称</label>
                  <div class="col-sm-4">
                     <input type="text" name="china_name"  class="form-control" placeholder="Chinese name中文名称" value="<?php if(isset($info->china_name)) echo $info->china_name; else echo set_value('china_name'); ?>">
                    <span class="error-msg"><?php echo form_error("china_name"); ?></span>
                  </div>                  
                </div>
                 <div class="form-group">
                  <label class="col-sm-2 control-label">Category Name 分类名称<span style="color:red;">  *</span></label>
                  <div class="col-sm-4">
                    <select class="form-control select2" required name="category_id" id="category_id" >
                      <option value="">Select Category 选择类别</option>
                      <?php foreach ($clist as $value) {  ?>
                        <option value="<?php echo $value->category_id; ?>"
                          <?php  if(isset($info)) echo $value->category_id==$info->category_id? 'selected="selected"':0; else echo set_select('category_id',$value->category_id);?>>
                          <?php echo $value->category_name; ?></option>
                        <?php } ?>
                    </select>
                   <span class="error-msg"><?php echo form_error("category_id");?></span>
                  </div>
                  <label class="col-sm-2 control-label">Model型号<span style="color:red;">  </span></label>
                  <div class="col-sm-4">
                    <input type="text" name="product_model"  placeholder="Model型号" class="form-control" value="<?php if(isset($info)) echo $info->product_model; else echo set_value('product_model'); ?>"> 
                    <span class="error-msg"><?php echo form_error("product_model"); ?></span>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label">Item Code 项目代码</label>
                  <div class="col-sm-4">
                    <input type="text" name="product_code" <?php if(isset($info)) echo "readonly"; ?> placeholder="Item Code 项目代码" class="form-control" value="<?php if(isset($info)) echo $info->product_code; else echo set_value('product_code'); ?>"> 
                    <span class="error-msg"><?php echo form_error("product_code"); ?></span>
                  </div>
                  <label class="col-sm-2 control-label">Material Type 材料类型</label>
                   <div class="col-sm-4">
                    <select class="form-control select2" name="mtype_id" id="mtype_id">
                      <option value="">Select 选择 </option>
                      <?php foreach ($mlist as $value) {  ?>
                        <option value="<?php echo $value->mtype_id; ?>"
                          <?php  if(isset($info)) echo $value->mtype_id==$info->mtype_id? 'selected="selected"':0; else echo set_select('mtype_id',$value->mtype_id);?>>
                          <?php echo $value->mtype_name; ?></option>
                        <?php } ?>
                    </select>
                   <span class="error-msg"><?php echo form_error("mtype_id");?></span>
                 </div>
                </div>
                <div class="form-group">
               <label class="col-sm-2 control-label">Unit单价</label>
                  <div class="col-sm-2">
                    <select class="form-control select2" name="unit_id" id="unit_id"  required>
                      <option value="">Select 选择</option>
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
                 <label class="col-sm-2 control-label">She/Box Name</label>
                   <div class="col-sm-2">
                    <select class="form-control select2" name="box_id" id="box_id"  required>
                      <option value="">Select 选择</option>
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
                 <label class="col-sm-2 control-label">Unit Price单价<span style="color:red;">  *</span></label>
                <div class="col-sm-2">
                  <input type="text" name="unit_price" <?php if(isset($info)) echo ""; ?>  onfocus="this.select();"  class="form-control integerchk" value="<?php if(isset($info)) echo $info->unit_price; else echo set_value('unit_price');  ?>"  required> 
                  <span class="error-msg"><?php echo form_error("unit_price"); ?></span>
                </div>
          </div><!-- ///////////////////// -->
          <div class="form-group">
              <label class="col-sm-2 control-label">Opening Stock Qty 期初库存质量<span style="color:red;">  *</span></label>
                <div class="col-sm-2">
                  <input type="text" <?php if(isset($info)) echo "readonly"; ?>  name="stock_quantity" onfocus="this.select();"  class="form-control integerchk" value="<?php if(isset($info)) echo $info->stock_quantity; else echo "0"; ?>"  required> 
                  <span class="error-msg"><?php echo form_error("stock_quantity"); ?></span>
                </div>
                 <label class="col-sm-2 control-label">Maximum Stock Qty 最大库存数量<span style="color:red;">  *</span></label>
                <div class="col-sm-2">
                  <input type="text" <?php if($this->session->userdata('user_id')!=7) echo "readonly"; ?> name="minimum_stock" onfocus="this.select();"  class="form-control integerchk" value="<?php if(isset($info)) echo $info->minimum_stock; else echo '0'; ?>"> 
                  <span class="error-msg"><?php echo form_error("minimum_stock"); ?></span>
                </div>
                <label class="col-sm-2 control-label">Currency 货币 </label>
                <div class="col-sm-2">
                <select class="form-control select2" <?php if(isset($info)) echo "readonly"; ?>  name="currency" id="currency"  required>
                    <?php foreach ($culist as $value) {  ?>
                      <option value="<?php echo $value->currency; ?>"
                        <?php  if(isset($info)) echo $value->currency==$info->currency? 'selected="selected"':0; else echo set_select('currency',$value->currency);?>>
                        <?php echo $value->currency; ?></option>
                      <?php } ?>
                  </select>
                 <span class="error-msg"><?php echo form_error("currency");?></span>
                </div>
          </div><!-- ///////////////////// -->
          <div class="form-group">
                
            <label class="col-sm-2 control-label">Country国家<span style="color:red;">  *</span></label>
             <div class="col-sm-2">
              <select class="form-control" name="bd_or_cn" id="bd_or_cn"  required>
                <option value="BD"
                  <?php if(isset($info)) echo 'BD'==$info->bd_or_cn? 'selected="selected"':0; else echo set_select('bd_or_cn','BD');?>>BD</option>
                  <option value="CN"
                  <?php if(isset($info)) echo 'CN'==$info->bd_or_cn? 'selected="selected"':0; else echo set_select('bd_or_cn','CN');?>>CN</option>
              </select>
             <span class="error-msg"><?php echo form_error("bd_or_cn");?></span>
           </div>
           
            <label class="col-sm-2 control-label">Re-order Level<span style="color:red;">  *</span></label>
                <div class="col-sm-2">
                  <input type="text" required name="reorder_level" onfocus="this.select();"  class="form-control integerchk" value="<?php if(isset($info)) echo $info->reorder_level; else echo set_value('reorder_level');  ?>"> 
                  <span class="error-msg"><?php echo form_error("reorder_level"); ?></span>
                </div>
            <label class="col-sm-2 control-label">Thread Count 线程数</label>
                <div class="col-sm-2">
                  <input type="text" name="mthread_count" required class="form-control" value="<?php if(isset($info)) echo $info->mthread_count; else echo 0 ?>"> 
                  <span class="error-msg"><?php echo form_error("mthread_count"); ?></span>
                </div>
          </div><!-- ///////////////////// -->
          <div class="form-group">
            <label class="col-sm-2 control-label">Length 长度</label>
            <div class="col-sm-2">
              <input type="text" name="mlength"  required class="form-control" value="<?php if(isset($info)) echo $info->mlength; else echo  0; ?>"> 
              <span class="error-msg"><?php echo form_error("mlength"); ?></span>
            </div>
            
            <label class="col-sm-2 control-label">Re-order Qty<span style="color:red;">  *</span></label>
            <div class="col-sm-2">
              <input type="text" required name="re_order_qty" onfocus="this.select();"  class="form-control integerchk" value="<?php if(isset($info)) echo $info->re_order_qty; else 0;  ?>"> 
              <span class="error-msg"><?php echo form_error("re_order_qty"); ?></span>
            </div>
            <label class="col-sm-2 control-label">Diameter直径</label>
            <div class="col-sm-2">
              <input type="text" required name="mdiameter"  class="form-control" value="<?php if(isset($info)) echo $info->mdiameter; else echo 0; ?>"> 
              <span class="error-msg"><?php echo form_error("mdiameter"); ?></span>
            </div>
               
          </div><!-- ///////////////////// -->
          <div class="form-group">
            <label class="col-sm-2 control-label">Lead Time 交货时间</label>
                <div class="col-sm-2">
                  <input type="text" required name="lead_time"  class="form-control" value="<?php if(isset($info)) echo $info->lead_time; else echo 0; ?>"> 
                  <span class="error-msg"><?php echo form_error("lead_time"); ?></span>
                </div>
                <label class="col-sm-2 control-label">Safety Stock Qty 安全库存数量<span style="color:red;">  *</span></label>
                <div class="col-sm-2">
                  <input type="text" <?php if($this->session->userdata('user_id')!=7) echo "readonly"; ?> name="safety_stock_qty" required onfocus="this.select();"  class="form-control integerchk" value="<?php if(isset($info)) echo $info->safety_stock_qty; else echo '0'; ?>"> 
                  <span class="error-msg"><?php echo form_error("safety_stock_qty"); ?></span>
                </div>

            <label class="col-sm-2 control-label">Description描述</label>
            <div class="col-sm-2">
              <textarea  name="note" class="form-control" rows="1"><?php if(isset($info)) echo $info->product_description; else echo set_value('product_description'); ?> </textarea>
               <span class="error-msg"><?php echo form_error("product_description");?></span>
            </div>
            </div><!-- ///////////////////// -->
          <div class="form-group">
             <label class="col-sm-2 control-label">Usage Category<span style="color:red;">  *</span></label>
             <div class="col-sm-2">
              <select class="form-control" name="usage_category" id="usage_category">
                <option value="REGULAR(A)"
                  <?php if(isset($info)) echo 'REGULAR(A)'==$info->usage_category? 'selected="selected"':0; else echo set_select('usage_category','REGULAR(A)');?>>REGULAR(A)</option>
                  <option value="IRREGULAR(B)"
                  <?php if(isset($info)) echo 'IRREGULAR(B)'==$info->usage_category? 'selected="selected"':0; else echo set_select('usage_category','IRREGULAR(B)');?>>IRREGULAR(B)</option>
                  <option value="PROJECT(C)"
                  <?php if(isset($info)) echo 'PROJECT(C)'==$info->usage_category? 'selected="selected"':0; else echo set_select('usage_category','PROJECT(C)');?>>PROJECT(C)</option>
              </select>
             <span class="error-msg"><?php echo form_error("usage_category");?></span>
           </div>
            <label class="col-sm-2 control-label">Meterial Picture材质图片</label>
                <div class="col-sm-2">
                    <input type="file" class="form-control"  name="product_image">
                  <?php if (isset($info->product_image) &&!empty($info->product_image)) { ?>
                    <div style="margin-top:20px;">
                    <img src="<?php echo base_url(); ?>product/<?php echo $info->product_image ?>" class="img-thumbnail" style="width:100px;height:auto;"/>
                    </div>
                  <?php } ?>
                  <span>Allow: Max size: 500Kb</span>
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
                 <div class="col-sm-4"><a href="<?php echo base_url(); ?>me/spares/lists" class="btn btn-info"><i class="fa fa-arrow-circle-o-left" aria-hidden="true"></i> Back 背部</a></div>
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
 
