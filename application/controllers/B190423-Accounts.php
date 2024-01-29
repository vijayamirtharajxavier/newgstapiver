<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Accounts extends CI_Controller {

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

    public function receipts(){
        $data = array();
        $data['page'] = 'Receipts';
        $this->load->view('allreceipts', $data);
    }

    public function payments(){
        $data = array();
        $data['page'] = 'Payments';
        $this->load->view('allpayments', $data);
    }
    public function journals(){
        $data = array();
        $data['page'] = 'Journal Entry';
        $this->load->view('alljournals', $data);
    }

    public function contra(){
        $data = array();
        $data['page'] = 'Bank / Cash Contra';
        $this->load->view('allcontra', $data);
    }


public function getallcontralist()
{
$data=array();    
$compId = $this->session->userdata('id');
$finyear = $this->session->userdata('finyear');
$trans_type="CNTR";
//var_dump($compId . $finyear); 
$url=$this->config->item("api_url") ."/api/accounts/contra";

//$url=$this->config->item("api_url") . "/api/getallreceiptspayments.php";
$data = array("finyear"=>$finyear,"compId"=>$compId,"trans_type"=>$trans_type);
//$post = ['batch_id'=> "2"];
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  //curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

  $contraresponse = curl_exec($ch);
  //$result = json_decode($response);
 $contraresponse;
//var_dump($contraresponse);
curl_close($ch); // Close the connection
$maindata = json_decode($contraresponse,true);
$data=array();
foreach ($maindata as $key => $d) 
{
    
$db_name=$this->getledgerdatasearchbyid($d['db_account']);
$cr_name=$this->getledgerdatasearchbyid($d['cr_account']);
$button="<div class='btn-group'><button type='button' class='btn btn-warning btn-circle btn-xs center-block'  href='#' data-toggle='modal' data-target='#modalEditcontra'  onclick='updateTransid(" . $d["id"] . ")'><i class='fa fa-edit'></i></button><button type='button' class='btn btn-danger btn-circle btn-xs center-block'  href='#' data-toggle='modal' data-target='#deleteModal' onclick='deleteTransid(". $d["id"]. ")'><i class='fa fa-times'></i></button></div>";

$data['data'][]=array("action"=>$button,"trans_id"=>$d['trans_id'],"trans_date"=>$d['trans_date'],"db_name"=>$db_name,"cr_name"=>$cr_name,"trans_amount"=>$d['trans_amount'],"trans_ref"=>$d['trans_reference'],"narration"=>$d['trans_narration']);

}


//$tbl .='</tbody></table>';

echo json_encode($data);

}

public function getallreceiptlist()
{
$data=array();    
$compId = $this->session->userdata('id');
$finyear = $this->session->userdata('finyear');
$trans_type="RCPT";
//var_dump($compId . $finyear); 
$url=$this->config->item("api_url") ."/api/accounts/receipts";
//$url=$this->config->item("api_url") . "/api/getallreceiptspayments.php";
$data = array("finyear"=>$finyear,"compId"=>$compId,"trans_type"=>$trans_type);
//$post = ['batch_id'=> "2"];
  $ch = curl_init();
 curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
 // curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
 
 // curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
/*  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
*/
  $receiptresponse = curl_exec($ch);
  //$result = json_decode($response);
//var_dump($receiptresponse);

curl_close($ch); // Close the connection
$maindata = json_decode($receiptresponse,true);
$data=array();
$db_name="";
$cr_name="";
//var_dump($maindata);
//if (array_key_exists("status",$maindata))
//{
//$data['data'][]=null;

//}
//else 
//{

$json_filter = $this->j_filter($finyear,$maindata);

//var_dump($json_filter);

foreach ($json_filter as $d) 
{
 //var_dump($maindata['db_account']);   
if(array_key_exists("db_account",$d))
{
$db_name=$this->getledgerdatasearchbyid($d['db_account']);
$cr_name=$this->getledgerdatasearchbyid($d['cr_account']);
}
if(array_key_exists("cr_account",$d))
{
$db_name=$this->getledgerdatasearchbyid($d['db_account']);
$cr_name=$this->getledgerdatasearchbyid($d['cr_account']);
}

$button="<div class='btn-group'><button type='button' class='btn btn-warning btn-circle btn-xs center-block'  href='#' data-toggle='modal' data-target='#modalEditReceipt'  onclick='updateTransid(" . $d["id"] . ")'><i class='fa fa-edit'></i></button><button type='button' class='btn btn-danger btn-circle btn-xs center-block'  href='#' data-toggle='modal' data-target='#deleteModal' onclick='deleteTransid(". $d["id"]. ")'><i class='fa fa-times'></i></button></div>";

$data['data'][]=array("action"=>$button,"trans_id"=>$d['trans_id'],"trans_date"=>$d['trans_date'],"db_name"=>$db_name,"cr_name"=>$cr_name,"trans_amount"=>$d['trans_amount'],"trans_ref"=>$d['trans_reference'],"narration"=>$d['trans_narration']);
//var_dump($data);
//}


//$tbl .='</tbody></table>';
}
echo json_encode($data);



}

function j_filter($filter, $array){
    $filtered_array = array();    
 //   var_dump($array); 
    for ($i = 0; $i < count($array); $i++){
 // var_dump($array[$i]['finyear']);
        if($array[$i]['finyear'] == $filter)
     //   var_dump($array[$i]['finyear']);
            $filtered_array[] = $array[$i];
    }
    return $filtered_array;
}

public function getallpaymentlist()
{
$data=array();    
$compId = $this->session->userdata('id');
$finyear = $this->session->userdata('finyear');
$trans_type="PYMT";
//var_dump($compId . $finyear); 

//$url=$this->config->item("api_url") . "/api/getallreceiptspayments.php";
$url=$this->config->item("api_url") ."/api/accounts/payments";
$data = array("finyear"=>$finyear,"compId"=>$compId,"trans_type"=>$trans_type);
//$post = ['batch_id'=> "2"];
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
//  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

  $paymentresponse = curl_exec($ch);
  //$result = json_decode($response);
 //$receiptresponse;
//var_dump($paymentresponse);
curl_close($ch); // Close the connection
$maindata = json_decode($paymentresponse,true);
$data=array();
$json_filter = $this->j_filter($finyear,$maindata);

foreach ($json_filter as $key => $d) 
{
    
$db_name=$this->getledgerdatasearchbyid($d['db_account']);
$cr_name=$this->getledgerdatasearchbyid($d['cr_account']);
$button="<div class='btn-group'><button type='button' class='btn btn-warning btn-circle btn-xs center-block'  href='#' data-toggle='modal' data-target='#modalEditReceipt'  onclick='updateTransid(" . $d["id"] . ")'><i class='fa fa-edit'></i></button><button type='button' class='btn btn-danger btn-circle btn-xs center-block'   href='#' data-toggle='modal' data-target='#deleteModal'  onclick='deleteTransid(". $d["id"]. ")'><i class='fa fa-times'></i></button></div>";

$data['data'][]=array("action"=>$button,"trans_id"=>$d['trans_id'],"trans_date"=>$d['trans_date'],"db_name"=>$db_name,"cr_name"=>$cr_name,"trans_amount"=>$d['trans_amount'],"trans_ref"=>$d['trans_reference'],"narration"=>$d['trans_narration']);

}


//$tbl .='</tbody></table>';

echo json_encode($data);

}


public function getalljournallist()
{
$data=array();    
$compId = $this->session->userdata('id');
$finyear = $this->session->userdata('finyear');
$trans_type="PYMT";
//var_dump($compId . $finyear); 

//$url=$this->config->item("api_url") . "/api/getallreceiptspayments.php";
$url=$this->config->item("api_url") ."/api/accounts/journals";
$data = array("finyear"=>$finyear,"compId"=>$compId,"trans_type"=>$trans_type);
//$post = ['batch_id'=> "2"];
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
//  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

  $journalresponse = curl_exec($ch);
  //$result = json_decode($response);
 //$receiptresponse;
//var_dump($paymentresponse);
curl_close($ch); // Close the connection
$maindata = json_decode($journalresponse,true);
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
$url=$this->config->item("api_url") . "/api/transaction/" . $id ;
$data_array=array("id"=>$id,"finyear"=>$finyear,"compId"=>$compId,"trans_type"=>$trans_type);
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");    
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_array));
  $delresponse = curl_exec($ch);
 curl_close($ch); // Close the connection
 echo $delresponse;
}


