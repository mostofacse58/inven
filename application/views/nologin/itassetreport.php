<!DOCTYPE HTML>
<html lang="en">
<head>
<meta charset="utf-8">
<title><?php echo $heading; ?> </title>
<!-- <meta http-equiv="refresh" content="1000;url=<?php //echo base_url(); ?>nologin/machinestatus"/> -->
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
        <h2 style="text-align:center;color:#fff"><i class="fa fa-car" aria-hidden="true"></i> <?php echo $heading; ?></h2>
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
      <th style="text-align:center;width:5%;">SN</th>
      <th style="width:10%">Ventura Code</th>
      <th style="text-align:center;width:7%">Serial No</th>
      <th style="width:15%;">Asset Name</th>
      <th style="width:10%">Category</th>
      <th style="text-align:center;width:7%">Location</th>
      <th style="text-align:center;width:10%">Department</th>
      <th style="text-align:center;width:10%">Division</th>
      <th style="text-align:center;width:8%">Status 状态</th>
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
            <td><?php echo $row->asset_encoding;?></td>
            <td style="text-align:center;text-align: center;">
              <?php echo $row->product_name; ; ?></td>
            <td style="text-align:center;text-align: center;">
              <?php echo $row->category_name;  ?></td> 
              <td style="vertical-align: text-top;text-align: center;">
            <?php  echo $row->location_name; ?> </td>
            <td style="vertical-align: text-top;text-align:center;">
            <?php  echo $row->department_name; ?></td>
            <td style="vertical-align: text-top;text-align:center;">
            <?php  echo $row->division; ?></td>
            <td style="vertical-align: text-top;text-align: center;">
            <?php  echo CheckStatuspro($row->it_status); ?></td>
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
<script src="<?php echo base_url();?>uicon/contactform/contactform.js"></script>

</body>
</html>