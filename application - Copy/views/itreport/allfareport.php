<script src="<?php echo base_url('asset/js/plugins/datepicker/bootstrap-datepicker.js'); ?>"></script>
<script src="<?php echo base_url('asset/js/plugins/datepicker/bootstrap-datepicker.js'); ?>"></script>
<script>
    $(document).ready(function(){
       $('.date').datepicker({
            "format": "dd/mm/yyyy",
            "todayHighlight": true,
            "autoclose": true
        });
  var category_ids = "<?php echo set_value('category_id') ?>";
  var product_ids = "<?php echo set_value('product_id') ?>";
    var department_id=$('#department_id').val();
        if(department_id !=''){
        $.ajax({
          type:"post",
          url:"<?php echo base_url()?>"+'it/allfareport/getcategory',
          data:{department_id:department_id},
          success:function(data){
            $("#category_id").empty();
            $("#category_id").append(data);
            if(category_ids != ''){
              $('#category_id').val(category_ids).change();
            } }
        });
        $.ajax({
          type:"post",
          url:"<?php echo base_url()?>"+'it/allfareport/getAssetlist',
          data:{department_id:department_id},
          success:function(data){
            $("#product_id").empty();
            $("#product_id").append(data);
            if(product_ids != ''){
              $('#product_id').val(product_ids).change();
            } }
        });
      }
      ///////////////////////
      $('#department_id').on('change',function(){
        var department_id=$('#department_id').val();
        if(department_id !=''){
        $.ajax({
          type:"post",
          url:"<?php echo base_url()?>"+'it/allfareport/getcategory',
          data:{department_id:department_id},
          success:function(data){
            $("#category_id").empty();
            $("#category_id").append(data);
            if(category_ids != ''){
              $('#category_id').val(category_ids).change();
            }}
        });
        $.ajax({
          type:"post",
          url:"<?php echo base_url()?>"+'it/allfareport/getAssetlist',
          data:{department_id:department_id},
          success:function(data){
            $("#product_id").empty();
            $("#product_id").append(data);
            if(product_ids != ''){
              $('#product_id').val(product_ids).change();
            }}
        });
      }
      });
    });
</script>
<script language="javascript" type="text/javascript">
$(document).ready(function() {
  $('.popup').click(function(event) {
     var urls=$(this).attr("href");
     event.preventDefault();
     window.open(urls, "popupWindow", "width=1050,height=700,scrollbars=yes");
  });
});
      </script>
<div class="row">
<div class="col-xs-12">
  <div class="box box-primary">
  <div class="box-header">
  <div class="widget-block">
<div class="widget-head">
<h5><i class="fa fa-file-excel-o" aria-hidden="true"></i>
 <?php echo ucwords($heading); ?></h5>
<div class="widget-control pull-right">
<?php if(isset($resultdetail)){ ?>
<a class="btn btn-sm btn-primary pull-right" style="margin-right:0px;" href="<?php echo base_url(); ?>it/allfareport/downloadExcel<?php echo "/$department_id/$category_id/$product_id/$location_id/$issue_status/$take_department_id/$mlocation_id/$asset_encoding";  ?>">
<i style="background-color: green" class="fa fa-file-excel-o"></i>
Download Excel
</a>
<!-- 
<a class="btn btn-sm btn-primary pull-right" style="margin-right:0px;" target="_blank" href="<?php echo base_url(); ?>it/allfareport/downloadPdf<?php echo "/$department_id/$category_id/$product_id/$location_id/$issue_status/$take_department_id/$mlocation_id/$asset_encoding";  ?>">
<i style="background-color: red" class="fa fa-file-pdf-o"></i>
Download pdf
</a> -->
<?php } ?>
</div>
</div>
</div>

