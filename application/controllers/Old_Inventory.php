<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Inventory extends CI_Controller {

	public function __construct(){
        parent::__construct();
        check_login_user();
        $this->load->library('curl');
$this->load->helper('form');


    //   $this->load->model('common_model');
    //   $this->load->model('login_model');


$this->secret= $this->session->userdata('authkey');

$this->headers = array(
         
         'X-API-Key: '. $this->secret
);
    


    }

    public function newpurchase(){
        $data = array();
        $data['page'] = 'New Purchase';
        $this->load->view('purchaseentry', $data);
    }

    public function newsales(){
        $data = array();
        $data['page'] = 'New Sales';
        $this->load->view('salesentry', $data);
    }

    public function salesreg(){
        $data = array();
        $data['page'] = 'Sales Register';
        $this->load->view('salesreport', $data);
    }
    public function rsalesreg(){
        $data = array();
        $data['page'] = 'Credit Note / Sales Return Register';
        $this->load->view('rsalesreport', $data);
    }

    public function purreg(){
        $data = array();
        $data['page'] = 'Purchase Register';
        $this->load->view('purchasereport', $data);
    }

    public function salesinvoiceprint(){
        $data = array();
        $data['page'] = 'Sales Invoice';
        $this->load->view('salesinvoice', $data);
    }


public function getInvLedgerAccount()
{
$url=$this->config->item("api_url") . "/api/ledger";
//$post = ['batch_id'=> "2"];
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  //curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
  $response = curl_exec($ch);
  //$result = json_decode($response);
  curl_close($ch); // Close the connection
$groupArray = json_decode($response, true);
//$character = json_decode($data);
//print_r($response);
$data=array();
$option="";
foreach ($groupArray['ledger'] as $key => $value) {
$option .= '<option value="'.$value['id'].'">'.$value['account_name'].'</option>';

}
$option .= '<option selected  disabled value="0">Select a Vendor</option>';
echo $option;

}


public function getInvoiceprintbyid()
{
$id = $this->input->get('id');
$compId = $this->session->userdata('id');
$finyear = $this->session->userdata('finyear');
$trans_type="SALE";
//getTax breakup
$url=$this->config->item("api_url") . "/api/reports/gettaxesbyid";

$data = array("id"=>$id,"compId"=>$compId);
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

  $taxesbyidresponse = curl_exec($ch);
  //$result = json_decode($response);
//echo $taxesbyidresponse;

curl_close($ch); // Close the connection
//var_dump($taxesbyidresponse);
$taxobj = json_decode($taxesbyidresponse,true);
//var_dump(json_decode($taxesbyidresponse,true));

$url=$this->config->item("api_url") . "/api/transaction/pursal_byid/" . $id . "/" . $trans_type;
//$data = array("id"=>$id,"finyear"=>$finyear,"compId"=>$compId,"trans_type"=>$trans_type);
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);

  $salesbyidresponse = curl_exec($ch);
//var_dump($salesbyidresponse);
curl_close($ch); // Close the connection
$obj = json_decode($salesbyidresponse,true);
$tbl="";
//var_dump($obj);gegetSalesPurchaseItemsgetSalesPurchaseItemstSalesPurchaseItems

$url=$this->config->item("api_url") . "/api/itemtransaction/pursal_byid/" . $id . "/" . $trans_type;
//$data = array("id"=>$id,"finyear"=>$finyear,"compId"=>$compId,"trans_type"=>$trans_type);
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  $itemsresponse = curl_exec($ch);
//  var_dump($itemsresponse);
$objItems = json_decode($itemsresponse,true);

curl_close($ch); 



$tbl="";
ECHO '<link rel="stylesheet" type="text/css" href="'. base_url() . 'assets/css/invstyle.css"> 
<link rel="stylesheet" type="text/css" href="'. base_url() . 'assets/css/invprint.css"> 
<link rel="stylesheet" type="text/css" href="'. base_url() . 'assets/css/invstyle.css"> 
<style type="text/css">
    .pagebreak { page-break-before: always;} 
    .bdr {border: none;}
.breakAfter {
    page-break-after: always
}
</style>';
$pg=1;

$pgbrk =31;
$pglines=32;

$tbl .='<div id="page-wrap">';
$tbl .='<table id="items"  style="margin-top:5px;font-size:14px;" >';
$tbl .='<caption style="font-size:30px;text-align:center;">TAX INVOICE</caption>';
$tbl .= '<tr><td colspan="18" valign="top" style="text-align:center;">';

$tbl .='<strong style="font-size:35px;text-align:center;color:blue;">' . $this->session->userdata('cname') . '</strong>';

$tbl .='<br><div style="font-size:18px;color:grey;">';
$tbl .= str_replace(",", " | ", $this->session->userdata('cadd') ). ' <br /> ' . "Phone :" . $this->session->userdata('contact') . " | E-mail :" . $this->session->userdata('email'). '<br />
<strong style="font-size:20px;padding-top:10px;color:red;">GSTIN : ' . $this->session->userdata('gstin') . '</div></strong></td>
</tr>';

$bill_to_name='xyz';
$bill_add='abc';
$bill_statecode='33';
$inv_id='1111';
//var_dump($obj);
foreach ($obj as  $mvalue) {
$actid = $mvalue['db_account'];

//var_dump($mvalue);
$url=$this->config->item("api_url") . "/api/ledger/" . $actid ;
//$post = ['batch_id'=> "2"];

$data = array("id"=>$actid,"compId"=>$compId);

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 // curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  
  $ldgresponse = curl_exec($ch);
  //$result = json_decode($response);
//var_dump($data);
//var_dump($ldgresponse);
  curl_close($ch); // Close the connection
$ldgerArray = json_decode($ldgresponse);


$lname=$ldgerArray->account_name;
$laddress=$ldgerArray->account_address;
$lgstin=$ldgerArray->account_gstin;
$lemail=$ldgerArray->account_email;
$lcontact=$ldgerArray->account_contact;
$lstatecode=$ldgerArray->account_statecode;
$lbustype=$ldgerArray->bus_type;
//var_dump($lname );

//$count = count($objItems);

$number_of_rows= count($objItems);

$pgs= ceil($number_of_rows/$pgbrk);



$tbl .='<tr></tr>
          <th colspan="6" style="text-align:center;">Details of Buyer</th>
          <th colspan="12"  style="text-align:center;">INVOICE DETAILS</th>';  

$tbl .='<tr><td colspan="6" rowspan="4" valign="top"><strong style="font-size:20px;">M/S. ' . $lname . ' </strong><br />' . str_replace(",", "<br>", $laddress) . ' <br /><strong style="font-size:16px;"> "GSTIN : "' . $lgstin . '</strong><br /> State Code : ' . $lstatecode . '</td>';

$tbl .= '<td colspan="6" valign="top"><strong>Invoice No.</strong><p align="center"><strong style="font-size:25px;">' . $mvalue['trans_id'] . '</strong></p></td><td colspan="6" valign="top"><strong>Date</strong><p  align="center"><strong style="font-size:25px;">' . date("d-m-Y", strtotime($mvalue['trans_date']))  . '</strong></p></td></tr><tr><tr><td colspan="6" valign="top"><strong>Reference #</strong><strong style="font-size:18px;"><p align="center">' . $mvalue['order_no'] . '</strong></p></td>';

$tbl .= '<td colspan="5"><strong>Pages</strong><strong style="font-size:25px;"><p class="text-align:center" align="center">' . $pg . '/' . $pgs . '</strong></p></td>';
  
$tbl .= '</tr><tr>';          
         
$tbl .=  '<tr></tr>';
if($lbustype=="1")
{
          $tbl .= '<tr>
              <th>SL.NO.</th>
              <th style="width:500px" >PRODUCT / SERVICE</th>
              <th>DESCRIPTION</th>
              <th>HSN/SAC</th>
              <th>MRP</th>
              <th>QTY</th>
              <th>UOM</th>
              <th>RATE</th>
              
              <th>DIS%</th>
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
        $tot_igst=0.00;
        $tot_cgst=0.00;
        $tot_sgst=0.00;
        $tot_tax=0.00;
        $igst=0.00;
        $tot_amt = 0.00;
        $dis_tot = 0.00;
        $dis_pc=0;
        $itemamt_tot=0.00;

foreach ($objItems as  $item) {
    
   // var_dump($item);

       if($item['item_name']<>"") {
            $item_name = $item['item_name'];
       }
       else
       {
        $item_name="";
       }
       if($item['item_desc']<>"") {
            //$item_name = $item['item_name'];
            $item_nar = $item['item_desc'];
        } else {
            $item_nar = "";
        }
        if($item['cgst_pc']<>"") {
            $cgstpc = "<br>" . $item['cgst_pc'];
        } else {
            $cgstpc = "";
        } 
        if($item['sgst_pc']<>"") {
            $sgstpc = "<br>" . $item['sgst_pc'];
        } else {
            $sgstpc = "";
        } 
        if($item['igst_pc']<>"") {
            $igstpc = "<br>" . $item['igst_pc'];
        } else {
            $igstpc = "";
        } 



$rtot_amt = $item['taxable_amount'] + $item['cgst_amount'] + $item['sgst_amount'] + $item['igst_amount'];
$tbl .= '<tr>';
        
$tbl .= '<td align="center" style="border-top:none;border-bottom:none;">' . $rw. '</td>';
$tbl .= '<td style="font-size:14px;border-top:none;border-bottom:none;">' . $item_name . '</td>';
$tbl .= '<td align="center" style="font-size:14px;border-top:none;border-bottom:none;">' . $item_nar . '</td>';
$tbl .= '<td align="center" style="font-size:14px;border-top:none;border-bottom:none;">' . $item['item_hsnsac'] . '</td>';
$tbl .= '<td align="center" style="font-size:14px;border-top:none;border-bottom:none;">' . $item['item_mrp'] . '</td>';

$tbl .= '<td align="center" style="font-size:14px;border-top:none;border-bottom:none;">' . $item["item_qty"] . '</td>';
$tbl .= '<td align="center" style="font-size:14px;border-top:none;border-bottom:none;">' . $item["item_unit"]. '</td>';
$tbl .= '<td align="right" style="font-size:14px;border-top:none;border-bottom:none;">' . $item["item_rate"]. '</td>';
$tbl .= '<td align="right" style="font-size:14px;border-top:none;border-bottom:none;">' . $item["item_dispc"]. '</td>';
//$tbl .= '<td align="right" style="border-top:none;border-bottom:none;">' . $item["item_disamount"]. '</td>';

$tbl .= '<td align="right" style="font-size:14px;border-top:none;border-bottom:none;">' . $item["taxable_amount"]. '</td>';
$tbl .= '<td align="center" style="font-size:14px;width:30px;border-top:none;border-bottom:none;">' . $item["cgst_pc"]. '</td>';

$tbl .= '<td align="right" style="font-size:14px;border-top:none;border-bottom:none;">' . $item["cgst_amount"]. '</td>';
$tbl .= '<td align="center" style="font-size:14px;border-top:none;border-bottom:none;" >' . $item["sgst_pc"] . '</td>';
$tbl .= '<td align="right" style="font-size:14px;border-top:none;border-bottom:none;">' . $item["sgst_amount"] . '</td>';
$tbl .= '<td align="center" style="font-size:14px;border-top:none;border-bottom:none;">' . $item["igst_pc"] . '</td>';
$tbl .= '<td align="right" style="font-size:14px;border-top:none;border-bottom:none;">' . $item["igst_amount"]. '</td>';
$tbl .= '<td align="right" style="font-size:14px;border-top:none;border-bottom:none;">' . number_format($rtot_amt, 2, ".", ",") . '</td>';
$tbl .= '</tr>';

$rw=$rw+1;
        $tax_tot = $tax_tot + $item['taxable_amount'];
        $dis_tot = $dis_tot + $item['item_disamount'];
        $itemamt_tot = $itemamt_tot + $item['item_amount'];
        $taxable_tot = $itemamt_tot ;
        $cgst_tot = $cgst_tot + $item['cgst_amount'];
        $sgst_tot = $sgst_tot + $item['sgst_amount'];
        $igst_tot = $igst_tot + $item['igst_amount'];
        $tot_amt = $tax_tot + $cgst_tot + $sgst_tot + $igst_tot;

if($rc==$pglines) 
{
$rc=1;
    $r=1;
    $pg=$pg+1;
$tbl .= '<div class="pagebreak"></div>';
    $tbl .= '</table>';
    $tbl .= '<br>';
    $tbl .= '<div class="pull-right" align="right"> Contd./-</div>';
$tbl .= '<div class="breakAfter"></div>';
    $tbl .= '<table id="items" style="margin-top:5px;font-size:14px;" >
          <caption style="font-size:30px;text-align:center;">TAX INVOICE</caption>';
$tbl .= '<tr>
            <td colspan="17" valign="top" style="text-align:center;">';
                $tbl .= '<strong style="font-size:35px;text-align:center;color:blue;">' . $this->session->userdata('cname') . '</strong>';

$tbl .='<br><div style="font-size:14px;color:grey;">';
$tbl .= str_replace(",", " | ", $this->session->userdata('cadd') ). ' <br /> ' . "Phone :" . $this->session->userdata('contact') . " | E-mail :" . $this->session->userdata('email'). '<br />
<strong style="font-size:20px;padding-top:10px;color:red;">GSTIN : ' . $this->session->userdata('gstin') . '</div></strong></td>
</tr>';

$tbl .='<tr></tr>
          <th colspan="8" style="text-align:center;">Details of Buyer</th>
          <th colspan="10"  style="text-align:center;">CREDIT INVOICE</th>  
          <tr>
          
        <div style="float:left; "><td style="float:left;" colspan="6" rowspan="4" valign="top"><strong style="font-size:20px;">' . $bill_to_name . ' </strong><br />' . str_replace(",", "<br>", $bill_add) . ' <br /><strong style="font-size:16px;"> "GSTIN : "' . $mvalue['gstin'] . '</strong><br /> State Code : ' . $bill_statecode . '</td></div>';
  $tbl .= '<td colspan="5" valign="top"><strong>Invoice No.</strong><p align="center"><strong style="font-size:25px;">' . $mvalue['trans_id'] . '</strong></p></td>
  <td colspan="5" valign="top"><strong>Date</strong><p  align="center"><strong style="font-size:25px;">' . date("d-m-Y",strtotime($mvalue['trans_date']))  . '</strong></p></td></tr><tr>
  <tr><td colspan="5" valign="top"><strong>Reference #</strong><strong style="font-size:18px;"><p align="center">' . $mvalue['order_no'] . '</strong></p></td>';
 $tbl .= '<td colspan="5"><strong>Pages</strong><strong style="font-size:25px;"><p class="text-align:center" align="center">' . $pg . '/' . $pgs . '</strong></p></td>';
  $tbl .= '</tr><tr>';          
         
          $tbl .=  '<tr></tr>';
          $tbl .= '</tr>';
           
           
           $tbl .= '<tr></tr>';
          
          $tbl .= '<tr>
              <th>SL.NO.</th>
              <th style="width:500px" >PRODUCT / SERVICE</th>
              <th>DESCRIPTION</th>
              <th>HSN/SAC</th>
              <th>MRP</th>
              <th>QTY</th>
              <th>UOM</th>
              <th>RATE</th>
              
              <th>DIS%</th>
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


} //items


 $rws=$rc+8;
 while($rws <= $pglines) {
      
     
     $tbl .= '<tr>
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


        <td style="border-top:none;border-bottom:none;"></td></tr><tr>';

$rws=$rws+1;    

}


$r=1;


$tbl .= '<tr><td colspan="6" align="right">Total </td>';
        //$tbl .= '<td align="right"><strong>' . number_format($itemamt_tot, 2, '.', ','). '</strong></td>';
        $tbl .= '<td></td>';
           $tbl .= '<td></td><td></td>';
  //      $tbl .= '<td align="right">  <strong>' . number_format($dis_tot, 2, '.', ','). '</strong></td>';
        $tbl .= '<td align="right">  <strong>' . number_format($taxable_tot, 2, '.', ','). '</strong></td>';
        $tbl .= '<td></td>';
        $tbl .= '<td align="right">  <strong>' . number_format($cgst_tot, 2, '.', ','). '</strong></td>';
        $tbl .= '<td></td>';
        $tbl .= '<td align="right"> <strong>' . number_format($sgst_tot, 2, '.', ','). '</strong></td>';
        $tbl .= '<td></td>';
        $tbl .= '<td align="right"><strong> ' . number_format($igst_tot, 2, '.', ','). '</strong></td>';
        $tbl .= '<td align="right"><strong> ' . number_format($tot_amt, 2, '.', ','). '</strong></td>';
$tbl .= '</tr>';
        

$tbl .= '<tr>';
           $f = new NumberFormatter("en", NumberFormatter::SPELLOUT);
$tbl .= '<td valign="top" colspan="17" rowspan="2"><strong>(Rupees in words) :</strong>Rupees ' . ucwords($f->format(round($tot_amt,2))) . " only". '</td>';
$tbl .= '</tr><tr></tr>';
$tbl .= '<table id="items" style="margin-top:5px;font-size:12px;"><tr></tr>';
    
$tbl .= '<th>TAX %</th><th>AMOUNT</th><th>%</th><th>IGST</th><th>%</th><th>CGST</th><th>%</th><th>SGST</th><th>Total</th><tbody>';
 $rwtaxtot =0;
 $tot_amt=0;



foreach ($taxobj as  $taxdata) {
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


 $tbl .= '<tr>';
 $tbl .= '<td align="center">'. $gstpc . '%</td>';
 $tbl .= '<td align="right">' . number_format($taxableamt, 2, '.', ',') . '</td>';
 $tbl .= '<td align="center" >'. $igstpc .'</td>';
 $tbl .= '<td align="right">' . number_format($igstamt, 2, '.', ',') . '</td>';


 $tbl .= '<td align="center" >'. $divgst .'</td>';
 $tbl .= '<td align="right">' . number_format($cgstamt, 2, '.', ',') . '</td>';
 $tbl .= '<td align="center">'. $divgst .'</td>';
 $tbl .= '<td align="right">' . number_format($sgstamt, 2, '.', ',') . '</td>';

 $tbl .= '<td align="right">' . number_format($rwtaxtot, 2, '.', ',') . '</td></tr>';
 $tot_igst =$tot_igst+$igst;
 $tot_cgst =$tot_cgst+$cgst;
 $tot_sgst =$tot_sgst+$sgst;
 $tot_tax = $tot_tax+$rwtaxtot;
 $tot_amt = $tot_amt+$taxableamt;
 $rwtaxtot=0;



} //tax loop

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

 $tbl .= '<tr>
 <td><strong>Total</strong></td><td align="right"><strong>'.  number_format($tot_amt, 2)  .'</strong></td><td></td><td align="right"><strong>'. number_format($totigst, 2) . '</strong></td><td></td><td align="right"><strong>'. number_format($totcgst, 2) . '</strong></td><td></td><td align="right"><strong>'. number_format($totsgst , 2) . '</strong></td><td align="right"><strong>'. number_format($tot_tax , 2) . '</strong></td>'; 

  $tbl .= '</tr>';
  
 $tbl .= '</tbody>';
 $tbl .= '<tr></tr>';
 $tbl .= '</table>';
 $bnkdetails=str_replace(",", "</BR>", $this->session->userdata('cbankdetails'));
 
    $tbl .= '<table id="items" style="margin-top:5px;font-size:18px;" >
    <tr>

    <td colspan="10"  style="border-right:none"><p>' . $bnkdetails . '</p></td>
    <td colspan="8"  style="border-left:none;" align="right"><h4 align="right" style="font-size:20px;">for <strong> ' . ucwords($this->session->userdata('cname')). '</strong></h4>
                <br /><br /><br />
                <h4 align="right" style="font-size:18px;">Authorized Signatory</h4></td>
    
    </tr>';
}
else if($lbustype=="0")
{
          $tbl .= '<tr>
              <th>SL.NO.</th>
              <th style="width:500px" >PRODUCT / SERVICE</th>
              <th>DESCRIPTION</th>
              <th>HSN/SAC</th>
              
              <th>QTY</th>
              <th>UOM</th>
              <th>RATE</th>
              
              <th>DIS%</th>
              <th>TAXABLE VALUE</th>
              <th colspan="2">CGST</td>
              
              
              <th colspan="2">SGST</th>
              <th colspan="2">IGST</th>
              <th>TOTAL AMOUNT</th>
          </tr>
          <tr>
            <th colspan="7"></th>
            
            <th>%</th>
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
        $tot_igst=0.00;
        $tot_cgst=0.00;
        $tot_sgst=0.00;
        $tot_tax=0.00;
        $igst=0.00;
        $tot_amt = 0.00;
        $dis_tot = 0.00;
        $dis_pc=0;
        $itemamt_tot=0.00;
$totcgst=0;
$totigst=0;
$totsgst=0;
foreach ($objItems as  $item) {
    
    //var_dump($item);

       if($item['item_name']<>"") {
            $item_name = $item['item_name'];
       }
       else
       {
        $item_name="";
       }

//      $item_name = $item['item_name'];
       if($item['item_desc']<>"") {
            
            $item_nar = $item['item_desc'];
        } else {
            $item_nar =""; // $item['item_name'];
        }
        if($item['cgst_pc']<>"") {
            $cgstpc = "<br>" . $item['cgst_pc'];
        } else {
            $cgstpc = "";
        } 
        if($item['sgst_pc']<>"") {
            $sgstpc = "<br>" . $item['sgst_pc'];
        } else {
            $sgstpc = "";
        } 
        if($item['igst_pc']<>"") {
            $igstpc = "<br>" . $item['igst_pc'];
        } else {
            $igstpc = "";
        } 



$rtot_amt = $item['taxable_amount'] + $item['cgst_amount'] + $item['sgst_amount'] + $item['igst_amount'];
$tbl .= '<tr>';
        
$tbl .= '<td align="center" style="border-top:none;border-bottom:none;">' . $rw. '</td>';
$tbl .= '<td style="font-size:12px;border-top:none;border-bottom:none;">' . $item_name . '</td>';
$tbl .= '<td align="left" style="border-top:none;border-bottom:none;">' . $item_nar . '</td>';
$tbl .= '<td align="center" style="border-top:none;border-bottom:none;">' . $item['item_hsnsac'] . '</td>';

$tbl .= '<td align="center" style="border-top:none;border-bottom:none;">' . $item["item_qty"] . '</td>';
$tbl .= '<td align="center" style="border-top:none;border-bottom:none;">' . $item["item_unit"]. '</td>';
$tbl .= '<td align="right" style="border-top:none;border-bottom:none;">' . $item["item_rate"]. '</td>';
$tbl .= '<td align="right" style="border-top:none;border-bottom:none;">' . $item["item_dispc"]. '</td>';
//$tbl .= '<td align="right" style="border-top:none;border-bottom:none;">' . $item["item_disamount"]. '</td>';

$tbl .= '<td align="right" style="border-top:none;border-bottom:none;">' . $item["taxable_amount"]. '</td>';
$tbl .= '<td align="center" style="width:30px;border-top:none;border-bottom:none;">' . $item["cgst_pc"]. '</td>';

$tbl .= '<td align="right" style="border-top:none;border-bottom:none;">' . $item["cgst_amount"]. '</td>';
$tbl .= '<td align="center" style="border-top:none;border-bottom:none;" >' . $item["sgst_pc"] . '</td>';
$tbl .= '<td align="right" style="border-top:none;border-bottom:none;">' . $item["sgst_amount"] . '</td>';
$tbl .= '<td align="center" style="border-top:none;border-bottom:none;">' . $item["igst_pc"] . '</td>';
$tbl .= '<td align="right" style="border-top:none;border-bottom:none;">' . $item["igst_amount"]. '</td>';
$tbl .= '<td align="right" style="border-top:none;border-bottom:none;">' . number_format($rtot_amt, 2, ".", ",") . '</td>';
$tbl .= '</tr>';

$rw=$rw+1;
        $tax_tot = $tax_tot + $item['taxable_amount'];
        $dis_tot = $dis_tot + $item['item_disamount'];
        $itemamt_tot = $itemamt_tot + $item['item_amount'];
        $taxable_tot = $itemamt_tot ;
        $cgst_tot = $cgst_tot + $item['cgst_amount'];
        $sgst_tot = $sgst_tot + $item['sgst_amount'];
        $igst_tot = $igst_tot + $item['igst_amount'];
        $tot_amt = $tax_tot + $cgst_tot + $sgst_tot + $igst_tot;

if($rc==$pglines) 
{
$rc=1;
    $r=1;
    $pg=$pg+1;
$tbl .= '<div class="pagebreak"></div>';
    $tbl .= '</table>';
    $tbl .= '<br>';
    $tbl .= '<div class="pull-right" align="right"> Contd./-</div>';
$tbl .= '<div class="breakAfter"></div>';
    $tbl .= '<table id="items" style="margin-top:5px;font-size:12px;" >
          <caption style="font-size:30px;text-align:center;">TAX INVOICE</caption>';
$tbl .= '<tr>
            <td colspan="17" valign="top" style="text-align:center;">';
                $tbl .= '<strong style="font-size:35px;text-align:center;color:blue;">' . $this->session->userdata('cname') . '</strong>';

$tbl .='<br><div style="font-size:14px;color:grey;">';
$tbl .= str_replace(",", " | ", $this->session->userdata('cadd') ). ' <br /> ' . "Phone :" . $this->session->userdata('contact') . " | E-mail :" . $this->session->userdata('email'). '<br />
<strong style="font-size:20px;padding-top:10px;color:red;">GSTIN : ' . $this->session->userdata('gstin') . '</div></strong></td>
</tr>';

/*

$tbl .='<tr></tr>
          <th colspan="8" style="text-align:center;">Details of Buyer</th>
          <th colspan="10"  style="text-align:center;">CREDIT kkkkINVOICE</th>  
          <tr>
          
        <div style="float:left; "><td style="float:left;" colspan="6" rowspan="4" valign="top"><strong style="font-size:20px;">' . $bill_to_name . ' </strong><br />' . str_replace(",", "<br>", $bill_add) . ' <br /><strong style="font-size:16px;"> "GSTIN : "' . $value['gstin'] . '</strong><br /> State Code : ' . $bill_statecode . '</td></div>';
  $tbl .= '<td colspan="5" valign="top"><strong>Invoice No.</strong><p align="center"><strong style="font-size:25px;">' . $value['trans_id'] . '</strong></p></td>
  <td colspan="5" valign="top"><strong>Date</strong><p  align="center"><strong style="font-size:25px;">' . $value['trans_date'] . '</strong></p></td></tr><tr>
  <tr><td colspan="5" valign="top"><strong>Reference #</strong><strong style="font-size:18px;"><p align="center">' . $value['order_no'] . '</strong></p></td>';
 $tbl .= '<td colspan="5"><strong>Pages</strong><strong style="font-size:25px;"><p class="text-align:center" align="center">' . $pg . '/' . $pgs . '</strong></p></td>';
  $tbl .= '</tr><tr>';          

*/

$tbl .='<tr></tr>
          <th colspan="6" style="text-align:center;">Details of Buyer</th>
          <th colspan="12"  style="text-align:center;">INVOICE DETAILS</th>';  

$tbl .='<tr><td colspan="6" rowspan="4" valign="top"><strong style="font-size:20px;">M/S. ' . $lname . ' </strong><br />' . str_replace(",", "<br>", $laddress) . ' <br /><strong style="font-size:16px;"> "GSTIN : "' . $lgstin . '</strong><br /> State Code : ' . $lstatecode . '</td>';

$tbl .= '<td colspan="6" valign="top"><strong>Invoice No.</strong><p align="center"><strong style="font-size:25px;">' . $mvalue['trans_id'] . '</strong></p></td><td colspan="6" valign="top"><strong>Date</strong><p  align="center"><strong style="font-size:25px;">' . date("d-m-Y", strtotime($mvalue['trans_date']))  . '</strong></p></td></tr><tr><tr><td colspan="6" valign="top"><strong>Reference #</strong><strong style="font-size:18px;"><p align="center">' . $mvalue['order_no'] . '</strong></p></td>';

$tbl .= '<td colspan="5"><strong>Pages</strong><strong style="font-size:25px;"><p class="text-align:center" align="center">' . $pg . '/' . $pgs . '</strong></p></td>';
  
$tbl .= '</tr><tr>';          
         

         
          $tbl .=  '<tr></tr>';
          $tbl .= '</tr>';
           
           
           $tbl .= '<tr></tr>';
          
          $tbl .= '<tr>
              <th>SL.NO.</th>
              <th style="width:500px" >PRODUCT / SERVICE</th>
              <th>DESCRIPTION</th>
              <th>HSN/SAC</th>
        
              <th>QTY</th>
              <th>UOM</th>
              <th>RATE</th>
              
              <th>DIS%</th>
              <th>TAXABLE VALUE</th>
              <th colspan="2">CGST</td>
              
              
              <th colspan="2">SGST</th>
              <th colspan="2">IGST</th>
              <th>TOTAL AMOUNT</th>
          </tr>
          <tr>
            <th colspan="7"></th>
            <th>%</th>
            
            <th>&#8377;</th>
            <th>%</th>
            <th>&nbsp;&#8377;</th>
            <th>%</th>
            <th>&nbsp;&#8377;</th>
            <th>%</th>
            <th>&nbsp;&#8377;</th>
            <th>&nbsp;&#8377;</th>
            
          </tr>';


     

}
        $rc=$rc+1;


} //items


 $rws=$rc+8;
 while($rws <= $pglines) {
      
     
     $tbl .= '<tr>
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
        <td style="border-top:none;border-bottom:none;"></td></tr><tr>';

$rws=$rws+1;    

}


$r=1;


$tbl .= '<tr><td colspan="6" align="right">Total </td>';
        //$tbl .= '<td align="right"><strong>' . number_format($itemamt_tot, 2, '.', ','). '</strong></td>';
        $tbl .= '<td></td>';
           $tbl .= '<td></td>';
  //      $tbl .= '<td align="right">  <strong>' . number_format($dis_tot, 2, '.', ','). '</strong></td>';
        $tbl .= '<td align="right">  <strong>' . number_format($taxable_tot, 2, '.', ','). '</strong></td>';
        $tbl .= '<td></td>';
        $tbl .= '<td align="right">  <strong>' . number_format($cgst_tot, 2, '.', ','). '</strong></td>';
        $tbl .= '<td></td>';
        $tbl .= '<td align="right"> <strong>' . number_format($sgst_tot, 2, '.', ','). '</strong></td>';
        $tbl .= '<td></td>';
        $tbl .= '<td align="right"><strong> ' . number_format($igst_tot, 2, '.', ','). '</strong></td>';
        $tbl .= '<td align="right"><strong> ' . number_format($tot_amt, 2, '.', ','). '</strong></td>';
$tbl .= '</tr>';
        

$tbl .= '<tr>';
           $f = new NumberFormatter("en", NumberFormatter::SPELLOUT);
$tbl .= '<td valign="top" colspan="17" rowspan="2"><strong>(Rupees in words) :</strong>Rupees ' . ucwords($f->format(round($tot_amt,2))) . " only". '</td>';
$tbl .= '</tr><tr></tr>';
$tbl .= '<table id="items" style="margin-top:5px;font-size:12px;"><tr></tr>';
    
$tbl .= '<th>TAX %</th><th>AMOUNT</th><th>%</th><th>IGST</th><th>%</th><th>CGST</th><th>%</th><th>SGST</th><th>Total</th><tbody>';
 $rwtaxtot =0;
 $tot_amt=0;


//var_dump($taxobj);
foreach ($taxobj as  $taxdata) {
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


 $tbl .= '<tr>';
 $tbl .= '<td align="center">'. $gstpc . '%</td>';
 $tbl .= '<td align="right">' . number_format($taxableamt, 2, '.', ',') . '</td>';
 $tbl .= '<td align="center" >'. $igstpc .'</td>';
 $tbl .= '<td align="right">' . number_format($igstamt, 2, '.', ',') . '</td>';


 $tbl .= '<td align="center" >'. $divgst .'</td>';
 $tbl .= '<td align="right">' . number_format($cgstamt, 2, '.', ',') . '</td>';
 $tbl .= '<td align="center">'. $divgst .'</td>';
 $tbl .= '<td align="right">' . number_format($sgstamt, 2, '.', ',') . '</td>';

 $tbl .= '<td align="right">' . number_format($rwtaxtot, 2, '.', ',') . '</td></tr>';
 $tot_igst =$tot_igst+$igst;
 $tot_cgst =$tot_cgst+$cgst;
 $tot_sgst =$tot_sgst+$sgst;
 $tot_tax = $tot_tax+$rwtaxtot;
 $tot_amt = $tot_amt+$taxableamt;
 $rwtaxtot=0;



} //tax loop

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

 $tbl .= '<tr>
 <td><strong>Total</strong></td><td align="right"><strong>'.  number_format($tot_amt, 2)  .'</strong></td><td></td><td align="right"><strong>'. number_format($totigst, 2) . '</strong></td><td></td><td align="right"><strong>'. number_format($totcgst, 2) . '</strong></td><td></td><td align="right"><strong>'. number_format($totsgst , 2) . '</strong></td><td align="right"><strong>'. number_format($tot_tax , 2) . '</strong></td>'; 

  $tbl .= '</tr>';
  
 $tbl .= '</tbody>';
 $tbl .= '<tr></tr>';
 $tbl .= '</table>';
 $bnkdetails=str_replace(",", "</BR>", $this->session->userdata('cbankdetails'));
    $tbl .= '<table id="items" style="margin-top:5px;font-size:16px;" >
    <tr>
    <td colspan="6"  style="border-right:none"><p>' . $bnkdetails . '</p></td>
    <td colspan="6"  style="border-left:none;" align="right"><h4 align="right" style="font-size:20px;">for <strong> ' . ucwords($this->session->userdata('cname')). '</strong></h4>
                <br /><br /><br />
                <h4 align="right" style="font-size:18px;">Authorized Signatory</h4></td>
    
    </tr>';



} // Bus Type =0

    $tbl .= '</table>';

    
 $tbl .= '<div class=""><p><span style="float:right">This is a Computer Generated Invoice</p></span> </div><br><div align="right">E. & O.E.</div>';



    # code...
//var_dump($value);



} //obj

$tbl .= '</table>';

//$tbl .= '</div></table>';
echo $tbl;

}


public function getPurchasebyid()
{

$flag=$this->input->get('flag');
$id = $this->input->get('id');
$compId = $this->session->userdata('id');
$finyear = $this->session->userdata('finyear');
$trans_type="PURC";
//$url=$this->config->item("api_url") . "/api/gettransactionbyid.php";
$url=$this->config->item("api_url") . "/api/transaction/pursal_byid/" . $id . "/" . $trans_type;
//$data = array("id"=>$id,"finyear"=>$finyear,"compId"=>$compId,"trans_type"=>$trans_type);
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);

  $salesbyidresponse = curl_exec($ch);
//var_dump($salesbyidresponse);
curl_close($ch); // Close the connection
$obj = json_decode($salesbyidresponse,true);
$tbl="";
//var_dump($obj);gegetSalesPurchaseItemsgetSalesPurchaseItemstSalesPurchaseItems

$url=$this->config->item("api_url") . "/api/itemtransaction/pursal_byid/" . $id . "/" . $trans_type;
//$data = array("id"=>$id,"finyear"=>$finyear,"compId"=>$compId,"trans_type"=>$trans_type);
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  $itemsresponse = curl_exec($ch);
//  var_dump($itemsresponse);
$objItems = json_decode($itemsresponse,true);

curl_close($ch); 


//$url=$this->config->item("api_url") . "/api/getinvtype.php";
$url=$this->config->item("api_url") . "/api/invoicetype";
//$post = ['batch_id'=> "2"];

//$data = array("id"=>$actid,"compId"=>$compId);

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  $invtyperesponse = curl_exec($ch);
  //$result = json_decode($response);
//var_dump($data);
//var_dump($ldgresponse);
  curl_close($ch); // Close the connection
//var_dump($invtyperesponse);



foreach ($obj as $key => $value) {
  # code...
//  var_dump($value);

$invoption='';
$invdata =  json_decode($invtyperesponse,true);

foreach ($invdata as $key => $invvalue) {
    
 if($invvalue['inv_type']==$value["inv_type"])
{   
$invoption .= '<option selected value="'.$invvalue['inv_type'].'">'.$invvalue['description'].'</option>';
}
else
{
 $invoption .= '<option value="'. $invvalue['inv_type'].'">'. $invvalue['description'].'</option>';   
}

}


$tbl .='<table id="editInvoice" class="table table-bordered">';
$tbl .='<tr><td><input type="hidden" id="recid" name="recid" value="' . $id . '"><input type="hidden" id="recid" name="statecode" name="statecode"> Inv.#<input type="text" class="form-control" autocomplete="off"  id="editinvoiceno" name="editinvoiceno" value="'. $value['trans_id'] . '" readonly></td><td>Inv.Date<input type="date" class="form-control" autocomplete="off"  id="editinvdate" name="editinvdate" value="'. $value['trans_date'] . '"></td><td>Order #<input type="text" class="form-control" autocomplete="off" id="editorderno" name="editorderno" value="'. $value['order_no'] . '"></td><td>Order Date<input type="date" class="form-control" autocomplete="off"  id="editorderdate" name="editorderdate" value="'. $value['order_date'] . '"></td><td>DC #<input type="text" class="form-control" autocomplete="off"  id="editdcno" name="editdcno" value="'. $value['dc_no'] . '"></td><td>DC Date<input type="date" class="form-control" autocomplete="off"  id="editdcdate" name="editdcdate" value="'. $value['dc_date'] . '"></td></tr>';

$tbl .='<tr><td colspan="3">Customer<input type="text" class="form-control custname" autocomplete="off"  id="customer_name" name="customer_name" value="'. $value['custname'] . '"></td><td>GSTIN#<input type="text"  class="form-control" autocomplete="off" id="editgstin" name="editgstin" value="'. $value['gstin'] . '" readonly></td><td colspan="2">Inv.Type<select  class="form-control" autocomplete="off" id="editinvtype" name="editinvtype" >'. $invoption .'</select> </td></tr>';


}


$tbl .='</table>';


$tbl .='<div class="table-responsive"style="overflow:auto; height:200px;"><table id="editInvoiceItems" border="1" >';
//$itemobj = json_decode($salesbyidresponse['item']);
//var_dump($itemobj);
//echo count($value[0]['items']);
$tbl .='<tr><thead><th>Item Name</th><th>Item Description</th><th>HSNSAC</th><th>GST%</th><th>UOM</th><th>QTY</th><th>RATE</th><th>DIS%</th><th>TAXABLE AMOUNT</th><th>NETT AMOUNT</th><th>?</th></thead></tr><tbody>';
//$count=1;
$unitdata = json_decode($this->getProductUnitArr(),true);
//var_dump($unitdata);
$option='';
if($objItems)
{
$count = count($objItems);
foreach ($objItems as  $item) {

$i=1;

foreach ($unitdata as $key => $uvalue) {
 if($uvalue['unit_id']==$item["item_unit"])
 {   
$option .= '<option selected value="'.$uvalue['unit_id'].'">'.$uvalue['unit_id'].'</option>';
}
else
{
 $option .= '<option value="'.$uvalue['unit_id'].'">'.$uvalue['unit_id'].'</option>';   
}



}

//echo $option;

//var_dump($option);    
    //var_dump($item);
$tbl .='<tr data-row="row'.$count.'" class="trrow" id="row' . $count . '" ><td style="width:25%;"><input style="width:100%;" type="text"  class="form-control itemname" autocomplete="off" id="itemname'.$count.'" name="itemname[]" value="'. $item['item_name'] . '"></td><td><input type="text"  class="form-control itemdesc" autocomplete="off" id="itemdesc'.$count.'" name="itemdesc[]" value="'. $item['item_desc'] . '"></td><td><input type="text"  class="form-control itemhsnsac" autocomplete="off" id="hsnsac'.$count.'" name="hsnsac[]" value="'. $item['item_hsnsac'] . '"></td><td><input type="text"  style="text-align:right"  class="form-control itemgstpc" autocomplete="off" id="itemgstpc'.$count.'" name="itemgstpc[]" value="'. $item['item_gstpc'] . '"></td><td style="width:8%"><select style="width:100%"  class="form-control itemunit" autocomplete="off" id="itemunit'.$count.'" name="itemunit[]">'.$option.'</select></td><td style="width:5%"><input type="text"  style="text-align:right"  class="form-control itemqty" autocomplete="off" id="itemqty'.$count.'" name="itemqty[]" value="'. number_format($item['item_qty'],"0") . '"></td><td style="width:9%"><input type="text"  style="text-align:right"  class="form-control itemrate" autocomplete="off" id="itemrate'.$count.'" name="itemrate[]" value="'. $item['item_rate'] . '"></td><td><input type="text"  style="text-align:right"  class="form-control itemdispc" autocomplete="off" id="itemdispc'.$count.'" name="itemdispc[]" value="'. $item['item_dispc'] . '"></td><td><input type="text"  style="text-align:right"  class="form-control itemamt" autocomplete="off" id="itemamt'.$count.'" name="itemamt[]" value="'. $item['taxable_amount'] . '"></td><td><input type="text"  class="form-control itemnet" autocomplete="off" style="text-align:right"  id="itemnet'.$count.'" name="itemnet[]" value="'. $item['nett_amount'] . '"></td><td><button class="btn btn-sm btn-danger remove" data-row="row'.$count.'" ><i class="fa fa-times"></i></button></td></tr>';

$count--;

}
}


echo $tbl;

}




