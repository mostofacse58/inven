<script src="<?php echo base_url('asset/js/plugins/datepicker/bootstrap-datepicker.js'); ?>"></script>
<script src="<?php echo base_url('asset/js/plugins/datepicker/bootstrap-datepicker.js'); ?>"></script>
<!-- Morris.js charts -->
<script src="<?php echo base_url('asset/raphael/raphael.min.js'); ?>"></script>
<script src="<?php echo base_url('asset/morris/morris.min.js'); ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('asset/morris/morris.css'); ?>">
<!-- FLOT CHARTS -->
<script src="<?php echo base_url(); ?>asset/js/plugins/flot/jquery.flot.js"></script>
<!-- FLOT RESIZE PLUGIN - allows the chart to redraw when the window is resized -->
<script src="<?php echo base_url(); ?>asset/js/plugins/flot/jquery.flot.resize.js"></script>
<!-- FLOT PIE PLUGIN - also used to draw donut charts -->
<script src="<?php echo base_url(); ?>asset/js/plugins/flot/jquery.flot.pie.js"></script>
<!-- FLOT CATEGORIES PLUGIN - Used to draw bar charts -->
<script src="<?php echo base_url(); ?>asset/js/plugins/flot/jquery.flot.categories.js"></script>
<style type="text/css">
  table.table-bordered th:last-child, table.table-bordered td:last-child {
  border-right-width: 1px;
}
</style>
<?php //print_r($treewisereport); exit();
if(isset($modelwisereport)){
   $tretimearray=array();
   $modelarray=array();
  $tretimearray[1]=0;
  $tretimearray[2]=0;
  $tretimearray[3]=0;
  //////////////////
  $modelarray[1]=0;
  $modelarray[2]=0;
  $modelarray[3]=0;

  $totaltimes=0; $m=1;
  foreach ($modelwisereport as  $value) {
    $totaltimes=$totaltimes+$value->downtime;
    $tretimearray[$m]=$value->downtime;
    $modelarray[$m]=$value->product_model;
    $m++;
    
  }
  $percentarray=array();
  $percentarray[1]=round((100/$totaltimes)*$tretimearray[1],2);
  $percentarray[2]=round((100/$totaltimes)*$tretimearray[2],2);
  $percentarray[3]=round((100/$totaltimes)*$tretimearray[3],2);
  $percentarray[4]=100-($percentarray[1]+$percentarray[2]+$percentarray[3]);
  $colorarray=array();
  $colorarray['1']='#C12C2C';
  $colorarray['2']='#368FA5';
  $colorarray['3']='#FBB508';
  $colorarray['4']='#RRGGBB';
}

 ?>
