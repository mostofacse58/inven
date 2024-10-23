<div class="row">
  <div class="col-md-12">
   <div class="box box-info">
          
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" action="<?php echo base_url();?>configcontroller/savePost" method="POST" enctype="multipart/form-data">
              <div class="box-body">
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Designation Name <span style="color:red;">  *</span></label>

                  <div class="col-sm-6">
                    <input type="text" name="post_name" class="form-control" placeholder="Designation Name" value="<?php echo set_value('post_name'); ?>">
					          <span class="error-msg"><?php echo form_error("post_name");?></span>
                  </div>
                </div>
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                 <div class="col-sm-2"><a href="<?php echo base_url(); ?>configcontroller/PostList" class="btn btn-info">Cancel</a></div>
                 <div class="col-sm-6">
                <button type="submit" class="btn btn-info pull-right">SAVE 保存</button>
                </div>
              </div>
              <!-- /.box-footer -->
            </form>
          </div>
   
   </div>
 </div>
