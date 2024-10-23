<?php include_once 'asset/admin-ajax.php'; ?>

<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>asset/js/kendo.default.min.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>asset/js/kendo.common.min.css" />
<script type="text/javascript" src="<?php echo base_url(); ?>asset/js/kendo.all.min.js"></script>


<div class="row">
    <div class="col-md-12">
        <div class="box box-info">

            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" action="<?php echo base_url(); ?>configcontroller/saveUser/<?php if (isset($user_info->id)) echo "/$user_info->id"; ?>" method="POST" enctype="multipart/form-data" autocomplete="off">
                <div class="box-body">
                 <div class="col-sm-6">
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-4 control-label">Full Name <span style="color:red;">  *</span></label>

                        <div class="col-sm-8">
                            <input type="text" autocomplete="off" class="form-control" name="user_name" id="user_name" placeholder="Name" value="<?php if (isset($user_info->id)) echo "$user_info->user_name"; else  echo set_value('user_name'); ?>" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-4 control-label">ID NO</label>
                        <div class="col-sm-8">
                        <input type="text" class="form-control" id="employee_id_no" name="employee_id_no" placeholder="ID NO" value="<?php if (isset($user_info->id)) echo "$user_info->employee_id_no"; else  echo set_value('employee_id_no'); ?>">
                           
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-4 control-label">Email Address  <span style="color:red;">  *</span></label>

                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="email_address" name="email_address" placeholder="Email Address" value="<?php if (isset($user_info->id)) echo "$user_info->email_address"; else echo set_value('email_address'); ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-4 control-label">Mobile No. 手机号码。</label>

                        <div class="col-sm-8">
                        <input type="text" class="form-control" id="mobile" name="mobile" placeholder="Mobile No. 手机号码。" value="<?php if (isset($user_info->id)) echo "$user_info->mobile"; else  echo set_value('mobile'); ?>">
                           
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-4 control-label">Password <span style="color:red;">  *</span></label>

                        <div class="col-sm-8">
                            <input type="password" name="password" class="form-control" id="inputEmail3" placeholder="Password" value="<?php echo set_value('password'); ?>">
                            <span class="error-msg"><?php echo form_error("password"); ?></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-4 control-label">Designation <span style="color:red;">  *</span></label>
                        <div class="col-sm-8">
                            <select class="form-control select2" name="post_id" id="post_id">
                              <option value="">Select Designation</option>
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
                        <label for="inputEmail3" class="col-sm-4 control-label">Department <span style="color:red;">  *</span></label>
                        <div class="col-sm-8">
                            <select class="form-control select2" name="department_id" id="department_id">
                              <option value="0">Select Department</option>
                              <?php foreach ($dlist as $value) {  ?>
                                <option value="<?php echo $value->department_id; ?>"
                                  <?php  if(isset($user_info->id)) echo $value->department_id==$user_info->department_id? 'selected="selected"':0; else echo set_select('post_id',$value->department_id);?>>
                                  <?php echo $value->department_name; ?></option>
                                <?php } ?>
                            </select> 
                            <span class="error-msg"><?php echo form_error("department_id"); ?></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-4 control-label">PA limit <span style="color:red;">  *</span></label>

                        <div class="col-sm-8">
                            <input type="text" name="pa_limit" class="form-control integerchk"  placeholder="PA limit" value="<?php if (isset($user_info->id)) echo "$user_info->pa_limit"; else echo 0; ?>">
                            <span class="error-msg"><?php echo form_error("pa_limit"); ?></span>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-sm-4 control-label"> Update Permission</label>
                        <div class="col-sm-8">
                          <div class="checkbox">
                              <input type="checkbox" name="update" value="YES"<?php if(isset($user_info->id)){if($user_info->update=='YES'){echo "checked='checked'"; }}?>>
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-4 control-label"> Delete 删除 Permission</label>
                        <div class="col-sm-8">
                          <div class="checkbox">
                              <input type="checkbox" name="delete" value="YES"<?php if(isset($user_info->id)){if($user_info->delete=='YES'){echo "checked='checked'"; }}?>>
                          </div>
                        </div>
                      </div>

                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-4 control-label">Photo</label>
                        <div class="col-sm-8">
                            <div class="input-group" >
                                <input type="text" class="form-control file-focus-field"  placeholder="No File Selected">
                                <span class="input-group-addon btn btn-primary" style="Background-color:#0C5889;color:#fff;border:1px solid #069">Select</span>
                            </div>
                            <input type="file" class="form-control"  class="form-control file-field" name="photo"  style="opacity:0;position: absolute;top:0"/>
                        </div>
                    </div>
                </div>
                  <!-- col-md-6 end -->
                      <div class="col-sm-6">
                        <div id="roll" class="list-group">
                                <a href="#" class="list-group-item disabled">
                                    User Permission Level
                                </a>
                                <a href="#" class="list-group-item">
                                    <div class="k-header">
                                        <div class="box-col">
                                            <div id="treeview"></div>
                                        </div>
                                    </div>
                                </a>
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
<script>
         $("#treeview").kendoTreeView({
        checkboxes: {
        checkChildren: true,
                template: "<input type='checkbox' #= item.check# name='menu[]' value='#= item.value #'  />"

        },
                check: onCheck,
                dataSource: [
<?php foreach ($result as $parent => $v_parent): ?>
    <?php if (is_array($v_parent)): ?>
        <?php foreach ($v_parent as $parent_id => $v_child): ?>
                            {
                            id: "", text: "<?php echo $parent; ?>", value: "<?php
            if (!empty($parent_id)) {
                echo $parent_id;
            }
            ?>", expanded: false, items: [
            <?php foreach ($v_child as $child => $v_sub_child) : ?>
                <?php if (is_array($v_sub_child)): ?>
                    <?php foreach ($v_sub_child as $sub_chld => $v_sub_chld): ?>
                                        {
                                        id: "", text: "<?php echo $child; ?>", value: "<?php
                        if (!empty($sub_chld)) {
                            echo $sub_chld;
                        }
                        ?>", expanded: false, items: [
                        <?php foreach ($v_sub_chld as $sub_chld_name => $sub_chld_id): ?>
                                            {
                                            id: "", text: "<?php echo $sub_chld_name; ?>",<?php
                            if (!empty($roll[$sub_chld_id])) {
                                echo $roll[$sub_chld_id] ? 'check: "checked",' : '';
                            }
                            ?> value: "<?php
                            if (!empty($sub_chld_id)) {
                                echo $sub_chld_id;
                            }
                            ?>",
                                            },
                        <?php endforeach; ?>
                                        ]
                                        },
                    <?php endforeach; ?>
                <?php else: ?>
                                    {
                                    id: "", text: "<?php echo $child; ?>", <?php
                    if (!is_array($v_sub_child)) {
                        if (!empty($roll[$v_sub_child])) {
                            echo $roll[$v_sub_child] ? 'check: "checked",' : '';
                        }
                    }
                    ?> value: "<?php
                    if (!empty($v_sub_child)) {
                        echo $v_sub_child;
                    }
                    ?>",
                                    },
                <?php endif; ?>
            <?php endforeach; ?>
                            ]
                            },
        <?php endforeach; ?>
    <?php else: ?>
                        { <?php if ($parent == 'Dashboard') {
            ?>
                            id: "", text: "<?php echo $parent ?>", <?php echo 'check: "checked",';
            ?>  value: "<?php
            if (!is_array($v_parent)) {
                echo $v_parent;
            }
            ?>"
            <?php
        } else {
            ?>
                            id: "", text: "<?php echo $parent ?>", <?php
            if (!is_array($v_parent)) {
                if (!empty($roll[$v_parent])) {
                    echo $roll[$v_parent] ? 'check: "checked",' : '';
                }
            }
            ?> value: "<?php
            if (!is_array($v_parent)) {
                echo $v_parent;
            }
            ?>"
        <?php }
        ?>
                        },
    <?php endif; ?>
<?php endforeach; ?>
                ]
        });
                // show checked node IDs on datasource change
      function onCheck() {
      var checkedNodes = [],
              treeView = $("#treeview").data("kendoTreeView"),
              message;
              checkedNodeIds(treeView.dataSource.view(), checkedNodes);
              $("#result").html(message);
      }
    </script>


    <script type="text/javascript">
            $(function () {
            $("#treeview .k-checkbox input").eq(0).hide();
                    $('form').submit(function () {
            $('#treeview :checkbox').each(function () {
            if (this.indeterminate) {
            this.checked = true;
            }
            });
            })
            })
    </script>    

    <script>
  $(document).ready(function(){

      $("#userform").submit(function(){
          var user_name=$("#user_name").val();
          var email_address=$("#email_address").val();
          var mobile=$("#mobile").val();
          var post_id=$("#post_id").val();
          var department_id=$("#department_id").val();
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
          if(department_id==""){
              $("#department_id").css({"border-color":"red"});
              $("#department_id").parent().children("span").show(200).delay(5000).hide(200,function(){
              $("#department_id").css({"border-color":"#ccc"});
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