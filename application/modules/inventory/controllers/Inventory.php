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
		var_dump($this->data['inventory']);
		$this->data['content'] = 'grid/load_inventory';
		$this->load->view('layout', $this->data);
	}

	public function load_history(){
		$this->iModel->id = $this->input->post("id");

		$this->data['history'] = $this->iModel->get_history();
		$this->data['content'] = 'grid/load_inventory_history';
		$this->load->view('layout', $this->data);
	}

	public function load_po(){
		$po_num = $this->input->get("pon");
		$this->iModel->po = $po_num;
		// $po_num = "000000";
		$this->data['po'] = $this->iModel->get_po_header($po_num);
		$this->data['supplier_deets'] = $this->iModel->get_supplier_data($this->data['po']->supplier_ID);
		$this->data['po_items'] = $this->iModel->get_po_items($po_num);
		$this->data['content'] = 'purchase_order';
		$this->load->view('layout', $this->data);
	}

	public function load_po_list(){
		$this->data['purchase_order'] = $this->iModel->get_po_list();
		$this->data['content'] = 'grid/load_po_list';
		$this->load->view('layout', $this->data);
	}

	public function get_po_details()
    {
		$po_number = $this->input->get('pon');
        if (!$po_number) {
            show_error('PO number is required', 400);
        }
		$header = $this->iModel->get_po_header($po_number);
		$items  = $this->iModel->get_po_items($po_number);
	
		$result = [
			'header' => $header,
			'items'  => $items
		];

        if ($result) {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($result));
        } else {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode([]));
        }
    }

	public function fill_in_item () {
		$item_ID = $this->input->post('item_ID');
		$response = $this->iModel->get_item_data($item_ID);
		echo json_encode($response);
	}

}
