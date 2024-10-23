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
            <form class="form-horizontal" action="<?php echo base_url();?>supplier/save<?php if(isset($info)) echo "/$info->supplier_id"; ?>" method="POST" enctype="multipart/form-data">
              <div class="box-body">
                <div class="form-group">
                  <label class="col-sm-2 control-label">Supplier Name 供应商名称 <span style="color:red;">  *</span></label>
                  <div class="col-sm-4">
                    <input type="text" name="supplier_name" class="form-control" placeholder="Supplier Name 供应商名称" value="<?php if(isset($info->supplier_name)) echo $info->supplier_name; else echo set_value('supplier_name'); ?>">
                   <span class="error-msg"><?php echo form_error("supplier_name");?></span>
                  </div>
              
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label">Phone No <span style="color:red;">  *</span></label>
                  <div class="col-sm-4">
                    <input type="text" name="phone_no" class="form-control" placeholder="Phone No" value="<?php if(isset($info->phone_no)) echo $info->phone_no; else echo set_value('phone_no'); ?>">
                   <span class="error-msg"><?php echo form_error("phone_no");?></span>
                  </div>
                  <label class="col-sm-2 control-label">Mobile No. 手机号码。 <span style="color:red;">  </span> </label>
                  <div class="col-sm-4">
                    <input type="text" name="mobile_no" class="form-control"  placeholder="Mobile No. 手机号码。" value="<?php if(isset($info->mobile_no)) echo $info->mobile_no; else echo set_value('mobile_no'); ?>">
                   <span class="error-msg"><?php echo form_error("mobile_no");?></span>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label">Email Address </label>
                  <div class="col-sm-4">
                    <input type="text" name="email_address" class="form-control" placeholder="Email Address" value="<?php if(isset($info->email_address)) echo $info->email_address; else echo set_value('email_address'); ?>">
                   <span class="error-msg"><?php echo form_error("email_address");?></span>
                  </div>
                  <label class="col-sm-2 control-label">Company Address </label>
                  <div class="col-sm-4">
                  <textarea  name="company_address" class="form-control" rows="1"><?php if(isset($info->company_address)) echo $info->company_address; else echo set_value('company_address'); ?> </textarea>
                   <span class="error-msg"><?php echo form_error("company_address");?></span>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label">Payment terms </label>
                  <div class="col-sm-4">
                    <textarea  name="payment_terms" class="form-control" rows="1"><?php if(isset($info->payment_terms)) echo $info->payment_terms; else echo set_value('payment_terms'); ?> </textarea>
                   <span class="error-msg"><?php echo form_error("payment_terms");?></span>
                  </div>
                  <label  class="col-sm-2 control-label">Payment terms file</label>
                  <div class="col-sm-4">
                      <div class="input-group" >
                        <input type="file" name="payment_term_file" class="form-control"  placeholder="No File Selected">
                      </div>
                      <span>Only allow pdf</span>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label">VAT Number  </label>
                  <div class="col-sm-4">
                    <textarea  name="vat_number" class="form-control" rows="1"><?php if(isset($info->vat_number)) echo $info->vat_number; else echo set_value('vat_number'); ?> </textarea>
                   <span class="error-msg"><?php echo form_error("vat_number");?></span>
                  </div>
                  <label  class="col-sm-2 control-label">VAT file</label>
                  <div class="col-sm-4">
                      <div class="input-group" >
                        <input type="file" name="vat_number_file" class="form-control"  placeholder="No File Selected">
                      </div>
                      <span>Only allow pdf</span>
                  </div>
                </div>
                </div>
                <div class="box-footer">
                 <div class="col-sm-6">
                  <a href="<?php echo base_url(); ?>supplier/lists" class="btn btn-info"><i class="fa fa-arrow-circle-o-left"></i> Back</a></div>
                 <div class="col-sm-4">
                <button type="submit" class="btn btn-success pull-left"><i class="fa fa-send"></i> SAVE 保存</button>
                </div>
              <!-- /.box-body -->
            </form>
          </div>
            <!-- /.box-header -->
          
          </div>
        </div>
 </div>