public function __getPurchasebyid()
{

$flag=$this->input->get('flag');
$id = $this->input->get('id');
$compId = $this->session->userdata('id');
$finyear = $this->session->userdata('finyear');
$trans_type="PURC";
//$url=$this->config->item("api_url") . "/api/gettransactionbyid.php";
$url=$this->config->item("api_url") . "/api/transaction/getSalesPurchaseDatabyId/" . $id . "/" . $trans_type;
$data = array("id"=>$id,"finyear"=>$finyear,"compId"=>$compId,"trans_type"=>$trans_type);
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);

//  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

  $salesbyidresponse = curl_exec($ch);
  //$result = json_decode($response);
//echo $salesbyidresponse;
var_dump($salesbyidresponse);
curl_close($ch); // Close the connection
$obj = json_decode($salesbyidresponse,true);
$tbl="";
//var_dump($obj);

$url=$this->config->item("api_url") . "/api/itemtransaction/" . $id;
$data = array("id"=>$id,"finyear"=>$finyear,"compId"=>$compId,"trans_type"=>$trans_type);
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  $itemsresponse = curl_exec($ch);
curl_close($ch); 
$objItems = json_decode($itemsresponse,true);

$tbl .='<table id="editInvoice" class="table table-bordered">';



foreach ($obj as  $value) {
    # code...
//var_dump($value);





$actid=$obj['db_account'];
//$url=$this->config->item("api_url") . "/api/getsingle_ledger.php?id=" . $actid;
$url=$this->config->item("api_url") . "/api/ledger/" . $actid;
//$post = ['batch_id'=> "2"];

$data = array("id"=>$actid,"compId"=>$compId);

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
//  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
  //curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
  $ldgresponse = curl_exec($ch);
  //$result = json_decode($response);
//var_dump($data);
//var_dump($ldgresponse);
  curl_close($ch); // Close the connection
$ldgerArray = json_decode($ldgresponse);
//var_dump($ldgerArray);
$lname=$ldgerArray->account_name;


//$url=$this->config->item("api_url") . "/api/getinvtype.php";
$url=$this->config->item("api_url") . "/api/invoicetype";
//$post = ['batch_id'=> "2"];

//$data = array("id"=>$actid,"compId"=>$compId);

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  $invtyperesponse = curl_exec($ch);
  //$result = json_decode($response);
//var_dump($data);
//var_dump($ldgresponse);
  curl_close($ch); // Close the connection
//var_dump($invtyperesponse);

$invoption='';
$invdata =  json_decode($invtyperesponse,true);

foreach ($invdata as $key => $invvalue) {
    
 if($invvalue['inv_type']==$obj["inv_type"])
{   
$invoption .= '<option selected value="'.$invvalue['inv_type'].'">'.$invvalue['description'].'</option>';
}
else
{
 $invoption .= '<option value="'. $invvalue['inv_type'].'">'. $invvalue['description'].'</option>';   
}

}



$url=$this->config->item("api_url") . "/api/salesperson";
//$post = ['batch_id'=> "2"];

//$data = array("id"=>$actid,"compId"=>$compId);

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  $salebyresponse = curl_exec($ch);
  //$result = json_decode($response);
//var_dump($data);
//var_dump($ldgresponse);
  curl_close($ch); // Close the connection
//var_dump($invtyperesponse);

$soption='';
$salebydata =  json_decode($salebyresponse,true);

foreach ($salebydata as $key => $svalue) {
    
 if($svalue['id']==$obj["salebyperson"])
{   
$soption .= '<option selected value="'. $svalue['id'].'">'. $svalue['sales_person'].'</option>';
}
else
{
 $soption .= '<option value="'. $svalue['id'].'">'. $svalue['sales_person'].'</option>';   
}

}

if($flag=="pur")
{


$tbl .='<tr><td><input type="hidden" id="recid" name="recid" value="' . $id . '"><input type="hidden" id="recid" name="statecode" name="statecode"> Inv.#<input type="text" class="form-control" autocomplete="off"  id="editinvoiceno" name="editinvoiceno" value="'. $obj['trans_id'] . '" readonly></td><td>Inv.Date<input type="date" class="form-control" autocomplete="off"  id="editinvdate" name="editinvdate" value="'. $obj['trans_date'] . '"></td><td>Order #<input type="text" class="form-control" autocomplete="off" id="editorderno" name="editorderno" value="'. $obj['order_no'] . '"></td><td>Order Date<input type="date" class="form-control" autocomplete="off"  id="editorderdate" name="editorderdate" value="'. $obj['order_date'] . '"></td><td>DC #<input type="text" class="form-control" autocomplete="off"  id="editdcno" name="editdcno" value="'. $obj['dc_no'] . '"></td><td>DC Date<input type="date" class="form-control" autocomplete="off"  id="editdcdate" name="editdcdate" value="'. $obj['dc_date'] . '"></td></tr>';

$tbl .='<tr><td colspan="3">Customer<input type="text" class="form-control custname" autocomplete="off"  id="customer_name" name="customer_name" value="'. $lname . '"></td><td>GSTIN#<input type="text"  class="form-control" autocomplete="off" id="editgstin" name="editgstin" value="'. $obj['gstin'] . '" readonly></td><td colspan="2">Inv.Type<select  class="form-control" autocomplete="off" id="editinvtype" name="editinvtype" >'. $invoption .'</select> </td></tr>';
}






else if($flag=="rpur")
{
$url=$this->config->item("api_url") . "/api/getsettings.php";

$data_array= array("compId"=>$compId,"finyear"=>$finyear);
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_array));
  $setresponse = curl_exec($ch);
  curl_close($ch); // Close the connection
//var_dump($setresponse);
$settArr = json_decode($setresponse);


if($settArr)
{
    # code...
  //var_dump($settArr);
    $dnprefix = $settArr->dn_prefix;
    $dnsuffix = $settArr->dn_suffix;
    $dn_no = $settArr->dn_no;
    $dn_numtype = $settArr->inv_numtype;
    $dn_leadingzero = $settArr->leading_zero;

if($dn_numtype=="ZEROPAD")
{
//$ivno= $inv_no;
$_dnno = sprintf("%0". $dn_leadingzero ."d", $dn_no);
//$invnum = printf("[%0" .$inv_leadingzero ."s]\n",   $ivno); // zero-padding works on strings too

$dnno = $dnprefix . $_dnno . $dnsuffix;
$next_dnno = $dn_no+1;
}
else
{
    $_dnno= $dn_no;
    $dnno = $dnprefix . $_dnno . $dnsuffix;
    $next_dnno = $dn_no+1;
//$dnno = $dnprefix . $_dnno . $dnsuffix;
}



}



