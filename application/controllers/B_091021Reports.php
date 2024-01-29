<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Reports extends CI_Controller {

	public function __construct(){
        parent::__construct();
        check_login_user();
        $this->load->library('curl');
        $this->load->helper('file');
$this->load->helper('form');
    //   $this->load->model('common_model');
    //   $this->load->model('login_model');
$this->secret= $this->session->userdata('authkey');

$this->headers = array(
         
         'X-API-Key: '. $this->secret
);
    }

    public function cashbank(){
        $data = array();
        $data['page'] = 'Cash / Bank Book';
        $this->load->view('allcashbank', $data);
    }

    public function payments(){
        $data = array();
        $data['page'] = 'daybook';
        $this->load->view('alldaybook', $data);
    }
    public function purchasereg(){
        $data = array();
        $data['page'] = 'Purchase Register';
        $this->load->view('allpurchases', $data);
    }

    public function gledger(){
        $data = array();
        $data['page'] = 'General Ledger Report';
        $this->load->view('ledgerreport', $data);
    }

    public function cashbankdaybook()
    {
        $data = array();
        $data['page'] = 'Cash & Bank Daybook';
        $this->load->view('cashbank_daybook', $data);
    }

    public function gstr3b()
    {
        $data = array();
        $data['page'] = 'GSTR3B Return';
        $this->load->view('gstr3b', $data);
    }

    public function gstr3bsum()
    {
        $data = array();
        $data['page'] = 'GSTR3B Summary';
        $this->load->view('gstsummary', $data);
    }

public function trialbal()
{
  $data= array();
  $data['page'] = 'Trial Balance Report';
  $this->load->view('tb_list',$data);
}

    public function gstr2b()
    {
        $data = array();
        $data['page'] = 'GSTR2B Purchase Return';
        $this->load->view('gstr2b', $data);
    }


    public function gstr1()
    {
        $data = array();
        $data['page'] = 'GSTR1 Return';
        $this->load->view('gstr1', $data);
    }

    public function cwms()
    {
        $data = array();
        $data['page'] = 'Clientwise Monthly Sales Summary';
        $this->load->view('clientwisemsales', $data);
    }



public function gettrialbal()
{
$compId = $this->session->userdata('id');
$finyear = $this->session->userdata('finyear');


$url= $this->config->item("api_url") . "/api/reports/getTBData";
$data_post = array("finyear"=>$finyear,"compId"=>$compId);
//$post = ['batch_id'=> "2"];
//var_dump($data);  
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_post));

  $tbdatares = curl_exec($ch);
  //$result = json_decode($response);
 //echo $ledgerresponse;
//var_dump($tbdatares);
curl_close($ch); // Close the connection


//$group_data =


 // $data['data'][]=array("group"=>"ABC","name"=>"Vijay Amirtharaj","debitamt"=>123.00,"creditamt"=>245.00);
  echo $tbdatares;
}



public function cwms_report()
{
$tbl='';
$compId = $this->session->userdata('id');
  $yr=$this->input->get('fy');
  $nxt_yr=($yr+1);
  $fy=$yr . "-" . substr($nxt_yr, 2,2);
  //var_dump($fy);
$cwdata=array();
/*$url= $this->config->item("api_url") . "/api/reports/getmonthwiseclientcode";
$data = array("trans_type"=>"SALE","finyear"=>$fy,"compId"=>$compId);
//$post = ['batch_id'=> "2"];
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

  $cwsresponse = curl_exec($ch);
  //$result = json_decode($response);
 //echo $ledgerresponse;
//var_dump($cwsresponse);
curl_close($ch); // Close the connection
$cwsmaindata = json_decode($cwsresponse,true);
//if($cwsmaindata)
//{

//foreach ($cwsmaindata as $key => $value) {
*/
$compId = $this->session->userdata('id');
  $yr=$this->input->get('fy');
  $nxt_yr=($yr+1);
  $fy=$yr . "-" . substr($nxt_yr, 2,2);
  //$acctid=$value['db_account'];
  //var_dump($fy);
$url= $this->config->item("api_url") . "/api/reports/getmonthwiseclientdata";
$data_post = array("trans_type"=>"SALE","finyear"=>$fy,"compId"=>$compId);
//$post = ['batch_id'=> "2"];
//var_dump($data);  
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_post));

  $cwsdatares = curl_exec($ch);
  //$result = json_decode($response);
 //echo $ledgerresponse;
//var_dump($cwsdatares);
curl_close($ch); // Close the connection


$cwdata=json_decode($cwsdatares,true);
//var_dump($cwdata);
  # code...


//}

//}
 $tot=0;
  $apr=0;
  $may=0;
  $jun=0;
  $jul=0;
  $aug=0;
  $sep=0;
  $oct=0;
  $nov=0;
  $dec=0;
  $jan=0;
  $feb=0;
  $mar=0;
  $gst=0;
  $apr_tot=0;
  $may_tot=0;
  $jun_tot=0;
  $jul_tot=0;
  $aug_tot=0;
  $sep_tot=0;
  $oct_tot=0;
  $nov_tot=0;
  $dec_tot=0;
  $jan_tot=0;
  $feb_tot=0;
  $mar_tot=0;
  $gst_tot=0;
  $os_amt=0;
  $os_tot=0;

// var_dump($cwdata);
foreach ($cwdata as $key => $value) {
  # code...
  //var_dump($value);
    $apr=$value['apr'];
    $may=$value['may'];
    $jun=$value['jun'];
    $jul=$value['jul'];
    $aug=$value['aug'];
    $sep=$value['sep'];
    $oct=$value['oct'];
    $nov=$value['nov'];
    $dec=$value['dec'];
    $jan=$value['jan'];
    $feb=$value['feb'];
    $mar=$value['mar'];
    $gst=$value['gst'];
    $os_amt=$value['outstand'];

    $tot= $tot+$apr+$may+$jun+$jul+$aug+$sep+$oct+$nov+$dec+$jan+$feb+$mar+$gst;
$apr_tot=$apr_tot+$apr;
$may_tot=$may_tot+$may;
$jun_tot=$jun_tot+$jun;
$jul_tot=$jul_tot+$jul;
$aug_tot=$aug_tot+$aug;
$sep_tot=$sep_tot+$sep;
$oct_tot=$oct_tot+$oct;
$nov_tot=$nov_tot+$nov;
$dec_tot=$dec_tot+$dec;
$jan_tot=$jan_tot+$jan;
$feb_tot=$feb_tot+$feb;
$mar_tot=$mar_tot+$mar;
$gst_tot=$gst_tot+$gst;
$os_tot=$os_tot+$os_amt;

//var_dump($nov);
if($apr>0)
{
    $apr=number_format($value['apr'], 2, '.', '');
}
else
{
  $apr="";
}
if($may>0)
{

    $may=number_format($value['may'], 2, '.', '');
  }
  else{
    $may ="";
  }
if($jun>0)
{

    $jun=number_format($value['jun'], 2, '.', '');
  }
else{
  $jun="";
}
if($jul>0)
{

    $jul=number_format($value['jul'], 2, '.', '');
  }
  else
  {
    $jul="";
  }
  if($aug>0)
{

    $aug=number_format($value['aug'], 2, '.', '');
  }
  else {
   $aug="";
  }
if($sep>0)
{

    $sep=number_format($value['sep'], 2, '.', '');
  }
  else {
    $sep="";
  }
if($oct>0)
{

    $oct=number_format($value['oct'], 2, '.', '');
  }
  else {
    $oct="";
  }
if($nov>0)
{

    $nov=number_format($value['nov'], 2, '.', '');
  }
  else
  {
    $nov="";
  }
  if($dec>0)
{

    $dec=number_format($value['dec'], 2, '.', '');
  } 
  else {
    $dec="";
  }
  if($apr>0)
{

    $jan=number_format($value['jan'], 2, '.', '');
}
else {
  $jan="";
}
if($feb>0)
{

    $feb=number_format($value['feb'], 2, '.', '');
  }
  else {
    $feb="";
  }
  if($apr>0)
{

    $mar=number_format($value['mar'], 2, '.', '');
  }
  else {
    $mar="";
  }

  if($gst>0)
{

    $gst=number_format($value['gst'], 2, '.', '');
  }
  else {
    $gst="";
  }


$tbl .='<tr><td class="extcol" width="400px">'. $value["account_name"] .'</td><td style="text-align:right;">'. $apr .'</td><td style="text-align:right;">'. $may .'</td><td style="text-align:right;">'. $jun .'</td><td style="text-align:right;">'. $jul .'</td><td style="text-align:right;">'. $aug .'</td><td style="text-align:right;">'. $sep .'</td><td style="text-align:right;">'. $oct .'</td><td style="text-align:right;">'. $nov .'</td><td style="text-align:right;">'. $dec .'</td><td style="text-align:right;">'. $jan .'</td><td style="text-align:right;">'. $feb .'</td><td style="text-align:right;">'. $mar .'</td><td style="text-align:right;">'. $gst .'</td><td style="text-align:right;font-weight:bold;">'. number_format($tot, 2, '.', '') .'</td><td style="text-align:right;font-weight:bold;">'. number_format($os_amt,2,'.','') .'</td></tr>';
$tot=0;
}

$nettot= $apr_tot+$may_tot+$jun_tot+$jul_tot+$aug_tot+$sep_tot+$oct_tot+$nov_tot+$dec_tot+$jan_tot+$feb_tot+$mar_tot+$gst_tot;

if($apr_tot>0)
{
    $apr_tot=number_format($apr_tot, 2, '.', '');
}
else
{
  $apr_tot="";
}
if($may_tot>0)
{

    $may_tot=number_format($may_tot, 2, '.', '');
  }
  else{
    $may_tot="";
  }
if($jun_tot>0)
{

    $jun_tot=number_format($jun_tot, 2, '.', '');
  }
else{
  $jun_tot="";
}
if($jul_tot>0)
{

    $jul_tot=number_format($jul_tot, 2, '.', '');
  }
  else
  {
    $jul_tot="";
  }
  if($aug_tot>0)
{

    $aug_tot=number_format($aug_tot, 2, '.', '');
  }
  else {
   $aug_tot="";
  }
if($sep_tot>0)
{

    $sep_tot=number_format($sep_tot, 2, '.', '');
  }
  else {
    $sep_tot="";
  }
if($oct_tot>0)
{

    $oct_tot=number_format($oct_tot, 2, '.', '');
  }
  else {
    $oct_tot="";
  }
if($nov_tot>0)
{

    $nov_tot=number_format($nov_tot, 2, '.', '');
  }
  else
  {
    $nov_tot="";
  }
  if($dec_tot>0)
{

    $dec_tot=number_format($dec_tot, 2, '.', '');
  } 
  else {
    $dec_tot="";
  }
  if($apr_tot>0)
{

    $jan_tot=number_format($jan_tot, 2, '.', '');
}
else {
  $jan_tot="";
}
if($feb_tot>0)
{

    $feb_tot=number_format($feb_tot, 2, '.', '');
  }
  else {
    $feb_tot="";
  }
  if($mar_tot>0)
{

    $mar_tot=number_format($mar_tot, 2, '.', '');
  }
  else {
    $mar_tot="";
  }

  if($gst_tot>0)
{

    $gst_tot=number_format($gst_tot, 2, '.', '');
  }
  else {
    $gst_tot="";
  }


  if($os_tot>0)
{

    $os_tot=number_format($os_tot, 2, '.', '');
  }
  else {
    $os_tot=0;
  }

$tbl .='<tr><td style="font-weight:bold;">TOTAL</td><td style="text-align:right;font-weight:bold;">'. $apr_tot .'</td><td style="text-align:right;font-weight:bold;">'. $may_tot .'</td><td style="text-align:right;font-weight:bold;">'. $jun_tot .'</td><td style="text-align:right;font-weight:bold;">'. $jul_tot .'</td><td style="text-align:right;font-weight:bold;">'. $aug_tot .'</td><td style="text-align:right;font-weight:bold;">'. $sep_tot .'</td><td style="text-align:right;font-weight:bold;">'. $oct_tot .'</td><td style="text-align:right;font-weight:bold;">'. $nov_tot .'</td><td style="text-align:right;font-weight:bold;">'. $dec_tot .'</td><td style="text-align:right;font-weight:bold;">'. $jan_tot .'</td><td style="text-align:right;font-weight:bold;">'. $feb_tot .'</td><td style="text-align:right;font-weight:bold;">'. $mar_tot .'</td><td style="text-align:right;font-weight:bold;">'. $gst_tot .'</td><td style="text-align:right;font-weight:bold;">'. number_format($nettot,2,'.','') .'</td><td style="text-align:right;font-weight:bold;">'. number_format($os_tot,2,'.','') .'</td></tr>';

echo $tbl;

}


