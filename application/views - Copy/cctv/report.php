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
if(isset($locationwiseCCTV)){
  $percentarray=array();
  $percentarray[1]=$totalcctv-count($offlinelist);
  $percentarray[2]=count($offlinelist);
  $colorarray=array();
  $colorarray['1']='#008000';
  $colorarray['2']='#FF0000';
  $modelarray=array();
  $modelarray['1']='Online';
  $modelarray['2']='Offline';
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
  <?php if(isset($locationwiseCCTV)){ ?>
    var bar = new Morris.Bar({
      element: 'bar-chart',
      resize: true,
      data: [
       <?php foreach ($locationwiseCCTV as $value) {
       if($value->countcctv>0){ ?>
        {y: '<?php echo $value->location_name; ?>', a: <?php echo $value->countcctv; ?>},
        <?php }} ?>
      ],
      barColors: function (row, series, type) {
            colorchk=colorchk+1;
            return '#00A65A';
        },      
      labels: ['Total'],
      xkey: 'y',
      ykeys: ['a'],
      hideHover: 'auto',
      xLabelAngle: 90,
      gridTextSize: 12
    });
    ///////////////////
    

    /*
     * DONUT CHART
     * -----------
     */

    var donutData = [
    <?php for($m=1;$m<=2;$m++) { ?>
      { label: '<?php echo $modelarray[$m]; ?>', data: <?php echo $percentarray[$m]; ?>, color: '<?php echo $colorarray[$m]; ?>' },
      <?php } ?>
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
    
<!-- //////////////Result Bellow section/////////////// -->
<?php if(isset($locationwiseCCTV)){ ?>
<h3  style="overflow: hidden;text-align: center;width: 60%">
     Offline CCTV Lists
    </h3>
  
<div class="row">
<div class="col-md-7">
          <div class="table-responsive table-bordered">
              <table class="table table-bordered table-striped" style="width:100%;border:#000" >
                <thead>
              <tr>
                  <th style="text-align:center;width:5%">SL NO</th>
                  <th style="width:10%;">CCTV NO</th>
                  <th style="width:15%;">Location Name</th>
                  <th style="width:25%;">Coverage Area</th>
                  <th style="width:35%;">Offline Date</th>
              </tr>
              </thead>
              <tbody>
              <?php
              if($offlinelist&&!empty($offlinelist)): $i=1; 
                foreach($offlinelist as $row):
                    ?>
                  <tr>
                  <td style="text-align:center">
                      <?php echo $i++; ; ?></td>
                    <td><?php echo $row->asset_encoding;?></td>
                    <td style="text-align:center">
                      <?php echo $row->location_name;  ?> </td>
                    <td style="text-align:center">
                      <?php echo $row->issue_purpose;  ?> </td>
                    <td style="text-align:center">
                      <?php echo "$row->start_date $row->start_time";  ?> </td>
                  </tr>
                  <?php
                  endforeach;
              endif;
              ?>
          </tbody>
          </table>
          </div>
        </div>
        <div class="col-md-5 panel panel-success">
        <div class="box box-primary">
            <div class="box-header with-border">
              <i class="fa fa-bar-chart-o"></i>

              <h3 class="box-title" style="text-align: center;">Online Vs Offline</h3>

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
        </div>
<div class="row">
<h3 style="text-align: center;">
      Location Wise CCTV
   </h3>
    <br>
          <!-- <div class="table-responsive table-bordered">
              <table class="table table-bordered table-striped" style="width:100%;border:#000" >
                <thead>
              <tr>
                 <th style="text-align:center;width:5%">SL NO</th>
                  <th style="text-align:center;width:10%">Location</th>
                  <th style="text-align:center;width:10%">Total Qty</th>
              </tr>
              </thead>
              <tbody>
              <?php
              if($locationwiseCCTV&&!empty($locationwiseCCTV)): $i=1; $totald=0;
                foreach($locationwiseCCTV as $row):
                  $totald=$totald+$row->countcctv;
                    ?>
                  <tr>
                  <td style="text-align:center">
                      <?php echo $i++; ; ?></td>
                    <td style="text-align:center">
                      <?php echo $row->location_name; ; ?> </td>
                    <td style="text-align:center">
                      <?php echo $row->countcctv; ; ?> </td>
                  </tr>
                  <?php 
                  endforeach;
              endif;
              ?>
              <tr>
                  <th style="text-align:right;" colspan="2">Grand Total:</th>
                    <th style="text-align:center">
                      <?php echo $totald; ; ?> Pcs</th>
                  </tr>
          </tbody>
          </table>
          </div> -->
       <div class="col-md-12 panel panel-success">
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
              <div class="chart" id="bar-chart" style="height: 300px;"></div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
      </div>
<br>
<!-- //////////////////////////////////////////// -->


          <!-- //////////////////////////////////////// -->
           
          <?php } ?>

    </div>
      <!-- /.box-header -->

      <!-- /.box-body -->
    </div>
  </div>
 </div>
