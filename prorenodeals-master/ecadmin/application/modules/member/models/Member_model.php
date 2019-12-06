<?php

if (!defined('BASEPATH'))

    exit('No direct script access allowed');



class  Member_model extends BaseModel {



    public function __construct() {

        return parent::__construct();

    }

	public function getAllMemberList($lim_to,$lim_from,$srch=array(), $for_list=TRUE){ 
	
	// 	user_id	username	password	fname	lname	gender	status	email	mobile	address	country	zip	image	reg_date	edit_date	ldate	v_stat	ip	acc_balance	slogan	logo	overview	work_experience	hourly_rate	qualification	certification	education	asclient_aboutus	membership_plan	membership_start	membership_end

			$data = array();
			
            $this->db->select('*');
			$this->db->where('status <>', 'C');
			if(!empty($srch['term'])){
			
				$this->db->where("(concat(fname, ' ',lname) LIKE '%{$srch['term']}%' OR email LIKE '%{$srch['term']}%'  OR username LIKE '%{$srch['term']}%' ESCAPE '!')");
			}
			
			if(!empty($srch['profile_type'])){
				
				if($srch['profile_type'] == 'featured'){
					$this->db->where("featured", 1);
				}else{
					$this->db->where("featured", 0);
				}
				
			}
			
			
			$this->db->from('user');
			
			if($for_list){
				
				$this->db->order_by('user_id',"desc");

				$this->db->limit($lim_to,$lim_from);

				$rs = $this->db->get();

				
				
				foreach($rs->result_array() as $row){

					$data[] = $row;

					/* $data[] = array(

					'user_id'=>$row->user_id,

					'username' => $row->username,

					'fname' => $row->fname,

					'lname' => $row->lname,

					'email' => $row->email,

					'reg_date' => $row-> reg_date,

					'logo' => $row->logo,

					'country' => $row->country,

					'city' => $row->city,

					'acc_balance' => $row-> acc_balance,
					'account_type' => $row-> account_type,

					'edit_date' => $row->edit_date,

					'reg_date' => $row-> reg_date,

					'status' => $row->status,
					'verify' => $row->verify,

					'membership_plan' => $row->membership_plan,

					'membership_upgrade' => $row->membership_upgrade

					);
 */
				

				}
				
			}else{
				
				$data = $this->db->get()->num_rows();
			}
           

            return $data;

	}

	

	public function getcloseMemberList($lim_to,$lim_from)

	{ // 	user_id	username	password	fname	lname	gender	status	email	mobile	address	country	zip	image	reg_date	edit_date	ldate	v_stat	ip	acc_balance	slogan	logo	overview	work_experience	hourly_rate	qualification	certification	education	asclient_aboutus	membership_plan	membership_start	membership_end

            $this->db->select('*');

            $this->db->order_by('user_id',"desc");

			$this->db->where('status','C');

			$this->db->limit($lim_to,$lim_from);

			

			

            $rs = $this->db->get('user');

            $data = array();

			

			

            foreach($rs->result() as $row)

            {

                /*$rss=$this->db->get_where('company',array("comp_id"=>$row->comp_id));

		$al=$rss->row();*/

                $data[] = array(

			'user_id'=>$row->user_id,

			'username' => $row->username,

			'fname' => $row->fname,

			'lname' => $row->lname,

			'email' => $row->email,

			'reg_date' => $row-> reg_date,

			'logo' => $row->logo,

			'country' => $row->country,

			'city' => $row->city,

			'acc_balance' => $row-> acc_balance,

			'edit_date' => $row->edit_date,

			'reg_date' => $row-> reg_date,

			'membership_plan' => $row->membership_plan,

			'membership_upgrade' => $row->membership_upgrade

			);

			

            }

            return $data;

	}

	

	public function getplanMemberList($lim_to,$lim_from,$plan="")