<script>
    $(document).ready(function(){
      var colorchk=1;
      var colorchk1=1;
       $('.date').datepicker({
            "format": "dd/mm/yyyy",
            "todayHighlight": true,
            "autoclose": true
        });
  
       /////////////////////
       //BAR CHART
  <?php if(isset($modelwisereport)){ ?>
    var bar = new Morris.Bar({
      element: 'bar-chart',
      resize: true,
      data: [
       <?php foreach ($modelwisereport as $value) {
       if($value->downtime>0){ ?>
        {y: '<?php echo $value->product_model; ?>', a: <?php echo $value->downtime; ?>},
        <?php }} ?>
      ],
      barColors: function (row, series, type) {
          if (colorchk <4) {
            colorchk=colorchk+1;
            return '#FF0000';
          }
          else {
            colorchk=colorchk+1;
            return '#00A65A';
          }
          
        },      
      labels: ['Down Time'],
      xkey: 'y',
      ykeys: ['a'],
      hideHover: 'auto',
      xLabelAngle: 90,
      gridTextSize: 12
    });
    ///////////////////
    var bar = new Morris.Bar({
      element: 'bar-chart2',
      resize: true,
      data: [
       <?php foreach ($floorwisereport as $value) { ?>
        {y: '<?php echo $value->floor_no; ?>', a: <?php echo $value->downtime; ?>},
        <?php } ?>
      ],
      barColors: function (row, series, type) {
          if (colorchk1 <2) {
            colorchk1=colorchk1+1;
            return '#FF0000';
          }
          else {
            colorchk1=colorchk1+1;
            return '#3891A7';
          }
          
        },      
      labels: ['Down Time'],
      xkey: 'y',
      ykeys: ['a'],
      hideHover: 'auto',
      xLabelAngle: 90,
      gridTextSize: 12
    });

    /*
     * DONUT CHART
     * -----------
     */

    var donutData = [
    <?php for($m=1;$m<=3;$m++) { ?>
      { label: '<?php echo $modelarray[$m]; ?>', data: <?php echo $percentarray[$m]; ?>, color: '<?php echo $colorarray[$m]; ?>' },
      <?php } ?>
      { label: '', data: <?php echo $percentarray[4]; ?>, color: '#RRGGBB' },
    ]
    $.plot('#donut-chart', donutData, {
      series: {
        pie: {
          show       : true,
          radius     : 1,
          innerRadius: 0.5,
          label      : {
            show     : true,
            radius   : 2 / 3,
            formatter: labelFormatter,
            threshold: 0.1
          }

        }
      },
      legend: {
        show: false
      }
    });
    function labelFormatter(label, series) {
    return '<div style="font-size:13px; text-align:center; padding:2px; color: #fff; font-weight: 600;">'
      + label
      + '<br>'
      + series.percent.toFixed(2) + '%</div>'
  }
    /*
     * END DONUT CHART
     */
    ////////////////////////////
     <?php } ?>
    //////////////////



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

</div>
</div>
</div>

</div>
<div class="box box-info">
      <!-- form start -->
      <form class="form-horizontal" action="<?php echo base_url();?>me/downtimechart/reportrResult" method="POST" enctype="multipart/form-data">
        <div class="box-body">
          <div class="form-group">
           <label class="col-sm-2 control-label">From Date<span style="color:red;">  *</span></label>
                <div class="col-sm-3">
                    <input type="text" name="from_date"   class="form-control date" id="inputEmail3" placeholder="From Date" value="<?php echo set_value('from_date');
                        ?>">
                    <span class="error-msg"><?php echo form_error("from_date"); ?></span>
                </div>
                 <label class="col-sm-3 control-label">To Date<span style="color:red;">  *</span></label>

                <div class="col-sm-3">
                    <input type="text" name="to_date"   class="form-control date" id="inputEmail3" placeholder="To Date" value="<?php echo set_value('to_date');
                        ?>">
                    <span class="error-msg"><?php echo form_error("to_date"); ?></span>
                </div>
        </div>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
           <div class="col-sm-6"></div>
           <div class="col-sm-2">
          <button type="submit" class="btn btn-info pull-left">Result</button>
          </div>
        </div>
    
      </form>
<!-- //////////////Result Bellow section/////////////// -->
<?php if(isset($modelwisereport)){ ?>

<div class="panel panel-info">
    <div class="panel-body" style="padding:5px;font-size: 22px;background-color: #00A65A;color: #FFF">
     Model Wise Downtime
      <a href="<?php echo base_url();?>me/downtimechart/downloadexcel/<?php echo $from_date.'/'.$to_date; ?>" class="btn btn-primary pull-right" ><span class="fa fa-download"></span> Download</a>
    </div>
  </div>
  <?php if($from_date!=''){  ?>
   <h3 align="center" style="margin:0;padding: 5px">
   <b>
From Date: <?php echo date("jS M-Y", strtotime("$from_date")); ?>
  &nbsp;&nbsp;&nbsp;&nbsp; To Date: <?php echo date("jS M-Y", strtotime("$to_date"));  ?>
</b></h3>
<?php } ?>
          <div class="table-responsive table-bordered">
              <table class="table table-bordered table-striped" style="width:100%;border:#000" >
                <thead>
              <tr>
                 <th style="text-align:center;width:5%">SL NO</th>
                  <th style="width:25%;">Product Name</th>
                  <th style="text-align:center;width:15%">Product Model</th>
                  <th style="text-align:center;width:10%">Down Time(In Minutes)</th>
              </tr>
              </thead>
              <tbody>
              <?php
              if($modelwisereport&&!empty($modelwisereport)): $i=1; $totaldowntime=0;
                foreach($modelwisereport as $row):
                  if($value->downtime>0){
                  $totaldowntime=$totaldowntime+$row->downtime;
                    ?>
                  <tr>
                  <td style="text-align:center">
                      <?php echo $i++; ; ?></td>
                    <td><?php echo $row->product_name;?></td>
                    <td style="text-align:center">
                      <?php echo $row->product_model;  ?></td>
                    <td style="text-align:center">
                      <?php echo $row->downtime; ; ?> </td>
                  </tr>
                  <?php }
                  endforeach;
              endif;
              ?>
              <tr>
                  <th style="text-align:right;" colspan="3">Grand Total Downtime:</th>
                    <th style="text-align:center">
                      <?php echo $totaldowntime; ; ?> Minutes</th>
                  </tr>
          </tbody>
          </table>
          </div>
<div class="col-md-12 panel panel-success">
                <!-- BAR CHART -->
          <div class="box box-success">
            <div class="box-header with-border"  style="text-align: center;">
              <h3 class="box-title">Model Wise Downtime <br> From Date: <?php echo date("jS M-Y", strtotime("$from_date")); ?>
  &nbsp;&nbsp;&nbsp;&nbsp; To Date: <?php echo date("jS M-Y", strtotime("$to_date"));  ?></h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body chart-responsive">
              <div class="chart" id="bar-chart" style="height: 300px;"></div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
<br>
<!-- //////////////////////////////////////////// -->
<div class="panel panel-info" style="overflow: hidden;">
    <div class="panel-body" style="padding:5px;font-size: 22px;background-color: #00A65A;color: #FFF">
     Floor Wise Downtime
    </div>
  </div>
  <?php if($from_date!=''){  ?>
   <h3 align="center" style="margin:0;padding: 5px"><b>
From Date: <?php echo date("jS M-Y", strtotime("$from_date")); ?>
  &nbsp;&nbsp;&nbsp;&nbsp; To Date: <?php echo date("jS M-Y", strtotime("$to_date"));  ?>
</b></h3>
<?php } ?>
<div class="col-md-6">
          <div class="table-responsive table-bordered">
              <table class="table table-bordered table-striped" style="width:100%;border:#000" >
                <thead>
              <tr>
                 <th style="text-align:center;width:5%">SL NO</th>
                  <th style="width:25%;">Floor Name</th>
                  <th style="text-align:center;width:25%">Down Time(In Minutes)</th>
              </tr>
              </thead>
              <tbody>
              <?php
              if($floorwisereport&&!empty($floorwisereport)): $i=1; $totaldowntime=0;
                foreach($floorwisereport as $row):
                  $totaldowntime=$totaldowntime+$row->downtime;
                    ?>
                  <tr>
                  <td style="text-align:center">
                      <?php echo $i++; ; ?></td>
                    <td><?php echo $row->floor_no;?></td>
                    <td style="text-align:center">
                      <?php echo $row->downtime;  ?> </td>
                  </tr>
                  <?php
                  endforeach;
              endif;
              ?>
              <tr>
                  <th style="text-align:right;" colspan="2">Grand Total Downtime:</th>
                    <th style="text-align:center">
                      <?php echo $totaldowntime; ; ?> Minutes</th>
                  </tr>
          </tbody>
          </table>
          </div>
        </div>
<div class="col-md-6 panel panel-success">
                <!-- BAR CHART -->
          <div class="box box-success">
            <div class="box-header with-border"  style="text-align: center;">
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body chart-responsive">
              <div class="chart" id="bar-chart2" style="height: 300px;"></div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- //////////////////////////////////////////// -->
        <div class="col-md-6 panel panel-success">
        <div class="box box-primary">
            <div class="box-header with-border">
              <i class="fa fa-bar-chart-o"></i>

              <h3 class="box-title">MAJOR THREE DOWNTIME</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body">
              <div id="donut-chart" style="height: 300px;"></div>
            </div>
            <!-- /.box-body-->
          </div>
          </div>
          <!-- //////////////////////////////////////// -->
<?php } ?>

    </div>
      <!-- /.box-header -->

      <!-- /.box-body -->
    </div>
  </div>
 </div>
