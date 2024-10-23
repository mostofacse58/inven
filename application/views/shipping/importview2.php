  <script src="<?php echo base_url(); ?>asset/js/print.js"></script>

   <script type="text/javascript">
      // When the document is ready, initialize the link so
      // that when it is clicked, the printable area of the
      // page will print.
      $(function(){
        // Hook up the print link.
        $(".prints").attr( "href", "javascript:void(0)");

        $(".prints").click(function(){
            // Print the DIV.
            $(".primary_area" ).print();
            // Cancel click event.
            return( false );
          });
      });
    </script>
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
  .tg  {border-collapse:collapse;border-spacing:0;width: 100%}
.tg td{font-size:14px;font-weight: normal;padding:3px 5px;border-style:solid;border:1px solid #000;overflow:hidden;word-break:normal;}
.tg th{text-align: left;font-size:14px;font-weight:bold;padding:3px 5px;border-style:solid;border:1px solid #000;overflow:hidden;word-break:normal;}
.tg .tg-s6z2{text-align:left;word-wrap: break-word;overflow-wrap: break-word;}
.tg-s6z25{text-align:right;word-wrap: break-word;overflow-wrap: break-word;}
.tg .tg-baqh{text-align:left;word-wrap: break-word;overflow-wrap: break-word;}
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
</style>
<div class="row">
  <div class="col-md-12">
   <div class="box box-info">
         <div class="box-header">
  <div class="widget-block">
    <div class="widget-head">
    <h5><i class="fa fa-eye"></i> 
      <?php echo ucwords($heading); ?>
    </h5>
    <div class="widget-control pull-right">

    </div>
    </div>
    </div>
</div>  
<div class="box-body">
  <div class="primary_area">
<div class="primary_area1">
<div  style="width:100%;float:left;font-size: 30px;text-align: center;overflow:hidden;margin:0;margin-top: 15px;">
<p style="margin:2px 0px;color: #538FD4">
<b> Ventura Leatherware Mfy (BD) Ltd.</b></p>
</div>
<div style="width:100%;overflow:hidden;font-size: 18px;color: #000;text-align:center">
 <p style="margin:0;text-align:center">
  <b>Uttara EPZ, Nilphamari.</b></p>
 </div>
 <p style="margin:0;text-align:center;font-size: 16px;">
  <b><span style="font-family: cursive;font-size: 22px;">e-</span>Import Record </b></p>
  <br><br>

  <table style="width: 100%" class="tg">
  <tr>
    <th class="tg-s6z2"style="width: 30%"><?php echo lang('ex_fty_date'); ?> </th>
    <td class="tg-baqh" style="width: 20%">: <?php echo $info->ex_fty_date; ?></td>
    <th class="tg-baqh" style="width: 30%"><?php echo lang('port_of_loading'); ?>  </th>
    <th class="tg-baqh" style="width: 20%">: <?php echo $info->port_of_loading; ?> </th>
  </tr>
  <tr>
    <th class="tg-s6z2"><?php echo lang('routing'); ?> </th>
    <td class="tg-baqh" >: <?php echo $info->routing; ?></td>
    <th class="tg-s6z2"><?php echo lang('port_of_discharge'); ?> </th>
    <th class="tg-s6z2">: <?php echo $info->port_of_discharge; ?></th>
  </tr>
  <tr>
    <th class="tg-s6z2"><?php echo lang('shipped_qty'); ?> </th>
    <td class="tg-baqh" >: <?php echo $info->shipped_qty; ?></td>
    <th class="tg-s6z2"><?php echo lang('shipping_packages'); ?> </th>
    <th class="tg-s6z2">: <?php echo $info->shipping_packages; ?></th>
  </tr>
  <tr>
    <th class="tg-s6z2"><?php echo lang('building_material'); ?> </th>
    <td class="tg-baqh" >: <?php echo $info->building_material; ?></td>
    <th class="tg-s6z2"><?php echo lang('cutting_die_material'); ?> </th>
    <th class="tg-s6z2">: <?php echo $info->cutting_die_material; ?></th>
  </tr>
  <tr>
    <th class="tg-s6z2"><?php echo lang('machineries_part'); ?> </th>
    <td class="tg-baqh" >: <?php echo $info->machineries_part; ?></td>
    <th class="tg-s6z2"><?php echo lang('others_weight'); ?> </th>
    <th class="tg-s6z2">: <?php echo $info->others_weight; ?></th>
  </tr>
  <tr>
    <th class="tg-s6z2"><?php echo lang('mmk_weight'); ?> </th>
    <td class="tg-baqh" >: <?php echo $info->mmk_weight; ?></td>
    <th class="tg-s6z2"><?php echo lang('mkm_weight'); ?> </th>
    <th class="tg-s6z2">: <?php echo $info->mkm_weight; ?></th>
  </tr>
  <tr>
    <th class="tg-s6z2"><?php echo lang('coach_weight'); ?> </th>
    <td class="tg-baqh" >: <?php echo $info->coach_weight; ?></td>
    <th class="tg-s6z2"><?php echo lang('katespade_weight'); ?> </th>
    <th class="tg-s6z2">: <?php echo $info->katespade_weight; ?></th>
  </tr>
  <tr>
    <th class="tg-s6z2"><?php echo lang('total_consignment'); ?> </th>
    <td class="tg-baqh" >: <?php echo $info->total_consignment; ?></td>

  </tr>
  <tr>
    <th class="tg-s6z2"><?php echo lang('file_no'); ?> </th>
    <th class="tg-s6z2">: <?php echo $info->file_no; ?></th>
    <th class="tg-s6z2"><?php echo lang('season'); ?> </th>
    <td class="tg-baqh" >: <?php echo $info->season; ?></td>
    
  </tr>
  <tr>
    <th class="tg-s6z2"><?php echo lang('customer_name'); ?> </th>
    <th class="tg-s6z2">: <?php echo $info->customer_name; ?></th>
    <th class="tg-s6z2"><?php echo lang('supplier'); ?> 1 </th>
    <td class="tg-baqh" >: <?php echo $info->supplier_name; ?></td>
    
  </tr>
  <tr>
    <th class="tg-s6z2"><?php echo lang('invoice_no'); ?> </th>
    <th class="tg-s6z2">: <?php echo $info->invoice_no; ?></th>
    <th class="tg-s6z2"><?php echo lang('invoice_date'); ?> </th>
    <th class="tg-s6z2">: <?php echo $info->invoice_date; ?></th>
  </tr>
  <tr>
    <th class="tg-s6z2"><?php echo lang('invoice_amount'); ?> </th>
    <td class="tg-baqh" >: <?php echo $info->invoice_amount; ?></td>
    <th class="tg-s6z2"><?php echo lang('supplier'); ?> 2</th>
    <th class="tg-s6z2">: <?php echo $info->supplier_name2; ?></th>
  </tr>
  <tr>
    <th class="tg-s6z2"><?php echo lang('hk_re_export_inv'); ?> </th>
    <td class="tg-baqh" >: <?php echo $info->hk_re_export_inv; ?></td>
    <th class="tg-s6z2"><?php echo lang('shipping_terms'); ?> </th>
    <th class="tg-s6z2">: <?php echo $info->shipping_terms; ?></th>
  </tr>
  <tr>
    <th class="tg-s6z2"><?php echo lang('vessel_voyage'); ?> </th>
    <td class="tg-baqh" >: <?php echo $info->vessel_voyage; ?></td>
    <th class="tg-s6z2"><?php echo lang('carrier_name'); ?> </th>
    <th class="tg-s6z2">: <?php echo $info->carrier_name; ?></th>
  </tr>
  <tr>
    <th class="tg-s6z2"><?php echo lang('etd_port'); ?> </th>
    <td class="tg-baqh" >: <?php echo $info->etd_port; ?></td>
    <th class="tg-s6z2"><?php echo lang('eta_port'); ?> </th>
    <th class="tg-s6z2">: <?php echo $info->eta_port; ?></th>
  </tr>
  <tr>
    <th class="tg-s6z2"><?php echo lang('port_to_port'); ?> </th>
    <td class="tg-baqh" >: <?php echo $info->port_to_port; ?> days</td>
    <th class="tg-s6z2"><?php echo lang('bl_no'); ?> </th>
    <th class="tg-s6z2">: <?php echo $info->bl_no; ?></th>
  </tr>
  <tr>
    <th class="tg-s6z2"><?php echo lang('obl_no'); ?> </th>
    <td class="tg-baqh" >: <?php echo $info->obl_no; ?></td>
    <th class="tg-s6z2"><?php echo lang('container_no'); ?> </th>
    <th class="tg-s6z2">: <?php echo $info->container_no; ?></th>
  </tr>
  <tr>
    <th class="tg-s6z2"><?php echo lang('number_of_consignment'); ?> </th>
    <td class="tg-baqh" >: <?php echo $info->number_of_consignment; ?></td>
    <th class="tg-s6z2"><?php echo lang('korea_to_hkg_port'); ?> </th>
    <th class="tg-s6z2">: <?php echo $info->korea_to_hkg_port; ?></th>
  </tr>
  <tr>
    <th class="tg-s6z2"><?php echo lang('trucking_fee'); ?> </th>
    <td class="tg-baqh" >: <?php echo $info->trucking_fee; ?></td>
    <th class="tg-s6z2"><?php echo lang('freight_amount'); ?> </th>
    <th class="tg-s6z2">: <?php echo $info->freight_amount; ?></th>
  </tr>
  <tr>
    <th class="tg-s6z2"><?php echo lang('air_building_material_freight'); ?> </th>
    <td class="tg-baqh" >: <?php echo $info->air_building_material_freight; ?></td>
    <th class="tg-s6z2"><?php echo lang('air_cutting_die_material_freight'); ?> </th>
    <th class="tg-s6z2">: <?php echo $info->air_cutting_die_material_freight; ?></th>
  </tr>
  <tr>
    <th class="tg-s6z2"><?php echo lang('air_machineries_part_freight'); ?> </th>
    <td class="tg-baqh" >: <?php echo $info->air_machineries_part_freight; ?></td>
    <th class="tg-s6z2"><?php echo lang('air_others_freight'); ?> </th>
    <th class="tg-s6z2">: <?php echo $info->air_others_freight; ?></th>
  </tr>
  <tr>
    <th class="tg-s6z2"><?php echo lang('air_mmk_freight'); ?> </th>
    <td class="tg-baqh" >: <?php echo $info->air_mmk_freight; ?></td>
    <th class="tg-s6z2"><?php echo lang('air_mkm_freight'); ?> </th>
    <th class="tg-s6z2">: <?php echo $info->air_mkm_freight; ?></th>
  </tr>
  <tr>
    <th class="tg-s6z2"><?php echo lang('air_coach_freight'); ?> </th>
    <td class="tg-baqh" >: <?php echo $info->air_coach_freight; ?></td>
    <th class="tg-s6z2"><?php echo lang('air_katespade_freight'); ?> </th>
    <th class="tg-s6z2">: <?php echo $info->air_katespade_freight; ?></th>
  </tr>
  <tr>
    <th class="tg-s6z2"><?php echo lang('export_declaration'); ?> </th>
    <td class="tg-baqh" >: <?php echo $info->export_declaration; ?></td>
    <th class="tg-s6z2"><?php echo lang('air_reason_record'); ?> </th>
    <th class="tg-s6z2">: <?php echo $info->air_reason_record; ?></th>
  </tr>
  <tr>
    <th class="tg-s6z2"><?php echo lang('courier_freight_usd'); ?> </th>
    <td class="tg-baqh" >: <?php echo $info->courier_freight_usd; ?></td>
    <th class="tg-s6z2"><?php echo lang('cnf_from_broker_tkd'); ?> </th>
    <th class="tg-s6z2">: <?php echo $info->cnf_from_broker_tkd; ?></th>
  </tr>
  <tr>
    <th class="tg-s6z2"><?php echo lang('logistics_charges_tkd'); ?> </th>
    <td class="tg-baqh" >: <?php echo $info->logistics_charges_tkd; ?></td>
    <th class="tg-s6z2"><?php echo lang('bd'); ?> <?php echo lang('air_building_material_freight'); ?> </th>
    <th class="tg-s6z2">: <?php echo $info->local_building_material_freight; ?></th>
  </tr>
  <tr>
    <th class="tg-s6z2"><?php echo lang('bd'); ?> <?php echo lang('air_cutting_die_material_freight'); ?> </th>
    <td class="tg-baqh" >: <?php echo $info->local_cutting_die_material_freight; ?></td>
    <th class="tg-s6z2"><?php echo lang('bd'); ?>  <?php echo lang('air_machineries_part_freight'); ?> </th>
    <th class="tg-s6z2">: <?php echo $info->local_machineries_part_freight; ?></th>
  </tr>
  <tr>
    <th class="tg-s6z2"><?php echo lang('bd'); ?> <?php echo lang('air_others_freight '); ?> </th>
    <td class="tg-baqh" >: <?php echo $info->local_others_freight; ?></td>
    <th class="tg-s6z2"><?php echo lang('bd'); ?>  <?php echo lang('air_mkm_freight'); ?> </th>
    <th class="tg-s6z2">: <?php echo $info->local_mmk_freight; ?></th>
  </tr>
  <tr>
    <th class="tg-s6z2"><?php echo lang('bd'); ?> <?php echo lang('air_mkm_freight'); ?> </th>
    <td class="tg-baqh" >: <?php echo $info->local_mkm_freight; ?></td>
    <th class="tg-s6z2"><?php echo lang('bd'); ?>  <?php echo lang('air_coach_freight'); ?> </th>
    <th class="tg-s6z2">: <?php echo $info->local_coach_freight; ?></th>
  </tr>
  <tr>
    <th class="tg-s6z2"><?php echo lang('bd'); ?>  <?php echo lang('air_katespade_freight'); ?> </th>
    <th class="tg-s6z2">: <?php echo $info->local_katespade_freight; ?></th>
    <th class="tg-s6z2"> <?php echo lang('eta_uttara_factory'); ?> </th>
    <td class="tg-baqh" >: <?php echo $info->eta_uttara_factory; ?></td>
  </tr>
  <tr>
    <th class="tg-s6z2"><?php echo lang('eta_cgp_to_fty'); ?> </th>
    <td class="tg-baqh" >: <?php echo $info->eta_cgp_to_fty; ?></td>
    <th class="tg-s6z2"><?php echo lang('exception_remarks'); ?> </th>
    <th class="tg-s6z2">: <?php echo $info->exception_remarks; ?></th>
  </tr>
     
  <tr>
    <?php if($info->attachment!=''){ ?>
    <th class="tg-s6z2" valign="top">
    Attachment:
    </th>
    <td class="tg-baqh" valign="top">: 
      <a href="<?php echo base_url(); ?>dashboard/gatepassExcel/<?php echo $info->attachment; ?>">Download</a>
    </td>
    <?php } ?>
    
  </tr>
  </table>
 




<br>

  <table style="width:100%">
  <tr>
    <td style="text-align:left;width: 33%">
      <?php if($info->import_status>=2){ echo $info->user_name; 
        echo "<br>"; echo findDate($info->issue_date); }
      ?></td>
     <td style="text-align:center;width: 33%">
      <?php if($info->import_status>=4) {
        echo $info->received_by_name; 
          echo "<br>";
          echo findDate($info->received_date);
        }
        ?>
    </td>
     <td style="text-align:right;width: 33%">
      <?php if($info->import_status>=3) {
        echo $info->approved_by_name; 
          echo "<br>";
          echo findDate($info->approved_date);
        }
        ?>
      </td>
  </tr>
  <tr>
     <td style="text-align:left;font-size:15px;line-height:5px">
     ---------------------------------</td>
     <td style="text-align:center;font-size:15px;line-height:5px">
     --------------------------------</td>
     <td style="text-align:right;font-size:15px;line-height:5px">
     --------------------------------</td>
  </tr>
  <tr>
  <td style="text-align:left">PREPARED BY</td>
  <td style="text-align:center;">RECEIVED BY</td>
  <td style="text-align:right">APPROVED BY</td>
  </tr>
</table>
<br>
<p style="margin:0;text-align:center">
<?php echo $this->session->userdata('caddress'); ?>                   
</p>
  <!-- ///////////////////// -->
</div>
</div>
</div>
  <!-- /.box-body -->
  <div class="box-footer">
     <div class="col-sm-6"><a href="<?php echo base_url(); ?>cc/<?php echo $controller; ?>/lists" class="btn btn-info"> <i class="fa fa-arrow-circle-o-left" aria-hidden="true"></i> Back</a>
     <button class="btn btn-info prints"><i class="fa fa-print" ></i> Print</button>
   </div>
    </div>
       
    </div>
  </div>
  <!-- /.box-footer -->
</div>
