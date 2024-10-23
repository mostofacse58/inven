<!DOCTYPE html>
<html lang="en"><head>
<meta http-equiv="content-type" content=""; charset="UTF-8">
<meta charset="utf-8">
</head><body><title>Qcode  </title>
<style>
body {
width: 10.50in;
}
.label{
    width: 2.5in; /* plus .6 inches from padding */
	height: 2.5in; /* plus .125 inches from padding */
	padding: 0.20in 0.30in;
	text-align: center;
	overflow: hidden;
}   
 </style>
<?php $i=1;
foreach ($lists as  $value) {
	$code=' File:'.$value->file_no.'
	Style No(款号):'.$value->style_no.'
	Color(颜色):'.$value->color_name.'
	Quantity(数量):'.$value->quantity.'PCs'.	'
	Workshop(生产车间):'.$value->floor_no.'
	Line No(组别): '.$value->line_no; 
 ?>
<div class="label" style="text-align: center;float: left">
    <img src="<?php echo $this->look_up_model->qcode_functiongoods($code,'L',5); ?>">
</div>
<?php $i++; } ?>
</body>
</html>