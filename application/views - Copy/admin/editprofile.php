<div class="row">
    <div class="col-md-12">
        <div class="box box-info">

            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" action="<?php echo base_url(); ?>dashboard/saveP" method="POST" enctype="multipart/form-data">
                <div class="box-body">
                 <div class="col-sm-6">
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Full Name <span style="color:red;">  *</span></label>

                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="user_name" id="user_name" placeholder="Name" value="<?php if (isset($user_info->id)) echo "$user_info->user_name"; else  echo set_value('user_name'); ?>" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Email Address  <span style="color:red;">  *</span></label>

                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="email_address" name="email_address" placeholder="Email Address" value="<?php if (isset($user_info->id)) echo "$user_info->email_address"; else echo set_value('email_address'); ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Mobile No. 手机号码。</label>
                        <div class="col-sm-8">
                        <input type="text" class="form-control" id="mobile" name="mobile" placeholder="Mobile No. 手机号码。" value="<?php if (isset($user_info->id)) echo "$user_info->mobile"; else  echo set_value('mobile'); ?>">
                           
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Post <span style="color:red;">  *</span></label>
                        <div class="col-sm-8">
                            <select class="form-control" name="post_id" id="post_id">
                              <option value="">Select Post</option>
                              <?php foreach ($postlist as $value) {  ?>
                                <option value="<?php echo $value->post_id; ?>"
                                  <?php  if(isset($user_info->id)) echo $value->post_id==$user_info->post_id? 'selected="selected"':0; else echo set_select('post_id',$value->post_id);?>>
                                  <?php echo $value->post_name; ?></option>
                                <?php } ?>
                            </select> 
                            <span class="error-msg"><?php echo form_error("post_id"); ?></span>
                        </div>
                    </div>
       

                    <div class="form-group">
                      <label class="col-sm-4 control-label">Photo</label>
                      <div class="col-sm-8">
                        <div class="input-group" >
                            <input type="text" class="form-control file-focus-field"  placeholder="No File Selected">
                            <span class="input-group-addon btn btn-primary" style="Background-color:#0C5889;color:#fff;border:1px solid #069">Select</span>
                        </div>
                        <input type="file" class="form-control"  class="form-control file-field" name="photo"  style="opacity:0;position: absolute;top:0"/>
                        <br>
                        <img src="<?php echo base_url(); ?>asset/photo/<?php echo $user_info->photo; ?>" class="user-image img-circle" style="width: 150px" alt="User Image">
                        </div>

                    </div>
                </div>
                  <!-- col-md-6 end -->
                  </div>
                <!-- /.box-body -->

                <div class="box-footer">
                    <div class="col-sm-2"><a href="<?php echo base_url(); ?>dashboard" class="btn btn-info">Cancel</a></div>
                    <div class="col-sm-6">
                        <button type="submit" class="btn btn-info pull-right">Update</button>
                    </div>
                </div>
                <!-- /.box-footer -->
            </form>
        </div>

    </div>
</div>


  

    <script>
  $(document).ready(function(){

      $("#userform").submit(function(){
          var user_name=$("#user_name").val();
          var email_address=$("#email_address").val();
          var mobile=$("#mobile").val();
          var post_id=$("#post_id").val();
          var error=false;
          if(user_name==""){
              $("#user_name").css({"border-color":"red"});
              $("#user_name").parent().children("span").show(200).delay(5000).hide(200,function(){
              $("#user_name").css({"border-color":"#ccc"});
              });
              error=true;
          }
       
          if(email_address==""){
              $("#email_address").css({"border-color":"red"});
              $("#email_address").parent().children("span").show(200).delay(5000).hide(200,function(){
              $("#email_address").css({"border-color":"#ccc"});
              });
              error=true;
          }
           if(mobile==""){
              $("#mobile").css({"border-color":"red"});
              $("#mobile").parent().children("span").show(200).delay(5000).hide(200,function(){
              $("#mobile").css({"border-color":"#ccc"});
              });
              error=true;
          }
          if(post_id==""){
              $("#post_id").css({"border-color":"red"});
              $("#post_id").parent().children("span").show(200).delay(5000).hide(200,function(){
              $("#post_id").css({"border-color":"#ccc"});
              });
              error=true;
          }
      

          if(error==true){
              return false;
          }
          //return false;
      });
  });
    </script>