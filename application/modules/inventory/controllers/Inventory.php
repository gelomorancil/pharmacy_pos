<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Inventory extends MY_Controller
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
			'inventory/Inventory_model' => 'iModel',
			'Item_profiling/Item_profiling_model' => 'ipModel',
		];
		$this->load->model($model_list);
	}

	/** load main page */
	public function index(){
		$this->data['PO_num'] = $this->iModel->get_last_po();
		$this->data['units'] = $this->ipModel->get_units();
		$this->data['items_profiles'] = $this->iModel->get_item_profiles();
		$this->data['supplier'] = $this->iModel->get_suppliers();
		$this->data['content'] = 'index';
		$this->load->view('layout', $this->data);
	}

	public function load_inventory(){
		$this->data['inventory'] = $this->iModel->get_inventory();
		$this->data['content'] = 'grid/load_inventory';
		$this->load->view('layout', $this->data);
	}

	public function load_history(){
		$this->iModel->id = $this->input->post("id");

		$this->data['history'] = $this->iModel->get_history();
		$this->data['content'] = 'grid/load_inventory_history';
		$this->load->view('layout', $this->data);
	}

}
