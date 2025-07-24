<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Inventory_model extends CI_Model
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
    public function get_item_profiles()
    {
        $this->db->select('
        ip.*,
        u.unit_of_measure,
        i.item_name,
        i.item_code,
        i.short_name');

        $this->db->from($this->Table->item_profile . ' AS ip');
        $this->db->join($this->Table->items . ' AS i', 'ip.item_id = i.id', 'left');
        $this->db->join($this->Table->unit . ' AS u', 'ip.unit_id = u.id', 'left');
        $query = $this->db->get()->result();
        return $query;
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


    public function get_history()
    {
        $this->db->select('
            inv.quantity,
            inv.date_created,

            unit.unit_of_measure,

            items.item_name,
            items.short_name,
            items.item_code,
            items.description,

            supplier.supplier_name
        ');

        $this->db->from($this->Table->inventory . ' AS inv');
        $this->db->join($this->Table->item_profile . ' AS ip', 'inv.item_profile_id = ip.id', 'left');
        $this->db->join($this->Table->items . ' AS items', 'ip.item_id = items.id', 'left');
        $this->db->join($this->Table->unit . ' AS unit', 'ip.unit_id = unit.id', 'left');
        $this->db->join($this->Table->supplier . ' AS supplier', 'inv.supplier_id = supplier.id', 'left');

        $this->db->where('inv.item_profile_id', $this->id);
        $this->db->order_by('inv.date_created', 'DESC');
        $this->db->limit(50);

        $query = $this->db->get()->result();
        return $query;
    }

    public function get_suppliers()
    {
        $this->db->select('*');

        $this->db->from($this->Table->supplier);
        $this->db->where('active', 1);
        $query = $this->db->get()->result();
        return $query;
    }






}