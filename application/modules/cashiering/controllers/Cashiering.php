<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cashiering extends MY_Controller
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
			'Cashiering/Cashiering_model' => 'cModel',
		];
		$this->load->model($model_list);
	}

	/** load main page */
	public function index()
	{
		// $this->data['units'] = $this->cModel->get_units();
		// $this->data['items'] = $this->cModel->get_items();
		$this->data['content'] = 'index';
		$this->load->view('layout', $this->data);
	}

	public function load_scanned_items()
	{
		// $this->data['items_profiles'] = $this->ipModel->get_item_profiles();
		$this->data['content'] = 'grid/scanned_items_grid';
		$this->load->view('layout', $this->data);
	}

	public function check_item_code()
	{
		$this->cModel->item_code = $this->input->post('item_code');

		$response = $this->cModel->check_item_code();
		echo json_encode($response);
	}

	public function load_inventory()
	{
		$this->data['inventory'] = $this->cModel->get_inventory();
		$this->data['content'] = 'grid/load_inventory';
		$this->load->view('layout', $this->data);
	}

	public function check_item_stock()
	{
		$this->cModel->item_code = $this->input->post('item_code');
		$this->cModel->quantity = $this->input->post('quantity');
		$this->cModel->current_quantity = $this->input->post('current_quantity');

		$response = $this->cModel->check_item_stock();
		echo json_encode($response);
	}

	public function load_receipt()
	{
		// var_dump($this->input->post('data_array'));
		$this->data['control_number'] = $this->input->post('control_number');
		$this->data['sub_total'] = $this->input->post('sub_total');
		$this->data['discount_amount'] = $this->input->post('discount_amount');
		$this->data['total_amount'] = $this->input->post('total_amount');
		$this->data['discount_type'] = $this->input->post('discount_type');
		$this->data['remarks'] = $this->input->post('remarks') ? $this->input->post('remarks') : '-';

		$this->data['items'] = $this->input->post('data_array');
		$this->data['content'] = 'grid/receipt_58mm';
		$this->load->view('layout', $this->data);
	}

	public function check_stock_status()
	{
		$this->cModel->item_code = $this->input->post('item_code');

		$response = $this->cModel->check_stock_status();
		echo json_encode($response);
	}

}
