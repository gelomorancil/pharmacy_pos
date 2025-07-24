<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Management extends MY_Controller
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
			'management/Management_model' => 'mModel',
		];
		$this->load->model($model_list);
	}

	/** load main page */
	public function index()
	{
		$this->data['session'] =  $this->session;
		$this->data['content'] = 'list_management';
		$this->load->view('layout', $this->data);
	}

	public function load_items_drop_down(){
		$this->data['items'] =  $this->mModel->get_items_active();
		$this->data['content'] = 'components/items_drop_down';
		$this->load->view('layout', $this->data);
	}

	public function load_supplier_drop_down(){
		$this->data['suppliers'] =  $this->mModel->get_suppliers_active();
		$this->data['content'] = 'components/supplier_drop_down';
		$this->load->view('layout', $this->data);
	}

	public function load_unit_drop_down(){
		$this->data['units'] =  $this->mModel->get_units();
		$this->data['content'] = 'components/unit_drop_down';
		$this->load->view('layout', $this->data);
	}

	public function user_management()
	{
		$this->data['user_role'] = $this->mModel->get_user_role();
		
		$this->data['content'] = 'user_management';
		$this->load->view('layout', $this->data);

		
	}

	public function load_items()
	{
		$this->data['items'] = $this->mModel->get_items();
		$this->data['content'] = 'grid/items_grid';
		$this->load->view('layout', $this->data);
	}

	public function load_suppliers()
	{
		$this->data['suppliers'] = $this->mModel->get_suppliers();
		$this->data['content'] = 'grid/suppliers_grid';
		$this->load->view('layout', $this->data);
	}

	public function load_units()
	{
		$this->data['units'] = $this->mModel->get_units();
		$this->data['content'] = 'grid/unit_grid';
		$this->load->view('layout', $this->data);
	}

	public function load_user()
	{
		$this->data['user'] = $this->mModel->get_user();
		$this->data['content'] = 'grid/list_user';
		$this->load->view('layout', $this->data);
	}
	
	public function get_user_details(){
		$this->mModel->user_id = $this->input->post("user_id");
		$this->data['user_details'] = $this->mModel->get_user_for_edit();
		$response = $this->mModel->get_user_for_edit();
		echo json_encode($response);
	}

	public function get_list_details(){
		$this->mModel->list_id = $this->input->post("list_id");
		$this->data['list_details'] = $this->mModel->get_list_details();
		$response = $this->mModel->get_list_details();
		echo json_encode($response);
	}
}
