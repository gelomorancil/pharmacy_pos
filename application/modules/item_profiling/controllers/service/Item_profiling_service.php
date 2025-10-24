<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Item_profiling_service extends MY_Controller
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
			'item_profiling/service/Item_profiling_service_model' => 'ipsModel'
		];
		$this->load->model($model_list);
	}

	public function save_item_profile(){
		// $this->ipsModel->item_id = $this->input->post('item_id');
		// $this->ipsModel->unit_id = $this->input->post('unit_id');
		$this->ipsModel->unit_price = $this->input->post('unit_price');
		$this->ipsModel->threshold = $this->input->post('threshold');
		$this->ipsModel->walkin_price = $this->input->post('walkin_price');
		$this->ipsModel->wholesale_price = $this->input->post('wholesale_price');

		$response = $this->ipsModel->save_item_profile();
		echo json_encode($response);

	}

	public function update_item_profile(){
		$this->ipsModel->id = $this->input->post('id');

		// $this->ipsModel->item_id = $this->input->post('item_id');
		// $this->ipsModel->unit_id = $this->input->post('unit_id');
		$this->ipsModel->unit_price = $this->input->post('unit_price');
		$this->ipsModel->threshold = $this->input->post('threshold');
		$this->ipsModel->walkin_price = $this->input->post('walkin_price');
		$this->ipsModel->regular_stub_price = $this->input->post('regular_stub_price');
		$this->ipsModel->regular_box_price = $this->input->post('regular_box_price');
		$this->ipsModel->walkin_stub_price = $this->input->post('walkin_stub_price');
		$this->ipsModel->walkin_box_price = $this->input->post('walkin_box_price');
		// $this->ipsModel->wholesale_price = $this->input->post('wholesale_price');

		$response = $this->ipsModel->update_item_profile();
		echo json_encode($response);

	}
}