public function get_company()
{
$compId = $this->session->userdata('id');
$finyear = $this->session->userdata('finyear');

$url = $this->config->item("api_url") . "/api/getcompany.php";
$data_array= array("compId"=>$compId,"finyear"=>$finyear);
$ch = curl_init($url);
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_array));
$compresult = curl_exec($ch);
curl_close($ch);
//var_dump($compresult);
$compArr =  json_decode($compresult);
if($compArr)
{
  echo json_encode($compArr);
}

}


public function get_settings()
{
$compId = $this->session->userdata('id');
$finyear = $this->session->userdata('finyear');

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
echo json_encode($settArr);
}



}

function fetchUserProfile()
{

$url = $this->config->item("api_url") . "/api/getuserprofile.php";
$userid = $this->session->userdata('userid');
//var_dump($userid);
$data_array= array("id"=>$userid);
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_array));
  $userresponse = curl_exec($ch);
  curl_close($ch); // Close the connection
var_dump($userresponse);
//$finobj = json_decode($fresult,true);
//var_dump($finobj);
/*foreach ($finobj['data'] as $key => $value) {
$option .= '<option value="'.$value['finyear'].'">'.$value['finyear'].'</option>';

}
echo $option;
*/
echo $userresponse;
}




public function save_company()
{
$compId = $this->session->userdata('id');
$companyname=$this->input->post('companyname');
$companyaddress=$this->input->post('companyaddress');
$companygstin=$this->input->post('companygstin');
$companycity=$this->input->post('companycity');
$companypincode=$this->input->post('companypincode');
$companystatecode=$this->input->post('companystatecode');
$companyemail=$this->input->post('companyemail');
$companycontact=$this->input->post('companycontact');
$companybank=$this->input->post('companybank');

$url=$this->config->item("api_url") . "/api/updatecompany.php";
$data_array= array("compId"=>$compId,"companyname"=>$companyname,"companygstin"=>$companygstin,"companyaddress"=>$companyaddress,"companycity"=>$companycity,"companypincode"=>$companypincode,"companystatecode"=>$companystatecode,"companyemail"=>$companyemail,"companycontact"=>$companycontact,"companybank"=>$companybank);

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_array));
  $setupdresponse = curl_exec($ch);
  curl_close($ch); // Close the connection
