<?php 
$name="Import_Excel_Report_".date('Y-m-dhi').".xls";
header('Content-Disposition: attachement; filename="' .$name. '"');
header("Pragma: no-cache");
header("Expires: 0");
?>
<html>
<style type="text/css">
   @media print{
    .print{ display:none;}
    .approval_panel{ display:none;}
     .margin_top{ display:none;}
    .rowcolor{ background-color:#CCCCCC !important;}
    body{
      font-size:14px;
      padding: 3px;
     }
    }
  .tg  {border-collapse:collapse;border-spacing:0;width: 100%}
.tg td{font-size:14px;font-weight: normal;padding:3px 5px;border-style:solid;border:1px solid #000;overflow:hidden;word-break:normal;}
.tg th{text-align: left;font-size:14px;font-weight:bold;padding:3px 5px;border-style:solid;border:1px solid #000;overflow:hidden;word-break:normal;}
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
</style>
<body>
  <br>

  <!-- ///////////////////// -->
<br>
  <table class="tg" style="width: 100%">
  <tr>
    <th style="text-align:center;width:4%;">SN</th>
    <th style="text-align:center;width:10%">Import No</th>
    <th style="text-align:center;width:10%">Ex-fty date</th>
	<th style="text-align:center;width:10%">Port of Loading</th>
	<th style="text-align:center;width:10%">ROUTING</th>
	<th style="text-align:center;width:10%">Port of Discharge</th>
	<th style="text-align:center;width:10%">Shipped Qty</th>
	<th style="text-align:center;width:10%">The Consignment shipping number of packages </th>
	<th style="text-align:center;width:10%">Building materials of weight (KGS)</th>
	<th style="text-align:center;width:10%">Cutting die materials of weight (KGS)</th>
	<th style="text-align:center;width:10%">Machineries /Spare part of weight (KGS)</th>
	<th style="text-align:center;width:10%">Others of weight (KGS)</th>
	<th style="text-align:center;width:10%">MMK of weight (KGS)</th>
	<th style="text-align:center;width:10%">MKM of weight (KGS)</th>
	<th style="text-align:center;width:10%">COACH of weight (KGS)</th>
	<th style="text-align:center;width:10%">KATE SPADE of weight (KGS)</th>
	<th style="text-align:center;width:10%">Total  Consignment shipment weight(KGS)</th>
	<th style="text-align:center;width:10%">file/so#</th>
	<th style="text-align:center;width:10%">Season</th>
	<th style="text-align:center;width:10%">Customer (MK-W.MK-M,MK-SLG, BR.KS,MIMCO) </th>
	<th style="text-align:center;width:10%">Supplier</th>
	<th style="text-align:center;width:10%">Invoice.no.</th>
	<th style="text-align:center;width:10%">Invoice .date</th>
	<th style="text-align:center;width:10%">Invoice Amount (USD)</th>
	<th style="text-align:center;width:10%">Supplier</th>
	<th style="text-align:center;width:10%">HK Re-export Inv.</th>
	<th style="text-align:center;width:10%">Shipping Terms</th>
	<th style="text-align:center;width:10%">Vessel/Voyage </th>
	<th style="text-align:center;width:10%">Carrier.</th>
	<th style="text-align:center;width:10%">ETD.Port </th>
	<th style="text-align:center;width:10%">ETA.Port </th>
	<th style="text-align:center;width:10%">Port to Port T/T(Days) </th>
	<th style="text-align:center;width:10%">B/L NO./HAWB</th>
	<th style="text-align:center;width:10%">OBL.NO./MAWB#</th>
	<th style="text-align:center;width:10%">CONTAINER NO. </th>
	<th style="text-align:center;width:10%">Number of Consignment</th>
	<th style="text-align:center;width:10%">Korea or HCM to HKG port of Freight(USD)</th>
	<th style="text-align:center;width:10%">Trucking fee (from CN to HK) (USD)</th>
	<th style="text-align:center;width:10%">Freight Amount (AIR OR SEA) (USD) </th>
	<th style="text-align:center;width:10%">Building materials of Freight (USD) </th>
	<th style="text-align:center;width:10%">Cutting die materials of Freight (USD) </th>
	<th style="text-align:center;width:10%">Machineries /Spare part of Freight (USD) </th>
	<th style="text-align:center;width:10%">Others of Freight (USD) </th>
	<th style="text-align:center;width:10%">MMK of Freight (USD) </th>
	<th style="text-align:center;width:10%">MKM of Freight (USD) </th>
	<th style="text-align:center;width:10%">COACH of Freight (USD) </th>
	<th style="text-align:center;width:10%">KATE SPADE of Freight (USD) </th>
	<th style="text-align:center;width:10%">Export declaration</th>
	<th style="text-align:center;width:10%">AIR REASON RECORD</th>
	<th style="text-align:center;width:10%">COURIER FREIGHT( DHL/TNT/ ROYALE..)PAY BY BD A/C (USD)</th>
	<th style="text-align:center;width:10%">CNF /others from BD Broker (TKD)</th>
	<th style="text-align:center;width:10%">Logistics (Trucking) charges paid at BD (TKD)</th>
	<th style="text-align:center;width:10%">UEPZ Gate Tips</th>
	<th style="text-align:center;width:10%">Building materials of Freight (USD) </th>
	<th style="text-align:center;width:10%">Cutting die materials of Freight (USD) </th>
	<th style="text-align:center;width:10%">Machineries /Spare part of Freight (USD) </th>
	<th style="text-align:center;width:10%">Others of Freight (USD) </th>
	<th style="text-align:center;width:10%">MMK of Freight (USD) </th>
	<th style="text-align:center;width:10%">MKM of Freight (USD) </th>
	<th style="text-align:center;width:10%">COACH of Freight (USD) </th>
	<th style="text-align:center;width:10%">KATE SPADE of Freight (USD) </th>
	<th style="text-align:center;width:10%">Eta uttara factory </th>
	<th style="text-align:center;width:10%">ETA CGP TO FTY T/T Days</th>
	<th style="text-align:center;width:10%">Exception remarks</th>

  </tr>
    <?php $grandtotal=0;
    if(isset($lists)&&!empty($lists)): 
      $i=1;
      foreach($lists as $row):
        ?>
        <tr>
            <td style="vertical-align: middle;">
            <?php echo $i++; ?></td>
            <td style="vertical-align: middle;"><?php echo $row->import_number; ?></td>
            <td style="vertical-align: middle;"><?php echo $row->ex_fty_date; ?></td>
            <td style="vertical-align: middle;"><?php echo $row->port_of_loading; ?></td>
            <td style="vertical-align: middle;"><?php echo $row->routing; ?></td>
            <td style="vertical-align: middle;"><?php echo $row->port_of_discharge; ?></td>
            <td style="vertical-align: middle;"><?php echo $row->shipped_qty; ?></td>
            <td style="vertical-align: middle;"><?php echo $row->shipping_packages; ?></td>
            <td style="vertical-align: middle;"><?php echo $row->building_material; ?></td>
            <td style="vertical-align: middle;"><?php echo $row->cutting_die_material; ?></td>
            <td style="vertical-align: middle;"><?php echo $row->machineries_part; ?></td>
            <td style="vertical-align: middle;"><?php echo $row->others_weight; ?></td>
            <td style="vertical-align: middle;"><?php echo $row->mmk_weight; ?></td>
            <td style="vertical-align: middle;"><?php echo $row->mkm_weight; ?></td>
            <td style="vertical-align: middle;"><?php echo $row->coach_weight; ?></td>
            <td style="vertical-align: middle;"><?php echo $row->katespade_weight; ?></td>
            <td style="vertical-align: middle;"><?php echo $row->total_consignment; ?></td>
            <td style="vertical-align: middle;"><?php echo $row->file_no; ?></td>
            <td style="vertical-align: middle;"><?php echo $row->season; ?></td>
            <td style="vertical-align: middle;"><?php echo $row->customer_name; ?></td>
            <td style="vertical-align: middle;"><?php echo $row->supplier_name; ?></td>
            <td style="vertical-align: middle;"><?php echo $row->invoice_no; ?></td>
            <td style="vertical-align: middle;"><?php echo $row->invoice_date; ?></td>
            <td style="vertical-align: middle;"><?php echo $row->invoice_amount; ?></td>
            <td style="vertical-align: middle;"><?php echo $row->supplier_name2; ?></td>
            <td style="vertical-align: middle;"><?php echo $row->hk_re_export_inv; ?></td>
            <td style="vertical-align: middle;"><?php echo $row->shipping_terms; ?></td>
            <td style="vertical-align: middle;"><?php echo $row->vessel_voyage; ?></td>
            <td style="vertical-align: middle;"><?php echo $row->carrier_name; ?></td>
            <td style="vertical-align: middle;"><?php echo $row->etd_port; ?></td>
            <td style="vertical-align: middle;"><?php echo $row->eta_port; ?></td>
            <td style="vertical-align: middle;"><?php echo $row->port_to_port; ?></td>
            <td style="vertical-align: middle;"><?php echo $row->bl_no; ?></td>
            <td style="vertical-align: middle;"><?php echo $row->obl_no; ?></td>
            <td style="vertical-align: middle;"><?php echo $row->container_no; ?></td>
            <td style="vertical-align: middle;"><?php echo $row->number_of_consignment; ?></td>
            <td style="vertical-align: middle;"><?php echo $row->korea_to_hkg_port; ?></td>
            <td style="vertical-align: middle;"><?php echo $row->trucking_fee; ?></td>
            <td style="vertical-align: middle;"><?php echo $row->freight_amount; ?></td>
            <td style="vertical-align: middle;"><?php echo $row->air_building_material_freight; ?></td>
            <td style="vertical-align: middle;"><?php echo $row->air_cutting_die_material_freight; ?></td>
            <td style="vertical-align: middle;"><?php echo $row->air_machineries_part_freight; ?></td>
            <td style="vertical-align: middle;"><?php echo $row->air_others_freight; ?></td>
            <td style="vertical-align: middle;"><?php echo $row->air_mmk_freight; ?></td>
            <td style="vertical-align: middle;"><?php echo $row->air_mkm_freight; ?></td>
            <td style="vertical-align: middle;"><?php echo $row->air_coach_freight; ?></td>
            <td style="vertical-align: middle;"><?php echo $row->air_katespade_freight; ?></td>
            <td style="vertical-align: middle;"><?php echo $row->export_declaration; ?></td>
            <td style="vertical-align: middle;"><?php echo $row->air_reason_record; ?></td>
            <td style="vertical-align: middle;"><?php echo $row->courier_freight_usd; ?></td>
            <td style="vertical-align: middle;"><?php echo $row->cnf_from_broker_tkd; ?></td>
            <td style="vertical-align: middle;"><?php echo $row->logistics_charges_tkd; ?></td>
            <td style="vertical-align: middle;"><?php echo $row->uepz_gate_tips; ?></td>
            <td style="vertical-align: middle;"><?php echo $row->local_building_material_freight; ?></td>
            <td style="vertical-align: middle;"><?php echo $row->local_cutting_die_material_freight; ?></td>
            <td style="vertical-align: middle;"><?php echo $row->local_machineries_part_freight; ?></td>
            <td style="vertical-align: middle;"><?php echo $row->local_others_freight; ?></td>
            <td style="vertical-align: middle;"><?php echo $row->local_mmk_freight; ?></td>
            <td style="vertical-align: middle;"><?php echo $row->local_mkm_freight; ?></td>
            <td style="vertical-align: middle;"><?php echo $row->local_coach_freight; ?></td>
            <td style="vertical-align: middle;"><?php echo $row->local_katespade_freight; ?></td>
            <td style="vertical-align: middle;"><?php echo $row->eta_uttara_factory; ?></td>
            <td style="vertical-align: middle;"><?php echo $row->eta_cgp_to_fty; ?></td>
            <td style="vertical-align: middle;"><?php echo $row->exception_remarks; ?></td>
        </tr>
        <?php
        endforeach;
    endif;
    ?>
</table>

</body>
</html>