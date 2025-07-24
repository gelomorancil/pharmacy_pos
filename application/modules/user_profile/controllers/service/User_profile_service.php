<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_profile_service extends MY_Controller
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
			'user_profile/service/User_profile_services_model' => 'upsModel'
		];
		$this->load->model($model_list);
	}

	public function authenticate_user()
	{
		$this->upsModel->pass = $this->input->post("pass");
		$this->upsModel->uname = $this->input->post("uname");
		$response = $this->upsModel->authenticate_user();
		echo json_encode($response);
	}

	public function change_pass()
	{
		$this->upsModel->uname = $this->input->post("uname");
		$this->upsModel->new = $this->input->post("new");
		$this->upsModel->r_new = $this->input->post("r_new");
		$response = $this->upsModel->change_pass();
		echo json_encode($response);
	}


}
