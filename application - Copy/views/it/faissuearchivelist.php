<style type="text/css">
  .error-msg{display: none;}
</style>
  <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>asset/datepickerbootstrap/css/datepicker.css">
<script type="text/javascript" src="<?php echo base_url();?>asset/datepickerbootstrap/js/bootstrap-datepicker.js"></script>
<script type="text/javascript">
var url1="<?php echo base_url(); ?>it/faissuearchive/lists";
$(document).ready(function() {
  $('.date').datepicker({
      "format":"dd/mm/yyyy",
      "todayHighlight": true,
      "autoclose":true
    });
    ////////////////////////////////
});

</script>
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
      <!-- /.box-header -->
      <div class="box-body">
        <form class="form-horizontal" action="<?php echo base_url();?>it/faissuearchive/lists" method="POST" enctype="multipart/form-data">
        <div class="form-group">
          <label class="col-sm-1 control-label">Location </label>
          <div class="col-sm-3">
            <select class="form-control select2"  name="location_id" id="location_id">
              <option value="">All Location</option>
              <?php
               foreach ($llist as $value) {  ?>
                <option value="<?php echo $value->location_id; ?>"
                  <?php  if(isset($info)) echo $value->location_id==$info->location_id? 'selected="selected"':0; else echo set_select('location_id',$value->location_id);?>>  <?php echo $value->location_name; ?></option>
                <?php } ?>
            </select>
          </div>
          <div class="col-sm-6">
            <input type="text" name="asset_encoding" class="form-control" placeholder="Search 搜索 like SN/ventura code/Name/Model" autofocus>
          </div>
          <div class="col-sm-2">
          <button type="submit" class="btn btn-success pull-left"> Search 搜索 </button>
          <a class="btn btn-sm btn-primary pull-right" style="margin-right:0px;" href="<?php echo base_url(); ?>it/faissuearchive/lists">All</a>
        </div>
        </div>

        <!-- /.box-body -->
      </form>
      <div class="table-responsive table-bordered">
        <table id="" class="table table-bordered table-striped" style="width:100%;border:#00" >
          <thead>
          <tr>
            <th style="width:4%;">SN</th>
            <th style="text-align:center;width:6%">Category</th>
            <th style="width:15%;">Asset Name</th>
            <th style="width:8%">Ventura CODE</th>
            <th style="text-align:center;width:8%">Serial No</th>
            <th style="width:10%;text-align:center">Department</th>
            <th style="width:10%;text-align:center">Employee</th>
            <th style="width:6%;text-align:center">Location</th>
            <th style="text-align:center;width:6%;">Issue Date</th>
            <th style="text-align:center;width:6%;">Return Date</th>
            <th  style="text-align:center;width:15%;">Note/th>
        </tr>
        </thead>
        <tbody>
        <?php
        if($list&&!empty($list)): $i=1;
          foreach($list as $row):
              ?>
            <tr>
              <td style="text-align:center">
                <?php echo $i++; ; ?></td>
              <td style="text-align:center">
                <?php echo $row->category_name; ?></td>
              <td><?php echo $row->product_name;?></td>
              <td style="text-align:center">
                <?php echo $row->ventura_code; ; ?></td>
              <td style="text-align:center">
                <?php echo $row->asset_encoding; ; ?></td>
              <td style="text-align:center">
                <?php echo "$row->department_name"; ?></td> 
                <td style="text-align:center">
                <?php echo "$row->employee_name"; ?></td> 
              <td style="text-align:center">
                <?php echo $row->location_name; ?></td> 
              <td style="text-align:center">
              <?php echo findDate($row->issue_date);  ?></td>
              <td style="text-align:center">
              <?php echo findDate($row->return_date);  ?></td>
              <td style="text-align:center">
                <?php echo $row->return_note; ?>
              </td>
            </tr>
            <?php
            endforeach;
        endif;
        ?>
        </tbody>
        </table>
         <div class="box-tools">
            <?php if(isset($pagination))echo $pagination; ?>
        </div>
        </div>
      </div>
      <!-- /.box-body -->
    </div>
  </div>
 </div>

 