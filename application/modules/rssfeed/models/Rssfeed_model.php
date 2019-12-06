<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Rssfeed_model extends BaseModel {

    public function __construct() {
        return parent::__construct();
    }

public function get_feeds($cat,$ptype,$minb,$maxb,$post_with,$country,$city,$featured,$environment,$uid){
	$this->db->select();
		if($cat!='All')
		{
			$category=explode("-",$cat);
			$this->db->where_in('category',$category);	
		}
		if($ptype!='All')
		{
				$this->db->where('project_type',$ptype);	
		}
		if($minb>0)
		{
			$this->db->where('buget_min >=',$minb);
		}
		if($maxb > 0)
		{
			$this->db->where('buget_max <=',$maxb);
		}
		if($post_with!='All')
		{
			$newdate=date('Y-m-d',strtotime("-".$post_with." day",strtotime(date('Y-m-d'))));
			$this->db->where('post_date >=',$newdate);
		}
		if($country!='All')
		{
			$this->db->where('user_country',$country);
		}
		if($city!='All')
		{
			$this->db->where('user_city',$city);
		}
		if($featured!='All')
		{
			$this->db->where('featured',$featured);
		}
		if($environment!='All')
		{
			$this->db->where('environment',$environment);
		}
		if($uid > 0)
		{
			$this->db->where('user_id',$uid);
		}
		// set this to false so that _protect_identifiers skips escaping:
		$this->db->_protect_identifiers = FALSE;
		
		// your order_by line:
		$this -> db -> order_by("FIELD ( serv_projects.featured, 'N', 'Y')",'DESC');
		
		// important to set this back to TRUE or ALL of your queries from now on will be non-escaped:
		$this->db->_protect_identifiers = TRUE;
		
		$rs=$this->db->get_where('projects',array('status'=>'O','project_status'=>'Y'));
		//echo $this->db->last_query();
		$data=array();
		foreach($rs->result() as $row)
		{
			if($row->visibility_mode=="Private" && $this->session->userdata('user')){  
                        $user=$this->session->userdata('user');
                        
                        if($this->autoload_model->isOwner($row->project_id) || $this->autoload_model->isinvitees($row->project_id,$user[0]->email)){ 
                            
                            $data[]=array(
                            'id'=>$row->id,
                            'project_id'=>$row->project_id,
                            'user_id'=>$row->user_id,
                            'title'=>$row->title,
                            'description'=>$row->description,
                            'category' => $row->category,
                            'skills' => $row->skills,
                            'environment'=>$row->environment,
                            'project_type'=>$row->project_type,
                            'visibility_mode' =>$row->visibility_mode,    
                            'buget_min'=>$row->buget_min,
                            'buget_max'=>$row->buget_max,
                            'featured'=>$row->featured,
                            'post_date'=>$row->post_date,
                            'expiry_date'=>$row->expiry_date,
							'user_country'=>$row->user_country,
							'user_city'=>$row->user_city
                            );
                            
                        }
                        
                        
                    }
                    else if($row->visibility_mode=="Public"){ 
			$data[]=array(
			'id'=>$row->id,
			'project_id'=>$row->project_id,
			'user_id'=>$row->user_id,
			'title'=>$row->title,
			'description'=>$row->description,
			'category' => $row->category,
			'skills' => $row->skills,
			'environment'=>$row->environment,
			'project_type'=>$row->project_type,
                        'visibility_mode' =>$row->visibility_mode,    
			'buget_min'=>$row->buget_min,
			'buget_max'=>$row->buget_max,
			'featured'=>$row->featured,
			'post_date'=>$row->post_date,
			'expiry_date'=>$row->expiry_date,
			'user_country'=>$row->user_country,
			'user_city'=>$row->user_city
			);
                    }
		}
		return $data;

}
}
