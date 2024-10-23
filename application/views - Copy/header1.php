<html>
<div style="width:25%;float:left;overflow:hidden;">
   <span class="logo-lg text-uppercase">  
    <img style="width:100%;" src="<?php echo base_url('logo').'/'.$this->session->userdata('logo');?>" />
  </span>
</div>
<div  style="width:75%;float:left;font-size: 40px;;overflow:hidden;margin:0;margin-top: 28px;"><p style="margin:2px 0px">
<b> <?php echo  $this->session->userdata('company_name'); ?></b></p>
</div>
<div style="width:50%;margin-top:-30px;margin-left:46%;overflow:hidden;font-size: 19.5px;color: #797c80;">
 <p style="margin:0;"><b><i>We Build Your Future Into Reality</i></b></p>
 </div>
<div style="width:80%;margin-left:20%;overflow:hidden;font-size: 12px;color: #000;text-align:center">
 <p style="margin:0;text-align:center"><?php echo  $this->session->userdata('caddress'); ?>.
  E-mail:<?php echo  $this->session->userdata('cemail_address'); ?>.
  Website:<?php echo  $this->session->userdata('website'); ?></p>
 </div>
 </html>