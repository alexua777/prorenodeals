<?php



if (!defined('BASEPATH'))

    exit('No direct script access allowed');



class Settings_model extends BaseModel {



    public function __construct() {

        return parent::__construct();

    }

	public function update_account_Setting($post){

		$data = array(

            'fix_featured_charge' => $post['fix_featured_charge'],

            'fix_non_featured_charge' => $post['fix_non_featured_charge'],

            'featured_charge_hourly' => $post['featured_charge_hourly'],

            'non_featured_charge_hourly' => $post['non_featured_charge_hourly'],

            'currency' => $post['currency_txt'],

			'bidwin_charge' => $post['bidwin_charge'],
			'affiliate_amount'=>$post['affiliate_amount'],
			'bonus_amount'=>$post['bonus_amount'],

			);

		$this->db->where('id', 1);

        return $this->db->update('setting', $data);

	   

		

	

	}

	

	

	

	public function update_account_maintance_Setting($post){

	

	

		$data = array(

            'maintaince_heading' => $post['maintaince_heading'],

            'maintaince_description' => $post['maintaince_description']

           	);

		$this->db->where('id', 1);

        return $this->db->update('setting', $data);

	

	

	}

	

	public function update_account_transfer_Setting($post){

		if(isset($post['withdrawl_method_paypal']))

		{

			$paypal_withdraw='Y';	

		}

		else

		{

			$paypal_withdraw='N';	

		}

		if(isset($post['withdrawl_method_wire_transfer']))

		{

			$wire_withdraw='Y';	

		}

		else

		{

			$wire_withdraw='N';	

		}

		$data = array(

            'paypal_mail' => $post['paypal_mail'],

			'paypal_mode' => $post['paypal_mode'],
			'paypal_api_uid' 				=> $post['paypal_api_uid'],

			'paypal_api_pass'				=> $post['paypal_api_pass'],

			'paypal_api_sig'				=> $post['paypal_api_sig'],

			'sandbox_api_uid'				=> $post['sandbox_api_uid'],

			'sandbox_api_pass'				=> $post['sandbox_api_pass'],

			'sandbox_api_sig'				=> $post['sandbox_api_sig'],

			'withdrawl_method_paypal' => $paypal_withdraw,

			'withdrawl_method_wire_transfer' => $wire_withdraw,

			'withdrawl_commission_paypal' =>$post['withdrawl_commission_paypal'],

			'withdrawl_commission_wire_transfer' =>$post['withdrawl_commission_wire_transfer'],

			'bank_ac' =>$post['bank_ac'],

			'bank_ac_name' =>$post['bank_ac_name'],

			'bank_name' =>$post['bank_name'],

			'bank_address' =>$post['bank_address']

			);

		$this->db->where('id', 1);
		
       	return $this->db->update('setting', $data);

		//$this->db->last_query();

		

	   

	

	

	}



	

	

	

	

	

    public function update_Setting($post) {

        $data = array(

            'site_title' => $post['site_title'],

            'meta_desc' => $post['meta_desc'],

            'meta_keys' => $post['meta_keys'],

            /*'comp_desc' => $post['comp_desc'],*/

            'admin_mail' => $post['admin_mail'],

			'favicon' => $post['favicon'],	

			'site_logo' => $post['site_logo'],

           /* 'career_mail' => $post['career_mail'],

            'support_mail' => $post['support_mail'],*/

			'facebook' => $post['facebook'],

		    'twitter' => $post['twitter'],

			'linkedin' => $post['linkedin'],

			'pinterest' => $post['pinterest'],

			'rss' => $post['rss'],

            /*'address' => $post['address'],*/

            'corporate_address' => $post['corporate_address'],

            'contact_no' => $post['contact_no'],

            /*'office_no' => $post['office_no'],*/

            /*'corporate_no' => $post['corporate_no'],*/

            /*'telephone' => $post['telephone'],*/

			'map' => htmlentities($post['map']),

            /*'customer_care_no' => $post['customer_care_no'],*/

			'my_app_id' => $post['my_app_id'],

			'my_app_secret'	=> $post['my_app_secret'],

			/*'my_app_key'=> $post['my_app_key'],*/

			'email_verify' => $post['email_verify'],

			'job_expiration' => $post['job_expiration'],

			'bad_words' => $post['bad_words'],

			'footer_text' => $post['footer_text']

			);

         

        $this->db->where('id', 1);

        return $this->db->update('setting', $data);

    }