public function gstr1b2bJson()
{
$flag = $this->input->get('flag');
$fdate=$this->input->get('fdate');

if($flag=="M")
{
$fdt="01-" . $this->input->get('fdate');

$fdate = date("Y-m-d",strtotime($fdt));
$tdate = date("Y-m-t",strtotime($fdt));
$compId = $this->session->userdata('id');
//var_dump($fdate . $tdate);
}
if($flag=="Q")
{
$dt=$this->input->get('fdate');
$finyear = explode("-", $this->session->userdata('finyear'));
$exp_mn=explode("-", $this->input->get('fdate')); 

if($dt=="04-06")
{
$fdt ="01-" . $exp_mn[0] . "-". $finyear[0];
$edt = "01-" . $exp_mn[1] . "-". $finyear[0];
}
if($dt=="07-09")
{
$fdt ="01-" . $exp_mn[0] . "-". $finyear[0];
$edt = "01-" . $exp_mn[1] . "-". $finyear[0];
}
if($dt=="10-12")
{
$fdt ="01-" . $exp_mn[0] . "-" . $finyear[0];
$edt = "01-" . $exp_mn[1] . "-" . $finyear[0];
}

if($dt=="01-03")
{
$fdt ="01-" . $exp_mn[0] . "-". $finyear[1];
$edt = "01-" . $exp_mn[1] . "-". $finyear[1];
}
//var_dump($fdt . $edt);
//$fdt="01-" . $this->input->get('fdate');
$fdate = date("Y-m-d",strtotime($fdt));
$tdate = date("Y-m-t",strtotime($edt));

}


$item_cess="0";
$item_igst="0";
$item_cgst="0";
$item_sgst="0";
$rcm="N";
$arrmerge1=array();
$retmon= date("mY",strtotime($tdate));
$compId = $this->session->userdata('id');
$compGstin = $this->session->userdata('gstin');
$compStatecode = $this->session->userdata('cstatecode');
$isecomm = $this->session->userdata('ecomm');
    //$isecomm = $comvalue['ecomm'];
if($isecomm==0) {
  $ec="OE";
}

$data = array();
$itms = array();
$inv = array();
$finalmerge=array();
$gst = array();

//$url= $this->config->item("api_url") . "/api/getgstindata.php";
$url=$this->config->item("api_url") . "/api/reports/getGstJson";

$data_post = array("fdate"=>$fdate,"tdate"=>$tdate,"compId"=>$compId,"compStatecode"=>$compStatecode,"compGstin"=>$compGstin,"retmon"=>$retmon,"rcm"=>$rcm,"ec"=>$ec);
//var_dump($data_post);
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);

  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_post));

  $gstinresponse = curl_exec($ch);
  //$result = json_decode($response);
 //echo $ledgerresponse;
//var_dump($gstinresponse);
curl_close($ch); // Close the connection
$b2bgstinData = json_decode($gstinresponse,true);
//echo json_encode($gstinresponse);
echo $gstinresponse;



}




public function Old_gstr1b2bJson()
{
$flag = $this->input->get('flag');
$fdate=$this->input->get('fdate');

if($flag=="M")
{
$fdt="01-" . $this->input->get('fdate');

$fdate = date("Y-m-d",strtotime($fdt));
$tdate = date("Y-m-t",strtotime($fdt));
$compId = $this->session->userdata('id');
//var_dump($fdate . $tdate);
}
if($flag=="Q")
{
$dt=$this->input->get('fdate');
$finyear = explode("-", $this->session->userdata('finyear'));
$exp_mn=explode("-", $this->input->get('fdate')); 

if($dt=="04-06")
{
$fdt ="01-" . $exp_mn[0] . "-". $finyear[0];
$edt = "01-" . $exp_mn[1] . "-". $finyear[0];
}
if($dt=="07-09")
{
$fdt ="01-" . $exp_mn[0] . "-". $finyear[0];
$edt = "01-" . $exp_mn[1] . "-". $finyear[0];
}
if($dt=="10-12")
{
$fdt ="01-" . $exp_mn[0] . "-" . $finyear[0];
$edt = "01-" . $exp_mn[1] . "-" . $finyear[0];
}

if($dt=="01-03")
{
$fdt ="01-" . $exp_mn[0] . "-". $finyear[1];
$edt = "01-" . $exp_mn[1] . "-". $finyear[1];
}
//var_dump($fdt . $edt);
//$fdt="01-" . $this->input->get('fdate');
$fdate = date("Y-m-d",strtotime($fdt));
$tdate = date("Y-m-t",strtotime($edt));
$compId = $this->session->userdata('id');

}




/*
$fdate = $this->input->get('fdate');
$tdate = $this->input->get('tdate');
*/
$item_cess="0";
$item_igst="0";
$item_cgst="0";
$item_sgst="0";
$rcm="N";
$arrmerge1=array();
$retmon= date("mY",strtotime($tdate));
/*
$comdetails= $this->session->userdata('compdetails');

foreach ($comdetails as $key => $comvalue) {
    # code...
  //  print_r($comvalue);
    $compId = $comvalue['cid'];
    $compGstin = $comvalue['cgstin'];
    $compStatecode = $comvalue['compstatecode'];
    $isecomm = $comvalue['ecomm'];
 //   print_r($comid);
}
if($isecomm==0) {
  $ec="OE";
}

*/
$compId = $this->session->userdata('id');
$compGstin = $this->session->userdata('gstin');
$compStatecode = $this->session->userdata('cstatecode');
    //$isecomm = $comvalue['ecomm'];

$data = array();
$itms = array();
$inv = array();
$finalmerge=array();
$gst = array();

$url= $this->config->item("api_url") . "/api/getgstindata.php";
$data_post = array("fdate"=>$fdate,"tdate"=>$tdate,"compId"=>$compId);

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_post));

  $gstinresponse = curl_exec($ch);
  //$result = json_decode($response);
 //echo $ledgerresponse;
//var_dump($gstr1response);
curl_close($ch); // Close the connection
$b2bgstinData = json_decode($gstinresponse,true);
//echo $gstr1response;


///$b2bInvoiceData = $this->common_model->getInvData($fdate,$tdate,$compId);
//print_r($b2bInvoiceData);
foreach ($b2bgstinData as $key => $invvalue) 
{

$gstno = $invvalue['gstin'];  
//$invno = $invvalue['invoice_no'];
$rw=1;





$url= $this->config->item("api_url") . "/api/getgstinvdata.php";
$data_post = array("fdate"=>$fdate,"tdate"=>$tdate,"compId"=>$compId,"gstin"=>$gstno);

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_post));

  $gstinvresponse = curl_exec($ch);
  //$result = json_decode($response);
 //echo $ledgerresponse;
//var_dump($gstinvresponse);
curl_close($ch); // Close the connection
$b2bgstinvData = json_decode($gstinvresponse,true);
//echo $gstr1response;



//$b2bInvoicegstinData=$this->common_model->getInvgstdatajson($gstno,$fdate,$tdate,$compId);

//$inv=array();
//print_r($b2bInvoicegstinData);
//print_r('qry' . $rw);
//var_dump($b2bInvoicegstinData);
foreach ($b2bgstinvData as $key => $gstvalue) {
$invNo=$gstvalue['trans_id'];
//print_r($invNo);

$inv_amt=$gstvalue['inv_amt'];


$url= $this->config->item("api_url") . "/api/getinvjsondata.php";
$data_post = array("fdate"=>$fdate,"tdate"=>$tdate,"compId"=>$compId,"gstin"=>$gstno,"trans_id"=>$invNo);

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_post));

  $gstinv_response = curl_exec($ch);
  //$result = json_decode($response);
 //echo $ledgerresponse;
//var_dump($gstinv_response);
curl_close($ch); // Close the connection
$b2bData = json_decode($gstinv_response,true);


//$b2bData=$this->common_model->getB2BJson($fdate,$tdate,$compId,$gstno,$invNo);
//print_r($b2bData);
$itms=array();
foreach ($b2bData as $key => $b2bvalue)
{
if($invNo==$b2bvalue['trans_id'])
{
  
if($compStatecode==$b2bvalue['pos'])
{
$itms[]=array('num'=>$b2bvalue['gst_pc'].'01',
    'itm_det' => array('txval'=>$b2bvalue['taxable_amt'],
      'rt' =>$b2bvalue['gst_pc'],
      'camt'=>number_format((float)$b2bvalue['item_cgst'],2,'.',''),
      'samt'=>number_format((float)$b2bvalue['item_sgst'],2,'.',''),
      'csamt'=>number_format((float)$b2bvalue['item_cess'],2,'.','')
  ),);

}

else {

$itms[]=array('num'=>$b2bvalue['gst_pc'].'01',
    'itm_det' => array('txval'=>$b2bvalue['taxable_amt'],
      'rt' =>$b2bvalue['gst_pc'],
      'iamt'=>number_format((float)$b2bvalue['item_igst'],2,'.',''),
      'csamt'=>number_format((float)$b2bvalue['item_cess'],2,'.','')
  ),);

}
}
  
} //b2bvalue


$invdate =date("d-m-Y", strtotime($gstvalue['trans_date']));

    $inv['inv'][]= array('inum' => $gstvalue['trans_id'],
    'idt'=>$invdate,
    
    'val'=>number_format((float)$b2bvalue['inv_amt'],2,'.',''),
    'pos' =>"'" . substr($invvalue['gstin'],0,2) ."'", // $gstvalue['placeofsupply'] ."'",
    'rchrg' => $rcm,
    'inv_typ' => 'R','itms'=>$itms
 
);
  
//print_r($inv);


} //gstvalue

$arrmerge1[]= array_merge(array('ctin' => $invvalue['gstin']),$inv);

$inv = array();
$itms = array();

} //invvalue


$data['b2b']=$arrmerge1;
$arrmerge1=array();
$finalmerge = array_merge(array('gstin'=>$compGstin,'fp'=>"'". $retmon,'version'=>"GST2.4.0",'hash'=>"hash"),$data);

echo json_encode($finalmerge,JSON_PRETTY_PRINT);
/*
$output = json_encode($finalmerge,JSON_NUMERIC_CHECK | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
  $outp = str_replace("'", "", $output);
  echo $outp;

*/

}




public function fetch_gstr1b2b()
{
$flag = $this->input->get('flag');
$fdate=$this->input->get('fdate');

if($flag=="M")
{
$fdt="01-" . $this->input->get('fdate');

$fdate = date("Y-m-d",strtotime($fdt));
$tdate = date("Y-m-t",strtotime($fdt));
$compId = $this->session->userdata('id');
//var_dump($fdate . $tdate);
}
if($flag=="Q")
{
$dt=$this->input->get('fdate');
$finyear = explode("-", $this->session->userdata('finyear'));
$exp_mn=explode("-", $this->input->get('fdate')); 

if($dt=="04-06")
{
$fdt ="01-" . $exp_mn[0] . "-". $finyear[0];
$edt = "01-" . $exp_mn[1] . "-". $finyear[0];
}
if($dt=="07-09")
{
$fdt ="01-" . $exp_mn[0] . "-". $finyear[0];
$edt = "01-" . $exp_mn[1] . "-". $finyear[0];
}
if($dt=="10-12")
{
$fdt ="01-" . $exp_mn[0] . "-" . $finyear[0];
$edt = "01-" . $exp_mn[1] . "-" . $finyear[0];
}
if($dt=="01-03")
{
$fdt ="01-" . $exp_mn[0] . "-". substr($finyear[0], 0,2) . $finyear[1];
$edt = "01-" . $exp_mn[1] . "-". substr($finyear[0], 0,2) .$finyear[1];
}

//var_dump($fdt . $edt);
//$fdt="01-" . $this->input->get('fdate');
$fdate = date("Y-m-d",strtotime($fdt));
$tdate = date("Y-m-t",strtotime($edt));
$compId = $this->session->userdata('id');

}

//$url= $this->config->item("api_url") . "/api/getgstr1data.php";
$url= $this->config->item("api_url") . "/api/reports/getgstr1data";
$data_post = array("type"=>"B2B","fdate"=>$fdate,"tdate"=>$tdate,"compId"=>$compId,"gtype"=>"b2b");

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_post));

  $gstr1response = curl_exec($ch);
  //$result = json_decode($response);
 //echo $ledgerresponse;
//var_dump($gstr1response);
curl_close($ch); // Close the connection
$gst1maindata = json_decode($gstr1response,true);
echo $gstr1response;




}


