<!DOCTYPE html>
<html lang="en">
<?php  
//$u=base_url(); if($u!='http://www.osmbd.com/') {exit();} ?>
<?php 
  $company_info=getCompanyInfo(); 
 ?>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="<?php echo base_url();?>logo/favicon.ico">
    <link rel="shortcut icon" href="<?php echo base_url();?>logo/favicon.png">

    <title><?php if(isset($title)) echo $title; else echo $company_info['company_name']; ?></title>
<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url('');?>asset2/vendor/bootstrap/css/bootstrap.css" rel="stylesheet">
           
   
    <!-- Custom Fonts -->
    <link href="<?php echo base_url('');?>asset2/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    
    <!-- Theme CSS -->
    <link rel="stylesheet" href="<?php echo base_url('');?>asset/js/plugins/select2/select2.min.css">
    <link href="<?php echo base_url('');?>asset2/css/style.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="<?php echo base_url('');?>asset2/css/custom.css" rel="stylesheet">
    <style>
  .formdesign{
    color:#fff;
    font-size:20px; 
    text-align:center;
}
    </style>
  </head>

  <body>
    
    <!-- Nav Section -->
    
    <nav id="mainNav" class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>Menu<i class="fa fa-bars"></i>
                </button>
                
                <!-- Logo Here -->
                <a class="navbar-brand" href="#page-top"><img src="<?php echo base_url();?>logo/<?php echo $company_info['logo']; ?>" alt="<?php echo $company_info['company_name']; ?>" class="img-responsive"/></a>
            </div>
        </div>
        <!-- /.container-fluid -->
    </nav>    
    <?php echo $this->load->view($display); ?>
    <!-- Services Section -->
    <!-- Footer Section -->
    <footer class="footer" id="footer"><!-- Section id-->
        <div class="copyright clearfix">
            <div class="">
                <p class="copy">Copyright 2017 <span><?php echo $company_info['company_name']; ?></span> | All Rights Reserved</p>
            </div>
        </div>
    </footer>
     <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="<?php echo base_url('');?>asset2/js/ie10-viewport-bug-workaround.js"></script>
    
    <!-- jQuery -->
    <script src="<?php echo base_url('');?>asset2/vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo base_url('');?>asset2/vendor/bootstrap/js/bootstrap.min.js"></script>
        

    <!-- Theme JavaScript -->
    <script src="<?php echo base_url('');?>asset2/js/theme.js"></script>
    
    <!-- custom JavaScript -->
    <script src="<?php echo base_url('');?>asset2/js/custom.js"></script>
        
    <!-- FlexSlider -->
    <script src="<?php echo base_url('asset/js/plugins/datepicker/bootstrap-datepicker.js'); ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('asset/js/plugins/datepicker/datepicker3.css'); ?>">
<link rel="stylesheet" href="<?php echo base_url('asset/js/plugins/select2/select2.min.css'); ?>">
<script src="<?php echo base_url('asset/js/plugins/select2/select2.full.min.js'); ?>"></script>

<script>
$(document).ready (function(){
 $("#danger-alert").alert();
  window.setTimeout(function () { 
    $("#danger-alert").alert('close'); }, 2000);               
 });
$(document).ready (function(){
 $("#success-alert").alert();
  window.setTimeout(function () { 
    $("#success-alert").alert('close'); }, 2000);               
 });
</script>
<script>
$(document).ready (function(){
    //Initialize Select2 Elements
    $(".select2").select2();

     $('.date').datepicker({
        "format":"dd/mm/yyyy",
        "todayHighlight": true,
        "autoclose":true
      });

  });
</script>

  </body>

</html>
