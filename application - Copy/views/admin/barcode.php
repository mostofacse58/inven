<!DOCTYPE html>
<html lang="en"><head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<meta charset="utf-8">
</head><body><titlebarcode< title="">
<link href="sasasas_files/labels.htm" rel="stylesheet" type="text/css">
<style>
body {
width: 4.2in;
height: 5.0in;
}
.label{
/* Avery 5160 labels -- CSS and HTML by MM at Boulder Information Services */
width: 2in; /* plus .6 inches from padding */
height: 1.0in; /* plus .125 inches from padding */
padding: 0.27in 0.05in ;
text-align: center;
overflow: hidden;
float: left;
}   
 </style>
<?php foreach ($details as  $value) {
 ?>
<div class="label" style="text-align: center;float: left">
    <?php if($value->tpm_serial_code != '' || $value->tpm_serial_code != NULL) 
        { echo '<img src="'.base_url('dashboard/barcode/ASASASA45455645SAS').'" alt="" />'; } ?>
</div>
<?php } ?>

</body></html>