<!DOCTYPE HTML>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Machine Status </title>
<meta http-equiv="refresh" content="1000;url=<?php echo base_url(); ?>nologin/machinestatus"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">
<!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url('asset/css/font-awesome.min.css'); ?>">
<link href="<?php echo base_url();?>uicon/css/bootstrap-responsive.css" rel="stylesheet">
<link href="<?php echo base_url();?>uicon/css/style.css" rel="stylesheet">
<link href="<?php echo base_url();?>uicon/color/default.css" rel="stylesheet">
<style>
body {
  font-size: 13px;
  font-weight: 300;
   background: #FFF none repeat scroll 0 0;
  color: #000;
  font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
  font-size: 13px;
  line-height: 16px;
}
section.section {
  padding: 0px;
}
    footer {
  background: #2b2b2b none repeat scroll 0 0;
  color: #ddd;
  padding: 5px 0;
  text-align: center;

}
.copyright{
    font-size: 25px;
    font-weight: 600
}


h2 {
  font-size: 25px;
  margin-bottom: 4px;
}
.navbar-inner {
  min-height: 44px;
}
.navbar-fixed-top .navbar-inner, .navbar-static-top .navbar-inner {
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
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
</head>
<body>
<!-- navbar -->
<div class="navbar-wrapper">
  <div class="navbar navbar-inverse navbar-fixed-top">
    <div class="navbar-inner">
      <div class="container">
        <!-- Responsive navbar -->
        <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>
        </a>
        <h1 class="brand" style="margin:5px 0px"><a href="#">
        </a></h1>
        <h2 style="text-align:center;color:#fff"><i class="fa fa-plane" aria-hidden="true"></i> MACHINE INFORMATION</h2>
        <!-- navigation -->
        
      </div>
    </div>
  </div>
</div>
<!-- Header area -->

<!-- end spacer section -->
<!-- section: contact -->
<section id="contact" class="section" style="background:#FFF;margin-top: -14px;">
<!-- <div class="container">
  <div class="row bbbbb">
    <div class="span12"> -->
      <table class="tg">
  <thead>
      <tr>
        <th style="width:5%;">SN</th>
        <th style="width:10%">Ventura Code</th>
        <th style="width:15%;">Machine Name</th>
        <th style="width:10%;">China <br> Name</th>
        <th style="width:10%">Category</th>
        <th style="width:10%;text-align:center">Model NO</th>
        <th style="text-align:center;width:7%">Floor Name</th>
        <th style="text-align:center;width:7%">C. Location</th>
        <th style="text-align:center;width:10%">Machine <br> Type</th>
        <th style="text-align:center;width:7%">TPM CODE (TPM代码)</th>
        <th style="text-align:center;width:10%">Status 状态(<?php echo date("d/m/Y"); $dates=date('Y-m-d'); ?>) </th>
        <th style="text-align:center;width:10%">Invoice No</th>
        <th style="text-align:center;width:8%">Price</th>
        <th style="text-align:center;width:5%">Purchase Date</th>
        <th style="text-align:center;width:5%">
          <?php  echo $date1=date('Y-m-d', strtotime($dates. ' -7 day')); ?> 
        </th>
        <th style="text-align:center;width:5%">
          <?php  echo $date2=date('Y-m-d', strtotime($dates. ' -14 day')); ?> 
        </th>
        <th style="text-align:center;width:5%">
          <?php  echo $date3=date('Y-m-d', strtotime($dates. ' -21 day')); ?> 
        </th>
        <th style="text-align:center;width:5%">
          <?php  echo $date4=date('Y-m-d', strtotime($dates. ' -28 day')); ?> 
        </th>
        <th style="text-align:center;width:5%">
          <?php  echo $date5=date('Y-m-d', strtotime($dates. ' -35 day')); ?> 
        </th>
        <th style="text-align:center;width:5%">
          <?php  echo $date6=date('Y-m-d', strtotime($dates. ' -42 day')); ?> 
        </th>
        <th style="text-align:center;width:5%">
          <?php  echo $date7=date('Y-m-d', strtotime($dates. ' -49 day')); ?> 
        </th>
        <th style="text-align:center;width:5%">
          <?php  echo $date8=date('Y-m-d', strtotime($dates. ' -56 day')); ?> 
        </th>
        <th style="text-align:center;width:5%">
          <?php  echo $date9=date('Y-m-d', strtotime($dates. ' -63 day')); ?> 
        </th>
        <th style="text-align:center;width:5%">
          <?php  echo $date10=date('Y-m-d', strtotime($dates. ' -70 day')); ?> 
        </th>
        <th style="text-align:center;width:5%">
          <?php  echo $date11=date('Y-m-d', strtotime($dates. ' -77 day')); ?> 
        </th>
        <th style="text-align:center;width:5%">
          <?php  echo $date12=date('Y-m-d', strtotime($dates. ' -84 day')); ?> 
        </th>
        <th style="text-align:center;width:5%">
          <?php  echo $date13=date('Y-m-d', strtotime($dates. ' -91 day')); ?> 
        </th>
        <th style="text-align:center;width:5%">
          <?php  echo $date14=date('Y-m-d', strtotime($dates. ' -98 day')); ?> 
        </th>
        <th style="text-align:center;width:5%">
          <?php  echo $date15=date('Y-m-d', strtotime($dates. ' -105 day')); ?> 
        </th>
        <th style="text-align:center;width:5%">
          <?php  echo $date16=date('Y-m-d', strtotime($dates. ' -112 day')); ?> 
        </th>
      </tr>
      </thead>
      <tbody>
      <?php
      if(isset($resultdetail)&&!empty($resultdetail)): $i=1;
        foreach($resultdetail as $row):
            ?>
          <tr>
            <td style="text-align:center">
              <?php echo $i++; ?></td>
            <td style="text-align:center">
              <?php echo $row->ventura_code; ; ?></td>
            <td style="vertical-align: text-top"><?php echo $row->product_name;?></td>
            <td><?php echo $row->china_name;?></td>
            <td style="text-align:center;text-align: center;">
              <?php echo $row->category_name; ; ?></td>
            <td style="text-align:center;text-align: center;">
              <?php echo $row->product_code;  ?></td> 
              <td style="vertical-align: text-top;text-align: center;">
            <?php  echo $row->floor_no; ?> </td>
            <td style="vertical-align: text-top;text-align: center;">
            <?php  echo $row->line_no; ?></td>
            <td style="text-align:center">
            <?php echo $row->machine_type_name;  ?></td>
            <td style="vertical-align: text-top;text-align: center;">
            <?php  echo $row->tpm_serial_code; ?></td>
            <td style="vertical-align: text-top;text-align: center;">
              <?php  echo CheckStatus($row->machine_status); ?></td>
            <td style="vertical-align: text-top;text-align: center;">
            <?php  echo $row->invoice_no; ?></td>
            <td style="vertical-align: text-top;text-align: center;">
            <?php  echo $row->machine_price; ?></td>
            <td style="vertical-align: text-top;text-align: center;">
            <?php  echo findDate($row->purchase_date); ?></td>
            <td style="vertical-align: text-top;text-align: center;">
            <?php  $info=$this->machinestatus_model->getStatusFor($row->product_detail_id); 
            if(isset($info->status1))
            echo CheckStatus($info->status1); 
            else echo "Not Assign";
            ?></td>
            <td style="vertical-align: text-top;text-align: center;">
            <?php  if(isset($info->status2))
            echo CheckStatus($info->status2); 
            else echo "Not Assign"; ?></td>
            <td style="vertical-align: text-top;text-align: center;">
            <?php  if(isset($info->status3))
            echo CheckStatus($info->status3); 
            else echo "Not Assign"; ?></td>
            <td style="vertical-align: text-top;text-align: center;">
            <?php if(isset($info->status4))
            echo CheckStatus($info->status4); 
            else echo "Not Assign"; ?></td>
            <td style="vertical-align: text-top;text-align: center;">
            <?php  if(isset($info->status5))
            echo CheckStatus($info->status5); 
            else echo "Not Assign"; ?></td>
            <td style="vertical-align: text-top;text-align: center;">
            <?php  if(isset($info->status6))
            echo CheckStatus($info->status6); 
            else echo "Not Assign"; ?></td>
            <td style="vertical-align: text-top;text-align: center;">
            <?php  if(isset($info->status7))
            echo CheckStatus($info->status7); 
            else echo "Not Assign"; ?></td>
            <td style="vertical-align: text-top;text-align: center;">
            <?php if(isset($info->status8))
            echo CheckStatus($info->status8); 
            else echo "Not Assign"; ?></td>
            <td style="vertical-align: text-top;text-align: center;">
            <?php  if(isset($info->status9))
            echo CheckStatus($info->status9); 
            else echo "Not Assign"; ?></td>
            <td style="vertical-align: text-top;text-align: center;">
            <?php  if(isset($info->status10))
            echo CheckStatus($info->status10); 
            else echo "Not Assign"; ?></td>
            <td style="vertical-align: text-top;text-align: center;">
            <?php  if(isset($info->status11))
            echo CheckStatus($info->status11); 
            else echo "Not Assign";?></td>
            <td style="vertical-align: text-top;text-align: center;">
            <?php  if(isset($info->status12))
            echo CheckStatus($info->status12); 
            else echo "Not Assign"; ?></td>
            <td style="vertical-align: text-top;text-align: center;">
            <?php  if(isset($info->status13))
            echo CheckStatus($info->status13); 
            else echo "Not Assign"; ?></td>
            <td style="vertical-align: text-top;text-align: center;">
            <?php if(isset($info->status14))
            echo CheckStatus($info->status14); 
            else echo "Not Assign";; ?></td>
            <td style="vertical-align: text-top;text-align: center;">
            <?php  if(isset($info->status15))
            echo CheckStatus($info->status15); 
            else echo "Not Assign"; ?></td>
            <td style="vertical-align: text-top;text-align: center;">
            <?php  if(isset($info->status16))
            echo CheckStatus($info->status16); 
            else echo "Not Assign"; ?></td>

          </tr>
          <?php
          endforeach;
      endif;
      ?>
      </tbody>
 
</table>
  <!--  </div>
  </div>
</div> -->
</section>
<!-- section: contact -->

<script src="<?php echo base_url();?>uicon/js/jquery.js"></script>
<script src="<?php echo base_url();?>uicon/js/jquery.scrollTo.js"></script>
<script src="<?php echo base_url();?>uicon/js/jquery.nav.js"></script>
<script src="<?php echo base_url();?>uicon/js/jquery.localscroll-1.2.7-min.js"></script>
<script src="<?php echo base_url();?>uicon/js/bootstrap.js"></script>
<script src="<?php echo base_url();?>uicon/js/inview.js"></script>
<script src="<?php echo base_url();?>uicon/js/animate.js"></script>
<script src="<?php echo base_url();?>uicon/js/custom.js"></script>

</body>
</html>