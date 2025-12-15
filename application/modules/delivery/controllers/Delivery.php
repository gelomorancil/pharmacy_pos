<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Delivery extends MY_Controller
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
			'inventory/Inventory_model' => 'iModel',
			'Item_profiling/Item_profiling_model' => 'ipModel',
			'delivery/Delivery_model' => 'dModel',	
		];
		$this->load->model($model_list);
	}

	/** load main page */
	public function index()
	{
		// $this->data['PO_num'] = $this->iModel->get_last_po();
		$this->data['units'] = $this->ipModel->get_units();
		$this->data['items_profiles'] = $this->iModel->get_item_profiles();
		$this->data['supplier'] = $this->iModel->get_suppliers();
		$this->data['content'] = 'index';
		$this->load->view('layout', $this->data);
	}

	public function load_po_list(){
		$this->data['purchase_order'] = $this->dModel->get_po_list();
		$this->data['content'] = 'grid/load_po_list';
		$this->load->view('layout', $this->data);
	}

	public function approve_delivery() {
		  // Get raw JSON data from POST
		  $rawData = $this->input->post('data');
		  $payload = json_decode($rawData, true);
  
		//   if (empty($payload)) {
		// 	  echo json_encode(['status' => 'error', 'message' => 'Invalid or missing data.']);
		// 	  return;
		//   }
  
		  $po_number     = $payload['po_number'];
		//   echo $po_number;
		  $date_in       = $payload['date_in'];
		//   $supplier_id   = $payload['supplier_id'];
		  $received_by   = $payload['received_by'];
		  $received_date = $payload['received_date'];
		  $order_items   = $payload['order_items'];
		  $freight   = $payload['freight'];
  
		  // Example parent data — adjust column names to your DB structure
		  $delivery_data = [
			//   'po_number'      => $po_number,
			  'date_approved'  => $date_in,
			  'received_by'    => $received_by,
			  'freight'    => $freight,
			  'approved' => 1
		  ];
  
		  $this->db->trans_start(); // Begin transaction
  
		  // Insert delivery header
		  $po_ID = $this->dModel->insert_delivery_header($delivery_data,$po_number);
		  
		  // Loop through order items
		  foreach ($order_items as $item) {
			  $item_data = [
				  'po_ID'   => $po_ID,
				  'date_expiry'   => !empty($item['date_expiry']) ? $item['date_expiry'] : null,
				  'received_qty'  => $item['received_qty'],
				  'received_pcs'  => $item['pcs_value'],
				//   'received_pcs'  => $item['received_pcs'],
				  'damaged_pcs'   => $item['damaged_pcs'],
				  'batch_no'  => $item['batch_number'],
				  'unit_price'  => $item['unit_price'],
			  ];
  
			  $this->dModel->update_po_item($item_data, $item['item_id']);
		  }


		//   add to inventory stock

  
		  $this->db->trans_complete(); // Commit or rollback
  
		  if ($this->db->trans_status() === FALSE) {
			  echo json_encode(['status' => 'error', 'message' => 'Transaction failed.']);
		  } else {
			  echo json_encode(['status' => 'success']);
		  }
	  }

	public function validate_user()
	{
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$auth = $this->dModel->authenticate_user($username, $password);

		if (!$auth['has_error']) {
			echo json_encode(['status' => 'success', 'message' => 'Authentication successful.']);
		} else {
			echo json_encode(['status' => 'error', 'message' => $auth['message']]);
		}
	}
}