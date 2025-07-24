
<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Change_password_service extends MY_Controller
{
	protected $session;
	public function __construct()
	{
		parent::__construct();
		$this->session = (object)get_userdata(USER);

		$modelList = [
			'change_password/Change_password_model' => 'change_pass',
		];

		$this->load->model($modelList);
	}


	public function index()
	{
		echo 'error';
	}

	public function change_password(){
		$this->change_pass->username = $this->input->post('username', true);
		$this->change_pass->current_password = $this->input->post('current_pass', true);
		$this->change_pass->new_password = $this->input->post('new_pass', true);

		$response = $this->change_pass->change_password();
		echo json_encode($response);
	}

}
