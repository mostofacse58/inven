<!DOCTYPE html>
<html lang="en"><head>
<meta http-equiv="content-type" content=""; charset="UTF-8">
<meta charset="utf-8">
</head><body><titlebarcode< title="">
<!-- <link href="sasasas_files/labels.htm" rel="stylesheet" type="text/css"> -->
<style>
body {
width: 8.50in;
}
.label{
    width: 2.0in; /* plus .6 inches from padding */
	height: 1.2in; /* plus .125 inches from padding */
	padding: 0.25in 0.30in;
	text-align: center;
	overflow: hidden;
}   
 </style>
<?php 
foreach ($lists as  $value) {
 ?>
<div class="label" style="text-align: center;float: left">
    <?php if($value->sn_no != '' || $value->sn_no != NULL) 
        { echo '<img src="'.base_url('dashboard/barcode/'.$value->sn_no).'" alt="" />'; } ?>
        <p style="font-size:14px;margin:0;margin-top: 0px;font-weight: 600;text-align: center;">
    <?php echo $value->user_no; ?></p>
</div>
<?php } ?>

</body></html>