</div>
<div class="box box-info">
      <!-- form start -->
      <form class="form-horizontal" action="<?php echo base_url();?>it/allfareport/reportResult" method="POST" enctype="multipart/form-data">
        <div class="box-body">
          <div class="form-group">
            <label class="col-sm-1 control-label">Holder Dept.</label>
            <div class="col-sm-2">
              <select class="form-control select2" name="department_id" id="department_id">
              <?php 
              foreach($dlist as $rows){  ?>
              <option value="<?php echo $rows->department_id; ?>" 
                <?php echo $rows->department_id==set_value('department_id')? 'selected="selected"':0; ?>>
                 <?php echo $rows->department_name; ?></option>
              <?php }  ?>
            </select>                    
            <span class="error-msg"><?php echo form_error("department_id");?></span>
            </div>
            <label class="col-sm-1 control-label">Category </label>
            <div class="col-sm-2">
              <select class="form-control select2" name="category_id" id="category_id">
              <option value="All">All</option>
            </select>                    
            <span class="error-msg"><?php echo form_error("category_id");?></span>
            </div>
            <label class="col-sm-2 control-label">Asset Model</label>
           <div class="col-sm-4">
              <select class="form-control select2" name="product_id" id="product_id">
              <option value="All">All</option>
            </select>                    
            <span class="error-msg"><?php echo form_error("product_id");?></span>
            </div>
          </div>
           <div class="form-group">
            <label class="col-sm-1 control-label">Location </label>
            <div class="col-sm-2">
              <select class="form-control select2"  name="location_id" id="location_id">
                <option value="All">All</option>
                <?php
                 foreach ($llist as $value) {  ?>
                <option value="<?php echo $value->location_id; ?>"
                    <?php  if(isset($location_id)) echo $value->location_id==$location_id? 'selected="selected"':0; else echo set_select('location_id',$value->location_id);?>>  <?php echo $value->location_name; ?></option>
                  <?php } ?>
              </select>
            </div>
          <label class="col-sm-1 control-label">Status 状态 </label>
          <div class="col-sm-2">
            <select class="form-control select2"  name="issue_status" id="issue_status">
              <option value="All"
                <?php  if(isset($issue_status)) echo 'All'==$issue_status? 'selected="selected"':0; else echo set_select('issue_status','All');?>>
                  All</option>
              <option value="1"
                <?php  if(isset($issue_status)) echo 1==$issue_status? 'selected="selected"':0; else echo set_select('issue_status',1);?>>
                  USED</option>
                  <option value="2"
                <?php  if(isset($issue_status)) echo 2==$issue_status? 'selected="selected"':0; else echo set_select('issue_status',2);?>>
                  IDLE/Stock</option>
                  <option value="3"
                <?php  if(isset($issue_status)) echo 3==$issue_status? 'selected="selected"':0; else echo set_select('issue_status',3);?>>
                  UNDER SERVICE</option>
            </select>
           <span class="error-msg"><?php echo form_error("issue_status");?></span>
          </div>
           <div class="col-sm-2">
              <input type="text" name="asset_encoding" class="form-control" placeholder="SN/CODE" value="<?php  echo set_value('asset_encoding'); ?>" autofocus>
            </div>
            <label class="col-sm-2 control-label">Rcv. Dept.</label>
            <div class="col-sm-2">
              <select class="form-control select2" name="take_department_id" id="take_department_id">
              <option value="All">All</option>
              <?php 
              foreach($dlist as $rows){  ?>
              <option value="<?php echo $rows->department_id; ?>" 
                <?php echo $rows->department_id==set_value('take_department_id')? 'selected="selected"':0; ?>>
                 <?php echo $rows->department_name; ?></option>
              <?php }  ?>
            </select>                    
            <span class="error-msg"><?php echo form_error("take_department_id");?></span>
            </div>
          </div>
            <div class="form-group">
            <label class="col-sm-1 control-label">Main Area </label>
            <div class="col-md-2">
            <select class="form-control select2" name="mlocation_id">
            <option value="All" selected="selected">All</option>
            <?php $mllist=$this->db->query("SELECT * FROM main_location")->result();
            foreach ($mllist as $rows) { ?>
              <option value="<?php echo $rows->mlocation_id; ?>" 
              <?php if (isset($info))
                  echo $rows->mlocation_id == $mlocation_id ? 'selected="selected"' : 0;
              else
                  echo $rows->mlocation_id == set_value('mlocation_id') ? 'selected="selected"' : 0;
              ?>><?php echo $rows->mlocation_name; ?></option>
                  <?php } ?>
              </select>
            <span class="error-msg"><?php echo form_error("mlocation_id"); ?></span>
          </div>
            <div class="col-sm-2">
            <button type="submit" class="btn btn-success pull-left"> Search 搜索 </button>
          </div>
          </div>

        </div>
        <!-- /.box-body -->
        <!-- <div class="box-footer">
           <div class="col-sm-6"></div>
           <div class="col-sm-2">
          <button type="submit" class="btn btn-info pull-left">Result</button>
          </div>
        </div> -->
      </form>
      <?php if(isset($resultdetail)){ ?>
      <!-- /////////////////////////////////// -->
      <div class="table-responsive table-bordered">
          <table class="table table-bordered table-striped colortd" style="width:99%;border:#000" >
            <thead>
              <tr>
                <th style="text-align:center;width:5%;">SN</th>
                <th style="width:10%">Ventura Code</th>
                <th style="text-align:center;width:7%">Serial No</th>
                <th style="width:15%;">Asset Name</th>
                <?php if($category_id=='All'){ ?>
                <th style="width:10%">Category</th>
                <?php } ?>
                <?php if($product_id=='All'){ ?>
                <th style="width:10%;text-align:center">Model NO</th>
                <?php } ?>
                <th style="text-align:center;width:10%">Purchase Date</th>
                <th style="text-align:center;width:7%">Location</th>
                <th style="text-align:center;width:10%">Department</th>
                <th style="text-align:center;width:10%">Employee</th>
                <th style="text-align:center;width:8%">Status 状态</th>
                <th style="text-align:center;width:10%">Note</th>
              </tr>
              </thead>
              <tbody>
              <?php
              if(isset($resultdetail)&&!empty($resultdetail)): 
                $i=1;
                foreach($resultdetail as $row):
                  ?>
                  <tr>
                    <td style="text-align:center;background-color:<?php if($row->it_status==2) 
                          echo "#FFDF00"; else echo "#FFFFFF"; ?>">
                      <?php echo $i++; ?></td>
                    <td style="text-align:center;background-color:<?php if($row->it_status==2)echo "#FFDF00"; elseif($row->it_status==4) echo "#FF0000";  else echo "#FFFFFF"; ?>">
                      <?php echo $row->ventura_code; ; ?></td>
                      <td style="vertical-align: text-top;text-align: center;background-color:<?php if($row->it_status==2)echo "#FFDF00"; elseif($row->it_status==4) echo "#FF0000";  else echo "#FFFFFF"; ?>">
                    <?php  echo $row->asset_encoding; ?></td>
                    <td style="background-color:<?php if($row->it_status==2)echo "#FFDF00"; elseif($row->it_status==4) echo "#FF0000";  else echo "#FFFFFF"; ?>"><?php echo $row->product_name;?></td>
                    <?php if($category_id=='All'){ ?>
                    <td style="text-align:center;background-color:<?php if($row->it_status==2)echo "#FFDF00"; elseif($row->it_status==4) echo "#FF0000";  else echo "#FFFFFF"; ?>">
                      <?php echo $row->category_name; ; ?></td>
                      <?php } ?>
                    <?php if($product_id=='All'){ ?>
                    <td style="text-align:center;background-color:<?php if($row->it_status==2)echo "#FFDF00"; elseif($row->it_status==4) echo "#FF0000";  else echo "#FFFFFF"; ?>">
                      <?php echo $row->product_code;  ?></td> 
                      <?php } ?>
                      <td style="text-align:center;background-color:<?php if($row->it_status==2)echo "#FFDF00"; else echo "#FFFFFF"; ?>">
                    <?php echo findDate($row->purchase_date);  ?></td>
                    <td style="vertical-align: text-top;text-align: center;background-color:<?php if($row->it_status==2)echo "#FFDF00"; elseif($row->it_status==4) echo "#FF0000";  else echo "#FFFFFF"; ?>">
                    <?php  echo $row->location_name; ?></td>
                    <td style="text-align:center;background-color:<?php if($row->it_status==2)echo "#FFDF00"; elseif($row->it_status==4) echo "#FF0000";  else echo "#FFFFFF"; ?>">
                    <?php echo $row->department_name;  ?></td>
                    <td style="vertical-align: text-top;text-align: center;background-color:<?php if($row->it_status==2)echo "#FFDF00"; elseif($row->it_status==4) echo "#FF0000";  else echo "#FFFFFF"; ?>">
                    <?php if($row->employee_id!='') echo "$row->employee_name($row->employee_id)"; ?></td>
                    <td style="vertical-align: text-top;text-align: center;background-color:<?php if($row->it_status==2)echo "#FFDF00"; elseif($row->it_status==4) echo "#FF0000";  else echo "#FFFFFF"; ?>">
                    <?php  echo CheckStatuspro($row->it_status); ?></td>
                    <td style="text-align:center;background-color:<?php if($row->it_status==2)echo "#FFDF00"; elseif($row->it_status==4) echo "#FF0000";  else echo "#FFFFFF"; ?>">
                    <?php echo "$row->other_description, $row->remarks";  ?></td>
                    
             
                  </tr>
                  <?php
                  endforeach;
              endif;
              ?>
              </tbody>
              </table>
              </div>
              <?php } ?>
    </div>
      <!-- /.box-header -->

      <!-- /.box-body -->
    </div>
  </div>
 </div>
