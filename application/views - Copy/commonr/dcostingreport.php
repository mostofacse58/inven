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
<style type="text/css">
</style>
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
<a class="btn btn-sm btn-primary pull-right" style="margin-right:0px;" href="<?php echo base_url(); ?>commonr/dcostingreport/downloadExcel<?php 
 echo "/$department_id";  
 echo "/$from_date/$to_date";  ?>">
<i class="fa fa-file-excel-o"></i>
Download Excel
</a>
<?php } ?>
</div>
</div>
</div>

</div>
<div class="box box-info">
      <!-- form start -->
      <form class="form-horizontal" action="<?php echo base_url();?>commonr/dcostingreport/reportrResult" method="POST" enctype="multipart/form-data">
        <div class="box-body">
          <div class="form-group">
            <label class="col-sm-1 control-label">From Date</label>
              <div class="col-sm-2">
                  <input type="text" name="from_date" readonly class="form-control date" placeholder="From Date" value="<?php if (isset($info))
                          echo $info->from_date;
                      else
                          echo set_value('from_date');
                      ?>">
                  <span class="error-msg"><?php echo form_error("from_date"); ?></span>
              </div>
              <label class="col-sm-1 control-label">To Date</label>
              <div class="col-sm-2">
                  <input type="text" name="to_date" readonly class="form-control date" placeholder="To Date" value="<?php if (isset($info))
                          echo $info->to_date;
                      else
                          echo set_value('to_date');
                      ?>">
                  <span class="error-msg"><?php echo form_error("to_date"); ?></span>
              </div>
          
            <div class="col-sm-1">
          <button type="submit" class="btn btn-info pull-left">Result</button>
          </div>
          </div>
        </div>
        <!-- /.box-body -->
      </form>
      <?php if(isset($collapse)){ ?>
      <br>
        <?php if($from_date!=''){  ?>
           <h3 align="center" style="margin:0;padding: 5px">
           <b>
           From : <?php echo date("jS M-Y", strtotime("$from_date")); ?>
          &nbsp;&nbsp;&nbsp;&nbsp; 
          To : <?php echo date("jS M-Y", strtotime("$to_date"));  ?> 
        </b></h3>
        <?php } ?>
        <h3 align="center" style="margin:0;padding: 5px">All Amount in HKD</h4>
      <!-- /////////////////////////////////// -->
      <div class="table-responsive table-bordered">
        <table class="table table-bordered table-striped colortd" style="width:99%;border:#000">
        <thead>
        <tr>
            <th>Holder Department</th>
            <?php foreach ($hdlist as  $value) {
              ?>
              <th colspan="3" style="text-align: center;">
                <?php echo $value->department_name; ?></th>
            <?php } ?>
        </tr>
         <tr>
          <th>Received Department </th>
            <?php foreach ($hdlist as  $value) {
              ?>
              <th>S.Items Cost</th>
              <th>Fixed Asset Cost</th>
              <th>Servicing Cost</th>
            <?php } ?>
        </tr>
        </thead>
        <tbody>
        <?php $grandtotal=0;
         $grandpi=0;
         $grandamount=0;
        if(isset($dlist)&&!empty($dlist)){ 
            $i=1;
            foreach($dlist as $row){
            $tdid=$row->department_id;
             ?>
          <tr>
            <td  style="text-align: center;">
                <?php echo $row->department_name; ?></td>

          <?php
            foreach ($hdlist as $value) {
             $did=$value->department_id;
             $sscost="scost$tdid$did";
             $ddd=$$sscost;
              ?>
              <td style="text-align:center;">
                <?php echo $ddd['sparescost'];?></td>
              <td style="text-align:center;">
                <?php echo $ddd['facost'];?></td>
              <td style="text-align:center;">
                <?php echo number_format($ddd['sercost'],2);?></td>
            <?php
                    }
           ?>
        <tr>
        <?php 
            }
          }
        ?>
        <tr>
            <td>Full Factory</td>
            <?php foreach ($hdlist as  $value) {
               $did=$value->department_id;
              $cfullfactorycost="fullfactorycost$did";
              ?>
              <td style="text-align: center;">
                <?php echo $$cfullfactorycost; ?></td>
              <td style="text-align:center;">0.00</td>
              <td style="text-align:center;">0.00</td>
            <?php } ?>
        </tr>


        </tbody>
        </table>
        </div>
      <?php } ?>
    </div>
    <!-- /.box-body -->
    </div>
  </div>
 </div>
