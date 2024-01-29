<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function __construct(){
        parent::__construct();
        check_login_user();
        
    //   $this->load->model('common_model');
    //   $this->load->model('login_model');
$this->secret= $this->session->userdata('authkey');

$this->headers = array(
         
         'X-API-Key: '. $this->secret
);
    
   


    }

    public function index(){
        $data = array();

        $data['purchase'] = json_decode($this->purchaseTotal());
        $data['sales'] = json_decode($this->salesTotal());
        $data['salesbypersons'] = $this->revenueSource();
//var_dump($data);
        $data['page'] = 'Dashboard';
        $this->load->view('dashboard', $data);
    }


public function userRegister()
{
$url = $this->config->item("api_url") . "/api/userregister.php"; //?email=" . $email . "&password=" . $password;
$firstname = "SK ENTERPRISES";
$lastname  = "CHENNAI";
$email = "skenterprisesjoy@gmail.com";
$password = "ske123@";
$compId = $this->session->userdata('id');
$data_array= array("firstname"=>$firstname,"lastname"=>$lastname,"email"=>$email,"password"=>$password,"compId"=>$compId);
 $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_array));
  $result = curl_exec($ch);
  curl_close($ch);

echo $result;

}




function purchaseTotal()
{
// Total Purhcase for the month
$cur_date = date('Y-m-d');
$expdt = explode("-", $cur_date);
$st_date = $expdt[0] . "-" . $expdt[1] . "-01";
$start_date = date('Y-m-d',strtotime($st_date));
$end_date = date('Y-m-t', strtotime($st_date));
$compId= $this->session->userdata('id');
$finyear = $this->session->userdata('finyear');
//var_dump($start_date . $end_date);




$data=array();    
$compId = $this->session->userdata('id');
$finyear = $this->session->userdata('finyear');
$trans_type="PURC";
//var_dump($compId . $finyear); 
$url=$this->config->item("api_url") . "/api/productlist/getcurmonthtransaction";
$data = array("finyear"=>$finyear,"compId"=>$compId,"trans_type"=>$trans_type,"start_date"=>$start_date,"end_date"=>$end_date);
//$post = ['batch_id'=> "2"];
//var_dump($data);
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

  $currmonthresponse = curl_exec($ch);
  //$result = json_decode($response);
 // var_dump($currmonthresponse);
return $currmonthresponse;

curl_close($ch); // Close the connection






}

function salesTotal()
{
// Total Sales for the month
$cur_date = date('Y-m-d');
$expdt = explode("-", $cur_date);
$st_date = $expdt[0] . "-" . $expdt[1] . "-01";
$start_date = date('Y-m-d',strtotime($st_date));
$end_date = date('Y-m-t', strtotime($st_date));
$compId= $this->session->userdata('id');
$finyear = $this->session->userdata('finyear');
//var_dump($start_date . $end_date);




$data=array();    
$compId = $this->session->userdata('id');
$finyear = $this->session->userdata('finyear');
$trans_type="SALE";
//var_dump($compId . $finyear); 
$url=$this->config->item("api_url") . "/api/productlist/getcurmonthtransaction";
$data = array("finyear"=>$finyear,"compId"=>$compId,"trans_type"=>$trans_type,"start_date"=>$start_date,"end_date"=>$end_date);
//$post = ['batch_id'=> "2"];
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

  $currmonthresponse = curl_exec($ch);
  //$result = json_decode($response);
return $currmonthresponse;

curl_close($ch); // Close the connection


}


function changeFinyear()
{
$nfinyear= $this->input->get('newfinyear');
//var_dump($nfinyear);
 $this->session->set_userdata('finyear', $nfinyear);
$finyear = $this->session->userdata('finyear');
//var_dump($finyear);
return $finyear;
}

function fetchFinyear()
{
    $url = $this->config->item("api_url") . "/api/finyear";
//$url = $this->config->item("login_url") . "/api/finyear";
    var_dump($url);
    $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
//curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_array));
$fresult = curl_exec($ch);
var_dump($fresult);
curl_close($ch);
$option="";
$finyear = $this->session->userdata('finyear');
$finobj = json_decode($fresult,true);
var_dump($finobj);
foreach ($finobj as $value) {
if($finyear==$value['finyear'])
{
$option .= '<option selected value="'.$value['finyear'].'">'.$value['finyear'].'</option>';
}
else
{
 $option .= '<option value="'.$value['finyear'].'">'.$value['finyear'].'</option>'; 
}
}
echo $option;
}