    public function update_pass($id) {

        /*$ses_data = $this->session->userdata('user');

        $id = $ses_data->admin_id;*/

        $old_pass = md5($this->input->post('old_pass'));

        $new_pass = md5($this->input->post('new_pass'));

        // $con_pass = md5($this->input->post('con_pass'));



        $this->db->where(array("admin_id" => $id, "password" => $old_pass));

        $this->db->update("admin", array("password" => $new_pass));

        //echo $this->db->last_query();

        //die();

        return $this->db->affected_rows();

    }



    public function getAllSettingsData($id) {

        $this->db->select('*');

        $rs = $this->db->get_where('setting');

       

        $data = array();

        foreach ($rs->result() as $row) {

            $data = array( 

                'id' => $row->id,

                'site_logo' => $row->site_logo,

                'site_title' => $row->site_title,

                'meta_desc' => $row->meta_desc,

                'meta_keys' => $row->meta_keys,

                /*'comp_desc' => $row->comp_desc,*/

                'admin_mail' => $row->admin_mail,

                'career_mail' => $row->career_mail,

                'support_mail' => $row->support_mail,

                'facebook' => $row->facebook,

	            'twitter' => $row->twitter,

				'linkedin' => $row->linkedin,

				'pinterest' => $row->pinterest,

				'rss' => $row->rss,

                'address' => $row->address,

                'corporate_address' => $row->corporate_address,

                'contact_no' => $row->contact_no,

                /*'office_no' => $row->office_no,*/

                'corporate_no' => $row->corporate_no,

			    'telephone' => $row->telephone,

                'customer_care_no' => $row->customer_care_no,

                'map' => $row->map,

				'my_app_id' => $row->my_app_id,

				'my_app_secret' => $row->my_app_secret,

				'my_app_key'  => $row->my_app_key,

				'fix_featured_charge' 			=> $row->fix_featured_charge,

				'fix_non_featured_charge' 		=>$row->fix_non_featured_charge,

				'featured_charge_hourly'		=> $row->featured_charge_hourly,

				'non_featured_charge_hourly'	=> $row->non_featured_charge_hourly,

				'currency_txt'					=> $row->currency,

				'paypal_mail' 					=> $row->paypal_mail,

				'paypal_api_uid' 				=> $row->paypal_api_uid,

				'paypal_api_pass'				=> $row->paypal_api_pass,

				'paypal_api_sig'				=> $row->paypal_api_sig,

				'sandbox_api_uid'				=> $row->sandbox_api_uid,

				'sandbox_api_pass'				=> $row->sandbox_api_pass,

				'sandbox_api_sig'				=> $row->sandbox_api_sig,

				'paypal_mode'					=> $row->paypal_mode,

				'deposite_by_creaditcard_fees'  => $row->deposite_by_creaditcard_fees,

				'deposite_by_paypal_commission' => $row->deposite_by_paypal_commission,	

				'deposite_by_paypal_fees'		=> $row->deposite_by_paypal_fees,

				'withdrawl_method_paypal'		=> $row->withdrawl_method_paypal,

				'withdrawl_method_wire_transfer'=> $row->withdrawl_method_wire_transfer,	

				'withdrawl_commission_paypal'	=> $row->withdrawl_commission_paypal,

				'withdrawl_commission_wire_transfer'=> $row->withdrawl_commission_wire_transfer,

				'maintaince_heading'		=>$row->maintaince_heading,

				'maintaince_description' =>$row->maintaince_description,

				'favicon' => $row->favicon,

				'email_verify' => $row->email_verify,

				'job_expiration' => $row->job_expiration,

				'bidwin_charge' => $row->bidwin_charge,

				'bank_ac' => $row->bank_ac,

				'bank_ac_name' => $row->bank_ac_name,

				'bank_name' => $row->bank_name,

				'bank_address' => $row->bank_address,

				'escrow_charge' => $row->escrow_charge,

				'bad_words' => $row->bad_words,

				'footer_text' => $row->footer_text,
				'affiliate_amount'=>$row->affiliate_amount,
				'bonus_amount'=>$row->bonus_amount,

            );

        }



         //echo "<pre>";

          //print_r($data);die;

        return $data;

    }

	

