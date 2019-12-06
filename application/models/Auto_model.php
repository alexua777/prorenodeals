<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Auto_Model extends BaseModel {

    public function __construct() {
        parent::__construct();
		$idiom = $this->session->userdata('lang');
		$this->lang->load('global', $idiom);
		
		$query = $this->db->get( 'setting' );
		foreach( $query->result() as $filed=>$val ){

			define('ADMIN_EMAIL', $val->admin_mail); 
			define('ADMIN_PHONE', $val->contact_no); 
			define('ADMIN_FACEBOOK', $val->facebook);
			define('ADMIN_TWITTER', $val->twitter);
			define('ADMIN_PINTEREST', $val->pinterest);
			define('ADMIN_LINKEDIN', $val->linkedin);
			define('ADMIN_GOOGLE', $val->google_plus);
			define('ADMIN_RSS', $val->rss);
			define('EMAIL_VERI', $val->email_verify);
			define('TOTAL_BID', $val->total_bid);
			define('TOTAL_POST', $val->total_post);
			define('FIXED_RATE', $val->fix_featured_charge);
			define('HOURLY_RATE', $val->featured_charge_hourly);
			define('CURRENCY', $val->currency);
			define('PAYPAL', $val->paypal_mail);
			define('PAYPAL_MODE', $val->paypal_mode);
			define('BANK_AC', $val->bank_ac);
			define('BANK_AC_NAME', $val->bank_ac_name);
			define('BANK_NAME', $val->bank_name);
			define('BANK_ADDRESS', $val->bank_address);
			define('JOB_EXPIRATION', $val->job_expiration);
			define('YOUR_APP_ID', $val->my_app_id); 
			define('YOUR_APP_SECRET', $val->my_app_secret);
			define('SITE_FAVICON', $val->favicon);
			define('SITE_LOGO', $val->site_logo);
			define('ESCROW_CHARGE', $val->escrow_charge);
			define('BAD_WORDS', $val->bad_words);
			define('DEMO', $val->demo);
			define('SKRILL', $val->skrill_mail);
			define('SITE_TITLE', $val->site_title);
			define('ADMIN_ADDRESS', $val->corporate_address);

		}
		
		
		$q2 = $this->db->get( 'finance_constants' );
		foreach( $q2->result() as $k=>$v ){
			define($v->key, $v->value);
		}

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
	
	public function date_format($dateformat) {
	    $timestamp = strtotime($dateformat);
		$date = date("d M, Y",$timestamp);
        return $date;
    }
	
    public function send_email($from,$to,$template,$data_parse){
	
			$mailcontent=$this->auto_model->getaldata('template,subject','mailtemplate','type',$template);
			//print_r($mailcontent); die();
			foreach($mailcontent as $key=>$val){
			$contents=$val['body'];
			$subject=$val['subject'];
			}
			
			
			//$this->load->library('email');
			
			
			
			 $config = Array(
				'protocol' => 'smtp',
				'smtp_host' => 'mail.demoscript.website',
				'smtp_port' => 587,
				'smtp_user' => "info@demoscript.website",
				'smtp_pass' => "kH6n3!pCq;(M",
				'mailtype'  => 'html', 
				'charset'   => 'iso-8859-1'
			);
			$this->load->library('email', $config);
			$this->email->set_newline("\r\n"); 
			
			//$this->email->from($from, ADMIN_EMAIL);
			$this->email->from('info@demoscript.website');
			$this->email->to($to); 
			$this->email->reply_to($from); 
			$this->email->subject($subject);
			$this->email->set_mailtype("html");
			foreach($data_parse as $key=>$val){
	
				$contents=str_replace('{'.trim($key).'}',$val,$contents);
			}
			$contents=str_replace('src="/','src="'.VPATH,$contents);
			$contents=html_entity_decode($contents);			
			$this->email->message($contents);	

			return $this->email->send();
			//echo $this->email->print_debugger(); die; 

	}

	
	public function send_emailone($from,$to,$template,$data_parse){
	
			$mailcontent=$this->auto_model->getaldata('template,subject','mailtemplate','type',$template);
			/*print_r($mailcontent); die();*/
			foreach($mailcontent as $key=>$val){
			$contents=$val['body'];
			$subject=$val['subject'];
			}
			$this->load->library('email');

			//echo ADMIN_EMAIL; die;
			$this->email->from($from, ADMIN_EMAIL);
			$this->email->to($to); 
			$this->email->subject($subject);
			$this->email->set_mailtype("html");
			foreach($data_parse as $key=>$val){
	
				$contents=str_replace('{'.trim($key).'}',$val,$contents);
			}
			$contents=str_replace('src="/','src="'.VPATH,$contents);
			$contents=html_entity_decode($contents);			
			$this->email->message($contents);	

			return $this->email->send();
			//echo $this->email->print_debugger(); die;
	}
        
        public function getalldata($attr,$table,$by,$value,$limit=''){
	$this->db->select($attr);
	if($limit!='')
	{
		$this->db->limit($limit);	
	}
	if($by!='' && $value!='')
	{
		$this->db->where($by,$value);	
	}	
	$rs = $this->db->get($table);
	 $data = array();
	 
	 foreach ($rs->result() as $key=>$row){
	  $data["'".$key."'"] = $row;
	 }
	 return $data;
	
	}
	public function checkrequestajax(){
	if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
	
	}else{
		die('error ');
	}
	}
    public function get_user_data($user_id) {
        $this->db->select();
        $query = $this->db->get_where("user", array("id" => $user_id));
        $result = array();
        foreach ($query->result() as $row) {
            $result['user_type'] = $row->user_type;
            $result['full_name'] = $row->full_name;
            $result['user_img'] = $row->user_img;
            $result['country'] = $row->country;
            $result['state'] = $row->state;
            $result['city'] = $row->city;
            $result['email'] = $row->email;
            $result['mobile'] = $row->mobile;
            $result['zip'] = $row->zip;
        }
        return $result;
    }

    public function get_fb_auth_id($user_id) {
        $fb_auth_id = $this->getFeild("fb_auth_no", "user", "id", $user_id);
        return $fb_auth_id;
    }

    public function user_log_check($get_result = 'N') {
        $user_id = 0;
        $user_id = $this->session->userdata('fab_user_id');
        if ($user_id == '' OR $user_id == 0) {
            if ($get_result == 'Y') {
                return FALSE;
            } else {
                redirect(base_url() . 'user/login');
            }
        } else {
            return TRUE;
        }
    }

    //..............................................................................................//
    //                              Get Geo location from google                                    //
    //                                  pass complete address                                       //
    //                    returns country, state, city, latitude, longitude                         //
    //                              Developed by Somnath Mukherjee                                  //
    //..............................................................................................//

    public function reverse_geocode($address) {
        $address = str_replace(" ", "+", "$address");
        $url = "http://maps.google.com/maps/api/geocode/json?address=$address&sensor=false";
        $result = file_get_contents("$url");
        $json = json_decode($result);
        $city = '';
        $state = '';
        $country = '';
        $latitude = '';
        $lngitude = '';

        foreach ($json->results as $result) {
            foreach ($result->address_components as $addressPart) {
                if ((in_array('locality', $addressPart->types)) && (in_array('political', $addressPart->types)))
                    $city = $addressPart->long_name;
                else if ((in_array('administrative_area_level_1', $addressPart->types)) && (in_array('political', $addressPart->types)))
                    $state = $addressPart->long_name;
                else if ((in_array('country', $addressPart->types)) && (in_array('political', $addressPart->types)))
                    $country = $addressPart->long_name;
            }
            /* foreach ($result->geometry as $geo_loc) {
              if ($geo_loc->lat != '' && $geo_loc->lng != '') {
              $latitude = $geo_loc->lat;
              $lngitude = $geo_loc->lng;
              }
              } */
            if ($latitude == '' && $lngitude == '') {
                $latitude = $result->geometry->location->lat;
                $lngitude = $result->geometry->location->lng;
            }
        }

        if (($city != '') && ($state != '') && ($country != ''))
            $address = $city . ', ' . $state . ', ' . $country;
        else if (($city != '') && ($state != ''))
            $address = $city . ', ' . $state;
        else if (($state != '') && ($country != ''))
            $address = $state . ', ' . $country;
        else if ($country != '')
            $address = $country;

        // return $address;
        return "$country/$state/$city/$latitude/$lngitude";
    }

    //..............................................................................................//
    //                                    Get City locations                                        //
    //                        pass state id(optional), city id(optional)                            //
    //                              returns city details in array                                   //
    //                              Developed by Somnath Mukherjee                                  //
    //..............................................................................................// 

    public function get_city_details($state_id = '', $city_id = '', $limit = 0) {
        $this->db->select();
        $this->db->order_by("city_name");
        //$this->db->from('city');
        $condition = array();
        $condition['status'] = 'Y';

        if ($state_id != '') {
            //$query = $this->db->where("state_id", $state_id);
            $condition["state_id"] = $state_id;
        }

        if ($city_id != '') {
            $condition['id'] = $city_id;
        }

        if ($limit > 0) {
            $query = $this->db->get_where("city", $condition, $limit);
        } else {
            $query = $this->db->get_where("city", $condition);
        }

        $result = array();
        foreach ($query->result() as $row) {
            $result[] = array(
                'id' => $row->id,
                'state_id' => $row->state_id,
                'city_name' => $row->city_name,
                'city_img' => $row->city_img
            );
        }
        return $result;
    }

    //..............................................................................................//
    //                                    Get State locations                                       //
    //                        pass state id(optional), country id(optional)                         //
    //                                returns state list in array                                   //
    //                              Developed by Somnath Mukherjee                                  //
    //..............................................................................................// 

    public function get_state_list($state_id = '', $country_id = '', $limit = 0) {
        $this->db->select();
        $this->db->order_by('order_id');

        $condition = array();
        $condition['status'] = 'Y';

        if ($state_id != '') {
            $condition["id"] = $state_id;
        }

        if ($country_id != '') {
            $condition['country_id'] = $country_id;
        }

        if ($limit > 0) {
            $query = $this->db->get_where("state", $condition, $limit);
        } else {
            $query = $this->db->get_where("state", $condition);
        }

        $result = array();
        foreach ($query->result() as $row) {
            $result[] = array(
                'id' => $row->id,
                'state_name' => $row->state_name
            );
        }
        return $result;
    }

    //..............................................................................................//
    //                                Get locations from Zip code                                   //
    //                                       pass Zip code                                          //
    //                           returns latitude, longitude in array                               //
    //                              Developed by Somnath Mukherjee                                  //
    //..............................................................................................// 

    public function get_lat_long_from_zip($zip) {
        if (strlen($zip) > 0) {
            $url = "http://maps.googleapis.com/maps/api/geocode/json?address=" . urlencode($zip) . "&sensor=false";
            $result_string = file_get_contents($url);
            $result = json_decode($result_string, true);
            /* $result1[] = $result['results'][0];
              $result2[] = $result1[0]['geometry'];
              $result3[] = $result2[0]['location'];
              return $result3[0]; */


            return $result['results'][0]['geometry']['location'];
        } else {
            return false;
        }
    }

    public function getbanner($type = '', $limit_from = '', $limit_to = '') {
        $this->db->select('*');
        $this->db->limit($limit_to, $limit_from);
        $rs = $this->db->get_where('banner', array('status' => 'Y', 'type' => $type));
        $data = array();
        foreach ($rs->result() as $row) {
            $data[] = array(
                'id' => $row->id,
                'type' => $row->type,
                'image' => $row->image
            );
        }
        return $data;
    }
	
	    public function get_setting() {
        $this->db->select('*');
        $rs = $this->db->get_where('setting');
        $data = array();
        foreach ($rs->result() as $row) {
            $data[] = array(
                'facebook' => $row->facebook,
                'twitter' => $row->twitter,
				'pinterest' => $row->pinterest,
				'linkedin' => $row->linkedin,
				'google_plus' => $row->google_plus,
				'site_title' => $row->site_title,
				'meta_desc' => $row->meta_desc,
				'meta_keys' => $row->meta_keys,
				'admin_mail' => $row->admin_mail,
				'support_mail' => $row->support_mail,
				'paypal_mail' => $row->paypal_mail,
				'contact_no' => $row->contact_no,
				'office_no' => $row->office_no,
				'telephone' => $row->telephone
            );
        }
        return $data;
    }

    public function find_taskers() {
        $this->db->select('*');
        // $this->db->limit($limit_to, $limit_from);
        $rs = $this->db->get_where('find_taskers', array('status' => 'Y'));
        $data = array();
        foreach ($rs->result() as $row) {
            $data[] = array(
                'id' => $row->id,
                'title' => $row->title,
                'button_name' => $row->button_name
            );
        }
        return $data;
    }

    public function bid_count($task_id) {
        $this->db->select('count(id) as total');
        $rs = $this->db->get_where("buyer_bid", array('task_id' => $task_id));
        foreach ($rs->result() as $row) {
            $data = $row->total;
        }
        return $data;
    }
    public function getcleanurl($name) {
		$pattern = "/[^a-zA-Z0-9]+/";
		return trim(strtolower(preg_replace($pattern, '-', $name)), '-');
		
    }
    
    public function getcategory($pid){         
        $this->db->select("cat_id,cat_name,arabic_cat_name,spanish_cat_name,swedish_cat_name");
        $con=array( 
           "parent_id" => $pid,
            "status" => "Y"
        );
        $this->db->order_by("cat_name");
        $res=$this->db->get_where("categories",$con);
        $data=array();
        
        foreach ($res->result() as $row){ 
            $data[]=array(
               "cat_id" => $row->cat_id,
               "arabic_cat_name" => $row->arabic_cat_name, 
               "spanish_cat_name" => $row->spanish_cat_name, 
               "swedish_cat_name" => $row->swedish_cat_name, 
               "cat_name" => $row->cat_name
            );
        }
        
        return $data;
    }
    public function getnumsubcat($pid){         
        $this->db->select("cat_id");
        $con=array( 
           "parent_id" => $pid,
            "status" => "Y"
        );
		$this->db->where($con);
		$this->db->from('categories');
		return $this->db->count_all_results();
    }
    
    public function getskill($pid){         
        $this->db->select("id,skill_name");
        $con=array( 
           "parent_id" => $pid,
            "status" => "Y"
        );
        $this->db->order_by("skill_name", "ASC");
        $res=$this->db->get_where("skills",$con);
        $data=array();
        
        foreach ($res->result() as $row){ 
            $data[]=array(
               "id" => $row->id,
               "skill_name" => $row->skill_name 
            );
        }
        
        return $data;
    } 

	public function getskillbyname($term=''){         
        $this->db->select("id,skill_name,parent_id");
        $con=array( 
           "parent_id <>" => '0',
            "status" => "Y"
        );
		$this->db->where($con);
		$this->db->like('skill_name', $term);
        $this->db->order_by("skill_name");
		
        $res=$this->db->get("skills")->result_array();
        $data=array();
        
		if(count($res) > 0){
			 foreach ( $res as $row){ 
				$data[]=array(
				   "id" => $row['id'],
				   "skill_name" => $row['skill_name'],
				   "parent" => $row['parent_id'] 
				);
			}
		}
       
        
        return $data;
    } 	
    
    
    public function getaldata($attr,$table,$by,$value){
	$this->db->select($attr);	
	$rs = $this->db->get_where($table,array($by=>$value));
	 $data = array();
	 
	 foreach ($rs->result() as $row){
	  $data[] = array(
	  'body'=>$row->template,
	  'subject'=>$row->subject
	  );
	 }
	 return $data;
	
   }
   public function count_results($attr,$table,$by='',$values='',$query=array())
   {
		   $this->db->select($attr);
		   if($by!='' && $values!='')
		   {
		   $this->db->where($by,$values);
		   }
		   if(is_array($query) && count($query)>0)
		   {
				$this->db->where($query);   
		   }
		   $this->db->from($table);
		   return $this->db->count_all_results();
		   
	}
	public function getCompleteness($user_id)
   {
	   $basic_info=$this->getFeild('basic_info','setting','id','1');
	   $social_info=$this->getFeild('social_info','setting','id','1');
	   $portfolio_info=$this->getFeild('portfolio_info','setting','id','1');
	   $skill_info=$this->getFeild('skill_info','setting','id','1');
	   $finance_info=$this->getFeild('finance_info','setting','id','1');
	   $portfolio_count=$this->getFeild('portfolio','membership_plan','id','4');
	   $skill_count=$this->getFeild('skills','membership_plan','id','4');
	   
		$this->db->select();
		$this->db->where('user_id',$user_id);
		$res=$this->db->get('user');
		$row=$res->result();
		
		$bcount=0;
		if($row[0]->username!='')
		{
			$bcount+=1;	
		}
		if($row[0]->fname!='')
		{
			$bcount+=1;	
		}
		if($row[0]->lname!='')
		{
			$bcount+=1;	
		}
		if($row[0]->email!='')
		{
			$bcount+=1;	
		}
		if($row[0]->city!='')
		{
			$bcount+=1;	
		}
		if($row[0]->logo!='')
		{
			$bcount+=1;	
		}
		if($row[0]->v_stat=='Y')
		{
			$bcount+=1;	
		}
		if($row[0]->acc_balance!='' ||  $row[0]->acc_balance!='0.00')
		{
			$bcount+=1;	
		}
		if($row[0]->slogan!='')
		{
			$bcount+=1;	
		}
		if($row[0]->overview!='')
		{
			$bcount+=1;	
		}
		if($row[0]->work_experience!='')
		{
			$bcount+=1;	
		}
		if($row[0]->hourly_rate!='')
		{
			$bcount+=1;	
		}
		if($row[0]->qualification!='')
		{
			$bcount+=1;	
		}
		if($row[0]->certification!='')
		{
			$bcount+=1;	
		}
		if($row[0]->education!='')
		{
			$bcount+=1;	
		}
		if($row[0]->asclient_aboutus!='')
		{
			$bcount+=1;	
		}
		if($row[0]->membership_plan!='' || $row[0]->membership_plan!='1')
		{
			$bcount+=1;	
		}
		if($row[0]->membership_upgrade!='N')
		{
			$bcount+=1;	
		}
		$basic=($bcount/18)* $basic_info;
		
		$scount=0;
		if($row[0]->facebook_link!='')
		{
			$scount+=1;	
		}
		if($row[0]->gplus_link!='')
		{
			$scount+=1;	
		}
		if($row[0]->twitter_link!='')
		{
			$scount+=1;	
		}
		if($row[0]->linkedin_link!='')
		{
			$scount+=1;	
		}
		$social=($scount/4)* $social_info;
		
		$pcount=0;
		$this->db->select('id');
		$this->db->where('user_id',$user_id);
		$this->db->from('user_portfolio');
		$pcount+=$this->db->count_all_results();
		$portfolio=($pcount/$portfolio_count)* $portfolio_info;
		
		$skcount=0;
		$skills=$this->getFeild('skills_id','user_skills','user_id',$user_id);
		$skcount=count(explode(',',$skills));
		$skill=($skcount/$skill_count)* $skill_info;
		
		$fcount=0;
		$this->db->select('account_for');
		$this->db->where('user_id',$user_id);
		$this->db->from('user_bank_account');
		$fcount+=$this->db->count_all_results();
		$finance=($fcount/2)* $finance_info;
		
		$rvcount=0;
		$this->db->select('id');
		$this->db->where('user_id',$user_id);
		$this->db->where('rating_status','Y');
		$this->db->where('admin_review','Y');
		$this->db->from('references');
		$rvcount+=$this->db->count_all_results();
		$review=($rvcount/3)* 30;
		
		return $basic+$social+$portfolio+$skill+$finance+$review;
		
		   
   }
   
   public function updateproject(){ 
    $data = array(
       'status' => "E",
    );

    $this->db->where('status',"O");
    $this->db->where('expiry_date <', date("Y-m-d"));
    $this->db->update('projects', $data); 
   }
    public function insert_data($table_name = '', $data = array()) {

	if ($table_name != '' && is_array($data)) {
		return $this->db->insert($table_name, $data);
	} else {
		return false;
	}
	}
	
	public function getSimilarJobs($type,$key,$id)
	{
		if($type=='C')
		{
			$this->db->select("title,project_id,category,skills,buget_min,buget_max");
			$res=$this->db->get_where('projects',array('category'=>$key,"project_status"=>'Y',"project_id !="=>$id),3);
			$data=array();
			foreach($res->result() as $row)
			{
				$data[]=array(
				"title"=>$row->title,
				"project_id"=>$row->project_id,
				"category"=>$row->category,
				"skills"=>$row->skills,
				"buget_min" => $row->buget_min,
				"buget_max" => $row->buget_max
				);
			}
				
		}
		elseif($type=='S')
		{
			$this->db->select("title,project_id,category,skills,buget_min,buget_max");
			$this->db->like('skills',$key);
			$res=$this->db->get_where('projects',array("project_status"=>'Y',"project_id !="=>$id),2);
			$data=array();
			foreach($res->result() as $row)
			{
				$data[]=array(
				"title"=>$row->title,
				"project_id"=>$row->project_id,
				"category"=>$row->category,
				"skills"=>$row->skills,
				"buget_min" => $row->buget_min,
				"buget_max" => $row->buget_max
				);
			}
				
		}
		return $data;	
	}
	
	 public function get_results($table_name, $query = array(), $cols = "*", $offset = '', $limit = '0', $order_by = array()) 	{
        $this->db->select($cols)->from($table_name);
        if ($query AND is_array($query)) {
            $this->db->where($query);
        }
        if (count($order_by) > 0 && is_array($order_by)) {
            foreach ($order_by as $key => $value) {
                $this->db->order_by($key, $value);
            }
        }
        if (is_numeric($offset) && is_numeric($limit)) {
            $this->db->limit($offset, $limit);
        }

        $rs = $this->db->get();
        //echo $this->db->last_query();
        $rs = $rs->result_array();

        return $rs;
    }
	public function update_data($table_name = '', $updated_data = array(), $cond_array = array()) {

        if (count($cond_array) > 0 && is_array($cond_array)) {
            $this->db->where($cond_array);
        }

        return $this->db->update($table_name, $updated_data);
    }
   
}