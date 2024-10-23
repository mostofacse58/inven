  <?php 
$name="IssueReport_".date('Y-m-dhi').".xls";
header("Content-type: application/octet-stream");
header('Content-Disposition: attachement; filename="' .$name. '"');
header("Pragma: no-cache");
header("Expires: 0");
?>
<html>
<head>
  <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  </head>
<style type="text/css">
body{
  font-family: 'Hiragino Kaku Gothic Pro', 'WenQuanYi Zen Hei', '微軟正黑體', '蘋果儷中黑', Helvetica, Arial, sans-serif;
}
.tg  {border-collapse:collapse;
  border-spacing:0;width:100%}
.tg td{
  font-size:12px;
  padding:10px 5px;
  border-style:solid;
  border-width:1px;
  overflow:hidden;
  word-break:normal;
}
.tg th{
  font-size:12px;
  font-weight:bold;
  padding:10px 5px;
  border-style:solid;
  border-width:1px;
  overflow:hidden;
  word-break:normal;}
.tg .tg-s6z2{text-align:center}
.tg .tg-baqh{text-align:center;
  vertical-align:top}

</style>
<h4 align="center" style="margin:0;"><b> 
   <?php if(isset($heading))echo $heading; ?>  </b></h4>
<table class="tg">
   <thead>
        <tr>
            <th style="text-align:center;width:5%;">SN</th>
            <th style="text-align:center;width:10%">Issue Date</th>
            <th style="width:15%;">Item/Materials Name</th>
            <th style="text-align:center;width:10%">Item Code 项目代码</th>
            <th style="text-align:center;width:8%">FIFO CODE</th>
            <th style="text-align:center;width:7%">Issue Qty</th>
            <th style="text-align:center;width:7%">Unit <br> Price(Currency)</th>
            <th style="text-align:center;width:7%">Amount(HKD)</th>
            <th style="text-align:center;width:8%">Dept</th>
            <th style="text-align:center;width:8%">Location</th>
            <th style="text-align:center;width:7%">Employee</th>
            <th style="text-align:center;width:7%">ID</th>
            <th style="text-align:center;width:6%">Type</th>
            <th style="text-align:center;width:6%">Asset Code</th>
        </tr>
        </thead>
        <tbody>
        <?php $grandtotal=0; $grandpi=0;$grandamount=0;
        if(isset($resultdetail)&&!empty($resultdetail)): $i=1;
          foreach($resultdetail as $row):
            $grandtotal=$grandtotal+$row->quantity;
            $grandamount=$grandamount+$row->amount_hkd;
            ?>
            <tr>
              <td style="text-align:center;">
                <?php echo $i++; ?></td>
              <td style="text-align:center;">
                <?php echo findDate3($row->issue_date);  ?></td>
              <td style=""><?php echo $row->product_name;?></td>
              <td style="text-align:center;">
                <?php echo $row->product_code;  ?></td>
              <td style="text-align:center;">
                <?php echo "'$row->FIFO_CODE";  ?></td>  
              <td style="vertical-align: text-top;text-align:center;">
              <?php  echo "$row->quantity"; ?></td>
              <td style="vertical-align: text-top;text-align:center;">
              <?php  echo "$row->unit_price $row->currency"; ?></td>
              <td style="vertical-align: text-top;text-align:center;">
              <?php  echo $row->amount_hkd; ?></td>
              <td style="vertical-align: text-top;text-align:center;">
              <?php  echo $row->department_name; ?></td>
              <td style="vertical-align: text-top;text-align:center;">
              <?php  echo $row->location_name; ?></td>
              <td style="vertical-align: text-top;text-align:center;">
              <?php  echo "$row->employee_name"; ?></td>
              <td style="vertical-align: text-top;text-align:center;">
              <?php  echo "'$row->employee_id"; ?></td>
              <td style="vertical-align: text-top;text-align:center;">
              <?php if($row->issue_for==1)  echo "NEW"; elseif($row->issue_for==2) echo "REPLACE"; ?></td>
              <td style="vertical-align: text-top;text-align:center;">
              <?php  echo $this->itemissuereport_model->getAssetCode($row->product_detail_id); ?></td>
            </tr>
            <?php
            endforeach;
        endif;
        ?>
        <tr>
            <th style="text-align:right;" colspan="5">Grand Total</th>
            <th style="text-align:center;"><?php echo $grandtotal; ?> HKD</th>
            <th style="text-align:right;"></th>
            <th style="text-align:center;">
                    <?php echo number_format($grandamount,2); ?> HKD</th>
            <th style="text-align:right;"></th>
            <th style="text-align:right;"></th>
            <th style="text-align:right;"></th>
            <th style="text-align:right;"></th>
            <th style="text-align:right;"></th>
            <th></th>
        </tr>
        </tbody>
 
</table>

<html>