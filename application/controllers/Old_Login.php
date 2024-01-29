<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {



    public function __construct(){
        parent::__construct();
  //     $this->load->model('common_model');

//        $this->load->model('login_model');
    $this->load->library('curl');
$this->secret="JVA@123";
$this->username="admin";
$this->password="1234";
$this->headers = array(
         'Authorization: Basic '. base64_encode($this->username.':'.$this->password),
         'X-API-Key: '.$this->secret
);

    }



public function index()
{
	$this->load->view('login');
}


public function validate_user()
{
$email = $this->input->post('InputEmail');
$password = $this->input->post('InputPassword');
$finyear = $this->input->post('finyear');
$data=array();

//$result = $this->curl->simple_get($url);
//var_dump($result);

        /* API URL */

//$url = $this->config->item("login_url") . "/api/login.php"; //?email=" . $email . "&password=" . $password;
///$url = $this->config->item("login_url") . "/api/users/validateLogin";
 //?email=" . $email . "&password=" . $password;

$data_array= array("email"=>$email,"password"=>$password,"finyear"=>$finyear);

//var_dump($data_array);
$url = $this->config->item("login_url") . "/api/users/validateLogin";

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);

curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_array));
  $response = curl_exec($ch);
        curl_close($ch);

echo $response;


}





function fetchFinyear()
{
    $url = $this->config->item("login_url") . "/api/finyear";
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

$finobj = json_decode($fresult,true);
var_dump($finobj);
foreach ($finobj as $value) {
$option .= '<option value="'.$value['finyear'].'">'.$value['finyear'].'</option>';

}
echo $option;
}


function log()
{

$id= $this->input->get('id');
$userid=$this->input->get('userid');
$login=$this->input->get('email');
$finyear=$this->input->get('finyear');
$authkey=$this->input->get('authkey');

$this->headers = array(
         
         'X-API-Key: '.$authkey
);


$furl = $this->config->item("login_url") . "/api/finyear/" . $finyear;
$ch = curl_init($furl);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$finresult = curl_exec($ch);
//var_dump($finresult);
curl_close($ch);
if($finresult)
{
$finArray = json_decode($finresult, true);    
    $s_date = $finArray["start_date"];
    $e_date = $finArray["end_date"];
    $active_year = $finArray["active_year"];
}

/*
$url = $this->config->item("api_url") . "/api/keys/" . $userid;
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);

$kresult = curl_exec($ch);
curl_close($ch);
*/

$url = $this->config->item("login_url") . "/api/company/" . $id;
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$cresult = curl_exec($ch);
curl_close($ch);

            //-- if valid
//var_dump($cresult);
if($cresult){

$data = array();

$phpArray = json_decode($cresult, true);

                   $data = array(
                        'userid' => $userid,
                   		'login'=>$login,
                        'id' => $phpArray['id'],
                        'cname' =>  $phpArray['company_name'],
                        'cadd' =>  $phpArray['company_address'],
                        'email' =>  $phpArray['company_email'],
                        'cstatecode' =>  $phpArray['company_statecode'],
                        'city' =>  $phpArray['company_city'],
                        'pincode' =>  $phpArray['company_pincode'],
                        'gstin' =>  $phpArray['company_gstin'],
                        'contact' =>  $phpArray['company_contact'],
                        'cbankdetails' =>  $phpArray['company_bankdetails'],
                        'ecomm' => $phpArray['ecomm'],
                        'startdate' =>$s_date,
                        'enddate' =>$e_date,
                        'finyear' =>$finyear,
                        'authkey'=>$authkey,
                        'is_login' => TRUE
                    ); 
//var_dump($data);                   
                  $this->session->set_userdata($data);
	                    $url = base_url('dashboard');

	   if(!empty($login))
	    {
				redirect(base_url() . 'dashboard', 'refresh');
			}
			else
			{
			 $this->logout();	
			}
            
        }
        else
        {
        	$data = array();
        	$this->session->sess_destroy();
            $this->session->set_userdata(array('login' => '', 'is_login' => ''));    	
            $this->load->view('login');
        }



}



    function logout(){
        $this->session->sess_destroy();
    // null the session (just in case):
    $this->session->set_userdata(array('login' => '', 'is_login' => ''));
    redirect(base_url() . 'login', 'refresh');
        //$this->load->view('login');
    }



}