$tbl .='<tr><td> Debit Note.#<input type="text" class="form-control" autocomplete="off"  id="cndn_no" name="cndn_no" value="'. $dnno . '" readonly></td><td>Debit Note Date<input type="date" class="form-control" autocomplete="off"  id="cndn_date" name="cndn_date" required></td><td><input type="hidden" id="recid" name="recid" value="' . $id . '"><input type="hidden" id="statecode" value="' . $obj['statecode'] . '" name="statecode"> Inv.#<input type="text" class="form-control" autocomplete="off"  id="invoiceno" name="invoiceno" value="'. $obj['trans_id'] . '" readonly></td><td>Inv.Date<input type="date" class="form-control" autocomplete="off"  id="invdate" name="invdate" value="'. $obj['trans_date'] . '" readonly></td></tr>';



$tbl .='<tr><td>Customer<input type="text" class="form-control custname" autocomplete="off"  id="customer_name" name="customer_name" value="'. $lname . '" readonly></td><td>GSTIN#<input type="text"  class="form-control" autocomplete="off" id="gstin" name="gstin" value="'. $obj['gstin'] . '" readonly></td><td>Inv.Type<select  class="form-control" autocomplete="off" id="invtype" name="invtype" readonly >'. $invoption .'</select> </td><td>Sales by<select class="form-control" autocomplete="off" id="salebyperson" name="salebyperson" readonly>'. $soption .'</select> </td></tr>';

/*
$tbl .='<tr><td> <input type="hidden" id="recid" name="recid" value="' . $id . '"><input type="hidden" id="recid" name="statecode" name="statecode"> Inv.#<input type="text" class="form-control" autocomplete="off"  id="editinvoiceno" name="editinvoiceno" value="'. $value['trans_id'] . '" readonly></td><td>Inv.Date<input type="date" class="form-control" autocomplete="off"  id="editinvdate" name="editinvdate" value="'. $value['trans_date'] . '"></td><td>Order #<input type="text" class="form-control" autocomplete="off" id="editorderno" name="editorderno" value="'. $value['order_no'] . '"></td><td>Order Date<input type="date" class="form-control" autocomplete="off"  id="editorderdate" name="editorderdate" value="'. $value['order_date'] . '"></td><td>DC #<input type="text" class="form-control" autocomplete="off"  id="editdcno" name="editdcno" value="'. $value['dc_no'] . '"></td><td>DC Date<input type="date" class="form-control" autocomplete="off"  id="editdcdate" name="editdcdate" value="'. $value['dc_date'] . '"></td></tr>';

$tbl .='<tr><td colspan="3">Customer<input type="text" class="form-control custname" autocomplete="off"  id="customer_name" name="customer_name" value="'. $lname . '"></td><td>GSTIN#<input type="text"  class="form-control" autocomplete="off" id="editgstin" name="editgstin" value="'. $value['gstin'] . '" readonly></td><td colspan="2">Inv.Type<select  class="form-control" autocomplete="off" id="editinvtype" name="editinvtype" >'. $invoption .'</select> </td></tr>';*/
}



$tbl .='</table>';


$tbl .='<div class="table-responsive"style="overflow:auto; height:200px;"><table id="editInvoiceItems" border="1" >';
//$itemobj = json_decode($salesbyidresponse['item']);
//var_dump($itemobj);
//echo count($value[0]['items']);
$tbl .='<tr><thead><th>Item Name</th><th>Item Description</th><th>HSNSAC</th><th>GST%</th><th>UOM</th><th>QTY</th><th>RATE</th><th>DIS%</th><th>TAXABLE AMOUNT</th><th>NETT AMOUNT</th><th>?</th></thead></tr><tbody>';
//$count=1;
$unitdata = json_decode($this->getProductUnitArr(),true);
//var_dump($unitdata);
$option='';
$count = count($value[0]['items']);
foreach ($value[0]['items'] as  $item) {

$i=1;

foreach ($unitdata['units'] as $key => $uvalue) {
 if($uvalue['unit_id']==$item["item_unit"])
 {   
$option .= '<option selected value="'.$uvalue['unit_id'].'">'.$uvalue['unit_id'].'</option>';
}
else
{
 $option .= '<option value="'.$uvalue['unit_id'].'">'.$uvalue['unit_id'].'</option>';   
}
}

//echo $option;

//var_dump($option);    
    //var_dump($item);
$tbl .='<tr data-row="row'.$count.'" class="trrow" id="row' . $count . '" ><td style="width:25%;"><input style="width:100%;" type="text"  class="form-control itemname" autocomplete="off" id="itemname'.$count.'" name="itemname[]" value="'. $item['item_name'] . '"></td><td><input type="text"  class="form-control itemdesc" autocomplete="off" id="itemdesc'.$count.'" name="itemdesc[]" value="'. $item['item_desc'] . '"></td><td><input type="text"  class="form-control itemhsnsac" autocomplete="off" id="hsnsac'.$count.'" name="hsnsac[]" value="'. $item['item_hsnsac'] . '"></td><td><input type="text"  style="text-align:right"  class="form-control itemgstpc" autocomplete="off" id="itemgstpc'.$count.'" name="itemgstpc[]" value="'. $item['item_gstpc'] . '"></td><td style="width:8%"><select style="width:100%"  class="form-control itemunit" autocomplete="off" id="itemunit'.$count.'" name="itemunit[]">'.$option.'</select></td><td style="width:5%"><input type="text"  style="text-align:right"  class="form-control itemqty" autocomplete="off" id="itemqty'.$count.'" name="itemqty[]" value="'. number_format($item['item_qty'],"0") . '"></td><td style="width:9%"><input type="text"  style="text-align:right"  class="form-control itemrate" autocomplete="off" id="itemrate'.$count.'" name="itemrate[]" value="'. $item['item_rate'] . '"></td><td><input type="text"  style="text-align:right"  class="form-control itemdispc" autocomplete="off" id="itemdispc'.$count.'" name="itemdispc[]" value="'. $item['item_dispc'] . '"></td><td><input type="text"  style="text-align:right"  class="form-control itemamt" autocomplete="off" id="itemamt'.$count.'" name="itemamt[]" value="'. $item['taxable_amount'] . '"></td><td><input type="text"  class="form-control itemnet" autocomplete="off" style="text-align:right"  id="itemnet'.$count.'" name="itemnet[]" value="'. $item['nett_amount'] . '"></td><td><button class="btn btn-sm btn-danger remove" data-row="row'.$count.'" ><i class="fa fa-times"></i></button></td></tr>';

$count--;

}

}
$tbl .='</tbody></table></div>';
echo $tbl;
}





public function getSalesbyid()
{

$flag=$this->input->get('flag');
$id = $this->input->get('id');
$compId = $this->session->userdata('id');
$finyear = $this->session->userdata('finyear');
$trans_type="SALE";
//$url=$this->config->item("api_url") . "/api/gettransactionbyid.php";
$url=$this->config->item("api_url") . "/api/transaction/pursal_byid/" . $id . "/" . $trans_type;
//$data = array("id"=>$id,"finyear"=>$finyear,"compId"=>$compId,"trans_type"=>$trans_type);
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);

  $salesbyidresponse = curl_exec($ch);
//var_dump($salesbyidresponse);
curl_close($ch); // Close the connection
$obj = json_decode($salesbyidresponse,true);
$tbl="";
//var_dump($obj);gegetSalesPurchaseItemsgetSalesPurchaseItemstSalesPurchaseItems

$url=$this->config->item("api_url") . "/api/itemtransaction/pursal_byid/" . $id . "/" . $trans_type;
//$data = array("id"=>$id,"finyear"=>$finyear,"compId"=>$compId,"trans_type"=>$trans_type);
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  $itemsresponse = curl_exec($ch);
//  var_dump($itemsresponse);
$objItems = json_decode($itemsresponse,true);

curl_close($ch); 


//$url=$this->config->item("api_url") . "/api/getinvtype.php";
$url=$this->config->item("api_url") . "/api/invoicetype";
//$post = ['batch_id'=> "2"];

//$data = array("id"=>$actid,"compId"=>$compId);

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  $invtyperesponse = curl_exec($ch);
  //$result = json_decode($response);
//var_dump($data);
//var_dump($ldgresponse);
  curl_close($ch); // Close the connection
//var_dump($invtyperesponse);



foreach ($obj as $key => $value) {
  # code...
//  var_dump($value);

$invoption='';
$invdata =  json_decode($invtyperesponse,true);

foreach ($invdata as $key => $invvalue) {
    
 if($invvalue['inv_type']==$value["inv_type"])
{   
$invoption .= '<option selected value="'.$invvalue['inv_type'].'">'.$invvalue['description'].'</option>';
}
else
{
 $invoption .= '<option value="'. $invvalue['inv_type'].'">'. $invvalue['description'].'</option>';   
}

}

$url=$this->config->item("api_url") . "/api/salesperson";
//$url=$this->config->item("api_url") . "/api/getSalesPerson.php";
//$post = ['batch_id'=> "2"];

//$data = array("id"=>$actid,"compId"=>$compId);

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  $salebyresponse = curl_exec($ch);
  //$result = json_decode($response);
//var_dump($data);
//var_dump($ldgresponse);
  curl_close($ch); // Close the connection
//var_dump($invtyperesponse);

$soption='';
$salebydata =  json_decode($salebyresponse,true);

foreach ($salebydata as $key => $svalue) {
    
 if($svalue['id']==$value["salebyperson"])
{   
$soption .= '<option selected value="'. $svalue['id'].'">'. $svalue['sales_person'].'</option>';
}
else
{
 $soption .= '<option value="'. $svalue['id'].'">'. $svalue['sales_person'].'</option>';   
}

}
$tbl .='<table id="editInvoice" class="table table-bordered">';
$tbl .='<tr><td><input type="hidden" id="recid" name="recid" value="' . $id . '"><input type="hidden" id="recid" name="statecode" name="statecode"> Inv.#<input type="text" class="form-control" autocomplete="off"  id="editinvoiceno" name="editinvoiceno" value="'. $value['trans_id'] . '" readonly></td><td>Inv.Date<input type="date" class="form-control" autocomplete="off"  id="editinvdate" name="editinvdate" value="'. $value['trans_date'] . '"></td><td>Order #<input type="text" class="form-control" autocomplete="off" id="editorderno" name="editorderno" value="'. $value['order_no'] . '"></td><td>Order Date<input type="date" class="form-control" autocomplete="off"  id="editorderdate" name="editorderdate" value="'. $value['order_date'] . '"></td><td>Sales by<select class="form-control" autocomplete="off" id="editsalebyperson" name="editsalebyperson">'. $soption .'</select> </td></tr>';


$tbl .='<tr><td>DC #<input type="text" class="form-control" autocomplete="off"  id="editdcno" name="editdcno" value="'. $value['dc_no'] . '"></td><td>DC Date<input type="date" class="form-control" autocomplete="off"  id="editdcdate" name="editdcdate" value="'. $value['dc_date'] . '"></td><td>Customer<input type="text" class="form-control custname" autocomplete="off"  id="customer_name" name="customer_name" value="'. $value['custname'] . '"></td><td>GSTIN#<input type="text"  class="form-control" autocomplete="off" id="editgstin" name="editgstin" value="'. $value['gstin'] . '" readonly></td><td>Inv.Type<select  class="form-control" autocomplete="off" id="editinvtype" name="editinvtype" >'. $invoption .'</select> </td></tr>';

/*
$tbl .='<table id="editInvoice" class="table table-bordered">';
$tbl .='<tr><td><input type="hidden" id="recid" name="recid" value="' . $id . '"><input type="hidden" id="recid" name="statecode" name="statecode"> Inv.#<input type="text" class="form-control" autocomplete="off"  id="editinvoiceno" name="editinvoiceno" value="'. $value['trans_id'] . '" readonly></td><td>Inv.Date<input type="date" class="form-control" autocomplete="off"  id="editinvdate" name="editinvdate" value="'. $value['trans_date'] . '"></td><td>Order #<input type="text" class="form-control" autocomplete="off" id="editorderno" name="editorderno" value="'. $value['order_no'] . '"></td><td>Order Date<input type="date" class="form-control" autocomplete="off"  id="editorderdate" name="editorderdate" value="'. $value['order_date'] . '"></td><td>DC #<input type="text" class="form-control" autocomplete="off"  id="editdcno" name="editdcno" value="'. $value['dc_no'] . '"></td><td>DC Date<input type="date" class="form-control" autocomplete="off"  id="editdcdate" name="editdcdate" value="'. $value['dc_date'] . '"></td></tr>';

$tbl .='<tr><td colspan="3">Customer<input type="text" class="form-control custname" autocomplete="off"  id="customer_name" name="customer_name" value="'. $value['custname'] . '"></td><td>GSTIN#<input type="text"  class="form-control" autocomplete="off" id="editgstin" name="editgstin" value="'. $value['gstin'] . '" readonly></td><td colspan="2">Inv.Type<select  class="form-control" autocomplete="off" id="editinvtype" name="editinvtype" >'. $invoption .'</select> </td></tr>';
*/

}


$tbl .='</table>';


$tbl .='<div class="table-responsive"style="overflow:auto; height:200px;"><table id="editInvoiceItems" border="1" >';
//$itemobj = json_decode($salesbyidresponse['item']);
//var_dump($itemobj);
//echo count($value[0]['items']);
$tbl .='<tr><thead><th>Item Name</th><th>Item Description</th><th>HSNSAC</th><th>GST%</th><th>UOM</th><th>QTY</th><th>RATE</th><th>DIS%</th><th>TAXABLE AMOUNT</th><th>NETT AMOUNT</th><th>?</th></thead></tr><tbody>';
//$count=1;
$unitdata = json_decode($this->getProductUnitArr(),true);
//var_dump($unitdata);
$option='';
if($objItems)
{
$count = count($objItems);
foreach ($objItems as  $item) {

$i=1;

foreach ($unitdata as $key => $uvalue) {
 if($uvalue['unit_id']==$item["item_unit"])
 {   
$option .= '<option selected value="'.$uvalue['unit_id'].'">'.$uvalue['unit_id'].'</option>';
}
else
{
 $option .= '<option value="'.$uvalue['unit_id'].'">'.$uvalue['unit_id'].'</option>';   
}



}

//echo $option;

//var_dump($option);    
    //var_dump($item);
$tbl .='<tr data-row="row'.$count.'" class="trrow" id="row' . $count . '" ><td style="width:25%;"><input style="width:100%;" type="text"  class="form-control itemname" autocomplete="off" id="itemname'.$count.'" name="itemname[]" value="'. $item['item_name'] . '"></td><td><input type="text"  class="form-control itemdesc" autocomplete="off" id="itemdesc'.$count.'" name="itemdesc[]" value="'. $item['item_desc'] . '"></td><td><input type="text"  class="form-control itemhsnsac" autocomplete="off" id="hsnsac'.$count.'" name="hsnsac[]" value="'. $item['item_hsnsac'] . '"></td><td><input type="text"  style="text-align:right"  class="form-control itemgstpc" autocomplete="off" id="itemgstpc'.$count.'" name="itemgstpc[]" value="'. $item['item_gstpc'] . '"></td><td style="width:8%"><select style="width:100%"  class="form-control itemunit" autocomplete="off" id="itemunit'.$count.'" name="itemunit[]">'.$option.'</select></td><td style="width:5%"><input type="text"  style="text-align:right"  class="form-control itemqty" autocomplete="off" id="itemqty'.$count.'" name="itemqty[]" value="'. number_format($item['item_qty'],"0") . '"></td><td style="width:9%"><input type="text"  style="text-align:right"  class="form-control itemrate" autocomplete="off" id="itemrate'.$count.'" name="itemrate[]" value="'. $item['item_rate'] . '"></td><td><input type="text"  style="text-align:right"  class="form-control itemdispc" autocomplete="off" id="itemdispc'.$count.'" name="itemdispc[]" value="'. $item['item_dispc'] . '"></td><td><input type="text"  style="text-align:right"  class="form-control itemamt" autocomplete="off" id="itemamt'.$count.'" name="itemamt[]" value="'. $item['taxable_amount'] . '"></td><td><input type="text"  class="form-control itemnet" autocomplete="off" style="text-align:right"  id="itemnet'.$count.'" name="itemnet[]" value="'. $item['nett_amount'] . '"></td><td><button class="btn btn-sm btn-danger remove" data-row="row'.$count.'" ><i class="fa fa-times"></i></button></td></tr>';

$count--;

}
}


echo $tbl;

}




public function __oldgetSalesbyid()
{
$flag= $this->input->get('flag');
$id = $this->input->get('id');
$compId = $this->session->userdata('id');
$finyear = $this->session->userdata('finyear');
$trans_type="SALE";
$url=$this->config->item("api_url") . "/api/transaction/pursal_byid/" . $id . "/" . $trans_type;

//$url=$this->config->item("api_url") . "/api/gettransactionbyid.php";
$data = array("id"=>$id,"finyear"=>$finyear,"compId"=>$compId,"trans_type"=>$trans_type);
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);

  $salesbyidresponse = curl_exec($ch);
  //$result = json_decode($response);
//echo $salesbyidresponse;

curl_close($ch); // Close the connection
$obj = json_decode($salesbyidresponse,true);
$tbl="";
//var_dump($obj);

$tbl .='<table id="editInvoice" class="table table-bordered">';
foreach ($obj as  $value) {
    # code...
//var_dump($value);
$actid=$value['db_account'];

$url=$this->config->item("api_url") . "/api/ledger/" .$actid;
//$post = ['batch_id'=> "2"];

$data = array("id"=>$actid,"compId"=>$compId);

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  //curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
  $ldgresponse = curl_exec($ch);
  //$result = json_decode($response);
//var_dump($data);
//var_dump($ldgresponse);
  curl_close($ch); // Close the connection
$ldgerArray = json_decode($ldgresponse);
//var_dump($ldgerArray);
$lname=$ldgerArray->account_name;

$url=$this->config->item("api_url") . "/api/invoicetype";
//$url=$this->config->item("api_url") . "/api/getinvtype.php";
//$post = ['batch_id'=> "2"];

//$data = array("id"=>$actid,"compId"=>$compId);

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  $invtyperesponse = curl_exec($ch);
  //$result = json_decode($response);
//var_dump($data);
//var_dump($ldgresponse);
  curl_close($ch); // Close the connection
//var_dump($invtyperesponse);

$invoption='';
$invdata =  json_decode($invtyperesponse,true);

foreach ($invdata as $key => $invvalue) {
    
 if($invvalue['inv_type']==$value["inv_type"])
{   
$invoption .= '<option selected value="'.$invvalue['inv_type'].'">'.$invvalue['description'].'</option>';
}
else
{
 $invoption .= '<option value="'. $invvalue['inv_type'].'">'. $invvalue['description'].'</option>';   
}

}


$url=$this->config->item("api_url") . "/api/salesperson";
//$url=$this->config->item("api_url") . "/api/getSalesPerson.php";
//$post = ['batch_id'=> "2"];

//$data = array("id"=>$actid,"compId"=>$compId);

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  $salebyresponse = curl_exec($ch);
  //$result = json_decode($response);
//var_dump($data);
//var_dump($ldgresponse);
  curl_close($ch); // Close the connection
//var_dump($invtyperesponse);

$soption='';
$salebydata =  json_decode($salebyresponse,true);

foreach ($salebydata as $key => $svalue) {
    
 if($svalue['id']==$value["salebyperson"])
{   
$soption .= '<option selected value="'. $svalue['id'].'">'. $svalue['sales_person'].'</option>';
}
else
{
 $soption .= '<option value="'. $svalue['id'].'">'. $svalue['sales_person'].'</option>';   
}

}

if($flag=="sl")
{
$tbl .='<tr><td><input type="hidden" id="recid" name="recid" value="' . $id . '"><input type="hidden" id="recid" name="statecode" name="statecode"> Inv.#<input type="text" class="form-control" autocomplete="off"  id="editinvoiceno" name="editinvoiceno" value="'. $value['trans_id'] . '" readonly></td><td>Inv.Date<input type="date" class="form-control" autocomplete="off"  id="editinvdate" name="editinvdate" value="'. $value['trans_date'] . '"></td><td>Order #<input type="text" class="form-control" autocomplete="off" id="editorderno" name="editorderno" value="'. $value['order_no'] . '"></td><td>Order Date<input type="date" class="form-control" autocomplete="off"  id="editorderdate" name="editorderdate" value="'. $value['order_date'] . '"></td><td>Sales by<select class="form-control" autocomplete="off" id="editsalebyperson" name="editsalebyperson">'. $soption .'</select> </td></tr>';


$tbl .='<tr><td>DC #<input type="text" class="form-control" autocomplete="off"  id="editdcno" name="editdcno" value="'. $value['dc_no'] . '"></td><td>DC Date<input type="date" class="form-control" autocomplete="off"  id="editdcdate" name="editdcdate" value="'. $value['dc_date'] . '"></td><td>Customer<input type="text" class="form-control custname" autocomplete="off"  id="customer_name" name="customer_name" value="'. $lname . '"></td><td>GSTIN#<input type="text"  class="form-control" autocomplete="off" id="editgstin" name="editgstin" value="'. $value['gstin'] . '" readonly></td><td>Inv.Type<select  class="form-control" autocomplete="off" id="editinvtype" name="editinvtype" >'. $invoption .'</select> </td></tr>';

}
else if($flag=="sr")
{

//$url=$this->config->item("api_url") . "/api/getsettings.php";
$url=$this->config->item("api_url") . "/api/settings";

$data_array= array("compId"=>$compId,"finyear"=>$finyear);
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  //curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_array));
  $setresponse = curl_exec($ch);
  curl_close($ch); // Close the connection
//var_dump($setresponse);
$settArr = json_decode($setresponse);


if($settArr)
{
    # code...
  //var_dump($settArr);
    $dnprefix = $settArr->dn_prefix;
    $dnsuffix = $settArr->dn_suffix;
    $dn_no = $settArr->dn_no;
    $dn_numtype = $settArr->inv_numtype;
    $dn_leadingzero = $settArr->leading_zero;

if($dn_numtype=="ZEROPAD")
{
//$ivno= $inv_no;
$_dnno = sprintf("%0". $dn_leadingzero ."d", $dn_no);
//$invnum = printf("[%0" .$inv_leadingzero ."s]\n",   $ivno); // zero-padding works on strings too

$dnno = $dnprefix . $_dnno . $dnsuffix;
$next_dnno = $dn_no+1;
}
else
{
    $_dnno= $dn_no;
    $dnno = $dnprefix . $_dnno . $dnsuffix;
    $next_dnno = $dn_no+1;
//$dnno = $dnprefix . $_dnno . $dnsuffix;
}



}


$tbl .='<tr><td> Debit Note.#<input type="text" class="form-control" autocomplete="off"  id="cndn_no" name="cndn_no" value="'. $dnno . '" readonly></td><td>Debit Note Date<input type="date" class="form-control" autocomplete="off"  id="cndn_date" name="cndn_date" required></td><td><input type="hidden" id="recid" name="recid" value="' . $id . '"><input type="hidden" id="statecode" value="' . $value['statecode'] . '" name="statecode"> Inv.#<input type="text" class="form-control" autocomplete="off"  id="invoiceno" name="invoiceno" value="'. $value['trans_id'] . '" readonly></td><td>Inv.Date<input type="date" class="form-control" autocomplete="off"  id="invdate" name="invdate" value="'. $value['trans_date'] . '" readonly></td></tr>';



$tbl .='<tr><td>Customer<input type="text" class="form-control custname" autocomplete="off"  id="customer_name" name="customer_name" value="'. $lname . '" readonly></td><td>GSTIN#<input type="text"  class="form-control" autocomplete="off" id="gstin" name="gstin" value="'. $value['gstin'] . '" readonly></td><td>Inv.Type<select  class="form-control" autocomplete="off" id="invtype" name="invtype" readonly >'. $invoption .'</select> </td><td>Sales by<select class="form-control" autocomplete="off" id="salebyperson" name="salebyperson" readonly>'. $soption .'</select> </td></tr>';
}
$tbl .='</table>';


$tbl .='<div class="table-responsive"style="overflow:auto; height:200px;"><table id="editInvoiceItems" border="1" >';
//$itemobj = json_decode($salesbyidresponse['item']);
//var_dump($itemobj);
//echo count($value[0]['items']);
$tbl .='<tr><thead><th>Item Name</th><th>Item Description</th><th>HSNSAC</th><th>GST%</th><th>UOM</th><th>STK</th><th>QTY</th><th>RATE</th><th>DIS%</th><th>TAXABLE AMOUNT</th><th>NETT AMOUNT</th><th>?</th></thead></tr><tbody>';
//$count=1;
$unitdata = json_decode($this->getProductUnitArr(),true);
//var_dump($unitdata);
$option='';
$count = count($value['items']);
foreach ($value['items'] as  $item) {

$i=1;

foreach ($unitdata['units'] as $key => $uvalue) {
 if($uvalue['unit_id']==$item["item_unit"])
 {   
$option .= '<option selected value="'.$uvalue['unit_id'].'">'.$uvalue['unit_id'].'</option>';
}
else
{
 $option .= '<option value="'.$uvalue['unit_id'].'">'.$uvalue['unit_id'].'</option>';   
}
}

//echo $option;

//var_dump($option);    
    //var_dump($item);
$tbl .='<tr data-row="row'.$count.'" class="trrow" id="row' . $count . '" ><td style="width:25%;"><input style="width:100%;" type="text"  class="form-control itemname" autocomplete="off" id="itemname'.$count.'" name="itemname[]" value="'. $item['item_name'] . '"></td><td><input type="text"  class="form-control itemdesc" autocomplete="off" id="itemdesc'.$count.'" name="itemdesc[]" value="'. $item['item_desc'] . '"></td><td><input type="text"  class="form-control itemhsnsac" autocomplete="off" id="hsnsac'.$count.'" name="hsnsac[]" value="'. $item['item_hsnsac'] . '"></td><td><input type="text"  style="text-align:right"  class="form-control itemgstpc" autocomplete="off" id="itemgstpc'.$count.'" name="itemgstpc[]" value="'. $item['item_gstpc'] . '"></td><td style="width:8%"><select style="width:100%"  class="form-control itemunit" autocomplete="off" id="itemunit'.$count.'" name="itemunit[]">'.$option.'</select></td><td style="width:5%"><input type="text"  style="text-align:right"  class="form-control itemqty" autocomplete="off" id="itemstk'.$count.'" name="itemstk[]" value="'. $item['item_stock'] . '"></td><td style="width:5%"><input type="text"  style="text-align:right"  class="form-control itemqty" autocomplete="off" id="itemqty'.$count.'" name="itemqty[]" value="'. $item['item_qty'] . '"></td><td style="width:9%"><input type="text"  style="text-align:right"  class="form-control itemrate" autocomplete="off" id="itemrate'.$count.'" name="itemrate[]" value="'. $item['item_rate'] . '"></td><td><input type="text"  style="text-align:right"  class="form-control itemdispc" autocomplete="off" id="itemdispc'.$count.'" name="itemdispc[]" value="'. $item['item_dispc'] . '"></td><td><input type="text"  style="text-align:right"  class="form-control itemamt" autocomplete="off" id="itemamt'.$count.'" name="itemamt[]" value="'. $item['taxable_amount'] . '"></td><td><input type="text"  class="form-control itemnet" autocomplete="off" style="text-align:right"  id="itemnet'.$count.'" name="itemnet[]" value="'. $item['nett_amount'] . '"></td><td><button class="btn btn-sm btn-danger remove" data-row="row'.$count.'" ><i class="fa fa-times"></i></button></td></tr>';

$count--;

}

}
$tbl .='</tbody></table></div>';
echo $tbl;
}




