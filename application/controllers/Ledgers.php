<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Ledgers extends CI_Controller {

	public function __construct(){
        parent::__construct();
        check_login_user();
        $this->load->library('curl');
        $this->load->helper('form','url');

    //   $this->load->model('common_model');
    //   $this->load->model('login_model');
        $this->secret= $this->session->userdata('authkey');
$this->headers = array(
      
         'X-API-Key: '.$this->secret
);
  

    }

    public function index(){
        $data = array();
        $data['page'] = 'Ledgers List';
        $this->load->view('ledger_list', $data);
    }

    public function openbal(){
        $data = array();
        $data['page'] = 'Opening Balance - Ledger Accounts';
        $this->load->view('opbal_list', $data);
    }


		public function getledgerdatabyname()
		{
		$flag = $this->input->get('flag');
		$compId = $this->session->userdata('id');
		$finyear = $this->session->userdata('finyear');
		
		$itemkeyword = rawurlencode($this->input->get('itemkeyword'));    
		$url=$this->config->item("api_url") . "/api/productlist/ldg_keyword/" . $itemkeyword . "/" . $compId ;
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
		
		public function getopenbal()
		{
		$compId = $this->session->userdata('id');
		$finyear = $this->session->userdata('finyear');
		$trans_type="SALE";
		//getTax breakup
		$url=$this->config->item("api_url") . "/api/productlist/get_opbal";
		
		$data = array("finyear"=>$finyear,"compId"=>$compId);
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL,$url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
			curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
		
			$opresponse = curl_exec($ch);
			//$result = json_decode($response);
		//echo $taxesbyidresponse;
		//var_dump($opresponse);
		curl_close($ch); // Close the connection
		
		
		
		$phpArray = json_decode($opresponse, true);
		//$character = json_decode($data);
		//print_r($phpArray);
		$data=array();
		$i=0;
		
		echo json_encode($phpArray);
		
		}
		


public function deleteOpbalbyid()
{
	$id = $this->input->get('id');
	$compId = $this->session->userdata('id');
	$finyear = $this->session->userdata('finyear');

	$del_array = array("delflag"=>"1","company_id"=>$compId,"finyear"=>$finyear,"ldger_id"=>$id);
	//var_dump($del_array);
	$url=$this->config->item("api_url") . "/api/productlist/delete_OpBal";

	$ch = curl_init($url);
	 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
	curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($del_array));
	
	$response = curl_exec($ch);
	if(curl_errno($ch)) {
			echo 'Error: ' . curl_error($ch);
	} else {
			echo $response;
	}
	curl_close($ch);
	
	
}



		public function updateOpBal()
		{
		$compId = $this->session->userdata('id');
		$finyear = $this->session->userdata('finyear');
			$open_bal = $this->input->post('openbal_amt');
			$acct_id = $this->input->post('acct_id');
		//	$cnt = count($this->input->post('acid'));
		
			$data=array();
		 //var_dump($opdata);
		$data  = array("ldger_id"=>$acct_id,"open_bal"=>$open_bal,"finyear"=>$finyear,"company_id"=>$compId,"delflag"=>0);
		// echo json_encode($data);
		//	var_dump($data);
		$url=$this->config->item("api_url") . "/api/productlist/insertOpBal";
		
		$ch = curl_init($url);
		 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
		
		$response = curl_exec($ch);
		if(curl_errno($ch)) {
				echo 'Error: ' . curl_error($ch);
		} else {
				echo $response;
		}
		curl_close($ch);
		
	}
		
		



public function getLedgerGroup()
{
//$url=$this->config->item("api_url") . "/api/getgroup.php";
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
//$character = json_decode($data);
//print_r($response);
$data=array();
$option="";
foreach ($groupArray as $key => $value) {
$option .= '<option value="'.$value['id'].'">'.$value['group_name'].'</option>';

}
echo $option;

}


public function getStates()
{
//$url=$this->config->item("api_url") . "/api/getstates.php";
$url=$this->config->item("api_url") . "/api/state";
//$post = ['batch_id'=> "2"];
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  $response = curl_exec($ch);
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
$compId = $this->session->userdata('id');
$tbl="";    
$id = $this->input->get('id');

//$url=$this->config->item("api_url") . "/api/getsingle_ledger.php";
$url=$this->config->item("api_url") . "/api/ledger/" . $id;

//?id=" . $id;
$post= array("id"=>$id,"compId"=>$compId);
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
 // curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
  $response = curl_exec($ch);
  //var_dump($response);
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
                <div class="col"><!-- First name --><div class="md-form"><input type="text" id="recid" name="recid" value="' . $ledgerArray["id"] . '" hidden ><label for="ledgername">LEDGER ACCOUNT NAME</label><input oninput="this.value = this.value.toUpperCase()" type="text" value="' . $ledgerArray["account_name"] . '" id="ledgername" name="ledgername" class="form-control" autocomplete="off" required></div></div><div class="col"><!-- Last name --><div class="md-form"><label for="ledgergstin">GSTIN NUMBER</label><input type="text" oninput="this.value = this.value.toUpperCase()"  id="ledgergstin" name="ledgergstin"  value="' . $ledgerArray["account_gstin"] . '"  class="form-control" autocomplete="off"></div></div><div class="col"><!-- Last name --><div class="md-form"><label for="ledgeraddress">ADDRESS</label><input type="text" oninput="this.value = this.value.toUpperCase()"  id="ledgeraddress"  value="' . $ledgerArray["account_address"] . '"  autocomplete="off" name="ledgeraddress" class="form-control"></div></div><div class="col"><!-- Last name --><div class="md-form"><label for="ledgergroup">GROUP</label><br>
                        <select id="ledgergroup" class="form-control" name="ledgergroup">';

foreach ($groupArray as $key => $value) {
  if($ledgerArray["account_groupid"]==$value["id"])
    {
$tbl .= '<option value="'.$value['id'].'" selected>'.$value['group_name'].'</option>';
}
else 
{
 $tbl .= '<option value="'.$value['id'].'">'.$value['group_name'].'</option>';   
}
}

                        $tbl .='</select></div></div></div><div class="form-row"><div class="col"><!-- First name --><div class="md-form"><label for="ledgercity">CITY</label><input type="text" id="ledgercity" oninput="this.value = this.value.toUpperCase()"   style="text-align: right;" autocomplete="off"  value="' . $ledgerArray["account_city"] . '" name="ledgercity" class="form-control"></div></div><div class="col"><!-- Last name --><div class="md-form"><label for="ledgerstate">STATE</label><br><select id="ledgerstate" oninput="this.value = this.value.toUpperCase()"  style="width: 250px; height: 20px;" name="ledgerstate">';
foreach ($stateArray as $key => $value) {
  if($ledgerArray["account_statecode"]==$value["id"])
    {
$tbl .= '<option value="'.$value['statecode_id'].'" selected>'.$value['state_name'].'</option>';
}
else 
{
 $tbl .= '<option value="'.$value['statecode_id'].'">'.$value['state_name'].'</option>';   
}
}


                        $tbl .='</select></div></div><div class="col"><!-- Last name --><div class="md-form"><label for="ledgercontact">CONTACT#</label><input type="text"  style="text-align: right;"  id="ledgercontact" autocomplete="off"   name="ledgercontact" oninput="this.value = this.value.toUpperCase()" value="' . $ledgerArray["account_contact"] . '"   class="form-control"></div></div><div class="col"><!-- Last name --><div class="md-form"><label for="ledgeremail">EMAIL</label><input type="email" id="ledgeremail"  value="' . $ledgerArray["account_email"] . '" name="ledgeremail" oninput="this.value = this.value.toUpperCase()"  style="text-align: right;"  autocomplete="off" class="form-control"></div></div></div><div class="form-row"><div class="col"><!-- First name --><div class="md-form"><label for="ledgerbustype">BUSINESS TYPE</label><select class="form-control" id="bus_type" name="bus_type"><option value="0">Regular</option>
                          <option value="1">Store</option>';


                          $tbl .= '</select></div></div><div class="col"><!-- Last name --><div class="md-form"><label for="ledgerpan">PAN#</label><input type="text" id="ledgerpan" oninput="this.value = this.value.toUpperCase()"  autocomplete="off" name="ledgerpan" value="' . $ledgerArray["account_pan"] . '"  class="form-control"></div></div><div class="col"><!-- Last name --><div class="md-form"><label for="ledgeropenbal">OPENING BALANCE</label><input style="text-align: right;" type="text"  value="' . $ledgerArray["account_openbal"] . '" id="ledgeropenbal" name="ledgeropenbal" autocomplete="off" value="0.00" class="form-control"></div></div></div><input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>"></div></div>';



echo $tbl;

}

public function getLedger()
{
//$url=$this->config->item("api_url") . "/api/getallledgers.php";
$url=$this->config->item("api_url") . "/api/ledger";
//$post = ['batch_id'=> "2"];
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  $response = curl_exec($ch);
  //var_dump($response);
  //$result = json_decode($response);
  curl_close($ch); // Close the connection


//var_dump($response);

$phpArray = json_decode($response, true);
//$character = json_decode($data);
//print_r($phpArray);
$data=array();
foreach ($phpArray as $key => $value) {
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

if($value['bus_type']=="0")
{
    $bustype="Regular";
}
else
{
    $bustype="Store";
}



$data['data'][]= array('name'=>$value['account_name'],'address'=>$value['account_address'],'gstin'=>$value['account_gstin'],'city'=>$value['account_city'],'statecode'=>$value['account_statecode'],'groupid'=>$value['account_groupid'],'groupname'=>$value['account_groupid'],'contact'=>$value['account_contact'],'bustype'=>$bustype, 'email'=>$value['account_email'],'pan'=>$value['account_pan'],'openbal'=>$value['account_openbal'],'action'=>$button);




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

        if($this->input->post("ledgerstatecode")===null)
        {
        $statecode="";

        }
        else
        {
        $statecode=$this->input->post("ledgerstatecode");            
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

        if($this->input->post("ledgerstate")===null)
        {
        $statecode="";

        }
        else
        {
        $statecode=$this->input->post("ledgerstate");

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
        "id"=> $id,
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
        "bus_type" =>$bustype,
        "account_statecode" =>$statecode,
        "account_openbal"=> $openbal);

//var_dump($data_array);
//$url=$this->config->item("api_url") . "/api/ledger_update.php";
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

        if($this->input->post("ledgerstatecode")===null)
        {
        $statecode="";

        }
        else
        {
        $statecode=$this->input->post("ledgerstatecode");            
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

        if($this->input->post("ledgerstate")===null)
        {
        $statecode="";

        }
        else
        {
        $statecode=$this->input->post("ledgerstate");

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
$compId = $this->session->userdata('id');
$finyear = $this->session->userdata('finyear');

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
        "bus_type" =>$bustype,
        "account_statecode" =>$statecode,
        "account_openbal"=> $openbal,
        "company_id"=>$compId);


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
//print_r($data);
}

public function deleteLedger()
{
$data_array=array();
$id=$this->input->get("id");
$data_array=array("id"=>$id);
//$url=$this->config->item("api_url") . "/api/ledger_delete.php";
$url=$this->config->item("api_url") . "/api/ledger/" . $id;
 $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");  
  //curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_array));
  $response = curl_exec($ch);
  //$result = json_decode($response);


  curl_close($ch); // Close the connection

//$res = json_decode($response, true);
echo $response;

//$this->callAPI('DELETE', 'https://apigstsoft.jvait.in/api/Ledger_delete.php', $id);
}





}
