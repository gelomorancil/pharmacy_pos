<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Report extends MY_Controller
{
	private $data = [];
	protected $session;
	public function __construct()
	{
		parent::__construct();
		$this->session = (object) get_userdata(USER);

		// if(is_empty_object($this->session)){
		// 	redirect(base_url().'login/authentication', 'refresh');
		// }

		$model_list = [
			'report/Report_model' => 'rModel',
			'inventory/Inventory_model' => 'iModel',

		];
		$this->load->model($model_list);
	}

	/** load main page */

	public function index()
	{
		$this->data['items_profiles'] = $this->iModel->get_item_profiles();
		$this->data['content'] = 'index';
		$this->load->view('layout', $this->data);
	}

	public function load_sales_report()
	{
		$date_range = $this->input->post('date_range');
		$date_parts = explode('-', $date_range);

		$date_from = trim($date_parts[0]);
		$date_to = trim($date_parts[1]);

		$date_from_formatted = DateTime::createFromFormat('M d, Y', $date_from)->format('Y-m-d 00:00:00');
		$date_to_formatted = DateTime::createFromFormat('M d, Y', $date_to)->format('Y-m-d 23:59:59');

		$this->rModel->date_from = $date_from_formatted;
		$this->rModel->date_to = $date_to_formatted;
		$this->rModel->load_type = $this->input->post('load_type');

		$this->data['sales'] = $this->rModel->get_sales();
		$this->data['content'] = 'grid/load_sales';
		$this->load->view('layout', $this->data);
	}

	public function load_inventory_report()
	{
		$date_range = $this->input->post('date_range');
		$date_parts = explode('-', $date_range);

		$date_from = trim($date_parts[0]);
		$date_to = trim($date_parts[1]);

		$date_from_formatted = DateTime::createFromFormat('M d, Y', $date_from)->format('Y-m-d 00:00:00');
		$date_to_formatted = DateTime::createFromFormat('M d, Y', $date_to)->format('Y-m-d 23:59:59');

		$this->rModel->date_from = $date_from_formatted;
		$this->rModel->date_to = $date_to_formatted;

		// var_dump( $this->rModel->get_inventory());
		$this->data['inventory'] = $this->rModel->get_inventory();
		$this->data['content'] = 'grid/load_inventory';
		$this->load->view('layout', $this->data);
	}

	public function load_individual_items()
	{
		$this->data['items'] = $this->input->post('children_array');
		$this->data['content'] = 'grid/load_individual_items';
		$this->load->view('layout', $this->data);
	}

	public function load_receipt()
	{
		$this->data['control_number'] = $this->input->post('control_number');
		$this->data['sub_total'] = $this->input->post('sub_total');
		$this->data['discount_amount'] = $this->input->post('discount_amount');
		$this->data['total_amount'] = $this->input->post('total_amount');
		$this->data['discount_type'] = $this->input->post('discount_type');
		$this->data['buyer_name'] = $this->input->post('buyer_name');
		$this->data['date_created'] = $this->input->post('date_created');

		$this->data['items'] = $this->input->post('data_array');
		$this->data['content'] = 'grid/receipt_58mm';
		$this->load->view('layout', $this->data);
	}

	/**
	 * execute the batch file that opens cash drawer (windows environment)
	 * The file is stored under assets/uploaded/open_cashdrawer_usb.bat
	 * and will be invoked with exec().
	 * The client javascript calls this via AJAX after printing a receipt.
	 */
	public function open_drawer()
	{
		// path to the bat file relative to the document root
		$batPath = FCPATH . 'assets/uploaded/open_cashdrawer_usb.bat';

		if (!file_exists($batPath)) {
			// respond with error JSON so caller can log/notify if needed
			echo json_encode(['success' => false, 'error' => 'batch file not found']);
			return;
		}

		// run the batch file. return code 0 usually means success.
		// suppress output to avoid leaking data to response.
		exec(escapeshellarg($batPath) . ' 2>&1', $output, $returnVar);

		if ($returnVar === 0) {
			echo json_encode(['success' => true]);
		} else {
			echo json_encode(['success' => false, 'output' => $output, 'code' => $returnVar]);
		}
	}

	public function profitloss()
	{
		$this->data['content'] = 'profitloss';
		$this->load->view('layout', $this->data);
	}

	public function load_profitloss_report()
	{
		$date_range = $this->input->post('date_range');
		$date_parts = explode('-', $date_range);

		$date_from = trim($date_parts[0]);
		$date_to = trim($date_parts[1]);

		$date_from_formatted = DateTime::createFromFormat('M d, Y', $date_from)->format('Y-m-d 00:00:00');
		$date_to_formatted = DateTime::createFromFormat('M d, Y', $date_to)->format('Y-m-d 23:59:59');

		$this->rModel->date_from = $date_from_formatted;
		$this->rModel->date_to = $date_to_formatted;
		// $this->rModel->load_type = $this->input->post('load_type');

		$this->data['expenses'] = $this->rModel->get_expenses();
		$this->data['get_sales'] = $this->rModel->total_sales();
		$this->data['get_purchases'] = $this->rModel->get_purchases();
		$this->data['content'] = 'grid/load_profitloss_report';
		$this->load->view('layout', $this->data);
	}

}
