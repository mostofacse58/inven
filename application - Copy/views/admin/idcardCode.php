<!DOCTYPE html>
<html lang="en"><head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<meta charset="utf-8">
<style>
body {
   width: 100%;
}
   
.label2{
width: 2in; /* plus .6 inches from padding */
height: 2in; /* plus .125 inches from padding */
padding: 0.1in ;
text-align: center;
overflow: hidden;
float: left;
} 
 </style>
</head>
<body>
<titlebarcode< title="">
<?php
$i=1;
foreach ($details as  $value) {
 ?>
<div class="label2" style="text-align: center;">
	<img style="width: 1.5in;height: 1.5in" class="imgl" src="<?php echo $this->look_up_model->qcode_functionHCM($value->employee_id,'L',1000); ?>" alt="">
    <p style="font-size:14px;margin:0;margin-top: -10px;font-weight: 600">
    <?php echo $value->employee_cardno; ?></p>
</div>

<?php
} ?>

</body>
</html>