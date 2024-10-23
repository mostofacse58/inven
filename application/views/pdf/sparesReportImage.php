<html>
<style type="text/css">
  @media print{
            .print{ display:none;}
            .approval_panel{ display:none;}
             .margin_top{ display:none;}
            .rowcolor{ background-color:#CCCCCC !important;}
            body {padding: 3px; font-size:12px}
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
        <th style="width:15%;">Tools/Materials Name</th>
        <th style="text-align:center;width:5%;">Country</th>
        <th style="width:10%">Category Name 分类名称</th>
        
        <th style="text-align:center;width:10%">Rack(Box)</th>
        <th style="text-align:center;width:10%">Item Code 项目代码</th>
        <th style="text-align:center;width:7%">Min. Stock</th>
         <th style="text-align:center;width:7%">C. Stock</th>
        <th style="text-align:center;width:10%">Picture</th>
    </tr>
    </thead>
    <tbody>
    <?php $grandtotal=0;
    if(isset($resultdetail)&&!empty($resultdetail)): 
      $i=1;
      foreach($resultdetail as $row):
        $stock=$row->main_stock;
        $grandtotal=$grandtotal+$stock;
    ?>
        <tr>
         <td style="text-align:center;">
            <?php echo $i++; ?></td>
          <td style=""><?php echo $row->product_name; echo "($row->china_name)";?></td>
          <td style="text-align:center;<?php echo $color; ?>">
                      <?php if($row->bd_or_cn==1) echo "BD"; else echo "CN";  ?></td>
          <td style="text-align:center;">
            <?php echo $row->category_name; ?></td>
     
          <td style="text-align:center;">
            <?php echo $row->rack_name;  ?></td>
            <td style="text-align:center;">
            <?php echo $row->product_code;  ?></td> 
          <td style="vertical-align: text-top;text-align:center;">
          <?php  echo "$row->minimum_stock $row->unit_nam"; ?></td>
          <td style="vertical-align: text-top;text-align:center;<?php echo $color; ?>">
                    <?php  echo "$stock $row->unit_name"; ?></td>
          <th>
            <?php if (isset($row->product_image) &&!empty($row->product_image)) { ?>
            <img src="<?php echo base_url(); ?>product/<?php echo $row->product_image; ?>" class="img-thumbnail" style="width:100px;height:auto;"/>
            <?php }else{ echo "No Image";} ?></th>
        </tr>
        <?php
        endforeach;
    endif;
    ?>

    </tbody>

</table>

<html>