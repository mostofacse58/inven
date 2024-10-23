<!DOCTYPE html>
<html lang="en"><head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<meta charset="utf-8">
<style>
body {
   width: 4.25in;
}
.label1{
width: 1.7in; /* plus .6 inches from padding */
height: 1.7in; /* plus .125 inches from padding */
padding: 0.45in 0.80in 0.45in 0.01in ;
text-align: center;
overflow: hidden;
float: left;
}   
.label2{
width: 1.7in; /* plus .6 inches from padding */
height: 1.7in; /* plus .125 inches from padding */
padding: 0.45in 0.001in 0.45in 0.01in ;
text-align: center;
overflow: hidden;
float: left;
} 
 </style>
</head>
<body>
<titlebarcode< title="">
<!-- <link href="sasasas_files/labels.htm" rel="stylesheet" type="text/css"> -->

<?php $i=1;

foreach ($details as  $value) {
if($i%2==0){
 ?>
<div class="label2" style="text-align: center;">
	<img class="imgl" src="<?php echo $this->look_up_model->qcode_function($value->tpm_serial_code,'L',10); ?>" alt="">
    <p style="font-size:14px;margin:0;margin-top: -10px;font-weight: 600">
    <?php echo $value->tpm_serial_code; ?></p>
</div>
<?php }else{ ?>
<div class="label1" style="text-align: center;">
	<img class="imgl" src="<?php echo $this->look_up_model->qcode_function($value->tpm_serial_code,'L',10); ?>" alt="">
    <p style="font-size:14px;margin:0;margin-top: -10px;font-weight: 600">
    <?php echo $value->tpm_serial_code; ?></p>
</div>

<?php

} 
$i++;
} ?>

</body>
</html>