<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Top_buyers extends MY_Controller
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
			'top_buyers/Top_buyers_model' => 'TModel',
		];
		$this->load->model($model_list);
	}

	/** load main page */

	public function index()
	{
		$this->data['content'] = 'index';
		$this->load->view('layout', $this->data);
	}

	public function load_top_buyers()
	{
		$date = $this->input->post('date');
		$this->TModel->date = $date;
		$this->data['buyers'] = $this->TModel->get_top_buyers();
		$this->data['content'] = 'grid/load_top_buyers';
		$this->load->view('layout', $this->data);
	}

}
