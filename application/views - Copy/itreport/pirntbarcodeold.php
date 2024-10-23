<!DOCTYPE html>
<html lang="en"><head>
<meta http-equiv="content-type" content=""; charset="UTF-8">
<meta charset="utf-8">
</head><body><titlebarcode< title="">
<style>
body {
width: 8.50in;
}
.label{
    width: 2.0in; /* plus .6 inches from padding */
	height: 1.2in; /* plus .125 inches from padding */
	padding: 0.20in 0.30in;
	text-align: center;
	overflow: hidden;
}   
 </style>
<?php $i=1;
foreach ($lists as  $value) {
 ?>
<div class="label" style="text-align: center;float: left">
    <?php if($value->ventura_code != '' || $value->ventura_code != NULL) 
        { echo '<img src="'.base_url('dashboard/barcode/'.$value->ventura_code).'" alt="" />'; } ?>
        <p style="font-size:11px;margin:0;margin-top: 0px;font-weight: 600;text-align: center;">
    <?php if($value->department_name!='') echo "$value->ventura_code <br>"; echo "$value->asset_encoding";  ?></p>
</div>
<?php $i++; } ?>
</body>
</html>