public function getmsalespurhcase()
{

$compId = $this->session->userdata('id');
$finyear = $this->session->userdata('finyear');
$trans_type="PURC";
$url=$this->config->item("api_url") . "/api/productlist/getmonthwisedata";
$data = array("finyear"=>$finyear,"compId"=>$compId,"trans_type"=>$trans_type);
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

 $presponse = curl_exec($ch);
  //$result = json_decode($response);
//echo $presponse;

curl_close($ch); // Close the connection
//echo $presponse;
$pdata = json_decode($presponse,TRUE);
if($pdata)
{
  $tbl='';
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

  foreach ($pdata as $key => $value) {
  //var_dump($value['oct']);
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
    $tot= $tot+$apr+$may+$jun+$jul+$aug+$sep+$oct+$nov+$dec+$jan+$feb+$mar;
    # code...
    $tbl .='<tr><td style="font-weight:bold;">Purhcase</td><td style="text-align:right;">'. $value['apr'] .'</td><td style="text-align:right;">'. $value['may'] .'</td><td style="text-align:right;">'. $value['jun'] .'</td><td style="text-align:right;">'. $value['jul'] .'</td><td style="text-align:right;">'. $value['aug'] .'</td><td style="text-align:right;">'. $value['sep'] .'</td><td style="text-align:right;">'. $value['oct'] .'</td><td style="text-align:right;">'. $value['nov'] .'</td><td style="text-align:right;">'. $value['dec'] .'</td><td style="text-align:right;">'. $value['jan'] .'</td><td style="text-align:right;">'. $value['feb'] .'</td><td style="text-align:right;">'. $value['mar'] .'</td><td style="text-align:right;font-weight:bold;">'. number_format($tot, 2, '.', '') .'</td></tr>';
  }

}

$trans_type="SALE";











$url=$this->config->item("api_url") . "/api/productlist/getmonthwisedata";
$data = array("finyear"=>$finyear,"compId"=>$compId,"trans_type"=>$trans_type);
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

 $spresponse = curl_exec($ch);
  //$result = json_decode($response);
//echo $salesresponse;

curl_close($ch); // Close the connection
//echo $spresponse;
$spdata = json_decode($spresponse,TRUE);
if($spdata)
{
  
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
  foreach ($spdata as $key => $value) {
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
    $tot= $tot+$apr+$may+$jun+$jul+$aug+$sep+$oct+$nov+$dec+$jan+$feb+$mar;
    # code...
    $tbl .='<tr><td style="font-weight:bold;">Sales</td><td style="text-align:right;">'. $value['apr'] .'</td><td style="text-align:right;">'. $value['may'] .'</td><td style="text-align:right;">'. $value['jun'] .'</td><td style="text-align:right;">'. $value['jul'] .'</td><td style="text-align:right;">'. $value['aug'] .'</td><td style="text-align:right;">'. $value['sep'] .'</td><td style="text-align:right;">'. $value['oct'] .'</td><td style="text-align:right;">'. $value['nov'] .'</td><td style="text-align:right;">'. $value['dec'] .'</td><td style="text-align:right;">'. $value['jan'] .'</td><td style="text-align:right;">'. $value['feb'] .'</td><td style="text-align:right;">'. $value['mar'] .'</td><td style="text-align:right;font-weight:bold;">'. number_format($tot, 2, '.', '') .'</td></tr>';
  }

}
else
{
  $tbl ='No Data';

}
echo $tbl;

}

