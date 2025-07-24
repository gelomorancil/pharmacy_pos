<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Change_password extends MY_Controller
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
		$this->data['username'] = get_userdata(USER)["Username"];
		$this->data['content'] = 'index';
		$this->load->view($this->data['content'], $this->data);
	}
}
