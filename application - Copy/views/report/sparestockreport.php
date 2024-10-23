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
<a class="btn btn-sm btn-primary pull-right" style="margin-right:0px;" href="<?php echo base_url(); ?>me/sparestockreport/downloadExcel2<?php echo "/$category_id/$rack_id/$box_id/$color_code/$product_code";  ?>">
<i class="fa fa-file-excel-o"></i>
Excel All Data
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
    <table class="table table-bordered table-striped colortd" style="width:99%;border:#000"  >
      <thead>
          <tr>
          <th style="text-align:center;width:5%;">SN</th>
          <th style="width:15%;">English Name</th>
          <th style="width:15%;">China Name 中国名</th>
          <th style="width:10%;">Category Name 分类名称</th>
          <th style="text-align:center;width:10%;">Rack(Box) 架</th>
          <th style="text-align:center;width:10%;">Item Code 项目代码</th>
          <th style="text-align:center;width:8%;">Item Origin</th>
          <th style="text-align:center;width:6%;">
          <?php $date = date('Y-m');
            $sixmonth = date('Y-m',strtotime($date." -6 month"));
             echo date("M-Y", strtotime("$sixmonth"));
           ?></th>
          <th style="text-align:center;width:6%;">
            <?php 
            $fivemonth = date('Y-m',strtotime($date." -5 month"));
             echo date("M-Y", strtotime("$fivemonth"));
           ?></th>
          <th style="text-align:center;width:6%;">
            <?php 
            $fourmonth = date('Y-m',strtotime($date." -4 month"));
             echo date("M-Y", strtotime("$fourmonth"));
           ?></th>
          <th style="text-align:center;width:6%;">
            <?php 
            $threemonth = date('Y-m',strtotime($date." -3 month"));
             echo date("M-Y", strtotime("$threemonth"));
           ?></th>
          <th style="text-align:center;width:6%;">
            <?php 
            $twomonth = date('Y-m',strtotime($date." -2 month"));
             echo date("M-Y", strtotime("$twomonth"));
           ?></th>
          <th style="text-align:center;width:6%;">
            <?php 
            $onemonth = date('Y-m',strtotime($date." -1 month"));
             echo date("M-Y", strtotime("$onemonth"));
           ?></th>
          <th style="text-align:center;width:8%">Quantity Used for Last 6 Months
            <br>近6个月使用的数量</th>
          <th style="text-align:center;width:8%">Average Used Qty Per Month
            <br>平均每月使用量</th>
          <th style="text-align:center;width:8%">Lead Time 采购周期</th>
          <th style="text-align:center;width:8%">Lead Time Stock Qty 
            <br>采购周期库存数量</th>
          <th style="text-align:center;width:8%">Reorder Level 
            <br>库存预警数量</th>
          <th style="text-align:center;width:8%">Reorder Qty 
            <br>重新订购数量</th>
          <th style="text-align:center;width:7%">Safety Stock 
            <br>最低安全库存</th>                
          <th style="text-align:center;width:6%">Maximum Qty 
            <br>库存数量</th>
          <th style="text-align:center;width:7%">Stock Qty
            </th>
          <th style="text-align:center;width:7%">Unit Price
            <br>单价</th>
          <th style="text-align:center;width:6%">
            Safety Stock Value 
            <br>安全库存总金额</th>
          <th style="text-align:center;width:6%">
            Maximum Stock Value 
          </th>
          <th style="text-align:center;width:7%">
            Amount in excess of safety stock value 
            <br>超过安全库存值的金额</th>
          <th style="text-align:center;width:6%">PI Qty 
            <br>PI购买数量</th>
          <th style="text-align:center;width:6%">Unit 单位</th>
          <th style="text-align:center;width:6%">Usage Cat</th>
          <th style="text-align:center;width:5%">Stock Value(HKD) 
            <br>库存金额</th>
          <th style="text-align:center;width:5%">Currency 
            <br>货币</th>
          <th style="text-align:center;width:6%">
            Last Received Date 
            <br>上一次收货日期</th>
        </tr>
      </thead>
      <tbody>
    <?php 
      $grandtotal=0; 
      $totalvalue=0;
      $grandpi=0;
      if(isset($resultdetail)&&!empty($resultdetail)): $i=1;
        foreach($resultdetail as $row):
          $piqty=$this->look_up_model->get_PIStock($row->product_id);
          if($piqty>0||$row->main_stock>0||$row->reorder_level>0){
          /////////////////////////////////////////////
          if($color_code!=3){
          $stock=$row->main_stock;
          $grandtotal=$grandtotal+$stock;
          $grandpi=$grandpi+$piqty;
          $totalvalue=$totalvalue+$row->stock_value_hkd;
          $color="background-color: white;color: #000;";
            if($stock<$row->reorder_level){
              $color="background-color: #CE3130;color: #FFF;";
            } 
           ?>
          <tr>
            <td style="text-align:center;<?php echo $color; ?>">
              <?php echo $i++; ?></td>
            <td style="<?php echo $color; ?>"><?php echo $row->product_name;?></td>
            <td style="<?php echo $color; ?>"><?php echo $row->china_name;?></td>
            <td style="text-align:center;<?php echo $color; ?>">
              <?php echo $row->category_name; ?></td>
            <td style="text-align:center;<?php echo $color; ?>">
              <?php echo getRack($row->box_id);  ?></td>
            <td style="text-align:center;<?php echo $color; ?>">
              <?php echo $row->product_code;  ?></td> 
            <td style="text-align:center;<?php echo $color; ?>">
              <?php echo $row->bd_or_cn; ?></td>
            <td style="text-align:center;<?php echo $color; ?>">
            <?php echo ceil($row->sixqty); ?></td>
            <td style="text-align:center;<?php echo $color; ?>">
            <?php echo ceil($row->fiveqty); ?></td>
            <td style="text-align:center;<?php echo $color; ?>">
            <?php echo ceil($row->fourqty); ?></td>
            <td style="text-align:center;<?php echo $color; ?>">
            <?php echo ceil($row->threeqty); ?></td>
            <td style="text-align:center;<?php echo $color; ?>">
            <?php echo ceil($row->twoqty); ?></td>
            <td style="text-align:center;<?php echo $color; ?>">
            <?php echo ceil($row->oneqty); ?></td>
            <td style="text-align:center;<?php echo $color; ?>">
            <?php echo ceil($row->last_six_month_qty); ?></td>
            <td style="vertical-align: text-top;text-align:center;<?php echo $color; ?>">
            <?php  echo ceil($row->avg_use_per_month); ?></td> 
            <td style="vertical-align: text-top;text-align:center;<?php echo $color; ?>">
            <?php  echo "$row->lead_time days"; ?></td>
            <td style="vertical-align: text-top;text-align:center;<?php echo $color; ?>">
            <?php  echo ceil($row->avg_use_per_month*$row->lead_time/30); ?></td>
            <td style="vertical-align: text-top;text-align:center;<?php echo $color; ?>">
            <?php  echo $row->reorder_level; ?></td>
            <td style="vertical-align: text-top;text-align:center;<?php echo $color; ?>">
            <?php  echo $row->re_order_qty; ?></td>
            <td style="vertical-align: text-top;text-align:center;<?php echo $color; ?>">
            <?php  echo $row->safety_stock_qty; ?></td>
            <td style="vertical-align: text-top;text-align:center;<?php echo $color; ?>">
            <?php  echo $row->minimum_stock; ?></td>
            <td style="vertical-align: text-top;text-align:center;<?php echo $color; ?>">
            <?php  echo $stock; ?></td>
            <td style="vertical-align: text-top;text-align:right;<?php echo $color; ?>">
            <?php  echo "$row->unit_price";  ?></td>
            <td style="vertical-align: text-top;text-align:center;<?php echo $color; ?>">
            <?php  echo number_format($row->safety_stock_qty*$row->unit_price,2); ?></td>
            <td style="vertical-align: text-top;text-align:center;<?php echo $color; ?>">
            <?php  echo number_format($row->minimum_stock*$row->unit_price,2); ?></td>
            <td style="vertical-align: text-top;text-align:center;<?php echo $color; ?>">
            <?php  echo number_format(($stock*$row->unit_price)-($row->minimum_stock*$row->unit_price),2); ?></td>
            <td style="vertical-align: text-top;text-align:center;<?php if($piqty>0)echo "background-color: #FFDF00";else echo $color; ?>">
            <?php  echo $piqty; ?></td>
            <td style="vertical-align: text-top;text-align:center;<?php echo $color; ?>">
            <?php  echo $row->unit_name; ?></td>
            <td style="vertical-align: text-top;text-align:center;<?php echo $color; ?>">
            <?php  echo $row->usage_category; ?></td>
            <td style="vertical-align: text-top;text-align:right;<?php echo $color; ?>">
            <?php  echo number_format($row->stock_value_hkd,2);  ?></td>
            <td style="vertical-align: text-top;text-align:right;<?php echo $color; ?>">
            <?php  echo "$row->currency"; ?></td>
            <td style="vertical-align: text-top;text-align:center;<?php echo $color; ?>">
            <?php  echo findDate($row->last_receive_date); ?></td>
          </tr> 
          <?php
        }else{ 
        ?>
        <?php $stock=$row->main_stock;
          if($piqty>0){
          $stock=$row->main_stock;
          $grandtotal=$grandtotal+$stock;
          $grandpi=$grandpi+$piqty;
          $totalvalue=$totalvalue+$row->stock_value_hkd;
            $color="background-color: white;color: #000;";
            if($stock<$row->reorder_level){
              $color="background-color: #CE3130;color: #FFF;";
            } 
           ?>
          <tr>
            <td style="text-align:center;<?php echo $color; ?>">
              <?php echo $i++; ?></td>
            <td style="<?php echo $color; ?>"><?php echo $row->product_name;?></td>
            <td style="<?php echo $color; ?>"><?php echo $row->china_name;?></td>
            <td style="text-align:center;<?php echo $color; ?>">
              <?php echo $row->category_name; ?></td>
            <td style="text-align:center;<?php echo $color; ?>">
              <?php echo getRack($row->box_id);  ?></td>
            <td style="text-align:center;<?php echo $color; ?>">
              <?php echo $row->product_code;  ?></td> 
            <td style="text-align:center;<?php echo $color; ?>">
              <?php echo $row->bd_or_cn; ?></td>
            <td style="text-align:center;<?php echo $color; ?>">
            <?php echo ceil($row->sixqty); ?></td>
            <td style="text-align:center;<?php echo $color; ?>">
            <?php echo ceil($row->fiveqty); ?></td>
            <td style="text-align:center;<?php echo $color; ?>">
            <?php echo ceil($row->fourqty); ?></td>
            <td style="text-align:center;<?php echo $color; ?>">
            <?php echo ceil($row->threeqty); ?></td>
            <td style="text-align:center;<?php echo $color; ?>">
            <?php echo ceil($row->twoqty); ?></td>
            <td style="text-align:center;<?php echo $color; ?>">
            <?php echo ceil($row->oneqty); ?></td>
            <td style="text-align:center;<?php echo $color; ?>">
            <?php echo ceil($row->last_six_month_qty); ?></td>
            <td style="vertical-align: text-top;text-align:center;<?php echo $color; ?>">
            <?php  echo ceil($row->avg_use_per_month); ?></td> 
            <td style="vertical-align: text-top;text-align:center;<?php echo $color; ?>">
            <?php  echo "$row->lead_time days"; ?></td>
            <td style="vertical-align: text-top;text-align:center;<?php echo $color; ?>">
            <?php  echo ceil($row->avg_use_per_month*$row->lead_time/30); ?></td>
            <td style="vertical-align: text-top;text-align:center;<?php echo $color; ?>">
            <?php  echo $row->reorder_level; ?></td>
            <td style="vertical-align: text-top;text-align:center;<?php echo $color; ?>">
            <?php  echo $row->re_order_qty; ?></td>
            <td style="vertical-align: text-top;text-align:center;<?php echo $color; ?>">
            <?php  echo $row->safety_stock_qty; ?></td>
            <td style="vertical-align: text-top;text-align:center;<?php echo $color; ?>">
            <?php  echo $row->minimum_stock; ?></td>
            <td style="vertical-align: text-top;text-align:center;<?php echo $color; ?>">
            <?php  echo $stock; ?></td>
            <td style="vertical-align: text-top;text-align:right;<?php echo $color; ?>">
            <?php  echo "$row->unit_price";  ?></td>
            <td style="vertical-align: text-top;text-align:center;<?php echo $color; ?>">
            <?php  echo number_format($row->safety_stock_qty*$row->unit_price,2); ?></td>
            <td style="vertical-align: text-top;text-align:center;<?php echo $color; ?>">
            <?php  echo number_format($row->minimum_stock*$row->unit_price,2); ?></td>
            <td style="vertical-align: text-top;text-align:center;<?php echo $color; ?>">
            <?php  echo number_format(($stock*$row->unit_price)-($row->minimum_stock*$row->unit_price),2); ?></td>
            <td style="vertical-align: text-top;text-align:center;<?php if($piqty>0)echo "background-color: #FFDF00";else echo $color; ?>">
            <?php  echo $piqty; ?></td>
            <td style="vertical-align: text-top;text-align:center;<?php echo $color; ?>">
            <?php  echo $row->unit_name; ?></td>
            <td style="vertical-align: text-top;text-align:center;<?php echo $color; ?>">
            <?php  echo $row->usage_category; ?></td>
            <td style="vertical-align: text-top;text-align:right;<?php echo $color; ?>">
            <?php  echo number_format($row->stock_value_hkd,2);  ?></td>
            <td style="vertical-align: text-top;text-align:right;<?php echo $color; ?>">
            <?php  echo "$row->currency"; ?></td>
            <td style="vertical-align: text-top;text-align:center;<?php echo $color; ?>">
            <?php  echo findDate($row->last_receive_date); ?></td>
          </tr> 
      <?php  
         }
         } 
        }
          endforeach;
      endif;
      ?>
      <tr>
          <th style="text-align:right;" colspan="22">Grand Total</th>
          <th style="text-align:center;"><?php echo number_format($grandtotal,2); ?></th>
          <th style="text-align:center;"><?php echo number_format($grandpi,2); ?></th>
          <th></th>
          <th></th>
          <th></th>
          <th></th>
          <th></th>
          <th style="text-align:right;"><?php echo number_format($totalvalue,2); ?></th>
          <th></th>
          <th></th>
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
