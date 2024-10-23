
<style type="text/css">

.tg  {border-collapse:collapse;border-spacing:0;width:100%}
.tg td{
  font-family: 'Hiragino Kaku Gothic Pro', 'WenQuanYi Zen Hei', '微軟正黑體', '蘋果儷中黑', Helvetica, Arial, sans-serif;
  font-size:12px;padding:2px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;text-align: center;}
.tg th{
  font-family: 'Hiragino Kaku Gothic Pro', 'WenQuanYi Zen Hei', '微軟正黑體', '蘋果儷中黑', Helvetica, Arial, sans-serif;
  font-size:12px;font-weight:normal;padding:2px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;font-weight: bold}
.tg .tg-s6z2{text-align:center}
.tg .tg-right{text-align:right;vertical-align:top;padding-right: 20px}
hr{margin: 5px}
.tg1  {border-collapse:collapse;border-spacing:0;width:100%}
.tg1 td{
  font-family: 'Hiragino Kaku Gothic Pro', 'WenQuanYi Zen Hei', '微軟正黑體', '蘋果儷中黑', Helvetica, Arial, sans-serif;
  font-size:12px;padding:2px;overflow:hidden;word-break:normal;line-height: 18px;overflow: hidden;}
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
.error-msg{display: none;}

</style>


<div class="row">
  <div class="col-md-12">
   <div class="content-holder">
   <div class="box box-info" style="padding: 10px">
    <div class="primary_area1">
   <div class="table-responsive table-bordered">
<div  style="width:100%;float:left;font-size: 30px;text-align: center;overflow:hidden;margin:0;margin-top: 0px;">
<p style="margin:0px 0px;color: #538FD4">
<b><?php echo $this->session->userdata('company_name'); ?></b></p>
</div>
 <div style="width:100%;overflow:hidden;text-align:center;margin-top: 0px;">
<p style="line-height: 20px;padding: 0px 5px;font-size: 18px" >
  <b>Project Details
</div>
<hr style="margin-top: 0px">
<table style="width: 100%">
  <tr>
    <th style="text-align: left" > 
     Peject Name:  </th>
    <th style="text-align: left" > 
      <?php if(isset($info)) echo $info->project_name; ?>
     </th>
     <th style="text-align: left" > 
     Department Name:  </th>
    <th style="text-align: left"> 
      <?php if(isset($info)) echo $info->department_name; ?>
     </th>
   </tr>
   <tr>
    <th style="text-align: left" > 
     Requirements :  </th>
    <th style="text-align: left" colspan="3"> 
      <?php if(isset($info)) echo $info->project_requirement; ?>
     </th>
    
   </tr>
   <tr>
    <th style="text-align: left" > 
     Project Co-ordinator:  </th>
    <th style="text-align: left" > 
      <?php if(isset($info)) echo "$info->project_coordinator/$info->project_coordinator2"; ?>
     </th>
     <th style="text-align: left" > 
     Heat:  </th>
    <th style="text-align: left"> 
      <?php if(isset($info)) echo "$info->manpower|$info->money|$info->times|$info->quality"; ?>
     </th>
   </tr>
   <tr>
    <th style="text-align: left" > 
     Priority :  </th>
    <th style="text-align: left" > 
      <?php   if($info->priority==1) echo "Low" ; 
                    elseif($info->priority==2) echo "Medium" ;
                    elseif($info->priority==3) echo "High"; ?>
     </th>
     <th style="text-align: left" > 
     Status:  </th>
    <th style="text-align: left"> 
      <?php if($info->project_status==1) echo "Draft" ; 
            elseif($info->project_status==2) echo "Submit" ;
            elseif($info->project_status==3) echo "Received";
            elseif($info->project_status==4) echo "Waiting";
            elseif($info->project_status==5) echo "Progress";
            elseif($info->project_status==6) echo "Completed";
             ?>
     </th>
   </tr>
   <tr>
    <th style="text-align: left" > 
     Start Date:  </th>
    <th style="text-align: left" > 
      <?php if(isset($info)) echo $info->start_date; ?>
     </th>
     <th style="text-align: left" > 
     End Date:  </th>
    <th style="text-align: left"> 
      <?php if(isset($info)) echo $info->end_date; ?>
     </th>
   </tr>
  <tr>
    <th style="width:20%;text-align: left" > 
     Development Note:  </th>
    <th style="width:50%;text-align: left"> 
      <?php if(isset($info)) echo $info->development_note; ?>
     </th>
    <th style="width:15%;text-align: left" > 
    Special Note: </th>
    <th style="width:15%">
      <?php if(isset($info)) echo $info->special_note; ?>

    </th>
  </tr>
 
  
</table>
<br>

<p style="text-align: left;width: 100%;float: left;overflow: hidden;margin-top: 1px;font-weight: bold;font-size: 20px">Attachment:
      <?php foreach ($detail as  $value) {
        ?>
        <a href="<?php echo base_url(); ?>dashboard/dproject/<?php echo $value->attachemnt_file; ?>">Download</a>
    <?php } ?>
</p>



<br><br>
<table class="tg1" style="overflow: hidden;">
  <tr>
  <td>&nbsp;</td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
</tr>
  <tr>
  <td style="width:50%;text-align:left;">
    <?php if($info->project_status>=2) echo getUserName($info->user_id); ?></td>
  <td style="width:50%;text-align:right;">
  <?php if($info->project_status>=4&&$info->project_status!=8) echo getUserName($info->received_by); ?></td>

  </tr>
  <tr>
  <td style="text-align:left;">
    <?php if($info->project_status>=1) echo findDate($info->submit_date); ?></td>
  <td style="text-align:right;">
  <?php if($info->project_status>=3&&$info->project_status!=8) 
   echo findDate($info->received_date); ?></td>

  </tr>
  <tr>
  <td style="text-align:left;font-size: 15px;line-height: 5px">---------------</td>
  <td style="text-align:right;font-size: 15px;line-height: 5px">----------------</td>
  </tr>
  <tr>
  <td style="text-align:left;">Submitted By:</td>
  <td style="text-align:right;">Received By</td>
  </tr>
</table>
</div>
</div>
</div>
<div class="box-footer">
  <div class="col-sm-12" style="text-align: center;">
    <a class="btn btn-info" href="<?php echo base_url()?><?php echo $controller; ?>/lists">
    <i class="fa fa-arrow-circle-o-left tiny-icon"></i> Back</a>
 
 
  </div>
</div>
</div>
</div>
</div>