public function getsaleschart()
{
$compId = $this->session->userdata('id');
$finyear = $this->session->userdata('finyear');
$trans_type="SALE";
$url=$this->config->item("api_url") . "/api/productlist/chartData";
$postdata = array("finyear"=>$finyear,"compId"=>$compId,"trans_type"=>$trans_type);
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  //curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");  
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postdata));

 $chartresponse = curl_exec($ch);
  //$result = json_decode($response);
//echo $salesresponse;

curl_close($ch); // Close the connection
echo $chartresponse;

}

public function getallPurchase()
{
$data=array();    
$compId = $this->session->userdata('id');
$finyear = $this->session->userdata('finyear');
$trans_type="PURC";
//var_dump($compId . $finyear); 
$url=$this->config->item("api_url") . "/api/getallsales.php";
$data = array("finyear"=>$finyear,"compId"=>$compId,"trans_type"=>$trans_type);
//$post = ['batch_id'=> "2"];
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

  $salesresponse = curl_exec($ch);
  //$result = json_decode($response);
//echo $salesresponse;

curl_close($ch); // Close the connection
$tbl='<table class="table table-bordered" id="saleslistTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>ACTION</th>
                      <th>INVOICE#</th>
                      <th>INVOICE DATE</th>
                      <th>CUSTOMER</th>
                      <th>GSTIN</th>
                      <th>TAXABLE VALUE</th>
                      <th>GST</th>
                      <th>NETT VALUE</th>

                    </tr>
                  </thead>
                  <tbody id="saleslist">';


$maindata = json_decode($salesresponse,true);
foreach ($maindata as $key => $d) 
{
    # code...
$gst_tot = $d['net_amount']-$d['taxable_amount'];

$tbl .='<tr><td><div class="btn-group"><button type="button" class="btn btn-info btn-circle btn-xs center-block"  href="#" data-toggle="modal" data-backdrop="static" data-keyboard="true" data-target="#modalEditPurchase" onclick="updateTransid(' . $d['id'] . ')"><i class="fa fa-edit"></i></button><button type="button" class="btn btn-danger btn-circle btn-xs center-block"  href="#" data-toggle="modal" data-backdrop="static" data-keyboard="true" data-target="#modalRPurchase" onclick="rpurchaseTransid(' . $d['id'] . ')"><i class="fa fa-redo"></i></button>' . '<td style="width:30%;">'. $d['trans_id'] .'</td>' . '<td>'. $d['trans_date'] .'</td>'. '<td style="width:100%;">'. $d['custname'] .'</td>' . '<td>'. $d['gstin'] .'</td>'. '<td style="text-align:right;">'. number_format($d['taxable_amount'],"2") .'</td>'. '<td style="text-align:right;">' . number_format($gst_tot,"2") . '</td><td style="text-align:right;">'. number_format($d['net_amount'],"2") .'</td>'  .'</tr>';
}


$tbl .='</tbody></table>';

echo $tbl;
}


public function getallSales()
{
$data=array();    
$compId = $this->session->userdata('id');
$finyear = $this->session->userdata('finyear');
$trans_type="SALE";
//var_dump($compId . $finyear); 
$url=$this->config->item("api_url") . "/api/getallsales.php";
$data = array("finyear"=>$finyear,"compId"=>$compId,"trans_type"=>$trans_type);
//$post = ['batch_id'=> "2"];
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

  $salesresponse = curl_exec($ch);
  //$result = json_decode($response);
//echo $salesresponse;

curl_close($ch); // Close the connection
$tbl='<table class="table table-bordered" id="saleslistTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>ACTION</th>
                      <th>INVOICE#</th>
                      <th>INVOICE DATE</th>
                      <th>CUSTOMER</th>
                      <th>GSTIN</th>
                      <th>ITMES</th>
                      <th>TAXABLE VALUE</th>
                      <th>GST</th>
                      <th>NETT VALUE</th>

                    </tr>
                  </thead>
                  <tbody id="saleslist">';


$maindata = json_decode($salesresponse,true);
foreach ($maindata as $key => $d) 
{
    # code...
$gst_tot = $d['net_amount']-$d['taxable_amount'];

$tbl .='<tr><td><div class="btn-group"><button type="button" class="btn btn-warning btn-circle btn-xs center-block"  href="#" data-toggle="modal" data-backdrop="static" data-keyboard="true" data-target="#modalEditSales" onclick="updateTransid(' . $d['id'] . ')"><i class="fa fa-edit"></i></button><button type="button" class="btn btn-primary btn-circle btn-xs center-block" href="#" onclick="printTransid('. $d['id']. ')"><i class="fa fa-print"></i></button>' . '<td style="width:30%;">'. $d['trans_id'] .'</td>' . '<td>'. $d['trans_date'] .'</td>'. '<td style="width:100%;">'. $d['custname'] .'</td>' . '<td>'. $d['gstin'] .'</td>'. '<td style="text-align:right;">'. number_format($d['taxable_amount'],"2") .'</td>'. '<td style="text-align:right;">' . number_format($gst_tot,"2") . '</td><td style="text-align:right;">'. number_format($d['net_amount'],"2") .'</td>'  .'</tr>';
}


$tbl .='</tbody></table>';

echo $tbl;
}


public function getallRSaleslist()
{
$data=array();    
$compId = $this->session->userdata('id');
$finyear = $this->session->userdata('finyear');
$trans_type="SRTN";
//var_dump($compId . $finyear); 
$url=$this->config->item("api_url") . "/api/getallrsales.php";
$data = array("finyear"=>$finyear,"compId"=>$compId,"trans_type"=>$trans_type);
//$post = ['batch_id'=> "2"];
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

  $salesresponse = curl_exec($ch);
  //$result = json_decode($response);
//echo $salesresponse;

curl_close($ch); // Close the connection
$maindata = json_decode($salesresponse,true);
$data=array();
foreach ($maindata as $key => $d) 
{
//var_dump($d);
    # code...
$gst_tot = $d['net_amount']-$d['taxable_amount'];

$button="<div class='btn-group'><button type='button' class='btn btn-warning btn-circle btn-xs center-block'  href='#' data-toggle='modal' data-target='#modalEditSales'  onclick='updateTransid(" . $d["id"] . ")'><i class='fa fa-edit'></i></button></div>";

$data['data'][]=array("action"=>$button,"cn_id"=>$d['cn_id'],"cn_date"=>$d['cn_date'],"trans_id"=>$d['trans_id'],"trans_date"=>$d['trans_date'],"custname"=>$d['custname'],"gstin"=>$d['gstin'],"taxable_amount"=>$d['taxable_amount'],"gst_tot"=>$gst_tot,"net_amount"=>$d['net_amount'],"noi"=>$d['noi']);

}


//$tbl .='</tbody></table>';

echo json_encode($data);
}




public function getallSaleslist()
{
$data=array();    
$compId = $this->session->userdata('id');
$finyear = $this->session->userdata('finyear');
$trans_type="SALE";
//var_dump($compId . $finyear); 
//$url=$this->config->item("api_url") . "/api/getallsales.php";
//$data = array("finyear"=>$finyear,"compId"=>$compId,"trans_type"=>$trans_type);
//$post = ['batch_id'=> "2"];
$data = array("finyear"=>$finyear,"compId"=>$compId,"trans_type"=>$trans_type);
$url=$this->config->item("api_url") . "/api/transaction/pursal/" . $trans_type . "/" . $finyear ;
//$url=$this->config->item("api_url") . "/api/transaction/pursal/" . $trans_type;

//$post = ['batch_id'=> "2"];
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  //curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

  $salesresponse = curl_exec($ch);
  //$result = json_decode($response);
//echo $salesresponse;
//var_dump($salesresponse);
curl_close($ch); // Close the connection
$maindata = json_decode($salesresponse,true);

$data=array();
if($maindata)
{
foreach ($maindata as $key => $d) 
{
//var_dump($d);
    # code...
$gst_tot = $d['net_tot']-$d['txb_tot'];

/*$tbl .='<tr><td><div class="btn-group"><button type="button" class="btn btn-warning btn-circle btn-xs center-block"  href="#" data-toggle="modal" data-target="#modalEditSales"  onclick="updateTransid(' . $d['id'] . ')"><i class="fa fa-edit"></i></button><button type="button" class="btn btn-primary btn-circle btn-xs center-block" href="#" onclick="printTransid('. $d['id']. ')"><i class="fa fa-print"></i></button>' . '<td style="width:30%;">'. $d['trans_id'] .'</td>' . '<td>'. $d['trans_date'] .'</td>'. '<td style="width:100%;">'. $d['custname'] .'</td>' . '<td>'. $d['gstin'] .'</td>'. '<td style="text-align:right;">'. number_format($d['taxable_amount'],"2") .'</td>'. '<td style="text-align:right;">' . number_format($gst_tot,"2") . '</td><td style="text-align:right;">'. number_format($d['net_amount'],"2") .'</td>'  .'</tr>';
<button type='button' class='btn btn-danger btn-circle btn-xs center-block'  href='#' data-toggle='modal' data-backdrop='static' data-keyboard='true' data-target='#modalEditRSales' onclick='sreturnTransid(" . $d["id"] . ")'><i class='fa fa-undo'></i></button>
*/
$button="<div class='btn-group'><button type='button' class='btn btn-warning btn-circle btn-xs center-block'  href='#' data-toggle='modal' data-target='#modalEditSales'  onclick='updateTransid(" . $d["id"] . ")'><i class='fa fa-edit'></i></button><button type='button' class='btn btn-primary btn-circle btn-xs center-block' href='#' onclick='printTransid(". $d["id"]. ")'><i class='fa fa-print'></i></button></div>";

$data['data'][]=array("action"=>$button,"trans_id"=>$d['trans_id'],"trans_date"=>$d['trans_date'],"custname"=>$d['custname'],"gstin"=>$d['gstin'],"taxable_amount"=>$d['txb_tot'],"gst_tot"=>$gst_tot,"net_amount"=>$d['net_tot'],"noi"=>$d['noi']);

}
}

//$tbl .='</tbody></table>';

echo json_encode($data);
}


public function getallPurchaselist()
{
$data=array();    
$compId = $this->session->userdata('id');
$finyear = $this->session->userdata('finyear');
$trans_type="PURC";
//var_dump($compId . $finyear); 
//$url=$this->config->item("api_url") . "/api/getallpurchase.php";
$url=$this->config->item("api_url") . "/api/transaction/pursal/" . $trans_type . "/" . $finyear ;
$data = array("finyear"=>$finyear,"compId"=>$compId,"trans_type"=>$trans_type);
//$post = ['batch_id'=> "2"];
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);

//  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

  $salesresponse = curl_exec($ch);
  //$result = json_decode($response);
//echo $salesresponse;
//var_dump($salesresponse);
curl_close($ch); // Close the connection

/*$tbl='<table class="table table-bordered" id="saleslistTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>ACTION</th>
                      <th>INVOICE#</th>
                      <th>INVOICE DATE</th>
                      <th>CUSTOMER</th>
                      <th>GSTIN</th>
                      <th>TAXABLE VALUE</th>
                      <th>GST</th>
                      <th>NETT VALUE</th>

                    </tr>
                  </thead>
                  <tbody id="saleslist">';

*/
$maindata = json_decode($salesresponse,true);
$data=array();
foreach ($maindata as $key => $d) 
{
//var_dump($d);
    # code...
if($d['net_tot']!=null)
{
  $netamt= $d['net_tot'];
}
else
{
  $netamt=0;
}

if($d['txb_tot']!=null)
{
  $txbamt= $d['txb_tot'];
}
else
{
  $txbamt=0;
}

$gst_tot = $netamt-$txbamt;

/*$tbl .='<tr><td><div class="btn-group"><button type="button" class="btn btn-warning btn-circle btn-xs center-block"  href="#" data-toggle="modal" data-target="#modalEditSales"  onclick="updateTransid(' . $d['id'] . ')"><i class="fa fa-edit"></i></button><button type="button" class="btn btn-primary btn-circle btn-xs center-block" href="#" onclick="printTransid('. $d['id']. ')"><i class="fa fa-print"></i></button>' . '<td style="width:30%;">'. $d['trans_id'] .'</td>' . '<td>'. $d['trans_date'] .'</td>'. '<td style="width:100%;">'. $d['custname'] .'</td>' . '<td>'. $d['gstin'] .'</td>'. '<td style="text-align:right;">'. number_format($d['taxable_amount'],"2") .'</td>'. '<td style="text-align:right;">' . number_format($gst_tot,"2") . '</td><td style="text-align:right;">'. number_format($d['net_amount'],"2") .'</td>'  .'</tr>';
<button type='button' class='btn btn-danger btn-circle btn-xs center-block' href='#'  data-toggle='modal' data-target='#modalEditSales' onclick='rpurchaseTransid(". $d["id"]. ")'><i class='fa fa-redo'></i></button>
*/
$button="<div class='btn-group'><button type='button' class='btn btn-warning btn-circle btn-xs center-block'  href='#' data-toggle='modal' data-target='#modalEditSales'  onclick='updateTransid(" . $d["id"] . ")'><i class='fa fa-edit'></i></button></div>";

$data['data'][]=array("action"=>$button,"trans_id"=>$d['trans_id'],"trans_date"=>$d['trans_date'],"custname"=>$d['custname'],"gstin"=>$d['gstin'],"taxable_amount"=>$txbamt,"gst_tot"=>$gst_tot,"net_amount"=>$netamt,"noi"=>$d['noi']);

}


//$tbl .='</tbody></table>';

echo json_encode($data);
}


public function getInvoiceType()
{

//$url=$this->config->item("api_url") . "/api/getinvtype.php";
$url=$this->config->item("api_url") . "/api/invoicetype";
//$post = ['batch_id'=> "2"];

//$data = array("id"=>$actid,"compId"=>$compId);

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  $invtyperesponse = curl_exec($ch);
  //$result = json_decode($response);
//var_dump($data);
//var_dump($ldgresponse);
  curl_close($ch); // Close the connection
//var_dump($invtyperesponse);

$invoption='';
$invdata =  json_decode($invtyperesponse,true);

foreach ($invdata as $key => $invvalue) {
    
$invoption .= '<option value="'.$invvalue['inv_type'].'">'.$invvalue['description'].'</option>';

}

echo $invoption;
}



public function getSalesPerson()
{
$url=$this->config->item("api_url") . "/api/salesperson";
//$url=$this->config->item("api_url") . "/api/getSalesPerson.php";
//$post = ['batch_id'=> "2"];
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  $response = curl_exec($ch);
  //$result = json_decode($response);
  curl_close($ch); // Close the connection
$groupArray = json_decode($response, true);
//$character = json_decode($data);
//print_r($response);
$data=array();
$option="";
foreach ($groupArray as $key => $value) {
$option .= '<option value="'.$value['id'].'">'.$value['sales_person'].'</option>';

}
$option .= '<option selected  disabled value="0">Select a Sales Person</option>';
echo $option;

}

public function getledgerdatasearchbyname($name)
{
$data_array=array();

$itemkeyword= $name; 
//var_dump($itemkeyword);

$compId = $this->session->userdata('id');
$data_array = array("flag"=>"oth", "itemkeyword"=>$name,"compId"=>$compId);
//$id = $this->input->get('id');    
//$url=$this->config->item("api_url") . "/api/getledgerbykeyword.php";
$url=$this->config->item("api_url") . "/api/productlist/lbyname";// . $itemkeyword . "/" . $compId ;

//$post = ['batch_id'=> "2"];
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);

curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_array));
  $response = curl_exec($ch);
 // var_dump($response);
  //$result = json_decode($response);
  curl_close($ch); // Close the connection
$ldgerArray = json_decode($response,true);
$item_data=array();
return $ldgerArray;

}

public function getledgerdatabysearch()
{
$data_array=array();

$itemkeyword= $this->input->get('itemkeyword'); 
//var_dump($itemkeyword);
$compId = $this->session->userdata('id');
$data_array = array("itemkeyword"=>$itemkeyword,"compId"=>$compId);
//$id = $this->input->get('id');    
$url=$this->config->item("api_url") . "/api/productlist/lbyname"; // . $itemkeyword . "/" . $compId;
//$post = ['batch_id'=> "2"];
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_array));
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  $response = curl_exec($ch);
  //$result = json_decode($response);
  curl_close($ch); // Close the connection
$ldgerArray = json_decode($response,true);
$item_data=array();
echo $response;

}

public function getproductdatabysearch()
{
$data_array=array();

$itemkeyword= $this->input->get('itemkeyword'); 
//var_dump($itemkeyword);
$finyear = $this->session->userdata('finyear');

$compId = $this->session->userdata('id');
$data_array = array("itemkeyword"=>$itemkeyword,"compId"=>$compId,"finyear"=>$finyear);
//$id = $this->input->get('id');    
$url=$this->config->item("api_url") . "/api/productlist/keyword/";//. $itemkeyword . "/" . $compId ;
//$post = ['batch_id'=> "2"];
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
    //curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");  

  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_array));

  $response = curl_exec($ch);
  //$result = json_decode($response);
 
  curl_close($ch); // Close the connection
$ldgerArray = json_decode($response,true);
$item_data=array();
echo $response;
}



public function productdatabyname()
{
//$id = $this->input->get('id');  
$name=$this->input->get('itemname');
//var_dump($name);
$compId = $this->session->userdata('id');
$finyear = $this->session->userdata('finyear');
$data_array = array('itemkeyword'=> $name,'compId'=>$compId,"finyear"=>$finyear);
$url=$this->config->item("api_url") . "/api/productlist/byname" ;

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($data_array));

 // curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");  


  $response = curl_exec($ch);
echo $response;
  //$result = json_decode($response);
  curl_close($ch); // Close the connection
$ldgerArray = json_decode($response, true);

return $response;
}



public function getproductdatabyname($name)
{
//$id = $this->input->get('id');    
$compId = $this->session->userdata('id');
$finyear = $this->session->userdata('finyear');
$data_array = array('itemkeyword'=> $name,'compId'=>$compId,"finyear"=>$finyear);
$url=$this->config->item("api_url") . "/api/productlist/byname";///" . $name . "/" . $compId ;

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_array));

  $response = curl_exec($ch);
//var_dump($response);
  //$result = json_decode($response);
  curl_close($ch); // Close the connection
$ldgerArray = json_decode($response, true);

return $response;
}

public function getproductdatabyid($id)
{
$compId = $this->session->userdata('id');
//$id = $this->input->get('id');    
$url=$this->config->item("api_url") . "/api/product/" . $id . "/" . $compId ;
//$post = ['batch_id'=> "2"];
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  $response = curl_exec($ch);
  //$result = json_decode($response);
  curl_close($ch); // Close the connection
$ldgerArray = json_decode($response, true);

return $response;
}



public function getledgerdatabyname()
{
$flag = $this->input->get('flag');
$compId = $this->session->userdata('id');
$finyear = $this->session->userdata('finyear');

$itemkeyword = rawurlencode($this->input->get('itemkeyword'));    
$url=$this->config->item("api_url") . "/api/ledger/keyword/" . $itemkeyword . "/" . $compId ;
//$post = ['batch_id'=> "2"];

//$post=array("flag"=>$flag,"itemkeyword"=>$itemkeyword,"compId"=>$compId);
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);

//  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
  $response = curl_exec($ch);
 // var_dump($url);
  //$result = json_decode($response);
  curl_close($ch); // Close the connection
$ldgerArray = json_decode($response, true);

echo $response;
}