public function fetch_gstr12hsnsac()
{
$flag = $this->input->get('flag');
$fdate=$this->input->get('fdate');

if($flag=="M")
{
$fdt="01-" . $this->input->get('fdate');

$fdate = date("Y-m-d",strtotime($fdt));
$tdate = date("Y-m-t",strtotime($fdt));
$compId = $this->session->userdata('id');
//var_dump($fdate . $tdate);
}
if($flag=="Q")
{
$dt=$this->input->get('fdate');
$finyear = explode("-", $this->session->userdata('finyear'));
$exp_mn=explode("-", $this->input->get('fdate')); 

if($dt=="04-06")
{
$fdt ="01-" . $exp_mn[0] . "-". $finyear[0];
$edt = "01-" . $exp_mn[1] . "-". $finyear[0];
}
if($dt=="07-09")
{
$fdt ="01-" . $exp_mn[0] . "-". $finyear[0];
$edt = "01-" . $exp_mn[1] . "-". $finyear[0];
}
if($dt=="10-12")
{
$fdt ="01-" . $exp_mn[0] . "-" . $finyear[0];
$edt = "01-" . $exp_mn[1] . "-" . $finyear[0];
}

if($dt=="01-03")
{
$fdt ="01-" . $exp_mn[0] . "-". $finyear[1];
$edt = "01-" . $exp_mn[1] . "-". $finyear[1];
}
//var_dump($fdt . $edt);
//$fdt="01-" . $this->input->get('fdate');
$fdate = date("Y-m-d",strtotime($fdt));
$tdate = date("Y-m-t",strtotime($edt));
$compId = $this->session->userdata('id');

}

$url= $this->config->item("api_url") . "/api/reports/getgstr1hsndata";
//$url= $this->config->item("api_url") . "/api/getgstr1data.php";
$data_post = array("type"=>"SALE","fdate"=>$fdate,"tdate"=>$tdate,"compId"=>$compId);

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_post));

  $gstr1response = curl_exec($ch);
  //$result = json_decode($response);
 //echo $ledgerresponse;
//var_dump($gstr1response);
curl_close($ch); // Close the connection
$gst1maindata = json_decode($gstr1response,true);
echo $gstr1response;

}



public function fetch_gstr1b2c()
{
$flag = $this->input->get('flag');
$fdate=$this->input->get('fdate');

if($flag=="M")
{
$fdt="01-" . $this->input->get('fdate');

$fdate = date("Y-m-d",strtotime($fdt));
$tdate = date("Y-m-t",strtotime($fdt));
$compId = $this->session->userdata('id');
//var_dump($fdate . $tdate);
}
if($flag=="Q")
{
$dt=$this->input->get('fdate');
$finyear = explode("-", $this->session->userdata('finyear'));
$exp_mn=explode("-", $this->input->get('fdate')); 

if($dt=="04-06")
{
$fdt ="01-" . $exp_mn[0] . "-". $finyear[0];
$edt = "01-" . $exp_mn[1] . "-". $finyear[0];
}
if($dt=="07-09")
{
$fdt ="01-" . $exp_mn[0] . "-". $finyear[0];
$edt = "01-" . $exp_mn[1] . "-". $finyear[0];
}
if($dt=="10-12")
{
$fdt ="01-" . $exp_mn[0] . "-" . $finyear[0];
$edt = "01-" . $exp_mn[1] . "-" . $finyear[0];
}

if($dt=="01-03")
{
$fdt ="01-" . $exp_mn[0] . "-". $finyear[1];
$edt = "01-" . $exp_mn[1] . "-". $finyear[1];
}
//var_dump($fdt . $edt);
//$fdt="01-" . $this->input->get('fdate');
$fdate = date("Y-m-d",strtotime($fdt));
$tdate = date("Y-m-t",strtotime($edt));
$compId = $this->session->userdata('id');

}

$url= $this->config->item("api_url") . "/api/reports/getgstr1data";
//$url= $this->config->item("api_url") . "/api/getgstr1data.php";
$data_post = array("type"=>"B2C","fdate"=>$fdate,"tdate"=>$tdate,"compId"=>$compId,"gtype"=>"b2c");

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_post));

  $gstr1response = curl_exec($ch);
  //$result = json_decode($response);
 //echo $ledgerresponse;
//var_dump($gstr1response);
curl_close($ch); // Close the connection
$gst1maindata = json_decode($gstr1response,true);
echo $gstr1response;

}


public function fetch_gstr3b5()
{

$flag = $this->input->get('flag');
$fdate=$this->input->get('fdate');

if($flag=="M")
{
$fdt="01-" . $this->input->get('fdate');

$fdate = date("Y-m-d",strtotime($fdt));
$tdate = date("Y-m-t",strtotime($fdt));
$compId = $this->session->userdata('id');
//var_dump($fdate . $tdate);
}

if($flag=="Q")
{
$dt=$this->input->get('fdate');
$finyear = explode("-", $this->session->userdata('finyear'));
$exp_mn=explode("-", $this->input->get('fdate')); 

if($dt=="04-06")
{
$fdt ="01-" . $exp_mn[0] . "-". $finyear[0];
$edt = "01-" . $exp_mn[1] . "-". $finyear[0];
}
if($dt=="07-09")
{
$fdt ="01-" . $exp_mn[0] . "-". $finyear[0];
$edt = "01-" . $exp_mn[1] . "-". $finyear[0];
}
if($dt=="10-12")
{
$fdt ="01-" . $exp_mn[0] . "-" . $finyear[0];
$edt = "01-" . $exp_mn[1] . "-" . $finyear[0];
}

if($dt=="01-03")
{
$fdt ="01-" . $exp_mn[0] . "-". substr($finyear[0],0,2) . $finyear[1];
$edt = "01-" . $exp_mn[1] . "-". substr($finyear[0],0,2) . $finyear[1];
}
//var_dump($fdt . $edt);
//$fdt="01-" . $this->input->get('fdate');
$fdate = date("Y-m-d",strtotime($fdt));
$tdate = date("Y-m-t",strtotime($edt));
//var_dump($fdt);
}


  
/*
$fdt="01-" . $this->input->get('fdate');
$fdate = date("Y-m-d",strtotime($fdt));
$tdate = date("Y-m-t",strtotime($fdt));
*/
$compId = $this->session->userdata('id');

$url= $this->config->item("api_url") . "/api/reports/getgstr3b5data";
$data = array("trans_type"=>"PURC","fdate"=>$fdate,"tdate"=>$tdate,"compId"=>$compId);
//$post = ['batch_id'=> "2"];
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

  $gstr3b5itcresponse = curl_exec($ch);
  //$result = json_decode($response);
 //echo $ledgerresponse;
//var_dump($gstr3b5itcresponse);
curl_close($ch); // Close the connection
$gsitcmaindata = json_decode($gstr3b5itcresponse,true);



if($gsitcmaindata)
{


  $tbl='';
  $tbl ='<table class="table table-bordered" id="gstr3bitclistTable" width="100%" cellspacing="0">

                  <thead>
                    <tr>
                      
                      <th>Inter-state supplies</th>
                      <th>Intra-state supplies</th>
                  </tr>
                  </thead>
                  <tbody>';


$tbl .= '<tr><td style="text-align:right;">'.  $gsitcmaindata['intra_zero']  .'</td><td style="text-align:right;">'.  $gsitcmaindata['inter_zero']  .'</td></tr>';


echo $tbl;
}  
}



public function fetch_gstr34b()
{

$flag = $this->input->get('flag');
$fdate=$this->input->get('fdate');

if($flag=="M")
{
$fdt="01-" . $this->input->get('fdate');

$fdate = date("Y-m-d",strtotime($fdt));
$tdate = date("Y-m-t",strtotime($fdt));
$compId = $this->session->userdata('id');
//var_dump($fdate . $tdate);
}

if($flag=="Q")
{
$dt=$this->input->get('fdate');
$finyear = explode("-", $this->session->userdata('finyear'));
$exp_mn=explode("-", $this->input->get('fdate')); 

if($dt=="04-06")
{
$fdt ="01-" . $exp_mn[0] . "-". $finyear[0];
$edt = "01-" . $exp_mn[1] . "-". $finyear[0];
}
if($dt=="07-09")
{
$fdt ="01-" . $exp_mn[0] . "-". $finyear[0];
$edt = "01-" . $exp_mn[1] . "-". $finyear[0];
}
if($dt=="10-12")
{
$fdt ="01-" . $exp_mn[0] . "-" . $finyear[0];
$edt = "01-" . $exp_mn[1] . "-" . $finyear[0];
}

if($dt=="01-03")
{
$fdt ="01-" . $exp_mn[0] . "-". substr($finyear[0],0,2) . $finyear[1];
$edt = "01-" . $exp_mn[1] . "-". substr($finyear[0],0,2) . $finyear[1];
}
//var_dump($fdt . $edt);
//$fdt="01-" . $this->input->get('fdate');
$fdate = date("Y-m-d",strtotime($fdt));
$tdate = date("Y-m-t",strtotime($edt));
//var_dump($fdt);
}


/*
$fdt="01-" . $this->input->get('fdate');
$fdate = date("Y-m-d",strtotime($fdt));
$tdate = date("Y-m-t",strtotime($fdt));*/
$compId = $this->session->userdata('id');

$url= $this->config->item("api_url") . "/api/reports/getgstr3bdata";
//$data = array("trans_type"=>"SALE","fdate"=>$fdate,"tdate"=>$tdate,"compId"=>$compId);

//$url= $this->config->item("api_url") . "/api/reports/getgstr34bdata.php";
$data = array("trans_type"=>"PURC","fdate"=>$fdate,"tdate"=>$tdate,"compId"=>$compId);
//$post = ['batch_id'=> "2"];
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

  $gstr3bitcresponse = curl_exec($ch);
  //$result = json_decode($response);
 //echo $ledgerresponse;
//var_dump($gstr3bitcresponse);
curl_close($ch); // Close the connection
$gsitcmaindata = json_decode($gstr3bitcresponse,true);



if($gsitcmaindata)
{


  $tbl='';
  $tbl ='<table class="table table-bordered" id="gstr3bitclistTable" width="100%" cellspacing="0">

                  <thead>
                    <tr>
                      
                      <th>Details</th>
                      <th>Integrated Tax</th>
                      <th>Central Tax</th>
                      <th>State/UT Tax</th>
                      <th>Cess</th>
                  </tr>
                  </thead>
                  <tbody>';

$tbl .= '<tr><td style="font-weight:bold;">(A) ITC Available (whether in full or part)</td><td colspan="4"></td></tr>';

$tbl .= '<tr><td>(1) Import of goods</td><td></td><td></td><td></td><td></td></tr>';

$tbl .= '<tr><td>(2) Import of services</td><td></td><td></td><td></td><td></td></tr>';


$tbl .= '<tr><td>(3) Inward supplies liable to reverse charge(other than1 & 2 above)</td><td></td><td></td><td></td><td></td></tr>';


$tbl .= '<tr><td>(4) Inward supplies from ISD</td><td></td><td></td><td></td><td></td></tr>';


$tbl .= '<tr><td>(5) All other ITC</td><td style="text-align:right;">'.  $gsitcmaindata['igst_amt']  .'</td><td style="text-align:right;">'.  $gsitcmaindata['cgst_amt']  .'</td><td style="text-align:right;">'.  $gsitcmaindata['sgst_amt']  .'</td><td></td></tr>';


$tbl .= '<tr><td style="font-weight:bold;">(B) ITC Reversed</td><td></td><td></td><td></td><td></td></tr>';


$tbl .= '<tr><td>(1) As per Rule 42 & 43 of CGST/SGST rules</td><td></td><td></td><td></td><td></td></tr>';

$tbl .= '<tr><td>(2) Others</td><td></td><td></td><td></td><td></td></tr>';


$tbl .= '<tr><td style="font-weight:bold;">(C) Net ITC Available (A)-(B)</td><td style="font-weight:bold;text-align:right;">'.  $gsitcmaindata['igst_amt']  .'</td><td style="font-weight:bold;text-align:right;">'.  $gsitcmaindata['cgst_amt']  .'</td><td style="font-weight:bold;text-align:right;">'.  $gsitcmaindata['sgst_amt']  .'</td><td></td></tr>';


$tbl .= '<tr><td style="font-weight:bold;">(D) Ineligible ITC</td><td></td><td></td><td></td><td></td></tr>';



$tbl .= '<tr><td>(1) As per Rule 17(5)</td><td></td><td></td><td></td><td></td></tr>';


$tbl .= '<tr><td>(2) Others</td><td></td><td></td><td></td><td></td></tr>';

echo $tbl;
}
}



