<script src="<?php echo base_url('asset/js/plugins/datepicker/bootstrap-datepicker.js'); ?>"></script>
<script src="<?php echo base_url('asset/js/plugins/datepicker/bootstrap-datepicker.js'); ?>"></script>
<script>
    $(document).ready(function(){
       $('.date').datepicker({
            "format": "dd/mm/yyyy",
            "todayHighlight": true,
            "autoclose": true
        });
       <?php if(isset($box_id)){ ?>
      var box_ids = "<?php echo $box_id; ?>";
      <?php  }else{ ?>
        var box_ids = "<?php echo set_value('box_id') ?>";
      <?php }?>
    ///////////////////
   
     
      ////////////////////////
       var rack_id=$('#rack_id').val();
            if(rack_id !=''){
            $.ajax({
              type:"post",
              url:"<?php echo base_url()?>"+'me/sparestockreport/getBox/',
              data:{rack_id:rack_id},
              success:function(data){
                $("#box_id").empty();
                $("#box_id").append(data);
                if(box_ids != ''){
                  $('#box_id').val(box_ids).change();
                }
              }
            });
          }

      ///////////////////////
      $('#rack_id').on('change',function(){
        var rack_id=$('#rack_id').val();
            if(rack_id !=''){
            $.ajax({
              type:"post",
              url:"<?php echo base_url()?>"+'me/sparestockreport/getBox',
              data:{rack_id:rack_id},
              success:function(data){
                $("#box_id").empty();
                $("#box_id").append(data);
                if(box_ids != ''){
                  $('#box_id').val(box_ids).change();
                }
              }
            });
          }
          });
    });
</script>
<style type="text/css">
  .colortd td{background-color:#FFDF00; }
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
<a class="btn btn-sm btn-primary pull-right" style="margin-right:0px;" href="<?php echo base_url(); ?>me/sparestockreport/downloadExcel<?php echo "/$category_id/$rack_id/$box_id/$color_code/$product_code";  ?>">
<i class="fa fa-file-excel-o"></i>
Download Excel
</a>
<a class="btn btn-sm btn-primary pull-right" style="margin-right:0px;" href="<?php echo base_url(); ?>me/sparestockreport/downloadPdf<?php echo "/$category_id/$rack_id/$box_id/$color_code/$product_code";  ?>">
<i class="fa fa-file-pdf-o"></i>
Download PDF
</a>
<?php } ?>
</div>
</div>
</div>

