<div class="row">
  <div class="col-md-12">
   <div class="box box-info">
          
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" method="post" action="<?php echo site_url('navigation/save')?><?php if(isset($info)) echo "/$info->menu_id"; ?>">
              <div class="box-body">
                 <div class="form-group ">
                        <label  class="col-sm-2 control-label"> Menu Label </label>
                        <div class="col-sm-5">
                          <input type="text" class="form-control" name="menu_label" placeholder="Menu Label" value="<?php if(isset($info->menu_label))echo $info->menu_label; else echo set_value('menu_label'); ?>" >
                          <span class="error-msg text-danger"><?php echo form_error("menu_label");?></span>
                        </div>
                      </div>
                      <div class="form-group ">
                        <label  class="col-sm-2 control-label"> Menu Link </label>
                        <div class="col-sm-5">
                          <input type="text" class="form-control" name="link" placeholder="Menu Link" value="<?php if(isset($info->link))echo $info->link; else echo set_value('link'); ?>" >
                          <span class="error-msg text-danger"><?php echo form_error("link");?></span>
                        </div>
                      </div>
                       <div class="form-group ">
                        <label  class="col-sm-2 control-label">Menu Icon </label>
                        <div class="col-sm-5">
                          <input type="text" class="form-control" name="icon" placeholder="Menu Icon" value="<?php if(isset($info->link))echo $info->icon; else echo set_value('icon'); ?>" >
                          <span class="error-msg text-danger"><?php echo form_error("icon");?></span>
                        </div>
                      </div>

                      <div class="form-group">
                        <label  class="col-sm-2 control-label"> Parent </label>
                        <div class="col-sm-5">
                       <select class="form-control select2" name="parent">
                      <option value="0">None</option>
                      <?php foreach ($mlist as $value) {
                       ?>
                      <option value="<?php echo $value->menu_id; ?>" 
                      <?php if(isset($info->parent)) echo $value->menu_id==$info->parent? 'selected="selected"':0;
                     else echo $value->menu_id==set_value('parent')? 'selected="selected"':0; ?>><?php echo $value->menu_label; ?></option>
                      <?php } ?>
                      </select>
                      <span class="error-msg text-danger"><?php echo form_error('parent'); ?></span>
                        </div>
                      </div>
                      <div class="form-group ">
                        <label  class="col-sm-2 control-label">Sort </label>
                        <div class="col-sm-5">
                          <input type="text" class="form-control" name="sort" placeholder="Sort" value="<?php if(isset($info->sort))echo $info->sort; else echo set_value('sort'); ?>" >
                          <span class="error-msg text-danger"><?php echo form_error("sort");?></span>
                        </div>
                      </div>
                       <div class="form-group">
                        <label class="col-sm-2 control-label">Department <span style="color:red;">  *</span></label>
                        <div class="col-sm-5">
                            <select class="form-control select2" name="department_id" id="department_id">
                              <option value="0">Select Department</option>
                              <?php foreach ($dlist as $value) {  ?>
                                <option value="<?php echo $value->department_id; ?>"
                                  <?php  if(isset($info)) echo $value->department_id==$info->department_id? 'selected="selected"':0; else echo set_select('post_id',$value->department_id);?>>
                                  <?php echo $value->department_name; ?></option>
                                <?php } ?>
                            </select> 
                            <span class="error-msg"><?php echo form_error("department_id"); ?></span>
                        </div>
                    </div>
        

              <!-- ///////////////////// -->

                </div>
              <!-- /.box-body -->
              <div class="box-footer">
                 <div class="col-sm-4"><a href="<?php echo base_url(); ?>navigation/lists" class="btn btn-info"><i class="fa fa-arrow-circle-o-left" aria-hidden="true"></i> Back</a></div>
                 <div class="col-sm-4">
                <button type="submit" class="btn btn-info pull-right">SAVE 保存</button>
                </div>
              </div>
              <!-- /.box-footer -->
            </form>
          </div>
   
   </div>
 </div>
