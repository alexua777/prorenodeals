<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Country_model extends BaseModel {

    public function __construct() {
        return parent::__construct();
    }

    ////// ADD country///////////////////////////////
    public function add_countrymenu($data) {
        return $this->db->insert('countries', $data);
    }

    ///// Edit country ///////////////////////////////
    public function update_countrymenu($data, $id) {

        $this->db->where('id', $id);

        return $this->db->update('countries', $data);
    }

    public function record_count_country() {
        return $this->db->count_all('countries');
    }

    //// Delete country //////////////////////////////////
    public function delete_menu($id) {
        return $this->db->delete('countries', array('id' => $id));
    }

    /// Get country list ////////////////////////////
    public function getcountrylist($limit = '', $start = '') {
        $this->db->order_by('order_id', "asc");
        $this->db->limit($limit, $start);
        $rs = $this->db->get("countries");
        $data = array();
        
            foreach ($rs->result() as $row) {
                $data[] = array(
                    'id' => $row->id,
                    'c_code' => $row->c_code,
                    'c_name' => $row->c_name,
                    'domain' => $row->domain,
                    'order_id' => $row->order_id,
                    'flag_logo' => $row->flag_logo,
                    'set_default' => $row->set_default,
                    'status' => $row->status
                );
            }
            return $data;
        }
        

    public function updatecountry($data, $id) {
        /* echo "<pre>";
          print_r($data);die; */
        $this->db->where('id', $id);
        return $this->db->update('countries', $data);
    }

}