public function getvendordata()
{
$id = $this->input->get('id');    
$compId = $this->session->userdata('id');
$finyear = $this->session->userdata('finyear');
$url=$this->config->item("api_url") . "/api/ledger/" . $id . "/" . $compId;
//$post = ['batch_id'=> "2"];

$post=array("id"=>$id,"compId"=>$compId);
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  $response = curl_exec($ch);
  //$result = json_decode($response);
  curl_close($ch); // Close the connection
$ldgerArray = json_decode($response, true);

echo $response;
}


function validateDate($date, $format = 'Y-m-d')
{
 //   $d = DateTime::createFromFormat($format, $date);
    // The Y ( 4 digits year ) returns TRUE for any integer with any number of digits so changing the comparison from == to === fixes the issue.
   // return $d && $d->format($format) === $date;

$timestamp = strtotime($date);
return $timestamp ? $date : null;

}


public function getInvItems()
{
$url=$this->config->item("api_url") . "/api/getinvitems.php";
//$post = ['batch_id'=> "2"];
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  //curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
  $response = curl_exec($ch);
  //$result = json_decode($response);
  curl_close($ch); // Close the connection
$groupArray = json_decode($response, true);
//$character = json_decode($data);
//print_r($response);
$data=array();
$option="";
foreach ($groupArray['products'] as $key => $value) {
$option .= '<option value="'.$value['id'].'">'.$value['prod_name'].'</option>';

}
$option .= '<option selected disabled value="0">Select a Product</option>';
echo $option;

}

public function addPurchase()
{
//Main Purchase 
$compId = $this->session->userdata('id');
$finyear = $this->session->userdata('finyear');
$cpos = $this->session->userdata('cstatecode');
    $invno= $this->input->post('invoice_no');
    $invdate= $this->input->post('invoice_date');
    $orderno= $this->input->post('order_no');
    $orderdate= $this->input->post('order_date');
    $dc_no= $this->input->post('dc_no');
    $dc_date= $this->input->post('dc_date');
    $vendor_name= $this->input->post('vendor_name');
    $statecode = $this->input->post('statecode');
    $gstin= $this->input->post('gstin');

//Items Purchase
$taxable_tot=0;
$netamt_tot=0;

$url=$this->config->item("api_url") . "/api/insert_transaction.php";

$data_array=array(
    "trans_id"=> $invno,
    "trans_date"=>$invdate,
    "order_no"=>$orderno,
    "order_date"=>$orderdate,
    "dc_no"=>$dc_no,
    "dc_date"=>$dc_date,
    "trans_type"=>"PURC",            
    "db_account"=>$vendor_name,
    "cr_account"=>2,
    "statecode"=>$statecode,
    "gstin"=>$gstin,
    "trans_narration"=>"INWARD ENTRY POSTED",
    "finyear"=>$finyear,
    "company_id"=>$compId);

//var_dump($data_array);
//$make_call = $this->callAPI('POST', $url, json_encode($data_array));

$url=$this->config->item("api_url") . "/api/insert_transaction.php";

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_array));
  $response = curl_exec($ch);
  //echo $response;
  //$result = json_decode($response);
  curl_close($ch); // Close the connection

$res = json_decode($response, true);
//echo $response;
//var_dump($res);
$ins_sql=array();
$trans_link_id=$res['last_ins_id'];
$cnt = count($this->input->post('itemqty'));
//var_dump($cnt);
//for($rw = 0; $rw < count($this->input->post('itemqty')); $rw++) {
for($rw = $cnt+1; $rw >1; $rw--) {
    //print_r($rw);
//$taxable_amt = $this->input->post('txbval')[$rw];
$itemid = $this->input->post('itemname')[$rw];


$itemData = $this->getproductdatabyid($itemid);
//var_dump(json_decode($itemData));
$obj = json_decode($itemData);
//var_dump($obj);
if($obj)
{
    $itemmrp= $obj->mrp;
    $itemname=$obj->name;
//    print_r($itemmrp);

}
$itemname = $itemname;
$itemdesc = $this->input->post('itemdesc')[$rw];
$itemhsn = $this->input->post('itemhsn')[$rw];
$itemgstpc = $this->input->post('itemgstpc')[$rw];
$itemuom = $this->input->post('itemuom')[$rw];
$itemqty = $this->input->post('itemqty')[$rw];
$itemrate = $this->input->post('itemrate')[$rw];
$itemdispc = $this->input->post('itemdispc')[$rw];
$itemdis = $this->input->post('itemdis')[$rw];
$itemmrp = $itemmrp;
//$itemgstamt = $this->input->post('itemgstamt')[$rw];
$itemamt = $this->input->post('itemamt')[$rw];
$itemnet = $this->input->post('itemnet')[$rw];

$taxable_tot = $taxable_tot+$itemamt;
$netamt_tot = $netamt_tot+$itemnet;

if($cpos==$statecode)
{
// Intra state
$cgstpc=0;
$sgstpc=0;
$cgstamt=0;
$sgstamt=0;    
$igstpc=0;
$igstamt=0;
$cgstpc = $itemgstpc/2;
$sgstpc = $itemgstpc/2;
$cgstamt = ($itemamt*$cgstpc)/100;
$sgstamt = ($itemamt*$sgstpc)/100;

}
else 
{
//Inter state
$igstpc=0;
$igstamt=0;    
$cgstpc=0;
$sgstpc=0;
$cgstamt=0;
$sgstamt=0;    
$results=array();
$igstpc = $itemgstpc;
$igstamt = ($itemamt*$igstpc)/100;
}

$ins_sql[] = array("trans_link_id"=>$trans_link_id,"item_name"=>$itemname, "item_hsnsac"=>$itemhsn,"trans_id"=>$invno,"trans_date"=>$invdate,"trans_type"=>"PURC","item_id"=>$itemid,/*"item_name"=>$item_name,*/"item_unit"=>$itemuom,"item_qty"=>$itemqty,"item_rate"=>$itemrate,"item_amount"=>$itemamt,"item_mrp"=>$itemmrp,"item_gstpc"=>$itemgstpc,"item_dispc"=>$itemdispc,"item_disamount"=>$itemdis,"item_cgst"=>$cgstamt,"item_sgst"=>$sgstamt,"item_igst"=>$igstamt,"cgst_pc"=>$cgstpc,"sgst_pc"=>$sgstpc,"igst_pc"=>$igstpc,"taxable_amount"=>$itemamt,"nett_amount"=>$itemnet,"item_desc"=>$itemdesc,"company_id"=>$compId,"finyear"=>$finyear);

//$ins_sql = array($trans_link_id,$itemhsn,$invno,$invdate,$itemid,$itemuom,$itemqty,$itemrate,$itemamt,$itemgstpc,$itemdispc,$itemdis,$cgstamt,$sgstamt,$igstamt,$cgstpc,$sgstpc,$igstpc,$itemamt,$itemnet,$itemdesc,$compId);


//var_dump($ins_sql);
}

$each_data=array();
$url=$this->config->item("api_url") . "/api/insert_transactionitems.php";

$ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);

foreach($ins_sql as $r) {
    //var_dump($r);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($r));
    $results = curl_exec($ch);
    curl_close($ch);


}


$url=$this->config->item("api_url") . "/api/update_transaction_total.php";

$data_updarray=array(
    "id"=> $trans_link_id,
    "taxable_amount"=>$taxable_tot,
    "net_amount"=>$netamt_tot,
    "company_id"=>$compId);

//var_dump($data_array);
//$make_call = $this->callAPI('POST', $url, json_encode($data_array));

//$url=$this->config->item("api_url") . "/api/insert_transaction.php";

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_updarray));
  $updresponse = curl_exec($ch);
  //var_dump($response);
  //echo $response;
  //$result = json_decode($response);
  curl_close($ch); // Close the connection

$res = json_decode($response,true);


echo $results;
/*
for ($i=0; $i <count($ins_sql) ; $i++) { 

    //print_r($ins_sql[$i]);
$each_data =  array($ins_sql[$i]);

    # code...

    # code...

  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($each_data));


echo json_encode($each_data);
}  */ 
  //curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  //curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($ins_sql));
  /*$response = curl_exec($ch);
  //$result = json_decode($response);
  curl_close($ch); // Close the connection



echo $response;
*/


}


//Purchase Return Entry New

// Sales Return Entry New
public function createRPurchase()
{
$tax_tot=0;
$net_tot=0;
$itemdispc=0.00;
$id=$this->input->post('recid');
$compId = $this->session->userdata('id');
$finyear = $this->session->userdata('finyear');
$cpos = $this->session->userdata('cstatecode');
$statecode = $this->input->post('statecode');
$cnt = count($this->input->post('itemqty'));


//Main Sales
    
    $invno= $this->input->post('invoiceno');
    $cndn_no=$this->input->post('cndn_no');
    $cndn_date=$this->input->post('cndn_date');
    $invdate= $this->input->post('invdate');
    //$orderno= $this->input->post('orderno');
    //$odate= $this->input->post('orderdate');
    //$dc_no= $this->input->post('dcno');
    //$ddate= $this->input->post('dcdate');
    $vendor_name= $this->input->post('customer_name');
    //$statecode = $this->input->post('editstatecode');
    $invtype= $this->input->post('invtype');

    $salebyperson=$this->input->post('salebyperson');
/*
$o_date=$this->validateDate($odate);
if($o_date==null)
{
$orderdate="1970-01-01";
}
else
{
    $orderdate = $o_date;
}
$d_date=$this->validateDate($ddate);
if($d_date==null)
{
$dc_date="1970-01-01";
}
else
{
    $dc_date = $d_date;
}
*/
//var_dump($orderdate);
//var_dump($cnt);
$ldgarray = $this->getledgerdatasearchbyname($vendor_name);

foreach ($ldgarray as $lvalue) {
    //var_dump($lvalue);
    # code...
    $statecode=$lvalue['statecode'];
    $gstin=$lvalue['gstin'];
    $db_account=$lvalue['id'];
}
$r=0;

for ($i=0; $i <count($this->input->post('itemqty')) ; $i++) { 
    # code...

    # code...

$itemgstpc = $this->input->post('itemgstpc');
$itemamt = $this->input->post('itemamt');
$itemnet = $this->input->post('itemnet');

//echo $itemgstpc[$i];
//var_dump($itemamt);
//var_dump($itemnet);


if($cpos==$statecode)
{
// Intra state
$cgstpc=0;
$sgstpc=0;
$cgstamt=0;
$sgstamt=0;    
$igstpc=0;
$igstamt=0;
$cgstpc = $itemgstpc[$i]/2;
$sgstpc = $itemgstpc[$i]/2;
$cgstamt = ($itemamt[$i]*$cgstpc)/100;
$sgstamt = ($itemamt[$i]*$sgstpc)/100;
//var_dump($sgstpc);
}
else 
{
//Inter state
$igstpc=0;
$igstamt=0;    
$cgstpc=0;
$sgstpc=0;
$cgstamt=0;
$sgstamt=0;    
$results=array();
$igstpc = $itemgstpc[$i];
$igstamt = ($itemamt[$i]*$igstpc)/100;
//var_dump($igstpc);
}

$tax_tot=$tax_tot+$itemamt[$i];
$net_tot=$net_tot+$itemnet[$i];

$r++;


}


$url=$this->config->item("api_url") . "/api/getsettings.php";

$data_array= array("compId"=>$compId,"finyear"=>$finyear);
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_array));
  $setresponse = curl_exec($ch);
  curl_close($ch); // Close the connection
//var_dump($setresponse);
$settArr = json_decode($setresponse);


if($settArr)
{
    # code...
  //var_dump($settArr);
    $dnprefix = $settArr->dn_prefix;
    $dnsuffix = $settArr->dn_suffix;
    $dn_no = $settArr->dn_no;
    $dn_numtype = $settArr->inv_numtype;
    $dn_leadingzero = $settArr->leading_zero;

if($dn_numtype=="ZEROPAD")
{
//$ivno= $inv_no;
$_dnno = sprintf("%0". $dn_leadingzero ."d", $dn_no);
//$invnum = printf("[%0" .$inv_leadingzero ."s]\n",   $ivno); // zero-padding works on strings too

$dnno = $dnprefix . $_dnno . $dnsuffix;
$next_dnno = $dn_no+1;
}
else
{
    $_dnno= $dn_no;
    $dnno = $dnprefix . $_dnno . $dnsuffix;
    $next_dnno = $dn_no+1;
}



}


//var_dump($invno);
//Transaction Sales & Purhcase

$url=$this->config->item("api_url") . "/api/insert_cndntransaction.php";
$trans_type="PRTN";
$data_array=array(
    "srecid"=>$id,
    "cndntrans_id"=>$dnno,
    "cndntrans_date"=>$cndn_date,
    "trans_id"=>$invno,
    "trans_date"=>$invdate,
  //  "order_no"=>$orderno,
  //  "order_date"=>$orderdate,
  //  "dc_no"=>$dc_no,
  //  "dc_date"=>$dc_date,
    "trans_type"=>$trans_type,            
    "db_account"=>$db_account,
    "cr_account"=>1,
    "statecode"=>$statecode,
    "gstin"=>$gstin,
    "finyear"=>$finyear,
    "salebyperson"=>$salebyperson,
    "invtype"=>$invtype,
    "taxable_amount"=>$tax_tot,
    "nett_amount"=>$net_tot,
    "company_id"=>$compId);


  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_array));
  $response = curl_exec($ch);
  //var_dump($response);
  //echo $response;
  //$result = json_decode($response);
  curl_close($ch); // Close the connection

$res = json_decode($response,true);


$ins_sql=array();
$id=$res['last_ins_id'];


if($id)
{
$url=$this->config->item("api_url") . "/api/updatesettings.php";
$data_array=array("finyear"=>$finyear,"compId"=>$compId,"next_no"=>$next_dnno,"trans_type"=>"PRTN");
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_array));
  $updsettresponse = curl_exec($ch);
curl_close($ch);
 //var_dump($updsettresponse);
 $sts= json_decode($updsettresponse);
}
else
{
  $sts = json_encode(array("status"=>false));
}
if($sts->status==true)
{



$cnt = count($this->input->post('itemqty'));
//var_dump($cnt);
//for($rw = 0; $rw < count($this->input->post('itemqty')); $rw++) {
for ($i=0; $i <count($this->input->post('itemqty')) ; $i++) { 

//for($rw = $cnt; $rw >1; $rw--) {
    //print_r($rw);
//$taxable_amt = $this->input->post('txbval')[$rw];
$itemname = $this->input->post('itemname');
//var_dump($itemid);

$itemData = json_decode($this->getproductdatabyname($itemname[$i]),true);
//var_dump($itemData);
//$obj = json_decode($itemData);

if($itemData)
{
    $itemmrp= $itemData[0]['mrp'];
    $itemname=$itemData[0]['name'];
    $itemid=$itemData[0]['id'];
  //var_dump($itemmrp);
  //  var_dump($itemid);
}
if(is_numeric($itemmrp))
{
    $item_mrp=floatval($itemmrp);
}
else
{
    $item_mrp="0.00";
}


//$itemname = $itemname[$i];
$itemdesc = $this->input->post('itemdesc');
$itemhsn = $this->input->post('hsnsac');
$itemgstpc = $this->input->post('itemgstpc');
$itemuom = $this->input->post('itemunit');
$itemqty = $this->input->post('itemqty');
$itemrate = $this->input->post('itemrate');

$itemdispc = $this->input->post('itemdispc');

if(is_null($itemdispc[$i]) )
{
 $item_dispc=0.00;   
 
}
else
{
 $item_dispc = floatval($itemdispc[$i]);  
}

//var_dump($itemrate);
//var_dump($itemqty);
//var_dump($itemdispc);
$itemdis = (($itemrate[$i]*$itemqty[$i])*$item_dispc/100);

//$itemdis = $this->input->post('itemdis')[$rw];
//$itemmrp = $itemmrp[$i];
//$itemgstamt = $this->input->post('itemgstamt')[$rw];
$itemamt = $this->input->post('itemamt');
$itemnet = $this->input->post('itemnet');



if($cpos==$statecode)
{
// Intra state
$cgstpc=0;
$sgstpc=0;
$cgstamt=0;
$sgstamt=0;    
$igstpc=0;
$igstamt=0;
$cgstpc = $itemgstpc[$i]/2;
$sgstpc = $itemgstpc[$i]/2;
$cgstamt = ($itemamt[$i]*$cgstpc)/100;
$sgstamt = ($itemamt[$i]*$sgstpc)/100;

}
else 
{
//Inter state
$igstpc=0;
$igstamt=0;    
$cgstpc=0;
$sgstpc=0;
$cgstamt=0;
$sgstamt=0;    
$results=array();
$igstpc = $itemgstpc[$i];
$igstamt = ($itemamt[$i]*$igstpc)/100;
}

$tax_tot=$tax_tot+$itemamt[$i];
$net_tot=$tax_tot+$itemnet[$i];

$ins_sql[] = array("trans_link_id"=>$id,"item_name"=>$itemname, "item_hsnsac"=>$itemhsn[$i],"trans_id"=>$invno,"trans_date"=>$invdate,"trans_type"=>$trans_type,"item_id"=>$itemid,"item_unit"=>$itemuom[$i],"item_qty"=>$itemqty[$i],"item_rate"=>$itemrate[$i],"item_amount"=>$itemamt[$i],"item_mrp"=>$item_mrp,"item_gstpc"=>$itemgstpc[$i],"item_dispc"=>$item_dispc,"item_disamount"=>$itemdis,"item_cgst"=>$cgstamt,"item_sgst"=>$sgstamt,"item_igst"=>$igstamt,"cgst_pc"=>$cgstpc,"sgst_pc"=>$sgstpc,"igst_pc"=>$igstpc,"taxable_amount"=>$itemamt[$i],"nett_amount"=>$itemnet[$i],"item_desc"=>$itemdesc[$i],"company_id"=>$compId,"finyear"=>$finyear);


//var_dump($ins_sql);
}

$each_data=array();
$url=$this->config->item("api_url") . "/api/insert_cndntransactionitems.php";

$ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);



foreach($ins_sql as $r) {
    //var_dump($r);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($r));
    $results = curl_exec($ch);
    curl_close($ch);



}

}
echo $results;



}


// Sales Return Entry New
public function createRSales()
{
  $trans_type="SRTN";
$tax_tot=0;
$net_tot=0;
$itemdispc=0.00;
$id=$this->input->post('recid');
$compId = $this->session->userdata('id');
$finyear = $this->session->userdata('finyear');
$cpos = $this->session->userdata('cstatecode');
$statecode = $this->input->post('statecode');
$cnt = count($this->input->post('itemqty'));


//Main Sales
    
    $invno= $this->input->post('invoiceno');
    $cndn_no=$this->input->post('cndn_no');
    $cndn_date=$this->input->post('cndn_date');
    $invdate= $this->input->post('invdate');
    //$orderno= $this->input->post('orderno');
    //$odate= $this->input->post('orderdate');
    //$dc_no= $this->input->post('dcno');
    //$ddate= $this->input->post('dcdate');
    $vendor_name= $this->input->post('customer_name');
    //$statecode = $this->input->post('editstatecode');
    $invtype= $this->input->post('invtype');

    $salebyperson=$this->input->post('salebyperson');
/*
$o_date=$this->validateDate($odate);
if($o_date==null)
{
$orderdate="1970-01-01";
}
else
{
    $orderdate = $o_date;
}
$d_date=$this->validateDate($ddate);
if($d_date==null)
{
$dc_date="1970-01-01";
}
else
{
    $dc_date = $d_date;
}
*/
//var_dump($orderdate);
//var_dump($cnt);
$ldgarray = $this->getledgerdatasearchbyname($vendor_name);

foreach ($ldgarray as $lvalue) {
    //var_dump($lvalue);
    # code...
    $statecode=$lvalue['statecode'];
    $gstin=$lvalue['gstin'];
    $db_account=$lvalue['id'];
}
$r=0;

for ($i=0; $i <count($this->input->post('itemqty')) ; $i++) { 
    # code...

    # code...

$itemgstpc = $this->input->post('itemgstpc');
$itemamt = $this->input->post('itemamt');
$itemnet = $this->input->post('itemnet');

//echo $itemgstpc[$i];
//var_dump($itemamt);
//var_dump($itemnet);


if($cpos==$statecode)
{
// Intra state
$cgstpc=0;
$sgstpc=0;
$cgstamt=0;
$sgstamt=0;    
$igstpc=0;
$igstamt=0;
$cgstpc = $itemgstpc[$i]/2;
$sgstpc = $itemgstpc[$i]/2;
$cgstamt = ($itemamt[$i]*$cgstpc)/100;
$sgstamt = ($itemamt[$i]*$sgstpc)/100;
//var_dump($sgstpc);
}
else 
{
//Inter state
$igstpc=0;
$igstamt=0;    
$cgstpc=0;
$sgstpc=0;
$cgstamt=0;
$sgstamt=0;    
$results=array();
$igstpc = $itemgstpc[$i];
$igstamt = ($itemamt[$i]*$igstpc)/100;
//var_dump($igstpc);
}

$tax_tot=$tax_tot+$itemamt[$i];
$net_tot=$net_tot+$itemnet[$i];

$r++;


}


$url=$this->config->item("api_url") . "/api/getsettings.php";

$data_array= array("compId"=>$compId,"finyear"=>$finyear);
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_array));
  $setresponse = curl_exec($ch);
  curl_close($ch); // Close the connection
//var_dump($setresponse);
$settArr = json_decode($setresponse);


if($settArr)
{
    # code...
  //var_dump($settArr);
    $cnprefix = $settArr->cn_prefix;
    $cnsuffix = $settArr->cn_suffix;
    $cn_no = $settArr->cn_no;
    $cn_numtype = $settArr->inv_numtype;
    $cn_leadingzero = $settArr->leading_zero;

if($cn_numtype=="ZEROPAD")
{
//$ivno= $inv_no;
$_cnno = sprintf("%0". $cn_leadingzero ."d", $cn_no);
//$invnum = printf("[%0" .$inv_leadingzero ."s]\n",   $ivno); // zero-padding works on strings too

$cnno = $cnprefix . $_cnno . $cnsuffix;
$next_cnno = $cn_no+1;
}
else
{
    $_cnno= $cn_no;
    $cnno = $cnprefix . $_cnno . $cnsuffix;
    $next_cnno = $cn_no+1;
}



}


//var_dump($invno);
//Transaction Sales & Purhcase

$url=$this->config->item("api_url") . "/api/insert_cndntransaction.php";
$trans_type="SRTN";
$data_array=array(
    "srecid"=>$id,
    "cndntrans_id"=>$cnno,
    "cndntrans_date"=>$cndn_date,
    "trans_id"=>$invno,
    "trans_date"=>$invdate,
  //  "order_no"=>$orderno,
  //  "order_date"=>$orderdate,
  //  "dc_no"=>$dc_no,
  //  "dc_date"=>$dc_date,
    "trans_type"=>"SRTN",            
    "db_account"=>$db_account,
    "cr_account"=>1,
    "statecode"=>$statecode,
    "gstin"=>$gstin,
    "finyear"=>$finyear,
    "salebyperson"=>$salebyperson,
    "invtype"=>$invtype,
    "taxable_amount"=>$tax_tot,
    "nett_amount"=>$net_tot,
    "company_id"=>$compId);


  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_array));
  $response = curl_exec($ch);
  //var_dump($response);
  //echo $response;
  //$result = json_decode($response);
  curl_close($ch); // Close the connection

$res = json_decode($response,true);


$ins_sql=array();
$id=$res['last_ins_id'];


if($id)
{
$url=$this->config->item("api_url") . "/api/updatesettings.php";
$data_array=array("finyear"=>$finyear,"compId"=>$compId,"next_no"=>$next_cnno,"trans_type"=>"SRTN");
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_array));
  $updsettresponse = curl_exec($ch);
