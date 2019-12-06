<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class location_model extends BaseModel {

    public function __construct() {
        return parent::__construct();
    }

    ////// ADD country///////////////////////////////
    public function add_countrymenu($data) {
        return $this->db->insert('city', $data);
    }

    ///// Edit country ///////////////////////////////
    public function update_countrymenu($data, $id) {

        $this->db->where('ID', $id);

        return $this->db->update('city', $data);
		
    }

    public function record_count_country() {
		$this->db->select('ID');
		
		$this->db->from('city');
		return $this->db->count_all_results();
    }
	
	public function record_count_city($countrycode) {
		$this->db->select('ID');
		$this->db->where('CountryCode',$countrycode);
		$this->db->from('city');
		return $this->db->count_all_results();
    }

    //// Delete country //////////////////////////////////
    public function delete_menu($id) {
        return $this->db->delete('city', array('id' => $id));
    }

    /// Get country list ////////////////////////////
    public function getcountrylist($limit = '', $start = '') {
        $this->db->order_by('id', "desc");
        $this->db->limit($limit, $start);
        $rs = $this->db->get("city");
        $data = array();
        
            foreach ($rs->result() as $row) {
                $data[] = array(
                    'id' => $row->ID,
                    'name' => $row->Name,
                    'countrycode' => $row->CountryCode
                );
            }
            return $data;
        }
        
	public function getcitylist($countrycode,$limit = '', $start = '') {
		$this->db->where('CountryCode',$countrycode);
        $this->db->order_by('id', "desc");
        $this->db->limit($limit, $start);
        $rs = $this->db->get("city");
        $data = array();
        
            foreach ($rs->result() as $row) {
                $data[] = array(
                    'id' => $row->ID,
                    'name' => $row->Name,
                    'countrycode' => $row->CountryCode
                );
            }
            return $data;
        }
        
	public function getAllcountrylist()
	{
		$this->db->order_by('Name', "asc");
        
        $rs = $this->db->get("country");
        $data = array();
        
            foreach ($rs->result() as $row) {
                $data[] = array(
                    'code' => $row->Code,
                    'name' => $row->Name
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
