<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cashiering extends MY_Controller
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
			'Cashiering/Cashiering_model' => 'cModel',
		];
		$this->load->model($model_list);
	}

	/** load main page */
	public function index()
	{
		// $this->data['units'] = $this->cModel->get_units();
		$this->data['items'] = $this->cModel->get_items();
		$this->data['buyers'] = $this->cModel->get_buyers();
		$this->data['content'] = 'index';
		$this->load->view('layout', $this->data);
	}

	public function load_scanned_items()
	{
		// $this->data['items_profiles'] = $this->ipModel->get_item_profiles();
		$this->data['content'] = 'grid/scanned_items_grid';
		$this->load->view('layout', $this->data);
	}

	public function check_item_code()
	{
		$this->cModel->item_code = $this->input->post('item_code');

		$response = $this->cModel->check_item_code();
		echo json_encode($response);
	}

	public function load_inventory()
	{
		$this->data['inventory'] = $this->cModel->get_inventory();
		$this->data['content'] = 'grid/load_inventory';
		$this->load->view('layout', $this->data);
	}

	public function check_item_stock()
	{
		$this->cModel->item_code = $this->input->post('item_code');
		$this->cModel->quantity = $this->input->post('quantity');
		$this->cModel->current_quantity = $this->input->post('current_quantity');

		$response = $this->cModel->check_item_stock();
		echo json_encode($response);
	}

	public function load_receipt()
	{
		// var_dump($this->input->post('data_array'));
		$this->data['control_number'] = $this->input->post('control_number');
		$this->data['sub_total'] = $this->input->post('sub_total');
		$this->data['discount_amount'] = $this->input->post('discount_amount');
		$this->data['total_amount'] = $this->input->post('total_amount');
		$this->data['discount_type'] = $this->input->post('discount_type');
		$this->data['transaction_date'] = $this->input->post('transaction_date');
		$this->data['buyer_name'] = $this->input->post('buyer_name');
		$this->data['remarks'] = $this->input->post('remarks') ? $this->input->post('remarks') : '-';

		$this->data['items'] = $this->input->post('data_array');
		$this->data['content'] = 'grid/receipt_58mm';
		$this->load->view('layout', $this->data);
	}

	public function check_stock_status()
	{
		$this->cModel->item_code = $this->input->post('item_code');

		$response = $this->cModel->check_stock_status();
		echo json_encode($response);
	}

	// ADDED FJ NEW FUNCTIONS
	// GETTING THE EFFECTIVE PRICE BASE SA PO QUANTITY 
	public function get_dynamic_price()
	{
		try {
			$item_id = $this->input->post('item_id');
			$quantity = (int)$this->input->post('quantity');
			$base_price = (float)$this->input->post('base_price');
			$cart_qty = (int)$this->input->post('cart_qty') ?? 0; // Current qty in cart

			if (!$item_id || !$quantity) {
				echo json_encode(['success' => false, 'price' => $base_price, 'error' => 'Missing parameters']);
				return;
			}

			// Get raw prices for debugging
			$tiers = $this->cModel->get_price_tiers($item_id);
			$effective_price = $this->cModel->calculate_effective_price($item_id, $quantity, $base_price, $cart_qty);
			
			echo json_encode([
				'success' => true,
				'price' => $effective_price,
				'base_price' => $base_price,
				'quantity' => $quantity,
				'cart_qty' => $cart_qty,
				'item_id' => $item_id,
				'tiers' => $tiers
			]);
		} catch (Exception $e) {
			echo json_encode([
				'success' => false,
				'error' => $e->getMessage(),
				'trace' => $e->getTraceAsString()
			]);
		}
	}

	// ADDED FJ
	// CALCULATING RECEIVED_PCS(purchase_order_items) - QUANTITY(tbl_payment_child)
	public function get_available_stock()
	{
		try {
			$item_id = (int)$this->input->post('item_id');
			$cart_qty = (int)$this->input->post('cart_qty') ?? 0; // Current qty in cart
			
			if (!$item_id) {
				echo json_encode(['success' => false, 'available' => 0, 'error' => 'Item ID missing']);
				return;
			}

			$available = $this->cModel->get_available_stock($item_id, $cart_qty);
			
			echo json_encode([
				'success' => true,
				'available' => $available,
				'item_id' => $item_id,
				'cart_qty' => $cart_qty
			]);
		} catch (Exception $e) {
			echo json_encode([
				'success' => false,
				'available' => 0,
				'error' => $e->getMessage()
			]);
		}
	}

}