curl_close($ch);
 //var_dump($updsettresponse);
 $sts= json_decode($updsettresponse);
}
else
{
  $sts = json_encode(array("status"=>false));
}
if($sts->status==true)
{



$cnt = count($this->input->post('itemqty'));
//var_dump($cnt);
//for($rw = 0; $rw < count($this->input->post('itemqty')); $rw++) {
for ($i=0; $i <count($this->input->post('itemqty')) ; $i++) { 

//for($rw = $cnt; $rw >1; $rw--) {
    //print_r($rw);
//$taxable_amt = $this->input->post('txbval')[$rw];
$itemname = $this->input->post('itemname');
//var_dump($itemid);

$itemData = json_decode($this->getproductdatabyname($itemname[$i]),true);
//var_dump($itemData);
//$obj = json_decode($itemData);

if($itemData)
{
    $itemmrp= $itemData[0]['mrp'];
    $itemname=$itemData[0]['name'];
    $itemid=$itemData[0]['id'];
  //var_dump($itemmrp);
  //  var_dump($itemid);
}
if(is_numeric($itemmrp))
{
    $item_mrp=floatval($itemmrp);
}
else
{
    $item_mrp="0.00";
}


//$itemname = $itemname[$i];
$itemdesc = $this->input->post('itemdesc');
$itemhsn = $this->input->post('hsnsac');
$itemgstpc = $this->input->post('itemgstpc');
$itemuom = $this->input->post('itemunit');
$itemqty = $this->input->post('itemqty');
$itemrate = $this->input->post('itemrate');

$itemdispc = $this->input->post('itemdispc');

if(is_null($itemdispc[$i]) )
{
 $item_dispc=0.00;   
 
}
else
{
 $item_dispc = floatval($itemdispc[$i]);  
}

//var_dump($itemrate);
//var_dump($itemqty);
//var_dump($itemdispc);
$itemdis = (($itemrate[$i]*$itemqty[$i])*$item_dispc/100);

//$itemdis = $this->input->post('itemdis')[$rw];
//$itemmrp = $itemmrp[$i];
//$itemgstamt = $this->input->post('itemgstamt')[$rw];
$itemamt = $this->input->post('itemamt');
$itemnet = $this->input->post('itemnet');



if($cpos==$statecode)
{
// Intra state
$cgstpc=0;
$sgstpc=0;
$cgstamt=0;
$sgstamt=0;    
$igstpc=0;
$igstamt=0;
$cgstpc = $itemgstpc[$i]/2;
$sgstpc = $itemgstpc[$i]/2;
$cgstamt = ($itemamt[$i]*$cgstpc)/100;
$sgstamt = ($itemamt[$i]*$sgstpc)/100;

}
else 
{
//Inter state
$igstpc=0;
$igstamt=0;    
$cgstpc=0;
$sgstpc=0;
$cgstamt=0;
$sgstamt=0;    
$results=array();
$igstpc = $itemgstpc[$i];
$igstamt = ($itemamt[$i]*$igstpc)/100;
}

$tax_tot=$tax_tot+$itemamt[$i];
$net_tot=$tax_tot+$itemnet[$i];

$ins_sql[] = array("trans_link_id"=>$id,"item_name"=>$itemname, "item_hsnsac"=>$itemhsn[$i],"trans_id"=>$invno,"trans_date"=>$invdate,"trans_type"=>"SRTN","item_id"=>$itemid,"item_unit"=>$itemuom[$i],"item_qty"=>$itemqty[$i],"item_rate"=>$itemrate[$i],"item_amount"=>$itemamt[$i],"item_mrp"=>$item_mrp,"item_gstpc"=>$itemgstpc[$i],"item_dispc"=>$item_dispc,"item_disamount"=>$itemdis,"item_cgst"=>$cgstamt,"item_sgst"=>$sgstamt,"item_igst"=>$igstamt,"cgst_pc"=>$cgstpc,"sgst_pc"=>$sgstpc,"igst_pc"=>$igstpc,"taxable_amount"=>$itemamt[$i],"nett_amount"=>$itemnet[$i],"item_desc"=>$itemdesc[$i],"company_id"=>$compId,"finyear"=>$finyear);


//var_dump($ins_sql);
}

$each_data=array();
$url=$this->config->item("api_url") . "/api/insert_cndntransactionitems.php";

$ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);



foreach($ins_sql as $r) {
    //var_dump($r);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($r));
    $results = curl_exec($ch);
    curl_close($ch);



}

}
echo $results;



}




public function createSales()
{
$tax_tot=0;
$net_tot=0;
$itemdispc=0.00;

$compId = $this->session->userdata('id');
$finyear = $this->session->userdata('finyear');
$cpos = $this->session->userdata('cstatecode');
$statecode = $this->input->post('statecode');
$cnt = count($this->input->post('itemqty'));


//Main Sales
    
    //$invno= $this->input->post('invoiceno');
    $invdate= $this->input->post('invdate');
    $orderno= $this->input->post('orderno');
    $odate= $this->input->post('orderdate');
    $dc_no= $this->input->post('dcno');
    $ddate= $this->input->post('dcdate');
    $vendor_name= $this->input->post('customer_name');
    //$statecode = $this->input->post('editstatecode');
    $invtype= $this->input->post('invtype');

    $salebyperson=$this->input->post('salebyperson');

$o_date=$this->validateDate($odate);
if($o_date==null)
{
$orderdate="1970-01-01";
}
else
{
    $orderdate = $o_date;
}
$d_date=$this->validateDate($ddate);
if($d_date==null)
{
$dc_date="1970-01-01";
}
else
{
    $dc_date = $d_date;
}

//var_dump($orderdate);
//var_dump($cnt);
$ldgarray = $this->getledgerdatasearchbyname($vendor_name);

foreach ($ldgarray as $lvalue) {
    //var_dump($lvalue);
    # code...
    $statecode=$lvalue['account_statecode'];
    $gstin=$lvalue['account_gstin'];
    $db_account=$lvalue['id'];
}
$r=0;

for ($i=0; $i <count($this->input->post('itemqty')) ; $i++) { 
    # code...

    # code...

$itemgstpc = $this->input->post('itemgstpc');
$itemamt = $this->input->post('itemamt');
$itemnet = $this->input->post('itemnet');

//echo $itemgstpc[$i];
//var_dump($itemamt);
//var_dump($itemnet);


if($cpos==$statecode)
{
// Intra state
$cgstpc=0;
$sgstpc=0;
$cgstamt=0;
$sgstamt=0;    
$igstpc=0;
$igstamt=0;
$cgstpc = $itemgstpc[$i]/2;
$sgstpc = $itemgstpc[$i]/2;
$cgstamt = ($itemamt[$i]*$cgstpc)/100;
$sgstamt = ($itemamt[$i]*$sgstpc)/100;
//var_dump($sgstpc);
}
else 
{
//Inter state
$igstpc=0;
$igstamt=0;    
$cgstpc=0;
$sgstpc=0;
$cgstamt=0;
$sgstamt=0;    
$results=array();
$igstpc = $itemgstpc[$i];
$igstamt = ($itemamt[$i]*$igstpc)/100;
//var_dump($igstpc);
}

$tax_tot=$tax_tot+$itemamt[$i];
$net_tot=$net_tot+$itemnet[$i];

$r++;


}


$url=$this->config->item("api_url") . "/api/settings";

$data_array= array("compId"=>$compId,"finyear"=>$finyear);
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");  

 curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_array));
  $setresponse = curl_exec($ch);
  curl_close($ch); // Close the connection
//var_dump($setresponse);
$settArr = json_decode($setresponse,true);


if($settArr)
{
    # code...
  //var_dump($settArr);
    $iprefix = $settArr[0]['inv_prefix'];
    $isuffix = $settArr[0]['inv_suffix'];
    $inv_no = $settArr[0]['inv_no'];
    $inv_numtype = $settArr[0]['inv_numtype'];
    $inv_leadingzero = $settArr[0]['leading_zero'];

if($inv_numtype=="ZEROPAD")
{
//$ivno= $inv_no;
$_invno = sprintf("%0". $inv_leadingzero ."d", $inv_no);
//$invnum = printf("[%0" .$inv_leadingzero ."s]\n",   $ivno); // zero-padding works on strings too

$invno = $iprefix . $_invno . $isuffix;
$next_invno = $inv_no+1;
}
else
{
    $_invno= $inv_no;
    $invno = $iprefix . $_invno . $isuffix;
    $next_invno = $inv_no+1;
}



}


//var_dump($invno);
//Transaction Sales & Purhcase

$url=$this->config->item("api_url") . "/api/transaction";

$data_array=array(
    "trans_id"=>$invno,
    "trans_date"=>$invdate,
    "order_no"=>$orderno,
    "order_date"=>$orderdate,
    "dc_no"=>$dc_no,
    "dc_date"=>$dc_date,
    "trans_type"=>"SALE",            
    "db_account"=>$db_account,
    "cr_account"=>1,
    "statecode"=>$statecode,
    "gstin"=>$gstin,
    "finyear"=>$finyear,
    "salebyperson"=>$salebyperson,
    "inv_type"=>$invtype,
    "trans_amount"=>$tax_tot,
    "net_amount"=>$net_tot,
    "company_id"=>$compId);


  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");  
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_array));
  $response = curl_exec($ch);
  //var_dump($response);
  //echo $response;
  //$result = json_decode($response);
  curl_close($ch); // Close the connection

$res = json_decode($response,true);
//var_dump($res);

$ins_sql=array();
$id=$res['last_ins_id'];

//var_dump("id = " . $id);
if($id)
{
$url=$this->config->item("api_url") . "/api/productlist/updsettings";

$compId = $this->session->userdata('id');
$finyear = $this->session->userdata('finyear');

$data_array=array("finyear"=>$finyear,"compId"=>$compId,"next_no"=>$next_invno,"trans_type"=>"SALE");
 //var_dump($data_array);
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
//  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");  
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_array));
  $updsettresponse = curl_exec($ch);
curl_close($ch);
 //var_dump($updsettresponse);
 //$sts= json_decode($updsettresponse,true);
//var_dump($sts);
$sts="1";
}
else
{
  $sts = "0";
}


if($sts=="1")
{

$cnt = count($this->input->post('itemqty'));
//var_dump($cnt);
//for($rw = 0; $rw < count($this->input->post('itemqty')); $rw++) {
for ($i=0; $i <count($this->input->post('itemqty')) ; $i++) { 

//for($rw = $cnt; $rw >1; $rw--) {
    //print_r($rw);
//$taxable_amt = $this->input->post('txbval')[$rw];
$itemname = $this->input->post('itemname');
//var_dump($itemid);

$itemData = json_decode($this->getproductdatabyname($itemname[$i]),true);
//var_dump($itemData);
//$obj = json_decode($itemData);

if($itemData)
{
    $itemmrp= $itemData[0]['prod_mrp'];
    $itemname=$itemData[0]['prod_name'];
    $itemid=$itemData[0]['id'];
  //var_dump($itemmrp);
  //  var_dump($itemid);
}
if(is_numeric($itemmrp))
{
    $item_mrp=floatval($itemmrp);
}
else
{
    $item_mrp="0.00";
}


//$itemname = $itemname[$i];
$itemdesc = $this->input->post('itemdesc');
$itemhsn = $this->input->post('hsnsac');
$itemgstpc = $this->input->post('itemgstpc');
$itemuom = $this->input->post('itemunit');
$itemqty = $this->input->post('itemqty');
$itemrate = $this->input->post('itemrate');

$itemdispc = $this->input->post('itemdispc');

if(is_null($itemdispc[$i]) )
{
 $item_dispc=0.00;   
 
}
else
{
 $item_dispc = floatval($itemdispc[$i]);  
}

//var_dump($itemrate);
//var_dump($itemqty);
//var_dump($itemdispc);
$itemdis = (($itemrate[$i]*$itemqty[$i])*$item_dispc/100);

//$itemdis = $this->input->post('itemdis')[$rw];
//$itemmrp = $itemmrp[$i];
//$itemgstamt = $this->input->post('itemgstamt')[$rw];
$itemamt = $this->input->post('itemamt');
$itemnet = $this->input->post('itemnet');



if($cpos==$statecode)
{
// Intra state
$cgstpc=0;
$sgstpc=0;
$cgstamt=0;
$sgstamt=0;    
$igstpc=0;
$igstamt=0;
$cgstpc = $itemgstpc[$i]/2;
$sgstpc = $itemgstpc[$i]/2;
$cgstamt = ($itemamt[$i]*$cgstpc)/100;
$sgstamt = ($itemamt[$i]*$sgstpc)/100;

}
else 
{
//Inter state
$igstpc=0;
$igstamt=0;    
$cgstpc=0;
$sgstpc=0;
$cgstamt=0;
$sgstamt=0;    
$results=array();
$igstpc = $itemgstpc[$i];
$igstamt = ($itemamt[$i]*$igstpc)/100;
}

$tax_tot=$tax_tot+$itemamt[$i];
$net_tot=$tax_tot+$itemnet[$i];

$ins_sql[] = array("trans_link_id"=>$id,"item_name"=>$itemname, "item_hsnsac"=>$itemhsn[$i],"trans_id"=>$invno,"trans_date"=>$invdate,"trans_type"=>"SALE","item_id"=>$itemid,"item_unit"=>$itemuom[$i],"item_qty"=>$itemqty[$i],"item_rate"=>$itemrate[$i],"item_amount"=>$itemamt[$i],"item_mrp"=>$item_mrp,"item_gstpc"=>$itemgstpc[$i],"item_dispc"=>$item_dispc,"item_disamount"=>$itemdis,"cgst_amount"=>$cgstamt,"sgst_amount"=>$sgstamt,"igst_amount"=>$igstamt,"cgst_pc"=>$cgstpc,"sgst_pc"=>$sgstpc,"igst_pc"=>$igstpc,"taxable_amount"=>$itemamt[$i],"nett_amount"=>$itemnet[$i],"item_desc"=>$itemdesc[$i],"company_id"=>$compId,"finyear"=>$finyear);


//var_dump($ins_sql);
}

$each_data=array();
$url=$this->config->item("api_url") . "/api/itemtransaction";

$ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);



foreach($ins_sql as $r) {
    //var_dump($r);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($r));
    $results = curl_exec($ch);
    curl_close($ch);



}

}
echo $results;



}


public function getSettings()
{
$compId = $this->session->userdata('id');
$finyear = $this->session->userdata('finyear');

$url=$this->config->item("api_url") . "/api/settings";

$data_array= array("compId"=>$compId,"finyear"=>$finyear);
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");  
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_array));
  $setresponse = curl_exec($ch);
  curl_close($ch); // Close the connection
//var_dump($setresponse);
$settArr = json_decode($setresponse,true);
//var_dump($settArr);

if($settArr)
{
    # code...
  //var_dump($settArr);
    $iprefix = $settArr[0]['inv_prefix'];
    $isuffix = $settArr[0]['inv_suffix'];
    $inv_no = $settArr[0]['inv_no'];
    $inv_numtype = $settArr[0]['inv_numtype'];
    $inv_leadingzero = $settArr[0]['leading_zero'];

if($inv_numtype=="ZEROPAD")
{
//$ivno= $inv_no;
$_invno = sprintf("%0". $inv_leadingzero ."d", $inv_no);
//$invnum = printf("[%0" .$inv_leadingzero ."s]\n",   $ivno); // zero-padding works on strings too

$invno = $iprefix . $_invno . $isuffix;
$next_invno = $inv_no+1;
}
else
{
    $_invno= $inv_no;
    $invno = $iprefix . $_invno . $isuffix;
 //   $next_invno = $inv_no+1;
}


}

echo $invno;

}

public function createPurchase()
{
$tax_tot=0;
$net_tot=0;
$itemdispc=0.00;

$compId = $this->session->userdata('id');
$finyear = $this->session->userdata('finyear');
$cpos = $this->session->userdata('cstatecode');
$statecode = $this->input->post('statecode');
$cnt = count($this->input->post('itemqty'));


//Main Sales
    
    $invno= $this->input->post('invoiceno');
    $invdate= $this->input->post('invdate');
    $orderno= $this->input->post('orderno');
    $odate= $this->input->post('orderdate');
    $dc_no= $this->input->post('dcno');
    $ddate= $this->input->post('dcdate');
    $vendor_name= $this->input->post('customer_name');
    //$statecode = $this->input->post('editstatecode');
    $invtype= $this->input->post('invtype');

    $salebyperson=0;//$this->input->post('salebyperson');

$o_date=$this->validateDate($odate);
if($o_date==null)
{
$orderdate="1970-01-01";
}
else
{
    $orderdate = $o_date;
}
$d_date=$this->validateDate($ddate);
if($d_date==null)
{
$dc_date="1970-01-01";
}
else
{
    $dc_date = $d_date;
}

//var_dump($orderdate);
//var_dump($cnt);
$ldgarray = $this->getledgerdatasearchbyname($vendor_name);

foreach ($ldgarray as $lvalue) {
    //var_dump($lvalue);
    # code...
    $statecode=$lvalue['account_statecode'];
    $gstin=$lvalue['account_gstin'];
    $db_account=$lvalue['id'];
}
$r=0;

for ($i=0; $i <count($this->input->post('itemqty')) ; $i++) { 
    # code...

    # code...

$itemgstpc = $this->input->post('itemgstpc');
$itemamt = $this->input->post('itemamt');
$itemnet = $this->input->post('itemnet');

//echo $itemgstpc[$i];
//var_dump($itemamt);
//var_dump($itemnet);


if($cpos==$statecode)
{
// Intra state
$cgstpc=0;
$sgstpc=0;
$cgstamt=0;
$sgstamt=0;    
$igstpc=0;
$igstamt=0;
$cgstpc = $itemgstpc[$i]/2;
$sgstpc = $itemgstpc[$i]/2;
$cgstamt = ($itemamt[$i]*$cgstpc)/100;
$sgstamt = ($itemamt[$i]*$sgstpc)/100;
//var_dump($sgstpc);
}
else 
{
//Inter state
$igstpc=0;
$igstamt=0;    
$cgstpc=0;
$sgstpc=0;
$cgstamt=0;
$sgstamt=0;    
$results=array();
$igstpc = $itemgstpc[$i];
$igstamt = ($itemamt[$i]*$igstpc)/100;
//var_dump($igstpc);
}

$tax_tot=$tax_tot+$itemamt[$i];
$net_tot=$net_tot+$itemnet[$i];

$r++;


}

//var_dump($invno);
//Transaction Sales & Purhcase

$url=$this->config->item("api_url") . "/api/transaction";

$data_array=array(
    "trans_id"=>$invno,
    "trans_date"=>$invdate,
    "order_no"=>$orderno,
    "order_date"=>$orderdate,
    "dc_no"=>$dc_no,
    "dc_date"=>$dc_date,
    "trans_type"=>"PURC",            
    "db_account"=>$db_account,
    "cr_account"=>2,
    "statecode"=>$statecode,
    "gstin"=>$gstin,
    "finyear"=>$finyear,
    "salebyperson"=>$salebyperson,
    "inv_type"=>$invtype,
    "trans_amount"=>$tax_tot,
    "net_amount"=>$net_tot,
    "company_id"=>$compId);


  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_array));
  $response = curl_exec($ch);
  //var_dump($response);
  //echo $response;
  //$result = json_decode($response);
  curl_close($ch); // Close the connection

$res = json_decode($response,true);


$ins_sql=array();
$id=$res['last_ins_id'];


if($id)
{


$cnt = count($this->input->post('itemqty'));
//var_dump($cnt);
//for($rw = 0; $rw < count($this->input->post('itemqty')); $rw++) {
for ($i=0; $i <count($this->input->post('itemqty')) ; $i++) { 

//for($rw = $cnt; $rw >1; $rw--) {
    //print_r($rw);
//$taxable_amt = $this->input->post('txbval')[$rw];
$itemname = $this->input->post('itemname');
//var_dump($itemid);

$itemData = json_decode($this->getproductdatabyname($itemname[$i]),true);
//var_dump($itemData);
//$obj = json_decode($itemData);

if($itemData)
{
    $itemmrp= $itemData[0]['prod_mrp'];
    $itemname=$itemData[0]['prod_name'];
    $itemid=$itemData[0]['id'];
  //var_dump($itemmrp);
  //  var_dump($itemid);
}
if(is_numeric($itemmrp))
{
    $item_mrp=floatval($itemmrp);
}
else
{
    $item_mrp="0.00";
}


//$itemname = $itemname[$i];
$itemdesc = $this->input->post('itemdesc');
$itemhsn = $this->input->post('hsnsac');
$itemgstpc = $this->input->post('itemgstpc');
$itemuom = $this->input->post('itemunit');
$itemqty = $this->input->post('itemqty');
$itemrate = $this->input->post('itemrate');

$itemdispc = $this->input->post('itemdispc');

if(is_null($itemdispc[$i]) )
{
 $item_dispc=0.00;   
 
}
else
{
 $item_dispc = floatval($itemdispc[$i]);  
}

//var_dump($itemrate);
//var_dump($itemqty);
//var_dump($itemdispc);
$itemdis = (($itemrate[$i]*$itemqty[$i])*$item_dispc/100);

//$itemdis = $this->input->post('itemdis')[$rw];
//$itemmrp = $itemmrp[$i];
//$itemgstamt = $this->input->post('itemgstamt')[$rw];
$itemamt = $this->input->post('itemamt');
$itemnet = $this->input->post('itemnet');



if($cpos==$statecode)
{
// Intra state
$cgstpc=0;
$sgstpc=0;
$cgstamt=0;
$sgstamt=0;    
$igstpc=0;
$igstamt=0;
$cgstpc = $itemgstpc[$i]/2;
$sgstpc = $itemgstpc[$i]/2;
$cgstamt = ($itemamt[$i]*$cgstpc)/100;
$sgstamt = ($itemamt[$i]*$sgstpc)/100;

}
else 
{
//Inter state
$igstpc=0;
$igstamt=0;    
$cgstpc=0;
$sgstpc=0;
$cgstamt=0;
$sgstamt=0;    
$results=array();
$igstpc = $itemgstpc[$i];
$igstamt = ($itemamt[$i]*$igstpc)/100;
}

$tax_tot=$tax_tot+$itemamt[$i];
$net_tot=$tax_tot+$itemnet[$i];

$ins_sql[] = array("trans_link_id"=>$id,"item_name"=>$itemname, "item_hsnsac"=>$itemhsn[$i],"trans_id"=>$invno,"trans_date"=>$invdate,"trans_type"=>"PURC","item_id"=>$itemid,"item_unit"=>$itemuom[$i],"item_qty"=>$itemqty[$i],"item_rate"=>$itemrate[$i],"item_amount"=>$itemamt[$i],"item_mrp"=>$item_mrp,"item_gstpc"=>$itemgstpc[$i],"item_dispc"=>$item_dispc,"item_disamount"=>$itemdis,"cgst_amount"=>$cgstamt,"sgst_amount"=>$sgstamt,"igst_amount"=>$igstamt,"cgst_pc"=>$cgstpc,"sgst_pc"=>$sgstpc,"igst_pc"=>$igstpc,"taxable_amount"=>$itemamt[$i],"nett_amount"=>$itemnet[$i],"item_desc"=>$itemdesc[$i],"company_id"=>$compId,"finyear"=>$finyear);


//var_dump($ins_sql);
}

$each_data=array();
$url=$this->config->item("api_url") . "/api/itemtransaction";

$ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);



foreach($ins_sql as $r) {
    //var_dump($r);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($r));
    $results = curl_exec($ch);
    curl_close($ch);



}

}
echo $results;



}



public function editSales()

