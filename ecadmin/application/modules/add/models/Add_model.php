<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Add_model extends BaseModel {

    public function __construct() {
        return parent::__construct();
    }
	
	////// ADD MENU///////////////////////////////
    public function add_banner($data) {
        $this->db->insert('advartise', $data);
        return TRUE;
    }

    ///// Edit MENU ///////////////////////////////
    public function update_banner($data,$id) {
        $this->db->where('id', $id);
        $this->db->update('advartise', $data);
        return TRUE;
    }

    public function record_count_banner() {
        return $this->db->count_all('advartise');
    }

    //// Delete Menu //////////////////////////////////
    public function delete_banner($id) {
        return $this->db->delete('advartise', array('id' => $id));
    }

    /// Get Parent menu list ////////////////////////////
    public function getbannerList($limit = '', $start = '') {
        $this->db->select('*');
        $this->db->order_by('id',"desc");
        $this->db->limit($limit, $start);
        $rs = $this->db->get('advartise');
        $data = array();

        foreach ($rs->result() as $row) {
            $position = $row->add_pos;
            if ($position == 'H')
                $position = 'Header';
            else if ($position == 'M')
                $position = 'Middle';
            else if ($position == 'F')
                $position = 'Footer';
				
			$type = $row->type;
            if ($type == 'B')
                $type = 'Banner';
            else if ($type == 'A')
                $type = 'Adsense';

            $data[] = array(
                'id' => $row->id,
                'page_name' => $row->page_name,
				'type' => $type,
                'code' => $row->advertise_code,
				'banner_image' => $row->banner_image,
				'banner_url' => $row->banner_url,
                'add_date' => $row->add_date,
                'position' => $position,
                'status' => $row->status
            );
        }
        return $data;
    }
    
    public function get_all_position($type='')
    {
        $this->db->distinct();
        $this->db->select("position");
        $this->db->from("add_type");
        if($type=="")
        {
            $this->db->where("type", $type);
        }
        $res = $this->db->get();
        $data = array();
        foreach ($res->result() as $row)
        {
            $position = $row->position;
            if ($position == 1)
                $position = 'Top';
            else if ($position == 2)
                $position = 'Left side';
            else if ($position == 3)
                $position = 'Right side';
            else if ($position == 4)
                $position = 'Bottom';
            else if ($position == 5)
                $position = 'Footer';
            
            $data[] = array(
                "pos_id" =>$row->position,
                "pos_val"=>$position
            );
        }
        return $data;
    }

    public function getbannertype() {
        $this->db->select('type');
        $this->db->group_by('type');
        $rs = $this->db->get('add_type');

        $data = array();
        foreach ($rs->result() as $row) {
            $data[] = array(
                'type' => $row->type
            );
        }
        return $data;
    }

    public function get_banner_position($type) {
        $res = $this->db->select("position")->from("add_type")->where("type", $type)->get();
        $data = array();
        foreach ($res->result() as $row) {
            $position = $row->position;
            if ($position == 1)
                $position = 'Top';
            else if ($position == 2)
                $position = 'Left side';
            else if ($position == 3)
                $position = 'Right side';
            else if ($position == 4)
                $position = 'Bottom';
            else if ($position == 5)
                $position = 'Footer';
            $data[] = array(
                'position_id' => $row->position,
                'position_val' => $position
            );
        }
        return $data;
    }

    public function getAllSearchData($usr_select, $search_element, $type) {
        $this->db->select('*');
        $this->db->like($usr_select, $search_element, 'none');
        $this->db->order_by("id","desc");
        $rs = $this->db->get_where('add');
        $data = array();
        foreach ($rs->result() as $row) {
            $data[] = array(
                'id' => $row->id,
                'type' => $row->type,
                'image' => $row->image,
                'order' => $row->order,
                'status' => $row->status
            );
        }
        return $data;
    }

    public function updatebanner($data, $id) {
        $this->db->where('id', $id);
        return $this->db->update('advartise', $data);
    }
	

}
