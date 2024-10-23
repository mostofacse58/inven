<html lang="en"><head><meta charset="UTF-8">
</head>
<body>
<p style="font-size:15px;margin:0px;">
Dear Sir, <br>
Good day. You have below Asset lists for Plan Maintenance today, <br>
<?php foreach ($lists as $value) {
?>
CODE NO: <?php echo $value->tpm_code; ?>  <br>
<?php } ?>
. please check... <br>
<a href="<?php echo base_url(); ?>pm/maintenance/lists">Click for Login</a>
<br><br>
Thanks by <br>
Ventura BD IT <br><br>
This is auto generated email from Ventura Inventory Management Software. No Need to Reply.
</body>
</html>
