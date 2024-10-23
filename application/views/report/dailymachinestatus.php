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

</div>
</div>
</div>

</div>
<div class="box box-info">
      <!-- form start -->
      <form class="form-horizontal" action="<?php echo base_url();?>me/dailymachinestatus/Search 搜索Form" method="POST" enctype="multipart/form-data">
        <div class="box-body">
          <div class="form-group">
            <label class="col-sm-2 control-label">Date<span style="color:red;">  *</span></label>
            <div class="col-sm-3">
                <input type="text" name="from_date"   class="form-control date"  placeholder="From Date" value="<?php echo findDate($from_date);
                ?>">
                <span class="error-msg"><?php echo form_error("from_date"); ?></span>
            </div>
            <div class="col-sm-2">
          <button type="submit" class="btn btn-info pull-left">Result</button>
          </div>
          </div>
         </div>
        <!-- /.box-body -->
       
    
      </form>
      <!-- //////////////Result Bellow section/////////////// -->
<?php if(isset($flist)){ ?>

<div class="panel panel-info">
    <div class="panel-body" style="padding:5px;font-size: 22px;background-color: #00A65A;color: #FFF">
     Daily Machine Status 状态 Report
      <a href="<?php echo base_url();?>me/dailymachinestatus/downloadexcel/<?php echo $from_date; ?>" class="btn btn-primary pull-right" ><span class="fa fa-download"></span> Download</a>
    </div>
  </div>
  <?php if($from_date!=''){  ?>
   <h3 align="center" style="margin:0;padding: 5px">
   <b>
Date: <?php echo date("jS M-Y", strtotime("$from_date")); ?>
</b></h3>
<?php } ?>
          <div class="table-responsive table-bordered">
              <table class="table table-bordered table-striped" style="width:100%;border:#000" >
                <thead>
              <tr>
                 <th style="text-align:center;width:5%">SL NO</th>
                  <th style="text-align:center;width:20%;">LOCATION <br>位置</th>
                  <th style="text-align:center;width:15%">WORKING MACHINES <br> 机器在使用中</th>
                  <th style="text-align:center;width:15%">IDLE MACHINES<br>闲 机</th>
                  <th style="text-align:center;width:15%">UNDER SERVICE<br>正在服务</th>
                  <th style="text-align:center;width:15%">MISSING DATA <br> 缺失数据</th>
                  <th style="text-align:center;width:15%">GRAND TOTAL <br>累计</th>
              </tr>
              </thead>
              <tbody>
              <?php
               $i=1; $totalworking=0;
               $totalidle=0;
               $totalservice=0;
               $totalmissing=0;
                foreach($flist as $row){
                  $grandtotal=0;
                  ?>
                  <tr>
                  <td style="text-align:center">
                      <?php echo $i++; ; ?></td>
                    <td style="text-align:center">
                  <?php echo $row->floor_no; ?></td>
                  <td style="text-align:center">
                  <?php $total=$this->dailymachinestatus_model->reportrResult($row->floor_id,$from_date,1);
                  $totalworking=$totalworking+$total;
                  $grandtotal=$grandtotal+$total;
                  echo $total; ?></td>
                  <td style="text-align:center">
                  <?php $total=$this->dailymachinestatus_model->reportrResult($row->floor_id,$from_date,2);
                  $totalidle=$totalidle+$total;
                  $grandtotal=$grandtotal+$total;
                  echo $total; ?></td>
                  <td style="text-align:center">
                  <?php $total=$this->dailymachinestatus_model->reportrResult($row->floor_id,$from_date,3);
                  $totalservice=$totalservice+$total;
                  $grandtotal=$grandtotal+$total;
                  echo $total; ?></td>
                  <td style="text-align:center">
                  <?php                 
                  echo 0; ?></td>
                  <td style="text-align:center">
                  <?php echo $grandtotal; ?></td>

                  </tr>
                  <?php }
                 ?>
                 <tr>
                 <th style="text-align:center;width:5%"><?php echo $i++; ; ?></th>
                  <th style="text-align:center;width:20%;">MISSING DATA</th>
                  <th style="text-align:center;width:15%">0</th>
                  <th style="text-align:center;width:15%">0</th>
                  <th style="text-align:center;width:15%">0</th>
                  <td style="text-align:center">
                  <?php 
                  $totalmissing=$this->dailymachinestatus_model->NotfoundMachine(3);
                  echo $totalmissing; ?></td>
                  <td style="text-align:center">
                  <?php echo $totalmissing; ?></td>
              </tr>
              <tr>
                 <th style="text-align:center;width:5%"></th>
                  <th style="text-align:center;width:20%;">TOTAL</th>
                  <th style="text-align:center;width:15%"><?php echo $totalworking; ?></th>
                  <th style="text-align:center;width:15%"><?php echo $totalidle; ?></th>
                  <th style="text-align:center;width:15%"><?php echo $totalservice; ?></th>
                  <th style="text-align:center;width:15%"><?php echo $totalmissing; ?></th>
                  <th style="text-align:center;width:15%">
                    <?php echo $totalidle+$totalworking+$totalservice+$totalmissing; ?></th>
              </tr>
             
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