public function fetch_gstr32b()
{

$flag = $this->input->get('flag');
$fdate=$this->input->get('fdate');

if($flag=="M")
{
$fdt="01-" . $this->input->get('fdate');

$fdate = date("Y-m-d",strtotime($fdt));
$tdate = date("Y-m-t",strtotime($fdt));
$compId = $this->session->userdata('id');
//var_dump($fdate . $tdate);
}

if($flag=="Q")
{
$dt=$this->input->get('fdate');
$finyear = explode("-", $this->session->userdata('finyear'));
$exp_mn=explode("-", $this->input->get('fdate')); 

if($dt=="04-06")
{
$fdt ="01-" . $exp_mn[0] . "-". $finyear[0];
$edt = "01-" . $exp_mn[1] . "-". $finyear[0];
}
if($dt=="07-09")
{
$fdt ="01-" . $exp_mn[0] . "-". $finyear[0];
$edt = "01-" . $exp_mn[1] . "-". $finyear[0];
}
if($dt=="10-12")
{
$fdt ="01-" . $exp_mn[0] . "-" . $finyear[0];
$edt = "01-" . $exp_mn[1] . "-" . $finyear[0];
}

if($dt=="01-03")
{
$fdt ="01-" . $exp_mn[0] . "-". substr($finyear[0],0,2) . $finyear[1];
$edt = "01-" . $exp_mn[1] . "-". substr($finyear[0],0,2) . $finyear[1];
}
//var_dump($fdt . $edt);
//$fdt="01-" . $this->input->get('fdate');
$fdate = date("Y-m-d",strtotime($fdt));
$tdate = date("Y-m-t",strtotime($edt));
//var_dump($fdt);
}



/*
$fdt="01-" . $this->input->get('fdate');
$fdate = date("Y-m-d",strtotime($fdt));
$tdate = date("Y-m-t",strtotime($fdt));*/
$compId = $this->session->userdata('id');
$cstatecode = $this->session->userdata('cstatecode');
$url= $this->config->item("api_url") . "/api/reports/getgstr32bdata";
//$url= $this->config->item("api_url") . "/api/getgstr32bdata.php";
$data = array("fdate"=>$fdate,"tdate"=>$tdate,"compId"=>$compId,"cstatecode"=>$cstatecode);
//$post = ['batch_id'=> "2"];
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

  $gstr32bresponse = curl_exec($ch);
  //$result = json_decode($response);
 //echo $ledgerresponse;
//var_dump($gstr32bresponse);
curl_close($ch); // Close the connection
$gs32maindata = json_decode($gstr32bresponse,true);
if($gs32maindata)
{


  $tbl='';
  $tbl ='<table class="table table-bordered" id="gstr32blistTable" width="100%" cellspacing="0">

                  <thead>
                    <tr>
                      
                      <th>Plase of Supply(State/UT)</th>
                      <th>Total Taxable value</th>
                      <th>Amount Integrated Tax</th>
                  </tr>
                  </thead>
                  <tbody>';
foreach ($gs32maindata as $key => $gvalue) {
  # code...
$tbl .='<tr><td style="text-align:left;">'. $gvalue["statecode"] .'</td><td style="text-align:right;">'. $gvalue['txbamt'] .'</td><td style="text-align:right;">'. $gvalue['igstamt'] .'</td></tr>';
}

echo $tbl;
}
}

public function fetch_gstr2b()
{
$flag = $this->input->get('flag');
$fdate=$this->input->get('fdate');

if($flag=="M")
{
$fdt="01-" . $this->input->get('fdate');

$fdate = date("Y-m-d",strtotime($fdt));
$tdate = date("Y-m-t",strtotime($fdt));
$compId = $this->session->userdata('id');
//var_dump($fdate . $tdate);
}
if($flag=="Q")
{
$dt=$this->input->get('fdate');
$finyear = explode("-", $this->session->userdata('finyear'));
$exp_mn=explode("-", $this->input->get('fdate')); 

if($dt=="04-06")
{
$fdt ="01-" . $exp_mn[0] . "-". $finyear[0];
$edt = "01-" . $exp_mn[1] . "-". $finyear[0];
}
if($dt=="07-09")
{
$fdt ="01-" . $exp_mn[0] . "-". $finyear[0];
$edt = "01-" . $exp_mn[1] . "-". $finyear[0];
}
if($dt=="10-12")
{
$fdt ="01-" . $exp_mn[0] . "-" . $finyear[0];
$edt = "01-" . $exp_mn[1] . "-" . $finyear[0];
}

if($dt=="01-03")
{
$fdt ="01-" . $exp_mn[0] . "-". substr($finyear[0],0,2) . $finyear[1];
$edt = "01-" . $exp_mn[1] . "-". substr($finyear[0],0,2) . $finyear[1];
}
//var_dump($fdt . $edt);
//$fdt="01-" . $this->input->get('fdate');
$fdate = date("Y-m-d",strtotime($fdt));
$tdate = date("Y-m-t",strtotime($edt));
//var_dump($fdt);
}


/*
$fdt="01-" . $this->input->get('fdate');
$fdate = date("Y-m-d",strtotime($fdt));
$tdate = date("Y-m-t",strtotime($fdt));*/
$compId = $this->session->userdata('id');

$url= $this->config->item("api_url") . "/api/reports/getGstr2B";
$data = array("trans_type"=>"PURC","fdate"=>$fdate,"tdate"=>$tdate,"compId"=>$compId);
//$post = ['batch_id'=> "2"];
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

  $gstr2bresponse = curl_exec($ch);
  //$result = json_decode($response);
 //echo $ledgerresponse;
//var_dump($gstr2bresponse);
curl_close($ch); // Close the connection
$main2bdata = json_decode($gstr2bresponse,true);
echo json_encode($main2bdata);
}


public function fetch_gstr3b()
{

$flag = $this->input->get('flag');
$fdate=$this->input->get('fdate');

if($flag=="M")
{
$fdt="01-" . $this->input->get('fdate');

$fdate = date("Y-m-d",strtotime($fdt));
$tdate = date("Y-m-t",strtotime($fdt));
$compId = $this->session->userdata('id');
//var_dump($fdate . $tdate);
}

if($flag=="Q")
{
$dt=$this->input->get('fdate');
$finyear = explode("-", $this->session->userdata('finyear'));
$exp_mn=explode("-", $this->input->get('fdate')); 

if($dt=="04-06")
{
$fdt ="01-" . $exp_mn[0] . "-". $finyear[0];
$edt = "01-" . $exp_mn[1] . "-". $finyear[0];
}
if($dt=="07-09")
{
$fdt ="01-" . $exp_mn[0] . "-". $finyear[0];
$edt = "01-" . $exp_mn[1] . "-". $finyear[0];
}
if($dt=="10-12")
{
$fdt ="01-" . $exp_mn[0] . "-" . $finyear[0];
$edt = "01-" . $exp_mn[1] . "-" . $finyear[0];
}

if($dt=="01-03")
{
$fdt ="01-" . $exp_mn[0] . "-". substr($finyear[0],0,2) . $finyear[1];
$edt = "01-" . $exp_mn[1] . "-". substr($finyear[0],0,2) . $finyear[1];
}
//var_dump($fdt . $edt);
//$fdt="01-" . $this->input->get('fdate');
$fdate = date("Y-m-d",strtotime($fdt));
$tdate = date("Y-m-t",strtotime($edt));
//var_dump($fdt);
}


/*
$fdt="01-" . $this->input->get('fdate');
$fdate = date("Y-m-d",strtotime($fdt));
$tdate = date("Y-m-t",strtotime($fdt)); */
$compId = $this->session->userdata('id');

$url= $this->config->item("api_url") . "/api/reports/getgstr3bdata";
$data = array("trans_type"=>"SALE","fdate"=>$fdate,"tdate"=>$tdate,"compId"=>$compId);
//$post = ['batch_id'=> "2"];
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

  $gstr3bresponse = curl_exec($ch);
  //$result = json_decode($response);
 //echo $ledgerresponse;
//var_dump($gstr3bresponse);
curl_close($ch); // Close the connection
$maindata = json_decode($gstr3bresponse,true);




  $tbl='';
  $tbl ='<table class="table table-bordered" id="gstr3blistTable" width="100%" cellspacing="0">

                  <thead>
                    <tr>
                      
                      <th>Nature of Supplies</th>
                      <th>Total Taxable value</th>
                      <th>Integrated Tax</th>
                      <th>Central Tax</th>
                      <th>State/UT Tax</th>
                      <th>Cess</th>
                      

                    </tr>
                  </thead>
                  <tbody>';
  $tbl .='<tr><td>(a) Outward taxable supplies (other than zero rated, nil rated and exempted)</td><td style="text-align:right;">'. $maindata['txbgst'] .'</td><td style="text-align:right;">'. $maindata['igst_amt'] .'</td><td style="text-align:right;">'. $maindata['cgst_amt'] .'</td><td style="text-align:right;">'. $maindata['sgst_amt'] .'</td><td style="text-align:right;"></td></tr>';
$tbl .='<tr><td>(b) Outward taxable supplies (zero rated)</td><td style="text-align:right;">'. $maindata['zerorate'] .'</td><td style="text-align:right;"></td><td style="text-align:right;"></td><td style="text-align:right;"></td><td style="text-align:right;"></td></tr>';

$tbl .='<tr><td>(c) Other outward supplies (Nil rated, exempted)</td><td style="text-align:right;">'. $maindata['zerogst'] .'<t/d><td style="text-align:right;"></td><td style="text-align:right;"></td><td style="text-align:right;"></td><td style="text-align:right;"></td></tr>';


$tbl .='<tr><td>(d) Inward supplies (liable to reverse charge)</td><td style="text-align:right;"></td><td style="text-align:right;"></td><td style="text-align:right;"></td><td style="text-align:right;"></td><td style="text-align:right;"></td></tr>';


$tbl .='<tr><td>(d) Non-GST outward supplies</td><td style="text-align:right;"></td><td style="text-align:right;"></td><td style="text-align:right;"></td><td style="text-align:right;"></td><td style="text-align:right;"></td></tr>';

$tbl .='</tbody></table>';
echo $tbl;

}


// Ledger Report
public function getledgerlist()
{
$c_balance=0.00;
$data=array();    
$actid = $this->input->get('acctid');
$fdate = $this->input->get('fdate');
$tdate = $this->input->get('tdate');
$compId = $this->session->userdata('id');
$s_date = $this->session->userdata('startdate');
$e_date = $this->session->userdata('enddate');
$finyear = $this->session->userdata('finyear');
$trans_type="CNTR";
//var_dump($compId . $finyear); 
//$your_admin_variable =$this->config->item("admin_url");
//$url=$this->config->item("api_url") . "/api/getalltransaction.php";



$url= $this->config->item("api_url") . "/api/reports/glreport";
$data = array("s_date"=>$s_date,"e_date"=>$e_date,"finyear"=>$finyear,"compId"=>$compId,"actid"=>$actid,"fdate"=>$fdate,"tdate"=>$tdate);
//var_dump($data);
//$post = ['batch_id'=> "2"];
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  //curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");  
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

  $ledgerresponse = curl_exec($ch);
  //$result = json_decode($response);
 //echo $ledgerresponse;
//var_dump($ledgerresponse);
curl_close($ch); // Close the connection
$maindata = json_decode($ledgerresponse,true);
//var_dump($maindata);
$data=array();
$db_amount=0.00;
$cr_amount=0.00;
$cl_balance=0.00;
$name="";

$c_balance = $maindata[0]['opbal'];
$opbal = "<div><b><h5>Opening Balance :" . number_format($maindata[0]['opbal'],'2') ."</h5></b></div>";
//var_dump($opbal);
foreach ($maindata as $key => $d) 
{

//var_dump($d);




if($d['trans_type']=="RCPT")
{

$db_amount=0;
$cr_amount=$d['trans_amount'];
$c_balance =$c_balance+$db_amount-$cr_amount;    
$name=$this->getledgerdatasearchbyid($d['db_account']);// . "<br>" . $d['trans_narration'];
$data['data'][]=array("trans_id"=>$d['trans_id'],"trans_date"=>$d['trans_date'],"trans_ref"=>$d['trans_reference'],"trans_type"=>$d['trans_type'], "particulars"=>$name,"db_amount"=>$db_amount,"cr_amount"=>$cr_amount,"cl_balance"=>$c_balance,"op_balance"=>$opbal);
}
if($d['trans_type']=="PYMT")
{

$name=$this->getledgerdatasearchbyid($d['db_account']);// . "<br>" . $d['trans_narration'];
$cr_amount=0;
$db_amount=$d['trans_amount'];
$c_balance =$c_balance+$db_amount-$cr_amount;    
$data['data'][]=array("trans_id"=>$d['trans_id'],"trans_date"=>$d['trans_date'],"trans_ref"=>$d['trans_reference'],"trans_type"=>$d['trans_type'], "particulars"=>$name,"db_amount"=>$d['trans_amount'],"cr_amount"=>$cr_amount,"cl_balance"=>$c_balance,"op_balance"=>$opbal);

}



if($d['trans_type']=="PURC")
{
//var_dump($d['cr_account']);
//$cr_amount=0;
$name=$this->getledgerdatasearchbyid($d['cr_account']) ;//. "<br>" . $d['trans_narration'];
$db_amount=0;
$cr_amount=$d['net_amount'];
$c_balance =$c_balance+$db_amount-$cr_amount;
$data['data'][]=array("trans_id"=>$d['trans_id'],"trans_date"=>$d['trans_date'],"trans_ref"=>$d['trans_reference'],"trans_type"=>$d['trans_type'], "particulars"=>$name,"db_amount"=>$db_amount,"cr_amount"=>$cr_amount,"cl_balance"=>$c_balance,"op_balance"=>$opbal);

}


if($d['trans_type']=="JRNL")
{
  
//var_dump($d['cr_account']);
//$cr_amount=0;
if($actid==$d['cr_account'])
{
$name=$this->getledgerdatasearchbyid($d['db_account']) ;//. "<br>" . $d['trans_narration'];
$db_amount=0;
$cr_amount=$d['net_amount'];
$c_balance =$c_balance+$db_amount-$cr_amount;
$data['data'][]=array("trans_id"=>$d['trans_id'],"trans_date"=>$d['trans_date'],"trans_ref"=>$d['trans_reference'],"trans_type"=>$d['trans_type'], "particulars"=>$name,"db_amount"=>$db_amount,"cr_amount"=>$cr_amount,"cl_balance"=>$c_balance,"op_balance"=>$opbal);
}
else
{
$name=$this->getledgerdatasearchbyid($d['cr_account']) ;//. "<br>" . $d['trans_narration'];
$cr_amount=0;
$db_amount=$d['net_amount'];
$c_balance =$c_balance+$db_amount-$cr_amount;
$data['data'][]=array("trans_id"=>$d['trans_id'],"trans_date"=>$d['trans_date'],"trans_ref"=>$d['trans_reference'],"trans_type"=>$d['trans_type'], "particulars"=>$name,"db_amount"=>$db_amount,"cr_amount"=>$cr_amount,"cl_balance"=>$c_balance,"op_balance"=>$opbal);

}
}

if($d['trans_type']=="SALE")
{
$cr_amount=0;
$db_amount=$d['net_amount'];
$c_balance =$c_balance+$db_amount-$cr_amount;
$name=$this->getledgerdatasearchbyid($d['cr_account']);// . "<br>" . $d['trans_narration'];
$data['data'][]=array("trans_id"=>$d['trans_id'],"trans_date"=>$d['trans_date'],"trans_ref"=>$d['trans_reference'],"trans_type"=>$d['trans_type'], "particulars"=>$name,"db_amount"=>$db_amount,"cr_amount"=>$cr_amount,"cl_balance"=>$c_balance,"op_balance"=>$opbal);
}


$db_amount=0;
$cr_amount=0;



}

//var_dump($opbal);
//$tbl .='</tbody></table>';
//$result = array_merge($opbal,$data);
echo json_encode($data);

}


