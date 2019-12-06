<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Sitemap_model extends BaseModel {

    public function __construct() {
        return parent::__construct();
    }
	
	public function getSitemap()
	{
		$this->db->select();
		$rs=$this->db->get("sitemap");
		$data=array();
		foreach($rs->result() as $al)
		{
			$data[]=array(
			"page" => $al->name,
			"url" => $al->url
			);
		}
		return $data;
	}
	
}
