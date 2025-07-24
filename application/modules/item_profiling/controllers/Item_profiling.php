<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Item_profiling extends MY_Controller
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
			'Item_profiling/Item_profiling_model' => 'ipModel',
		];
		$this->load->model($model_list);
	}

	/** load main page */
	public function index(){
		$this->data['units'] = $this->ipModel->get_units();
		$this->data['items'] = $this->ipModel->get_items();
		$this->data['content'] = 'index';
		$this->load->view('layout', $this->data);
	}

	public function load_item_profiles(){
		$this->data['items_profiles'] = $this->ipModel->get_item_profiles();
		$this->data['content'] = 'grid/items_profile_grid';
		$this->load->view('layout', $this->data);
	}

}
