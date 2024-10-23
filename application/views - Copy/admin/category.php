<div class="row">
  <div class="col-xs-12">
   <div class="box box-primary">
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
            <form class="form-horizontal" action="<?php echo base_url();?>category/save<?php if(isset($info)) echo "/$info->category_id"; ?>" method="POST" enctype="multipart/form-data">
              <div class="box-body">
                <div class="form-group">
                  <label class="col-sm-1 control-label">Department -部门 <span style="color:red;">  *</span></label>
                  <div class="col-sm-2">
                    <select class="form-control select2" name="department_id" id="department_id">
                    <option value="" selected="selected">Select Department -部门</option>
                    <?php foreach($dlist as $rows){  ?>
                    <option value="<?php echo $rows->department_id; ?>" 
                      <?php if(isset($info->department_id))echo $rows->department_id==$info->department_id? 'selected="selected"':0; else
                       echo $rows->department_id==set_value('department_id')? 'selected="selected"':0; ?>><?php echo $rows->department_name; ?></option>
                    <?php }  ?>
                  </select>                    
                  <span class="error-msg"><?php echo form_error("department_id");?></span>
                  </div>
                  <label class="col-sm-2 control-label">Category Name 分类名称<span style="color:red;">  *</span></label>
                  <div class="col-sm-3">
                    <input type="text" name="category_name" class="form-control" placeholder="Category Name 分类名称" value="<?php if(isset($info->category_name)) echo $info->category_name; else echo set_value('category_name'); ?>">
                   <span class="error-msg"><?php echo form_error("category_name");?></span>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-1 control-label">Type-类型 <span style="color:red;">  *</span></label>
                  <div class="col-sm-2">
                    <select class="form-control select2" name="cat_type" id="cat_type">
                    <option value="" selected="selected">Select Type-类型</option>
                    <option value="1" <?php if(isset($info->cat_type)) echo 1==$info->cat_type? 'selected="selected"':0; else
                       echo 1==set_value('cat_type')? 'selected="selected"':0; ?>>Asset</option>
                    <option value="2" <?php if(isset($info->cat_type)) echo 2==$info->cat_type? 'selected="selected"':0; else
                       echo 2==set_value('cat_type')? 'selected="selected"':0; ?>>Spares</option>
                    <option value="3" <?php if(isset($info->cat_type)) echo 3==$info->cat_type? 'selected="selected"':0; else
                       echo 3==set_value('cat_type')? 'selected="selected"':0; ?>>Tools & Accessories</option>
                    <option value="4" <?php if(isset($info->cat_type)) echo 4==$info->cat_type? 'selected="selected"':0; else
                       echo 4==set_value('cat_type')? 'selected="selected"':0; ?>>Others</option>
                    </select>                    
                    <span class="error-msg"><?php echo form_error("cat_type");?></span>
                  </div>

                  <div class="col-sm-3">
                <button type="submit" class="btn btn-success pull-right">SAVE 保存</button>
                </div>
                </div>

              <!-- /.box-body -->
            </form>
          </div>
            <!-- /.box-header -->
            <div class="box-body box">
              <div class="col-md-10">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                      <th style="width:20%">Category Name 分类名称</th>
                      <th style="width:20%">Department -部门</th>
                      <th style="width:10%">Type-类型</th>
                      <th  style="text-align:center;width:10%">Actions 行动</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php
                  if($list&&!empty($list)):
                      foreach($list as $row):
                          ?>
                          <tr>
                              <td style="text-align: center;"><?php echo $row->category_name;?></td>
                              <td style="text-align: center;"><?php echo $row->department_name;?></td>
                              <td style="text-align: center;">
                                <?php if($row->cat_type==1) echo "Assets";
                                elseif ($row->cat_type==2) echo "Spares";
                                elseif ($row->cat_type==3) echo "Tools & Accessories";
                                elseif ($row->cat_type==4) echo "Others"; ?></td>
                              <td style="text-align:center">
                                <a class="btn btn-success" href="<?php echo base_url()?>category/edit/<?php echo $row->category_id;?>"><i class="fa fa-edit tiny-icon"></i></a>
                                &nbsp;&nbsp;&nbsp;&nbsp;                                        
                                <!-- <a href="<?php echo base_url()?>category/delete/<?php echo $row->category_id;?>" class="delete btn btn-success" onClick="return doconfirm();" ><i class="fa fa-trash-o tiny-icon"></i></a> -->
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
