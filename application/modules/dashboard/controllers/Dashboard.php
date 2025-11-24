<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends MY_Controller
{
	private $data = [];
	protected $session;
	public function __construct()
	{
		parent::__construct();
		$this->session = (object) get_userdata(USER);

		if (is_empty_object($this->session)) {
			redirect(base_url() . 'login/authentication', 'refresh');
		}

		$model_list = [
			'dashboard/Dashboard_model' => 'dModel',
		];
		$this->load->model($model_list);
	}

	/** load main page */
	public function index()
	{
		$this->data['session'] = $this->session;
		$this->data['content'] = 'index';
		$this->load->view('layout', $this->data);
	}

	public function load_inventory()
	{
		$this->data['inventory'] = $this->dModel->get_inventory();
		$this->data['content'] = 'grid/load_inventory';
		$this->load->view('layout', $this->data);
	}

	public function load_top_items()
	{
		$this->dModel->date = $this->input->post('date');
		$this->data['items'] = $this->dModel->get_top_items();

		$this->data['content'] = 'grid/load_top_items';
		$this->load->view('layout', $this->data);
	}

	public function load_top_items_chart()
	{
		$this->dModel->date = $this->input->post('date');
		$this->data['items'] = $this->dModel->get_top_items();
		$this->data['content'] = 'grid/load_top_items_chart';
		$this->load->view('layout', $this->data);
	}

	public function load_monthly_sales()
	{
		$this->dModel->year = $this->input->post('year');
		$this->data['monthly'] = $this->dModel->get_monthly_sales();
		$this->data['content'] = 'grid/load_monthly_sales';
		$this->load->view('layout', $this->data);
	}

	public function load_top_buyers()
	{
		$this->dModel->date = $this->input->post('date');
		$this->data['buyers'] = $this->dModel->get_top_buyers();

		$this->data['content'] = 'grid/load_top_buyers';
		$this->load->view('layout', $this->data);
	}
}
