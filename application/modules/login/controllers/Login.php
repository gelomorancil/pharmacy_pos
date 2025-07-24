<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends MY_Controller
{


	private $data = [];
	protected $session;
	public function __construct()
	{
		parent::__construct();
		$this->session = (object)get_userdata(USER);
	}

	public function index()
	{
		redirect(base_url() . 'login/authentication', 'refresh');
	}

	public function authentication()
	{	
		unset_userdata(USER);
		$this->data['content'] = 'index';
		$this->load->view($this->data['content'], $this->data);
	}
}
