<html>
<style type="text/css">
body{
  font-family: 'Hiragino Kaku Gothic Pro', 'WenQuanYi Zen Hei', '微軟正黑體', '蘋果儷中黑', Helvetica, Arial, sans-serif;
}
.tg  {border-collapse:collapse;border-spacing:0;width:100%}
.tg td{font-family:Arial, sans-serif;font-size:12px;padding:3px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
.tg th{font-family:Arial, sans-serif;font-size:12px;font-weight:normal;padding:3px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
.tg .tg-s6z2{text-align:center}
.tg .tg-baqh{text-align:center;vertical-align:top}
</style>
<h4 align="center" style="margin:0;"><b> 
   <?php if(isset($heading))echo $heading; ?>  </b></h4>
<table class="tg">
   <thead>
            <tr>
                 <th style="text-align:center;width:5%;">SN</th>
                <th style="width:15%;">Item/Materials Name</th>
                <th style="width:10%">Category Name 分类名称</th>
                <th style="text-align:center;width:10%">Rack(Box)</th>
                <th style="text-align:center;width:10%">Item Code 项目代码</th>
                <th style="text-align:center;width:7%">Safety Stock</th>
                <th style="text-align:center;width:8%">Stock Qty</th>
                <th style="text-align:center;width:8%">Currency</th>
                <!-- <th style="text-align:center;width:7%">PI Qty</th> -->
                <th style="text-align:center;width:10%">Stock Value(HKD)</th>
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
                ?>
                <tr>
                  <td style="text-align:center;<?php echo $color; ?>">
                    <?php echo $i++; ?></td>
                  <td style="<?php echo $color; ?>"><?php echo $row->product_name;?></td>
                  <td style="text-align:center;<?php echo $color; ?>">
                    <?php echo $row->category_name; ?></td>
           
                  <td style="text-align:center;<?php echo $color; ?>">
                    <?php echo $row->rack_name;  ?></td>
                    <td style="text-align:center;<?php echo $color; ?>">
                    <?php echo $row->product_code;  ?></td> 
                  <td style="vertical-align: text-top;text-align:center;<?php echo $color; ?>">
                  <?php  echo $row->minimum_stock; ?></td>
                  <td style="vertical-align: text-top;text-align:center;<?php echo $color; ?>">
                  <?php  echo "$stock $row->unit_name"; ?></td>
                  <!-- <td style="vertical-align: text-top;text-align:center;<?php echo $color; ?>">
                  <?php  echo "$piqty $row->unit_name"; ?></td> -->
                  <td style="vertical-align: text-top;text-align:center;<?php echo $color; ?>">
                  <?php  echo $row->currency; ?></td>
                  <td style="vertical-align: text-top;text-align:right;<?php echo $color; ?>">
                  <?php  echo number_format($row->stock_value_hkd,2); ?></td>
                </tr>
                <?php
                endforeach;
            endif;
            ?>
            <tr>
                <th style="text-align:right;" colspan="6">Grand Total</th>
                <th style="text-align:center;"><?php echo $grandtotal; ?></th>
                <th style="text-align:center;"></th>
                <th style="text-align:right;"><?php echo number_format($totalvalue,2); ?></th>
            </tr>
    </tbody>
</table>
<html>