	{ // 	user_id	username	password	fname	lname	gender	status	email	mobile	address	country	zip	image	reg_date	edit_date	ldate	v_stat	ip	acc_balance	slogan	logo	overview	work_experience	hourly_rate	qualification	certification	education	asclient_aboutus	membership_plan	membership_start	membership_end

            $this->db->select('*');

            $this->db->order_by('user_id',"desc");

			$this->db->limit($lim_to,$lim_from);

			if($plan !=""){

			$this->db->where('membership_plan',$plan);

			}

			

            $rs = $this->db->get('user');

            $data = array();

			

			

            foreach($rs->result() as $row)

            {

                /*$rss=$this->db->get_where('company',array("comp_id"=>$row->comp_id));

		$al=$rss->row();*/

                $data[] = array(

			'user_id'=>$row->user_id,

			'username' => $row->username,

			'fname' => $row->fname,

			'lname' => $row->lname,

			'email' => $row->email,

			'reg_date' => $row-> reg_date,

			'logo' => $row->logo,

			'country' => $row->country,

			'city' => $row->city,

			'acc_balance' => $row-> acc_balance,

			'edit_date' => $row->edit_date,

			'reg_date' => $row-> reg_date,

			'status' => $row->status,

			'membership_plan' => $row->membership_plan,

			'membership_upgrade' => $row->membership_upgrade

			);

			

            }

            return $data;

	}

	

	public function getFilterMemberList($key)

	{ 

            $this->db->select('*');

			$this->db->like('fname',$key);

			$this->db->or_like('lname',$key);

			$this->db->or_like('username',$key);

			$this->db->or_like('email',$key);

            $this->db->order_by('user_id');

			

			

			

            $rs = $this->db->get('user');

            $data = array();

			

			

            foreach($rs->result() as $row)

            {

                $data[] = array(

			'user_id'=>$row->user_id,

			'username' => $row->username,

			'fname' => $row->fname,

			'lname' => $row->lname,

			'email' => $row->email,

			'reg_date' => $row-> reg_date,

			'logo' => $row->logo,

			'country' => $row->country,

			'city' => $row->city,

			'acc_balance' => $row-> acc_balance,

			'edit_date' => $row->edit_date,

			'reg_date' => $row-> reg_date,

			'status' => $row->status,

			'membership_plan' => $row->membership_plan,

			'membership_upgrade' => $row->membership_upgrade

			);

			

            }

            return $data;

	}

        

	public function get_user_details($uid){

	

		$this->db->select('*');

		$this->db->where(array('user_id'=>$uid));

        $this->db->from("user");

		$rs = $this->db->get();

		$data = array();

		

	foreach ($rs->result() as $row) {

		$data = array(

			'user_id' =>$row->user_id,

			'fname' => $row->fname,

			'lname' => $row->lname,

			'email' =>$row->email,

			'country' =>$row->country,

			'zip'	  => $row->zip,

			'image'   => $row->logo,

			'acc_balance' =>$row->acc_balance,

			'overview' => $row->overview,

			'work_experience'=> $row->work_experience,

			'hourly_rate'=> $row->hourly_rate,

			'qualification' => $row->qualification,

			'certification' => $row->certification,

			'education'	=> $row->education,

			'asclient_aboutus' => $row->asclient_aboutus,

			'membership_plan' => $row->membership_plan,

			'membership_upgrade' => $row->membership_upgrade

			);

		}

	return $data;

	

	

	

	}

	

	

	

	

	public function get_user_skill($uid){

	

		$user_skill  = $this->auto_model->getFeild('skills_id','user_skills','user_id',$uid);

		$skillArray =  explode(",",$user_skill);

		$data =  array();

		foreach($skillArray as $item){

			$data[] = $this->auto_model->getFeild('skill_name','skills','id',$item);

			}

			

			

		return $data;

	}

	

	

	

	public function get_sub_skill($pid){

		$this->db->select('id,skill_name,parent_id');

		$this->db->where(array('parent_id'=>$pid));

        $this->db->from("skills");

		$rs = $this->db->get();

		$data = array();

		foreach ($rs->result() as $row) {

		

			$data [] = array(

					'id'=> $row->id,

					'skill_name'=> $row->skill_name,

					'parent_id'=> $row->parent_id

					

					

			);

			

			}

		

		

		return $data;

	

	}

	

	public function get_all_p_skill(){

	

		$this->db->select('id,skill_name,parent_id');

		$this->db->where(array('parent_id'=>0));

        $this->db->from("skills");

		$rs = $this->db->get();

		$data = array();

		

		foreach ($rs->result() as $row) {

		

			$data [] = array(

					'id'=> $row->id,

					'skill_name'=> $row->skill_name,

					'parent_id'=> $row->parent_id

					

					

			);

			

			}

		

		

		return $data;

		

	}

	

