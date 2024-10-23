<!DOCTYPE html>
<html lang="en"><head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<meta charset="utf-8">
</head><body><titlebarcode< title="">
<link href="sasasas_files/labels.htm" rel="stylesheet" type="text/css">
<style>
body {
width: 4.25in;
height: 5.0in;
}
.label{
/* Avery 5160 labels -- CSS and HTML by MM at Boulder Information Services */
width: 1.82in; /* plus .6 inches from padding */
height: 1.in; /* plus .125 inches from padding */
padding: 0in 0.15in ;
text-align: center;
overflow: hidden;
float: left;
}   
 </style>
<?php 
foreach ($lists as  $value) {
 ?>
<div class="label" style="text-align: center;float: left">
    <?php if($value->sn_no != '' || $value->sn_no != NULL) 
        { echo '<img src="'.base_url('dashboard/barcode/'.$value->sn_no).'" alt="" />'; } ?>
</div>
<?php } ?>

</body></html>