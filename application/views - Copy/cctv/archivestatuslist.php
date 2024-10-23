<style type="text/css">
  .error-msg{display: none;}
</style>
  <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>asset/datepickerbootstrap/css/datepicker.css">
<script type="text/javascript" src="<?php echo base_url();?>asset/datepickerbootstrap/js/bootstrap-datepicker.js"></script>


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
        <form class="form-horizontal" action="<?php echo base_url();?>cctv/camerastatuslists" method="GET" enctype="multipart/form-data">
   
        <div class="form-group">
            <div class="col-sm-4">
            <input type="text" name="asset_encoding" class="form-control" placeholder="Search 搜索 like SN/ventura code/Name/Model" autofocus>
          </div>
          <div class="col-sm-2">
          <button type="submit" class="btn btn-success pull-left"> Search 搜索 </button>
          <a class="btn btn-sm btn-primary pull-right" style="margin-right:0px;" href="<?php echo base_url(); ?>cctv/camerastatuslists">All</a>
        </div>
        </div>

        <!-- /.box-body -->
      </form>
      <div class="table-responsive table-bordered">
        <table id="" class="table table-bordered table-striped" style="width:100%;border:#00" >
          <thead>
          <tr>
            <th style="width:4%;">SN</th>
            <th style="width:8%">Ventura CODE</th>
            <th style="text-align:center;width:8%">Asset Code</th>
            <th style="width:8%;text-align:center">Location</th>
            <th style="width:10%;text-align:center">Start Time</th>
            <th style="width:10%;text-align:center">End time</th>
            <th style="text-align:center;width:6%;">Downtime</th>
            <th style="text-align:center;width:10%;">Problem</th>
            <th style="text-align:center;width:15%;">Solution</th>
            <th style="text-align:center;width:6%;">Status 状态</th>
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
                <?php echo $row->ventura_code; ; ?></td>
              <td style="text-align:center">
                <?php echo $row->asset_encoding; ; ?></td>
              <td style="text-align:center">
                <?php echo "$row->location_name($row->coveragearea)";
                //$this->camerastatus_model->getlocation($row->product_detail_id); ?></td> 
              <td style="text-align:center">
                <?php echo "$row->start_date $row->start_time"; ?></td> 
              <td style="text-align:center">
                <?php echo "$row->end_date $row->end_time"; ?></td>
              <td style="text-align:center">
              <?php if($row->end_date!=''&&$row->end_time!=''){
                $datetime1 = new DateTime("$row->start_date $row->start_time");
                $datetime2 = new DateTime("$row->end_date $row->end_time");
                $interval = $datetime1->diff($datetime2);
                $elapsed = $interval->format('%a days %h hours %i minutes');
                echo $elapsed;
              }  ?></td>
              <td style="text-align:center">
                <?php echo $row->remarks; ?></td> 
                <td style="text-align:center">
                <?php echo $row->repair_note; ?></td> 
              <td style="text-align:center">
              <span class="btn btn-xs btn-success">
              <?php 
                if($row->cctv_status==1) echo "Offline";
                else if($row->cctv_status==2) echo "Online";
                else if($row->cctv_status==3) echo "Damage";
              ?>
              </span>
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

  