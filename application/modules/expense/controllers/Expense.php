<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Expense extends MY_Controller
{
	private $data = [];
	protected $session;
	public function __construct()
	{
		parent::__construct();
		$this->session = (object)get_userdata(USER);

		$model_list = [
			'expense/Expense_model' => 'eModel',
		];
		$this->load->model($model_list);
	}

	/** load main page */
	public function index()
	{
		$this->data['content'] = 'index';
		$this->load->view('layout', $this->data);
	}

	public function get_expenses() {
        $this->eModel->d_from = $this->input->post("d_from");
		$this->eModel->d_to = $this->input->post("d_to");
		$this->eModel->branch = $this->input->post("branch");
		
		$this->data['expenses'] = $this->eModel->get_expenses();
		$this->data['content'] = 'grid/load_expenses';
		$this->load->view('layout', $this->data);
	}

	public function get_expense_details(){
		$this->eModel->exp_id = $this->input->post("exp_id");
		$this->data['exp_details'] = $this->eModel->get_expense_details();
		$response = $this->eModel->get_expense_details();
		echo json_encode($response);
	}
}
