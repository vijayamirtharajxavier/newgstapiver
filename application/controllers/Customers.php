<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Customers extends CI_Controller {

	public function __construct(){
        parent::__construct();
        check_login_user();

    //   $this->load->model('common_model');
    //   $this->load->model('login_model');
    }

    public function index(){
        $data = array();
        $data['page'] = 'Customers List';
        $this->load->view('customers_list', $data);
    }


}
