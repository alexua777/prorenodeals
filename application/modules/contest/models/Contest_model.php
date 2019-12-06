<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Contest_model extends BaseModel {

    public function __construct() {
        return parent::__construct();
    }
    
	
	public function getSkills($term=''){
		$ret = array();
		$this->db->like('skill_name', $term);
		$result = $this->db->get('skills')->result_array();
		if($result){
			foreach($result as $k => $v){
				$ret[] = array(
					'text' => $v['skill_name'],
					'value' => $v['id']
				);
			}
		}
		
		return $ret;
	}
	
	public function getEntryDetail($contest_id='', $user_id=''){
		$entry_row = $this->db->where(array('contest_id' => $contest_id, 'user_id' =>  $user_id))->get('contest_entry')->row_array();
		
		if(!empty($entry_row)){
			$entry_row['entry_files'] = $this->db->where('entry_id', $entry_row['entry_id'])->get('contest_entry_files')->result_array();
		}
		
		return $entry_row;
	}
	
	public function getContestEntry($srch=array(), $limit=0, $offset=30, $for_list=TRUE){
		$login_user_id = $srch['login_user'];
		
		$this->db->select('*')
			->from('contest_entry');
			
		if(!empty($srch['contest_id'])){
			$this->db->where('contest_id', $srch['contest_id']);
		}
		
		if(!empty($srch['view'])){
			if($srch['view'] == 'A'){
				$this->db->where('is_withdraw', '0');
			}else if($srch['view'] == 'W'){
				$this->db->where('is_withdraw', '1');
			}else if($srch['view'] == 'S'){
				$this->db->where('is_sealed', '1');
			}else if($srch['view'] == 'ME'){
				$this->db->where('user_id', $login_user_id);
			}
			
		}	
		
		$this->db->where('is_entry_complete', 'Y');
		
		if($for_list){
			
			if(!empty($srch['order_by'])){
				if($srch['order_by'] == 'recent'){
					$this->db->order_by('entry_id', 'DESC');
				}else if($srch['order_by'] == 'old'){
					$this->db->order_by('entry_id', 'ASC');
				}
			}else{
				$this->db->order_by('entry_id', 'DESC');
			}
		
			$result = $this->db->limit($offset, $limit)->get()->result_array();
			if(count($result) > 0){
				foreach($result as $k => $v){
					$result[$k]['entry_files'] = $this->db->where('entry_id', $v['entry_id'])->get('contest_entry_files')->result_array();
				}
			}
		}else{
			$result = $this->db->get()->num_rows();
		}
		
		return $result;
	}
	
	public function getComments($contest_id=''){
		$this->db->select('c.*')
			->from('contest_comment cc')
			->join('comments c', 'c.comment_id=cc.comment_id');
			
		$this->db->where('cc.contest_id', $contest_id);
		$this->db->where('c.parent_id', '0');
		$result = $this->db->order_by('c.comment_id', 'DESC')->get()->result_array();
		if(count($result) > 0){
			foreach($result as $k => $v){
				$result[$k]['user_info'] = $this->db->select('fname,lname,logo')->from('user')->where('user_id', $v['user_id'])->get()->row_array();
				$result[$k]['comment_replies'] = $this->db->where('parent_id', $v['comment_id'])->get('comments')->result_array();
				
				if($result[$k]['comment_replies']){
					foreach($result[$k]['comment_replies'] as $key => $val){
						$result[$k]['comment_replies'][$key]['user_info'] = $this->db->select('fname,lname,logo')->from('user')->where('user_id', $val['user_id'])->get()->row_array();
					}
				}
			}
		}
		//get_print($result);
		return $result;
	}
	
	public function getEntryComments($entry_id=''){
		$this->db->select('c.*')
			->from('entry_comment ec')
			->join('comments c', 'c.comment_id=ec.comment_id');
			
		$this->db->where('ec.entry_id', $entry_id);
		$result = $this->db->order_by('c.comment_id', 'ASC')->get()->result_array();
		if(count($result) > 0){
			foreach($result as $k => $v){
				$result[$k]['user_info'] = $this->db->select('fname,lname,logo')->from('user')->where('user_id', $v['user_id'])->get()->row_array();
			}
		}
		
		return $result;
	}
	
	
	public function getContest($srch=array(), $limit=0, $offset=30, $for_list=TRUE){
		$contest_entry = $this->db->dbprefix('contest_entry');
		$this->db->select("c.*, (select count(*) from $contest_entry  where contest_id = c.contest_id) as total_entries")
			->from('contest c')
			->join('contest_skills cs', 'cs.contest_id=c.contest_id', 'LEFT');
		
		if(!empty($srch['skills'])){
			$this->db->where_in('cs.skill_id', $srch['skills']);
		}
		
		if(!empty($srch['cid'])){
			$this->db->where('c.category_id', $srch['cid']);
		}
		$this->db->where('c.status', 'Y');
		if(!empty($srch['term'])){
			$this->db->like('c.title', trim($srch['term']));
		}
		
		$this->db->group_by('c.contest_id');
		
		if($for_list){
			
			$result = $this->db->limit($offset, $limit)->order_by('c.is_featured', 'DESC')->order_by('c.contest_id', 'DESC')->get()->result_array();
			if(count($result) > 0){
				foreach($result as $k => $v){
					$result[$k]['skills'] = $this->_getSkills($v['contest_id']);
				}
			}
		}else{
			$result = $this->db->get()->num_rows();
		}
		
		return $result;
	}
	
	private function _getSkills($contest_id=''){
		$this->db->select('s.*')
			->from('contest_skills cs')
			->join('skills s', 's.id=cs.skill_id')
			->where('contest_id', $contest_id);
			
		$res = $this->db->get()->result_array();
		
		return $res;
	}
	
	public function getMarker($files=array()){
		$markers = array();
		if(count($files) > 0){
			foreach($files as $file){
				$file_id = $file['entry_file_id'];
				$markers[$file_id] = $this->db->where('entry_file_id', $file_id)->get('contest_file_marker')->result_array();
				
				if($markers[$file_id]){
					foreach($markers[$file_id] as $m_key => $marker){
						$marker_id  = $marker['marker_id'];
						$markers[$file_id][$m_key]['comments'] = $this->db->where('marker_id', $marker_id)->get('contest_marker_comment')->result_array();
						
						if($markers[$file_id][$m_key]['comments']){
							
							foreach($markers[$file_id][$m_key]['comments'] as $c => $comment){
								$user_detail = $this->db->select('fname,lname,logo')->where('user_id', $comment['user_id'])->get('user')->row_array();
								
								$logo = $user_detail['logo'];
								
								if($logo!=''){
									$user_detail['logo'] = base_url('assets/uploaded/'.$logo) ;
								if(file_exists('assets/uploaded/cropped_'.$logo)){
									$user_detail['logo'] = base_url('assets/uploaded/cropped_'.$logo) ;
								}
								}else{
									$user_detail['logo'] = base_url('assets/images/user.png'); 
								}
								
								$user_detail['name'] = $user_detail['fname'].' '.$user_detail['lname'];

								$markers[$file_id][$m_key]['comments'][$c]['user_detail'] = $user_detail;
							}
						}
						
					}
				}
				
			}
		}
		
		return $markers;
		
	}

}