//GST Monthwise
public function getmgstsalespurhcase()
{

$compId = $this->session->userdata('id');
$finyear = $this->session->userdata('finyear');
$trans_type="PURC";
$url=$this->config->item("api_url") . "/api/productlist/getmonthwisegstdata";
$data = array("finyear"=>$finyear,"compId"=>$compId,"trans_type"=>$trans_type);
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

 $presponse = curl_exec($ch);
  //$result = json_decode($response);
//echo $salesresponse;

curl_close($ch); // Close the connection
//echo $presponse;
$pdata = json_decode($presponse,TRUE);
if($pdata)
{
  $tbl='';
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
  foreach ($pdata as $key => $value) {
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
    $tot= $tot+$apr+$may+$jun+$jul+$aug+$sep+$oct+$nov+$dec+$jan+$feb+$mar;
    # code...
    $tbl .='<tr><td style="font-weight:bold;">Purhcase</td><td style="text-align:right;">'. $value['apr'] .'</td><td style="text-align:right;">'. $value['may'] .'</td><td style="text-align:right;">'. $value['jun'] .'</td><td style="text-align:right;">'. $value['jul'] .'</td><td style="text-align:right;">'. $value['aug'] .'</td><td style="text-align:right;">'. $value['sep'] .'</td><td style="text-align:right;">'. $value['oct'] .'</td><td style="text-align:right;">'. $value['nov'] .'</td><td style="text-align:right;">'. $value['dec'] .'</td><td style="text-align:right;">'. $value['jan'] .'</td><td style="text-align:right;">'. $value['feb'] .'</td><td style="text-align:right;">'. $value['mar'] .'</td><td style="text-align:right;font-weight:bold;">'. number_format($tot, 2, '.', '') .'</td></tr>';
  }

}

$trans_type="SALE";


$url=$this->config->item("api_url") . "/api/productlist/getmonthwisegstdata";
$data = array("finyear"=>$finyear,"compId"=>$compId,"trans_type"=>$trans_type);
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

 $spresponse = curl_exec($ch);
  //$result = json_decode($response);
//echo $salesresponse;

curl_close($ch); // Close the connection
//echo $spresponse;
$spdata = json_decode($spresponse,TRUE);
if($spdata)
{
  
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
  foreach ($spdata as $key => $value) {
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
    $tot= $tot+$apr+$may+$jun+$jul+$aug+$sep+$oct+$nov+$dec+$jan+$feb+$mar;
    # code...
    $tbl .='<tr><td style="font-weight:bold;">Sales</td><td style="text-align:right;">'. $value['apr'] .'</td><td style="text-align:right;">'. $value['may'] .'</td><td style="text-align:right;">'. $value['jun'] .'</td><td style="text-align:right;">'. $value['jul'] .'</td><td style="text-align:right;">'. $value['aug'] .'</td><td style="text-align:right;">'. $value['sep'] .'</td><td style="text-align:right;">'. $value['oct'] .'</td><td style="text-align:right;">'. $value['nov'] .'</td><td style="text-align:right;">'. $value['dec'] .'</td><td style="text-align:right;">'. $value['jan'] .'</td><td style="text-align:right;">'. $value['feb'] .'</td><td style="text-align:right;">'. $value['mar'] .'</td><td style="text-align:right;font-weight:bold;">'. number_format($tot, 2, '.', '') .'</td></tr>';
  }

}
echo $tbl;
//var_dump($tbl);

$url=$this->config->item("api_url") . "/api/productlist/getmonthwiseitcdata";
$data = array("finyear"=>$finyear,"compId"=>$compId);
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);

  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

 $spresponse = curl_exec($ch);
  //$result = json_decode($response);
//echo $salesresponse;

curl_close($ch); // Close the connection
//echo $spresponse;
//var_dump($spresponse);
  $tbl='';

$spdata = json_decode($spresponse,TRUE);
//var_dump($spdata);

if($spdata)
{
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
 // var_dump($spdata);
  foreach ($spdata as $key => $value) {
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
    $tot= $tot+$apr+$may+$jun+$jul+$aug+$sep+$oct+$nov+$dec+$jan+$feb+$mar;
    # code...
    $tbl .='<tr><td style="font-weight:bold;">ITC Availed</td><td style="text-align:right;font-weight:bold;">'. $value['apr'] .'</td><td style="text-align:right;font-weight:bold;">'. $value['may'] .'</td><td style="text-align:right;font-weight:bold;">'. $value['jun'] .'</td><td style="text-align:right;font-weight:bold;">'. $value['jul'] .'</td><td style="text-align:right;font-weight:bold;">'. $value['aug'] .'</td><td style="text-align:right;font-weight:bold;">'. $value['sep'] .'</td><td style="text-align:right;font-weight:bold;">'. $value['oct'] .'</td><td style="text-align:right;font-weight:bold;">'. $value['nov'] .'</td><td style="text-align:right;font-weight:bold;">'. $value['dec'] .'</td><td style="text-align:right;font-weight:bold;">'. $value['jan'] .'</td><td style="text-align:right;font-weight:bold;">'. $value['feb'] .'</td><td style="text-align:right;font-weight:bold;">'. $value['mar'] .'</td><td style="text-align:right;font-weight:bold;">'. number_format($tot, 2, '.', '') .'</td></tr>';
  }

}



echo $tbl;

}




function revenueSource()
{
// Total Sales Source for the month    

}





}
