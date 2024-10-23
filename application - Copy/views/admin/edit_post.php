<div class="row">
  <div class="col-md-12">
   <div class="box box-info">
          
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" action="<?php echo base_url();?>configcontroller/savePost/<?php echo $post_info->post_id; ?>" method="POST" enctype="multipart/form-data">
              <div class="box-body">
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Designation Name <span style="color:red;">  *</span></label>

                  <div class="col-sm-6">
                    <input type="text" name="post_name" class="form-control" id="inputEmail3" placeholder="Full Name" value="<?php echo $post_info->post_name; ?>">
					<span class="error-msg"><?php echo form_error("post_name");?></span>
                  </div>
                </div>
				
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Designation Level </label>

                  <div class="col-sm-6">
                    <select class="form-control" name="post_lavel" required>
                    <option value="Director" 
                      <?php if(isset($post_info->post_lavel)) echo 'Director'==$post_info->post_lavel? 'selected="selected"':0; ?>>Director</option>
                     <option value="Employee" 
                      <?php if(isset($post_info->post_lavel)) echo 'Employee'==$post_info->post_lavel? 'selected="selected"':0;?>>Employee</option>
                        </select>
          <span class="error-msg"><?php echo form_error("post_lavel");?></span>
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
