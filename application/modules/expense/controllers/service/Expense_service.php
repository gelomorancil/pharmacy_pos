<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Expense_service extends MY_Controller
{
	private $data = [];
	protected $session;
	public function __construct()
	{
		parent::__construct();
		$this->session = (object)get_userdata(USER);


		$model_list = [
			'expense/service/Expense_services_model' => 'esModel'
		];
		$this->load->model($model_list);
	}

	public function save(){
		$response = $this->esModel->add_expense();
		echo json_encode($response);
	}

	public function edit(){	
		$response = $this->esModel->edit_expense();
		echo json_encode($response);
	}
	
	public function add_image(){	
		$response = $this->esModel->add_image();
		echo json_encode($response);
	}
	
	public function void(){
		$this->esModel->Expense_ID = $this->input->post("Expense_id");
		$response = $this->esModel->void();
		echo json_encode($response);
	}
}
