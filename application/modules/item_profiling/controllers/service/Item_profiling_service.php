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
		$this->ipsModel->item_id = $this->input->post('item_id');
		$this->ipsModel->unit_id = $this->input->post('unit_id');
		// $this->ipsModel->unit_price = $this->input->post('unit_price');
		$this->ipsModel->threshold = $this->input->post('threshold');

		$response = $this->ipsModel->save_item_profile();
		echo json_encode($response);

	}

	public function update_item_profile(){
		$this->ipsModel->id = $this->input->post('id');

		$this->ipsModel->item_id = $this->input->post('item_id');
		$this->ipsModel->unit_id = $this->input->post('unit_id');
		// $this->ipsModel->unit_price = $this->input->post('unit_price');
		$this->ipsModel->threshold = $this->input->post('threshold');

		$response = $this->ipsModel->update_item_profile();
		echo json_encode($response);

	}
}
