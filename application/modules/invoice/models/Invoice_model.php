<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Invoice_model extends BaseModel {

    public function __construct() {
        return parent::__construct();
    }
	
	public function getInvoiceList($srch=array(), $limit=0, $offset=40, $for_list=TRUE){
		
		$this->db->select('i.*,t.type')
				->from('invoice_main i')
				->join('invoice_type t', 'i.invoice_type=t.invoice_type_id', 'LEFT')
				->join('project_invoice p_i', 'p_i.invoice_id=i.invoice_id', 'LEFT');
		
		if(!empty($srch['project_id'])){
			$this->db->where('p_i.project_id', $srch['project_id']);
		}
		
		if(!empty($srch['invoice_number'])){
			$this->db->where('i.invoice_number', $srch['invoice_number']);
		}
		
		if(!empty($srch['invoice_type'])){
			$this->db->where('i.invoice_type', $srch['invoice_type']);
		}
		
		if(!empty($srch['user_id'])){
			$this->db->where("(i.sender_id = {$srch['user_id']} OR i.receiver_id = {$srch['user_id']})");
		}
		
		if($for_list){
			$result = $this->db->limit($offset, $limit)->order_by('i.invoice_id', 'DESC')->get()->result_array();

		}else{
			$result = $this->db->get()->num_rows();
		}
		
		return $result;
	}
	
}
