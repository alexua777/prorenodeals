<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class contact_model extends BaseModel {

    public function __construct() {
        return parent::__construct();
    }
	
	public function getcontact($data)
	{
	   $data['contact_ticket'] = $this->contactTicket();
	   $this->db->insert('contact',$data);
	   return  $data['contact_ticket'];
	
	}
	
	
	
	public function contactTicket(){
        $messageid = base_convert(time(), 10, 36)."-". base_convert(rand(1000,9999), 10, 36);
		if($this->isTicketExist($messageid)){
			$this->contactTicket();
			}else{
		return strtoupper($messageid);
		}
			
	}
	
	public function isTicketExist($ticket) {
		$this->db->select('contact_id');
		$this->db->where('contact_ticket', $ticket);
		$query = $this->db->get('contact');
		
		if ($query->num_rows() > 0) {
			return true;
			} else {
			return false;
		}
	}
	
	
	
	
	public function getCountryInfo()
	{
		$this->db->select('id,c_name');
		$this->db->order_by('order_id','asc');
		$rs = $this->db->get_where('countries',array('status'=>'Y'));
		$data = array();
		foreach($rs->result() as $row)
		{
			$data[] = array(
				'country_id' => $row->id,
				'country_name' => $row->c_name
			);
		}
		return $data;
	
	}
	public function getsubject()
	{
		$this->db->select('id,title');
		$this->db->order_by('ord','asc');
		$rs = $this->db->get_where('contact_subject',array('status'=>'Y'));
		$data = array();
		foreach($rs->result() as $row)
		{
			$data[] = array(
				'sub_id' => $row->id,
				'subject' => $row->title
			);
		}
		return $data;
	
	}
	public function getcontact_info()
	{
		$this->db->select('id,admin_mail,support_mail,fax,address,corporate_address,office_no,corporate_no,telephone,map');
		$rs = $this->db->get('setting');
		$data = array();
		foreach($rs->result() as $row)
		{
			$data[] = array(
				'id' => $row->id,
				'office_mail' => $row->admin_mail,
				'corporate_mail' => $row->support_mail,
				'fax' => $row->fax,
				'office_address' => $row->address,
				'corporate_address' => $row->corporate_address,
				'office_no' => $row->office_no,
				'telephone' => $row->telephone,
				'corporate_no' => $row->corporate_no,
				'map' => $row->map
			);
		}
		return $data;
	
	}
	

}
