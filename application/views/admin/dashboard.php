<!-- Morris.js charts -->
<script src="<?php echo base_url('highchart/code/highcharts.js'); ?>"></script>
<script src="<?php echo base_url('highchart/code/modules/exporting.js'); ?>"></script>
<!-- AdminLTE App -->
    <div class="row">
      <?php if($this->session->userdata('department_id')==12){ ?>
        <div class="col-md-4 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-product-hunt"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Total Machines</span>
              <span class="info-box-number"><?php echo $totalmachine; ?><small></small></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-4 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-red"><i class="fa fa-product-hunt"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Total Spares</span>
              <span class="info-box-number"><?php echo $totalspares; ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- fix for small devices only -->
        <div class="col-md-4 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-product-hunt"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Total Active Machines</span>
              <span class="info-box-number"><?php echo $totalmachineactive; ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <div class="col-md-4 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-product-hunt"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Total Deactive <br> Machines</span>
              <span class="info-box-number"><?php echo $totalmachinedeactive; ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <?php } ?>
        <div class="col-md-4 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-product-hunt"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Total Fixed Assets</span>
              <span class="info-box-number"><?php echo $totalasset; ?><small></small></span>
            </div>
          </div>
        </div>
        <div class="col-md-4 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-product-hunt"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Total Items</span>
              <span class="info-box-number"><?php echo $totalitems; ?></span>
            </div>
          </div>
        </div>
        <div class="col-md-4 col-sm-6 col-xs-12">
          <div class="info-box">
            
          </div>
        </div>
 
      </div>
      <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-bell"></i></span>
            <div class="info-box-content">
               
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
      </div>

      <!-- /.row -->
      <?php 
      $colors[1]='#00a65a';
      $colors[2]='';
      $colors[3]='';
      $colors[4]='';
      $colors[5]='';
      $colors[6]='';
    ?>

<script type="text/javascript">
  $(document).ready(function() {
  clockUpdate();
  setInterval(clockUpdate, 1000);
})

function clockUpdate() {
  var date = new Date();
  $('.digital-clock').css({'color': '#fff', 'text-shadow': '0 0 6px #ff0'});
  function addZero(x) {
    if (x < 10) {
      return x = '0' + x;
    } else {
      return x;
    }
  }

  function twelveHour(x) {
    if (x > 12) {
      return x = x - 12;
    } else if (x == 0) {
      return x = 12;
    } else {
      return x;
    }
  }

  var h = addZero(twelveHour(date.getHours()));
  var m = addZero(date.getMinutes());
  var s = addZero(date.getSeconds());

  $('.digital-clock').text(h + ':' + m + ':' + s)
}
</script>
<style>
  @font-face {
  font-family: 'DIGITAL';
  src: url('https://cssdeck.com/uploads/resources/fonts/digii/DS-DIGII.TTF');
}


.digital-clock {
  margin: auto;
  width: 200px;
  height: 60px;
  color: #ffffff;
  border: 2px solid #999;
  border-radius: 4px;
  text-align: right;
  font: 50px/60px 'DIGITAL', Helvetica;
  background: linear-gradient(90deg, #000, #555);
}
  .timeline > div > .timeline-item {
  margin-left: 50px;
  margin-right: -11px;
}
</style>
 



   