//Cash/Bank Book Printing
public function printCashBank()
{
$db_tot=0.00;
$cr_tot=0.00;
$cl_tot=0.00;
$cl_balance=0.00;  

$rw=1;
$pg=1;
$pglines=22;

$compId = $this->session->userdata('id'); 
$tbl="";

//$url = $this->config->item("api_url") . "/api/companydetails.php?id=" . $compId;
$url = $this->config->item("api_url") . "/api/company/" . $compId;
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
$cresult = curl_exec($ch);
curl_close($ch);

            //-- if valid
//var_dump($cresult);
//var w = window.open(url+'?acctid='+actid+'&fdate='+fdate+'&tdate='+tdate

$fdate = $this->input->get('fdate');
$tdate = $this->input->get('tdate');
$acname = $this->input->get('acname');

if($cresult){

$data = array();

$phpArray = json_decode($cresult, true);

                   $heading_data = array(
                        'cname' =>  $phpArray['company_name'],
                        'cadd' =>  $phpArray['company_address'],
                        'email' =>  $phpArray['company_email'],
                        'cstatecode' =>  $phpArray['company_statecode'],
                        'city' =>  $phpArray['company_city'],
                        'pincode' =>  $phpArray['company_pincode'],
                        'gstin' =>  $phpArray['company_gstin'],
                        'contact' =>  $phpArray['company_contact'],
                        'cbankdetails' =>  $phpArray['company_bankdetails'],
                        'acname' => $acname,'fdate'=>$fdate,'tdate'=>$tdate); 

}


$data=array();    
$actid = $this->input->get('acctid');
$fdate = $this->input->get('fdate');
$tdate = $this->input->get('tdate');
$compId = $this->session->userdata('id');
$finyear = $this->session->userdata('finyear');
$trans_type="CNTR";
//var_dump($compId . $finyear); 
$url=$this->config->item("api_url") . "/api/reports/cashbankreport";

//$url=$this->config->item("api_url") . "/api/getcashbankbook.php";
$data = array("finyear"=>$finyear,"compId"=>$compId,"actid"=>$actid,"fdate"=>$fdate,"tdate"=>$tdate);

//$post = ['batch_id'=> "2"];
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

  $cashbankresponse = curl_exec($ch);
  //$result = json_decode($response);
// echo $cashbankresponse;

curl_close($ch); // Close the connection
$maindata = json_decode($cashbankresponse,true);
$data=array();
$db_amount=0.00;
$cr_amount=0.00;


$cl_balance=0.00;
$name="";
$c_balance = $maindata[0]['opbal'];
$cl_balance = $maindata[0]['opbal'];
$opbal = "<div><b><h5>Opening Balance :" . number_format($maindata[0]['opbal'],'2') ."</h5></b></div>";






foreach ($maindata as $key => $d) 
{
    
//$db_name=$this->getledgerdatasearchbyid($d['db_account']);
//$cr_name=$this->getledgerdatasearchbyid($d['cr_account']);


if($d['trans_type']=="RCPT")
{

$cr_amount=0;
$cr_name=$this->getledgerdatasearchbyid($d['cr_account']) . "<br>" . $d['trans_narration'];
$button="<div class='btn-group'><button type='button' class='btn btn-warning btn-circle btn-xs center-block'  href='#' data-toggle='modal' data-target='#modalEditReceipt'  onclick='updateTransid(" . $d["id"] . ")'><i class='fa fa-edit'></i></button><button type='button' class='btn btn-danger btn-circle btn-xs center-block'  href='#' data-toggle='modal' data-target='#deleteModal' onclick='deleteTransid(". $d["id"]. ")'><i class='fa fa-times'></i></button></div>";
$cr_account=0;
$db_amount=$d['trans_amount'];
if($db_amount!=0)
{
  $db_amt = $db_amount;
}
else
{
  $db_amt ="";
}

if($cr_amount!=0)
{
  $cr_amt = $cr_amount;
}
else
{
  $cr_amt ="";
}

$cl_balance = $cl_balance+$db_amount-$cr_amount;
$data[]=array("trans_id"=>$d['trans_id'],"trans_date"=>$d['trans_date'],"trans_ref"=>$d['trans_reference'],"particulars"=>$cr_name,"db_amount"=>$db_amt,"cr_amount"=>$cr_amt,"cl_balance"=>$cl_balance);

}


if($d['trans_type']=="PYMT")
{

$button="<div class='btn-group'><button type='button' class='btn btn-warning btn-circle btn-xs center-block'  href='#' data-toggle='modal' data-target='#modalEditReceipt'  onclick='updateTransid(" . $d["id"] . ")'><i class='fa fa-edit'></i></button><button type='button' class='btn btn-danger btn-circle btn-xs center-block'  href='#' data-toggle='modal' data-target='#deleteModal' onclick='deleteTransid(". $d["id"]. ")'><i class='fa fa-times'></i></button></div>";
$db_amount=0;
$cr_amount=$d['trans_amount'];
$cl_balance = $cl_balance+$db_amount-$cr_amount;
if($db_amount!=0)
{
  $db_amt = $db_amount;
}
else
{
  $db_amt ="";
}

if($cr_amount!=0)
{
  $cr_amt = $cr_amount;
}
else
{
  $cr_amt ="";
}

$db_name=$this->getledgerdatasearchbyid($d['cr_account']) . "<br>" . $d['trans_narration'];
$data[]=array("trans_id"=>$d['trans_id'],"trans_date"=>$d['trans_date'],"trans_ref"=>$d['trans_reference'],"particulars"=>$db_name,"db_amount"=>$db_amt,"cr_amount"=>$cr_amt,"cl_balance"=>$cl_balance);
}




if($d['trans_type']=="CNTR" && $d['cr_account']==$actid)
{

$button="<div class='btn-group'><button type='button' class='btn btn-warning btn-circle btn-xs center-block'  href='#' data-toggle='modal' data-target='#modalEditReceipt'  onclick='updateTransid(" . $d["id"] . ")'><i class='fa fa-edit'></i></button><button type='button' class='btn btn-danger btn-circle btn-xs center-block'  href='#' data-toggle='modal' data-target='#deleteModal' onclick='deleteTransid(". $d["id"]. ")'><i class='fa fa-times'></i></button></div>";
$db_amount=0;
$cr_amount=$d['trans_amount'];
$cl_balance = $cl_balance+$db_amount-$cr_amount;
if($db_amount!=0)
{
  $db_amt = $db_amount;
}
else
{
  $db_amt ="";
}

if($cr_amount!=0)
{
  $cr_amt = $cr_amount;
}
else
{
  $cr_amt ="";
}

$db_name=$this->getledgerdatasearchbyid($d['db_account']) . "<br>" . $d['trans_narration'];
$data[]=array("trans_id"=>$d['trans_id'],"trans_date"=>$d['trans_date'],"trans_ref"=>$d['trans_reference'],"particulars"=>$db_name,"db_amount"=>$db_amt,"cr_amount"=>$cr_amt,"cl_balance"=>$cl_balance);
}


else if($d['trans_type']=="CNTR" && $d['db_account']==$actid)
{

$button="<div class='btn-group'><button type='button' class='btn btn-warning btn-circle btn-xs center-block'  href='#' data-toggle='modal' data-target='#modalEditReceipt'  onclick='updateTransid(" . $d["id"] . ")'><i class='fa fa-edit'></i></button><button type='button' class='btn btn-danger btn-circle btn-xs center-block'  href='#' data-toggle='modal' data-target='#deleteModal' onclick='deleteTransid(". $d["id"]. ")'><i class='fa fa-times'></i></button></div>";
$cr_amount=0;
$db_amount=$d['trans_amount'];
$cl_balance = $cl_balance+$db_amount-$cr_amount;
if($db_amount!=0)
{
  $db_amt = $db_amount;
}
else
{
  $db_amt ="";
}

if($cr_amount!=0)
{
  $cr_amt = $cr_amount;
}
else
{
  $cr_amt ="";
}
$db_name=$this->getledgerdatasearchbyid($d['cr_account']) . "<br>" . $d['trans_narration'];

$data[]=array("trans_id"=>$d['trans_id'],"trans_date"=>$d['trans_date'],"trans_ref"=>$d['trans_reference'],"particulars"=>$db_name,"db_amount"=>$db_amt,"cr_amount"=>$cr_amt,"cl_balance"=>$cl_balance);

}
$db_amount=0;
$cr_amount=0;

}


 $this->cb_head($heading_data);

//for ($i=1; $i <=count($data) ; $i++) { 
  # code...

//$tbl .= $i;
//$tbl .='<tr>';
ECHO '<tr><td colspan="6" style="margin-top:10px; font-weight:bold;font-size:18;">Opening Balance</td><td style="font-weight:bold;font-size:18;text-align:right;">'. number_format( floatval($c_balance),'2') .'</td></tr>';

foreach ($data as $key => $value) {
  # code...
if($value["db_amount"]>0)
{
  $dbamt=$value["db_amount"];
}
else
{
  $dbamt="";
}

if($value["cr_amount"]>0)
{
  $cramt=$value["cr_amount"];
}
else
{
  $cramt="";
}

ECHO '<tr><td>'. date('d-m-yy',strtotime($value["trans_date"])).'</td><td>'. $value["trans_id"].'</td><td>'. $value["trans_ref"].'</td><td>'. $value["particulars"] .'</td><td style="text-align:right">'. $dbamt .'</td><td style="text-align:right">'. $cramt .'</td><td style="text-align:right">'. number_format( floatval($value["cl_balance"]),'2').'</td></tr>' ;


$db_tot=$db_tot+floatval($value["db_amount"]);
$cr_tot=$cr_tot+floatval($value["cr_amount"]);
$cl_tot=floatval($value["cl_balance"]);
/*

if($i==48)
{

$tbl.='<div style="text-align:center"><h5>'. $heading_data["cadd"] .'</h5></div>';

}


if($i<=48)
{
  $remain_rw = 48-$i;
  for ($rw=0; $rw <$remain_rw ; $rw++) { 
    # code...
    $tbl .= '<br/>';
  }
$tbl.='<div class="footer" style="text-align:center"><h5>'. $heading_data["cadd"] .'</h5></div>';

}
*/

if($rw==$pglines) 
{
$rw=1;
    $r=1;
    $pg=$pg+1;
ECHO '<div class="pagebreak"></div>';
    ECHO  '</table>';
    ECHO  '<br>';
    ECHO  '<div class="pull-right" align="right"> Contd./-</div>';
ECHO  '<div class="breakAfter"></div>';

ECHO '<div style="text-align:center"><h3>'. $heading_data["cname"] .'</h3></div>';
ECHO '<div class="footer" style="text-align:center;margin-top:-15px;"><h6>'. $heading_data["cadd"] .'</h6></div>';
ECHO '<div class="footer" style="text-align:center;margin-top:-15px;"><h6>'. $heading_data["contact"] .' | ' . $heading_data["email"] . '</h6></div>';

ECHO '<div style="text-align:center;margin-top:-15px;"><h5>'. $heading_data["acname"].'  BOOK FOR THE PERIOD ( '. date("d-m-yy", strtotime($heading_data["fdate"])) .' to '. date("d-m-yy", strtotime($heading_data["tdate"])) .' )</h5></div>';
ECHO '<div style="float:right;" class="pull-right">Page No : '. $pg . '</div>';


ECHO '<table class="table" width="100%"><tr>
<th style="text-align:left;border-left:none;">DATE</th>
<th style="text-align:left;border-left:none;">TRANS #</th>
<th style="text-align:left;border-left:none;">REFERENCE</th>
<th style="text-align:left;border-left:none;">PARTICULARS</th>
<th style="text-align:right;border-left:none;">DEBIT</th>
<th style="text-align:right;border-left:none;">CREDIT</th>
<th style="text-align:right;border-left:none;">BALANCE</th></tr>';


}
$rw++;


}

//ECHO '</table><br><table class="table" width="100%">';

ECHO '<tr height=50px;><td></td><td></td><td></td><td><strong>CLOSING BALANCE</strong></td><td style="text-align:right;"><strong>'. number_format($db_tot,'2') .'</strong></td><td style="text-align:right;"><strong>'.  number_format($cr_tot,'2') .'</strong></td><td style="text-align:right;"><strong>'.  number_format($cl_tot,'2') .'</strong></td></tr>';

//$tbl .='</table>';  
ECHO '</table>';

echo $tbl;







}