echo $setupdresponse;

}


public function save_settings()
{
$compId = $this->session->userdata('id');
$finyear = $this->session->userdata('finyear');
$inv_numtype = $this->input->post('numformat');
$inv_leadzero = $this->input->post('leadzero');
$inv_no = $this->input->post('invoice_number');
$inv_prefix = $this->input->post('invoice_prefix');
$inv_suffix = $this->input->post('invoice_suffix');

$receipt_no = $this->input->post('receipt_number');
$receipt_prefix = $this->input->post('receipt_prefix');
$receipt_suffix = $this->input->post('receipt_suffix');

$payment_no = $this->input->post('payment_number');
$payment_prefix = $this->input->post('payment_prefix');
$payment_suffix = $this->input->post('payment_suffix');

$journal_no = $this->input->post('journal_number');
$journal_prefix = $this->input->post('journal_prefix');
$journal_suffix = $this->input->post('journal_suffix');

$contra_no = $this->input->post('contra_number');
$contra_prefix = $this->input->post('contra_prefix');
$contra_suffix = $this->input->post('contra_suffix');

$url=$this->config->item("api_url") . "/api/updateallsettings.php";
$data_array= array("compId"=>$compId,"finyear"=>$finyear,"inv_no"=>$inv_no,"inv_prefix"=>$inv_prefix,"inv_suffix"=>$inv_suffix,"receipt_no"=>$receipt_no,"receipt_prefix"=>$receipt_prefix,"receipt_suffix"=>$receipt_suffix,"payment_no"=>$payment_no,"payment_prefix"=>$payment_prefix,"payment_suffix"=>$payment_suffix,"journal_no"=>$journal_no,"journal_prefix"=>$journal_prefix,"journal_suffix"=>$journal_suffix,"contra_no"=>$contra_no,"contra_prefix"=>$contra_prefix,"contra_suffix"=>$contra_suffix,"numtype"=>$inv_numtype,"num_leadzero"=>$inv_leadzero);

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_array));
  $setupdresponse = curl_exec($ch);
  curl_close($ch); // Close the connection
echo $setupdresponse;
$settupdArr = json_decode($setupdresponse);
//var_dump($settupdArr);
}


public function createcontra()
{
//$contrano = $this->input->post('contrano');
$contradate=$this->input->post('contradate');
$dbaccount=$this->input->post('dbaccount');
$craccount=$this->input->post('craccount');
$trans_amount=$this->input->post('trans_amount');
$transref = $this->input->post('transref');
$narration=$this->input->post('narration');
$compId = $this->session->userdata('id');
$finyear = $this->session->userdata('finyear');


$settingsdata = $this->getsettings();
if($settingsdata)
{
	foreach($settingsdata as $s)
	{
		$cnt_id = $s['contra_no'];
		$cnt_prefix=$s['contra_prefix'];
		$cnt_suffix=$s['contra_suffix'];
	}

	$cnt_no_next = number($cnt_id)+1;
	$contrano = $cnt_prefix . $cnt_no_next . $cnt_suffix;

}

$ldgarray = $this->getledgerdatasearchbyname($dbaccount);

foreach ($ldgarray as $lvalue) {
    //var_dump($lvalue);
    # code...
    $statecode=$lvalue['account_statecode'];
    $gstin=$lvalue['account_gstin'];
    $db_account=$lvalue['id'];
}



$ldgarray = $this->getledgerdatasearchbyname($craccount);

foreach ($ldgarray as $lvalue) {
    //var_dump($lvalue);
    # code...
    $statecode=$lvalue['account_statecode'];
    $gstin=$lvalue['account_gstin'];
    $cr_account=$lvalue['id'];
}



$url=$this->config->item("api_url") . "/api/settings/" . $finyear . "/" . $compId;

//$url=$this->config->item("api_url") . "/api/settings";

//$data_array= array("compId"=>$compId,"finyear"=>$finyear);
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  $setresponse = curl_exec($ch);
  curl_close($ch); // Close the connection
//var_dump($setresponse);
$settArr = json_decode($setresponse,true);


if($settArr)
{
    # code...
  //var_dump($settArr);
    $cprefix = $settArr['contra_prefix'];
    $csuffix = $settArr['contra_suffix'];
    $c_no = $settArr['contra_no'];
    $cnv_numtype = $settArr['inv_numtype'];
    $cnv_leadingzero = $settArr['leading_zero'];

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
"trans_reference"=>$transref,
"trans_narration"=>$narration,
"company_id"=>$compId,
"finyear"=>$finyear);

$url=$this->config->item("api_url") . "/api/accounts";

//$url=$this->config->item("api_url") . "/api/insert_receiptpayment.php";


  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_post));
  $response = curl_exec($ch);
  //$result = json_decode($response);
  curl_close($ch); // Close the connection
