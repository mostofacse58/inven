     <style type="text/css">
.btn-circle {
	width: 30px;
	height: 30px;
	text-align: center;
	padding: 6px 0;
	font-size: 12px;
	line-height: 1.428571429;
	border-radius: 15px;
}
.form-group{
  margin-top: 15px;
  overflow: hidden;
}
</style>
    <section class="news" id="news"><!-- Section id-->
        <div class="container">
          <div class="row">
          <div class="col-md-12 col-sm-12">
          <div class="section-title center-text">
              <h1>SIM Requisition Form</h1>
              <img src="<?php echo base_url('');?>asset2/images/line-02.jpg" alt="" />
          </div>
	       <div class="panel panel-primary">

          <div class="panel-heading">
            <h3 class="panel-title">Please Fill up Information for SIM Requisition</h3>
          </div>
          <div class="panel-body">


	       <div class="row">
				<?php
				$exception = $this->session->userdata('exception');
				if ($exception) {
					?>
					<div class="row">
						<div class="col-md-12">
							<div class="alert alert-danger" id="danger-alert">
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
								<?php echo $exception; ?>
							</div>
						</div>
					</div>
					<?php
					$this->session->unset_userdata('exception');
				}	?>
				<?php
				$exceptions = $this->session->userdata('exceptions');
				if($exceptions){
					?>
					<div class="row">
						<div class="col-md-12">
							<div class="alert alert-success" id="success-alert">
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                  &times;</button>
								<?php echo $exceptions; ?>
							</div>
						</div>
					</div>
					<?php
					$this->session->unset_userdata('exceptions');
				}	?>
	</div>

  <div class="row">
    <div class="col-md-12 col-xs-12">
         <form role="form" action="<?php echo base_url('');?>requisition/submitapplication" method="post"  enctype="multipart/form-data">
       <div class="form-group">
          <div class="col-sm-6">
            <label class="control-label">Employee Name <span style="color:red;">  *</span></label>
                <input type="text" class="form-control" 
                      placeholder="Employee Name" value="<?php echo set_value('employee_name'); ?>" name="employee_name"  required="required">
                <span class="error-msg"><?php echo form_error('employee_name'); ?></span>
            </div>
            <div class="col-sm-6">
            <label class="control-label">Employee ID <span style="color:red;">  *</span></label>
                <input type="text" class="form-control" 
                      placeholder="Employee ID" value="<?php echo set_value('employee_card_id'); ?>" name="employee_card_id"  required="required">
                <span class="error-msg"><?php echo form_error('employee_card_id'); ?></span>
            </div>
                
          </div>
          <div class="form-group">
            <div class="col-sm-6">
                  <label class=" control-label">Designation <span style="color:red;">  *</span></label>
                  <select type="text" class="form-control select2" name="post_id" required>
                  <option value="">Select Designation</option>
                  <?php $plist=$this->db->query("SELECT * FROM post")->result();
                  foreach ($plist as $value) {  ?>
                        <option value="<?php echo $value->post_id; ?>"
                          <?php  echo set_select('post_id',$value->post_id);?>>
                          <?php echo $value->post_name; ?></option>
                        <?php } ?>
                    </select>
                <span class="error-msg"><?php echo form_error('post_id'); ?></span>
            </div>
            <div class="col-sm-6">
              <label class="control-label">Date of Join <span style="color:red;">  *</span></label>
                <input type="text" class="form-control date" 
                      placeholder="Date of Join" value="<?php echo set_value('joining_date'); ?>" name="joining_date"  readonly>
                <span class="error-msg"><?php echo form_error('joining_date'); ?></span>
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-6">
              <label class="control-label">Department <span style="color:red;">  *</span></label>
               <select type="text" class="form-control select2" name="department_id" required>
                <option value="">Select Department</option>
                  <?php $dlist=$this->db->query("SELECT * FROM department_info")->result();
                  foreach ($dlist as $value) {  ?>
                        <option value="<?php echo $value->department_id; ?>"
                          <?php  echo set_select('department_id',$value->department_id);?>>
                          <?php echo $value->department_name; ?></option>
                        <?php } ?>
                     
                    </select>
                <span class="error-msg"><?php echo form_error('department_id'); ?> </span>
            </div>
            <div class="col-sm-6">
            <label class="control-label">Personal Mobile No. 手机号码。 </label>
              <input type="text" class="form-control" 
                  placeholder="Personal Mobile No. 手机号码。" value="<?php echo set_value('per_mobile_no'); ?>" name="per_mobile_no">
            <span class="error-msg"><?php echo form_error('per_mobile_no'); ?></span>
           </div>
            
          </div>
         
          <div class="form-group">
            <div class="col-sm-6">
              <label class="control-label">Mailing Address
              </label>
                <input type="text" class="form-control" 
                      placeholder="Mailing Address" value="<?php echo set_value('email_address'); ?>" name="email_address">
                <span class="error-msg"><?php echo form_error('email_address'); ?></span>
            </div>
            <div class="col-sm-6">
            <label class="control-label">Photo</label>
               <input type="file" class="form-control"  name="photo">
                <span class="error-msg"><?php 
                if(isset($photoerror)) echo $photoerror; ?></span>
            <div class="row">
              <div class="col-sm-12">
              <span id="pwmatch" class="glyphicon glyphicon-ok" style="color:#FF0004;"></span> Allowed types are: jpg, jpeg, png.
              </div>
          </div>
            </div>
         </div>

          
          <button class="btn btn-success btn-lg pull-right" type="submit">Submit</button>
          </form>
      </div>
    </div>
</div>
</div>
</div>                
</div>            
</div>
</section>

    