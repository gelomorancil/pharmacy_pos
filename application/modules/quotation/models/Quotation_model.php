
<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Quotation_model extends CI_Model
{
    public $Table;
    public function __construct()
    {
        parent::__construct();
        $this->session = (object)get_userdata(USER);

        // if(is_empty_object($this->session)){
        // 	redirect(base_url().'login/authentication', 'refresh');
        // }

        $model_list = [];
        $this->load->model($model_list);
        $this->Table = json_decode(TABLE);
    }

    public function insert_quotation($data)
    {
        $this->db->insert('tbl_quotation', $data);
        return $this->db->insert_id();
    }

    public function insert_items_batch($items)
    {
        if (empty($items)) return 0;
        $this->db->insert_batch('tbl_quotation_items', $items);
        return $this->db->affected_rows();
    }

    public function get_quotation_no()
    {
        $this->db->select('quotation_no');
        $this->db->from('tbl_quotation');
        $this->db->order_by('ID', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $row = $query->row();
            $last_qn = $row->quotation_no;
            $new_qn = intval($last_qn) + 1;
            return str_pad($new_qn, 6, '0', STR_PAD_LEFT);
        } else {
            return '000000';
        }
    }

    public function get_quotations()
    {
        $this->db->select('*');
        $this->db->from('tbl_quotation');
        $this->db->order_by('ID', 'DESC');
        $this->db->order_by('approved', '0');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_quotation_items($quotation_id)
    {
        $this->db->select('qi.*, i.item_name, qi.po_descr,u.unit_of_measure');
        $this->db->from('tbl_quotation_items qi');
        $this->db->join('tbl_items i', 'qi.item_ID = i.ID', 'left');
        $this->db->join('tbl_unit u', 'qi.unit_ID = u.ID', 'left');
        $this->db->where('qi.ID', $quotation_id);
        $query = $this->db->get();
        return $query->result();
    }
    public function get_quotation($id)
    {
        $this->db->select('*');
        $this->db->from('tbl_quotation');
        $this->db->where('ID', $id);
        $query = $this->db->get();
        return $query->row();
    }

    public function delete($id)
    {
        // Delete quotation items first to avoid orphan rows
        $this->db->where('qo_ID', $id);
        $this->db->delete('tbl_quotation_items');

        // Delete quotation
        $this->db->where('ID', $id);
        return $this->db->delete('tbl_quotation');
    }

    public function approve($id)
    {
        // approve update field to 1
        $this->db->set('approved', 1);
        $this->db->where('ID', $id);
        $this->db->update('tbl_quotation');

        // add to purchase order
        $this->db->select('po_num');
        $this->db->from($this->Table->purchase_order);
        $this->db->where('po_num!=', null);
        $this->db->order_by('id', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get()->row();

        $po_num = "";
        if ($query) {
            $last_po = $query->po_num;
            $new_po = intval($last_po) + 1;
            $po_num = str_pad($new_po, 6, '0', STR_PAD_LEFT);
        } else {
            $po_num = '000000';
        }
        
        $purchase_order_data = [
            'po_num' => $po_num,
        ];

        $this->db->insert($this->Table->purchase_order, $purchase_order_data);
        $purchase_order_id = $this->db->insert_id();

        // add quotation items to purchase order items
        $this->db->select('*');
        $this->db->from('tbl_quotation_items');
        $this->db->where('qo_ID', $id);
        $items = $this->db->get()->result_array();
        foreach ($items as &$item) {
            unset($item['ID']); // remove ID to avoid conflict
            unset($item['qo_ID']);
            $item['po_ID'] = $purchase_order_id; // set the foreign key to purchase order
        }
        if (!empty($items)) {
            $this->db->insert_batch('tbl_purchase_order_items', $items);
        }
        return $this->db->affected_rows() > 0;

    }
}