function cb_head($heading_data)
{
$tbl="";
$pg=1;
ECHO '<link rel="stylesheet" type="text/css" href="'. base_url() . 'assets/css/cashbook.css">';

ECHO '<div style="text-align:center"><h3>'. $heading_data["cname"] .'</h3></div>';
ECHO '<div class="footer" style="text-align:center;margin-top:-15px;"><h6>'. $heading_data["cadd"] .'</h6></div>';
ECHO '<div class="footer" style="text-align:center;margin-top:-15px;"><h6>'. $heading_data["contact"] .' | ' . $heading_data["email"] . '</h6></div>';

ECHO '<div style="text-align:center;margin-top:-10px;"><h5>'. $heading_data["acname"].'  BOOK FOR THE PERIOD ( '. date("d-m-yy", strtotime($heading_data["fdate"])) .' to '. date("d-m-yy", strtotime($heading_data["tdate"])) .' )</h5></div>';

ECHO '<div style="float:right;" class="pull-right">Page No : '. $pg . '</div>';


ECHO '<table class="table" width="100%"><tr>
<th style="text-align:left;border-top;">DATE</th>
<th style="text-align:left">TRANS #</th>
<th style="text-align:left">REFERENCE</th>
<th style="text-align:left">PARTICULARS</th>
<th style="text-align:right">DEBIT</th>
<th style="text-align:right">CREDIT</th>
<th style="text-align:right">BALANCE</th></tr>';
}



//Cash Bank Report

public function getcashbanklist()
{
$cl_balance=0.00;
$data=array();    
$actid = $this->input->get('acctid');
$fdate = $this->input->get('fdate');
$tdate = $this->input->get('tdate');
$compId = $this->session->userdata('id');
$finyear = $this->session->userdata('finyear');
$trans_type="CNTR";
//var_dump($compId . $finyear); 
$url=$this->config->item("api_url") . "/api/reports/cashbankreport";
$data = array("finyear"=>$finyear,"compId"=>$compId,"actid"=>$actid,"fdate"=>$fdate,"tdate"=>$tdate);

//$post = ['batch_id'=> "2"];
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

  $cashbankresponse = curl_exec($ch);
  //$result = json_decode($response);
// echo $cashbankresponse;
//var_dump($cashbankresponse);
curl_close($ch); // Close the connection
$maindata = json_decode($cashbankresponse,true);
//var_dump($maindata);
$data=array();
$db_amount=0.00;
$cr_amount=0.00;
$cl_balance=0.00;
$name="";
if($maindata)
{
$cl_balance = $maindata[0]['opbal'];
if(is_null($cl_balance))
{
  $cl_balance=0;
}




$opbal = "<div><b><h5>Opening Balance :" . number_format($cl_balance,'2') ."</h5></b></div>";


foreach ($maindata as $key => $d) 
{
    
//$db_name=$this->getledgerdatasearchbyid($d['db_account']);
//$cr_name=$this->getledgerdatasearchbyid($d['cr_account']);


if($d['trans_type']=="RCPT")
{

$cr_amount=0;
$cr_name=$this->getledgerdatasearchbyid($d['cr_account']) . "<br>" . $d['trans_narration'];
$button="<div class='btn-group'><button type='button' class='btn btn-warning btn-circle btn-xs center-block'  href='#' data-toggle='modal' data-target='#modalEditReceipt'  onclick='updateTransid(" . $d["id"] . ")'><i class='fa fa-edit'></i></button><button type='button' class='btn btn-danger btn-circle btn-xs center-block'  href='#' data-toggle='modal' data-target='#deleteModal' onclick='deleteTransid(". $d["id"]. ")'><i class='fa fa-times'></i></button></div>";
$cr_account=0;
$db_amount=$d['trans_amount'];
if($db_amount!=0)
{
  $db_amt = $db_amount;
}
else
{
  $db_amt ="";
}

if($cr_amount!=0)
{
  $cr_amt = $cr_amount;
}
else
{
  $cr_amt ="";
}

$cl_balance = $cl_balance+$db_amount-$cr_amount;
$data['data'][]=array("action"=>$button,"trans_id"=>$d['trans_id'],"trans_date"=>$d['trans_date'],"trans_ref"=>$d['trans_reference'],"particulars"=>$cr_name,"db_amount"=>$db_amt,"cr_amount"=>$cr_amt,"cl_balance"=>$cl_balance,"op_balance"=>$opbal);

}


if($d['trans_type']=="PYMT")
{

$button="<div class='btn-group'><button type='button' class='btn btn-warning btn-circle btn-xs center-block'  href='#' data-toggle='modal' data-target='#modalEditReceipt'  onclick='updateTransid(" . $d["id"] . ")'><i class='fa fa-edit'></i></button><button type='button' class='btn btn-danger btn-circle btn-xs center-block'  href='#' data-toggle='modal' data-target='#deleteModal' onclick='deleteTransid(". $d["id"]. ")'><i class='fa fa-times'></i></button></div>";
$db_amount=0;
$cr_amount=$d['trans_amount'];
$cl_balance = $cl_balance+$db_amount-$cr_amount;
if($db_amount!=0)
{
  $db_amt = $db_amount;
}
else
{
  $db_amt ="";
}

if($cr_amount!=0)
{
  $cr_amt = $cr_amount;
}
else
{
  $cr_amt ="";
}

$db_name=$this->getledgerdatasearchbyid($d['cr_account']) . "<br>" . $d['trans_narration'];
$data['data'][]=array("action"=>$button,"trans_id"=>$d['trans_id'],"trans_date"=>$d['trans_date'],"trans_ref"=>$d['trans_reference'],"particulars"=>$db_name,"db_amount"=>$db_amt,"cr_amount"=>$cr_amt,"cl_balance"=>$cl_balance,"op_balance"=>$opbal);
}




if($d['trans_type']=="CNTR" && $d['cr_account']==$actid)
{

$button="<div class='btn-group'><button type='button' class='btn btn-warning btn-circle btn-xs center-block'  href='#' data-toggle='modal' data-target='#modalEditReceipt'  onclick='updateTransid(" . $d["id"] . ")'><i class='fa fa-edit'></i></button><button type='button' class='btn btn-danger btn-circle btn-xs center-block'  href='#' data-toggle='modal' data-target='#deleteModal' onclick='deleteTransid(". $d["id"]. ")'><i class='fa fa-times'></i></button></div>";
$db_amount=0;
$cr_amount=$d['trans_amount'];
$cl_balance = $cl_balance+$db_amount-$cr_amount;
if($db_amount!=0)
{
  $db_amt = $db_amount;
}
else
{
  $db_amt ="";
}

if($cr_amount!=0)
{
  $cr_amt = $cr_amount;
}
else
{
  $cr_amt ="";
}

$db_name=$this->getledgerdatasearchbyid($d['db_account']) . "<br>" . $d['trans_narration'];
$data['data'][]=array("action"=>$button,"trans_id"=>$d['trans_id'],"trans_date"=>$d['trans_date'],"trans_ref"=>$d['trans_reference'],"particulars"=>$db_name,"db_amount"=>$db_amt,"cr_amount"=>$cr_amt,"cl_balance"=>$cl_balance,"op_balance"=>$opbal);
}


else if($d['trans_type']=="CNTR" && $d['db_account']==$actid)
{

$button="<div class='btn-group'><button type='button' class='btn btn-warning btn-circle btn-xs center-block'  href='#' data-toggle='modal' data-target='#modalEditReceipt'  onclick='updateTransid(" . $d["id"] . ")'><i class='fa fa-edit'></i></button><button type='button' class='btn btn-danger btn-circle btn-xs center-block'  href='#' data-toggle='modal' data-target='#deleteModal' onclick='deleteTransid(". $d["id"]. ")'><i class='fa fa-times'></i></button></div>";
$cr_amount=0;
$db_amount=$d['trans_amount'];
$cl_balance = $cl_balance+$db_amount-$cr_amount;
if($db_amount!=0)
{
  $db_amt = $db_amount;
}
else
{
  $db_amt ="";
}

if($cr_amount!=0)
{
  $cr_amt = $cr_amount;
}
else
{
  $cr_amt ="";
}

$db_name=$this->getledgerdatasearchbyid($d['cr_account']) . "<br>" . $d['trans_narration'];
$data['data'][]=array("action"=>$button,"trans_id"=>$d['trans_id'],"trans_date"=>$d['trans_date'],"trans_ref"=>$d['trans_reference'],"particulars"=>$db_name,"db_amount"=>$db_amt,"cr_amount"=>$cr_amt,"cl_balance"=>$cl_balance,"op_balance"=>$opbal);
}


$db_amount=0;
$cr_amount=0;

}

}
//$tbl .='</tbody></table>';
//$result = array_merge($data,array("cl_balance"=>$cl_balance));
echo json_encode($data);

}



public function getallreceiptlist()
{
$data=array();    
$compId = $this->session->userdata('id');
$finyear = $this->session->userdata('finyear');
$trans_type="RCPT";
//var_dump($compId . $finyear); 
$url=$this->config->item("api_url") . "/api/getallreceiptspayments.php";
$data = array("finyear"=>$finyear,"compId"=>$compId,"trans_type"=>$trans_type);
//$post = ['batch_id'=> "2"];
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);

  $receiptresponse = curl_exec($ch);
  //$result = json_decode($response);
 $receiptresponse;

curl_close($ch); // Close the connection
$maindata = json_decode($receiptresponse,true);
$data=array();
foreach ($maindata as $key => $d) 
{
    
$db_name=$this->getledgerdatasearchbyid($d['db_account']);
$cr_name=$this->getledgerdatasearchbyid($d['cr_account']);
$button="<div class='btn-group'><button type='button' class='btn btn-warning btn-circle btn-xs center-block'  href='#' data-toggle='modal' data-target='#modalEditReceipt'  onclick='updateTransid(" . $d["id"] . ")'><i class='fa fa-edit'></i></button><button type='button' class='btn btn-danger btn-circle btn-xs center-block'  href='#' data-toggle='modal' data-target='#deleteModal' onclick='deleteTransid(". $d["id"]. ")'><i class='fa fa-times'></i></button></div>";

$data['data'][]=array("action"=>$button,"trans_id"=>$d['trans_id'],"trans_date"=>$d['trans_date'],"db_name"=>$db_name,"cr_name"=>$cr_name,"trans_amount"=>$d['trans_amount'],"trans_ref"=>$d['trans_reference'],"narration"=>$d['trans_narration']);

}


//$tbl .='</tbody></table>';

echo json_encode($data);

}


public function getallpaymentlist()
{
$data=array();    
$compId = $this->session->userdata('id');
$finyear = $this->session->userdata('finyear');
$trans_type="PYMT";
//var_dump($compId . $finyear); 
$url=$this->config->item("api_url") . "/api/getallreceiptspayments.php";
$data = array("finyear"=>$finyear,"compId"=>$compId,"trans_type"=>$trans_type);
//$post = ['batch_id'=> "2"];
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);

  $receiptresponse = curl_exec($ch);
  //$result = json_decode($response);
 $receiptresponse;

