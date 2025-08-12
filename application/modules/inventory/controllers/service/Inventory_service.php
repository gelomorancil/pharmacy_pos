<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Inventory_service extends MY_Controller
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
			'inventory/service/Inventory_services_model' => 'isModel'
		];
		$this->load->model($model_list);
	}

	public function save_stock_in()
	{
		$this->isModel->item = $this->input->post("item");
		$this->isModel->supplier = $this->input->post("supplier");
		$this->isModel->quantity = $this->input->post("quantity");
		$this->isModel->date_in = $this->input->post("date_in");
		$this->isModel->po_number = $this->input->post("po_number");
		$this->isModel->recieved_by = $this->input->post("recieved_by");

		$response = $this->isModel->save_stock_in();
		echo json_encode($response);
	}
}
