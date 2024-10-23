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
  var category_ids = "<?php echo set_value('category_id') ?>";
  
  var department_id=$('#department_id').val();
      if(department_id !=''){
      $.ajax({
        type:"post",
        url:"<?php echo base_url()?>"+'commonr/itemstock/getcategory',
        data:{department_id:department_id},
        success:function(data){
          $("#category_id").empty();
          $("#category_id").append(data);
          if(category_ids != ''){
            $('#category_id').val(category_ids).change();
          } }
      });
    }
    ///////////////////////
    $('#department_id').on('change',function(){
      var department_id=$('#department_id').val();
      if(department_id !=''){
      $.ajax({
        type:"post",
        url:"<?php echo base_url()?>"+'commonr/itemstock/getcategory',
        data:{department_id:department_id},
        success:function(data){
          $("#category_id").empty();
          $("#category_id").append(data);
          if(category_ids != ''){
            $('#category_id').val(category_ids).change();
          }}
      });
    
    }
    });
  ////////////////////////
     var rack_id=$('#rack_id').val();
          if(rack_id !=''){
          $.ajax({
            type:"post",
            url:"<?php echo base_url()?>"+'commonr/itemstock/getBox/',
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
          url:"<?php echo base_url()?>"+'commonr/itemstock/getBox',
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
th{vertical-align: top;}
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
<a class="btn btn-sm btn-primary pull-right" style="margin-right:0px;" href="<?php echo base_url(); ?>commonr/itemstock/downloadExcel<?php echo "/$category_id/$rack_id/$box_id/$department_id/$product_code";  ?>">
<i class="fa fa-file-excel-o"></i>
Download Excel
</a>
<a class="btn btn-sm btn-primary pull-right" style="margin-right:0px;" href="<?php echo base_url(); ?>commonr/itemstock/downloadPdf<?php echo "/$category_id/$rack_id/$box_id/$department_id/$product_code";  ?>">
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
    <form class="form-horizontal" action="<?php echo base_url();?>commonr/stock/reportrResult" method="POST" enctype="multipart/form-data">
      <div class="box-body">
        <div class="form-group">
          <label class="col-sm-2 control-label">
          Holder Department</label>
          <div class="col-sm-2">
            <select class="form-control select2" name="department_id" id="department_id">
            <?php 
            foreach($dlist as $rows){  ?>
            <option value="<?php echo $rows->department_id; ?>" 
              <?php echo $rows->department_id==$this->session->userdata('department_id')? 'selected="selected"':0; ?>>
               <?php echo $rows->department_name; ?></option>
            <?php }  ?>
          </select>                    
          <span class="error-msg"><?php echo form_error("department_id");?></span>
          </div>
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
            <select class="form-control" name="rack_id" id="rack_id">
            <option value="All" <?php echo 'All'==set_value('rack_id')? 'selected="selected"':0; ?>>All</option>
            <?php $department_id=$this->session->userdata('department_id');
            $rlist=$this->db->query("SELECT * FROM rack_info WHERE department_id=$department_id")->result();
            foreach($rlist as $rows){  ?>
            <option value="<?php echo $rows->rack_id; ?>" 
              <?php echo $rows->rack_id==set_value('rack_id')? 'selected="selected"':0; ?>>
               <?php echo $rows->rack_name; ?></option>
            <?php }  ?>
          </select>                    
          <span class="error-msg"><?php echo form_error("rack_id");?></span>
          </div>
          
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">
          Box Name<span style="color:red;">  </span></label>
        <div class="col-sm-2">
          <select class="form-control select2" name="box_id" id="box_id">
            <option value="All" selected="selected">All</option>
            </select>
            <span class="error-msg"><?php echo form_error("box_id"); ?></span>
          </div>          
          <label class="col-sm-2 control-label">
          Search 搜索<span style="color:red;">  *</span></label>
          <div class="col-sm-3">
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
                <th style="text-align:center;width:5%;" rowspan="2">SN</th>
                <th style="width:10%;" rowspan="2">Category name <br> 物料分类</th>
                <th style="width:10%;" rowspan="2">Origin <br>原產地</th>
                <th style="width:10%;" rowspan="2">Lead time (Days)<br>生產週期</th>
                <th style="width:10%;" rowspan="2">Currency幣別</th>
                <th style="width:10%;" rowspan="2">Unit price單價</th>
                <th style="width:10%;" rowspan="2">Item code <br>  物料編碼</th>
                <th style="width:10%;" rowspan="2">Item/materials name <br> 物料名稱</th>
                <th style="width:10%;" rowspan="2">Location 位置</th>
                <th style="width:10%;" rowspan="2">Total usage QTY <?php echo date('Y')-1; ?> <br>总用量 <?php echo date('Y')-1; ?></th>
                <th style="text-align:center;width:6%;" rowspan="2">
                  <?php $date = date('Y-m');
                    $sixmonth = date('Y-m',strtotime($date." -6 month"));
                     echo date("M-Y", strtotime("$sixmonth"));
                   ?></th>
                  <th style="text-align:center;width:6%;" rowspan="2">
                    <?php 
                    $fivemonth = date('Y-m',strtotime($date." -5 month"));
                     echo date("M-Y", strtotime("$fivemonth"));
                   ?></th>
                  <th style="text-align:center;width:6%;" rowspan="2">
                    <?php 
                    $fourmonth = date('Y-m',strtotime($date." -4 month"));
                     echo date("M-Y", strtotime("$fourmonth"));
                   ?></th>
                  <th style="text-align:center;width:6%;" rowspan="2">
                    <?php 
                    $threemonth = date('Y-m',strtotime($date." -3 month"));
                     echo date("M-Y", strtotime("$threemonth"));;
                   ?></th>
                  <th style="text-align:center;width:6%;" rowspan="2">
                    <?php 
                    $twomonth = date('Y-m',strtotime($date." -2 month"));
                     echo date("M-Y", strtotime("$twomonth"));
                   ?></th>
                  <th style="text-align:center;width:6%;" rowspan="2">
                    <?php 
                    $onemonth = date('Y-m',strtotime($date." -1 month"));
                     echo date("M-Y", strtotime("$onemonth"));
                   ?></th>
                <th style="width:10%;" rowspan="2">Total usage QTY <?php echo date('Y'); ?> <br> 总用量2021</th>
                <th style="width:10%;" rowspan="2">Last month closing stock QTY <br>上月最后庫存数量</th>
                <th style="width:10%;" rowspan="2">Price for closing stock <br>价格（上月的最后庫存数量)</th>
                <th style="width:10%;" rowspan="2">Current month used price <br>当月已用的金额</th>
                <th style="width:10%;" rowspan="2">Daily consumption <br>每日用量</th>
                <th style="width:10%;" rowspan="2">Auto Safety stock QTY <br>安全库存数量</th>
                <th style="width:10%;" rowspan="2">Safety stock QTY <br>安全库存数量</th>
                <th style="width:10%;" rowspan="2">Safety stock price <br>安全库存数金额 </th>
                <th style="width:10%;" rowspan="2">Current stock price <br>现在的库存金额</th>
                <th style="width:10%;" rowspan="2">Excess stock price <br>按现在的库存量计算的超库存</th>
                <th style="width:10%;" rowspan="2">Total stock & PI price <br>总金额（PI+库存）</th>
                <th style="width:10%;" rowspan="2">(PI+Inventory) super safe inventory amount <br>（PI+库存）超安全库存量金额</th>
                <th style="width:10%;" rowspan="2">Current stock QTY <br>现有库存</th>
                <th style="width:10%;" rowspan="2">Unit单位</th>

                <th style="width:10%;" colspan="2">Stock QTY  will be use till 目前库存预计使用时间</th>
                <th style="width:10%;" rowspan="2">Purchase indent No采购单</th>
                <th style="width:10%;" rowspan="2">Purchase  QTY <br>新订未到厂数量</th>
                <th style="width:10%;" rowspan="2">Purchase  price <br>采购净额</th>
                <th style="width:10%;" rowspan="2">PI QTY  will be use till (Day) <br>PI数用量日期</th>
                <th style="width:10%;" colspan="2">Total QTY  will be use till <br>(stock+purchase QTY) <br>整体预计用完时间- 日期</th>
                <th style="width:10%;" rowspan="2">Long time stock reason</th>
                <th style="width:10%;" rowspan="2">Remarks备注</th>
            </tr>
            <tr>
               <th> Date日期</th> <!-- 29 -->
               <th> Day's天数</th> <!-- 30 -->
               <th> Date日期</th> <!-- 29 -->
               <th> Day's天数</th> <!-- 30 -->
            </tr>
            </thead>
            <tbody>
            <?php $grandtotal=0; $totalvalue=0;$grandpi=0;
            if(isset($resultdetail)&&!empty($resultdetail)): $i=1;
              foreach($resultdetail as $row):
                $stock=$row->main_stock;
                $piqty=$this->look_up_model->get_PIStock($row->product_id);
                $grandtotal=$grandtotal+$stock;
                $grandpi=$grandpi+$piqty;
                $totalvalue=$totalvalue+$row->stock_value_hkd;
                $color="background-color: #FFDF00;color: #000;";
                 if($stock<$row->minimum_stock){
                  $color="background-color: #CE3130;color: #FFF;";
                } 
                $lastsixmonth=$row->oneqty+$row->twoqty+$row->threeqty+$row->fourqty+$row->fiveqty+$row->sixqty;
                //$hkdrate=getHKDRate($row->currency);
                ?>
                <tr>
                  <td style="text-align:center;<?php echo $color; ?>">
                    <?php echo $i++; ?></td>
                  <td style="text-align:center;<?php echo $color; ?>">
                    <?php echo $row->category_name; ?></td>
                  <td style="<?php echo $color; ?>"><?php echo $row->bd_or_cn;?></td>
                  <td style="<?php echo $color; ?>"><?php echo $row->lead_time;?></td>
                  <td style="<?php echo $color; ?>"><?php echo $row->currency;?></td>
                  <td style="text-align:center;<?php echo $color; ?>">
                    <?php echo $row->unit_price;  ?></td> 
                  <td style="text-align:center;<?php echo $color; ?>">
                    <?php echo $row->product_code;  ?></td> 
                  <td style="<?php echo $color; ?>"><?php echo $row->product_name;?></td>
                  <td style="<?php echo $color; ?>"><?php echo $row->rack_name;?></td>
                  <td style="text-align:center;<?php echo $color; ?>"><?php echo $row->before_year_qty;?></td>
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
                  <td style="text-align:center;<?php echo $color; ?>"><?php echo getThisYearQty($row->product_id);?></td>
                  <td style="text-align:center;<?php echo $color; ?>"><?php echo $row->lmonth_closing_stock;?></td>
                  <td style="text-align:center;<?php echo $color; ?>"><?php echo $row->lmonth_closing_stock*$row->unit_price;?></td>
                  <td style="text-align:center;<?php echo $color; ?>"><?php $tinfo=getThisMonthQty($row->product_id); echo $tinfo->qty;?></td>
                  <td style="text-align:center;<?php echo $color; ?>"><?php  echo $tinfo->qty*$row->unit_price;?></td>
                  <td style="text-align:center;<?php echo $color; ?>"><?php echo $dailycon=$lastsixmonth/180;  ?> </td>
                  <td style="text-align:center;<?php echo $color; ?>"><?php echo $row->auto_safety_stock;  ?></td>
                  <td style="text-align:center;<?php echo $color; ?>"><?php echo $row->minimum_stock;  ?></td>
                  <td style="text-align:center;<?php echo $color; ?>"><?php echo $row->minimum_stock*$row->unit_price;  ?></td>
                  <td style="text-align:center;<?php echo $color; ?>"><?php echo $row->main_stock*$row->unit_price;  ?></td>
                  <td style="text-align:center;<?php echo $color; ?>"><?php echo ($row->main_stock*$row->unit_price)-($row->minimum_stock*$row->unit_price);  ?></td>
                  <td style="text-align:center;<?php echo $color; ?>"><?php echo ($row->main_stock+$piqty)*$row->unit_price;  ?></td>
                  <td style="text-align:center;<?php echo $color; ?>"><?php echo (($row->main_stock+$piqty)*$row->unit_price)-($row->minimum_stock*$row->unit_price);  ?></td>
                  <td style="text-align:center;<?php echo $color; ?>"><?php echo $row->main_stock;  ?></td>
                  <td style="text-align:center;<?php echo $color; ?>"><?php
                   if($dailycon!=0) $useDay=round($row->main_stock/$dailycon); else $useDay=0;
                    echo date('Y-m-d',strtotime($date." +$useDay days"));     ?></td>
                  <td style="text-align:center;<?php echo $color; ?>"><?php echo $useDay;  ?></td>
                  <td style="text-align:center;<?php echo $color; ?>"><?php echo '';  ?></td>
                  <td style="text-align:center;<?php echo $color; ?>"><?php echo $newpurchaseqty=($row->lead_time+3)*$dailycon;  ?></td>
                  <td style="text-align:center;<?php echo $color; ?>">
                    <?php echo $newpurchaseqty*$row->unit_price;  ?></td>
                  <td style="text-align:center;<?php echo $color; ?>"><?php if($dailycon!=0)  echo round($newpurchaseqty/$dailycon); else echo 0; ?></td>
                  <td style="text-align:center;<?php echo $color; ?>"><?php
                   if($dailycon!=0) $useDay=round(($row->main_stock+$newpurchaseqty)/$dailycon); else $useDay=0; 
                   echo date('Y-m-d',strtotime($date." +$useDay days"));     ?></td>
                  <td style="text-align:center;<?php echo $color; ?>">
                    <?php echo $useDay;  ?></td>
                  <td style="text-align:center;<?php echo $color; ?>"> </td>
                  <td style="text-align:center;<?php echo $color; ?>"> </td>
                </tr>
                <?php
                endforeach;
            endif;
            ?>
            <!-- <tr>
                <th style="text-align:right;" colspan="6">Grand Total</th>
                <th style="text-align:center;"><?php echo $grandtotal; ?></th>
                <th style="text-align:center;"></th>
                <th style="text-align:center;"></th>
                <th style="text-align:right;"><?php echo number_format($totalvalue,2); ?></th>
            </tr> -->
            </tbody>
            </table>
          </div>
  </div>
    <!-- /.box-header -->

    <!-- /.box-body -->
  </div>
</div>
</div>