$contratArray = json_decode($response, true);

echo $response;


//$id=$res['last_ins_id'];


if($contraArray['success']=true)
{
$url=$this->config->item("api_url") . "/api/productlist/updsettings";
$data_array=array("finyear"=>$finyear,"compId"=>$compId,"next_no"=>$next_cntrno,"trans_type"=>"CNTR");
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

}





public function createPayment()
{
//$paymentno = $this->input->post('paymentno');
$paymentdate=$this->input->post('paymentdate');
$dbaccount=$this->input->post('dbaccount');
$craccount=$this->input->post('craccount');
$trans_amount=$this->input->post('trans_amount');
$net_amount=$this->input->post('trans_amount');
$transref = $this->input->post('transref');
$narration=$this->input->post('narration');
$compId = $this->session->userdata('id');
$finyear = $this->session->userdata('finyear');



$ldgarray = $this->getledgerdatasearchbyname($dbaccount);

foreach ($ldgarray as $lvalue) {
    //var_dump($lvalue);
    # code...
    $statecode=$lvalue['account_statecode'];
    $gstin=$lvalue['account_gstin'];
    $db_account=$lvalue['id'];
}



$ldgarray = $this->getledgerdatasearchbyname($craccount);

foreach ($ldgarray as $lvalue) {
    //var_dump($lvalue);
    # code...
    $statecode=$lvalue['account_statecode'];
    $gstin=$lvalue['account_gstin'];
    $cr_account=$lvalue['id'];
}


$url=$this->config->item("api_url") . "/api/settings/" . $finyear . "/" . $compId;

//$url=$this->config->item("api_url") . "/api/settings";

//$data_array= array("compId"=>$compId,"finyear"=>$finyear);
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);

  $setresponse = curl_exec($ch);
  curl_close($ch); // Close the connection
//var_dump($setresponse);
$settArr = json_decode($setresponse,true);


if($settArr)
{
    # code...
  //var_dump($settArr);
    $pprefix = $settArr['payment_prefix'];
    $psuffix = $settArr['payment_suffix'];
    $p_no = $settArr['payment_no'];
    $pnv_numtype = $settArr['inv_numtype'];
    $pnv_leadingzero = $settArr['leading_zero'];

if($pnv_numtype=="ZEROPAD")
{
//$ivno= $inv_no;
$pytno = sprintf("%0". $pnv_leadingzero ."d", $p_no);
//$invnum = printf("[%0" .$inv_leadingzero ."s]\n",   $ivno); // zero-padding works on strings too

$pyt_no = $pprefix . $pytno . $psuffix;
$next_pytno = $p_no+1;
}
else
{
    $pytno= $p_no;
    $pyt_no = $pprefix . $pytno . $psuffix;
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
"trans_reference"=>$transref,
"trans_narration"=>$narration,
"company_id"=>$compId,
"finyear"=>$finyear);



$url=$this->config->item("api_url") . "/api/accounts";

//$url=$this->config->item("api_url") . "/api/insert_receiptpayment.php";


  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_post));
  $response = curl_exec($ch);
  //$result = json_decode($response);
  curl_close($ch); // Close the connection
$paymentArray = json_decode($response, true);

echo $response;


//$id=$res['last_ins_id'];


if($paymentArray['success']=true)
{
$url=$this->config->item("api_url") . "/api/productlist/updsettings";
$data_array=array("finyear"=>$finyear,"compId"=>$compId,"next_no"=>$next_pytno,"trans_type"=>"PYMT");
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

}

public function createJournal()
{
//$journalno = $this->input->post('journalno');
$journaldate=$this->input->post('journaldate');
$dbaccount=$this->input->post('dbaccount');
$craccount=$this->input->post('craccount');
$trans_amount=$this->input->post('trans_amount');
$net_amount=$this->input->post('trans_amount');
$transref = $this->input->post('transref');
$narration=$this->input->post('narration');
$compId = $this->session->userdata('id');
$finyear = $this->session->userdata('finyear');
$db_account="";
$cr_account="";

$ldgarray = $this->getledgerdatasearchbyname($dbaccount);

foreach ($ldgarray as $lvalue) {
    //var_dump($lvalue);
    # code...
    $statecode=$lvalue['account_statecode'];
    $gstin=$lvalue['account_gstin'];
    $db_account=$lvalue['id'];
}



$ldgarray = $this->getledgerdatasearchbyname($craccount);

foreach ($ldgarray as $lvalue) {
    //var_dump($lvalue);
    # code...
    $statecode=$lvalue['account_statecode'];
    $gstin=$lvalue['account_gstin'];
    $cr_account=$lvalue['id'];
}


$url=$this->config->item("api_url") . "/api/settings/" . $finyear . "/" . $compId;

//$url=$this->config->item("api_url") . "/api/settings";

//$data_array= array("compId"=>$compId,"finyear"=>$finyear);
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);

  $setresponse = curl_exec($ch);
  curl_close($ch); // Close the connection
//var_dump($setresponse);
$settArr = json_decode($setresponse,true);


