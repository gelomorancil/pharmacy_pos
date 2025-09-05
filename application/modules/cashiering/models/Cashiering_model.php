<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Cashiering_model extends CI_Model
{
    public $Table;
    public function __construct()
    {
        parent::__construct();
        $this->session = (object) get_userdata(USER);

        $model_list = [];
        $this->load->model($model_list);
        $this->Table = json_decode(TABLE);
    }

    public function get_items()
    {
        $this->db->select('
            i.*, 
            ip.unit_price,
            ip.id AS item_profile_id,
            u.unit_of_measure
        ');
        $this->db->from($this->Table->item_profile . ' ip');
        $this->db->join($this->Table->items . ' i', 'i.id = ip.item_id', 'left');
        $this->db->join($this->Table->unit . ' u', 'ip.unit_id = u.id', 'left');
        $this->db->where('i.active', '1');
        $this->db->order_by('i.item_name', 'asc');
        $query = $this->db->get()->result();

        foreach ($query as $row) {
            // attach stock result directly into each row object
            $row->current_stock = $this->get_current_stock($row->item_code);
        }

        return $query;
    }

    public function get_current_stock($code)
    {
        $this->db->select('
            inv.item_profile_id,
            (SUM(inv.quantity) - IFNULL(sold_quantities.sold_quantity, 0)) AS current_stock
        ');
        $this->db->from($this->Table->inventory . ' AS inv');
        $this->db->join($this->Table->item_profile . ' AS ip', 'inv.item_profile_id = ip.id', 'left');
        $this->db->join($this->Table->items . ' AS items', 'ip.item_id = items.id', 'left');

        // Subquery for sold quantities
        $this->db->join(
            "(SELECT item_profile_id, SUM(quantity) AS sold_quantity 
            FROM {$this->Table->payment_child} 
            GROUP BY item_profile_id) AS sold_quantities",
            'sold_quantities.item_profile_id = inv.item_profile_id',
            'left'
        );

        $this->db->where('items.item_code', $code);
        $this->db->group_by('inv.item_profile_id');

        $query = $this->db->get()->row();

        return $query ? $query->current_stock : 0; // return 0 if no stock found
    }


    // public function get_items()
    // {
    //     $this->db->select('*');
    //     $this->db->where('Active', '1');
    //     $this->db->from($this->Table->items);
    //     $this->db->order_by('item_name', 'asc');
    //     $query = $this->db->get()->result();
    //     return $query;
    // }

    public function check_item_code()
    {
        $this->db->select('
        ip.*,

        u.unit_of_measure,

        i.item_name,
        i.item_code,
        i.description,
        i.short_name
        ');

        $this->db->from($this->Table->item_profile . ' AS ip');
        $this->db->join($this->Table->items . ' AS i', 'ip.item_id = i.id', 'left');
        $this->db->join($this->Table->unit . ' AS u', 'ip.unit_id = u.id', 'left');

        $this->db->where('i.item_code', $this->item_code);

        $query = $this->db->get()->result();
        if (!empty($query)) {
            return (array('message' => "Item Code Verified", 'has_error' => false, 'query' => $query));
        } else {
            return (array('message' => "Item Code Not Found on System!", 'has_error' => true, 'query' => null));
        }
    }

    public function get_inventory()
    {
        $this->db->select('
            inv.item_profile_id,
            (SUM(inv.quantity) - IFNULL(sold_quantities.sold_quantity, 0)) AS current_stock,
            ip.threshold,
            unit.unit_of_measure,
            items.item_name,
            items.short_name,
            items.item_code,
            items.description
        ');

        $this->db->from($this->Table->inventory . ' AS inv');
        $this->db->join($this->Table->item_profile . ' AS ip', 'inv.item_profile_id = ip.id', 'left');
        $this->db->join($this->Table->items . ' AS items', 'ip.item_id = items.id', 'left');
        $this->db->join($this->Table->unit . ' AS unit', 'ip.unit_id = unit.id', 'left');

        // Custom Join to tbl_payment_child
        $this->db->join(
            "(SELECT item_profile_id, SUM(quantity) AS sold_quantity 
            FROM {$this->Table->payment_child} 
            GROUP BY item_profile_id) AS sold_quantities",
            'sold_quantities.item_profile_id = inv.item_profile_id',
            'left'
        );

        $this->db->group_by('inv.item_profile_id, unit.unit_of_measure, items.item_name, items.short_name, items.item_code, items.description');

        return $this->db->get()->result();
    }

    public function check_item_stock()
    {
        $this->db->select('
            inv.item_profile_id,
            (SUM(inv.quantity) - IFNULL(sold_quantities.sold_quantity, 0)) AS current_stock
        ');

        $this->db->from($this->Table->inventory . ' AS inv');
        $this->db->join($this->Table->item_profile . ' AS ip', 'inv.item_profile_id = ip.id', 'left');
        $this->db->join($this->Table->items . ' AS items', 'ip.item_id = items.id', 'left');
        $this->db->join($this->Table->unit . ' AS unit', 'ip.unit_id = unit.id', 'left');
        $this->db->where('items.item_code', $this->item_code);

        // Subquery to get sold quantities for each item profile
        $this->db->join(
            "(SELECT item_profile_id, SUM(quantity) AS sold_quantity 
            FROM {$this->Table->payment_child} 
            GROUP BY item_profile_id) AS sold_quantities",
            'sold_quantities.item_profile_id = inv.item_profile_id',
            'left'
        );

        $this->db->group_by('inv.item_profile_id');

        $current_stock_query = $this->db->get()->row();
        if (empty($this->quantity) || !is_numeric($this->quantity)) {
            return array('message' => "Missing Details. Input Quantity!", 'has_error' => true);
        } else if (!empty($this->current_quantity) && ($this->quantity + $this->current_quantity) > $current_stock_query->current_stock) {
            return array('message' => "Not Enough Stocks! only " . $current_stock_query->current_stock . " Stocks Left", 'has_error' => true);
        } else {
            return array('message' => SAVED_SUCCESSFUL, 'has_error' => false);
        }
    }

    public function check_stock_status()
    {
        $this->db->select('
            inv.item_profile_id,
            (SUM(inv.quantity) - IFNULL(sold_quantities.sold_quantity, 0)) AS current_stock,
            ip.threshold,
            unit.unit_of_measure,
            items.item_name,
            items.short_name,
            items.item_code,
            items.description
        ');

        $this->db->from($this->Table->inventory . ' AS inv');
        $this->db->join($this->Table->item_profile . ' AS ip', 'inv.item_profile_id = ip.id', 'left');
        $this->db->join($this->Table->items . ' AS items', 'ip.item_id = items.id', 'left');
        $this->db->join($this->Table->unit . ' AS unit', 'ip.unit_id = unit.id', 'left');

        // Subquery join to get sold quantities directly
        $this->db->join(
            "(SELECT item_profile_id, SUM(quantity) AS sold_quantity 
            FROM {$this->Table->payment_child} 
            GROUP BY item_profile_id) AS sold_quantities",
            'sold_quantities.item_profile_id = inv.item_profile_id',
            'left'
        );

        $this->db->where('items.item_code', $this->item_code);

        $this->db->group_by('inv.item_profile_id, unit.unit_of_measure, items.item_name, items.short_name, items.item_code, items.description');

        // Use HAVING clause to filter by threshold condition
        $this->db->having('current_stock <= ip.threshold');
        $this->db->order_by('current_stock', 'ASC');

        $query = $this->db->get()->result();
        return $query;
    }


}