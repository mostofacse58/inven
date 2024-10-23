<script src="<?php echo base_url('asset/js/plugins/datepicker/bootstrap-datepicker.js'); ?>"></script>
<script src="<?php echo base_url('asset/js/plugins/datepicker/bootstrap-datepicker.js'); ?>"></script>
<script>
$(document).ready(function(){
 $('.date').datepicker({
      "format": "dd/mm/yyyy",
      "todayHighlight": true,
      "autoclose": true
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
<a class="btn btn-sm btn-primary pull-right" style="margin-right:0px;" href="<?php echo base_url(); ?>it/faissuereport/downloadpdf<?php echo "/$category_id/$department_id/$employee_id";  ?>">
<i class="fa fa-file-excel-o"></i>
Download
</a>
<?php } ?>
</div>
</div>
</div>

</div>
<div class="box box-info">
      <!-- form start -->
      <form class="form-horizontal" action="<?php echo base_url();?>it/faissuereport/reportResult" method="POST" enctype="multipart/form-data">
        <div class="box-body">
          <div class="form-group">
            <label class="col-sm-2 control-label">Category </label>
            <div class="col-sm-3">
              <select class="form-control select2" name="category_id" id="category_id">
              <option value="All">All</option>
              <?php foreach($clist as $rows){  ?>
              <option value="<?php echo $rows->category_id; ?>" 
                <?php if(isset($category_id))echo $rows->category_id==$category_id? 'selected="selected"':0; else
                 echo $rows->category_id==set_value('category_id')? 'selected="selected"':0; ?>>
                 <?php echo $rows->category_name; ?></option>
              <?php }  ?>
            </select>                    
            <span class="error-msg"><?php echo form_error("category_id");?></span>
            </div>
            <label class="col-sm-2 control-label">Department</label>
            <div class="col-sm-3">
              <select class="form-control select2" name="department_id" id="department_id">
              <option value="All">All</option>
              <?php 
              foreach($dlist as $rows){  ?>
              <option value="<?php echo $rows->department_id; ?>" 
                <?php echo $rows->department_id==set_value('department_id')? 'selected="selected"':0; ?>>
                 <?php echo $rows->department_name; ?></option>
              <?php }  ?>
            </select>                    
            <span class="error-msg"><?php echo form_error("department_id");?></span>
            </div>
          </div>
          <div class="form-group">
         
            <label class="col-sm-2 control-label">Employee ID</label>
            <div class="col-sm-3">
              <input type="text" name="employee_id" class="form-control" placeholder="Employee ID" value="<?php  echo set_value('employee_id'); ?>" autofocus>
            </div>
            <div class="col-sm-1">
            <button type="submit" class="btn btn-success pull-left"> Search 搜索 </button>
          </div>
          </div>
        </div>
      </form>
      <?php if(isset($resultdetail)){ ?>
      <!-- /////////////////////////////////// -->
      <div class="table-responsive table-bordered">
        <h4>Asset Information</h4>
          <table class="table table-bordered table-striped colortd" style="width:99%;border:#000" >
            <thead>
              <tr>
                <th style="text-align:center;width:5%;">SN</th>
                <th style="width:10%;text-align:center">Ventura Code</th>
                <th style="text-align:center;width:7%">Serial No</th>
                <th style="width:15%;text-align:center">Asset Name</th>
                <th style="width:10%;text-align:center">Category</th>
                <th style="width:10%;text-align:center">Model NO</th>
                <th style="text-align:center;width:7%">Location</th>
                <th style="text-align:center;width:10%">Department</th>
                <th style="text-align:center;width:10%">Employee</th>
                <th style="text-align:center;width:7%">Issue Date</th>
                <th style="text-align:center;width:7%">Return Date</th>
                <th style="text-align:center;width:10%">Status 状态</th>
              </tr>
              </thead>
              <tbody>
              <?php
              if(isset($resultdetail)&&!empty($resultdetail)): 
                $i=1;
                foreach($resultdetail as $row):
                    ?>
                  <tr>
                    <td style="text-align:center;background-color:<?php if($row->issue_status==2) 
                          echo "#FFDF00"; else echo "#FFFFFF"; ?>">
                      <?php echo $i++; ?></td>
                    <td style="text-align:center;background-color:<?php if($row->issue_status==2)echo "#FFDF00"; else echo "#FFFFFF"; ?>">
                      <?php echo $row->ventura_code; ; ?></td>
                      <td style="vertical-align: text-top;text-align: center;background-color:<?php if($row->issue_status==2)echo "#FFDF00"; else echo "#FFFFFF"; ?>">
                    <?php  echo $row->asset_encoding; ?></td>
                    <td style="background-color:<?php if($row->issue_status==2)echo "#FFDF00"; else echo "#FFFFFF"; ?>"><?php echo $row->product_name;?></td>
                    <td style="text-align:center;background-color:<?php if($row->issue_status==2)echo "#FFDF00"; else echo "#FFFFFF"; ?>">
                      <?php echo $row->category_name; ; ?></td>
                    <td style="text-align:center;background-color:<?php if($row->issue_status==2)echo "#FFDF00"; else echo "#FFFFFF"; ?>">
                      <?php echo $row->product_code;  ?></td> 
                    <td style="vertical-align: text-top;text-align: center;background-color:<?php if($row->issue_status==2)echo "#FFDF00"; else echo "#FFFFFF"; ?>">
                    <?php  echo $row->location_name; ?></td>
                    <td style="text-align:center;background-color:<?php if($row->issue_status==2)echo "#FFDF00"; else echo "#FFFFFF"; ?>">
                    <?php echo $row->department_name;  ?></td>
                    <td style="vertical-align: text-top;text-align: center;background-color:<?php if($row->issue_status==2)echo "#FFDF00"; else echo "#FFFFFF"; ?>">
                    <?php  echo "$row->employee_name($row->employee_id)"; ?></td>
                    <td style="text-align:center;background-color:<?php if($row->issue_status==2)echo "#FFDF00"; else echo "#FFFFFF"; ?>">
                    <?php echo findDate($row->issue_date);  ?></td>
                    <td style="text-align:center;background-color:<?php if($row->issue_status==2)echo "#FFDF00"; else echo "#FFFFFF"; ?>">
                    <?php echo findDate($row->return_date);  ?></td>
                    <td style="vertical-align: text-top;text-align: center;background-color:<?php if($row->issue_status==2)echo "#FFDF00"; else echo "#FFFFFF"; ?>">
                    <?php  if($row->issue_status==1)echo "Used"; else echo "Return"; ?></td>
                </tr>
                  <?php
                  endforeach;
              endif;
              ?>
              </tbody>
              </table>
              </div>
              <?php } ?>
        <?php if(isset($spareslist)){ ?>
      <!-- /////////////////////////////////// -->
      <div class="table-responsive table-bordered">
        <h4>Tools/Material/Items Taking</h4>
          <table class="table table-bordered table-striped colortd" style="width:99%;border:#000" >
            <thead>
              <tr>
                <th style="text-align:center;width:5%;">SN</th>
                <th style="text-align:center;width:7%">Product Code</th>
                <th style="width:15%;">Item Name</th>
                <th style="width:10%">Category</th>
                <th style="text-align:center;width:7%">Location</th>
                <th style="text-align:center;width:10%">Department</th>
                <th style="text-align:center;width:10%">Employee</th>
                <th style="text-align:center;width:8%">Issue Date</th>
                <th style="text-align:center;width:10%">Quantity</th>
              </tr>
              </thead>
              <tbody>
              <?php
              if(isset($spareslist)&&!empty($spareslist)): 
                $i=1;
                foreach($spareslist as $row):
                    ?>
                  <tr>
                    <td style="text-align:center;">
                      <?php echo $i++; ?></td>
                    <td style="text-align:center;">
                      <?php echo $row->product_code;?></td>
                      <td style="text-align:center;">
                      <?php echo $row->product_name;?></td>
                      <td style="text-align:center;">
                      <?php echo $row->category_name; ?></td>
                      <td style="text-align:center;">
                      <?php echo $row->location_name; ?></td>
                      <td style="text-align:center;">
                      <?php echo $row->department_name; ?></td>
                      <td style="text-align:center;">
                      <?php echo "$row->employee_name ($row->employee_id)"; ; ?></td>
                      <td style="text-align:center;:">
                      <?php echo findDate($row->issue_date); ?></td>
                      <td style="text-align:center;">
                      <?php echo $row->quantity; ?></td>
                   </tr>
                  <?php
                  endforeach;
              endif;
              ?>
              </tbody>
              </table>
              </div>
              <?php } ?>
        <?php if(isset($relist)){ ?>
      <!-- /////////////////////////////////// -->
      <div class="table-responsive table-bordered">
        <h4>Tools/Material/Items Return</h4>
          <table class="table table-bordered table-striped colortd" style="width:99%;border:#000" >
            <thead>
              <tr>
                <th style="text-align:center;width:5%;">SN</th>
                <th style="text-align:center;width:7%">Product Code</th>
                <th style="width:15%;">Item Name</th>
                <th style="width:10%">Category</th>
                <th style="text-align:center;width:10%">Department</th>
                <th style="text-align:center;width:10%">Employee</th>
                <th style="text-align:center;width:8%">Return Date</th>
                <th style="text-align:center;width:10%">Quantity</th>
              </tr>
              </thead>
              <tbody>
              <?php
              if(isset($relist)&&!empty($relist)): 
                $i=1;
                foreach($relist as $row):
                    ?>
                  <tr>
                    <td style="text-align:center;">
                      <?php echo $i++; ?></td>
                    <td style="text-align:center;">
                      <?php echo $row->product_code; ?></td>
                      <td style="text-align:center;">
                      <?php echo $row->product_name;?></td>
                      <td style="text-align:center;">
                      <?php echo $row->category_name; ?></td>
                      <td style="text-align:center;">
                      <?php echo $row->department_name; ?></td>
                      <td style="text-align:center;">
                      <?php echo "$row->employee_name ($row->employee_id)"; ; ?></td>
                      <td style="text-align:center;">
                      <?php echo findDate($row->return_date); ?></td>
                      <td style="text-align:center;">
                      <?php echo $row->return_qty;?></td>
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