	public function getProfile($id) {

        $this->db->select('*');

        $rs = $this->db->get_where('setting',array('id'=>'1'));

       

        $data = array();

        foreach ($rs->result() as $row) {

            $data = array( 

                'id' => $row->id,

                'basic_info' => $row->basic_info,

                'social_info' => $row->social_info,

                'portfolio_info' => $row->portfolio_info,

                'skill_info' => $row->skill_info,

                'finance_info' => $row->finance_info,

				'reference_info' => $row->reference_info

            );

        }



        return $data;

    }

	

	public function update_prof($post) {

        $data = array(

             'basic_info' => $post['basic_info'],

            'social_info' => $post['social_info'],

            'portfolio_info' => $post['portfolio_info'],

            'skill_info' => $post['skill_info'],

            'finance_info' => $post['finance_info'],

			'reference_info' => $post['reference_info']

			

			);

         

        $this->db->where('id', 1);

        return $this->db->update('setting', $data);

    }

	

	public function getHomepage($id) {

        $this->db->select('*');

        $rs = $this->db->get_where('pagesetup',array('id'=>'1'));

       

        $data = array();

        foreach ($rs->result() as $row) {

            $data = array( 

                'skills' => $row->skills,

                'testimonial' => $row->testimonial,

                'cms' => $row->cms,

                'counting' => $row->counting,

                'partner' => $row->partner,

				'newsletter' => $row->newsletter,

				'posts' => $row->posts,

				'popular_links' => $row->popular_links,

				'skill_no' =>$row->skill_no,

				'testimonial_no' =>$row->testimonial_no

				

            );

        }



        return $data;

    }

	

	public function update_home($post) {

        $data = array(

             'skills' => $post['skills'],

            'testimonial' => $post['testimonial'],

            'cms' => $post['cms'],

            'counting' => $post['counting'],

            'partner' => $post['partner'],

			'newsletter' => $post['newsletter'],

			'posts' => $post['posts'],

			'popular_links' => $post['popular_links'],

			'skill_no' => $post['skill_no'],

			'testimonial_no' => $post['testimonial_no']

			

			

			);

         

        $this->db->where('id', 1);

        return $this->db->update('pagesetup', $data);

    }

	public function getHomecms() {

        $this->db->select('*');

        $rs = $this->db->get('cms');

        $data = array();

        foreach ($rs->result() as $row) {

            $data[] = array( 

				'id' =>$row->id,

                'name' => $row->name,

                'title' => $row->title,

                'image' => $row->image,

                'desc' => $row->desc			

            );

        }



        return $data;

    }

	public function update_cms($data,$id)

	{

		$this->db->where('id',$id);

		return $this->db->update('cms',$data);	

	}

	

	public function getPopularlinks($id) {

        $this->db->select('*');

        $rs = $this->db->get_where('popular',array('id'=>'1'));

       

        $data = array();

        foreach ($rs->result() as $row) {

            $data = array( 

                'terms' => $row->terms,

                'service' => $row->service,

                'refund' => $row->refund,

                'privacy' => $row->privacy,

                'faq' => $row->faq,

				'sitemap' => $row->sitemap,

				'contact' => $row->contact,

				'facebook' => $row->facebook,

				'twitter' =>$row->twitter,

				'pinterest' =>$row->pinterest,

				'linkedin' =>$row->linkedin,

				'rss' =>$row->rss

				

            );

        }



        return $data;

    }

	

	public function update_popular($post) {

        $data = array(

            'terms' => $post['terms'],

            'service' => $post['service'],

            'refund' => $post['refund'],

            'privacy' => $post['privacy'],

            'faq' => $post['faq'],

			'sitemap' => $post['sitemap'],

			'contact' => $post['contact'],

			'facebook' => $post['facebook'],

			'twitter' => $post['twitter'],

			'pinterest' => $post['pinterest'],

			'linkedin' => $post['linkedin'],

			'rss' => $post['rss']

			

			

			);

         

        $this->db->where('id', 1);

        return $this->db->update('popular', $data);

    }



}

