<div class="row">
        <div class="col-xs-12">
   <div class="box box-primary">
        <div class="box-header">
              <div class="widget-block">
             
<div class="widget-head">
<h5><?php echo ucwords($heading); ?></h5>
<div class="widget-control pull-right">
<a class="btn btn-sm btn-primary pull-right" style="margin-right:0px;" href="<?php echo base_url(); ?>me/dieselissue/add">
<i class="fa fa-plus"></i>
Add New
</a>
</div>
</div>
</div>
</div>
  <!-- /.box-header -->
  <div class="box-body">
  <div class="table-responsive table-bordered">
    <table id="example1" class="table table-bordered table-striped" style="width:100%;border:#000" >
      <thead>
    <tr>
      <th style="width:4%;">SN</th>
      <th style="width:8%;">Date</th>
      <th style="width:8%;">Department</th>
      <th style="width:15%">Vehicles Name</th>
      <th style="width:10%;text-align:center">Fuel Reading at Start Point</th>
      <th style="width:10%;text-align:center">Fuel Reading at Stop Point</th>
      <th style="text-align:center;width:10%">Run(KM)(Liter)</th>
      <th style="text-align:center;width:10%">Start Run Hr</th>
      <th style="text-align:center;width:10%">Stop Run Hr</th>
      <th style="text-align:center;width:10%">Run Hr</th>
      <th style="text-align:center;width:8%">Diesel Qty</th>
      <th style="text-align:center;width:8%">Taken By</th>
      <th style="text-align:center;width:7%">Req No</th>
      <th style="text-align:center;width:6%">Non Official KM</th> 
      <th  style="text-align:center;width:5%">Actions 行动</th>
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
      <td class="text-center">
        <?php echo findDate($row->issue_date); ?></td>
      <td><?php echo $row->fuel_using_dept_name;?></td>
      <td style="text-align:center">
        <?php echo $row->motor_name; ; ?></td>
      <td style="text-align:center">
        <?php echo $row->fuel_r_start_point_km_liter;  ?></td>  
      <td style="text-align:center">
        <?php echo $row->fuel_r_end_point_km_liter;  ?></td>
      <td style="vertical-align: text-top">
      <?php  echo $row->run_km_liter; ?></td> 
      <td style="vertical-align: text-top">
      <?php echo $row->start_hour;  ?></td>
      <td style="vertical-align: text-top">
      <?php  echo $row->stop_hour; ?></td> 
      <td style="vertical-align: text-top">
      <?php  echo $row->run_hour; ?></td>
      <td style="vertical-align: text-top">
      <?php  echo $row->issue_qty; ?></td>
      <td style="vertical-align: text-top">
      <?php  echo $row->driver_name; ?></td>
      <td style="vertical-align: text-top">
      <?php  echo $row->req_no; ?></td>
      <td style="vertical-align: text-top">
      <?php  echo $row->on_officicer_km; ?></td>
      <td style="text-align:center">
          <!-- Single button -->
      <div class="btn-group">
        <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
          <i class="fa fa-gear tiny-icon"></i><span class="caret"></span>
        </button>
          <ul class="dropdown-menu pull-right" role="menu">
            <li>  <a href="<?php echo base_url()?>me/dieselissue/edit/<?php echo $row->fuel_issue_id;?>"><i class="fa fa-edit tiny-icon"></i>Edit 编辑</a></li>
              <?php if($this->session->userdata('delete')=='YES'){ ?>
            <li><a href="#" class="delete" data-pid="<?php echo $row->fuel_issue_id;?>"><i class="fa fa-trash-o tiny-icon"></i>Delete 删除</a></li>
          <?php } ?>
        </ul>
      </div>
      </td>
    </tr>
    <?php
    endforeach;
    endif;
    ?>
    </tbody>
    </table>
    </div>
  </div>
  <!-- /.box-body -->
  </div>
</div>
</div>
<script>
$(document).ready (function(){
  ///////////////////  CHECK BEFOR DELETING ATTACHEMNT//////////////////////
$(".delete").click(function(e){
  job=confirm("Are you sure you want to delete this Information?");
   if(job==true){
  e.preventDefault();
  var rowId=$(this).data('pid');
  location.href="<?php echo base_url();?>me/dieselissue/delete/"+rowId;
  
}
});
});//jquery ends here
</script>
