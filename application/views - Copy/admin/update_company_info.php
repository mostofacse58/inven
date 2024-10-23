<div class="row">
    <div class="col-md-12">
        <div class="box box-info">
            <?php
            $company_info = $this->look_up_model->get_company_info();
            ?>
            <div class="box-header with-border">
                <?php
                if (isset($file_error)) {
                    ?>
                    <div class="row">
                        <div class="col-md-12"> 
                            <div class="alert alert-danger alert-dismissible"> 
                                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                <?php echo $file_error; ?>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?> 
            </div>
            <!-- form start -->
            <form class="form-horizontal" action="<?php echo base_url(); ?>configcontroller/saveInfo" method="POST" enctype="multipart/form-data">
                <div class="box-body">
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">Company Name</label>

                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="inputEmail3" name="company_name" placeholder="Company Name" value="<?php echo $company_info->company_name; ?>">
                            <span class="error-msg"><?php echo form_error('company_name'); ?></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">Phone</label>

                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="inputEmail3" placeholder="Phone" name="phone" value="<?php echo $company_info->phone; ?>">
                            <span class="error-msg"><?php echo form_error('phone'); ?></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">Short Code</label>

                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="inputEmail3" placeholder="Short Code" name="short_name" value="<?php echo $company_info->short_name; ?>">
                            <span class="error-msg"><?php echo form_error('short_name'); ?></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">Email Address</label>

                        <div class="col-sm-6">
                            <input type="email" class="form-control" id="inputEmail3" placeholder="Email Address" name="email_address" value="<?php echo $company_info->email_address; ?>">
                            <span class="error-msg"><?php echo form_error('email_address'); ?></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">Website</label>

                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="inputEmail3" placeholder="Website" name="website" value="<?php echo $company_info->website; ?>">
                            <span class="error-msg"><?php echo form_error('website'); ?></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">Address</label>

                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="inputEmail3" placeholder="Full Address" name="address" value="<?php echo $company_info->address; ?>">
                            <span class="error-msg"><?php echo form_error('website'); ?></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">Logo</label>
                        <input type="hidden" name="old_logo" value="<?php echo $company_info->logo; ?>">

                        <div class="col-sm-6">
                            <div class="input-group" >
                                <input type="text" class="form-control file-focus-field"  placeholder="No File Selected">
                                <span class="input-group-addon btn btn-primary" style="Background-color:#0C5889;color:#fff;border:1px solid #069">Select</span>
                            </div>
                            <input type="file" class="form-control"  class="form-control file-field" name="logo"  style="opacity:0;position: absolute;top:0"/>
                            <?php if (isset($company_info->logo) && !empty($company_info->logo)) { ?>
                                <div class="input-group" style="margin-top:20px;">
                            <img src="<?php echo base_url(); ?>logo/<?php echo $company_info->logo ?>" class="img-thumbnail" style="width:130px;height:auto;"/>
                            </div>
                      <?php } ?>
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <div class="col-sm-8">
                        <button type="submit" class="btn btn-info pull-right">SAVE 保存</button>
                    </div>
                </div>
                <!-- /.box-footer -->
            </form>
        </div>

    </div>
</div>