curl_close($ch); // Close the connection
$maindata = json_decode($receiptresponse,true);
$data=array();
foreach ($maindata as $key => $d) 
{
    
$db_name=$this->getledgerdatasearchbyid($d['db_account']);
$cr_name=$this->getledgerdatasearchbyid($d['cr_account']);
$button="<div class='btn-group'><button type='button' class='btn btn-warning btn-circle btn-xs center-block'  href='#' data-toggle='modal' data-target='#modalEditReceipt'  onclick='updateTransid(" . $d["id"] . ")'><i class='fa fa-edit'></i></button><button type='button' class='btn btn-danger btn-circle btn-xs center-block'   href='#' data-toggle='modal' data-target='#deleteModal'  onclick='deleteTransid(". $d["id"]. ")'><i class='fa fa-times'></i></button></div>";

$data['data'][]=array("action"=>$button,"trans_id"=>$d['trans_id'],"trans_date"=>$d['trans_date'],"db_name"=>$db_name,"cr_name"=>$cr_name,"trans_amount"=>$d['trans_amount'],"trans_ref"=>$d['trans_reference'],"narration"=>$d['trans_narration']);

}


//$tbl .='</tbody></table>';

echo json_encode($data);

}


public function deleteTransactionbyid()
{
$id= $this->input->get('id');
$trans_type=$this->input->get('trans_type');
$compId = $this->session->userdata('id');
$finyear = $this->session->userdata('finyear');
$url=$this->config->item("api_url") . "/api/delete_transactionbyid.php";
$data_array=array("id"=>$id,"finyear"=>$finyear,"compId"=>$compId,"trans_type"=>$trans_type);
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_array));
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  $delresponse = curl_exec($ch);
 curl_close($ch); // Close the connection
 echo $delresponse;
}



public function createContra()
{
$contrano = $this->input->post('contrano');
$contradate=$this->input->post('contradate');
$dbaccount=$this->input->post('dbaccount');
$craccount=$this->input->post('craccount');
$trans_amount=$this->input->post('trans_amount');
$transref = $this->input->post('transref');
$narration=$this->input->post('narration');
$compId = $this->session->userdata('id');
$finyear = $this->session->userdata('finyear');


$ldgarray = $this->getledgerdatasearchbyname($dbaccount);

foreach ($ldgarray as $lvalue) {
    //var_dump($lvalue);
    # code...
    $statecode=$lvalue['statecode'];
    $gstin=$lvalue['gstin'];
    $db_account=$lvalue['id'];
}



$ldgarray = $this->getledgerdatasearchbyname($craccount);

foreach ($ldgarray as $lvalue) {
    //var_dump($lvalue);
    # code...
    $statecode=$lvalue['statecode'];
    $gstin=$lvalue['gstin'];
    $cr_account=$lvalue['id'];
}



$url=$this->config->item("api_url") . "/api/getsettings.php";

$data_array= array("compId"=>$compId,"finyear"=>$finyear);
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_array));
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  $setresponse = curl_exec($ch);
  curl_close($ch); // Close the connection
//var_dump($setresponse);
$settArr = json_decode($setresponse);


if($settArr)
{
    # code...
  //var_dump($settArr);
    $cprefix = $settArr->contra_prefix;
    $csuffix = $settArr->contra_suffix;
    $c_no = $settArr->contra_no;
    $cnv_numtype = $settArr->inv_numtype;
    $cnv_leadingzero = $settArr->leading_zero;

if($cnv_numtype=="ZEROPAD")
{
//$ivno= $inv_no;
$_cno = sprintf("%0". $cnv_leadingzero ."d", $c_no);
//$invnum = printf("[%0" .$inv_leadingzero ."s]\n",   $ivno); // zero-padding works on strings too

$cntr_no = $cprefix . $_cno . $csuffix;
$next_cntrno = $c_no+1;
}
else
{
    $_pno= $p_no;
    $cntr_no = $cprefix . $_cno . $csuffix;
    $next_cntrno = $c_no+1;
}


}

$data_post=array(
"trans_id"=>$cntr_no,
"trans_date"=>$contradate,
"db_account"=>$db_account,
"cr_account"=>$cr_account,
"trans_amount"=>$trans_amount,
"trans_type"=>"CNTR",
"transref"=>$transref,
"narration"=>$narration,
"compId"=>$compId,
"finyear"=>$finyear);

$url=$this->config->item("api_url") . "/api/insert_receiptpayment.php";


  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_post));
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  $response = curl_exec($ch);
  //$result = json_decode($response);
  curl_close($ch); // Close the connection
$contratArray = json_decode($response, true);

echo $response;


//$id=$res['last_ins_id'];


if($contraArray['success']=true)
{
$url=$this->config->item("api_url") . "/api/updatesettings.php";
$data_array=array("finyear"=>$finyear,"compId"=>$compId,"next_no"=>$next_cntrno,"trans_type"=>"CNTR");
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_array));
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  $updsettresponse = curl_exec($ch);
curl_close($ch);
 //var_dump($updsettresponse);
 $sts= json_decode($updsettresponse);
}

}





public function createPayment()
{
$paymentno = $this->input->post('paymentno');
$paymentdate=$this->input->post('paymentdate');
$dbaccount=$this->input->post('dbaccount');
$craccount=$this->input->post('craccount');
$trans_amount=$this->input->post('trans_amount');
$transref = $this->input->post('transref');
$narration=$this->input->post('narration');
$compId = $this->session->userdata('id');
$finyear = $this->session->userdata('finyear');


$ldgarray = $this->getledgerdatasearchbyname($dbaccount);

foreach ($ldgarray as $lvalue) {
    //var_dump($lvalue);
    # code...
    $statecode=$lvalue['statecode'];
    $gstin=$lvalue['gstin'];
    $db_account=$lvalue['id'];
}



$ldgarray = $this->getledgerdatasearchbyname($craccount);

foreach ($ldgarray as $lvalue) {
    //var_dump($lvalue);
    # code...
    $statecode=$lvalue['statecode'];
    $gstin=$lvalue['gstin'];
    $cr_account=$lvalue['id'];
}



$url=$this->config->item("api_url") . "/api/getsettings.php";

$data_array= array("compId"=>$compId,"finyear"=>$finyear);
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_array));
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  $setresponse = curl_exec($ch);
  curl_close($ch); // Close the connection
//var_dump($setresponse);
$settArr = json_decode($setresponse);


if($settArr)
{
    # code...
  //var_dump($settArr);
    $pprefix = $settArr->payment_prefix;
    $psuffix = $settArr->payment_suffix;
    $p_no = $settArr->payment_no;
    $pnv_numtype = $settArr->inv_numtype;
    $pnv_leadingzero = $settArr->leading_zero;

if($pnv_numtype=="ZEROPAD")
{
//$ivno= $inv_no;
$_pno = sprintf("%0". $pnv_leadingzero ."d", $p_no);
//$invnum = printf("[%0" .$inv_leadingzero ."s]\n",   $ivno); // zero-padding works on strings too

$pyt_no = $pprefix . $_pno . $psuffix;
$next_pytno = $p_no+1;
}
else
{
    $_pno= $p_no;
    $pyt_no = $pprefix . $_pno . $psuffix;
    $next_pytno = $p_no+1;
}


}

$data_post=array(
"trans_id"=>$pyt_no,
"trans_date"=>$paymentdate,
"db_account"=>$db_account,
"cr_account"=>$cr_account,
"trans_amount"=>$trans_amount,
"trans_type"=>"PYMT",
"transref"=>$transref,
"narration"=>$narration,
"compId"=>$compId,
"finyear"=>$finyear);



$url=$this->config->item("api_url") . "/api/insert_receiptpayment.php";


  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_post));
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  $response = curl_exec($ch);
  //$result = json_decode($response);
  curl_close($ch); // Close the connection
$receiptArray = json_decode($response, true);

echo $response;


//$id=$res['last_ins_id'];


if($paymentArray['success']=true)
{
$url=$this->config->item("api_url") . "/api/updatesettings.php";
$data_array=array("finyear"=>$finyear,"compId"=>$compId,"next_no"=>$next_pytno,"trans_type"=>"PYMT");
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_array));
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  $updsettresponse = curl_exec($ch);
curl_close($ch);
 //var_dump($updsettresponse);
 $sts= json_decode($updsettresponse);
}

}


public function createReceipt()
{
$receiptno = $this->input->post('receiptno');
$receiptdate=$this->input->post('receiptdate');
$dbaccount=$this->input->post('dbaccount');
$craccount=$this->input->post('craccount');
$trans_amount=$this->input->post('trans_amount');
$transref = $this->input->post('transref');
$narration=$this->input->post('narration');
$compId = $this->session->userdata('id');
$finyear = $this->session->userdata('finyear');


$ldgarray = $this->getledgerdatasearchbyname($dbaccount);

foreach ($ldgarray as $lvalue) {
    //var_dump($lvalue);
    # code...
    $statecode=$lvalue['statecode'];
    $gstin=$lvalue['gstin'];
    $db_account=$lvalue['id'];
}



$ldgarray = $this->getledgerdatasearchbyname($craccount);

foreach ($ldgarray as $lvalue) {
    //var_dump($lvalue);
    # code...
    $statecode=$lvalue['statecode'];
    $gstin=$lvalue['gstin'];
    $cr_account=$lvalue['id'];
}



$url=$this->config->item("api_url") . "/api/getsettings.php";

$data_array= array("compId"=>$compId,"finyear"=>$finyear);
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_array));
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  $setresponse = curl_exec($ch);
  curl_close($ch); // Close the connection
//var_dump($setresponse);
$settArr = json_decode($setresponse);


if($settArr)
{
    # code...
  //var_dump($settArr);
    $rprefix = $settArr->receipt_prefix;
    $rsuffix = $settArr->receipt_suffix;
    $r_no = $settArr->receipt_no;
    $rnv_numtype = $settArr->inv_numtype;
    $rnv_leadingzero = $settArr->leading_zero;

if($rnv_numtype=="ZEROPAD")
{
//$ivno= $inv_no;
$_rno = sprintf("%0". $rnv_leadingzero ."d", $r_no);
//$invnum = printf("[%0" .$inv_leadingzero ."s]\n",   $ivno); // zero-padding works on strings too

$rct_no = $rprefix . $_rno . $rsuffix;
$next_rctno = $r_no+1;
}
else
{
    $_rno= $r_no;
    $rct_no = $rprefix . $_rno . $rsuffix;
    $next_rctno = $r_no+1;
}


}

$data_post=array(
"trans_id"=>$rct_no,
"trans_date"=>$receiptdate,
"db_account"=>$db_account,
"cr_account"=>$cr_account,
"trans_amount"=>$trans_amount,
"trans_type"=>"RCPT",
"transref"=>$transref,
"narration"=>$narration,
"compId"=>$compId,
"finyear"=>$finyear);



$url=$this->config->item("api_url") . "/api/insert_receiptpayment.php";


  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_post));
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  $response = curl_exec($ch);
  //$result = json_decode($response);
  curl_close($ch); // Close the connection
$receiptArray = json_decode($response, true);

echo $response;


//$id=$res['last_ins_id'];


if($receiptArray['success']=true)
{
$url=$this->config->item("api_url") . "/api/updatesettings.php";
$data_array=array("finyear"=>$finyear,"compId"=>$compId,"next_no"=>$next_rctno,"trans_type"=>"RCPT");
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_array));
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  $updsettresponse = curl_exec($ch);
curl_close($ch);
 //var_dump($updsettresponse);
 $sts= json_decode($updsettresponse);
}

}




public function getPaymentbyid()
{

$id = $this->input->get('id');
$compId = $this->session->userdata('id');
$finyear = $this->session->userdata('finyear');
$trans_type="PYMT";
$url=$this->config->item("api_url") . "/api/getreceiptpaymentbyid.php";
$data = array("id"=>$id,"finyear"=>$finyear,"compId"=>$compId,"trans_type"=>$trans_type);
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);

  $paymentbyidresponse = curl_exec($ch);
  //$result = json_decode($response);
//echo $salesbyidresponse;

curl_close($ch); // Close the connection
$obj = json_decode($paymentbyidresponse,true);
$tbl="";
//var_dump($obj);


foreach ($obj as  $value) {
    # code...
//var_dump($value);
$actid=$value['db_account'];

$url=$this->config->item("api_url") . "/api/getsingle_ledger.php?id=" . $actid;
//$post = ['batch_id'=> "2"];

$data = array("id"=>$actid,"compId"=>$compId);

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
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
$lname=$ldgerArray->name;
//var_dump($value);

$db_name=$this->getledgerdatasearchbyid($value['db_account']);
$cr_name=$this->getledgerdatasearchbyid($value['cr_account']);


$tbl .='<table id="editpayment" class="table table-bordered">
<tr><td><input type="text" id="recid" name="recid" value="' . $value["id"] . '" hidden >Payment#<input type="text" class="form-control" autocomplete="off"  id="paymentno" name="paymentno" value="'.$value["trans_id"].'" readonly></td><td>Payment Date<input type="date" class="form-control" value="'.$value["trans_date"].'"  autocomplete="off"  id="paymentdate" name="paymentdate" required></td><td>Debit Account<input type="text" class="form-control dbaccount" autocomplete="off" id="dbaccount" value="'. $db_name .'"  name="dbaccount" required></td><td>Credit Account<input type="text" class="form-control craccount" autocomplete="off" value="'.$cr_name .'"   id="craccount" name="craccount" required></td></tr><tr><td>Amount <input type="text" class="form-control" id="trans_amount" value="'.$value["trans_amount"].'"  name="trans_amount"></td><td>Trans Ref#<input type="text" class="form-control" autocomplete="off" value="'.$value["trans_reference"].'"   id="transref" name="transref"></td><td colspan="2">Narration<input type="text" class="form-control" value="'.$value["trans_narration"].'"  autocomplete="off"  id="narration" name="narration"></td></tr>
</table>
';


}



