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

    // public function get_inventory()
    // {
    //     $this->db->select('
    //         inv.item_profile_id,
    //         (SUM(inv.quantity) - IFNULL(sold_quantities.sold_quantity, 0)) AS current_stock,
    //         ip.threshold,
    //         unit.unit_of_measure,
    //         items.item_name,
    //         items.short_name,
    //         items.item_code,
    //         items.description
    //     ');

    //     $this->db->from($this->Table->inventory . ' AS inv');
    //     $this->db->join($this->Table->item_profile . ' AS ip', 'inv.item_profile_id = ip.id', 'left');
    //     $this->db->join($this->Table->items . ' AS items', 'ip.item_id = items.id', 'left');
    //     $this->db->join($this->Table->unit . ' AS unit', 'ip.unit_id = unit.id', 'left');

    //     // Custom Join to tbl_payment_child
    //     $this->db->join(
    //         "(SELECT item_profile_id, SUM(quantity) AS sold_quantity 
    //         FROM {$this->Table->payment_child} 
    //         GROUP BY item_profile_id) AS sold_quantities",
    //         'sold_quantities.item_profile_id = inv.item_profile_id',
    //         'left'
    //     );

    //     $this->db->group_by('inv.item_profile_id, unit.unit_of_measure, items.item_name, items.short_name, items.item_code, items.description');

    //     return $this->db->get()->result();
    // }

    // public function get_inventory(){
    //     $this->db->select('
    //         inv.item_ID,
    //         (SUM(inv.qty) - IFNULL(sold_quantities.sold_quantity, 0)) AS current_stock,
    //         ip.threshold,
    //         unit.unit_of_measure,
    //         items.item_name,
    //         items.short_name,
    //         items.item_code,
    //         items.description
    //     ');
    //     $this->db->from($this->Table->purchase_order_items. ' AS inv');
    //     $this->db->join($this->Table->purchase_order. ' AS po', 'inv.po_ID = po.ID', 'left');
    //     $this->db->join($this->Table->item_profile . ' AS ip', 'inv.item_ID = ip.item_id', 'left');
    //     $this->db->join($this->Table->items . ' AS items', 'inv.item_ID = items.id', 'left');
    //     $this->db->join($this->Table->unit . ' AS unit', 'inv.unit_ID = unit.id', 'left');
    //     // Custom Join to tbl_payment_child
    //     $this->db->join(
    //         "(SELECT pc.item_profile_id, ipj.item_id, SUM(pc.quantity) AS sold_quantity
    //           FROM {$this->Table->payment_child} pc
    //           JOIN {$this->Table->item_profile} ipj
    //             ON pc.item_profile_id = ipj.id
    //           GROUP BY pc.item_profile_id, ipj.item_id
    //         ) AS sold_quantities",
    //         'sold_quantities.item_id = inv.item_ID',
    //         'left'
    //     );
    //     $this->db->where('po.approved', 1);
    //     $this->db->group_by('inv.item_ID, ip.threshold, unit.unit_of_measure, items.item_name, items.short_name, items.item_code, items.description');
    
    //     return $this->db->get()->result();
    // }

    public function get_inventory(){
        $this->db->select('
            inv.item_ID,
            (SUM(inv.qty) - COALESCE(MAX(sq.sold_quantity), 0)) AS current_stock,
            ip.threshold,
            unit.unit_of_measure,
            items.item_name,
            items.short_name,
            items.item_code,
            items.description
        ');
        $this->db->from($this->Table->purchase_order_items . ' AS inv');
        $this->db->join($this->Table->purchase_order . ' AS po', 'inv.po_ID = po.ID', 'left');
        $this->db->join($this->Table->item_profile . ' AS ip', 'inv.item_ID = ip.item_id', 'left');
        $this->db->join($this->Table->items . ' AS items', 'inv.item_ID = items.id', 'left');
        $this->db->join($this->Table->unit . ' AS unit', 'inv.unit_ID = unit.id', 'left');
    
        // Subquery: one row per item_id (sold total)
        $this->db->join("
            (SELECT ipj.item_id, SUM(pc.quantity) AS sold_quantity
               FROM {$this->Table->payment_child} pc
               JOIN {$this->Table->item_profile} ipj
                 ON pc.item_profile_id = ipj.id
              GROUP BY ipj.item_id
            ) AS sq",
            'sq.item_id = inv.item_ID',
            'left'
        );
    
        $this->db->where('po.approved', 1);
    
        // Keep or trim columns here depending on how you want to group rows
        $this->db->group_by('inv.item_ID, ip.threshold, unit.unit_of_measure, items.item_name, items.short_name, items.item_code, items.description');
    
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

    public function get_last_po()
    {
        $this->db->select('po_num');
        $this->db->from($this->Table->purchase_order);
        $this->db->where('po_num!=', null);
        $this->db->order_by('id', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get()->row();

        if ($query) {
            $last_po = $query->po_num;
            $new_po = intval($last_po) + 1;
            return str_pad($new_po, 6, '0', STR_PAD_LEFT);
        } else {
            return '000000';
        }
    }

    public function get_po_list()
    {
        $this->db->select('ID,po_num');
        $this->db->from($this->Table->purchase_order);
        $this->db->where('approved', 0);
        $this->db->order_by('ID', 'DESC');
        $query = $this->db->get()->result();
     
        return $query;
    }

    public function get_po_header($po_number)
    {
        $this->db->select('
            po.ID,
            po.po_num,
            po.date_ordered,
            po.approved,
            po.date_added,
            po.supplier_ID,
            s.supplier_name,
            po.received_by
        ');
        $this->db->from($this->Table->purchase_order . ' AS po');
        $this->db->join($this->Table->supplier . ' AS s', 'po.supplier_id = s.id', 'left');
        $this->db->where('po.po_num', $po_number);
        $query = $this->db->get()->row();
        return $query;
    }
    public function get_po_items($po_number)
    {
        $this->db->select('ID');
        $this->db->from($this->Table->purchase_order);
        $this->db->where('po_num', $po_number);
        $pID = $this->db->get()->row()->ID;
       
        $this->db->select('
            poi.id AS po_item_id,
            poi.pcs,
            poi.date_expiry,
            poi.unit_price,
            poi.threshold,
            poi.unit_ID,
            poi.qty,
            poi.item_ID,
            u.unit_of_measure,
            i.item_name,
            i.item_code,
            i.description');
        $this->db->from($this->Table->purchase_order_items . ' AS poi');
        $this->db->join($this->Table->items . ' AS i', 'poi.item_id = i.id', 'left');
        $this->db->join($this->Table->unit . ' AS u', 'poi.unit_id = u.id', 'left');
        $this->db->where('poi.po_ID', $pID);
        $query = $this->db->get()->result();
        return $query;
    }

    public function get_supplier_data($supplier_id)
    {
        $this->db->select('*');
        $this->db->from($this->Table->supplier);
        $this->db->where('id', $supplier_id);
        $query = $this->db->get()->row();
        return $query;
    }

    public function get_item_data($item_ID) {
        $this->db->select('
        unit.unit_of_measure,
        item.description,
        item.id as item_id,
        unit.id as unit_id');
        $this->db->where('ip.item_id', $item_ID);
        $this->db->from($this->Table->item_profile. ' ip');
        $this->db->join($this->Table->items . ' item', 'ip.item_id = item.id', 'left');
        $this->db->join($this->Table->unit . ' unit', 'ip.unit_id = unit.id', 'left');

        $query = $this->db->get()->row();
        return $query;
    }

}