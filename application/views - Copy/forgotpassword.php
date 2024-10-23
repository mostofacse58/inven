<!DOCTYPE html>
<html lang="en">
	<head>
	<meta charset="utf-8">
	<?php  
		$company_info=$this->look_up_model->get_company_info();
	?>
       <title>VLMBD : <?php echo	$company_info->company_name; ?></title>		
       <meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="shortcut icon" href="<?php echo base_url('asset/favicon.ico'); ?>" type="image/x-icon"> 
		<!--web fonts-->
		<!--Load Bootsrap stylesheet  -->
		<link href="<?php echo base_url('bootstrap/css/bootstrap.css');?>" rel="stylesheet" />
		
		<!--Load Fontawesome stylesheet  -->
		<link href="<?php echo base_url('bootstrap/css/font-awesome.css');?>" rel="stylesheet" />
		
		<!--Checkbox stylesheet  -->
		<link href="<?php echo base_url('bootstrap/css/checkbox.css');?>" rel="stylesheet" />		
		
		<!--Load Base stylesheet  -->
		<link href="<?php echo base_url('bootstrap/css/login.css');?>" rel="stylesheet" />
				
		<!--Load Global js plugin -->
		<script src="<?php echo base_url('bootstrap/js/jquery-2.1.1.js');?>"></script>
		
		<!--Load Bootsrap js plugin -->
		<script src="<?php echo base_url('bootstrap/js/bootstrap.js');?>"></script>
	</head>

	<body class="signin">		
	    <form action="<?php echo base_url('');?>logincontroller/reset" method="post">	
		<!-- LOGIN SECTION START -->
		<section class="content_section">
<div class="container wrapper-bg">
	<div class="row">
		<div  class="col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3">
			<div class="panel panel-default panel-signin">
                <div class="panel-heading panel-signin-heading">
            <div class="pull-left logofont">
                <img src="<?php echo base_url("logo/$company_info->logo");?>" alt="ico" />
            </div>
            <div class="">
             <h1 class="panel-title signin-title text-uppercase">  
             	<?php echo	$company_info->company_name; ?></h1>
                    <span style="margin-left:10px;font-size:18px;padding-top: 12px;"> </span>
            </div>								
            </div>
                <div class="panel-body">
                         <div class="row">
							<?php
							$exception = $this->session->userdata('exception');
							if ($exception) {
								?>
								<div class="row">
									<div class="col-md-12">
										<div class="alert alert-danger" id="danger-alert">
											<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
											<?php echo $exception; ?>
										</div>
									</div>
								</div>
								<?php
								$this->session->unset_userdata('exception');
							} ?>
						</div>
                        <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                                    <input type="email"  style="height: 50px;font-size: 26px" value="<?php echo set_value('email_address'); ?>" name="email_address" class="form-control" placeholder="Email Address">
                                </div>
                                 <?php echo form_error('email_address'); ?>
                        </div>
                        <div class="form-group">
                            <div class="pull-left checkbox checkbox-success" id="check-awesome">
                            </div>
                            <div class="pull-right">
                                <input type="submit" name="Login" class="btn btn-green" value="Submit">
                                    <a href="<?php echo base_url('');?>logincontroller" class="btn btn-default">
                                            Back
                                    </a>
                            </div>
                        </div>

                </div>
        </div>
        <div class="copyright text-center text-muted">
        		<span>&copy;  <?php echo $company_info->company_name; ?></span><br />
                <span><a href="http://www.vlmbd.com/" target="_blank" class="text-muted">
                	Developed by: Ventura IT.</a></span>
        </div>
		</div>
	</div>
</div>
</section>
<!-- LOGIN SECTION END -->
</form>

	</body>
</html>


