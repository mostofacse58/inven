<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>.:VLMBD || <?php if(isset($heading)) echo $heading; else echo "Dashboard";  ?></title>
<link href="<?php echo base_url(); ?>asset/favicon.ico" rel="shortcut icon" type="image/x-icon" />
<link href="<?php echo base_url(); ?>asset/favicon.png" rel="shortcut icon" type="image/x-icon" />

  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="<?php echo base_url('asset/css/bootstrap.min.css'); ?>">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url('asset/css/font-awesome.min.css'); ?>">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo base_url('asset/css/ionicons.min.css'); ?>">

   <link rel="stylesheet" href="<?php echo base_url('asset/js/plugins/datepicker/datepicker3.css'); ?>">
  <link rel="stylesheet" href="<?php echo base_url('asset/js/plugins/timepicker/bootstrap-timepicker.min.css'); ?>">

   <link rel="stylesheet" href="<?php echo base_url('asset/js/plugins/datatables/dataTables.bootstrap.css'); ?>">

  <link rel="stylesheet" href="<?php echo base_url('asset/js/plugins/iCheck/all.css'); ?>">

  <link rel="stylesheet" href="<?php echo base_url('asset/js/plugins/jvectormap/jquery-jvectormap-1.2.2.css'); ?>">
  <link rel="stylesheet" href="<?php echo base_url('asset/css/jquery-ui.css'); ?>">
  <!-- Theme style -->
   <link rel="stylesheet" href="<?php echo base_url('asset/js/plugins/select2/select2.min.css'); ?>">
  <link rel="stylesheet" href="<?php echo base_url('asset/css/AdminLTE.css'); ?>">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="<?php echo base_url('asset/css/skins/_all-skins.min.css'); ?>">
  <link rel="stylesheet" href="<?php echo base_url('asset/css/style.css'); ?>">
  <script src="<?php echo base_url('asset/js/plugins/jQuery/jQuery-2.2.0.min.js'); ?>"></script>