	public function get_user_applied($uid){

	

		$this->db->select('*');

		$this->db->where(array('bidder_id'=>$uid));

		$this->db->order_by('add_date',"desc");

        $this->db->from("bids");

		

		$rs = $this->db->get();

		$data = array();

		

		foreach ($rs->result() as $row) {

		

			$data [] = array(

				'project_id'   => $row->project_id,

				'job_details'  => $this->getjobDetails($row->project_id),

				'details'      => $row->details,

				'bidder_amt'   => $row->bidder_amt,

				'total_amt'	   => $row->total_amt,

				'days_required'=> $row->days_required,

				);

		}

		return $data;

	

	

	

	}

	

	

	public function get_user_transition($uid){

	

		$this->db->select('*');

		$this->db->where(array('user_id'=>$uid));

		$this->db->order_by('transction_date',"desc");

        $this->db->from("transaction");

		

		$rs = $this->db->get();

		$data = array();

		

		foreach ($rs->result() as $row) {

		

			$data [] = array(

				'paypal_transaction_id'   => $row->paypal_transaction_id,

				'amount'  => $row->amount,

				'transction_type' => $row->transction_type,

				'transaction_for'   => $row->transaction_for,

				'transction_date'	   => $row->transction_date

				);

		}

		return $data;

	

	

	

	}

	

	

	public function get_user_message($uid){

	

		$this->db->select('id,project_id');

		$this->db->where(array('sender_id'=>$uid));

		$this->db->group_by('project_id');

        $this->db->from("message");

		$rs = $this->db->get();

		$data = array();

		foreach ($rs->result() as $row) {

			$data [] = array(

				'project_title' => $this->auto_model->getFeild('title','projects','project_id',$row->project_id),

				'id'  	=> $row->id,

				'message' => $this->get_all_message($row->project_id)

				);

		}

		

		return $data;

	

		}

	

	

	

	public function get_all_message($pid){

	$this->db->select('recipient_id,sender_id,message,add_date,project_id');

		$this->db->where(array('project_id'=>$pid));

        $this->db->from("message");

		$rs = $this->db->get();

		$data = array();

		foreach ($rs->result() as $row) {

			$data [] = array(

				'send_to' => $this->auto_model->getFeild('fname','user','user_id',$row->recipient_id).' '. $this->auto_model->getFeild('lname','user','user_id',$row->recipient_id),

				'add_date'  	=> $row->add_date,

				'send_from' => $this->auto_model->getFeild('fname','user','user_id',$row->sender_id).' '. $this->auto_model->getFeild('lname','user','user_id',$row->sender_id),

				'project_name'  =>$this->auto_model->getFeild('title','projects','project_id',$row->project_id),

				'message' => $row->message

				);

		}

	

	return $data;

	

	}

	public function getjobDetails($pid){

		$this->db->select('title,skills');

		$this->db->where(array('project_id'=>$pid));

        $this->db->from("projects");

		$rs = $this->db->get();

		$data = array();

		foreach ($rs->result() as $row) {

		

			$data  = array(

				'title'   => $row->title,

				'skills'  => $row->skills

				

				);

		}

	

		return $data;

	

	}

	

	

	public function get_user_portfolio($uid){

	

		$this->db->select('*');

		$this->db->where(array('user_id'=>$uid));

        $this->db->from("user_portfolio");

		$rs = $this->db->get();

		$data = array();

		

	foreach ($rs->result() as $row) {

		$data [] = array(

			'title' => $row->title,

			'description'=> $row->description,

			'tags' => $row->tags,

			'url' => $row->url,

			'thumb_img' => $row->thumb_img,

			

			);

	

		}

	return $data;

	

	

	}

	

