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

	public function get_expenses()
	{
		$date_range = trim($this->input->post('date_range'));

		// ✅ DEFAULT: today
		if (empty($date_range) || strpos($date_range, ' - ') === false) {

			$today = date('Y-m-d');

			$this->eModel->date_from = $today . ' 00:00:00';
			$this->eModel->date_to   = $today . ' 23:59:59';

		} else {

			$date_parts = explode(' - ', $date_range);

			$date_from = trim($date_parts[0]);
			$date_to   = trim($date_parts[1]);

			$fromObj = DateTime::createFromFormat('F d, Y', $date_from);
			$toObj   = DateTime::createFromFormat('F d, Y', $date_to);

			// Extra safety fallback
			if (!$fromObj || !$toObj) {
				$today = date('Y-m-d');
				$this->eModel->date_from = $today . ' 00:00:00';
				$this->eModel->date_to   = $today . ' 23:59:59';
			} else {
				$this->eModel->date_from = $fromObj->format('Y-m-d 00:00:00');
				$this->eModel->date_to   = $toObj->format('Y-m-d 23:59:59');
			}
		}

		$this->data['expenses'] = $this->eModel->get_expenses();
		$this->data['content']  = 'grid/load_expenses';
		$this->load->view('layout', $this->data);
	}



	public function get_expense_details(){
		$this->eModel->exp_id = $this->input->post("exp_id");
		$this->data['exp_details'] = $this->eModel->get_expense_details();
		$response = $this->eModel->get_expense_details();
		echo json_encode($response);
	}
}
