<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Email_model extends BaseModel {

    public function __construct() {
        return parent::__construct();
    }

    ////// ADD MENU///////////////////////////////
    public function add_email() {
        /*/return $this->db->insert('email_template', $data);
        $insert_id = $this->db->insert_id();*/
        $status = 'Y';
        $data['type'] = $this->input->post('type');
        $data['subject'] = $this->input->post('subject');
        $data['template'] = $this->input->post('template');
		$data['langid'] = 'en';
        $data['status'] = $status;
        $this->db->insert('mailtemplate', $data);
        $insert_id = $this->db->insert_id();
        if($this->input->post('status')=='Y')
        {
            $this->db->where("type", $this->input->post('type'));
            $this->db->update("mailtemplate", array("status"=>'N')); 
            
            $this->db->where("id",$insert_id);
            $this->db->update("mailtemplate", array("status"=>'Y'));
            
        }
        return TRUE;
    }
	
	public function record_count_email() 
	{
        return $this->db->count_all('mailtemplate');
    }

    ///// Edit MENU ///////////////////////////////
    public function update_email($post) {
        $data = array(
            'type' => $post['type'],
            'subject' => $post['subject'],
            'template' => $post['template']
        );
        $this->db->where('id', $post['id']);
		$this->db->update('mailtemplate', $data);
        if($this->input->post('status')=='Y')
        {
            $this->db->where("type", $this->input->post('type'));
            $this->db->update("mailtemplate", array("status"=>'N')); 
            
            $this->db->where("id",$post['id']);
            $this->db->update("mailtemplate", array("status"=>'Y'));
            
        }
        return TRUE;

            //  return $this->db->update('email_template', $data);
        }
        
        
    

    /// Get Parent menu list ////////////////////////////
    public function getemailList($limit='',$start='') {
        $this->db->select('*');
	$this->db->limit($limit,$start);
        $this->db->order_by("id","desc");
        $rs = $this->db->get('mailtemplate');
        $data = array();
		foreach ($rs->result() as $row) {
            $data[] = array(
                'id' => $row->id,
                'type' => $row->type,
                'subject' => $row->subject,
                'template' => $row->template,
                'status' => $row->status
            );
        }
        return $data;
    }
   
	
    public function gettype() {
        $this->db->select('type');
        $this->db->group_by('type');
        $rs = $this->db->get('mailtemplate');
        
        $data = array();
        foreach ($rs->result() as $row) {
            $data[] = array(
                'type' => $row->type
            );
            //print_r($data);
        }
        return $data;
    }

    //// Get Data by field name //////////////////

    public function getFeild($select, $table, $feild, $value) {
        $this->db->select($select);
        $rs = $this->db->get_where($table, array($feild => $value));
        $data = '';
        foreach ($rs->result() as $row) {
            $data = $row->$select;
        }
        return $data;
    }
	
	public function updateemail($data,$id)
	{
		/*echo "<pre>";
			print_r($data);die;*/
		$this->db->where('id',$id);
		return $this->db->update('mailtemplate',$data);
		
	}

}