	public function get_user_referee($uid){

	

		$this->db->select('*');

		$this->db->where(array('user_id'=>$uid,'status'=>'Y'));

        $this->db->from("references");

		$rs = $this->db->get();

		$data = array();

		

	foreach ($rs->result() as $row) {

		$data [] = array(

			'id' => $row->id,

			'name' => $row->name,

			'company'=> $row->company,

			'contact_name' => $row->contact_name,

			'email' => $row->email,

			'phone_no' => $row->phone_no,

			'add_date' => $row->add_date,

			'rating_status' => $row->rating_status,

			'admin_review' => $row->admin_review

			);

	

		}

	return $data;

	

	

	}

	

	public function updateField($uid, $data){

	

		$this->db->where('user_id',$uid);

		return $this->db->update('user',$data);

	

	

	}

	public function updateReviewStatus($data,$id){

	

		$this->db->where('id',$id);

		return $this->db->update('references',$data);

	

	}

	

	public function update_user_skill($data,$uid){

		$this->db->where('user_id',$uid);

		return $this->db->update('user_skills',$data);

	

	}

	

	 public function getAllMember($user_id = 0, $limit_to = '0', $limit_from = '0', $letter = '0') {

        $this->db->select('*');

        //if($limit_to='' && $limit_from='0')

        $this->db->limit($limit_from, $limit_to);

        $this->db->order_by('user_id', 'desc');

        $this->db->from("user");

        if ($user_id != 0) {

            $run = "FIND_IN_SET('" . $user_id . "', user_id)";

            $this->db->where($run);

        }

        if ($letter != '0') {

            $this->db->like('fname', $letter, 'after');

			

        }

        $rs = $this->db->get();

        //echo $this->db->last_query();die;

        $data = array();

        foreach ($rs->result() as $row) {

            $data[] = array(

                'id' => $row->user_id,

                'fname' => $row->fname,

                //'cat_id' => $row->cat_id,

                //'cat_name' => $this->getCatName($row->cat_id),

                'status' => $row->status

            );

        }





      //  echo "<pre>";

       // print_r($data);die;

        echo $this->db->last_query();die;

       // return $data;

    }	

		

		

		 public function countRecord($user_id = 0, $letter = '0') {

        $this->db->select('count(*) as total');

        $this->db->from("user");

        if ($user_id != 0) {

            $run = "FIND_IN_SET('" . $user_id . "', user_id)";

            $this->db->where($run);

        }

        if ($letter != '0') {

            $this->db->like('fname', $letter, 'after');

        }

        $rs = $this->db->get();



        //$rs = $this->db->get_where('search_brand');

        foreach ($rs->result() as $row) {

            return $row->total;

        }

    }

		

		

		

		

       /*

	public function getAllCheckList()

	{

		$this->db->select('*');

		$this->db->order_by('varify_id');

		$rs = $this->db->get('varify_record');

		$data = array();

		foreach($rs->result() as $row)

		{		

			$data[] = array(

				'varify_id' => $row->varify_id,

				'text' => $row->text,				

				'when' => $row->when,

				'status' => $row->status

			);

			

		}

		return $data;

	}        

        */

	

	public function add_membership($data)

	{

		return $this->db->insert('membership_plan',$data);

	}

	

	public function updateMemberStatus($data,$id)

	{

			

            $this->db->where('user_id',$id);

            return $this->db->update('user',$data);

	}

        

        public function updateMember($data,$id)

	{

            $this->db->where('user_id',$id);

            $this->db->update('user',$data);
			
			$wallet_count = $this->db->where('user_id', $id)->count_all_results('wallet');
			
			if($wallet_count == 0){
				$this->db->insert('wallet', array('user_id' => $id, 'title' => $data['fname'].' '.$data['lname'], 'balance' => 0));
			}
			
			return TRUE;

	}

	

	public function getMemberUsingId($id)

	{

		$this->db->select('user_id,logo,email,fname,lname,status,gender,country,city,zip,verify,membership_plan,phone,company,account_type');

		$this->db->order_by("user_id","desc");

                $rs = $this->db->get_where('user',array('user_id'=>$id));

                

		$data = array();

		$row=$rs->row_array();
		$data = $row;
		$data['image'] = $row['logo'];
		/* $data = array(

			'user_id' => $row->user_id,

                        'image' => $row->logo,

                        'email' => $row->email,

                        'fname' => $row->fname,

                        'lname' => $row->lname,

                        'gender' => $row->gender,

                        'country' => $row->country,

						'city' => $row->city,

                        'zip' => $row->zip,

                        'status' => $row->status,

						'logo'=>$row->logo,

						'verify'=>$row->verify,

						'membership_plan' => $row->membership_plan

                              ); */

			

		/*echo "<pre>";

		print_r($data);die;*/

		return $data;

	}

	

