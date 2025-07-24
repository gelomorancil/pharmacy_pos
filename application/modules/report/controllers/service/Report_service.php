<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Report_service extends MY_Controller
{
	private $data = [];
	protected $session;
	public function __construct()
	{
		parent::__construct();
		$this->session = (object)get_userdata(USER);

		// if(is_empty_object($this->session)){
		// 	redirect(base_url().'login/authentication', 'refresh');
		// }

		$model_list = [
			'report/service/Report_services_model' => 'rsModel'
		];
		$this->load->model($model_list);
	}

	public function void_transaction(){
		$this->rsModel->pParentID = $this->input->post("pParentID");
		$response = $this->rsModel->void();
		echo json_encode($response);
	}

	// public function verify(){
	// 	$this->rsModel->Payment_ID = $this->input->post("Payment_ID");
	// 	$response = $this->rsModel->verify();
	// 	echo json_encode($response);
	// }
}
