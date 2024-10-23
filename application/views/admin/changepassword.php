<div class="row">
  <div class="col-md-12">
   <div class="box box-primary">

    <div class="box-header">
              <div class="widget-block">
             
<div class="widget-head">
<h5>Please change your Password after every 30 days</h5>
<div class="widget-control pull-right">
</div>
</div>
</div>
</div>
    <?php  
$company_info=$this->look_up_model->get_company_info();
 ?>
 <div class="box-header with-border">
    </div>
            <!-- form start -->
            <form class="form-horizontal" action="<?php echo base_url(); ?>configcontroller/changePassword" method="POST">
              <div class="box-body">
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Old Password <span style="color:red;">  *</span></label>

                  <div class="col-sm-6">
                    <input type="password" class="form-control" name="password" placeholder="Old Password">
                    <span class="error-msg"><?php echo form_error('new_password'); ?></span>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">New Password <span style="color:red;">  *</span></label>

                  <div class="col-sm-6">
                    <input type="password" class="form-control" name="new_password" placeholder="New Password">
                    <span class="error-msg"><?php echo form_error('new_password'); ?></span>
                  </div>
                </div>
                 <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Confirm Password <span style="color:red;">  *</span></label>

                  <div class="col-sm-6">
                    <input type="password" class="form-control" placeholder="Confirm Password" name="con_password">
                    <span class="error-msg"><?php echo form_error('con_password'); ?></span>
                  </div>
                </div>
                 
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                 <div class="col-sm-8">
                <button type="submit" class="btn btn-info pull-right">Update</button>
                </div>
              </div>
              <!-- /.box-footer -->
            </form>
          </div>
   
   </div>
 </div>
