<script language="javascript" type="text/javascript">
$(document).ready(function() {
      $('.popup').click(function(event) {
      var category_id  = $('#category_id').val();
      if(category_id!=''){
         var urls='<?php echo base_url();?>me/checkmachinedetail/showbar/'+category_id;
         event.preventDefault();
         window.open(urls, "popupWindow", "width=275,height=600,scrollbars=yes");
      }else{
        alert('Please Select Category');
      }
      
});
      });
      </script>
<div class="row">
        <div class="col-xs-12">
   <div class="box box-primary">
           
<div class="box box-info">
          
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" action="#" method="POST" enctype="multipart/form-data">
              <div class="box-body">
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Category <span style="color:red;">  *</span></label>
                  <div class="col-sm-4">
                    <select class="form-control" name="category_id" required id="category_id">
                    <option value="1">Sponsor Complementary Bronze</option>
                    <option value="2">Bronze</option>
                    <option value="3">Silver</option>
                    <option value="4">Gold</option>
                    <option value="5">Platinum</option>
                    <option value="6">Titanium</option>
                    <option value="7">Complementary</option>
                    <option value="8">VIP Complementary</option>
                    <option value="9">Sponsor Complementary Silver</option>
                  </select>                    
                  <span class="error-msg"><?php echo form_error("category_id");?></span>
                  </div>
                </div>
             </div>
              <!-- /.box-body -->
              <div class="box-footer">
                 <div class="col-sm-6"></div>
                 <div class="col-sm-4">
                <button type="submit" class="btn btn-info pull-left popup">Print</button>
                </div>
              </div>
          
            </form>
          </div>
            <!-- /.box-header -->

            <!-- /.box-body -->
          </div>
        </div>
 </div>
