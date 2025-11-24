<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Top_items extends MY_Controller
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
			'top_items/Top_items_model' => 'TModel',
		];
		$this->load->model($model_list);
	}

	/** load main page */

	public function index()
	{
		$this->data['content'] = 'index';
		$this->load->view('layout', $this->data);
	}

	public function load_top_items()
	{
		$date = $this->input->post('date');
		$this->TModel->date = $date;
		$this->data['items'] = $this->TModel->get_top_items();
		$this->data['content'] = 'grid/load_top_items';
		$this->load->view('layout', $this->data);
	}

}
