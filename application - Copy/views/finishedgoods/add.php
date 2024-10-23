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
      <form class="form-horizontal" action="<?php echo base_url();?>finishedgoods/finishedgoods/save<?php if(isset($info)) echo "/$info->goods_id"; ?>" method="POST" enctype="multipart/form-data">
        <div class="box-body">
          <div class="form-group">
            <label class="col-sm-2 control-label">File No <span style="color:red;">  *</span></label>
            <div class="col-sm-4">
              <input type="text" name="file_no" required class="form-control" value="<?php if(isset($info->file_no)) echo $info->file_no; else echo set_value('file_no'); ?>">
             <span class="error-msg"><?php echo form_error("file_no");?></span>
            </div>
           <label class="col-sm-2 control-label">Style No(款号) </label>
            <div class="col-sm-4">
               <input type="text" name="style_no"  class="form-control" value="<?php if(isset($info->style_no)) echo $info->style_no; else echo set_value('style_no'); ?>">
              <span class="error-msg"><?php echo form_error("style_no"); ?></span>
            </div>                  
          </div>
           <div class="form-group">
       
            <label class="col-sm-2 control-label">Color(颜色)<span style="color:red;">  </span></label>
            <div class="col-sm-4">
              <input type="text" name="color_name" class="form-control" value="<?php if(isset($info)) echo $info->color_name; else echo set_value('color_name'); ?>"> 
              <span class="error-msg"><?php echo form_error("color_name"); ?></span>
            </div>
            <label class="col-sm-2 control-label">
              Quantity(数量) <span style="color:red;">  </span></label>
            <div class="col-sm-4">
              <input type="text" name="quantity" class="form-control" value="<?php if(isset($info)) echo $info->quantity; else echo set_value('quantity'); ?>"> 
              <span class="error-msg"><?php echo form_error("quantity"); ?></span>
            </div>
               
          </div>
        <div class="form-group">
         <label class="col-sm-2 control-label">Workshop(生产车间)</label>
             <div class="col-sm-4">
              <select class="form-control select2" name="floor_no" id="floor_no">
                <option value="">Select Workshop(生产车间)</option>
                <?php 
                $ulist=$this->db->query("SELECT * FROM workshop_info")->result();
                foreach ($ulist as $value) {  ?>
                  <option value="<?php echo $value->floor_no; ?>"
                    <?php  if(isset($info)) echo $value->floor_no==$info->floor_no? 'selected="selected"':0; else echo set_select('floor_no',$value->floor_no);?>>
                    <?php echo $value->floor_no; ?></option>
                  <?php } ?>
              </select>
             <span class="error-msg"><?php echo form_error("floor_no");?></span>
           </div>
           <label class="col-sm-2 control-label">Line No(组别)</label>
             <div class="col-sm-3">
              <select class="form-control select2" name="line_no" id="line_no">
                <option value="">Select Line No(组别)</option>
                <?php $blist=$this->db->query("SELECT * FROM floorline_info")->result();
                foreach ($blist as $value) {  ?>
                  <option value="<?php echo $value->line_no; ?>"
                    <?php if(isset($info)) echo $value->line_no==$info->line_no? 'selected="selected"':0; else echo set_select('line_no',$value->line_no);?>>
                    <?php echo $value->line_no; ?></option>
                  <?php } ?>
              </select>
             <span class="error-msg"><?php echo form_error("line_no");?></span>
           </div>
    </div><!-- ///////////////////// -->
   
      </div>
        <!-- /.box-body -->
        <div class="box-footer">
           <div class="col-sm-4"><a href="<?php echo base_url(); ?>finishedgoods/finishedgoods/lists" class="btn btn-info"><i class="fa fa-arrow-circle-o-left" aria-hidden="true"></i> Back</a></div>
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
 
