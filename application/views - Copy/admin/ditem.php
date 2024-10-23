<div class="row">
  <div class="col-xs-12">
   <div class="box box-primary">
            <div class="box-header">
              <div class="widget-block">
             
<div class="widget-head">
<h5><?php echo ucwords($heading); ?></h5>
<div class="widget-control pull-right">
 <a class="btn btn-sm btn-primary pull-right" target="_blank" style="margin-right:0px;" 
href="https://dm.vlmbd.com/update_price">
<i class="fa fa-refresh"></i>
Price Synch
</a>
</div>
</div>
</div>
</div>
<div class="box box-info">
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" action="<?php echo base_url();?>ditem/save<?php if(isset($info)) echo "/$info->id"; ?>" method="POST" enctype="multipart/form-data">
              <div class="box-body">
                <div class="form-group">
                  <label class="col-sm-2 control-label">Item Name<span style="color:red;">  *</span></label>
                  <div class="col-sm-3">
                    <input type="text" <?php if(isset($info->product_name)) echo "readonly"; ?> name="product_name" class="form-control" value="<?php if(isset($info->product_name)) echo $info->product_name; else echo set_value('product_name'); ?>">
                   <span class="error-msg"><?php echo form_error("product_name");?></span>
                  </div>
                   <label class="col-sm-2 control-label">Unit<span style="color:red;">  *</span></label>
                  <div class="col-sm-3">
                    <input type="text" name="unit" class="form-control" value="<?php if(isset($info->unit)) echo $info->unit; else echo set_value('unit'); ?>">
                   <span class="error-msg"><?php echo form_error("unit");?></span>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label">Unit Price <span style="color:red;">  *</span></label>
                  <div class="col-sm-3">
                    <input type="text" name="unit_price" class="form-control" value="<?php if(isset($info->unit_price)) echo $info->unit_price; else echo set_value('unit_price'); ?>">
                    <span class="error-msg"><?php echo form_error("unit_price");?></span>
                  </div>
                  <label class="col-sm-2 control-label">Price Affected <span style="color:red;">  *</span></label>
                  <div class="col-sm-2">
                    <input type="text" name="affected" class="form-control" value="<?php if(isset($info->affected)) echo $info->affected; else echo set_value('affected'); ?>">
                    <span class="error-msg"><?php echo form_error("affected");?></span>
                  </div>

                  <div class="col-sm-2">
                <button type="submit" class="btn btn-success pull-right">SAVE 保存</button>
                </div>
                </div>

              <!-- /.box-body -->
            </form>
          </div>
            <!-- /.box-header -->
            <div class="box-body box">
              <div class="col-md-12">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                      <th style="width:20%">Item Name</th>
                      <th style="width:10%">Unit</th>
                      <th style="width:10%">Unit Price</th>
                      <th style="width:10%">Affected</th>
                      <th  style="text-align:center;width:10%">Actions 行动</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php
                  if($list&&!empty($list)):
                      foreach($list as $row):
                          ?>
                          <tr>
                              <td style="text-align: center;"><?php echo $row->product_name;?></td>
                              <td style="text-align: center;"><?php echo $row->unit;?></td>
                              <td style="text-align: center;"><?php echo $row->unit_price;?></td>
                              <td style="text-align: center;"><?php echo $row->affected;?></td>
                              <td style="text-align:center">
                                <a class="btn btn-success" href="<?php echo base_url()?>ditem/edit/<?php echo $row->id;?>"><i class="fa fa-edit tiny-icon"></i></a>
                                &nbsp;&nbsp;&nbsp;&nbsp;                                        
                              </td>
                          </tr>
                      <?php
                      endforeach;
                  endif;
                  ?>
                  </tbody>
              </table>
            </div>
          </div>
            <!-- /.box-body -->
          </div>
        </div>
 </div>