	public function getAllSearchData($usr_select,$search_element,$id)

	{

		$this->db->select('*');

		$this->db->order_by('ord','desc');

		if($usr_select == 'footer_id')

			$this->db->like($usr_select, trim($search_element), 'none'); 

		else

			$this->db->like($usr_select, trim($search_element), 'after'); 

			

		$rs = $this->db->get_where('footer_management',array('footer_parent_id'=>$id));

		$data = array();

		foreach($rs->result() as $row)

		{

			$data[] = array(

				'footer_id' => $row->footer_id,

				'footer_cat_name' => $row->footer_cat_name,

				'footer_parent_id' => $row->footer_parent_id,

				'footer_link' => $row->footer_link,

				'ord' => $row->ord,

				'footer_status' => $row->footer_status

			);

		}

		return $data;

			

	}

	

	public function deleteMember($id)

	{

		return $this->db->delete('user', array('user_id' => $id)); 

	}

	

        public function getAllcountry()

	{

		$this->db->select('*');

		$rs = $this->db->get('countries');

		$data=array();

		foreach($rs->result() as $row)

		{

			$data[]=array(

			'code'=>$row->code,

			'name'=>$row->name

			);

		}

		return $data;

	}

        

        

	public function getCompany()

	{

		$this->db->select('*');

		$this->db->order_by('comp_id','desc');

		$rs = $this->db->get_where('company',array('status'=>'Y'));

		$data = array();

		foreach($rs->result() as $row)

		{

			$data[] = array(

				'comp_id' => $row->comp_id,

				'name' => $row->name

			);

			

		}

		/*echo "<pre>";

		print_r($data);die;*/

		return $data;

	}

	public function record_count_member() 

	{

          return $this->db->count_all('membership_plan');

        }

        

	public function record_close_member() 

	{

		$this->db->select('user_id');

		$this->db->where('status','C');

		$this->db->from('user');

          return $this->db->count_all_results();

    }

        

	public function record_count_checklist() 

	{

          return $this->db->count_all('varify_record');

        }        

        

	

	public function getProd($prod)

	{

		$this->db->select('comp_id');

		$this->db->like("name",$prod);

		$r = $this->db->get('company');

		$dt=array();

		foreach($r->result() as $rw)

		{

			$dt[]=array(

			"comp_id"=>$rw->comp_id

			);

		}

		//echo $dt[0]['comp_id']; die();

		$this->db->select('*');

		$this->db->like("product_name",$prod);

		if(count($dt)>0)

		{

		$this->db->or_like("comp_id",$dt[0]['comp_id']);

		}

		$this->db->or_like("product_no",$prod);

		$this->db->or_like("nafdac_no",$prod);

		$this->db->or_like("manufacture_date",$prod);

		$this->db->or_like("expire_date",$prod);

		$this->db->order_by('prod_id','desc');

		$rs = $this->db->get('product');

		$data = array();

		foreach($rs->result() as $row)

		{

			

		$rss=$this->db->get_where('company',array("comp_id"=>$row->comp_id));

		$al=$rss->row();

			$data[] = array(

				'id' => $row->prod_id,

				'name' => $row->product_name,

				'company' => $al->name,

				'model_no' => $row->model_no,

				'product_no' => $row->product_no,

				'manufacture_date'=>$row->manufacture_date,

				'expire_date'=>$row->expire_date,

				'nafdac_no'=>$row->nafdac_no,

				'phone'=>$row->phone,

				'email'=>$row->email,

				'status' => $row->status

			);

			

		}

		return $data;

	}

        

	public function getchkProd($prod)

	{       

                $s= strtoupper(substr($prod, 0, 1));

		$this->db->select('*');

		

		$this->db->or_like("varify_id",$prod);

		$this->db->or_like("text",$prod);

		$this->db->or_like("when",$prod);                

                $this->db->or_like("status",$s);

		$rs = $this->db->get('varify_record');

		$data = array();

		foreach($rs->result() as $row)

		{

			

			$data[] = array(

				'varify_id' => $row->varify_id,

				'text' => $row->text,

				'when'=>$row->when,

				'status' => $row->status

			);

			

		}

		return $data;

	}  

	