if($settArr)
{
    # code...
  //var_dump($settArr);
    $jprefix = $settArr['journal_prefix'];
    $jsuffix = $settArr['journal_suffix'];
    $j_no = $settArr['journal_no'];
    $jnv_numtype = $settArr['inv_numtype'];
    $jnv_leadingzero = $settArr['leading_zero'];

/*if($jnv_numtype=="ZEROPAD")
{
//$ivno= $inv_no;
$_jno = sprintf("%0". $jnv_leadingzero ."d", $j_no);
//$invnum = printf("[%0" .$inv_leadingzero ."s]\n",   $ivno); // zero-padding works on strings too

$jv_no = $jprefix . $_jno . $jsuffix;
$next_jvno = $j_no+1;
}
else
{*/
    $jrnno= $j_no;
    $jv_no = $jprefix . $j_no . $jsuffix;
    $next_jvno = $j_no+1;
//}


}

$data_post=array(
"trans_id"=>$jv_no,
"trans_date"=>$journaldate,
"db_account"=>$db_account,
"cr_account"=>$cr_account,
"trans_amount"=>$trans_amount,
"net_amount"=>$trans_amount,
"trans_type"=>"JRNL",
"trans_reference"=>$transref,
"trans_narration"=>$narration,
"company_id"=>$compId,
"finyear"=>$finyear);



$url=$this->config->item("api_url") . "/api/accounts";

//$url=$this->config->item("api_url") . "/api/insert_receiptpayment.php";


  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_post));
  $response = curl_exec($ch);
  //$result = json_decode($response);
  curl_close($ch); // Close the connection
$journalArray = json_decode($response, true);

echo $response;


//$id=$res['last_ins_id'];


if($journalArray['success']=true)
{
$url=$this->config->item("api_url") . "/api/productlist/updsettings";
$data_array=array("finyear"=>$finyear,"compId"=>$compId,"next_no"=>$next_jvno,"trans_type"=>"JRNL");
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

}


public function createReceipt()
{
//$receiptno = $this->input->post('receiptno');
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
    $statecode=$lvalue['account_statecode'];
    $gstin=$lvalue['account_gstin'];
    $db_account=$lvalue['id'];
}



$ldgarray = $this->getledgerdatasearchbyname($craccount);

foreach ($ldgarray as $lvalue) {
    //var_dump($lvalue);
    # code...
    $statecode=$lvalue['account_statecode'];
    $gstin=$lvalue['account_gstin'];
    $cr_account=$lvalue['id'];
}


$url=$this->config->item("api_url") . "/api/settings/" . $finyear . "/" . $compId;

//$url=$this->config->item("api_url") . "/api/settings";

//$data_array= array("compId"=>$compId,"finyear"=>$finyear);
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  //curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");  
  //curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_array));
  $setresponse = curl_exec($ch);
  curl_close($ch); // Close the connection
//var_dump($setresponse);
$settArr = json_decode($setresponse,true);

//var_dump($settArr);
if($settArr)
{
    # code...
  //var_dump($settArr);
    $rprefix = $settArr['receipt_prefix'];
    $rsuffix = $settArr['receipt_suffix'];
    $r_no = $settArr['receipt_no'];
    $rnv_numtype = $settArr['inv_numtype'];
    $rnv_leadingzero = $settArr['leading_zero'];

if($rnv_numtype=="ZEROPAD")
{
//$ivno= $inv_no;
$rctno = sprintf("%0". $rnv_leadingzero ."d", $r_no);
//$invnum = printf("[%0" .$inv_leadingzero ."s]\n",   $ivno); // zero-padding works on strings too

$rct_no = $rprefix . $rctno . $rsuffix;
$next_rctno = $r_no+1;
}
else
{
    $rctno= $r_no;
    $rct_no = $rprefix . $rctno . $rsuffix;
    $next_rctno = $r_no+1;
}


}

$data_post=array(
"trans_id"=>$rct_no,
"trans_date"=>$receiptdate,
"db_account"=>$db_account,
"cr_account"=>$cr_account,
"trans_amount"=>$trans_amount,
"net_amount"=>$trans_amount,
"trans_type"=>"RCPT",
"trans_reference"=>$transref,
"trans_narration"=>$narration,
"company_id"=>$compId,
"finyear"=>$finyear);



$url=$this->config->item("api_url") . "/api/accounts";


  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_post));
  $response = curl_exec($ch);
  //var_dump($response);
  //$result = json_decode($response);
  curl_close($ch); // Close the connection
$receiptArray = json_decode($response, true);

echo $response;


//$id=$res['last_ins_id'];


if($receiptArray['success']=true)
{
$url=$this->config->item("api_url") . "/api/productlist/updsettings";

$compId = $this->session->userdata('id');
$finyear = $this->session->userdata('finyear');

$data_array=array("finyear"=>$finyear,"compId"=>$compId,"next_no"=>$next_rctno,"trans_type"=>"RCPT");
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

}




