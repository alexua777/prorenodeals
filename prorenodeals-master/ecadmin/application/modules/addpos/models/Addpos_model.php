<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Addpos_model extends BaseModel {

    public function __construct() {
        return parent::__construct();
    }

    ////// ADD banner type///////////////////////////////
    public function add_banner_pos($post) {
        $resolution = $post['width'] . "X". $post['height'];
        $data = array(
            'type'=>$post['type'],
            'position' => $post['position'],
            'resolution' => $resolution,
            'price' => $post['price'],
            'validity' => $post['validity']);
        return $this->db->insert('add_type', $data);
    }

    ///// Edit banner position ///////////////////////////////
    public function update_banner_pos($post) {
        $resolution = $post['width'] . "X". $post['height'];
        $data = array(
            'position' => $post['position'],
            'resolution' => $resolution,
            'price' => $post['price'],
            'validity' => $post['validity']);
        $this->db->where('id', $post['id']);
        return $this->db->update('add_type', $data);
    }

    public function record_count_state() {
        return $this->db->count_all('add_type');
    }

    public function get_banner_type_list($limit = '', $start = '') {
        $this->db->select();
        $this->db->limit($limit, $start);
        $this->db->order_by('type');
        $rs = $this->db->get_where('add_type', array());
        //$rs = $this->db->from('state');
        $data = array();
        
            foreach ($rs->result() as $row) {
                $position = $row->position;
                if($position==1)
                    $position = 'Top';
                else if($position==2)
                    $position='Left side';
                else if($position==3)
                    $position='Right side';
                else if($position==4)
                    $position='Bottom';
                else if($position==5)
                    $position='Footer';
                $data[] = array(
                    'id' => $row->id,
                    'type' => $row->type,
                    'position' => $position,
                    'resolution' => $row->resolution,
                    'price' => $row->price,
                    'validity'=> $row->validity);
            }
            return $data;
        }
 
}