{

$tax_tot=0;
$net_tot=0;
$itemdispc=0.00;

$compId = $this->session->userdata('id');
$finyear = $this->session->userdata('finyear');
$cpos = $this->session->userdata('cstatecode');
$statecode = $this->input->post('statecode');
$cnt = count($this->input->post('itemqty'));


//Main Sales
    $id= $this->input->post('recid');
    $invno= $this->input->post('editinvoiceno');
    $invdate= $this->input->post('editinvdate');
    $orderno= $this->input->post('editorderno');
    $orderdate= $this->input->post('editorderdate');
    $dc_no= $this->input->post('editdcno');
    $dc_date= $this->input->post('editdcdate');
    $vendor_name= $this->input->post('customer_name');
    //$statecode = $this->input->post('editstatecode');
    $invtype= $this->input->post('editinvtype');

    $salebyperson=$this->input->post('editsalebyperson');

//var_dump($cnt);
$ldgarray = $this->getledgerdatasearchbyname($vendor_name);

foreach ($ldgarray as $lvalue) {
    //var_dump($lvalue);
    # code...
    $statecode=$lvalue['account_statecode'];
    $gstin=$lvalue['account_gstin'];
    $db_account=$lvalue['id'];
}
$r=0;
//for($rw = $cnt; $rw >1; $rw--) {
//print_r($this->input->post('itemgstpc'));
//$ex_itemgstpc = explode("=>", $this->input->post('itemgstpc'));
//$ex_itemamt = $this->input->post('itemamt');
//$ex_itemnet = $this->input->post('itemnet');

for ($i=0; $i <count($this->input->post('itemqty')) ; $i++) { 
    # code...

    # code...

$itemgstpc = $this->input->post('itemgstpc');
$itemamt = $this->input->post('itemamt');
$itemnet = $this->input->post('itemnet');

//echo $itemgstpc[$i];
//var_dump($itemamt);
//var_dump($itemnet);


if($cpos==$statecode)
{
// Intra state
$cgstpc=0;
$sgstpc=0;
$cgstamt=0;
$sgstamt=0;    
$igstpc=0;
$igstamt=0;
$cgstpc = $itemgstpc[$i]/2;
$sgstpc = $itemgstpc[$i]/2;
$cgstamt = ($itemamt[$i]*$cgstpc)/100;
$sgstamt = ($itemamt[$i]*$sgstpc)/100;
//var_dump($sgstpc);
}
else 
{
//Inter state
$igstpc=0;
$igstamt=0;    
$cgstpc=0;
$sgstpc=0;
$cgstamt=0;
$sgstamt=0;    
$results=array();
$igstpc = $itemgstpc[$i];
$igstamt = ($itemamt[$i]*$igstpc)/100;
//var_dump($igstpc);
}

$tax_tot=$tax_tot+$itemamt[$i];
$net_tot=$net_tot+$itemnet[$i];

$r++;




}


//Transaction Sales & Purhcase


$url=$this->config->item("api_url") . "/api/transaction/" . $id;

$data_array=array(
    //"id"=> $id,
    "trans_date"=>$invdate,
    "order_no"=>$orderno,
    "order_date"=>$orderdate,
    "dc_no"=>$dc_no,
    "dc_date"=>$dc_date,
    "trans_type"=>"SALE",            
    "db_account"=>$db_account,
    "cr_account"=>1,
    "statecode"=>$statecode,
    "gstin"=>$gstin,
    "finyear"=>$finyear,
    "salebyperson"=>$salebyperson,
    "inv_type"=>$invtype,
    "trans_amount"=>$tax_tot,
    "net_amount"=>$net_tot,
    "company_id"=>$compId);

//var_dump($data_array);
//$make_call = $this->callAPI('POST', $url, json_encode($data_array));

//$url=$this->config->item("api_url") . "/api/insert_transaction.php";

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");    
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_array));
  $response = curl_exec($ch);
 // var_dump($response);
  //echo $response;
  //$result = json_decode($response);
  curl_close($ch); // Close the connection

$res = json_decode($response,true);
//echo $response;
//var_dump($res);
if($res['status']=="1")
{
$url=$this->config->item("api_url") . "/api/itemtransaction/" . $id;
$data_array=array("delflag"=>"1");
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");    
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_array));
  $delresponse = curl_exec($ch);

//var_dump($delresponse);
}


$ins_sql=array();
//$upd_sts=$res['last_ins_id'];
//if($upd_sts==true)/
//{
    
//}
//var_dump($trans_link_id);
$cnt = count($this->input->post('itemqty'));
//var_dump($cnt);
//for($rw = 0; $rw < count($this->input->post('itemqty')); $rw++) {
for ($i=0; $i <count($this->input->post('itemqty')) ; $i++) { 

//for($rw = $cnt; $rw >1; $rw--) {
    //print_r($rw);
//$taxable_amt = $this->input->post('txbval')[$rw];
$itemname = $this->input->post('itemname');
//var_dump($itemid);

$itemData = json_decode($this->getproductdatabyname($itemname[$i]),true);
//var_dump($itemData);
//$obj = json_decode($itemData);

if($itemData)
{
    $itemmrp= $itemData[0]['prod_mrp'];
    $itemname=$itemData[0]['prod_name'];
    $itemid=$itemData[0]['id'];
  //var_dump($itemmrp);
  //  var_dump($itemid);
}
if(is_numeric($itemmrp))
{
    $item_mrp=floatval($itemmrp);
}
else
{
    $item_mrp="0.00";
}


//$itemname = $itemname[$i];
$itemdesc = $this->input->post('itemdesc');
$itemhsn = $this->input->post('hsnsac');
$itemgstpc = $this->input->post('itemgstpc');
$itemuom = $this->input->post('itemunit');
$itemqty = $this->input->post('itemqty');
$itemrate = $this->input->post('itemrate');

$itemdispc = $this->input->post('itemdispc');

if(is_null($itemdispc[$i]) )
{
 $item_dispc=0.00;   
 
}
else
{
 $item_dispc = floatval($itemdispc[$i]);  
}

//var_dump($itemrate);
//var_dump($itemqty);
//var_dump($itemdispc);
$itemdis = (($itemrate[$i]*$itemqty[$i])*$item_dispc/100);

//$itemdis = $this->input->post('itemdis')[$rw];
//$itemmrp = $itemmrp[$i];
//$itemgstamt = $this->input->post('itemgstamt')[$rw];
$itemamt = $this->input->post('itemamt');
$itemnet = $this->input->post('itemnet');



if($cpos==$statecode)
{
// Intra state
$cgstpc=0;
$sgstpc=0;
$cgstamt=0;
$sgstamt=0;    
$igstpc=0;
$igstamt=0;
$cgstpc = $itemgstpc[$i]/2;
$sgstpc = $itemgstpc[$i]/2;
$cgstamt = ($itemamt[$i]*$cgstpc)/100;
$sgstamt = ($itemamt[$i]*$sgstpc)/100;

}
else 
{
//Inter state
$igstpc=0;
$igstamt=0;    
$cgstpc=0;
$sgstpc=0;
$cgstamt=0;
$sgstamt=0;    
$results=array();
$igstpc = $itemgstpc[$i];
$igstamt = ($itemamt[$i]*$igstpc)/100;
}

$tax_tot=$tax_tot+$itemamt[$i];
$net_tot=$tax_tot+$itemnet[$i];


$ins_sql[] = array("trans_link_id"=>$id,"item_name"=>$itemname, "item_hsnsac"=>$itemhsn[$i],"trans_id"=>$invno,"trans_date"=>$invdate,"trans_type"=>"SALE", "item_id"=>$itemid,"item_unit"=>$itemuom[$i],"item_qty"=>$itemqty[$i],"item_rate"=>$itemrate[$i],"item_amount"=>$itemamt[$i],"item_mrp"=>$item_mrp,"item_gstpc"=>$itemgstpc[$i],"item_dispc"=>$item_dispc,"item_disamount"=>$itemdis,"cgst_amount"=>$cgstamt,"sgst_amount"=>$sgstamt,"igst_amount"=>$igstamt,"cgst_pc"=>$cgstpc,"sgst_pc"=>$sgstpc,"igst_pc"=>$igstpc,"taxable_amount"=>$itemamt[$i],"nett_amount"=>$itemnet[$i],"item_desc"=>$itemdesc[$i],"company_id"=>$compId,"finyear"=>$finyear);

//$ins_sql[] = array("trans_link_id"=>$id,"item_name"=>$itemname, "item_hsnsac"=>$itemhsn[$i],"trans_id"=>$invno,"trans_date"=>$invdate,"trans_type"=>"SALE","item_id"=>$itemid,"item_unit"=>$itemuom[$i],"item_qty"=>$itemqty[$i],"item_rate"=>$itemrate[$i],"item_amount"=>$itemamt[$i],"item_mrp"=>$item_mrp,"item_gstpc"=>$itemgstpc[$i],"item_dispc"=>$item_dispc,"item_disamount"=>$itemdis,"item_cgst"=>$cgstamt,"item_sgst"=>$sgstamt,"item_igst"=>$igstamt,"cgst_pc"=>$cgstpc,"sgst_pc"=>$sgstpc,"igst_pc"=>$igstpc,"taxable_amount"=>$itemamt[$i],"nett_amount"=>$itemnet[$i],"item_desc"=>$itemdesc[$i],"company_id"=>$compId,"finyear"=>$finyear);


//var_dump($ins_sql);
}

$each_data=array();
$url=$this->config->item("api_url") . "/api/itemtransaction";

$ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);



foreach($ins_sql as $r) {
    //var_dump($r);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");   
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($r));
    $results = curl_exec($ch);
    curl_close($ch);



}
echo $results;


}


public function editPurchase()

{

$taxable_tot=0;
$netamt_tot=0;
$itemdispc=0.00;

$compId = $this->session->userdata('id');
$finyear = $this->session->userdata('finyear');
$cpos = $this->session->userdata('cstatecode');
$statecode = $this->input->post('statecode');
$cnt = count($this->input->post('itemqty'));


//Main Sales
    $id= $this->input->post('recid');
    $invno= $this->input->post('editinvoiceno');
    $invdate= $this->input->post('editinvdate');
    $orderno= $this->input->post('editorderno');
    $orderdate= $this->input->post('editorderdate');
    $dc_no= $this->input->post('editdcno');
    $dc_date= $this->input->post('editdcdate');
    $vendor_name= $this->input->post('customer_name');
    //$statecode = $this->input->post('editstatecode');
    $invtype= $this->input->post('editinvtype');

    $salebyperson=0; //$this->input->post('editsalebyperson');

//var_dump($cnt);
$ldgarray = $this->getledgerdatasearchbyname($vendor_name);

foreach ($ldgarray as $lvalue) {
    //var_dump($lvalue);
    # code...
    $statecode=$lvalue['account_statecode'];
    $gstin=$lvalue['account_gstin'];
    $db_account=$lvalue['id'];
}
$r=0;
//for($rw = $cnt; $rw >1; $rw--) {
//print_r($this->input->post('itemgstpc'));
//$ex_itemgstpc = explode("=>", $this->input->post('itemgstpc'));
//$ex_itemamt = $this->input->post('itemamt');
//$ex_itemnet = $this->input->post('itemnet');

for ($i=0; $i <count($this->input->post('itemqty')) ; $i++) { 
    # code...

    # code...

$itemgstpc = $this->input->post('itemgstpc');
$itemamt = $this->input->post('itemamt');
$itemnet = $this->input->post('itemnet');

//echo $itemgstpc[$i];
//var_dump($itemamt);
//var_dump($itemnet);


if($cpos==$statecode)
{
// Intra state
$cgstpc=0;
$sgstpc=0;
$cgstamt=0;
$sgstamt=0;    
$igstpc=0;
$igstamt=0;
$cgstpc = $itemgstpc[$i]/2;
$sgstpc = $itemgstpc[$i]/2;
$cgstamt = ($itemamt[$i]*$cgstpc)/100;
$sgstamt = ($itemamt[$i]*$sgstpc)/100;
//var_dump($sgstpc);
}
else 
{
//Inter state
$igstpc=0;
$igstamt=0;    
$cgstpc=0;
$sgstpc=0;
$cgstamt=0;
$sgstamt=0;    
$results=array();
$igstpc = $itemgstpc[$i];
$igstamt = ($itemamt[$i]*$igstpc)/100;
//var_dump($igstpc);
}

$taxable_tot=$taxable_tot+$itemamt[$i];
$netamt_tot=$netamt_tot+$itemnet[$i];

$r++;




}


//Transaction Sales & Purhcase


$url=$this->config->item("api_url") . "/api/transaction/" . $id;

$data_array=array(
    
    "trans_date"=>$invdate,
    "order_no"=>$orderno,
    "order_date"=>$orderdate,
    "dc_no"=>$dc_no,
    "dc_date"=>$dc_date,
    "trans_type"=>"PURC",            
    "db_account"=>$db_account,
    "cr_account"=>2,
    "statecode"=>$statecode,
    "gstin"=>$gstin,
    "finyear"=>$finyear,
    "salebyperson"=>$salebyperson,
    "inv_type"=>$invtype,
    "trans_amount"=>$taxable_tot,
    "net_amount"=>$netamt_tot,
    "company_id"=>$compId);

//var_dump($data_array);
//$make_call = $this->callAPI('POST', $url, json_encode($data_array));

//$url=$this->config->item("api_url") . "/api/insert_transaction.php";

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");    
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_array));
  $response = curl_exec($ch);
  //var_dump($response);
  //echo $response;
  //$result = json_decode($response);
  curl_close($ch); // Close the connection

$res = json_decode($response,true);
//echo $response;
//var_dump($res);
if($res['status']=="1")
{
$url=$this->config->item("api_url") . "/api/itemtransaction/" . $id;
$data_array=array("delflag"=>"1");
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");    
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_array));
  $delresponse = curl_exec($ch);

//var_dump($delresponse);
}


$ins_sql=array();
//$upd_sts=$res['last_ins_id'];
//if($upd_sts==true)/
//{
    
//}
//var_dump($trans_link_id);
$cnt = count($this->input->post('itemqty'));
//var_dump($cnt);
//for($rw = 0; $rw < count($this->input->post('itemqty')); $rw++) {
for ($i=0; $i <count($this->input->post('itemqty')) ; $i++) { 
$item_amt=0;
$item_net=0;

//for($rw = $cnt; $rw >1; $rw--) {
    //print_r($rw);
//$taxable_amt = $this->input->post('txbval')[$rw];
$itemname = $this->input->post('itemname');
//var_dump($itemid);
//var_dump($itemname);
$itemData = json_decode($this->getproductdatabyname($itemname[$i]),true);
//var_dump($itemData);
//$obj = json_decode($itemData);

if($itemData)
{
    $itemmrp= $itemData[0]['prod_mrp'];
    $itemname=$itemData[0]['prod_name'];
    $itemid=$itemData[0]['id'];
  //var_dump($itemmrp);
  //  var_dump($itemid);
}
if(is_numeric($itemmrp))
{
    $item_mrp=floatval($itemmrp);
}
else
{
    $item_mrp="0.00";
}


//$itemname = $itemname[$i];
$itemdesc = $this->input->post('itemdesc');
$itemhsn = $this->input->post('hsnsac');
$itemgstpc = $this->input->post('itemgstpc');
$itemuom = $this->input->post('itemunit');
$itemqty = $this->input->post('itemqty');
$itemrate = $this->input->post('itemrate');

$itemdispc = $this->input->post('itemdispc');

if(is_null($itemdispc[$i]) )
{
 $item_dispc=0.00;   
 
}
else
{
 $item_dispc = floatval($itemdispc[$i]);  
}

//var_dump($itemrate);
//var_dump($itemqty);
//var_dump($itemdispc);
$itemdis = (($itemrate[$i]*$itemqty[$i])*$item_dispc/100);

//$itemdis = $this->input->post('itemdis')[$rw];
//$itemmrp = $itemmrp[$i];
//$itemgstamt = $this->input->post('itemgstamt')[$rw];
$itemamt = $this->input->post('itemamt');
$itemnet = $this->input->post('itemnet');

$item_amt = $itemamt[$i];
$item_net = $itemnet[$i];



if($cpos==$statecode)
{
// Intra state
$cgstpc=0;
$sgstpc=0;
$cgstamt=0;
$sgstamt=0;    
$igstpc=0;
$igstamt=0;
$cgstpc = $itemgstpc[$i]/2;
$sgstpc = $itemgstpc[$i]/2;
$cgstamt = ($itemamt[$i]*$cgstpc)/100;
$sgstamt = ($itemamt[$i]*$sgstpc)/100;

}
else 
{
//Inter state
$igstpc=0;
$igstamt=0;    
$cgstpc=0;
$sgstpc=0;
$cgstamt=0;
$sgstamt=0;    
$results=array();
$igstpc = $itemgstpc[$i];
$igstamt = ($itemamt[$i]*$igstpc)/100;
}

//var_dump( $itemamt[$i]);
//var_dump( $itemnet[$i]);

$ins_sql[] = array("trans_link_id"=>$id,"item_name"=>$itemname, "item_hsnsac"=>$itemhsn[$i],"trans_id"=>$invno,"trans_date"=>$invdate,"trans_type"=>"PURC", "item_id"=>$itemid,"item_unit"=>$itemuom[$i],"item_qty"=>$itemqty[$i],"item_rate"=>$itemrate[$i],"item_amount"=>$itemamt[$i],"item_mrp"=>$item_mrp,"item_gstpc"=>$itemgstpc[$i],"item_dispc"=>$item_dispc,"item_disamount"=>$itemdis,"cgst_amount"=>$cgstamt,"sgst_amount"=>$sgstamt,"igst_amount"=>$igstamt,"cgst_pc"=>$cgstpc,"sgst_pc"=>$sgstpc,"igst_pc"=>$igstpc,"taxable_amount"=>$itemamt[$i],"nett_amount"=>$itemnet[$i],"item_desc"=>$itemdesc[$i],"company_id"=>$compId,"finyear"=>$finyear);
//var_dump($ins_sql);
}



//var_dump($net_tot);

$each_data=array();
//$url=$this->config->item("api_url") . "/api/insert_transactionitems.php";
$url=$this->config->item("api_url") . "/api/itemtransaction";
$ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);



foreach($ins_sql as $r) {
    //var_dump($r);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($r));
    $results = curl_exec($ch);
    curl_close($ch);



}


echo $results;


}






//Add Sales
public function addSales()
{
$tax_tot=0;
$net_tot=0;
$compId = $this->session->userdata('id');
$finyear = $this->session->userdata('finyear');
$cpos = $this->session->userdata('cstatecode');
$statecode = $this->input->post('statecode');
$cnt = count($this->input->post('itemqty'));


for($rw = $cnt+1; $rw >1; $rw--) {

$itemgstpc = $this->input->post('itemgstpc')[$rw];
$itemamt = $this->input->post('itemamt')[$rw];
$itemnet = $this->input->post('itemnet')[$rw];



if($cpos==$statecode)
{
// Intra state
$cgstpc=0;
$sgstpc=0;
$cgstamt=0;
$sgstamt=0;    
$igstpc=0;
$igstamt=0;
$cgstpc = $itemgstpc/2;
$sgstpc = $itemgstpc/2;
$cgstamt = ($itemamt*$cgstpc)/100;
$sgstamt = ($itemamt*$sgstpc)/100;

}
else 
{
//Inter state
$igstpc=0;
$igstamt=0;    
$cgstpc=0;
$sgstpc=0;
$cgstamt=0;
$sgstamt=0;    
$results=array();
$igstpc = $itemgstpc;
$igstamt = ($itemamt*$igstpc)/100;
}

$tax_tot=$tax_tot+$itemamt;
$net_tot=$net_tot+$itemnet;


}


//Main Purchase 
    $invno= $this->input->post('invoice_no');
    $invdate= $this->input->post('invoice_date');
    $orderno= $this->input->post('order_no');
    $orderdate= $this->input->post('order_date');
    $dc_no= $this->input->post('dc_no');
    $dc_date= $this->input->post('dc_date');
    $vendor_name= $this->input->post('customer_name');
    $statecode = $this->input->post('statecode');
    $gstin= $this->input->post('gstin');
    $salebyperson=$this->input->post('salesperson_name');

//Items Purchase


$url=$this->config->item("api_url") . "/api/insert_transaction.php";

$data_array=array(
    "trans_id"=> $invno,
    "trans_date"=>$invdate,
    "order_no"=>$orderno,
    "order_date"=>$orderdate,
    "dc_no"=>$dc_no,
    "dc_date"=>$dc_date,
    "trans_type"=>"SALE",            
    "db_account"=>$vendor_name,
    "cr_account"=>1,
    "statecode"=>$statecode,
    "gstin"=>$gstin,
    "trans_narration"=>"OUTWARD ENTRY POSTED",
    "finyear"=>$finyear,
    "salebyperson"=>$salebyperson,
    "taxable_amount"=>$tax_tot,
    "nett_amount"=>$net_tot,
    "company_id"=>$compId);

//var_dump($data_array);
//$make_call = $this->callAPI('POST', $url, json_encode($data_array));

//$url=$this->config->item("api_url") . "/api/insert_transaction.php";

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_array));
  $response = curl_exec($ch);
  //echo $response;
  //$result = json_decode($response);
  curl_close($ch); // Close the connection

$res = json_decode($response, true);
//echo $response;
//var_dump($res);
$ins_sql=array();
$trans_link_id=$res['last_ins_id'];
//var_dump($trans_link_id);
$cnt = count($this->input->post('itemqty'));
//var_dump($cnt);
//for($rw = 0; $rw < count($this->input->post('itemqty')); $rw++) {
for($rw = $cnt+1; $rw >1; $rw--) {
    //print_r($rw);
//$taxable_amt = $this->input->post('txbval')[$rw];
$itemid = $this->input->post('itemname')[$rw];


$itemData = $this->getproductdatabyid($itemid);
//var_dump(json_decode($itemData));
$obj = json_decode($itemData);
//var_dump($obj);
if($obj)
{
    $itemmrp= $obj->mrp;
    $itemname=$obj->name;
//    print_r($itemmrp);

}
$itemname = $itemname;
$itemdesc = $this->input->post('itemdesc')[$rw];
$itemhsn = $this->input->post('itemhsn')[$rw];
$itemgstpc = $this->input->post('itemgstpc')[$rw];
$itemuom = $this->input->post('itemuom')[$rw];
$itemqty = $this->input->post('itemqty')[$rw];
$itemrate = $this->input->post('itemrate')[$rw];
$itemdispc = $this->input->post('itemdispc')[$rw];
$itemdis = $this->input->post('itemdis')[$rw];
$itemmrp = $itemmrp;
//$itemgstamt = $this->input->post('itemgstamt')[$rw];
$itemamt = $this->input->post('itemamt')[$rw];
$itemnet = $this->input->post('itemnet')[$rw];



if($cpos==$statecode)
{
// Intra state
$cgstpc=0;
$sgstpc=0;
$cgstamt=0;
$sgstamt=0;    
$igstpc=0;
$igstamt=0;
$cgstpc = $itemgstpc/2;
$sgstpc = $itemgstpc/2;
$cgstamt = ($itemamt*$cgstpc)/100;
$sgstamt = ($itemamt*$sgstpc)/100;

}
else 
{
//Inter state
$igstpc=0;
$igstamt=0;    
$cgstpc=0;
$sgstpc=0;
$cgstamt=0;
$sgstamt=0;    
$results=array();
$igstpc = $itemgstpc;
$igstamt = ($itemamt*$igstpc)/100;
}

//$tax_tot=$tax_tot+$itemamt;
//$net_tot=$tax_tot+$itemnet;

$ins_sql[] = array("trans_link_id"=>$trans_link_id,"item_name"=>$itemname, "item_hsnsac"=>$itemhsn,"trans_id"=>$invno,"trans_date"=>$invdate,"trans_type"=>"SALE","item_id"=>$itemid,/*"item_name"=>$item_name,*/"item_unit"=>$itemuom,"item_qty"=>$itemqty,"item_rate"=>$itemrate,"item_amount"=>$itemamt,"item_mrp"=>$item_mrp,"item_gstpc"=>$itemgstpc,"item_dispc"=>$itemdispc,"item_disamount"=>$itemdis,"item_cgst"=>$cgstamt,"item_sgst"=>$sgstamt,"item_igst"=>$igstamt,"cgst_pc"=>$cgstpc,"sgst_pc"=>$sgstpc,"igst_pc"=>$igstpc,"taxable_amount"=>$itemamt,"nett_amount"=>$itemnet,"item_desc"=>$itemdesc,"company_id"=>$compId,"finyear"=>$finyear);

//$ins_sql = array($trans_link_id,$itemhsn,$invno,$invdate,$itemid,$itemuom,$itemqty,$itemrate,$itemamt,$itemgstpc,$itemdispc,$itemdis,$cgstamt,$sgstamt,$igstamt,$cgstpc,$sgstpc,$igstpc,$itemamt,$itemnet,$itemdesc,$compId);
//var_dump($ins_sql);

}