public function getPaymentbyid()
{

$id = $this->input->get('id');
$compId = $this->session->userdata('id');
$finyear = $this->session->userdata('finyear');
$trans_type="PYMT";
$url=$this->config->item("api_url") . "/api/accounts/" . $id;
//$url=$this->config->item("api_url") . "/api/getreceiptpaymentbyid.php";
$data = array("id"=>$id,"finyear"=>$finyear,"compId"=>$compId,"trans_type"=>$trans_type);
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
//  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

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
$url=$this->config->item("api_url") . "/api/ledger/" . $actid;

//$url=$this->config->item("api_url") . "/api/getsingle_ledger.php?id=" . $actid;
//$post = ['batch_id'=> "2"];

$data = array("id"=>$actid,"compId"=>$compId);

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
 // curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
  //curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
  $ldgresponse = curl_exec($ch);
  //$result = json_decode($response);
//var_dump($data);
//var_dump($ldgresponse);
  curl_close($ch); // Close the connection
$ldgerArray = json_decode($ldgresponse);
//var_dump($ldgerArray);
$lname=$ldgerArray->account_name;
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

public function getJournalbyid()
{

$id = $this->input->get('id');
$compId = $this->session->userdata('id');
$finyear = $this->session->userdata('finyear');
$trans_type="JRNL";
$url=$this->config->item("api_url") . "/api/accounts/" . $id;
//$url=$this->config->item("api_url") . "/api/getreceiptpaymentbyid.php";
$data = array("id"=>$id,"finyear"=>$finyear,"compId"=>$compId,"trans_type"=>$trans_type);
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
//  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

  $journalbyidresponse = curl_exec($ch);
  //$result = json_decode($response);
//echo $salesbyidresponse;

curl_close($ch); // Close the connection
$obj = json_decode($journalbyidresponse,true);
$tbl="";
//var_dump($obj);


foreach ($obj as  $value) {
    # code...
//var_dump($value);
$actid=$value['db_account'];
$url=$this->config->item("api_url") . "/api/ledger/" . $actid;

//$url=$this->config->item("api_url") . "/api/getsingle_ledger.php?id=" . $actid;
//$post = ['batch_id'=> "2"];

$data = array("id"=>$actid,"compId"=>$compId);

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
 // curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
  //curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
  $ldgresponse = curl_exec($ch);
  //$result = json_decode($response);
//var_dump($data);
//var_dump($ldgresponse);
  curl_close($ch); // Close the connection
$ldgerArray = json_decode($ldgresponse);
//var_dump($ldgerArray);
$lname=$ldgerArray->account_name;
//var_dump($value);

$db_name=$this->getledgerdatasearchbyid($value['db_account']);
$cr_name=$this->getledgerdatasearchbyid($value['cr_account']);


$tbl .='<table id="editjournal" class="table table-bordered">
<tr><td><input type="text" id="recid" name="recid" value="' . $value["id"] . '" hidden >Journal#<input type="text" class="form-control" autocomplete="off"  id="journalno" name="journalno" value="'.$value["trans_id"].'" readonly></td><td>Journal Date<input type="date" class="form-control" value="'.$value["trans_date"].'"  autocomplete="off"  id="journaldate" name="journaldate" required></td><td>Debit Account<input type="text" class="form-control dbaccount" autocomplete="off" id="dbaccount" value="'. $db_name .'"  name="dbaccount" required></td><td>Credit Account<input type="text" class="form-control craccount" autocomplete="off" value="'.$cr_name .'"   id="craccount" name="craccount" required></td></tr><tr><td>Amount <input type="text" class="form-control" id="trans_amount" value="'.$value["trans_amount"].'"  name="trans_amount"></td><td>Trans Ref#<input type="text" class="form-control" autocomplete="off" value="'.$value["trans_reference"].'"   id="transref" name="transref"></td><td colspan="2">Narration<input type="text" class="form-control" value="'.$value["trans_narration"].'"  autocomplete="off"  id="narration" name="narration"></td></tr>
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
    $statecode=$lvalue['account_statecode'];
    $gstin=$lvalue['account_gstin'];
    $db_account=$lvalue['id'];
}



$ldgarray = $this->getledgerdatasearchbyname($craccount);

foreach ($ldgarray as $lvalue) {
    //var_dump($lvalue);
    # code...
    $statecode=$lvalue['account_statecode'];
    $gstin=$lvalue['account_gstin'];
    $cr_account=$lvalue['id'];
}


$data_post=array(

"trans_date"=>$paymentdate,
"db_account"=>$db_account,
"cr_account"=>$cr_account,
"trans_amount"=>$trans_amount,
"trans_type"=>"PYMT",
"trans_reference"=>$transref,
"trans_narration"=>$narration,
"company_id"=>$compId,
"finyear"=>$finyear);


$url=$this->config->item("api_url") . "/api/accounts/" . $id;

//$url=$this->config->item("api_url") . "/api/accounts";


  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");      
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_post));
  $response = curl_exec($ch);
  //$result = json_decode($response);
  curl_close($ch); // Close the connection
$receiptArray = json_decode($response, true);

echo $response;



}


function editJournal()
{
 //Update Payment voucher
$id = $this->input->post('recid');    
$journalno = $this->input->post('journalno');
$journaldate=$this->input->post('journaldate');
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
    $statecode=$lvalue['account_statecode'];
    $gstin=$lvalue['account_gstin'];
    $db_account=$lvalue['id'];
}



