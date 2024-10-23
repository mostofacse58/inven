<div class="row">
    <div class="col-md-12">
        <div class="box box-info">

            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" action="<?php echo base_url(); ?>configcontroller/saveUser/<?php echo $user_info->id; ?>" method="POST" enctype="multipart/form-data">
                <div class="box-body">
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">Full Name <span style="color:red;">  *</span></label>
                        <div class="col-sm-6">
                            <input type="text" name="user_name" class="form-control" id="inputEmail3" placeholder="Full Name" value="<?php echo $user_info->user_name; ?>">
                            <span class="error-msg"><?php echo form_error("user_name"); ?></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">Email Address  <span style="color:red;">  *</span></label>
                        <div class="col-sm-6">
                            <input type="email" name="email_address" class="form-control" id="inputEmail3" placeholder="Email Address" value="<?php echo $user_info->email_address; ?>">
                            <span class="error-msg"><?php echo form_error("email_address"); ?></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">Mobile</label>

                        <div class="col-sm-6">
                            <input type="text" name="mobile" class="form-control" id="inputEmail3" placeholder="Mobile" value="<?php echo $user_info->mobile; ?>">
                            <span class="error-msg"><?php echo form_error("mobile"); ?></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">Password <span style="color:red;">  *</span></label>

                        <div class="col-sm-6">
                            <input type="password" name="password" class="form-control" id="inputEmail3" placeholder="Password" value="<?php echo $user_info->password; ?>">
                            <span class="error-msg"><?php echo form_error("password"); ?></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">Role <span style="color:red;">  *</span></label>
                        <div class="col-sm-6">
                    <select class="form-control" name="role">
                    <option value="" selected="selected">Role</option>
                    <option value="1" <?php echo "1" == $user_info->role ? 'selected="selected"' : 0; ?>>Admin</option>
                    <option value="2" <?php echo "2" == $user_info->role ? 'selected="selected"' : 0; ?>>Manager</option>
                    <option value="3" <?php echo "3" == $user_info->role ? 'selected="selected"' : 0; ?>>Assistant Manager</option>
                    <option value="4" <?php echo "4" == $user_info->role ? 'selected="selected"' : 0; ?>>Project Engineer</option>
                    <option value="5" <?php echo "5" == $user_info->role ? 'selected="selected"' : 0; ?>>Assistant Project Engi.</option>
                    <option value="6" <?php echo "6" == $user_info->role ? 'selected="selected"' : 0; ?>>Executive Officer</option>
                    <option value="7" <?php echo "7" == $user_info->role ? 'selected="selected"' : 0; ?>>Sr. Executive</option>
                    <option value="8" <?php echo "8" == $user_info->role ? 'selected="selected"' : 0; ?>>Marketing Officer</option>
                
                </select>
                            <span class="error-msg"><?php echo form_error("user_name"); ?></span>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">Post <span style="color:red;">  *</span></label>
                        <div class="col-sm-6">
                            <select class="form-control" name="post_id">
                                <option value="" selected="selected">===Select One===</option>
                                <?php foreach ($postlist as $row) { ?>
                                    <option value="<?php echo $row->post_id; ?>" <?php echo $row->post_id == $user_info->post_id ? 'selected="selected"' : 0; ?>><?php echo $row->post_name; ?></option>
                                <?php } ?>
                            </select>
                            <span class="error-msg"><?php echo form_error("post_id"); ?></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">Photo</label>
                        <input type="hidden" name="old_photo" value="<?php echo $user_info->photo; ?>">
                        <div class="col-sm-6">
                            <div class="input-group" >
                                <input type="text" class="form-control file-focus-field"  placeholder="No File Selected">
                                <span class="input-group-addon btn btn-primary" style=" Background-color:#0C5889;color:#fff;border:1px solid #069">Select</span>
                            </div>
                            <input type="file" class="form-control"  class="form-control file-field" name="photo"  style="opacity:0;position: absolute;top:0"/>
                            <?php if (isset($user_info->photo) && !empty($user_info->photo)) { ?>
                                <div class="input-group" style="margin-top:20px;">


                                    <img src="<?php echo base_url(); ?>asset/photo/<?php echo $user_info->photo ?>" class="img-thumbnail" style="width:130px;height:auto;"/>

                                </div>
                            <?php } ?>
                        </div>
                    </div>

                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <div class="col-sm-2"><a href="<?php echo base_url(); ?>configcontroller/userList" class="btn btn-info">Cancel</a></div>
                    <div class="col-sm-6">
                        <button type="submit" class="btn btn-info pull-right">SAVE 保存</button>
                    </div>
                </div>
                <!-- /.box-footer -->
            </form>
        </div>

    </div>
</div>