	public function add_user($post) {

        $data = array(

            'fname' => $post['fname'],

			'lname' => $post['lname'],

			'username' => $post['username'],

			'email' => $post['email'],

            'country' => $post['country'],

			'city' => $post['city'],

            'reg_date' => date('Y-m-d h:i:s'),

			'membership_plan' => '1',

			'password' => md5($post['password']),
			
			'account_type' => !empty($post['account_type']) ? $post['account_type'] : 'F',

            'status' => $post['status']);

       $this->db->insert('user', $data);
		
		$user_id = $this->db->insert_id();
		
		return $this->db->insert('wallet', array('user_id' => $user_id, 'title' => $post['fname'].' '.$post['lname'], 'balance' => 0));
		

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

	

   public function getCity($ccode){ 

       $this->db->select("Name,ID");

       $res=  $this->db->get_where("city",array("CountryCode"=>$ccode));

       

       $data=array();

       

       foreach ($res->result() as $row){ 

           $data[]=array(            

              "name" => $row->Name,
              "id" => $row->ID,

           );

       }

       return $data;

   } 

   

   public function getFeild($select, $table, $feild = "", $value = "", $where = null, $limit_from = 0, $limit_to = 0) {

        $this->db->select($select);

        if ($value != '' AND $feild != '') {

            if ($limit_from > 0) {

                $rs = $this->db->get_where($table, array($feild => $value), $limit_to, $limit_from);

            } else {

                $rs = $this->db->get_where($table, array($feild => $value));

            }

        } else {

            if ($limit_from > 0) {

                $rs = $this->db->get_where($table, $where, $limit_to, $limit_from);

            } else {

                $rs = $this->db->get_where($table, $where);

            }

        }

        //echo $this->db->last_query();

        $data = '';

        foreach ($rs->result() as $row) {

            $data = $row->$select;

        }

        return $data;

    }  	

	

	public function getAllCity()

	{

		$this->db->select('*');

		$rs = $this->db->get('cities');

		$data=array();

		foreach($rs->result() as $row)

		{

			$data[]=array(

			'id'=>$row->id,

			'city'=>$row->city

			);

		}

		return $data;

	}

	

	public function getReview($refer_id,$user_id)

	{

		$this->db->select();

		$this->db->where('refer_id',$refer_id);

		$this->db->where('user_id',$user_id);

		$res=$this->db->get('referer_review');

		$data=array();

		foreach($res->result() as $row)

		{

			$data[]=array(

			'safety'=>$row->safety,

			'flexiblity'=>$row->flexiblity,

			'performence'=>$row->performence,

			'initiative'=>$row->initiative,

			'knowledge'=>$row->knowledge,

			'average'=>$row->average,

			'comments'=>$row->comments

			);	

		}

		return $data;

	}

	

	public function insertTransaction($data)

	{

		return $this->db->insert('transaction',$data);

	}

	

	public function getMembership()

	{

		$this->db->select('id,name');

                $this->db->order_by("id","desc");

		$res=$this->db->get('membership_plan');	

		$data=array();

		foreach($res->result() as $row)

		{

			$data[]=array(

			'id'=>$row->id,

			'name'=>$row->name

			);	

		}

		return $data;

	}
	
	public function countActiveProject($user_id=''){
		$today = date('Y-m-d');
		$status_in = array('O', 'P', 'PS');
		$this->db->where('user_id', $user_id);
		$this->db->where_in('status', $status_in);
		$this->db->where('expiry_date >=', $today);
		$count = $this->db->count_all_results('projects');
		
		return $count;
	}

	public function checkEmployerPendingPayment($user_id=''){
		$amount = 0;
		$this->db->select('p.project_id,m.id as milestone_id, m.amount as milestone_amount')
			->from('projects p')
			->join('project_milestone m', "p.project_id=m.project_id AND p.project_type = 'F'", 'INNER');
			
		$this->db->where('p.user_id', $user_id);
		$this->db->where('m.status', 'A');
		$this->db->where('m.fund_release', 'P');
		$result1 = $this->db->get()->result_array();
		if($result1){
			foreach($result1 as $k => $v){
				$amount += $v['milestone_amount'];
			}
		}
		
		$this->db->select("p.project_id, p_t.worker_id,p_t.hour,p_t.minute")
			->from('projects p')
			->join('project_tracker p_t', "p.project_id=p_t.project_id AND p.project_type = 'H'", 'INNER');
		$this->db->where('p.user_id', $user_id);
		$this->db->where('p_t.payment_status <>', 'P');
		$this->db->where('p_t.payment_status <>', 'C');
		$result2 = $this->db->get()->result_array();
		if($result2){
			$data=get_row(array('select'=>'total_amt,pausedcontract','from'=>'bids', 'where'=>array('project_id'=>$v['project_id'],'bidder_id'=>$v['worker_id'])));
			$client_amt = $data['total_amt']; // hourly rate
			$minute_cost_min = ($client_amt/60);
			$total_min_cost = $minute_cost_min *floatval($v['minute']);
			$total_cost_new=(($client_amt*floatval($v['hour']))+$total_min_cost);
			$amount += $total_cost_new;
		}
		
		
		return $amount;
	}
	
	public function countActiveProjectFreelancer($user_id=''){
		$total_active = 0;
		$today = date('Y-m-d');
		$status_in = array('O', 'P', 'PS');
		$this->db->where("FIND_IN_SET('$user_id', bidder_id) > 0");
		$this->db->where("project_type = 'F'");
		$this->db->where_in('status', $status_in);
		$this->db->where('expiry_date >=', $today);
		$count = $this->db->count_all_results('projects');
		
		$this->db->select('p.project_id')
			->from('project_schedule ps')
			->join('projects p', "p.project_id=ps.project_id AND p.project_type='H'", 'INNER');
			
		$this->db->where_in('p.status', $status_in);
		$this->db->where('p.expiry_date >=', $today);
		$this->db->where('ps.freelancer_id', $user_id);
		$this->db->where('ps.is_project_start', 1);
		$this->db->where('ps.is_contract_end', 0);
		$this->db->group_by('ps.project_id');
		$count2 = $this->db->get()->num_rows();
		
		$total_active = $count + $count2;
		
		return $total_active ;
	}
	
	public function checkFreelancerPendingPayment($user_id=''){
		$amount = 0;
		$this->db->select('p.project_id,m.id as milestone_id, m.amount as milestone_amount')
			->from('projects p')
			->join('project_milestone m', "p.project_id=m.project_id AND p.project_type = 'F'", 'INNER')
			->join('bids b', "b.id=m.bid_id", 'INNER');
			
		$this->db->where('b.bidder_id', $user_id);
		$this->db->where('m.status', 'A');
		$this->db->where('m.fund_release', 'P');
		$result1 = $this->db->get()->result_array();
		if($result1){
			foreach($result1 as $k => $v){
				$amount += $v['milestone_amount'];
			}
		}
		
		$this->db->select("p.project_id, p_t.worker_id,p_t.hour,p_t.minute")
			->from('projects p')
			->join('project_tracker p_t', "p.project_id=p_t.project_id AND p.project_type = 'H'", 'INNER');
		$this->db->where('p_t.worker_id', $user_id);
		$this->db->where('p_t.payment_status <>', 'P');
		$this->db->where('p_t.payment_status <>', 'C');
		$result2 = $this->db->get()->result_array();
		if($result2){
			$data=get_row(array('select'=>'total_amt,pausedcontract','from'=>'bids', 'where'=>array('project_id'=>$v['project_id'],'bidder_id'=>$v['worker_id'])));
			$client_amt = $data['total_amt']; // hourly rate
			$minute_cost_min = ($client_amt/60);
			$total_min_cost = $minute_cost_min *floatval($v['minute']);
			$total_cost_new=(($client_amt*floatval($v['hour']))+$total_min_cost);
			$amount += $total_cost_new;
		}
		
		
		return $amount;
	}
	
	public function get_user_document($user_id=''){		return $this->db->where('user_id', $user_id)->get('user_documents')->result_array();	}

}