$ldgarray = $this->getledgerdatasearchbyname($craccount);

foreach ($ldgarray as $lvalue) {
    //var_dump($lvalue);
    # code...
    $statecode=$lvalue['account_statecode'];
    $gstin=$lvalue['account_gstin'];
    $cr_account=$lvalue['id'];
}


$data_post=array(

"trans_date"=>$journaldate,
"db_account"=>$db_account,
"cr_account"=>$cr_account,
"trans_amount"=>$trans_amount,
"net_amount"=>$trans_amount,
"trans_type"=>"JRNL",
"trans_reference"=>$transref,
"trans_narration"=>$narration,
"company_id"=>$compId,
"finyear"=>$finyear);


$url=$this->config->item("api_url") . "/api/accounts/" . $id;

//$url=$this->config->item("api_url") . "/api/accounts";


  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");      
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_post));
  $response = curl_exec($ch);
  //$result = json_decode($response);
  curl_close($ch); // Close the connection
$receiptArray = json_decode($response, true);

echo $response;



}


public function getReceiptbyid()
{

$id = $this->input->get('id');
$compId = $this->session->userdata('id');
$finyear = $this->session->userdata('finyear');
$trans_type="RCPT";
$url=$this->config->item("api_url") . "/api/accounts/" . $id;
$data = array("id"=>$id,"finyear"=>$finyear,"compId"=>$compId,"trans_type"=>$trans_type);
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  //curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

  $receiptbyidresponse = curl_exec($ch);
  //$result = json_decode($response);
//echo $salesbyidresponse;
//var_dump($receiptbyidresponse);
curl_close($ch); // Close the connection
$obj = json_decode($receiptbyidresponse,true);
$tbl="";
//var_dump($obj);


foreach ($obj as  $value) {
    # code...
//var_dump($value);
$actid=$value['db_account'];

$url=$this->config->item("api_url") . "/api/ledger/" . $actid;
//$post = ['batch_id'=> "2"];

$data = array("id"=>$actid,"compId"=>$compId);

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
 // curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
  //curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
  $ldgresponse = curl_exec($ch);
  //$result = json_decode($response);
//var_dump($data);
//var_dump($ldgresponse);
  curl_close($ch); // Close the connection
$ldgerArray = json_decode($ldgresponse);
//var_dump($ldgerArray);
$lname=$ldgerArray->account_name;
//var_dump($value);

$db_name=$this->getledgerdatasearchbyid($value['db_account']);
$cr_name=$this->getledgerdatasearchbyid($value['cr_account']);


$tbl .='<table id="editreceipt" class="table table-bordered">
<tr><td><input type="text" id="recid" name="recid" value="' . $value["id"] . '" hidden >Receipt#<input type="text" class="form-control" autocomplete="off"  id="receiptno" name="receiptno" value="'.$value["trans_id"].'" readonly></td><td>Receipt Date<input type="date" class="form-control" value="'.$value["trans_date"].'"  autocomplete="off"  id="receiptdate" name="receiptdate" required></td><td>Debit Account<input type="text" class="form-control dbaccount" autocomplete="off" id="dbaccount" value="'. $db_name .'"  name="dbaccount" required></td><td>Credit Account<input type="text" class="form-control craccount" autocomplete="off" value="'.$cr_name .'"   id="craccount" name="craccount" required></td></tr><tr><td>Amount <input type="text" class="form-control" id="trans_amount" value="'.$value["trans_amount"].'"  name="trans_amount"></td><td>Trans Ref#<input type="text" class="form-control" autocomplete="off" value="'.$value["trans_reference"].'"   id="transref" name="transref"></td><td colspan="2">Narration<input type="text" class="form-control" value="'.$value["trans_narration"].'"  autocomplete="off"  id="narration" name="narration"></td></tr>
</table>';


}



echo $tbl;
}