echo $tbl;
}


function editPayment()
{
 //Update Payment voucher
$id = $this->input->post('recid');    
$paymentno = $this->input->post('paymentno');
$paymentdate=$this->input->post('paymentdate');
$dbaccount=$this->input->post('dbaccount');
$craccount=$this->input->post('craccount');
$trans_amount=$this->input->post('trans_amount');
$transref = $this->input->post('transref');
$narration=$this->input->post('narration');
$compId = $this->session->userdata('id');
$finyear = $this->session->userdata('finyear');


$ldgarray = $this->getledgerdatasearchbyname($dbaccount);

foreach ($ldgarray as $lvalue) {
    //var_dump($lvalue);
    # code...
    $statecode=$lvalue['statecode'];
    $gstin=$lvalue['gstin'];
    $db_account=$lvalue['id'];
}



$ldgarray = $this->getledgerdatasearchbyname($craccount);

foreach ($ldgarray as $lvalue) {
    //var_dump($lvalue);
    # code...
    $statecode=$lvalue['statecode'];
    $gstin=$lvalue['gstin'];
    $cr_account=$lvalue['id'];
}


$data_post=array(
"id" => $id,
"trans_date"=>$paymentdate,
"db_account"=>$db_account,
"cr_account"=>$cr_account,
"trans_amount"=>$trans_amount,
"trans_type"=>"PYMT",
"transref"=>$transref,
"narration"=>$narration,
"compId"=>$compId,
"finyear"=>$finyear);



$url=$this->config->item("api_url") . "/api/update_receiptpayment.php";


  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_post));
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  $response = curl_exec($ch);
  //$result = json_decode($response);
  curl_close($ch); // Close the connection
$receiptArray = json_decode($response, true);

echo $response;



}

public function getallsaleslist()
{
$compId = $this->session->userdata('id');
$finyear = $this->session->userdata('finyear');
$trans_type=$this->input->get('trans_type');
$fdate = $this->input->get('fdate');
$tdate = $this->input->get('tdate');

$url= $this->config->item("api_url") . "/api/reports/spreport";
$data = array("fdate"=>$fdate,"tdate"=>$tdate,"finyear"=>$finyear,"compId"=>$compId,"trans_type"=>$trans_type);
//var_dump($data);
//$post = ['batch_id'=> "2"];
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  //curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");  
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

  $ledgerresponse = curl_exec($ch);
  //$result = json_decode($response);
 //echo $ledgerresponse;
//var_dump($ledgerresponse);
curl_close($ch); // Close the connection
//$maindata = json_decode($ledgerresponse,true);

echo json_encode($ledgerresponse);

}


public function getallSalesPurchaselist()
{

$trans_type=$this->input->get('trans_type');
$fdate=$this->input->get('fdate');
$tdate=$this->input->get('tdate');
$compId = $this->session->userdata('id');
$finyear = $this->session->userdata('finyear');

$data = array("finyear"=>$finyear,"compId"=>$compId,"trans_type"=>$trans_type,"fdate"=>$fdate,"tdate"=>$tdate);
var_dump($data);

$url=$this->config->item("api_url") . "/api/transaction/pursalreg/" . $trans_type . "/" . $finyear . "/" . $compId . "/" . $fdate . "/" . $tdate ;

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  //curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

  $salesresponse = curl_exec($ch);
  //$result = json_decode($response);
//echo $salesresponse;
var_dump($salesresponse);
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

$button="<div class='btn-group'><button type='button' class='btn btn-warning btn-circle btn-xs center-block'  href='#' data-toggle='modal' data-target='#modalEditSales'  onclick='updateTransid(" . $d["id"] . ")'><i class='fa fa-edit'></i></button><button type='button' class='btn btn-primary btn-circle btn-xs center-block' href='#' onclick='printTransid(". $d["id"]. ")'><i class='fa fa-print'></i></button></div>";

$data['data'][]=array("trans_id"=>$d['trans_id'],"trans_date"=>$d['trans_date'],"custname"=>$d['custname'],"gstin"=>$d['gstin'],"taxable_amount"=>$d['txb_tot'],"gst_tot"=>$gst_tot,"net_amount"=>$d['net_tot'],"noi"=>$d['noi']);

}
}

//$tbl .='</tbody></table>';

echo json_encode($data);


}



public function getReceiptbyid()
{

$id = $this->input->get('id');
$compId = $this->session->userdata('id');
$finyear = $this->session->userdata('finyear');
$trans_type="RCPT";
$url=$this->config->item("api_url") . "/api/getreceiptpaymentbyid.php";
$data = array("id"=>$id,"finyear"=>$finyear,"compId"=>$compId,"trans_type"=>$trans_type);
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);

  $receiptbyidresponse = curl_exec($ch);
  //$result = json_decode($response);
//echo $salesbyidresponse;

curl_close($ch); // Close the connection
$obj = json_decode($receiptbyidresponse,true);
$tbl="";
//var_dump($obj);


foreach ($obj as  $value) {
    # code...
//var_dump($value);
$actid=$value['db_account'];

$url=$this->config->item("api_url") . "/api/getsingle_ledger.php?id=" . $actid;
//$post = ['batch_id'=> "2"];

$data = array("id"=>$actid,"compId"=>$compId);

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
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
$lname=$ldgerArray->name;
//var_dump($value);

$db_name=$this->getledgerdatasearchbyid($value['db_account']);
$cr_name=$this->getledgerdatasearchbyid($value['cr_account']);


$tbl .='<table id="editreceipt" class="table table-bordered">
<tr><td><input type="text" id="recid" name="recid" value="' . $value["id"] . '" hidden >Receipt#<input type="text" class="form-control" autocomplete="off"  id="receiptno" name="receiptno" value="'.$value["trans_id"].'" readonly></td><td>Receipt Date<input type="date" class="form-control" value="'.$value["trans_date"].'"  autocomplete="off"  id="receiptdate" name="receiptdate" required></td><td>Debit Account<input type="text" class="form-control dbaccount" autocomplete="off" id="dbaccount" value="'. $db_name .'"  name="dbaccount" required></td><td>Credit Account<input type="text" class="form-control craccount" autocomplete="off" value="'.$cr_name .'"   id="craccount" name="craccount" required></td></tr><tr><td>Amount <input type="text" class="form-control" id="trans_amount" value="'.$value["trans_amount"].'"  name="trans_amount"></td><td>Trans Ref#<input type="text" class="form-control" autocomplete="off" value="'.$value["trans_reference"].'"   id="transref" name="transref"></td><td colspan="2">Narration<input type="text" class="form-control" value="'.$value["trans_narration"].'"  autocomplete="off"  id="narration" name="narration"></td></tr>
</table>';


}



echo $tbl;
}


function editReceipt()
{
 //Update Payment voucher
$id = $this->input->post('recid');    
$receiptno = $this->input->post('receiptno');
$receiptdate=$this->input->post('receiptdate');
$dbaccount=$this->input->post('dbaccount');
$craccount=$this->input->post('craccount');
$trans_amount=$this->input->post('trans_amount');
$transref = $this->input->post('transref');
$narration=$this->input->post('narration');
$compId = $this->session->userdata('id');
$finyear = $this->session->userdata('finyear');


$ldgarray = $this->getledgerdatasearchbyname($dbaccount);

foreach ($ldgarray as $lvalue) {
    //var_dump($lvalue);
    # code...
    $db_account=$lvalue['id'];
}



$ldgarray = $this->getledgerdatasearchbyname($craccount);

foreach ($ldgarray as $lvalue) {
    //var_dump($lvalue);
    # code...
    $cr_account=$lvalue['id'];
}


$data_post=array(
"id" => $id,
"trans_date"=>$receiptdate,
"db_account"=>$db_account,
"cr_account"=>$cr_account,
"trans_amount"=>$trans_amount,
"trans_type"=>"RCPT",
"transref"=>$transref,
"narration"=>$narration,
"compId"=>$compId,
"finyear"=>$finyear);



$url=$this->config->item("api_url") . "/api/update_receiptpayment.php";


  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_post));
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  $response = curl_exec($ch);
  //$result = json_decode($response);
  curl_close($ch); // Close the connection
$receiptArray = json_decode($response, true);

echo $response;



}


function getledgerdata()
{

$url=$this->config->item("api_url") . "/api/ledger";
//$post = ['batch_id'=> "2"];
$compId = $this->session->userdata('id');

$post=array("compId"=>$compId);
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  $response = curl_exec($ch);
  //$result = json_decode($response);
  curl_close($ch); // Close the connection
$ldgerArray = json_decode($response, true);

//echo $response;


//$character = json_decode($data);
//print_r($response);
$data=array();
$option="";
foreach ($ldgerArray as $key => $value) {
if($value['account_groupid']!=1)
{
$option .= '<option value="'.$value['id'].'">'.$value['account_name'].'</option>';
}

}
$option .= '<option selected  disabled value="0">Select an Account</option>';
echo $option;



}



function getcashbankledgerdata()
{

$url=$this->config->item("api_url") . "/api/reports/getcashbankledger";
//$post = ['batch_id'=> "2"];
$compId = $this->session->userdata('id');

$post=array("compId"=>$compId);
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
//  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");  
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  $response = curl_exec($ch);
  //$result = json_decode($response);
  curl_close($ch); // Close the connection
$ldgerArray = json_decode($response, true);
//var_dump($response);
//echo $response;


//$character = json_decode($data);
//print_r($response);
$data=array();
$option="";
foreach ($ldgerArray as $key => $value) {
    
$option .= '<option value="'.$value['id'].'">'.$value['account_name'].'</option>';

}
$option .= '<option selected  disabled value="0">Select an Account</option>';
echo $option;



}


function getledgerdatabyname()
{
$itemkeyword = $this->input->get('itemkeyword');    
$url=$this->config->item("api_url") . "/api/getledgerbyid.php";
//$post = ['batch_id'=> "2"];
$compId = $this->session->userdata('id');
$finyear = $this->session->userdata('finyear');

$post=array("itemkeyword"=>$itemkeyword,"compId"=>$compId);
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  $response = curl_exec($ch);
  //$result = json_decode($response);
  curl_close($ch); // Close the connection
$ldgerArray = json_decode($response, true);

echo $response;

}


function getledgerdatasearchbyid($actid)
{
$data_array=array();


//var_dump($itemkeyword);
$compId = $this->session->userdata('id');
$data_array = array("actid"=>$actid,"compId"=>$compId);
//$id = $this->input->get('id');    
$url=$this->config->item("api_url") . "/api/reports/lbyid";
//$post = ['batch_id'=> "2"];
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_array));
  $response = curl_exec($ch);
  //$result = json_decode($response);
 //var_dump($response);
  curl_close($ch); // Close the connection
$ldgerArray = json_decode($response,true);
$item_data=array();
return $ldgerArray[0]['account_name'];
//return $ldgerArray;
//var_dump($ldgerArray);
/*foreach ($ldgerArray as $key => $value) {
    # code...
 
 return $value['name'];
 
} */

}


function __olgetledgerdatasearchbyid($actid)
{
$data_array=array();


//var_dump($itemkeyword);
$compId = $this->session->userdata('id');
$data_array = array("actid"=>$actid,"compId"=>$compId);
//$id = $this->input->get('id');    
$url=$this->config->item("api_url") . "/api/getledgerbyactid.php";
//$post = ['batch_id'=> "2"];
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_array));
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  $response = curl_exec($ch);
  //$result = json_decode($response);
//var_dump($response);
  curl_close($ch); // Close the connection
$lArray = json_decode($response,true);
$item_data=array();
//return $ldgerArray;
//var_dump($ldgerArray);
foreach ($lArray as $value) {
    # code...
 //var_dump($value);
 return $value['name'];
 
}

}



function getledgerdatasearchbyname($name)
{
$data_array=array();

$itemkeyword= $name; 
//var_dump($itemkeyword);
$compId = $this->session->userdata('id');
$data_array = array("itemkeyword"=>$itemkeyword,"compId"=>$compId);
//$id = $this->input->get('id');    
$url=$this->config->item("api_url") . "/api/getledgerbykeyword.php";
//$post = ['batch_id'=> "2"];
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_array));
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  $response = curl_exec($ch);
  //$result = json_decode($response);
 //var_dump($response);
  curl_close($ch); // Close the connection
$ldgerArray = json_decode($response,true);
$item_data=array();
return $ldgerArray;

}



}


