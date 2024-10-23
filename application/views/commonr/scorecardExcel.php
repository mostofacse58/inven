  <?php 
$name="scorecard_".date('Y-m-dhi').".xls";
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
        <th style="text-align:center;width:4%;">SN</th>
        <th style="text-align:center;width:10%">SUPPLIER NAME</th>
        <th style="width:15%;">WORK ORDER</th>
        <th style="text-align:center;width:10%">DELIVERY (Weight=40%)</th>
        <th style="text-align:center;width:10%">QUALITY (Weight=40%)</th>
        <th style="text-align:center;width:10%">PO ACK (Weight=10%)</th>
        <th style="text-align:center;width:10%">PAYMENT_TERMS (Weight=10%)</th>
        <th style="text-align:center;width:10%">SCORE</th>
    </tr>
    </thead>
    <tbody>
    <?php 
    $grandtotal=0;  
    $counts=0;
    $delivery_rate=0;
    $qualityrate=0;
    $payment_term_rate=0;
    $resposive_rate=0;
    if(isset($resultdetail)&&!empty($resultdetail)): 
      $i=1;
      foreach($resultdetail as $row){
        $counts++;
        $deliveryrate=$this->scorecard_model->getDelivery($row->po_number);
        $paymenttermrate=$this->scorecard_model->getPayment($row->po_number);
        $quality_rate=$this->scorecard_model->getQuality($row->po_number);

        $delivery_rate=$delivery_rate+$deliveryrate;
        $payment_term_rate=$payment_term_rate+$paymenttermrate;
        $qualityrate=$qualityrate+$quality_rate;

        $d1= new DateTime("$row->approved_date_time"); // first date
        $d2= new DateTime("$row->acknow_date_time"); // second date
        $interval= $d1->diff($d2); // get difference between two dates
        $hours=($interval->days * 24) + $interval->h;
        if($hours<=12) $rrate=5;
        elseif($hours>12&&$hours<=24) $rrate=4;
        elseif($hours>24&&$hours<=36) $rrate=3;
        elseif($hours>36&&$hours<=48) $rrate=2;
        else $rrate=1;
        $resposive_rate=$resposive_rate+$rrate;
        /////////////////////////////////////
        ?>
        <tr>
          <td style="text-align:center;">
            <?php echo $i++; ?></td>
          <td style=""><?php echo $row->supplier_name;?></td>
          <td style="text-align:center;">
            <?php echo $row->po_number; ?></td>
          <td style="text-align:center;">
            <?php echo $deliveryrate;  ?></td>
          <td style="text-align:center;">
            <?php echo $quality_rate;  ?></td> 
          <td style="text-align:center;">
            <?php echo $rrate;  ?></td> 
          <td style="vertical-align: text-top;text-align:center;">
          <?php  echo $paymenttermrate; ?></td>
          <td style="vertical-align: text-top;text-align:center;">
          <?php  
            $total=($deliveryrate*40)/100+($quality_rate*40)/100+($rrate*10)/100+($paymenttermrate*10)/100;
            echo $total;
            $grandtotal=$grandtotal+$total;
            /////////////////////////////////
          ?>
          </td>
        </tr>
        <?php
      }
    
    ?>
    <tr>
      <th style="text-align:right;" colspan="3">Average</th>
      <th style="text-align:center;">
        <?php echo number_format($delivery_rate*40/(100*$counts),2); ?> 
      </th>
      <th style="text-align:center;">
        <?php echo number_format($qualityrate*40/(100*$counts),2); ?> 
      </th>
      <th style="text-align:center;">
        <?php echo number_format($resposive_rate*10/(100*$counts),2); ?> 
      </th>
      <th style="text-align:center;">
        <?php echo number_format($payment_term_rate*10/(100*$counts),2); ?> 
      </th>
      <th style="text-align:center;">
        <?php echo number_format($grandtotal/$counts,2); ?>
      </th>
     </tr>
     <?php endif; ?>
    </tbody>
    </table>

<html>