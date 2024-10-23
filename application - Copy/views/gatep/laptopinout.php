<style>
@media print{
    .print{ display:none;}
    .approval_panel{ display:none;}
     .margin_top{ display:none;}
    .rowcolor{ background-color:#CCCCCC !important;}
    body {
      font-size:14px;
      padding: 3px;
     }
    }
  .tg  {
    border-collapse:collapse;
    border-spacing:0;width: 100%;
   }
.tg td{font-size:14px;
  font-weight: normal;
  padding:3px 5px;
  border-style:solid;
  border:1px solid #000;
  overflow:hidden;
  word-break:normal;
}
.tg th{text-align: left;
  font-size:14px;
  font-weight:bold;
  padding:3px 5px;
  border-style:solid;
  border:1px solid #000;
  overflow:hidden;
  word-break:normal;
}
.tg .tg-s6z2{text-align:left}
.tg-s6z25{text-align:right;}
tbody{margin: 0;
  padding: 0}
.primary_area1{
  background-color: #fff;
  border-top: 5px dotted #000;
  border-bottom: 5px dotted #000;
  box-shadow: inset 0 -2px 0 0 #000, inset 0 2px 0 0 #000, 0 2px 0 0 #000, 0 -2px 0 0 #000;
  margin-bottom: 1px;
  padding: 10px;
  border-left: 5px;
  border-right: 5px;
  border-left-style:double ;
  border-right-style:double;
  padding-top:0px;
}
.form-group.required .control-label:after { 
     content:"*";
     color:red;
  }
  .well-sm {
  border-radius: 3px;
  padding: 7px 25px;
}
table td{text-align: left;}
.textcenter{text-align: center;}
</style>

<div class="row">
  <div class="col-md-12">
    <div class="panel panel-success">
      <div class="box-header">
              <div class="widget-block">
             
<div class="widget-head">
<h5><?php echo ucwords($heading); ?></h5>
</div>
</div>
</div>
   <div class="box box-info">
    <!-- /.box-header -->
      <!-- form start -->
      <form class="form-horizontal" action="<?php echo base_url();?>gatep/laptopinout/search" method="POST">
        <div class="box-body">
         <div class="form-group">
          <label class="col-sm-3 control-label" style="margin-top: 20px">SCAN CODE<span style="color:red;">  </span></label>
            <div class="col-sm-6">
              <div class="col-md-12" id="sticker" style="width: 100%; z-index: 2;">
                <div class="well well-sm">
                  <div class="form-group" style="margin-bottom:0;">
                    <div class="input-group wide-tip">
                    <div class="input-group-addon" style="padding-left: 10px; padding-right: 10px;">
                    <i class="fa fa-2x fa-barcode addIcon"></i></div>
                      <input name="sn_no" value="" class="form-control input-lg" id="sn_no" autofocus="autofocus" placeholder="Please scan CODE" tabindex="1" type="text" autocomplete="off">
                <div class="input-group-addon" style="padding-left: 10px; padding-right: 10px;">
              </div>
            </div>
            </div>
          <div class="clearfix"></div>
        </div>
      </div>
      </div>
     </div><!-- ///////////////////// -->
      </div>
     <!-- /.box-body -->
  </form>
<?php if(isset($info)){ ?>
<div class="row">
  <div class="col-md-6 col-md-offset-3">
<div class="box box-primary">
<div class="box-body">
   <?php if(count($info)>0){  ?>
    <div class="alert alert-success alert-dismissable" id="success-alert" style="text-align:center">
    <strong style="font-size:20px">This Laptop is Valid and  
      <?php if($chk==1) 
      echo "OUT"; 
      elseif($chk==2) 
        echo "IN";
      elseif($chk==3)
      echo "Already Out ";
      elseif($chk==4)
      echo "Already In";
      ?> !</strong> 
  </div>
  <div class="primary_area1">
 <p style="margin:0;text-align:center;font-size: 16px;">
  <b><span style="font-family: cursive;font-size: 22px;">
  e-</span>LAPTOP GATE PASS </b></p>
  <p style="margin:0;text-align:center;font-size: 22px;">
  User Name: <?php echo " $info->employee_name"; ?></p>
  <p style="margin:0;text-align:center;font-size: 22px;">
  SN NO: <?php echo "$info->sn_no" ?></p>
<br>
<!-- ///////////////////// -->
</div>
<script type="text/javascript">
  $(document).ready(function() {
    var urlList='<?php echo base_url('gatep/laptopinout/searchTypem');?>'; 
   setTimeout(function(){
    document.location=urlList;
    },10000 );
   });
</script>
  <?php }else{ ?>
  <div class="alert alert-danger alert-dismissable"  id="danger-alert" style="text-align:center">
    <strong style="font-size:25px">This Laptop Not Found!</strong> 
  </div>
  <?php } ?>
  </div>
</div>
</div>
</div>
  <?php } ?>
  </div>
</div>
</div>
</div>
 