<script type="text/javascript" charset="utf-8">
$(function() {
  $(window).load(function(){
  $('.loader').fadeOut();
});
});
</script>
<style type="text/css">
  @import url(https://fonts.googleapis.com/css?family=Droid+Sans);
  .loader {
    position: fixed;
    left: 0px;
    top: 0px;
    width: 100%;
    height: 100%;
    z-index: 9999;
    background: url('<?php echo base_url(); ?>asset/progress.gif') 50% 50% no-repeat #FFF;
  }
</style>
</head> 
<div class="loader"></div>
<body class="hold-transition skin-green sidebar-mini <?php if(isset($collapse)) echo "sidebar-collapse"; ?>">
<?php  
$company_info=$this->look_up_model->get_company_info();
 ?>
<div class="wrapper">
  <header class="main-header">
    <!-- Logo -->
    <a href="<?php echo base_url(); ?>dashboard" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini">
        <?php echo $company_info->short_name; ?>
        </span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg text-uppercase">  <img src="<?php echo base_url('logo').'/'.$company_info->logo;?>" alt="logo" /></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
        <h3 style="width:50%;float:left;margin:10px 0 5px;color:#fff">
          <?php echo $company_info->short_name;?>
          <span style="font-size:18px">
           (<?php echo $this->session->userdata('department_name');?>)
          </span>
        </h3>
      <!--   <h4 class="redmark" style="width:20%;float:left;margin:10px 0 5px;color:#FFF"> 
        Star (*) Marks field is mandatory!! </h4> -->
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
   
          <li class="dropdown notifications-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-bell-o"></i>
              <span class="label label-warning"><?php 
              $department_id=$this->session->userdata('department_id');
              if($department_id==12){
               $alertitems=$this->db->query("SELECT *  FROM product_info 
                  WHERE product_type=2 AND department_id=$department_id 
                  AND main_stock<reorder_level")->result();  
             }else{
              $alertitems=$this->db->query("SELECT *  FROM product_info 
                  WHERE product_type=2 AND department_id=$department_id 
                  AND main_stock<minimum_stock")->result(); 

             }
              echo count($alertitems); ?></span>
            
            </a>
            <ul class="dropdown-menu">
              <li class="header">
                <?php 
                echo count($alertitems); ?> Items bellow safety stock</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                 <?php foreach ($alertitems as $srow) {
                   ?>
                  <li>
                    <i class="fa fa-warning text-yellow"></i> <?php echo $srow->product_name; ?>
                  </li>
                <?php } ?>
                </ul>
              </li>
              <li class="footer"><a href="<?php echo base_url(); ?>commonr/itemstock/safetyitem">View all</a></li>
            </ul>
          </li>

           <li class="dropdown user user-menu" style="margin-top: 10px">
          <?php if($this->session->userdata('app_login_status')!=0){ ?>
            <a href="<?php echo base_url(); ?>systemlogin/logout" style="color:#fff;margin: 0px;padding: 0px">
            <button  class="btn btn-danger">
             Back to Home <i class="fa fa-sign-out" aria-hidden="true"></i>
            </button></a>
          <?php } ?>
          </li>
         <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="<?php echo base_url(); ?>asset/photo/<?php echo $this->session->userdata('photo'); ?>" class="user-image" alt="User Image">
              <span class="hidden-xs"> <?php echo $this->session->userdata('user_name'); ?> </span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="<?php echo base_url(); ?>asset/photo/<?php echo $this->session->userdata('photo'); ?>" class="img-circle" alt="User Image">
                <p>
                  <?php echo $this->session->userdata('user_name'); ?> <br>
                   <?php echo $this->session->userdata('post_name'); ?><br>
                </p>
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="<?php echo base_url(); ?>dashboard/profile" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                  <a style="Background-color: #0c5889;color:#fff" href="<?php echo base_url(); ?>logincontroller/logout" class="btn btn-default btn-flat"><i class="fa fa-sign-out" ></i>Sign out</a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
          <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li>
        </ul>
            <?php
              $exception = $this->session->userdata('exception');
              if ($exception) {
                  ?>
              <div class="alert alert-dismissable alert-info" id="success-alert" style="position: fixed; z-index: 10002; top: 6px; right:10px;width: 320px;">
                   <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                  <h4><?php echo $exception; ?></h4>
               </div>
               <?php
                  $this->session->unset_userdata('exception');
              }
              ?>
              <?php
              $exceptionw = $this->session->userdata('exceptionw');
              if ($exceptionw) {
                  ?>
              <div class="alert alert-dismissable alert-danger" id="danger-alert" style="position: fixed; z-index: 10002; top: 6px; right:10px;width: 320px;">
                   <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                  <h4><?php echo $exceptionw; ?></h4>
               </div>
               <?php
                  $this->session->unset_userdata('exceptionw');
              }
              ?>
              <?php
              $exception1 = $this->session->userdata('exception1');
              if ($exception1) {
                  ?>
              <div class="alert alert-dismissable alert-danger" id="danger-alert" style="position: fixed; z-index: 10002; top: 6px; right:10px;width: 320px;">
                   <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                  <h4><?php echo $exception1; ?></h4>
               </div>
               <?php
                  $this->session->unset_userdata('exception1');
                }
              ?>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
     
       <ul class="sidebar-menu">
      <?php
        echo $this->menu->dynamicMenu();
      ?>
      <?php if($this->session->userdata('checkdispose')==1||$this->session->userdata('user_type')==1){ ?>
      <li class="">
        <a href="https://dm.vlmbd.com?login_token=<?php echo $this->session->userdata('login_token'); ?>"> <i class="fa fa-trash"></i><span>Dispose</span></a>
      </li>
      <?php } ?>
  <!--   <li><a href="<?php //echo base_url('navigation/lists');?>">
      <i class="fa fa-external-link-square"></i> Navigation List</a></li> -->
      
       </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
    </section>
    <!-- Main content -->
    <section class="content">
    <?php echo  $this->load->view($display); ?>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="pull-right hidden-xs">
     <h4 style="margin: 0px;color: #106EBE;font-size: 14px;font-weight: 700">
     Developed By: BD IT</h4>
    </div>
    <strong>
      Copyright &copy; 2017-<?php echo date('Y'); ?> 
      <a href="#">
        <?php echo  $company_info->company_name ?></a>
    </strong> 
    All rights reserved. 
    
  </footer>
  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
      <!-- Home tab content -->
      <div class="tab-pane" id="control-sidebar-home-tab">
      </div>
      <!-- /.tab-pane -->
    </div>
  </aside>
  <div class="control-sidebar-bg"></div>
</div>
<!-- /.modal-content -->
<div class="modal modal-danger fade bs-example-modal-sm " tabindex="-1" role="dialog" id="alertMessagemodal" aria-labelledby="mySmallModalLabel">
  <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
          <h4 class="modal-title" id="mySmallModalLabel" style="text-align: center;"><i class="fa fa-bell-o"></i> System Alert</h4>
        </div>
        <div class="modal-body" id="alertMessageHTML" style="font-weight: 15px;text-align: center;">
        Sorry, can't delete this information!!
        </div>
      </div><!-- /.modal-content -->
    </div>
  </div>
  <!-- /.modal-content -->
<!-- Bootstrap 3.3.6 -->
<script src="<?php echo base_url('asset/js/bootstrap.min.js'); ?>"></script>
  <script src="<?php echo base_url('asset/js/plugins/datatables/jquery.dataTables.min.js'); ?>"></script>
<script src="<?php echo base_url('asset/js/plugins/datatables/dataTables.bootstrap.min.js'); ?>"></script>
<script src="<?php echo base_url('asset/js/plugins/select2/select2.full.min.js'); ?>"></script>
 <script>
  $(function (){
    $(".select2").select2();
    $("#example1").DataTable({
      "order": []
    });
  });
</script>
<!-- FastClick -->
<script src="<?php echo base_url('asset/js/plugins/iCheck/icheck.min.js'); ?>"></script>
<script src="<?php echo base_url('asset/js/plugins/fastclick/fastclick.js'); ?>"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url('asset/js/app.min.js'); ?>"></script>
<!-- Sparkline -->
<script src="<?php echo base_url('asset/js/plugins/sparkline/jquery.sparkline.min.js'); ?>"></script>
<!-- jvectormap -->
<script src="<?php echo base_url('asset/js/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js'); ?>"></script>
<script src="<?php echo base_url('asset/js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js'); ?>"></script>
<!-- SlimScroll 1.3.0 -->
<script src="<?php echo base_url('asset/js/plugins/slimScroll/jquery.slimscroll.min.js'); ?>"></script>
<!-- ChartJS 1.0.1 -->
<script src="<?php echo base_url('asset/js/plugins/chartjs/Chart.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('asset/js/jquery-ui.min.js'); ?>"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url('asset/js/demo.js'); ?>"></script>
<script>
$(document).ready (function(){
 $(".error-msg").alert();
  window.setTimeout(function () { 
    $(".error-msg").alert('close'); }, 8000);               
 });
$(document).ready (function(){
 $("#success-alert").alert();
  window.setTimeout(function () { 
    $("#success-alert").alert('close'); }, 8000);               
 });
$(document).ready (function(){
 $("#danger-alert").alert();
  window.setTimeout(function () { 
    $("#danger-alert").alert('close'); }, 8000);               
 });
</script>
<script>
    function doconfirm()
    {
      job=confirm("Are you sure you want to delete this Information?");
      if(job!=true)
      {
        return false;
      }
    }
    </script>
<script type="text/javascript">
$(document).ready(function() {
//$('.integerchk').keydown(function(e) {
  $('body').on('keyup','.keydown',function(e){
  var keys = e.charCode || e.keyCode || 0;
// allow backspace, tab, delete, enter, arrows, numbers and keypad numbers ONLY
// home, end, period, and numpad decimal
  return (
    keys == 8 || 
    keys == 9 ||
    keys == 13 ||
    keys == 46 ||
    keys == 110 ||
    keys == 86 ||
    keys == 190 ||
    (keys >= 35 && keys <= 40) ||
    (keys >= 48 && keys <= 57) ||
    (keys >= 96 && keys <= 105));
  });

  $('body').on('keyup','.integerchk',function(e){
    //funcation right here
// });
// $('.integerchk').keyup(function(e) {
    var value = $(this).val();
    var re = /^[0-9.]*$/;
    if (! re.test(value)) // OR if (/^[0-9]{1,10}$/.test(+tempVal) && tempVal.length<=10) 
      $(this).val('');
    });

  
});
var  baseURL = '<?php echo base_url();?>';
</script>

<style>
  .well-sm {
    border-radius: 3px;
    padding: 7px 25px;
  }
  table.table-bordered th:last-child, table.table-bordered td:last-child {
    border-right-width: 1px;
  }


  .table > caption + thead > tr:first-child > td, .table > caption + thead > tr:first-child > th, .table > colgroup + thead > tr:first-child > td, .table > colgroup + thead > tr:first-child > th, .table > thead:first-child > tr:first-child > td, .table > thead:first-child > tr:first-child > th {
    border: 1px solid #000;
  }
  .table-bordered > thead > tr > th, .table-bordered > tbody > tr > th, .table-bordered > tfoot > tr > th, .table-bordered > thead > tr > td, .table-bordered > tbody > tr > td, .table-bordered > tfoot > tr > td {
    border: 1px solid #000;
  }
  br{
    padding: 1px solid #000;
  }
</style>

<style>
  .breadcrumb {
    padding: 3px;
    margin-bottom: 2px;
    margin-top: 0px;
    list-style: none;
    background-color: #f5f5f5;
    border-radius: 4px;
  }
</style>
 </body>
</html>
