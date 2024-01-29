<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends CI_Controller {
var $secret;
	public function __construct(){
        parent::__construct();
        check_login_user();
        $this->load->library('curl');
    //   $this->load->model('common_model');
    //   $this->load->model('login_model');
        $this->secret= $this->session->userdata('authkey');
$this->headers = array(
         'X-API-Key: '.$this->secret
);

    }

    public function index(){
        $data = array();
        $data['page'] = 'Products List';
        $this->load->view('products_list', $data);
    }





function getledgerdatabyname()
{

$itemkeyword = $this->input->get('itemkeyword');
$flag="oth";    
//$url=$this->config->item("api_url") . "/api/getledgerbyid.php";
$url=$this->config->item("api_url") . "/api/ledger/keyword/".$itemkeyword . "/" . $compId;
//$post = ['batch_id'=> "2"];
$compId = $this->session->userdata('id');
$finyear = $this->session->userdata('finyear');

//$post=array("flag"=>$flag,"itemkeyword"=>$itemkeyword,"compId"=>$compId);
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
//  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
  $response = curl_exec($ch);
  //$result = json_decode($response);
  curl_close($ch); // Close the connection
$ldgerArray = json_decode($response, true);

echo $response;

}



public function getProductUnit()
{
$url=$this->config->item("api_url") . "/api/units";
$headers = array(
         'Authorization: Basic '. base64_encode($this->username.':'.$this->password),
         'X-API-Key: '.$this->secret
);
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  
curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
//var_dump($headers);
  //curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
  $response = curl_exec($ch);
 // var_dump($response);
  //$result = json_decode($response);
  curl_close($ch); // Close the connection
$unitArray = json_decode($response, true);
//$character = json_decode($data);
//print_r($response);
$data=array();
$option="";
foreach ($unitArray as $key => $value) {
$option .= '<option value="'.$value['unit_id'].'">'.$value['unit_name'].'</option>';

}
echo $option;

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
//$url=$this->config->item("api_url") . "/api/getproductsbykeyword.php";
$url=$this->config->item("api_url") . "/api/product/keyword/". $itemkeyword . "/" . $compId;
//$post = ['batch_id'=> "2"];
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  $response = curl_exec($ch);
  //$result = json_decode($response);
 
  curl_close($ch); // Close the connection
$ldgerArray = json_decode($response,true);
$item_data=array();
echo $response;
}



public function getproductdatabykeyword()
{
$data_array=array();

$itemkeyword= $this->input->get('itemkeyword'); 
//var_dump($itemkeyword);
$finyear = $this->session->userdata('finyear');

$compId = $this->session->userdata('id');
//$data_array = array("itemkeyword"=>$itemkeyword,"compId"=>$compId,"finyear"=>$finyear);
//$id = $this->input->get('id');
$url=$this->config->item("api_url") . "/api/product/keyword/". $itemkeyword . "/" . $compId;    
//$url=$this->config->item("api_url") . "/api/getallproductsbykeyword.php";
//$post = ['batch_id'=> "2"];
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  $response = curl_exec($ch);
  //$result = json_decode($response);
 
  curl_close($ch); // Close the connection
$ldgerArray = json_decode($response,true);
$item_data=array();
echo $response;
}




public function getProductforUpdate()
{

$tbl="";    
$id = $this->input->get('id');

//$url=$this->config->item("api_url") . "/api/getsingle_product.php?id=" . $id;
$url=$this->config->item("api_url") . "/api/product/" . $id;

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  //curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
  $response = curl_exec($ch);
  //$result = json_decode($response);
  curl_close($ch); // Close the connection
$prodArray = json_decode($response, true);
//var_dump($prodArray);

//$url=$this->config->item("api_url") . "/api/getunits.php";
//$post = ['batch_id'=> "2"];
$url=$this->config->item("api_url") . "/api/units";
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
/*foreach ($unitArray['units'] as $key => $value) {
$option .= '<option value="'.$value['unit_id'].'">'.$value['unit_name'].'</option>';

}*/

//print_r($prodArray["id"]);



//print_r($prodArray['name']);
$tbl .='<div class="card"><!--Card content-->
    <div class="card-body px-lg-5 pt-0"><div class="form-row"><div class="col"><input type="text" id="recid" name="recid" value="' . $prodArray["id"] . '" hidden ><div class="md-form"><label for="productname">PRODUCT NAME</label><input type="text" id="productname" name="productname" value="' . $prodArray["prod_name"] .'" class="form-control" autocomplete="off" required></div>
                </div><div class="col"><div class="md-form"><label for="productdesc">DESCRIPTION</label><input type="text" value="' . $prodArray["prod_desc"] .'"  id="productdesc" name="productdesc" class="form-control" autocomplete="off"></div></div><div class="col"><div class="md-form"><label for="productdesc">HSNSAC</label><input type="text" id="producthsnsac" value="' . $prodArray["prod_hsnsac"] .'"  autocomplete="off" name="producthsnsac" class="form-control"></div></div><div class="col"><div class="md-form"><label for="productdesc">GST%</label><input type="text" id="productgstpc" value="' . $prodArray["prod_gstpc"] .'" style="text-align:right;" autocomplete="off" name="productgstpc" class="form-control"></div></div><div class="col"><div class="md-form"><label for="productdesc">UNIT</label><br><select id="productunit" name="productunit">';
 foreach ($unitArray as $key => $value) {
    if($prodArray["prod_unit"]==$value["unit_id"])
    {
$tbl .= '<option value="'.$value['unit_id'].'" selected>'.$value['unit_name'].'</option>';
}
else 
{
 $tbl .= '<option value="'.$value['unit_id'].'">'.$value['unit_name'].'</option>';   
}
}
$tbl .='</select></div></div></div><div class="form-row">
                <div class="col"><!-- First name --><div class="md-form"><label for="productmrp">MRP</label><input type="text" value="' . $prodArray["prod_mrp"] .'"  id="productmrp"  style="text-align: right;"  autocomplete="off" name="productmrp" class="form-control"></div></div><div class="col"><div class="md-form"><label for="prodtype">Prod Type</label><select id="producttype"  name="producttype"  class="form-control">';
                if($prodArray['goods_service']=="0")
                {
                  $tbl .= '<option selected value="0">GOODS</option><option  value="1">SERVICES</option>';
                }
                else
                {
                 $tbl .= '<option selected value="1">SERVICES</option><option value="0">GOODS</option>'; 
                }
                $tbl .='</select></div>
                </div><div class="col"><div class="md-form"><label for="cost">Cost</label><input type="text" id="productcost"  style="text-align: right;"  name="productcost"  value="' . $prodArray["prod_cost"] .'"  autocomplete="off" class="form-control"></div>
                </div><div class="col"><div class="md-form"><label for="materialRegisterFormLastName">Rate</label><input type="text"  style="text-align: right;"  id="productrate" value="' . $prodArray["prod_rate"] .'"  autocomplete="off"  name="productrate" class="form-control"></div></div><div class="col"><div class="md-form"><label for="productstock">Stock</label><input type="text" id="productstock" name="productstock" style="text-align: right;"  value="' . $prodArray["prod_stock"] .'"  autocomplete="off" class="form-control"></div></div></div><div class="form-row"><div class="col"><!-- First name --><div class="md-form"><label for="productsku">SKU</label><input type="text" value="' . $prodArray["prod_sku"] .'"   id="productsku" autocomplete="off"  name="productsku" class="form-control"></div></div><div class="col"><div class="md-form"><label for="productbatch">Batch</label><input type="text" value="' . $prodArray["prod_batch"] .'"  id="productbatch" autocomplete="off" name="productbatch" class="form-control"></div>
                </div><div class="col"><div class="md-form"><label for="productexpiry">Expiry</label><input type="text" id="productexpiry" name="productexpiry" value="' . $prodArray["prod_expiry"] .'"  autocomplete="off" class="form-control"></div>
                </div><div class="col"><!-- First name --><div class="md-form"><label for="productmake">Make</label><input type="text" value="' . $prodArray["prod_make"] .'"  autocomplete="off" name="productmake" id="productmake" class="form-control"></div></div><div class="col"><div class="md-form"><label for="productmodel">Model</label><input type="text"  value="' . $prodArray["prod_model"] .'" id="productmodel" autocomplete="off" name="productmodel" class="form-control"></div>
                </div></div></div></div>';



echo $tbl;

}

public function getProduct()
{
//$url=$this->config->item("api_url") . "/api/getallproducts.php";
$url=$this->config->item("api_url") . "/api/product";
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

if($phpArray)
{
//foreach ($phpArray['data'] as $key => $value) {
  foreach ($phpArray as $key => $value) {
    # code...

    //print_r($value['name']);
 $button ='<div class="btn-group">
  <button type="button" class="btn btn-info btn-circle btn-xs center-block" href="#" data-toggle="modal" data-target="#modalEditProduct" onclick="updateProductbyid(' . $value['id'] . ')"><i class="fa fa-edit"></i>
      </button>
&nbsp;
  <button type="button" data-target="#deleteModal" class="btn btn-danger btn-circle btn-xs center-block " 
 href="#" data-toggle="modal"  onclick="deleteUpdate(' . $value['id'] . ')"><i class="fa fa-times"></i>
      </button>

  
</div>'; 

$data['data'][]= array('name'=>$value['prod_name'],'desc'=>$value['prod_desc'],'hsnsac'=>$value['prod_hsnsac'],'gstpc'=>$value['prod_gstpc'],'unit'=>$value['prod_unit'],'mrp'=>$value['prod_mrp'],'cost'=>$value['prod_cost'],'rate'=>$value['prod_rate'],'sku'=>$value['prod_sku'],'batch'=>$value['prod_batch'],'expiry'=>$value['prod_expiry'],'make'=>$value['prod_make'],'model'=>$value['prod_model'],'stock'=>$value['prod_stock'],'action'=>$button);

/*
$data['data'][]= array('name'=>$value['name'],'desc'=>$value['desc'],'hsnsac'=>$value['hsnsac'],'gstpc'=>$value['gstpc'],'unit'=>$value['unit'],'mrp'=>$value['mrp'],'cost'=>$value['cost'],'rate'=>$value['rate'],'sku'=>$value['sku'],'batch'=>$value['batch'],'expiry'=>$value['expiry'],'make'=>$value['make'],'model'=>$value['model'],'stock'=>$value['stock'],'action'=>$button);
*/



}

}
else
{
  $data="No Data";
}
echo json_encode($data);

}



public function editProduct()
{

$data_array=array();

if($this->input->post("recid")===null)
{
  $id = "";
}else{
  $id = $this->input->post("recid");
}


if($this->input->post("productname")===null)
{
  $name = "";
}else{
  $name = $this->input->post("productname");
}

if($this->input->post("productdesc")===null){
  $desc = '';
}else{
  $desc = $this->input->post("productdesc");
}

if($this->input->post("producthsnsac")===null){
  $hsnsac = '';
}else{
  $hsnsac = $this->input->post("producthsnsac");
}
if($this->input->post("productgstpc")===null){
  $gstpc = '';
}else{
  $gstpc = $this->input->post("productgstpc");
}

if($this->input->post("productmrp")===null){
  $mrp = "0.00";
}else{
  $mrp = $this->input->post("productmrp");
}

if($this->input->post("productcost")===null){
  $cost = "0.00";
}else{
  $cost = $this->input->post("productcost");
}
if($this->input->post("productrate")===null){
  $rate = "0.00";
}else{
  $rate = $this->input->post("productrate");
}
if($this->input->post("productbatch")===null){
  $batch = '';
}else{
  $batch = $this->input->post("productbatch");
}
if($this->input->post("productexpiry")===null){
  $expiry = '';
}else{
  $expiry = $this->input->post("productexpiry");
}
if($this->input->post("productmake")===null){
  $make = '';
}else{
  $make = $this->input->post("productmake");
}
if($this->input->post("productmodel")===null){
  $model = '';
}else{
  $model = $this->input->post("productmodel");
}
if($this->input->post("productsku")===null){
  $sku = '';
}else{
  $sku = $this->input->post("productsku");
}
if($this->input->post("productstock")===null){
  $stock = "0.00";
}else{
  $stock = $this->input->post("productstock");
}
$goods_service = $this->input->post("producttype");
$unit = $this->input->post("productunit");

$data_array=array(
    
    "prod_name"=> $name,
    "prod_desc"=>$desc,
    "prod_hsnsac"=>$hsnsac,
    "prod_gstpc"=>$gstpc,
    "prod_unit"=>$unit,
    "prod_batch"=>$batch,
    "prod_mrp"=>$mrp,            
    "prod_cost"=>$cost,
    "prod_rate"=>$rate,
    "prod_sku"=>$sku,
    "prod_expiry"=>$expiry,            
    "prod_make"=>$make,
    "prod_model"=>$model,
    "goods_service"=>$goods_service,
    "prod_stock"=>$stock);
//var_dump($data_array);
//$url=$this->config->item("api_url") . "/api/product_update.php";
$url=$this->config->item("api_url") . "/api/product/" . $id;
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

/*
$data_array =  array(
   "amount" => (string)($lease['amount'] / $tenant_count)
);
$update_plan = callAPI('PUT', 'https://api.example.com/put_url/'.$lease['plan_id'], json_encode($data_array));
$response = json_decode($update_plan, true);
$errors = $response['response']['errors'];
$data = $response['response']['data'][0];

*/


}



public function addProduct()
{
$data_array=array();



if($this->input->post("productname")===null)
{
  $name = "";
}else{
  $name = $this->input->post("productname");
}

if($this->input->post("productdesc")===null){
  $desc = '';
}else{
  $desc = $this->input->post("productdesc");
}

if($this->input->post("producthsnsac")===null){
  $hsnsac = '';
}else{
  $hsnsac = $this->input->post("producthsnsac");
}

if($this->input->post("productgstpc")===null){
  $gstpc = '';
}else{
  $gstpc = $this->input->post("productgstpc");
}

if($this->input->post("productmrp")===null){
  $mrp = "0.00";
}else{
  $mrp = $this->input->post("productmrp");
}

if($this->input->post("productcost")===null){
  $cost = "0.00";
}else{
  $cost = $this->input->post("productcost");
}
if($this->input->post("productrate")===null){
  $rate = "0.00";
}else{
  $rate = $this->input->post("productrate");
}
if($this->input->post("productbatch")===null){
  $batch = '';
}else{
  $batch = $this->input->post("productbatch");
}
if($this->input->post("productexpiry")===null){
  $expiry = '';
}else{
  $expiry = $this->input->post("productexpiry");
}
if($this->input->post("productmake")===null){
  $make = '';
}else{
  $make = $this->input->post("productmake");
}
if($this->input->post("productmodel")===null){
  $model = '';
}else{
  $model = $this->input->post("productmodel");
}
if($this->input->post("productsku")===null){
  $sku = '';
}else{
  $sku = $this->input->post("productsku");
}
if($this->input->post("productstock")===null){
  $stock = "0.00";
}else{
  $stock = $this->input->post("productstock");
}

$goods_service = $this->input->post("goods_service");
$unit = $this->input->post("productunit");

//$url=$this->config->item("api_url") . "/api/product_create.php";
$url=$this->config->item("api_url") . "/api/product";
$compId = $this->session->userdata('id');
$data_array=array(
    "prod_name"=> $name,
    "prod_desc"=>$desc,
    "prod_hsnsac"=>$hsnsac,
    "prod_gstpc"=>$gstpc,
    "prod_unit"=>$unit,
    "prod_batch"=>$batch,
    "prod_mrp"=>$mrp,            
    "prod_cost"=>$cost,
    "prod_rate"=>$rate,
    "prod_sku"=>$sku,
    "prod_expiry"=>$expiry,            
    "prod_make"=>$make,
    "prod_model"=>$model,
    "goods_service"=>$goods_service,
    "prod_stock"=>$stock,
    "company_id"=>$compId);

//var_dump($data_array);
//$make_call = $this->callAPI('POST', $url, json_encode($data_array));

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
//$errors   = $res['response']['errors'];
//$data     = $res['response']['data'][0];

//print_r($data);
}

public function deleteProduct()
{
$id=$this->input->get("id");
$data_array=array("id"=>$id);
//$url=$this->config->item("api_url") . "/api/product_delete.php";
$url=$this->config->item("api_url") . "/api/product/" . $id;
 $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");

  $response = curl_exec($ch);
  //$result = json_decode($response);


  curl_close($ch); // Close the connection

//$res = json_decode($response, true);
echo $response;

//$this->callAPI('DELETE', 'https://apigstsoft.jvait.in/api/product_delete.php', $id);
}


function callAPI($method, $url, $data){
   $curl = curl_init();
   switch ($method){
      case "POST":
         curl_setopt($curl, CURLOPT_POST, 1);
         if ($data)
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
         break;
      case "DELETE":
         curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
         if ($data)
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);                              
         break;

      case "PUT":
         curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
         if ($data)
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);                              
         break;
      default:
         if ($data)
            $url = sprintf("%s?%s", $url, http_build_query($data));
   }
   // OPTIONS:
   curl_setopt($curl, CURLOPT_URL, $url);
   /*curl_setopt($curl, CURLOPT_HTTPHEADER, array(
      'APIKEY: 111111111111111111111',
      'Content-Type: application/json',
   ));*/
   curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
   curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
   // EXECUTE:
   $result = curl_exec($curl);
   if(!$result){die("Connection Failure");}
   curl_close($curl);
   return $result;
}




}
