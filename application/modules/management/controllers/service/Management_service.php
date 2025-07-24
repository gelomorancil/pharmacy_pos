<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Management_service extends MY_Controller
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
			'management/service/Management_services_model' => 'msModel'
		];
		$this->load->model($model_list);
	}

	public function save_list()
	{
		$this->msModel->item_name = $this->input->post("item_name");
		$this->msModel->item_code = $this->input->post("item_code");
		$this->msModel->short_name = $this->input->post("short_name");
		$this->msModel->description = $this->input->post("description");
		$this->msModel->status = $this->input->post("status");

		$response = $this->msModel->save_list();
		echo json_encode($response);
	}

	public function save_user()
	{
		$this->msModel->FName = $this->input->post("FName");
		$this->msModel->LName = $this->input->post("LName");
		$this->msModel->Username = $this->input->post("Username");
		$this->msModel->Role = $this->input->post("Role");
		$this->msModel->Role_name = $this->input->post("Role_name");
		// $this->msModel->Branch = $this->input->post("Branch");
		$response = $this->msModel->save_user();
		echo json_encode($response);
	}

	public function update_user()
	{
		$this->msModel->user_id = $this->input->post("user_id");
		$this->msModel->FName = $this->input->post("FName");
		$this->msModel->LName = $this->input->post("LName");
		$this->msModel->Username = $this->input->post("Username");
		$this->msModel->Role = $this->input->post("Role");
		$this->msModel->Role_name = $this->input->post("Role_name");
		// $this->msModel->Branch = $this->input->post("Branch");
		$response = $this->msModel->update_user();
		echo json_encode($response);
	}

	public function reset()
	{
		$this->msModel->U_ID = $this->input->post("U_ID");
		$response = $this->msModel->reset();
		echo json_encode($response);
	}

	public function delete_user()
	{
		$this->msModel->U_ID = $this->input->post("U_ID");
		$response = $this->msModel->delete_user();
		echo json_encode($response);
	}

	public function update_item()
	{
		$this->msModel->item_id = $this->input->post("id");
		$this->msModel->item_name = $this->input->post("item_name");
		$this->msModel->item_code = $this->input->post("item_code");
		$this->msModel->short_name = $this->input->post("short_name");
		$this->msModel->description = $this->input->post("description");
		$this->msModel->status = $this->input->post("status");

		$response = $this->msModel->update_item();
		echo json_encode($response);
	}

	public function save_supplier()
	{
		$this->msModel->supplier_name = $this->input->post("supplier_name");
		$this->msModel->supplier_address = $this->input->post("supplier_address");
		$this->msModel->contact_person = $this->input->post("contact_person");
		$this->msModel->contact_number_1 = $this->input->post("contact_number_1");
		$this->msModel->contact_number_2 = $this->input->post("contact_number_2");
		$this->msModel->supplier_email = $this->input->post("supplier_email");
		$this->msModel->supplier_status = $this->input->post("supplier_status");

		$response = $this->msModel->save_supplier();
		echo json_encode($response);
	}

	public function update_supplier()
	{
		$this->msModel->supplier_id = $this->input->post("id");

		$this->msModel->supplier_name = $this->input->post("supplier_name");
		$this->msModel->supplier_address = $this->input->post("supplier_address");
		$this->msModel->contact_person = $this->input->post("contact_person");
		$this->msModel->contact_number_1 = $this->input->post("contact_number_1");
		$this->msModel->contact_number_2 = $this->input->post("contact_number_2");
		$this->msModel->supplier_email = $this->input->post("supplier_email");
		$this->msModel->supplier_status = $this->input->post("supplier_status");

		$response = $this->msModel->update_supplier();
		echo json_encode($response);
	}

	public function save_unit()
	{
		$this->msModel->unit = $this->input->post("unit");

		$response = $this->msModel->save_unit();
		echo json_encode($response);
	}

	public function delete_unit(){
		$this->msModel->unit_id = $this->input->post("id");

		$response = $this->msModel->delete_unit();
		echo json_encode($response);
	}

}