$each_data=array();
$url=$this->config->item("api_url") . "/api/insert_transactionitems.php";

$ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);



foreach($ins_sql as $r) {
    //var_dump($r);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($r));
    $results = curl_exec($ch);
    curl_close($ch);



}
echo $results;

}


//Sales Return
public function addRSales()
{
$tax_tot=0;
$net_tot=0;
$compId = $this->session->userdata('id');
$finyear = $this->session->userdata('finyear');
$cpos = $this->session->userdata('cstatecode');
$statecode = $this->input->post('statecode');
$cnt = count($this->input->post('itemqty'));



for($rw = 0; $rw<$cnt;  $rw++) {

$itemgstpc = $this->input->post('itemgstpc')[$rw];
$itemamt = $this->input->post('itemamt')[$rw];
$itemnet = $this->input->post('itemnet')[$rw];



if($cpos==$statecode)
{
// Intra state
$cgstpc=0;
$sgstpc=0;
$cgstamt=0;
$sgstamt=0;    
$igstpc=0;
$igstamt=0;
$cgstpc = $itemgstpc/2;
$sgstpc = $itemgstpc/2;
$cgstamt = ($itemamt*$cgstpc)/100;
$sgstamt = ($itemamt*$sgstpc)/100;

}
else 
{
//Inter state
$igstpc=0;
$igstamt=0;    
$cgstpc=0;
$sgstpc=0;
$cgstamt=0;
$sgstamt=0;    
$results=array();
$igstpc = $itemgstpc;
$igstamt = ($itemamt*$igstpc)/100;
}

$tax_tot=$tax_tot+$itemamt;
$net_tot=$net_tot+$itemnet;


}


//Main Purchase 
    $cndninvno= $this->input->post('cndn_no');
    $cndninvdate= $this->input->post('cndn_date');

    $invno= $this->input->post('invoiceno');
    $invdate= $this->input->post('invdate');
    //$orderno= $this->input->post('order_no');
    //$o/rderdate= $this->input->post('order_date');
    //$dc_no= $this->input->post('dc_no');
    //$dc_date= $this->input->post('dc_date');
    $vendor_name= $this->input->post('customer_name');
    $statecode = $this->input->post('statecode');
    $gstin= $this->input->post('gstin');
    $salebyperson=$this->input->post('salebyperson');

//Items Purchase
$ldgarray = $this->getledgerdatasearchbyname($vendor_name);

foreach ($ldgarray as $lvalue) {
    //var_dump($lvalue);
    # code...

    $statecode=$lvalue['statecode'];
    $gstin=$lvalue['gstin'];
    $db_account=$lvalue['id'];
}


$url=$this->config->item("api_url") . "/api/insert_cndntransaction.php";

$data_array=array(
    "cndntrans_id"=> $cndninvno,
    "cndntrans_date"=>$cndninvdate,
    "trans_id"=> $invno,
    "trans_date"=>$invdate,
    //"order_no"=>$orderno,
    //"order_date"=>$orderdate,
    //"dc_no"=>$dc_no,
    //"dc_date"=>$dc_date,
    "trans_type"=>"SRTN",            
    "db_account"=>$db_account,
    "cr_account"=>1,
    "statecode"=>$statecode,
    "gstin"=>$gstin,
    "trans_narration"=>"OUTWARD ENTRY POSTED",
    "finyear"=>$finyear,
    "salebyperson"=>$salebyperson,
    "taxable_amount"=>$tax_tot,
    "nett_amount"=>$net_tot,
    "company_id"=>$compId);

var_dump($data_array);
//$make_call = $this->callAPI('POST', $url, json_encode($data_array));

//$url=$this->config->item("api_url") . "/api/insert_transaction.php";

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_array));
  $response = curl_exec($ch);
  echo $response;
  //$result = json_decode($response);
  curl_close($ch); // Close the connection

$res = json_decode($response, true);
//echo $response;
//var_dump($res);
$ins_sql=array();
$trans_link_id=$res['last_ins_id'];
//var_dump($trans_link_id);
$cnt = count($this->input->post('itemqty'));
//var_dump($cnt);
//for($rw = 0; $rw < count($this->input->post('itemqty')); $rw++) {
for($rw =0; $rw<$cnt; $rw++) {
    //print_r($rw);
//$taxable_amt = $this->input->post('txbval')[$rw];
$itemid = $this->input->post('itemname')[$rw];


$itemData = $this->getproductdatabyid($itemid);
//var_dump(json_decode($itemData));
$obj = json_decode($itemData);
//var_dump($obj);
if($obj)
{
    $itemmrp= $obj->mrp;
    $itemname=$obj->name;
//    print_r($itemmrp);

}
/*$itemdesc = $this->input->post('itemdesc');
$itemhsn = $this->input->post('hsnsac');
$itemgstpc = $this->input->post('itemgstpc');
$itemuom = $this->input->post('itemunit');
$itemqty = $this->input->post('itemqty');
$itemrate = $this->input->post('itemrate');

$itemdispc = $this->input->post('itemdispc');
*/

$itemname = $this->input->post('itemname')[$rw];
$itemdesc = $this->input->post('itemdesc')[$rw];
$itemhsn = $this->input->post('hsnsac')[$rw];
$itemgstpc = $this->input->post('itemgstpc')[$rw];
$itemuom = $this->input->post('itemunit')[$rw];
$itemqty = $this->input->post('itemqty')[$rw];
$itemstk = $this->input->post('itemstk')[$rw];
$itemrate = $this->input->post('itemrate')[$rw];
$itemdispc = $this->input->post('itemdispc')[$rw];
//$itemdis = $this->input->post('itemdis')[$rw];
$itemmrp = $this->input->post('itemmrp')[$rw];
//$itemgstamt = $this->input->post('itemgstamt')[$rw];
$itemamt = $this->input->post('itemamt')[$rw];
$itemnet = $this->input->post('itemnet')[$rw];



if($cpos==$statecode)
{
// Intra state
$cgstpc=0;
$sgstpc=0;
$cgstamt=0;
$sgstamt=0;    
$igstpc=0;
$igstamt=0;
$cgstpc = $itemgstpc/2;
$sgstpc = $itemgstpc/2;
$cgstamt = ($itemamt*$cgstpc)/100;
$sgstamt = ($itemamt*$sgstpc)/100;

}
else 
{
//Inter state
$igstpc=0;
$igstamt=0;    
$cgstpc=0;
$sgstpc=0;
$cgstamt=0;
$sgstamt=0;    
$results=array();
$igstpc = $itemgstpc;
$igstamt = ($itemamt*$igstpc)/100;
}

//$tax_tot=$tax_tot+$itemamt;
//$net_tot=$tax_tot+$itemnet;

$ins_sql[] = array("trans_link_id"=>$trans_link_id,"item_name"=>$itemname, "item_hsnsac"=>$itemhsn,"trans_id"=>$invno,"trans_date"=>$invdate,"trans_type"=>"SALE","item_id"=>$itemid,/*"item_name"=>$item_name,*/"item_stock"=>$itemstk,"item_unit"=>$itemuom,"item_qty"=>$itemqty,"item_rate"=>$itemrate,"item_amount"=>$itemamt,"item_mrp"=>$item_mrp,"item_gstpc"=>$itemgstpc,"item_dispc"=>$itemdispc,"item_disamount"=>$itemdis,"item_cgst"=>$cgstamt,"item_sgst"=>$sgstamt,"item_igst"=>$igstamt,"cgst_pc"=>$cgstpc,"sgst_pc"=>$sgstpc,"igst_pc"=>$igstpc,"taxable_amount"=>$itemamt,"nett_amount"=>$itemnet,"item_desc"=>$itemdesc,"company_id"=>$compId,"finyear"=>$finyear);

//$ins_sql = array($trans_link_id,$itemhsn,$invno,$invdate,$itemid,$itemuom,$itemqty,$itemrate,$itemamt,$itemgstpc,$itemdispc,$itemdis,$cgstamt,$sgstamt,$igstamt,$cgstpc,$sgstpc,$igstpc,$itemamt,$itemnet,$itemdesc,$compId);
//var_dump($ins_sql);

}

$each_data=array();
$url=$this->config->item("api_url") . "/api/insert_cndntransactionitems.php";

$ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);



foreach($ins_sql as $r) {
    //var_dump($r);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($r));
    $results = curl_exec($ch);
    curl_close($ch);



}
echo $results;

}





public function getLedgerGroup()
{
$url=$this->config->item("api_url") . "/api/getgroup.php";
//$post = ['batch_id'=> "2"];
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  //curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
  $response = curl_exec($ch);
  //$result = json_decode($response);
  curl_close($ch); // Close the connection
$groupArray = json_decode($response, true);
//$character = json_decode($data);
//print_r($response);
$data=array();
$option="";
foreach ($groupArray['group'] as $key => $value) {
$option .= '<option value="'.$value['id'].'">'.$value['group_name'].'</option>';

}
echo $option;

}


public function getProductUnitArr()
{
$url=$this->config->item("api_url") . "/api/units";
//$post = ['batch_id'=> "2"];
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  $response = curl_exec($ch);
  //$result = json_decode($response);
  //var_dump($response);
  curl_close($ch); // Close the connection
$uomArray = json_decode($response, true);
//$character = json_decode($data);
//print_r($response);
$data=array();
return $response;
}


public function getProductUnit()
{
$url=$this->config->item("api_url") . "/api/units";
//$post = ['batch_id'=> "2"];
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  $response = curl_exec($ch);
  //$result = json_decode($response);
  curl_close($ch); // Close the connection
$unitArray = json_decode($response, true);
//$character = json_decode($data);
//print_r($response);
$data=array();
$option="";
foreach ($unitArray as $key => $value) {
$option .= '<option value="'.$value['unit_id'].'">'.$value['unit_id'].'</option>';

}
echo $option;

}

public function getStates()
{
$url=$this->config->item("api_url") . "/api/state";
//$post = ['batch_id'=> "2"];
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  $response = curl_exec($ch);
  //$result = json_decode($response);
  curl_close($ch); // Close the connection
$stateArray = json_decode($response, true);
//$character = json_decode($data);
//print_r($response);
$data=array();
$option="";
foreach ($stateArray as $key => $value) {
    if($value['state_name']=="Tamil Nadu")
    {
$option .= '<option selected  value="'.$value['statecode_id'].'">'.$value['state_name'].'</option>';
}
else
{
 $option .= '<option value="'.$value['statecode_id'].'">'.$value['state_name'].'</option>';   
}
}
echo $option;

}



public function getLedgerforUpdate()
{

$tbl="";    
$id = $this->input->get('id');

$url=$this->config->item("api_url") . "/api/ledger/" . $id;

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  $response = curl_exec($ch);
  //$result = json_decode($response);
  curl_close($ch); // Close the connection
$ledgerArray = json_decode($response, true);
//var_dump($ledgerArray);

//$character = json_decode($data);
//print_r($response);
$url=$this->config->item("api_url") . "/api/group";
//$post = ['batch_id'=> "2"];
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  $response = curl_exec($ch);
  //$result = json_decode($response);
  curl_close($ch); // Close the connection
$groupArray = json_decode($response, true);



$url=$this->config->item("api_url") . "/api/state";
//$post = ['batch_id'=> "2"];
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  $response = curl_exec($ch);
  //$result = json_decode($response);
  curl_close($ch); // Close the connection
$stateArray = json_decode($response, true);


$data=array();
$option="";
/*foreach ($unitArray['units'] as $key => $value) {
$option .= '<option value="'.$value['unit_id'].'">'.$value['unit_name'].'</option>';

}*/

//print_r($prodArray["id"]);



//print_r($prodArray['name']);
$tbl .='<div class="card"><!--Card content--><div class="card-body px-lg-5 pt-0"><div class="form-row">
                <div class="col"><!-- First name --><div class="md-form"><input type="text" id="recid" name="recid" value="' . $ledgerArray["id"] . '" hidden ><label for="ledgername">LEDGER ACCOUNT NAME</label><input oninput="this.value = this.value.toUpperCase()" type="text" value="' . $ledgerArray["name"] . '" id="ledgername" name="ledgername" class="form-control" autocomplete="off" required></div></div><div class="col"><!-- Last name --><div class="md-form"><label for="ledgergstin">GSTIN NUMBER</label><input type="text" oninput="this.value = this.value.toUpperCase()"  id="ledgergstin" name="ledgergstin"  value="' . $ledgerArray["gstin"] . '"  class="form-control" autocomplete="off"></div></div><div class="col"><!-- Last name --><div class="md-form"><label for="ledgeraddress">ADDRESS</label><input type="text" oninput="this.value = this.value.toUpperCase()"  id="ledgeraddress"  value="' . $ledgerArray["address"] . '"  autocomplete="off" name="ledgeraddress" class="form-control"></div></div><div class="col"><!-- Last name --><div class="md-form"><label for="ledgergroup">GROUP</label><br>
                        <select id="ledgergroup" class="form-control" name="ledgergroup">';

foreach ($groupArray['group'] as $key => $value) {
  if($ledgerArray["groupid"]==$value["id"])
    {
$tbl .= '<option value="'.$value['id'].'" selected>'.$value['group_name'].'</option>';
}
else 
{
 $tbl .= '<option value="'.$value['id'].'">'.$value['group_name'].'</option>';   
}
}

                        $tbl .='</select></div></div></div><div class="form-row"><div class="col"><!-- First name --><div class="md-form"><label for="ledgercity">CITY</label><input type="text" id="ledgercity" oninput="this.value = this.value.toUpperCase()"   style="text-align: right;" autocomplete="off"  value="' . $ledgerArray["city"] . '" name="ledgercity" class="form-control"></div></div><div class="col"><!-- Last name --><div class="md-form"><label for="Inventorytate">STATE</label><br><select id="Inventorytate" oninput="this.value = this.value.toUpperCase()"  style="width: 250px; height: 20px;" name="Inventorytate">';
foreach ($stateArray['state'] as $key => $value) {
  if($ledgerArray["statecode"]==$value["id"])
    {
$tbl .= '<option value="'.$value['statecode_id'].'" selected>'.$value['state_name'].'</option>';
}
else 
{
 $tbl .= '<option value="'.$value['statecode_id'].'">'.$value['state_name'].'</option>';   
}
}


                        $tbl .='</select></div></div><div class="col"><!-- Last name --><div class="md-form"><label for="ledgercontact">CONTACT#</label><input type="text"  style="text-align: right;"  id="ledgercontact" autocomplete="off"   name="ledgercontact" oninput="this.value = this.value.toUpperCase()" value="' . $ledgerArray["contact"] . '"   class="form-control"></div></div><div class="col"><!-- Last name --><div class="md-form"><label for="ledgeremail">EMAIL</label><input type="email" id="ledgeremail"  value="' . $ledgerArray["email"] . '" name="ledgeremail" oninput="this.value = this.value.toUpperCase()"  style="text-align: right;"  autocomplete="off" class="form-control"></div></div></div><div class="form-row"><div class="col"><!-- First name --><div class="md-form"><label for="ledgerbustype">BUSINESS TYPE</label><select class="form-control" id="bus_type" name="bus_type"><option value="0">Regular</option>
                          <option value="1">Store</option>';


                          $tbl .= '</select></div></div><div class="col"><!-- Last name --><div class="md-form"><label for="ledgerpan">PAN#</label><input type="text" id="ledgerpan" oninput="this.value = this.value.toUpperCase()"  autocomplete="off" name="ledgerpan" value="' . $ledgerArray["pan"] . '"  class="form-control"></div></div><div class="col"><!-- Last name --><div class="md-form"><label for="ledgeropenbal">OPENING BALANCE</label><input style="text-align: right;" type="text"  value="' . $ledgerArray["openbal"] . '" id="ledgeropenbal" name="ledgeropenbal" autocomplete="off" value="0.00" class="form-control"></div></div></div><input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>"></div></div>';




echo $tbl;

}

public function getLedger()
{
$url=$this->config->item("api_url") . "/api/getallInventory.php";
//$post = ['batch_id'=> "2"];
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  $response = curl_exec($ch);
  //$result = json_decode($response);
  curl_close($ch); // Close the connection


//var_dump($response);

$phpArray = json_decode($response, true);
//$character = json_decode($data);
//print_r($phpArray);
$data=array();
foreach ($phpArray['data'] as $key => $value) {
    # code...

    //print_r($value['name']);
 $button ='<div class="btn-group">
  <button type="button" class="btn btn-info btn-circle btn-xs center-block" href="#" data-toggle="modal" data-target="#modalEditLedger" onclick="updateLedgerbyid(' . $value['id'] . ')"><i class="fa fa-edit"></i>
      </button>
&nbsp;
  <button type="button" data-target="#deleteModal" class="btn btn-danger btn-circle btn-xs center-block " 
 href="#" data-toggle="modal"  onclick="deleteUpdate(' . $value['id'] . ')"><i class="fa fa-times"></i>
      </button>

  
</div>'; 



$data['data'][]= array('name'=>$value['name'],'address'=>$value['address'],'gstin'=>$value['gstin'],'city'=>$value['city'],'statecode'=>$value['statecode'],'groupid'=>$value['groupid'],'contact'=>$value['contact'],'email'=>$value['email'],'pan'=>$value['pan'],'openbal'=>$value['openbal'],'action'=>$button);




}

echo json_encode($data);

}



public function editLedger()
{

$data_array=array();

       

if($this->input->post("recid")===null)
{
  $id = "";
}else{
  $id = $this->input->post("recid");
}


        if($this->input->post("ledgername")===null)
        { 
            $name="";
        }
        else
        {
        $name=$this->input->post("ledgername");

        }
        if($this->input->post("ledgeraddress")===null)
        {
        $address="";

        }
        else
        {
        $address=$this->input->post("ledgeraddress");

        }

        if($this->input->post("ledgergstin")===null)
        {
        $gstin="";            
        }
        else
        {
        $gstin=$this->input->post("ledgergstin");            
        }

        if($this->input->post("ledgercity")===null)
        {
        $city="";

        }
        else
        {
        $city=$this->input->post("ledgercity");            
        }

        if($this->input->post("Inventorytatecode")===null)
        {
        $statecode="";

        }
        else
        {
        $statecode=$this->input->post("Inventorytatecode");            
        }

        if($this->input->post("ledgergroupid")===null)
        {
        $groupid="";

        }
        else
        {
        $groupid=$this->input->post("ledgergroupid");            
        }

        if($this->input->post("ledgercontact")===null)
        {
        $contact="";

        }
        else
        {
        $contact=$this->input->post("ledgercontact");

        }

        if($this->input->post("ledgeremail")===null)
        {
        $email="";

        }
        else
        {
        $email=$this->input->post("ledgeremail");

        }

        if($this->input->post("ledgerpan")===null)
        {
        $pan="";

        }
        else
        {
        $pan=$this->input->post("ledgerpan");

        }

        if($this->input->post("ledgeropenbal")===null)
        {
        $openbal="";

        }
        else
        {
        $openbal=$this->input->post("ledgeropenbal");

        }

        if($this->input->post("Inventorytate")===null)
        {
        $statecode="";

        }
        else
        {
        $statecode=$this->input->post("Inventorytate");

        }


        if($this->input->post("ledgergroup")===null)
        {
        $groupid="";

        }
        else
        {
        $groupid=$this->input->post("ledgergroup");

        }

        if($this->input->post("bus_type")===null)
        {
        $bustype="";

        }
        else
        {
        $bustype=$this->input->post("bus_type");

        }

$data_array=array(
//        "id"=> $id,
        "account_name"=> $name,
        "account_address"=> $address,
        "account_gstin"=> $gstin,
        "account_city"=> $city,
        "account_statecode"=> $statecode,
        "account_groupid"=> $groupid,
        "account_contact"=> $contact,
        "account_email"=> $email,
        "account_pan"=> $pan,
        "account_groupid" =>$groupid,
        "bustype" =>$bustype,
        "account_statecode" =>$statecode,
        "account_openbal"=> $openbal);

//var_dump($data_array);
$url=$this->config->item("api_url") . "/api/ledger/" . $id;
 $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");  
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_array));
  $response = curl_exec($ch);
  //$result = json_decode($response);


  curl_close($ch); // Close the connection

//$res = json_decode($response, true);
echo $response;


}



public function addLedger()
{
$data_array=array();



        if($this->input->post("ledgername")===null)
        { 
            $name="";
        }
        else
        {
        $name=$this->input->post("ledgername");

        }
        if($this->input->post("ledgeraddress")===null)
        {
        $address="";

        }
        else
        {
        $address=$this->input->post("ledgeraddress");

        }

        if($this->input->post("ledgergstin")===null)
        {
        $gstin="";            
        }
        else
        {
        $gstin=$this->input->post("ledgergstin");            
        }

        if($this->input->post("ledgercity")===null)
        {
        $city="";

        }
        else
        {
        $city=$this->input->post("ledgercity");            
        }

        if($this->input->post("Inventorytatecode")===null)
        {
        $statecode="";

        }
        else
        {
        $statecode=$this->input->post("Inventorytatecode");            
        }

        if($this->input->post("ledgergroupid")===null)
        {
        $groupid="";

        }
        else
        {
        $groupid=$this->input->post("ledgergroupid");            
        }

        if($this->input->post("ledgercontact")===null)
        {
        $contact="";

        }
        else
        {
        $contact=$this->input->post("ledgercontact");

        }

        if($this->input->post("ledgeremail")===null)
        {
        $email="";

        }
        else
        {
        $email=$this->input->post("ledgeremail");

        }

        if($this->input->post("ledgerpan")===null)
        {
        $pan="";

        }
        else
        {
        $pan=$this->input->post("ledgerpan");

        }

        if($this->input->post("ledgeropenbal")===null)
        {
        $openbal="";

        }
        else
        {
        $openbal=$this->input->post("ledgeropenbal");

        }

        if($this->input->post("Inventorytate")===null)
        {
        $statecode="";

        }
        else
        {
        $statecode=$this->input->post("Inventorytate");

        }


        if($this->input->post("ledgergroup")===null)
        {
        $groupid="";

        }
        else
        {
        $groupid=$this->input->post("ledgergroup");

        }

        if($this->input->post("bus_type")===null)
        {
        $bustype="";

        }
        else
        {
        $bustype=$this->input->post("bus_type");

        }


$url=$this->config->item("api_url") . "/api/ledger";

$data_array=array(
        "account_name"=> $name,
        "account_address"=> $address,
        "account_gstin"=> $gstin,
        "account_city"=> $city,
        "account_statecode"=> $statecode,
        "account_groupid"=> $groupid,
        "account_contact"=> $contact,
        "account_email"=> $email,
        "account_pan"=> $pan,
        "account_groupid" =>$groupid,
        "bustype" =>$bustype,
        "account_statecode" =>$statecode,
        "account_openbal"=> $openbal);


  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");  
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_array));
  $response = curl_exec($ch);
  //$result = json_decode($response);
  curl_close($ch); // Close the connection

//$res = json_decode($response, true);
echo $response;
//print_r($data);
}

public function deleteLedger()
{
$data_array=array();
$id=$this->input->get("id");
$data_array=array("id"=>$id);
$url=$this->config->item("api_url") . "/api/ledger/" . $id;
 $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_array));
  $response = curl_exec($ch);
  //$result = json_decode($response);


  curl_close($ch); // Close the connection

//$res = json_decode($response, true);
echo $response;

//$this->callAPI('DELETE', 'https://apigstsoft.jvait.in/api/Ledger_delete.php', $id);
}





}

