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

	public function save_stock_in_po()
	{
		$this->isModel->supplier = $this->input->post("supplier");
		$this->isModel->date_in = $this->input->post("date_in");
		$this->isModel->recieved_by = $this->input->post("recieved_by");
		$this->isModel->po_number = $this->input->post("po_number");
		$this->isModel->items = $this->input->post("items"); // this is the array we passed via AJAX

		$response = $this->isModel->save_stock_in_po();	
		
		echo json_encode($response);
	}

	public function update_po()
{
    $data = json_decode($this->input->raw_input_stream, true);

    if (empty($data['po_number']) || empty($data['items'])) {
        show_error("Invalid request", 400);
    }

    try {
        $this->isModel->update_po_with_items($data);
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(['message' => 'Updated successfully']));
    } catch (Exception $e) {
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(['error' => $e->getMessage()]));
    }
}

	public function remove_po_item(){
		$this->isModel->id = $this->input->post("id");
		$response = $this->isModel->remove_po_item();
		echo json_encode($response);
	}

	public function approve_po(){
		$this->isModel->po_number = $this->input->post("po_number");
		$response = $this->isModel->approve_po();
		echo json_encode($response);
	}

	public function delete_po(){
		$this->isModel->po_number = $this->input->post("po_number");
		$response = $this->isModel->delete_po();
		echo json_encode($response);
	}
}
