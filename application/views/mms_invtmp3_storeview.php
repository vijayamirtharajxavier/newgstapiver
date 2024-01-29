<?php 
/*//PDO Connection
$user ="gstinvoice";
$pass = "Jva999";
//$dbh = new PDO('mysql:host=localhost;dbname=gstinvoice', $user, $pass);
$dbh = new PDO('mysql:host=localhost;dbname=gstinvoice', $user, $pass);
*/
 $tot_tax=0.00;
 $totsgst=0.00;
 $totcgst=0.00;
 $totigst=0.00;
$cid = $_GET['cid'];
$in_id = $_GET['inv'];
$tot_igst =0.00;
 $tot_cgst =0.00;
 $tot_sgst =0.00;
 $tot_tax=0.00;
$totigst=0.00;
$tot_amt=0.00;
$totcgst=0.00;
  /*   
include('../dbscript/pdo-connect.php');
//Add data to it...
    foreach($dbh->query('SELECT * from invoice_tbl where company_id=' . $cid . ' and invoice_no like "%' . $in_id . '%" order by invoice_no') as $row) {
*/
foreach ($invoiceData as $key => $row) {
	# code...


	If($row['reversechg']==0) 
	{ 
$rev_chg="N";
} 
else { 
$rev_chg ="Y";
}
 $cust_id=$row['cust_id'];
 $inv_id = $row['invoice_no'];
 $inv_date=date('d-m-Y', strtotime($row['invoice_date']));
 $inv_date=date('d-m-Y', strtotime($row['invoice_date']));
 $inv_value=$row['invoice_value'];
 $dateofsupply = date('d-m-Y',strtotime($row['dateofsupply']));
 $order_date = date('d-m-Y',strtotime($row['order_date']));
 $order_no = $row['order_no'];
 $transport_mode = $row['transport_mode'];
 $vehicle_no = $row['vehicle_no'];
 $pof_supply = $row['placeofsupply'];
 
 //$cid= $row['company_id'];
 $bill_statecode="";$bill_to_name ="";$ship_to_name="";$bill_add="";$ship_add="";
$bill_gstin="";$ship_gstin="";$taxable_amount=0;
// $cid=2;
  //foreach($dbh->query('SELECT * from gststate_tbl where statecode_id=' . $pof_supply ) as $poc) {
  foreach ($gstData as $key => $poc) {
  		# code...
 	
	 $place_of_supply = $poc['state_name'] . " - (" . $poc['statecode_id'] . ")";
 }


 
// foreach($dbh->query('SELECT * from company_tbl where id=' . $cid ) as $cpnyrow) {
 	foreach ($companyData as $key => $cpnyrow) {
 		# code...
 
	 $comp_id = $cpnyrow['id'];
	 $comp_name = $cpnyrow['company_name'];
	 $comp_add1 = $cpnyrow['company_add1'];
	 $comp_add2 = $cpnyrow['company_add2'];
	 $comp_add3 = $cpnyrow['company_add3'];
	 $comp_state = $cpnyrow['company_state'];	 
	 $comp_statecode = $cpnyrow['company_statecode'];
	 $comp_gstin = $cpnyrow['company_gstin'];	 	 
	 $comp_emailid = $cpnyrow['company_emailid'];
	 $comp_contact = $cpnyrow['company_contact'];	
	 $comp_logo = $cpnyrow['logo_path'] . $cpnyrow['logo_name'];
	 $bnk_details = $cpnyrow['company_bank'];
	 $bnk_qrcode = $cpnyrow['bharath_qr'];
	 $upi_alt = $cpnyrow['upi_alter'];
	  
	 }
  //foreach($dbh->query('SELECT * from gststate_tbl where statecode_id=' . $comp_statecode ) as $soc) {
  	foreach ($orginData as $key => $soc) {
  		# code...
  		 $orgin_state = $soc['state_name'] . " - (" . $soc['statecode_id'] . ")";
 }
 
// foreach($dbh->query("SELECT * from customers_tbl where cust_id='" . $cust_id . "'" ) as $custrow) {
 	foreach ($customerData as $key => $custrow) {
 		# code...
 	 $cust_name = "M/S. " . $custrow['cust_name'];
	 $bill_to_name = "M/S. " . $custrow['bill_to_name'];
	 $bill_add = $custrow['bill_add'];
/*	 $bill_add2 = $custrow['bill_add2'];
	 $bill_add3 = $custrow['bill_add3']. '*/
	 $bill_state = $custrow['bill_state'];
	 $bill_statecode = $custrow['bill_statecode'];
	 $bill_gstin = $custrow['bill_gstin'];
	 $ship_to_name ="M/S. " . $custrow['ship_to_name'];
	 $ship_add = $custrow['ship_add'];
/*	 $ship_add2 = $custrow['ship_add2'];
	 $ship_add3 = $custrow['ship_add3'];*/
	 $ship_state = $custrow['ship_state'];
	 $ship_gstin = $custrow['ship_gstin'];
	 $ship_statecode = $custrow['ship_statecode'];
	 
 }
// echo $bill_statecode;
 
 if(substr($comp_gstin,0,2)==$bill_statecode) {
	 $taxname = "Central Tax";
	 $statetax = "State Tax";
 }
 else { 
     $taxname = "Integrated Tax";
	 $statetax="";
 }
 
 $co_address = $comp_add1 . "," . $comp_add2 . "," . $comp_add3;
 $co_email =  "Email : " . $comp_emailid;
 $co_gstin = "GSTIN No. " . $comp_gstin;
 
 $itemdata =array();

$badd = str_replace(",", "<br>", $bill_add);
$sadd = str_replace(",", "<br>", $ship_add);


 ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv='Content-Type' content='text/html' charset='UTF-8' />
	
	<title><?php echo $comp_name;?>| Invoice</title>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('custom/css/invstyle.css') ?>"> 
<link rel="stylesheet" type="text/css" href="<?php echo base_url('custom/css/invprint.css') ?>"> 
<link rel="stylesheet" type="text/css" href="<?php echo base_url('custom/css/invstyle.css') ?>"> 
<!--	<link rel='stylesheet' href='../dist/css/invstyle.css'>
	<link rel='stylesheet' type='text/css' href='css/invstyle.css' />
	<link rel='stylesheet' type='text/css' href='css/invprint.css' media='print'/>
	<script type='text/javascript' src='js/jquery-1.3.2.min.js'></script>
	<script type='text/javascript' src='js/example.js'></script> -->
<style type='text/css'>
	.pagebreak { page-break-before: always;} 
    .bdr {border: none;}
	
</style>

<style type='text/css' media='print'>
.breakAfter {
	page-break-after: always
}
</style>

</head>

<body>
<div id="page-wrap">

<!--<div style="font-size:30px;" class="text-align:center">TAX INVOICE</div>
			<!--<div style="float:right;font-size:100%;">&nbsp;ORIGINAL FOR RECIPIENT</div>-->

<?php 
$pg=1;

$pgbrk =30;
$pglines=31;
/*	$sql = "SELECT count(1) from invoicesub_tbl where invoice_id='" . $inv_id . "' and invoice_date='" . date('Y-m-d',strtotime($inv_date)) . "'";
$result = $dbh->prepare($sql); 
$result->execute(); 
//$number_of_rows = $result->fetchColumn(); 
*/
$number_of_rows=$itemCount;

$pgs= ceil($number_of_rows/$pgbrk);
echo '<table id="items"  style="margin-top:5px;font-size:12px;" >
		  <caption style="font-size:30px;text-align:center;">TAX INVOICE</caption>';
//		  	<!--<td colspan="1" style="border-right: none;border-left: none;"><img style="width:100px;" src="images/logo.png" alt="" /></td>-->
echo '<tr>
		  	<td colspan="21" valign="top" style="text-align:center;border-left:none;">';
//		  		<!--<img style="margin-left:10px;margin-top:15px;width:70px;float:left;" src="' . $comp_logo. '" >
echo '<strong style="font-size:35px;text-align:center;">' . $comp_name. '</strong>';
//<!--<td colspan="3" valign="top" class="noborders"><img src="../dist/img/chk-box.jpg" width="15px" alt="" />&nbsp;Recipient Copy <br /><img src="../dist/img/chk-box.jpg" width="15px" alt="" />&nbsp;Transport Copy <br /><img src="../dist/img/chk-box.jpg" width="15px" alt="" />&nbsp;Accounts Copy </td> -->

echo '<br><div style="font-size:14px;">';
echo str_replace(",", " | ", $comp_add1 . $comp_add2 . $comp_add3). ' <br /> ' . "Phone :" . $comp_contact . " | E-mail :" . $comp_emailid. '<br />
<strong style="font-size:20px;padding-top:10px;">GSTIN : ' . $comp_gstin . '</div></strong></td>
</tr>';
echo '<tr></tr>
		  <th colspan="8" style="text-align:center;">Details of Buyer</th>
		  <th colspan="10"  style="text-align:center;">CREDIT INVOICE</th>	
		  <tr>
		  
		<td colspan="8" rowspan="4" valign="top"><strong style="font-size:18px;">' . $bill_to_name . ' </strong><br />' . str_replace(",", "<br>", $bill_add) . ' <br /><strong style="font-size:16px;"> "GSTIN : "' . $bill_gstin . '</strong><br /> State Code : ' . $bill_statecode . '</td>';
  echo '<td colspan="5" valign="top"><strong>Invoice No.</strong><p align="center"><strong style="font-size:25px;">' . $inv_id . '</strong></p></td>
  <td colspan="5" valign="top"><strong>Date</strong><p  align="center"><strong style="font-size:25px;">' . $inv_date . '</strong></p></td></tr><tr>
  <tr><td colspan="5" valign="top"><strong>Reference #</strong><strong style="font-size:18px;"><p align="center">' . $order_no . '</strong></p></td>';
 echo '<td colspan="5"><strong>Pages</strong><strong style="font-size:25px;"><p class="text-align:center" align="center">' . $pg . '/' . $pgs . '</strong></p></td>';
  echo '</tr>
	<tr>';          
		 
		  echo	'<tr></tr>';
		 // echo '<td colspan="13"></td></tr>';
           
           
          echo '<tr></tr>';
          echo '<tr>
		      <th>SL.NO.</th>
		      <th style="width:500px" >PRODUCT / SERVICE</th>
              <th>DDESCRIPTION</th>
			  <th>HSN/SAC</th>
			  <th>MRP</th>
			  <th>QTY</th>
			  <th>UOM</th>
		      <th>RATE</th>
		      
		      <th>DISC</th>
		      <th>AFTR DISC</th>
		      <th>TAXABLE VALUE</th>
		      <th colspan="2">CGST</td>
		      
		      
		      <th colspan="2">SGST</th>
		      <th colspan="2">IGST</th>
		      <th>TOTAL AMOUNT</th>
		  </tr>
		  <tr>
		  	<th colspan="8"></th>
		  	
		  	<th>%</th>
		  	<th>&#8377;</th>
		  	<th>&#8377;</th>
		  	<th>%</th>
			<th>&#8377;</th>
		  	<th>%</th>
		  	<th>&nbsp;&#8377;</th>
		  	<th>%</th>
		  	<th>&nbsp;&#8377;</th>
		  	
		  	<th>&nbsp;&#8377;</th>
			
		  </tr>';
$rw=1;
$rc=1;
$rws=1;
$r=1;
		$tax_tot = 0.00;
		$cgst_tot = 0.00;
		$sgst_tot = 0.00;
		$igst_tot = 0.00;
		$igst=0.00;
		$tot_amt = 0.00;
		$dis_tot = 0.00;
		$dis_pc=0;
		$itemamt_tot=0.00;
   
	$sql = "SELECT * from invoicesub_tbl where invoice_id='" . $inv_id . "' and invoice_date='" . date('Y-m-d',strtotime($inv_date)) . "'";
	//echo $sql;
		// foreach($dbh->query($sql) as $subinv) {
		 	foreach ($invoiceSub as $key => $subinv) {
		 		# code...
		 		 
		 	if($subinv['item_narration']<>"") {
		 	$item_des = $subinv['item_name'];
		 	$item_nar = $subinv['item_narration'];
		} else {
		  	$item_des = $subinv['item_name'];
		}
		if($subinv['cgst_pc']<>"") {
			$cgstpc = "<br>" . $subinv['cgst_pc'];
		} else {
			$cgstpc = "";
		} 
		if($subinv['sgst_pc']<>"") {
			$sgstpc = "<br>" . $subinv['sgst_pc'];
		} else {
			$sgstpc = "";
		} 
		if($subinv['igst_pc']<>"") {
			$igstpc = "<br>" . $subinv['igst_pc'];
		} else {
			$igstpc = "";
		} 

		$rtot_amt = $subinv['taxable_amount'] + $subinv['item_cgst'] + $subinv['item_sgst'] + $subinv['item_igst'];
	
		 echo '<tr>';
		
		 echo '<td align="center" style="border:none;">' . $rw. '</td>';
		 echo '<td style="font-size:12px;border-top:none;border-bottom:none;">' . $item_des . '</td>';
		 echo '<td align="center" style="border-top:none;border-bottom:none;">' . $subinv['item_narration'] . '</td>';
		 echo '<td align="center" style="border-top:none;border-bottom:none;">' . $subinv['item_hsn'] . '</td>';
		 echo '<td align="center" style="border-top:none;border-bottom:none;">' . $subinv['item_mrp'] . '</td>';
		 echo '<td align="center" style="border-top:none;border-bottom:none;">' . $subinv['item_qty'] . '</td>';
		 echo '<td align="center" style="border-top:none;border-bottom:none;">' . $subinv['item_unit']. '</td>';
		 echo '<td align="right" style="border-top:none;border-bottom:none;">' . $subinv['item_rate']. '</td>';
		 echo '<td align="right" style="border-top:none;border-bottom:none;">' . $subinv['discount_pc']. '</td>';
		 echo '<td align="center" style="border-top:none;border-bottom:none;">' . $subinv['item_discount'] . '</td>';
		 echo '<td align="right" style="border-top:none;border-bottom:none;">' . $subinv['taxable_amount']. '</td>';
		 echo '<td align="center" style="width:30px;border-top:none;border-bottom:none;">' . $subinv['cgst_pc']. '</td>';

		 echo '<td align="right" style="border-top:none;border-bottom:none;">' . $subinv['item_cgst']. '</td>';
		 echo '<td align="center" style="border-top:none;border-bottom:none;" >' . $subinv['sgst_pc'] . '</td>';
		 echo '<td align="right" style="border-top:none;border-bottom:none;">' . $subinv['item_sgst'] . '</td>';
		 echo '<td align="center" style="border-top:none;border-bottom:none;">' . $subinv['igst_pc'] . '</td>';
		 echo '<td align="right" style="border-top:none;border-bottom:none;">' . $subinv['item_igst']. '</td>';
		 echo '<td align="right" style="border-top:none;border-bottom:none;">' . number_format($rtot_amt, 2, '.', ',') . '</td>';
		echo '</tr>';
 $rw=$rw+1;
		$tax_tot = $tax_tot + $subinv['taxable_amount'];
		$dis_tot = $dis_tot + $subinv['item_discount'];
		$itemamt_tot = $itemamt_tot + $subinv['item_amount'];
		$taxable_tot = $itemamt_tot - $dis_tot;
		$cgst_tot = $cgst_tot + $subinv['item_cgst'];
		$sgst_tot = $sgst_tot + $subinv['item_sgst'];
		$igst_tot = $igst_tot + $subinv['item_igst'];
		$tot_amt = $tax_tot + $cgst_tot + $sgst_tot + $igst_tot;

if($rc==$pglines) 
{
$rc=1;
	$r=1;
	$pg=$pg+1;
echo '<div class="pagebreak"></div>';
	echo '</table>';
	echo '<br>';
	echo '<div class="pull-right" align="right"> Contd./-</div>';
echo '<div class="breakAfter"></div>';
	echo '<table id="items" style="margin-top:5px;font-size:12px;" >
		  <caption style="font-size:30px;text-align:center;">TAX INVOICE</caption>';
//		  	<!--<td colspan="1" style="border-right: none;border-left: none;"><img style="width:100px;" src="images/logo.png" alt="" /></td>-->
echo '<tr>
		  	<td colspan="19" valign="top" style="text-align:center;border-left:none;">';
//		  		<!--<img style="margin-left:10px;margin-top:15px;width:70px;float:left;" src="' . $comp_logo. '" >
		  		echo '<strong style="font-size:35px;text-align:center;">' . $comp_name. '</strong>';
//<!--<td colspan="3" valign="top" class="noborders"><img src="../dist/img/chk-box.jpg" width="15px" alt="" />&nbsp;Recipient Copy <br /><img src="../dist/img/chk-box.jpg" width="15px" alt="" />&nbsp;Transport Copy <br /><img src="../dist/img/chk-box.jpg" width="15px" alt="" />&nbsp;Accounts Copy </td> -->

echo '<br><div style="font-size:14px;">';
echo str_replace(",", " | ", $comp_add1 . $comp_add2 . $comp_add3). ' <br /> ' . "Phone :" . $comp_contact . " | E-mail :" . $comp_emailid. '<br />
<strong style="font-size:20px;padding-top:10px;">GSTIN : ' . $comp_gstin . '</div></strong></td>
</tr>';
echo '<tr></tr>
		  <th colspan="6" style="text-align:center;">Details of Buyer</th>
		  <th colspan="10"  style="text-align:center;">CREDIT INVOICE</th>	
		  <tr>
		<td colspan="6" rowspan="4" valign="top"><strong style="font-size:18px;">' . $bill_to_name . ' </strong><br />' . str_replace(",", "<br>", $bill_add) . ' <br /><strong style="font-size:16px;"> "GSTIN : "' . $bill_gstin . '</strong><br /> State Code : ' . $bill_statecode . '</td>';
  echo '<td colspan="5" valign="top"><strong>Invoice No.</strong><strong style="font-size:25px;"><p align="center">' . $inv_id . '</strong></td>
  <td colspan="5" valign="top"><strong>Date</strong><p  align="center"><strong style="font-size:25px;">' . $inv_date . '</strong></p></td></tr><tr>
  <tr><td colspan="5" valign="top"><strong>Reference #</strong><strong style="font-size:25px;"><p align="center">' . $order_no . '</strong></p></td>';
 echo '<td colspan="5"><strong>Pages</strong><strong style="font-size:25px;"><p class="text-align:center" align="center">' . $pg . '/' . $pgs . '</strong></p></td>';
  echo '</tr>
	<tr>';          

		  echo	'<tr></tr>';
		  echo '</tr>';
           
           
           echo '<tr></tr>';
          
		  echo '<tr>
		      <th>SL.NO.</th>
		      <th style="width:500px" >PRODUCT / SERVICE</th>
              <th>DESCRIPTION</th>
			  <th>HSN/SAC</th>
			  <th>QTY</th>
			  <th>UOM</th>
		      <th>RATE</th>
		      
		      <th>DISC%</th>
		      <th>TAXABLE VALUE</th>
		      <th colspan="2">CGST</td>
		      
		      
		      <th colspan="2">SGST</th>
		      <th colspan="2">IGST</th>
		      <th>TOTAL AMOUNT</th>
		  </tr>
		  <tr>
		  	<th colspan="8"></th>
		  	<th>%</th>
		  	
		  	<th>&#8377;</th>
		  	<th>%</th>
		  	<th>&nbsp;&#8377;</th>
		  	<th>%</th>
		  	<th>&nbsp;&#8377;</th>
		  	<th>%</th>
		  	<th>&nbsp;&#8377;</th>
			
		  </tr>';


     

}
		$rc=$rc+1;


} 
 

 $rws=$rc+8;
 while($rws <= $pglines) {
      
     
     echo '<tr>
    	<td style="border-top:none;border-bottom:none;">&nbsp;</td>
     	<td style="border-top:none;border-bottom:none;"></td>
     	<td style="border-top:none;border-bottom:none;"></td>
		<td style="border-top:none;border-bottom:none;"></td>
		<td style="border-top:none;border-bottom:none;"></td>
		<td style="border-top:none;border-bottom:none;"></td>
     	<td style="border-top:none;border-bottom:none;"></td>
     	<td style="border-top:none;border-bottom:none;"></td>
		<td style="border-top:none;border-bottom:none;"></td>
		<td style="border-top:none;border-bottom:none;"></td>
		<td style="border-top:none;border-bottom:none;"></td>
     	<td style="border-top:none;border-bottom:none;"></td>
     	<td style="border-top:none;border-bottom:none;"></td>
		<td style="border-top:none;border-bottom:none;"></td>
		<td style="border-top:none;border-bottom:none;"></td>
		<td style="border-top:none;border-bottom:none;"></td>
		<td style="border-top:none;border-bottom:none;"></td>
		<td style="border-top:none;border-bottom:none;"></td>
		

    
     </tr>
<tr>';

$rws=$rws+1;    

}

   //  }
		
$r=1;


echo '<tr><td colspan="6" align="right">Total </td>';
	    //echo '<td align="right"><strong>' . number_format($itemamt_tot, 2, '.', ','). '</strong></td>';
	    echo '<td></td>';
	    echo '<td></td>';
	    echo '<td></td>';
	    echo '<td></td>';
	    /*<!--echo '<td align="right">  <strong>' . number_format($dis_tot, 2, '.', ','). '</strong></td>';*/
	    echo '<td align="right">  <strong>' . number_format($taxable_tot, 2, '.', ','). '</strong></td>';
	    echo '<td></td>';
	    echo '<td align="right">  <strong>' . number_format($cgst_tot, 2, '.', ','). '</strong></td>';
	    echo '<td></td>';
	    echo '<td align="right"> <strong>' . number_format($sgst_tot, 2, '.', ','). '</strong></td>';
	    echo '<td></td>';
	    echo '<td align="right"><strong> ' . number_format($igst_tot, 2, '.', ','). '</strong></td>';
	    echo '<td align="right"><strong> ' . number_format($tot_amt, 2, '.', ','). '</strong></td>';
echo '</tr>';
		
		  

		  echo '<tr>';
		   $f = new NumberFormatter("en", NumberFormatter::SPELLOUT);
		  echo '<td valign="top" colspan="18" rowspan="2"><strong>(Rupees in words) :</strong>Rupees ' . ucwords($f->format($tot_amt)) . " only". '</td>';

/*<!--		  	<td align="center" colspan="12" rowspan="1">TERMS</td>
		      <td colspan="3" class="total-line">Taxable Amount</td>
		      <td  colspan="2" class="total-value"><div id="subtotal" align="right"> <?php // echo number_format($tax_tot, 2, '.', ','). '</div></td> --> */
		 echo '</tr><tr></tr>';
	echo '<table id="items" style="margin-top:5px;font-size:12px;" >
	<tr></tr>';
	


echo '
	  <th>TAX %</th><th>AMOUNT</th><th>%</th><th>IGST</th><th>%</th><th>CGST</th><th>%</th><th>SGST</th><th>Total</th><tbody>';
 $sql="SELECT gst_pc,sum(taxable_amount) AS `taxable_amount`, sum(item_cgst) AS `item_cgst`,sum(item_sgst) AS `item_sgst`,sum(item_igst) AS `item_igst` FROM `invoicesub_tbl` WHERE company_id=" . $cid . "  and invoice_id='" . $in_id . "' GROUP by gst_pc";
 //echo $sql;
 $rwtaxtot =0;
 $tot_amt=0;
 //foreach($dbh->query($sql) as $taxdata) { 
 foreach ($invoiceSubTotal as $key => $taxdata) {
 	# code...
 
 $gstpc = $taxdata['gst_pc'];
 $igst = $taxdata['item_igst'];
 $cgst = $taxdata['item_cgst'];
 $sgst = $taxdata['item_sgst'];
 $taxableamt=$taxdata['taxable_amount'];
 $rwtaxtot = $igst+$cgst+$sgst;
 
 if($gstpc >0){
	 $divgst= $gstpc/2 . '%';
 }
 else {
	 $divgst= "";
 }
if($cgst>0) {
	 $cgstamt=$cgst;
	 $sgstamt=$sgst;
     $divgst= $gstpc/2 . '%';
	 $igstamt=0.00;
	 $igstpc="";

	 
 }
 else {
	 $cgstamt=0.00;
	 $sgstamt=0.00;
	 $divgst=0.00;
	 $igstamt=$igst;
	 $igstpc=$gstpc;
	 $tot_cgst=0.00;
	 $tot_sgst=0.00;

     //$totigst=$tot_igst;
	 } 
 
 
 echo '<tr>';
 echo '<td align="center">'. $gstpc . '%</td>';
 echo '<td align="right">' . number_format($taxableamt, 2, '.', ',') . '</td>';
 echo '<td align="center" >'. $igstpc .'</td>';
 echo '<td align="right">' . number_format($igstamt, 2, '.', ',') . '</td>';


 echo '<td align="center" >'. $divgst .'</td>';
 echo '<td align="right">' . number_format($cgstamt, 2, '.', ',') . '</td>';
 echo '<td align="center">'. $divgst .'</td>';
 echo '<td align="right">' . number_format($sgstamt, 2, '.', ',') . '</td>';

 echo '<td align="right">' . number_format($rwtaxtot, 2, '.', ',') . '</td></tr>';
 
 $tot_igst =$tot_igst+$igst;
 $tot_cgst =$tot_cgst+$cgst;
 $tot_sgst =$tot_sgst+$sgst;
 $tot_tax = $tot_tax+$rwtaxtot;
 $tot_amt = $tot_amt+$taxableamt;
 $rwtaxtot=0;
 
 
 
 }
 if($tot_igst>0) {
	 $totigst=$tot_igst;
 	 //$totcgst="";
	 //$totsgst="";
 }
 else {
	 $totigst=0.00;
	 	 $totcgst=$tot_cgst;
	 $totsgst=$tot_sgst;
 }

 echo '<tr>
 <td><strong>Total</strong></td><td align="right"><strong>'.  number_format($tot_amt, 2)  .'</strong></td><td></td><td align="right"><strong>'. number_format($totigst, 2) . '</strong></td><td></td><td align="right"><strong>'. number_format($totcgst, 2) . '</strong></td><td></td><td align="right"><strong>'. number_format($totsgst , 2) . '</strong></td><td align="right"><strong>'. number_format($tot_tax , 2) . '</strong></td>'; 

  echo '</tr>';
  
 echo '</tbody>';
 echo '<tr></tr>';
 echo '</table>';
 
 	echo '<table id="items" style="margin-top:5px;font-size:18px;" >
	<tr>
	<td  style="border-right:none">Bank Details<p>' . $bnk_details. '</p></td>
	<td  style="border-left:none;" align="right"><h4 align="right" style="font-size:20px;">for <strong> ' . ucwords($comp_name). '</strong></h4>
				<br /><br /><br />
				<h4 align="right" style="font-size:18px;">Authorized Signatory</h4></td>
	
	</tr>';


	echo '</table>';
	
 echo '<div class=""><p><span style="float:right">This is a Computer Generated Invoice</p></span> </div>
     <br>
     <div align="right">E. & O.E.</div>';
 

 



 } 
	
	?>

</body>

</html>