public function getContrabyid()
{

$id = $this->input->get('id');
$compId = $this->session->userdata('id');
$finyear = $this->session->userdata('finyear');
$trans_type="CNTR";
$url=$this->config->item("api_url") . "/api/accounts/" . $id;
$data = array("id"=>$id,"finyear"=>$finyear,"compId"=>$compId,"trans_type"=>$trans_type);
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  //curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

  $receiptbyidresponse = curl_exec($ch);
  //$result = json_decode($response);
//echo $salesbyidresponse;
//var_dump($receiptbyidresponse);
curl_close($ch); // Close the connection
$obj = json_decode($receiptbyidresponse,true);
$tbl="";
//var_dump($obj);


foreach ($obj as  $value) {
    # code...
//var_dump($value);
$actid=$value['db_account'];

$url=$this->config->item("api_url") . "/api/ledger/" . $actid;
//$post = ['batch_id'=> "2"];

$data = array("id"=>$actid,"compId"=>$compId);

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
 // curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
  //curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
  $ldgresponse = curl_exec($ch);
  //$result = json_decode($response);
//var_dump($data);
//var_dump($ldgresponse);
  curl_close($ch); // Close the connection
$ldgerArray = json_decode($ldgresponse);
//var_dump($ldgerArray);
$lname=$ldgerArray->account_name;
//var_dump($value);

$db_name=$this->getledgerdatasearchbyid($value['db_account']);
$cr_name=$this->getledgerdatasearchbyid($value['cr_account']);


$tbl .='<table id="editcontra" class="table table-bordered">
<tr><td><input type="text" id="recid" name="recid" value="' . $value["id"] . '" hidden >Contra #<input type="text" class="form-control" autocomplete="off"  id="contrano" name="contrano" value="'.$value["trans_id"].'" readonly></td><td>Contra Date<input type="date" class="form-control" value="'.$value["trans_date"].'"  autocomplete="off"  id="contradate" name="contradate" required></td><td>Debit Account<input type="text" class="form-control dbaccount" autocomplete="off" id="dbaccount" value="'. $db_name .'"  name="dbaccount" required></td><td>Credit Account<input type="text" class="form-control craccount" autocomplete="off" value="'.$cr_name .'"   id="craccount" name="craccount" required></td></tr><tr><td>Amount <input type="text" class="form-control" id="trans_amount" value="'.$value["trans_amount"].'"  name="trans_amount"></td><td>Trans Ref#<input type="text" class="form-control" autocomplete="off" value="'.$value["trans_reference"].'"   id="transref" name="transref"></td><td colspan="2">Narration<input type="text" class="form-control" value="'.$value["trans_narration"].'"  autocomplete="off"  id="narration" name="narration"></td></tr>
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
//"id" => $id,
"trans_date"=>$receiptdate,
"db_account"=>$db_account,
"cr_account"=>$cr_account,
"trans_amount"=>$trans_amount,
"trans_type"=>"RCPT",
"trans_reference"=>$transref,
"trans_narration"=>$narration,
"company_id"=>$compId,
"finyear"=>$finyear);




$url=$this->config->item("api_url") . "/api/accounts/" . $id;

//$url=$this->config->item("api_url") . "/api/accounts";


  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");      
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_post));
  $response = curl_exec($ch);
  //$result = json_decode($response);
  curl_close($ch); // Close the connection
$receiptArray = json_decode($response, true);

echo $response;



}


function editcontra()
{
 //Update Payment voucher
$id = $this->input->post('recid');  
//var_dump($id);  
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
    $db_account=$lvalue['id'];
}



$ldgarray = $this->getledgerdatasearchbyname($craccount);

foreach ($ldgarray as $lvalue) {
    //var_dump($lvalue);
    # code...
    $cr_account=$lvalue['id'];
}


$data_post=array(
//"id" => $id,
"trans_date"=>$contradate,
"db_account"=>$db_account,
"cr_account"=>$cr_account,
"trans_amount"=>$trans_amount,
"trans_type"=>"CNTR",
"trans_reference"=>$transref,
"trans_narration"=>$narration,
"company_id"=>$compId,
"finyear"=>$finyear);


$url=$this->config->item("api_url") . "/api/accounts/" . $id;

//$url=$this->config->item("api_url") . "/api/accounts";
//var_dump($url);

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");      
 curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_post));
  $response = curl_exec($ch);
  //$result = json_decode($response);
  curl_close($ch); // Close the connection
$receiptArray = json_decode($response, true);

echo $response;



}



function getcashledgerdatabyname()
{
$flag=$this->input->get('flag');
$itemkeyword = $this->input->get('itemkeyword');    
$url=$this->config->item("api_url") . "/api/productlist/getcashledgerbyname";
//$post = ['batch_id'=> "2"];
$compId = $this->session->userdata('id');
$finyear = $this->session->userdata('finyear');

$post=array("flag"=>$flag, "itemkeyword"=>$itemkeyword,"compId"=>$compId);
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
 
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
  $response = curl_exec($ch);
  //$result = json_decode($response);
  curl_close($ch); // Close the connection
$ldgerArray = json_decode($response, true);

echo $response;

}


function getledgerdatabyname()
{

$itemkeyword = $this->input->get('itemkeyword');
$flag="oth";    
$url=$this->config->item("api_url") . "/api/getledgerbyid.php";
//$post = ['batch_id'=> "2"];
$compId = $this->session->userdata('id');
$finyear = $this->session->userdata('finyear');

$post=array("flag"=>$flag,"itemkeyword"=>$itemkeyword,"compId"=>$compId);
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
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
$url=$this->config->item("api_url") . "/api/productlist/lbyid";
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
if($ldgerArray) {
return $ldgerArray[0]['account_name'];
}
else
{
return $ldgerArray;
}
//var_dump($ldgerArray);
/*foreach ($ldgerArray as $key => $value) {
    # code...
 
 return $value['name'];
 
} */

}



function getledgerdatasearchbyname($name)
{
$data_array=array();

$itemkeyword= $name; 
//var_dump($itemkeyword);
$flag="gen";
$compId = $this->session->userdata('id');
$data_array = array("flag"=>$flag, "itemkeyword"=>$itemkeyword,"compId"=>$compId);
//$id = $this->input->get('id');    
$url=$this->config->item("api_url") . "/api/productlist/ldgbyname";
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
return $ldgerArray;

}



}


