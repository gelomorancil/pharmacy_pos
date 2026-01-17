<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Report_model extends CI_Model
{
    public $Table;
    public function __construct()
    {
        parent::__construct();
        $this->session = (object) get_userdata(USER);

        // if(is_empty_object($this->session)){
        // 	redirect(base_url().'login/authentication', 'refresh');
        // }

        $model_list = [];
        $this->load->model($model_list);
        $this->Table = json_decode(TABLE);
    }

    public function get_sales()
    {
        $this->db->select('
            pParent.*,
            user.FName,
            user.LName,
            buyer.name AS buyer_name,
        ');
        $this->db->from($this->Table->payment_parent . ' AS pParent');
        $this->db->join($this->Table->user . ' AS user', 'pParent.recieved_by = user.id', 'left');
        $this->db->join($this->Table->buyers . ' AS buyer', 'pParent.Buyer_ID = buyer.ID', 'left');

        if ($this->date_from && $this->date_to) {
            $this->db->where('pParent.date_created >=', $this->date_from);
            $this->db->where('pParent.date_created <=', $this->date_to);
        }

        if ($this->load_type == "1") {
            $this->db->where('pParent.voided', 1);
        } else if ($this->load_type == "0") {
            $this->db->where('pParent.voided', 0);
        }


        $this->db->order_by('pParent.date_created', 'DESC');
        $parentQuery = $this->db->get();

        $sales = [];

        foreach ($parentQuery->result() as $parentRow) {
            $this->db->select('
                pChild.*,
                ip.item_id,
                item.pcs_box,
                item.pcs_stub,
                item.item_name,
                item.item_code,
                item.short_name,
                item.strenght,
                item.packaging,
            ');
            $this->db->from($this->Table->payment_child . ' AS pChild');
            $this->db->join($this->Table->item_profile . ' AS ip', 'pChild.item_profile_id = ip.id', 'left');
            $this->db->join($this->Table->items . ' AS item', 'ip.item_id = item.id', 'left');
            $this->db->where('pChild.payment_id', $parentRow->id);
            $childQuery = $this->db->get();

            $parentRow->children = $childQuery->result();
        }

        return $parentQuery->result_array();
    }

    public function get_inventory()
    {
        $this->db->select('
            inv.*,
            s.supplier_name,
            i.item_name,
            i.item_code,
        ');
        $this->db->from($this->Table->inventory . ' AS inv');
        $this->db->join($this->Table->supplier . ' AS s', 'inv.supplier_id = s.id', 'left');
        $this->db->join($this->Table->item_profile . ' AS ip', 'inv.item_profile_id = ip.id', 'left');
        $this->db->join($this->Table->items . ' AS i', 'ip.item_id = i.id', 'left');

        if ($this->date_from && $this->date_to) {
            $this->db->where('inv.date_created >=', $this->date_from);
            $this->db->where('inv.date_created <=', $this->date_to);
        }

        $this->db->where('inv.deleted', 0);
        $this->db->order_by('inv.date_created', 'DESC');

        $query = $this->db->get()->result();
        return $query;
    }

    public function get_expenses()
    {
        $this->db->select(
            'e.Branch as e_Branch,
            e.ID,
            e.Image,
            e.Date,
            e.Descr,
            e.Actual_Money,
            e.expense,
            e.Balance,
            e.Editted,
            u.FName,
            u.LName'
        );

        $this->db->from($this->Table->expenses . ' e');
        $this->db->join($this->Table->user . ' u', 'u.ID = e.Incharge', 'left');
        $this->db->where('e.Void', 0);

        // ✅ Date filter
        if (!empty($this->date_from) && !empty($this->date_to)) {

            $this->db->where('e.Date >=', $this->date_from);
            $this->db->where('e.Date <=', $this->date_to);

        } else {

            // ✅ Default: today (full day range)
            $today = date('Y-m-d');
            $this->db->where('e.Date >=', $today . ' 00:00:00');
            $this->db->where('e.Date <=', $today . ' 23:59:59');
        }

        return $this->db->get()->result();
    }

    // public function total_sales()
    // {
    //     $this->db->select('SUM(total_amount) AS total_sales');
    //     $this->db->from($this->Table->payment_parent);
    //     $this->db->where('voided', 0);

    //     if (!empty($this->date_from) && !empty($this->date_to)) {
    //         $this->db->where('date_created >=', $this->date_from);
    //         $this->db->where('date_created <=', $this->date_to);
    //     } else {
    //         $today = date('Y-m-d');
    //         $this->db->where('date_created >=', $today . ' 00:00:00');
    //         $this->db->where('date_created <=', $today . ' 23:59:59');
    //     }

    //     return (float) $this->db->get()->row()->total_sales;
    // }

    public function total_sales()
    {
        $this->db->select('SUM(pc.total_price) AS total_sales, i.Category');
        $this->db->from($this->Table->payment_parent . ' pp');
        $this->db->join($this->Table->payment_child . ' pc', 'pc.payment_id = pp.id', 'left');
        $this->db->join($this->Table->item_profile . ' ip', 'pc.item_profile_id = ip.id', 'left');
        $this->db->join($this->Table->items . ' i', 'ip.item_id = i.id', 'left');
        $this->db->where('pc.voided', 0);

        if (!empty($this->date_from) && !empty($this->date_to)) {
            $this->db->where('pp.date_created >=', $this->date_from);
            $this->db->where('pp.date_created <=', $this->date_to);
        } else {
            $today = date('Y-m-d');
            $this->db->where('pp.date_created >=', $today . ' 00:00:00');
            $this->db->where('pp.date_created <=', $today . ' 23:59:59');
        }

        $this->db->group_by('i.Category');
        return $this->db->get()->result();
    }

    // public function get_purchases()
    // {
    //     $this->db->select(
    //         'i.Category,
    //         p.received_pcs,
    //         p.supplier_price,
    //         (p.received_pcs * p.supplier_price) AS total_purchase_amount'
    //     );

    //     $this->db->from($this->Table->purchase_order_items . ' p');
    //     $this->db->join($this->Table->items . ' i', 'i.id = p.item_id', 'left');
    //     $this->db->join($this->Table->purchase_order . ' po', 'po.id = p.po_ID', 'left');
    //     $this->db->where('po.date_approved !=', '0000-00-00 00:00:00');
        
    //     // ✅ Date filter
    //     if (!empty($this->date_from) && !empty($this->date_to)) {

    //         $this->db->where('po.date_ordered >=', $this->date_from);
    //         $this->db->where('po.date_ordered <=', $this->date_to);

    //     } else {

    //         // ✅ Default: today (full day range)
    //         $today = date('Y-m-d');
    //         $this->db->where('po.date_ordered >=', $today . ' 00:00:00');
    //         $this->db->where('po.date_ordered <=', $today . ' 23:59:59');
    //     }

    //     $this->db->group_by('i.Category');
    //     return $this->db->get()->result();
    // }

    public function get_purchases()
    {
        $this->db->select('
            i.Category,
            SUM(p.received_pcs * p.supplier_price) AS total_purchase_amount
        ');

        $this->db->from($this->Table->purchase_order . ' po');
        $this->db->join($this->Table->purchase_order_items . ' p', 'p.po_ID = po.id', 'left');
        $this->db->join($this->Table->items . ' i', 'i.id = p.item_id', 'left');
        $this->db->where('po.approved', 1);

        // ✅ Date filter
        if (!empty($this->date_from) && !empty($this->date_to)) {
            $this->db->where('po.date_ordered >=', $this->date_from);
            $this->db->where('po.date_ordered <=', $this->date_to);
        } else {
            $today = date('Y-m-d');
            $this->db->where('po.date_ordered >=', $today . ' 00:00:00');
            $this->db->where('po.date_ordered <=', $today . ' 23:59:59');
        }

        // ✅ Group by category
        $this->db->group_by('i.Category');

        return $this->db->get()->result();
    }


}