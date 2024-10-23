<html lang="en"><head><meta charset="UTF-8">
</head>
<body>
<p style="font-size:15px;margin:0px;">
Dear Sir, <br>
Good day. You have below Purchase Indent <br>
<?php foreach ($plist as $value) {
?>
PI NO: <?php echo $value->pi_no; ?> from <?php echo $value->department_name ; ?> department <br>
<?php } ?>
for Approval. please check and approved. 

<a href="<?php echo base_url(); ?>format/pi/lists">Click for Login</a>
<br><br>
Thanks by <br>
Ventura BD IT <br><br>
This is auto generated email from Ventura Inventory Management Software. No Need to Reply.
</body>
</html>