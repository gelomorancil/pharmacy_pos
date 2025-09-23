<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Quotation extends MY_Controller
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
            'quotation/Quotation_model' => 'quotation',
            'inventory/Inventory_model' => 'iModel',
            'Item_profiling/Item_profiling_model' => 'ipModel',
        ];
        $this->load->model($model_list);
    }

    public function index()
    {
        $this->data['content'] = 'index';
        $this->load->view('layout', $this->data);
    }

    public function create()
    {
        $this->data['quotation_no'] = $this->quotation->get_quotation_no();
        $this->data['units'] = $this->ipModel->get_units();
        $this->data['items_profiles'] = $this->iModel->get_item_profiles();
        $this->data['content'] = 'quotation';
        $this->load->view('layout', $this->data);
    }

    public function load_quotation()
    {
        $this->data['q_list'] = $this->quotation->get_quotations();
        $this->data['content'] = 'grid/load_quotation';
        $this->load->view('layout', $this->data);
    }

    public function view()
    {
        $id = $this->input->get('qID');
        $this->data['quotation'] = $this->quotation->get_quotation($id);
        $this->data['content'] = 'view_quotation';
        $this->load->view('layout', $this->data);
    }

    public function load_quotation_items()
    {
        $id = $this->input->get('qID');
        var_dump($this->quotation->get_quotation_items($id));
        $this->data['items'] = $this->quotation->get_quotation_items($id);
        $this->data['content'] = 'grid/load_q_items';
        $this->load->view('layout', $this->data);
    }

    // service methods
    public function save()
    {
        // read raw JSON body
        $json = trim($this->input->raw_input_stream);
        $data = json_decode($json, true);

        header('Content-Type: application/json');

        if (!$data || !isset($data['items']) || !is_array($data['items']) || count($data['items']) == 0) {
            echo json_encode(['success' => false, 'message' => 'Invalid payload or items missing.']);
            return;
        }

        // basic sanitation / defaults
        $quotation_no = isset($data['quotation_no']) && $data['quotation_no'] !== '' ? $this->db->escape_str($data['quotation_no']) : $this->generate_quotation_no();
        $subtotal = floatval($data['subtotal'] ?? 0);
        $freight = floatval($data['freight'] ?? 0);
        $total = floatval($data['total'] ?? ($subtotal + $freight));

        // Begin transaction
        $this->db->trans_begin();

        $quotation_insert = [
            'quotation_no' => $quotation_no,
            'subtotal' => $subtotal,
            'freight' => $freight,
            'total' => $total,
            // date_added uses default CURRENT_TIMESTAMP
        ];

        $quotation_id = $this->quotation->insert_quotation($quotation_insert);

        if (!isset($quotation_id) || is_null($quotation_id)) {
            $this->db->trans_rollback();
            echo json_encode(['success' => false, 'message' => 'Failed to insert quotation.']);
            return;
        }

        // prepare items for batch insert
        $items_to_insert = [];
        foreach ($data['items'] as $it) {
            // map fields, providing safe defaults
            $item_id = isset($it['item_id']) ? intval($it['item_id']) : 0;
            $unit_price = isset($it['unit']) ? floatval($it['unit']) : 0.0;

            // unit_ID: if your modal sends a numeric unit id use it; otherwise fallback to 0.
            $unit_ID = isset($it['unit_id']) ? intval($it['unit_id']) : 0;

            $qty = isset($it['qty']) ? intval($it['qty']) : 0;
            $pcs = isset($it['pcs']) ? intval($it['pcs']) : 0;
            $descr = isset($it['desc']) ? $this->db->escape_str($it['desc']) : '';

            $items_to_insert[] = [
                'item_ID' => $item_id,
                'unit_price' => $unit_price,
                'unit_ID' => $unit_ID,
                'qo_ID' => intval($quotation_id), // store quotation id in qo_ID column
                'qty' => $qty,
                'po_descr' => substr($descr, 0, 255),
                'pcs' => $pcs
            ];
        }

        if (count($items_to_insert) > 0) {
            $this->quotation->insert_items_batch($items_to_insert);
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            echo json_encode(['success' => false, 'message' => 'Transaction failed, items not saved.']);
            return;
        }

        $this->db->trans_commit();
        echo json_encode(['success' => true, 'quotation_id' => intval($quotation_id), 'quotation_no' => $quotation_no]);
    }

    private function generate_quotation_no()
    {
        // simple generation: Q-YYYYMMDD-UNIQ
        return 'Q-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -6));
    }

    public function delete_quotation()
    {
        $id = $this->input->post('ID');

        if (!$id) {
            echo json_encode(['success' => false, 'message' => 'Invalid ID']);
            return;
        }

        $this->load->model('Quotation_model');

        if ($this->Quotation_model->delete($id)) {
            echo json_encode(['success' => true, 'message' => 'Quotation deleted successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to delete quotation.']);
        }
    }

    public function approve_quotation()
    {
        $id = $this->input->post('ID');

        if (!isset($id)) {
            echo json_encode(['success' => false, 'message' => 'Invalid ID']);
            return;
        }

        $this->load->model('Quotation_model');

        if ($this->Quotation_model->approve($id)) {
            echo json_encode(['success' => true, 'message' => 'Quotation approved successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to approve quotation.']);
        }
    }

}