</div>
<div class="box box-info">
      <!-- form start -->
      <form class="form-horizontal" action="<?php echo base_url();?>me/sparestockreport/reportrResult" method="POST" enctype="multipart/form-data">
        <div class="box-body">
          <div class="form-group">
            <label class="col-sm-2 control-label">Category Name 分类名称<span style="color:red;">  *</span></label>
            <div class="col-sm-3">
              <select class="form-control select2" name="category_id" id="category_id">
              <option value="All" <?php echo 'All'==set_value('category_id')? 'selected="selected"':0; ?>>All</option>
              <?php foreach($clist as $rows){  ?>
              <option value="<?php echo $rows->category_id; ?>" 
                <?php echo $rows->category_id==set_value('category_id')? 'selected="selected"':0; ?>>
                 <?php echo $rows->category_name; ?></option>
              <?php }  ?>
            </select>                    
            <span class="error-msg"><?php echo form_error("category_id");?></span>
            </div>
            <label class="col-sm-1 control-label">Rack</label>
            <div class="col-sm-2">
              <select class="form-control select2" name="rack_id" id="rack_id">
              <option value="All" <?php echo 'All'==set_value('rack_id')? 'selected="selected"':0; ?>>All</option>
              <?php $rlist=$this->db->query("SELECT * FROM rack_info")->result();
              foreach($rlist as $rows){  ?>
              <option value="<?php echo $rows->rack_id; ?>" 
                <?php echo $rows->rack_id==set_value('rack_id')? 'selected="selected"':0; ?>>
                 <?php echo $rows->rack_name; ?></option>
              <?php }  ?>
            </select>                    
            <span class="error-msg"><?php echo form_error("category_id");?></span>
            </div>
            <label class="col-sm-2 control-label">
            Box Name<span style="color:red;">  </span></label>
          <div class="col-sm-2">
            <select class="form-control select2" name="box_id" id="box_id">
              <option value="All" selected="selected">All</option>
              </select>
              <span class="error-msg"><?php echo form_error("box_id"); ?></span>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Color Code 色标</label>
            <div class="col-sm-2">
              <select class="form-control" name="color_code" id="color_code">
              <option value="All" <?php echo 'All'==set_value('color_code')? 'selected="selected"':0; ?>>All</option>
              <option value="1" 
                <?php echo 1==set_value('color_code')? 'selected="selected"':0; ?>>
                 White</option>
                <option value="3" 
                <?php echo 3==set_value('color_code')? 'selected="selected"':0; ?>>
                 Yellow</option>
              <option value="2" 
                <?php echo 2==set_value('color_code')? 'selected="selected"':0; ?>>
                 Red</option>
            </select>                    
            <span class="error-msg"><?php echo form_error("category_id");?></span>
            </div>
            <label class="col-sm-2 control-label">
            Search 搜索<span style="color:red;">  *</span></label>
            <div class="col-sm-4">
              <input class="form-control" name="product_code" id="product_code" value="<?php echo set_value('product_code'); ?>" placeholder="write as like Model,Code,Name">
            <span class="error-msg"><?php echo form_error("product_code");?></span>
            </div>
            <div class="col-sm-2">
          <button type="submit" class="btn btn-info pull-left">Result</button>
          </div>
          </div>
        </div>
        <!-- /.box-body -->
      </form>
      <!-- /////////////////////////////////// -->
      <div class="table-responsive table-bordered">
              <table class="table table-bordered table-striped colortd" style="width:99%;border:#000" >
                <thead>
              <tr>
                <th style="text-align:center;width:5%;">SN</th>
                <th style="width:15%;">Tools/Materials Name</th>
                <th style="width:10%">Category Name 分类名称</th>
                <th style="text-align:center;width:10%">Materials Type</th>
                <th style="text-align:center;width:10%">Rack(Box)</th>
                <th style="text-align:center;width:10%">Item Code 项目代码</th>
                <th style="text-align:center;width:8%">Item Origin</th>

                <th style="text-align:center;width:6%">
                <?php $date = date('Y-m');
                  $sixmonth = date('Y-m',strtotime($date." -6 month"));
                   echo date("M-Y", strtotime("$sixmonth"));;
                 ?></th>
                 <th style="text-align:center;width:6%">
                  <?php 
                  $fivemonth = date('Y-m',strtotime($date." -5 month"));
                   echo date("M-Y", strtotime("$fivemonth"));;
                 ?></th>
                  <th style="text-align:center;width:6%">
                  <?php 
                  $fourmonth = date('Y-m',strtotime($date." -4 month"));
                   echo date("M-Y", strtotime("$fourmonth"));;
                 ?></th>
                  <th style="text-align:center;width:6%">
                  <?php 
                  $threemonth = date('Y-m',strtotime($date." -3 month"));
                   echo date("M-Y", strtotime("$threemonth"));;
                 ?></th>
                  <th style="text-align:center;width:6%">
                  <?php 
                  $twomonth = date('Y-m',strtotime($date." -2 month"));
                   echo date("M-Y", strtotime("$twomonth"));;
                 ?></th>
                  <th style="text-align:center;width:6%">
                  <?php 
                  $onemonth = date('Y-m',strtotime($date." -1 month"));
                   echo date("M-Y", strtotime("$onemonth"));;
                 ?></th>
                <th style="text-align:center;width:8%">Quantity Used for Last 6 Months</th>
                <th style="text-align:center;width:8%">Average Used Qty Per Month</th>
                <th style="text-align:center;width:8%">Lead Time 交货时间</th>
                <th style="text-align:center;width:8%">Lead Time Stock Qty</th>
                <th style="text-align:center;width:8%">1 Months Stock Qty </th>
                <th style="text-align:center;width:8%">20% of Lead Time Stock </th>
                <th style="text-align:center;width:7%">Min. Stock</th>
                <th style="text-align:center;width:8%">Reorder Level </th>
                <th style="text-align:center;width:8%">Reorder Qty </th>
                <th style="text-align:center;width:8%">Stock Qty</th>
                <th style="text-align:center;width:7%">Unit Price (HKD)</th>
                <th style="text-align:center;width:7%">PI Qty</th>
                <th style="text-align:center;width:10%">Stock Value</th>
              </tr>
              </thead>
              <tbody>
            <?php 
              $grandtotal=0; 
              $totalvalue=0;
              $grandpi=0;
              if(isset($resultdetail)&&!empty($resultdetail)): $i=1;
                foreach($resultdetail as $row):
                  $stock=$row->main_stock;
                  $piqty=$this->look_up_model->get_PIStock($row->product_id);
                  $grandtotal=$grandtotal+$stock;
                  $grandpi=$grandpi+$piqty;
                  $totalvalue=$totalvalue+$stock*$row->unit_price;
                  $color="background-color: #FFF;color: #000;";
                   if($stock<$row->minimum_stock){
                    $color="background-color: #CE3130;color: #FFF;";} 
                   if($piqty>0&&$stock<$row->minimum_stock){
                    $color="background-color: #FFDF00;color: #FFF;";
                   }
                   ?>
                  <tr>
                    <td style="text-align:center;<?php echo $color; ?>">
                      <?php echo $i++; ?></td>
                    <td style="<?php echo $color; ?>"><?php echo $row->product_name;?></td>
                    <td style="text-align:center;<?php echo $color; ?>">
                      <?php echo $row->category_name; ?></td>
                    <td style="text-align:center;<?php echo $color; ?>">
                      <?php echo $row->mtype_name;  ?></td>  
                    <td style="text-align:center;<?php echo $color; ?>">
                      <?php echo $row->rack_name;  ?></td>
                    <td style="text-align:center;<?php echo $color; ?>">
                      <?php echo $row->product_code;  ?></td> 
                    <td style="text-align:center;<?php echo $color; ?>">
                      <?php echo $row->bd_or_cn; ?></td>
                    <td style="text-align:center;<?php echo $color; ?>">
                      <?php  $monthqty=$this->look_up_model->get_monthlyqty($row->product_id);
                      $sixqty=0;
                      if(count($monthqty)>0){
                        foreach ($monthqty as $value) {
                          if($value->month==$sixmonth) $sixqty=$value->total_quantity;
                        }
                      } 
                      echo $sixqty;
                    ?></td>
                    <td style="text-align:center;<?php echo $color; ?>">
                      <?php  
                      $fiveqty=0;
                      if(count($monthqty)>0){
                        foreach ($monthqty as  $value) {
                          if($value->month==$fivemonth)  $fiveqty=$value->total_quantity;
                        }
                      } 
                      echo $fiveqty;
                    ?></td>
                    <td style="text-align:center;<?php echo $color; ?>">
                      <?php  
                      $fourqty=0;
                      if(count($monthqty)>0){
                        foreach ($monthqty as  $value) {
                          if($value->month==$fourmonth)  $fourqty=$value->total_quantity;
                        }
                      } 
                      echo $fourqty;
                    ?></td>
                    <td style="text-align:center;<?php echo $color; ?>">
                      <?php  
                      $threeqty=0;
                      if(count($monthqty)>0){
                        foreach ($monthqty as  $value) {
                          if($value->month==$threemonth)  $threeqty=$value->total_quantity;
                        }
                      } 
                      echo $threeqty;
                    ?></td>
                    <td style="text-align:center;<?php echo $color; ?>">
                      <?php  
                      $twoqty=0;
                      if(count($monthqty)>0){
                        foreach ($monthqty as  $value) {
                          if($value->month==$twomonth)  $twoqty=$value->total_quantity;
                        }
                      } 
                      echo $twoqty;
                    ?></td>
                    <td style="text-align:center;<?php echo $color; ?>">
                      <?php  
                      $oneqty=0;
                      if(count($monthqty)>0){
                        foreach ($monthqty as  $value) {
                          if($value->month==$onemonth)  $oneqty=$value->total_quantity;
                        }
                      } 
                      echo $oneqty;
                    ?></td>
                    <td style="vertical-align: text-top;text-align:center;<?php echo $color; ?>">
                      <?php  echo $sixqty+$fiveqty+$fourqty+$threeqty+$twoqty+$oneqty; ?></td>
                    <td style="text-align:center;<?php echo $color; ?>">
                      <?php  
                     
                      echo $avgusepermonth=number_format(($sixqty+$fiveqty+$fourqty+$threeqty+$twoqty+$oneqty)/6,2);
                    ?></td>
                   <!--     <td style="vertical-align: text-top;text-align:center;<?php echo $color; ?>">
                    <?php  echo $row->avg_use_per_month; ?></td> -->
                    <td style="vertical-align: text-top;text-align:center;<?php echo $color; ?>">
                    <?php  echo "$row->lead_time days"; ?></td>
                    <td style="vertical-align: text-top;text-align:center;<?php echo $color; ?>">
                    <?php  echo $row->lead_time_stock_qty; ?></td>
                    <td style="vertical-align: text-top;text-align:center;<?php echo $color; ?>">
                    <?php  echo $row->one_month_stock; ?></td>
                    <td style="vertical-align: text-top;text-align:center;<?php echo $color; ?>">
                    <?php  echo $row->twenty_per_stock; ?></td>
                    <td style="vertical-align: text-top;text-align:center;<?php echo $color; ?>">
                    <?php  echo $row->minimum_stock; ?></td>
                    <td style="vertical-align: text-top;text-align:center;<?php echo $color; ?>">
                    <?php  echo $row->reorder_level; ?></td>
                    <td style="vertical-align: text-top;text-align:center;<?php echo $color; ?>">
                    <?php  echo $row->re_order_qty; ?></td>
                    <td style="vertical-align: text-top;text-align:center;<?php echo $color; ?>">
                    <?php  echo "$stock $row->unit_name"; ?></td>
                    <td style="vertical-align: text-top;text-align:right;<?php echo $color; ?>">
                    <?php  echo number_format($row->unit_price,2); ?></td>
                    <td style="vertical-align: text-top;text-align:center;<?php echo $color; ?>">
                    <?php  echo "$piqty $row->unit_name"; ?></td>
                    
                    <td style="vertical-align: text-top;text-align:right;<?php echo $color; ?>">
                    <?php  echo number_format($stock*$row->unit_price,2); ?></td>
                  </tr>
                  <?php
                  endforeach;
              endif;
              ?>
              <tr>
                  <th style="text-align:right;" colspan="22">Grand Total</th>
                  <th style="text-align:center;"><?php echo $grandtotal; ?></th>
                  <th style="text-align:center;"><?php echo $grandpi; ?></th>
                  <th></th>
                  <th style="text-align:right;"><?php echo number_format($totalvalue,2); ?></th>
              </tr>
              </tbody>
              </table>
              </div>
    </div>
      <!-- /.box-header -->

      <!-- /.box-body -->
    </div>
  </div>
 </div>
